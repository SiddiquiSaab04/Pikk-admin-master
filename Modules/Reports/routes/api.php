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
    Route::get('orders-count', [ReportsController::class, 'getOrdersCount']);
    Route::get('orders-revenue', [ReportsController::class, 'getTotalRevenue']);
    Route::get('orders-profit', [ReportsController::class, 'getTotalProfit']);
});
