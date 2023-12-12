<?php

namespace Modules\User\app\Repositories;

use Spatie\Permission\Models\Role;
use Modules\User\app\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getRole($name)
    {
        return Role::where('name', $name)->first();
    }

    public function assignUserRole($user, $role)
    {
        return $user->assignRole($role);
    }
}
