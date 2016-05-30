<?php

/*
 * This file is part of Laravel Auth.
 *
 * Partoo@163.com
 *
 */

namespace Star\Permission\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label'];
    protected $visible = ['id','name','label'];

    /**
     * A permission can be applied to roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Find a permission by the given name.
     *
     * @param string $value
     *
     * @return Model
     */
    public static function findByName($value)
    {
        return static::where('name', '=', $value)->firstOrFail();
    }

    /**
     * Find a permission by the given label.
     *
     * @param string $value
     *
     * @return Model
     */
    public static function findByLabel($value)
    {
        return static::where('label', '=', $value)->firstOrFail();
    }
}