<?php

namespace Modules\Permissions\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Modules\Role\app\Services\RoleService;
use Modules\User\app\Services\UserService;

class PermissionsService
{
    use Crud;

    protected $crudRepository;
    protected $roleService;
    protected $userService;
    protected $model;

    public function __construct(CrudRepository $crudRepository, RoleService $roleService, UserService $userService)
    {
        $this->crudRepository = $crudRepository;
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->model = "\\Modules\\Permissions\\app\\Models\\Permission";
    }

    public function getAllRole()
    {
        return $this->roleService->getAll();
    }

    public function getRole($user, $name)
    {
        return $this->userService->getRole($user, $name);
    }

    public function getUserById($id)
    {
        return $this->userService->getById($id);
    }
}
