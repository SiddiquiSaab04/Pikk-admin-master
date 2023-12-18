<?php

namespace Modules\Branch\app\Interfaces;

interface BranchInterface
{
    public function createOrderTable($id);
    public function createOrderProductTable($id);
    public function createOrderProductAddonTable($id);
    public function createProductStockTable($id);
}
