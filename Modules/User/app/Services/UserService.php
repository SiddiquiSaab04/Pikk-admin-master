<?php

namespace Modules\User\app\Services;

use App\Repositories\CrudRepository;
use Modules\User\app\Repositories\UserRepository;
use App\Traits\Crud;
use Modules\Role\app\Services\RoleService;

class UserService
{
    use Crud;

    protected $crudRepository;
    private $userRepository;
    private $roleService;
    protected $model;

    public function __construct(CrudRepository $crudRepository, UserRepository $userRepository, RoleService $roleService)
    {
        $this->model = "\\App\\Models\\User";
        $this->crudRepository = $crudRepository;
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
    }

    public function getAllRoles()
    {
        return $this->roleService->getAll();
    }

    public function updateRole($name, $user)
    {
        return $this->userRepository->updateRole($name, $user);
    }
}
