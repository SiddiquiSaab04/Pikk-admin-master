<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Reports\app\Http\Controllers\ReportsController;

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
//     Route::get('reports', fn (Request $request) => $request->user())->name('reports');
// });

Route::prefix("/{branch}/reports")->group(function() {
    Route::post('orders-count', [ReportsController::class, 'getOrdersCount']);
    Route::post('orders-revenue', [ReportsController::class, 'getTotalRevenue']);
    Route::post('orders-profit', [ReportsController::class, 'getTotalProfit']);
    Route::post('orders-by-date', [ReportsController::class, 'getOrdersByDate']);
    Route::post('orders-by-platform', [ReportsController::class, 'getOrdersByPlatform']);
});
