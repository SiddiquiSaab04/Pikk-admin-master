<?php

use Illuminate\Support\Facades\Route;
use Modules\Payments\app\Http\Controllers\PaymentsController;
use Modules\Payments\app\Services\PaymentService;
use Modules\Payments\app\Services\BraintreePaymentService;
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
    Route::get('test', function() {
        // $payment = new PaymentService(new BraintreePaymentService());
        // $a = $payment->processPayment(['amount' => 10, 'cardToken' => 'g2pgab9s']);
        // dd($a);
    });
});
