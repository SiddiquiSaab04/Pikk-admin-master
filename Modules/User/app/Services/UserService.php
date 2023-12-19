<?php

namespace Modules\User\app\Services;

use App\Repositories\CrudRepository;
use Modules\User\app\Repositories\UserRepository;
use App\Traits\Crud;
use Illuminate\Support\Facades\Auth;
use Modules\Branch\app\Services\BranchService;
use Modules\Role\app\Services\RoleService;

class UserService
{
    use Crud;

    protected $crudRepository;
    private $userRepository;
    private $roleService;
    private $branchService;
    protected $model;

    public function __construct(CrudRepository $crudRepository, UserRepository $userRepository, RoleService $roleService, BranchService $branchService)
    {
        $this->model = "\\App\\Models\\User";
        $this->crudRepository = $crudRepository;
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
        $this->branchService = $branchService;
    }

    public function getAllRoles()
    {
        return $this->roleService->getAll();
    }

    public function getAllBranches()
    {
        return $this->branchService->getAll();
    }

    public function updateRole($name, $user)
    {
        return $this->userRepository->updateRole($name, $user);
    }

    public function getUsers()
    {
        return Auth::user()->getRoleNames()->first() == 'admin' ? $this->getWhere(['branch_id' => Auth::user()->branch_id ]) : $this->getAll(); 
    }
}
