<?php

use App\Http\Controllers\SetupController;
use App\Http\Middleware\InstalledStateMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('do-setup', [SetupController::class, 'welcome'])->name('do-setup');

Route::middleware(['auth'])->group(function() {
    Route::get('/', function () {
        return view('index');
    })->name('home');
});

Auth::routes();


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
