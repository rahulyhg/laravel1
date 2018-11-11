<?php

namespace Bytesoft\ACL\Models;

use Bytesoft\ACL\Roles\EloquentRole;

class Role extends EloquentRole
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'permissions',
        'description',
        'is_default',
        'created_by',
        'updated_by',
    ];

    /**
     * @return mixed
     * @author Bytesoft
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Bytesoft
     */
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }
}