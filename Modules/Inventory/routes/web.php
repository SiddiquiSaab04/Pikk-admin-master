<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\app\Http\Controllers\CategoryController;
use Modules\Inventory\app\Http\Controllers\ProductController;
use Modules\Inventory\app\Http\Controllers\AddonGroupController;

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

Route::group([], function () {
    Route::resource('category', CategoryController::class)->names('category');
    Route::resource('product', ProductController::class)->names('product');
    Route::resource('addon-groups', AddonGroupController::class)->names('addonGroup');
});
