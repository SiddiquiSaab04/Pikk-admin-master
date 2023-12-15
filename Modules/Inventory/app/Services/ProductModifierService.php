<?php

namespace Modules\Inventory\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;

class ProductModifierService
{
    use Crud;

    private $crudRepository;
    private $model;

    public function __construct(CrudRepository $crudRepository)
    {
        $this->crudRepository = $crudRepository;
        $this->model = "\\Modules\\Inventory\\app\\Models\\ProductModifier";
    }
}
