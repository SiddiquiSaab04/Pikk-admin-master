<?php

namespace Modules\Branch\app\Observers;

use Illuminate\Support\Facades\Log;
use Modules\Branch\app\Models\Branch;
use Modules\Branch\app\Repositories\BranchRepository;

class BranchObserver
{
    private $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    /**
     * Handle the BranchObserver "created" event.
     */
    public function created(Branch $branch): void
    {
        $this->branchRepository->createOrderTable($branch->id);
        $this->branchRepository->createOrderProductTable($branch->id);
        $this->branchRepository->createOrderProductAddonTable($branch->id);
        $this->branchRepository->createProductStockTable($branch->id);

        return;
    }

    /**
     * Handle the BranchObserver "updated" event.
     */
    public function updated(Branch $branch): void
    {
        //
    }

    /**
     * Handle the BranchObserver "deleted" event.
     */
    public function deleted(Branch $branch): void
    {
        //
    }

    /**
     * Handle the BranchObserver "restored" event.
     */
    public function restored(Branch $branch): void
    {
        //
    }

    /**
     * Handle the BranchObserver "force deleted" event.
     */
    public function forceDeleted(Branch $branch): void
    {
        //
    }
}
