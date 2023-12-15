<?php

namespace Modules\User\app\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function updateRole(string $name, User $model);
}
