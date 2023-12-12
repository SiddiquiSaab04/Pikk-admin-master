<?php

namespace Modules\Role\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;

class RoleService
{
    use Crud;

    protected $crudRepository;
    protected $model;

    public function __construct(CrudRepository $crudRepository)
    {
        $this->model = "\\Modules\\Role\\app\\Models\\Role";
        $this->crudRepository = $crudRepository;
    }
}
