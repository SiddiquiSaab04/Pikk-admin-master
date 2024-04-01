<?php

namespace Modules\Inventory\app\Interfaces;

interface StockRepositoryInterface
{
    public function updateOrCreate($clause, $data);
    public function getWhereFirst($clause);
}
