<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Media\app\Http\Controllers\MediaController;

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
//     Route::get('media', fn (Request $request) => $request->user())->name('media');
// });

Route::prefix('media')->group(function () {
    Route::get('index', [MediaController::class, 'index']);
});
