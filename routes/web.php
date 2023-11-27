<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ECGCodesController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StaffController;
use App\Http\Middleware\LanguageChangerMiddleware;
use Illuminate\Support\Facades\Auth;
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

// Authentication Routes
Auth::routes();

Route::middleware([LanguageChangerMiddleware::class, 'auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'sign_in'])->name('sign_in');
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    });
    Route::resource('staff', StaffController::class);
    Route::resource('ecg-codes', ECGCodesController::class);
    Route::resource('locations', LocationController::class);
    Route::prefix('reports')->group(function () {
        Route::get('/code-pressed', [ReportsController::class, 'index'])->name('reports.code_pressed');
    });
    Route::get('privacy-policy', [Controller::class, 'privacy_policy'])->name('privacy_policy');
});
