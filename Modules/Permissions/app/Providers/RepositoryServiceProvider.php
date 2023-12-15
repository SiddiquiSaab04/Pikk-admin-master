<?php

namespace Modules\Permissions\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Permissions\app\Http\Controllers\PermissionsController;
use Modules\Permissions\app\Services\PermissionsService;
use Modules\Role\app\Services\RoleService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(PermissionsController::class, PermissionsService::class);
        $this->app->bind(RoleService::class, PermissionsController::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
