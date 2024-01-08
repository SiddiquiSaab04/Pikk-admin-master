<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Customers\app\Http\Controllers\CustomersController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('customers', fn (Request $request) => $request->user())->name('customers');
});

Route::prefix('customers')->group(function () {
    Route::post('loginOrRegister', [CustomersController::class, 'loginOrRegister']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [CustomersController::class, 'logout']);
    });
});
