<?php

namespace Modules\Role\app\Providers;

use App\Interfaces\CrudInterface;
use App\Repositories\CrudRepository;
use Illuminate\Support\ServiceProvider;
use Modules\Role\app\Services\RoleService;
use Modules\Role\app\Http\Controllers\RoleController;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(RoleService::class, RoleController::class);
        $this->app->bind(CrudInterface::class, CrudRepository::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
