<?php

namespace Bytesoft\ACL\Services;

use Bytesoft\ACL\Events\RoleAssignmentEvent;
use Bytesoft\ACL\Models\User;
use Bytesoft\ACL\Repositories\Interfaces\RoleInterface;
use Bytesoft\ACL\Repositories\Interfaces\RoleUserInterface;
use Bytesoft\ACL\Repositories\Interfaces\UserInterface;
use Bytesoft\Support\Services\ProduceServiceInterface;
use Illuminate\Http\Request;

class CreateUserService implements ProduceServiceInterface
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @var RoleUserInterface
     */
    protected $roleUserRepository;

    /**
     * CreateUserService constructor.
     * @param UserInterface $userRepository
     * @param RoleInterface $roleRepository
     * @param RoleUserInterface $roleUserRepository
     */
    public function __construct(
        UserInterface $userRepository,
        RoleInterface $roleRepository,
        RoleUserInterface $roleUserRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->roleUserRepository = $roleUserRepository;
    }

    /**
     * @param Request $request
     * @author Bytesoft
     * @return User|false|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function execute(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->userRepository->createOrUpdate(array_merge($request->input(), [
            'profile_image' => config('core.acl.general.avatar.default'),
        ]));

        if ($request->has('username') && $request->has('password')) {
            $this->userRepository->update(['id' => $user->id], [
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
            ]);

            if (acl_activate_user($user) && $request->has('role_id')) {
                $role = $this->roleRepository->getFirstBy([
                    'id' => $request->input('role_id'),
                ]);

                if (!empty($role)) {
                    $this->roleUserRepository->firstOrCreate([
                        'user_id' => $user->id,
                        'role_id' => $request->input('role_id'),
                    ]);

                    event(new RoleAssignmentEvent($role, $user));
                }
            }
        }

        return $user;
    }
}