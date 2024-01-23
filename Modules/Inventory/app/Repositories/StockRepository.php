<?php

namespace Modules\Inventory\app\Repositories;

use Modules\Inventory\app\Interfaces\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
  protected $query;

  public function initTable($model, $table = null)
  {
    $this->query = new $model;
    $this->query->setTableName($table);
    return $this;
  }

  public function updateOrCreate($clause, $data)
  {
    return $this->query->updateOrCreate($clause, $data);
  }
}
