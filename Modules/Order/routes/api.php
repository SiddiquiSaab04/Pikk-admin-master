<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Order\app\Http\Controllers\OrderController;

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

// Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
//     Route::get('order', fn (Request $request) => $request->user())->name('order');
// });

Route::prefix("/{branch?}/order")->group(function() {
    Route::post('/place-order', [OrderController::class, 'store']);
    // Route::post('/place-order', [OrderController::class, 'store'])->middleware(['auth:sanctum']);
    Route::get('/get-pending-orders', [OrderController::class, 'getPendingOrders']);
    Route::get('/get-ready-orders', [OrderController::class, 'getReadyOrders']);
    Route::post('/ready-order', [OrderController::class, 'readyOrder']);
    Route::post('/cancel-order', [OrderController::class, 'cancelOrder']);
    Route::post('/serve-order', [OrderController::class, 'serveOrder']);
});

// Route::prefix("{branch?}/order")->middleware(['auth:sanctum'])->group(function() {
//     Route::post('/place-order', [OrderController::class, 'store']);
// });
