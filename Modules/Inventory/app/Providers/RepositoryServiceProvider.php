<?php

namespace Modules\Inventory\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Inventory\app\Services\CategoryService;
use Modules\Inventory\app\Http\Controllers\CategoryController;
use Modules\Inventory\app\Http\Controllers\ProductController;
use Modules\Inventory\app\Http\Controllers\AddonGroupController;
use Modules\Inventory\app\Http\Controllers\ProductModifierController;
use Modules\Inventory\app\Http\Controllers\ProductModifiersAddonController;
use Modules\Inventory\app\Interfaces\AddonGroupRepositoryInterface;
use Modules\Inventory\app\Interfaces\CategoryRepositoryInterface;
use Modules\Inventory\app\Interfaces\ProductModifierRepositoryInterface;
use Modules\Inventory\app\Interfaces\ProductRepositoryInterface;
use Modules\Inventory\app\Repositories\AddonGroupRepository;
use Modules\Inventory\app\Repositories\CategoryRepository;
use Modules\Inventory\app\Repositories\ProductModifierRepository;
use Modules\Inventory\app\Repositories\ProductModifiersAddonsRepository;
use Modules\Inventory\app\Repositories\ProductRepository;
use Modules\Inventory\app\Services\AddonGroupService;
use Modules\Inventory\app\Services\ProductModifiersAddonService;
use Modules\Inventory\app\Services\ProductModifierService;
use Modules\Inventory\app\Services\ProductService;
use App\Interfaces\CrudInterface;
use App\Repositories\CrudRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        /**
         * Category Injections
         */
        $this->app->bind(CategoryService::class, CategoryController::class);
        $this->app->bind(CategoryRepository::class, CategoryService::class);
        $this->app->bind(CrudInterface::class, CrudRepository::class);

        /**
         * Addons Groups Injections
         */
        $this->app->bind(AddonGroupService::class, AddonGroupController::class);
        $this->app->bind(AddonGroupRepository::class, AddonGroupService::class);
        $this->app->bind(AddonGroupRepositoryInterface::class, AddonGroupRepository::class);

        /**
         * Products Injections
         */
        $this->app->bind(ProductService::class, ProductController::class);
        $this->app->bind(ProductRepository::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        /**
         * Product Injections
         */
        $this->app->bind(ProductService::class, ProductController::class);
        $this->app->bind(ProductRepository::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        /**
         * Product Modifiers Injections
         */
        $this->app->bind(ProductModifierService::class, ProductModifierController::class);
        $this->app->bind(ProductModifierRepository::class, ProductModifierService::class);
        $this->app->bind(ProductModifierRepositoryInterface::class, ProductModifierRepository::class);

        /**
         * Product Modifiers Addons Injections
         */
        $this->app->bind(ProductModifiersAddonService::class, ProductModifiersAddonController::class);
        $this->app->bind(ProductModifiersAddonsRepository::class, ProductModifiersAddonService::class);
        $this->app->bind(ProductModifierRepositoryInterface::class, ProductModifiersAddonsRepository::class);


    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
