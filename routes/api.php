<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ECGAlertsController;
use App\Http\Controllers\ECGCodesController;
use App\Http\Middleware\LanguageChangerMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware([LanguageChangerMiddleware::class])->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('request-reset-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('verify-reset-password-code', [ForgotPasswordController::class, 'verifyResetPasswordCode']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('ecg')->group(function () {
            Route::resource('codes', ECGCodesController::class);
            Route::resource('alerts', ECGAlertsController::class);
        });
        Route::get('ecg-codes-list', [ECGCodesController::class, 'ecgCodesListForSearch']);
        Route::get('users-list', [Controller::class, 'usersList']);
        Route::get('refresh-payload', [Controller::class, 'callOnHome']);
        Route::put('update-password', [Controller::class, 'updatePassword']);
        Route::post("broadcasting/auth", [Controller::class, 'authorizePusherChannel']);
    });
    Route::middleware('amplifier.middleware')->group(function () {
        Route::get('un-played-alert', [ECGAlertsController::class, 'getUnPlayedAlarm']);
    });

});


