<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Inventory\app\Http\Controllers\CategoryController;
use Modules\Inventory\app\Http\Controllers\ProductController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

// Route::prefix('v1')->name('api.')->group(function () {
//     Route::get('/product/index', [ProductController::class, 'index']);
// });

Route::prefix('')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('product/index', [ProductController::class, 'index']);
        Route::get('category/index', [CategoryController::class, 'index']);
    });
});