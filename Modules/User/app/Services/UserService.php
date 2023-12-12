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

    public function getAllRole()
    {
        return $this->roleService->getAll(); 
    }

    public function getRole($user, $name)
    {
        $role = $this->userRepository->getRole($name);
        return $this->assignUserRole($user, $role);
    }

    public function assignUserRole($user, $role)
    {
        return $this->userRepository->assignUserRole($user, $role);
    }
}
