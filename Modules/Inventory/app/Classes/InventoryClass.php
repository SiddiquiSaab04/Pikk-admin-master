<?php

namespace Modules\Inventory\app\Classes;

use App\Repositories\CrudRepository;
use App\Traits\Crud;

class InventoryClass
{
    use Crud;

    public function whereBranch()
    {
        return $this->model::when($this->branch != null , function($query) {
            $query->doesntHave('branches');
            $query->orWhereHas('branches', function($q) {
                $q->where('branch_id', $this->branch);
            });
        })->orderByDesc('created_at')->paginate(20);
    }
}
