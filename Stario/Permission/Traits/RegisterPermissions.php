<?php

/*
 * 注册权限
 * (c) Staraw.com
 */

namespace Star\Permission\Traits;

use Star\Permission\Models\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

trait RegisterPermissions
{
    /**
     * Dynamically register permissions with Laravel's Gate.
     *
     * @param GateContract $gate
     */
    protected function registerPermissions(GateContract $gate)
    {
        foreach ($this->getPermissions() as $permission) {
            $gate->define($permission->name, function ($user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }

    /**
     * Fetch the collection of site permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
