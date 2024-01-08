<?php

namespace Modules\Customers\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;

class CustomersCashbackService
{
  use Crud;

  private $crudRepository;
  private $model;

  public function __construct(CrudRepository $crudRepository)
  {
    $this->crudRepository = $crudRepository;
    $this->model = "\\Modules\\Customers\\app\\Models\\CustomerCashback";
  }
}
