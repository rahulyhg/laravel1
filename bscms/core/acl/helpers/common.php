<?php

use Bytesoft\ACL\Models\UserMeta;
use Bytesoft\ACL\Activations\EloquentActivation;

if (!function_exists('acl_activate_user')) {
    /**
     * @param \Bytesoft\ACL\Models\User $user
     * @return bool
     * @author Bytesoft
     */
    function acl_activate_user($user)
    {
        /**
         * @var EloquentActivation $activation
         */
        $activation = AclManager::getActivationRepository()->create($user);
        if (AclManager::getActivationRepository()->complete($user, $activation->code)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('acl_deactivate_user')) {
    /**
     * @param \Bytesoft\ACL\Models\User $user
     * @return bool
     * @author Bytesoft
     */
    function acl_deactivate_user($user)
    {
        return AclManager::getActivationRepository()->remove($user);
    }
}

if (!function_exists('acl_is_user_activated')) {
    /**
     * @param \Bytesoft\ACL\Models\User $user
     * @return bool
     * @author Bytesoft
     */
    function acl_is_user_activated($user)
    {
        return AclManager::getActivationRepository()->completed($user);
    }
}

if (!function_exists('render_login_form')) {
    /**
     * @return string
     * @author Bytesoft
     * @throws Throwable
     */
    function render_login_form()
    {
        return view('core.acl::partials.login-form')->render();
    }
}

if (!function_exists('get_user_meta')) {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     * @author Bytesoft
     */
    function get_user_meta($key, $default = null)
    {
        return UserMeta::getMeta($key, $default);
    }
}

if (!function_exists('set_user_meta')) {
    /**
     * @param $key
     * @param null $value
     * @param int $user_id
     * @return mixed
     * @internal param null $default
     * @author Bytesoft
     */
    function set_user_meta($key, $value = null, $user_id = 0)
    {
        return UserMeta::setMeta($key, $value, $user_id);
    }
}
