<?php

namespace Modules\Permissions\app\Interfaces;

use Modules\Permissions\app\Models\Permission;

interface PermissionsRepositoryInterface
{
    public function updateRole(string $name, Permission $model);
}
