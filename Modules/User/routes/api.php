<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\app\Http\Controllers\UserController;

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
    Route::get('user', fn (Request $request) => $request->user())->name('user');
});

Route::prefix('auth')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('getUserById/{userId}', [UserController::class, 'getUserById']);
    });
});