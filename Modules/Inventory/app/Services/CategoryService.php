<?php

namespace Modules\Inventory\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;

class CategoryService
{
    use Crud;

    protected $crudRepository;
    protected $model;

    public function __construct(CrudRepository $crudRepository)
    {
        $this->model = "\\Modules\\Inventory\\app\\Models\\Category";
        $this->crudRepository = $crudRepository;
    }
}
