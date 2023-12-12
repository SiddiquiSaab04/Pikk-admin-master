<?php

namespace Modules\User\app\Interfaces;

use App\Models\User;
use Spatie\Permission\Models\Role;

interface UserRepositoryInterface
{
    public function getRole(string $name);
    public function assignUserRole(User $user, Role $role);
}