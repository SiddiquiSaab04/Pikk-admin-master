<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\SetupController;
use App\Interfaces\SetupInterface;
use App\Repositories\SetupRepository;
use App\Services\SetupService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SetupService::class, SetupController::class);
        $this->app->bind(SetupRepository::class, SetupService::class);
        $this->app->bind(SetupInterface::class, SetupRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
