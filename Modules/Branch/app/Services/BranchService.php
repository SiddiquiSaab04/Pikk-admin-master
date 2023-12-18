<?php

namespace Modules\Branch\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;

class BranchService
{
    use Crud;

    private $crudRepository;
    private $model;

    public function __construct(CrudRepository $crudRepository)
    {
        $this->crudRepository = $crudRepository;
        $this->model = "\\Modules\\Branch\\app\\Models\\Branch";
    }

}
