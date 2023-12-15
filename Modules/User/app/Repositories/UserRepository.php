<?php

namespace Modules\User\app\Repositories;

use Spatie\Permission\Models\Role;
use Modules\User\app\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function updateRole($name, $model)
    {
        $role = Role::where('name', $name)->first();
        if ($model->getRoleNames()->first()) {
            $model->syncRoles([]);
        }
        return $model->assignRole($role);
    }
}
