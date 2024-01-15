<?php

namespace App\Providers;


use App\Services\CoreService;
use App\Singletons\BranchSingleton;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CoreService::class, function(){
            return new CoreService();
        });

        $this->app->singleton('branches', function() {
            $branches = new BranchSingleton();
            $branches = $branches->branches();
            return $branches;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
    }
}
