<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Settings\app\Http\Controllers\SettingsController;

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
    Route::get('settings', fn (Request $request) => $request->user())->name('settings');
});

Route::middleware(['auth:sanctum'])->prefix('/{branch?}/settings/')->group(function () {
    Route::get('get-pos-configuration', [SettingsController::class, 'getPosConfiguration']);
    Route::post('store-pos-configuration', [SettingsController::class, 'storePosConfiguration']);
});
