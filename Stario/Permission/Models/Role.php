<?php

/*
 * This file is part of Laravel Auth.
 *
 * Partoo@163.com
 *
 */

namespace Star\Permission\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label'];
    protected $visible = ['id','name','label'];

    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Grant the given permission to a role.
     *
     * @param Permission|string $permission
     *
     * @return mixed
     */
    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::findByLabel($permission);
        }

        if ($this->hasPermission($permission)) {
            return $permission;
        }

        return $this->permissions()->save($permission);
    }

    /**
     * Determine if the role may perform the given permission.
     *
     * @param Permission|string $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::findByLabel($permission);
        }

        return $this->permissions->contains('name', $permission->name);
    }

    /**
     * Find a role by the given name.
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
     * Find a role by the given label.
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