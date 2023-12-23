<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\app\Http\Controllers\OrderController;

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

Route::group(['prefix'=>'/{branch?}'], function () {
    Route::get('/order/invoice/{id}', [OrderController::class, 'invoice'])->name('order.invoice');
    Route::get('/order/receipt/{id}', [OrderController::class, 'receipt'])->name('order.receipt');
    Route::resource('order', OrderController::class)->names('order');
});
