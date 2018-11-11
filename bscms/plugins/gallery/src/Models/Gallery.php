<?php

namespace Bytesoft\Gallery\Models;

use Bytesoft\ACL\Models\User;
use Bytesoft\Slug\Traits\SlugTrait;
use Eloquent;

class Gallery extends Eloquent
{
    use SlugTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'galleries';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'featured',
        'order',
        'image',
        'status',
    ];

    /**
     * @var string
     */
    protected $screen = GALLERY_MODULE_SCREEN_NAME;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Bytesoft
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
