<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Settings\app\Http\Controllers\SettingsController;

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

// superadmin routes
Route::group(
    ['middleware' => function ($request, $next) {
        if (is_null(Auth::user()->branch_id)) {
            return $next($request);
        } else {
            abort(401);
        }
    }],
    function () {
        Route::get('settings/discounts', [SettingsController::class, 'listingDiscount'])->name('discounts.index');
    }
);

// admin routers
Route::group([
    'middleware' => function ($request, $next) {
        if (($request->branch != null) && Auth::user()->branch_id == $request->branch) {
            return $next($request);
        } else {
            abort(401);
        }
    },
    'prefix' => '{branch?}'
], function () {
    Route::get('settings/discounts', [SettingsController::class, 'listingDiscount'])->name('discounts.index');
    Route::get('settings/discounts/create', [SettingsController::class, 'createDiscount'])->name('discounts.create');
    Route::post('settings/discounts', [SettingsController::class, 'updateOrCreateDiscount'])->name('discounts.store');
});


Route::group([], function () {
    Route::resource('settings', SettingsController::class)->names('settings');
});
