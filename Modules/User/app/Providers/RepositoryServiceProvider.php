<?php

namespace Modules\User\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\app\Interfaces\UserRepositoryInterface;
use Modules\User\app\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
