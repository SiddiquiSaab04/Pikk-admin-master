<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Inventory\app\Http\Controllers\CategoryController;
use Modules\Inventory\app\Http\Controllers\ProductController;
use Modules\Inventory\app\Http\Controllers\AddonGroupController;
use Modules\Inventory\app\Http\Controllers\ProductStockController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// superadmin routes
Route::group(
    ['middleware' => function ($request, $next) {
        if (is_null(Auth::user()->branch_id)) {
            return $next($request);
        } else {
            abort(401);
        }
    }],
    function () {
        Route::resource('category', CategoryController::class)->names('category');
        Route::resource('product', ProductController::class)->names('product');
        Route::resource('addon-groups', AddonGroupController::class)->names('addonGroup');
    }
);

// admin routers
Route::group([
    'middleware' => function ($request, $next) {
        if (($request->branch != null) && Auth::user()->branch_id == $request->branch) {
            return $next($request);
        } else {
            abort(401);
        }
    },
    'prefix' => '{branch?}'
], function () {
    Route::resource('category', CategoryController::class)->names('category');
    Route::resource('product', ProductController::class)->names('product');
    Route::resource('addon-groups', AddonGroupController::class)->names('addonGroup');
    Route::get('stock/index', [ProductStockController::class, 'index'])->name('stock.index');
    Route::post('manage-stock', [ProductStockController::class, 'manageStock'])->name('stock.manage');
});
