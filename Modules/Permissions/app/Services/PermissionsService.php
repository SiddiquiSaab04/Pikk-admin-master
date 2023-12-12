<?php

namespace Modules\Permissions\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Modules\Permissions\app\Repositories\PermissionsRepository;
use Modules\Role\app\Services\RoleService;

class PermissionsService
{
    use Crud;

    protected $crudRepository;
    protected $roleService;
    protected $permissionsRepository;
    protected $model;

    public function __construct(CrudRepository $crudRepository, PermissionsRepository $permissionsRepository, RoleService $roleService)
    {
        $this->crudRepository = $crudRepository;
        $this->roleService = $roleService;
        $this->permissionsRepository = $permissionsRepository;
        $this->model = "\\Modules\\Permissions\\app\\Models\\Permission";
    }

    public function getAllRoles()
    {
        return $this->roleService->getAll();
    }

    public function updateRole($name, $permission)
    {
        return $this->permissionsRepository->updateRole($name, $permission);
    }
}
