<?php

namespace Modules\User\app\Services;

use App\Repositories\CrudRepository;
use Modules\User\app\Repositories\UserRepository;
use App\Traits\Crud;

class UserService
{
    use Crud;

    protected $crudRepository;
    private $userRepository;
    protected $model;

    public function __construct(CrudRepository $crudRepository, UserRepository $userRepository)
    {
        $this->model = "\\App\\Models\\User";
        $this->crudRepository = $crudRepository;
        $this->userRepository = $userRepository;
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
