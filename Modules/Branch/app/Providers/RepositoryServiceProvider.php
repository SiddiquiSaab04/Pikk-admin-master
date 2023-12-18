<?php

namespace Modules\Branch\app\Providers;

use App\Repositories\CrudRepository;
use Illuminate\Support\ServiceProvider;
use Modules\Branch\app\Http\Controllers\BranchController;
use Modules\Branch\app\Services\BranchService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(BranchService::class, BranchController::class);
        $this->app->bind(CrudRepository::class, BranchService::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
