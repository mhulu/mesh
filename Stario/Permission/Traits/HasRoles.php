<?php

/*
 * 获取用户的角色
 * (c) Staraw.com
 */

namespace Star\Permission\Traits;

use Star\Permission\Models\Permission;
use Star\Permission\Models\Role;

trait HasRoles
{
    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign the given role to the user.
     *
     * @param Role|string $role
     *
     * @return mixed
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::findByName($role);
        }

        if ($this->hasRole($role->name)) {
            return $role;
        }

        return $this->roles()->save($role);
    }

    /**
     * Determine if the user has the given role.
     *
     * @param mixed $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param Permission|string $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::findByName($permission);
        }

        return $this->hasRole($permission->roles);

    }
}
