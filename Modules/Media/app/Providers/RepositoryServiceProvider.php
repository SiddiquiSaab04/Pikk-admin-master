<?php

namespace Modules\Media\app\Providers;

use App\Repositories\CrudRepository;
use Illuminate\Support\ServiceProvider;
use Modules\Media\app\Http\Controllers\MediaController;
use Modules\Media\app\Interfaces\MediaRepositoryInterface;
use Modules\Media\app\Repositories\MediaRepository;
use Modules\Media\app\Services\MediaService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(MediaService::class, MediaController::class);
        $this->app->bind(MediaRepository::class, MediaService::class);
        $this->app->bind(CrudRepository::class, MediaService::class);
        $this->app->bind(MediaRepositoryInterface::class, MediaRepository::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
