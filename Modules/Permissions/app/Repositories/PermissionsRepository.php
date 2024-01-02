<?php

namespace Modules\Permissions\app\Repositories;

use Modules\Permissions\app\Interfaces\PermissionsRepositoryInterface;
use Spatie\Permission\Models\Role;

class PermissionsRepository implements PermissionsRepositoryInterface
{
    public function updateRole($name, $model)
    {
        $role = Role::whereIn('name', $name)->get();
        if ($model->getRoleNames()->first()) {
            $model->syncRoles([]);
        }
        return $model->syncRoles($role);
    }
}
