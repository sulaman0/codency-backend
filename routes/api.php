<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([LanguageChangerMiddleware::class])->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('request-reset-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('verify-reset-password-code', [ForgotPasswordController::class, 'verifyResetPasswordCode']);


    Route::middleware('auth:sanctum')->group(function () {

        Route::prefix('ecg')->group(function () {
            Route::get('codes', [ECGCodesController::class, 'indexJson']);
        });

        Route::get('refresh-payload', [Controller::class, 'callOnHome']);
        Route::put('update-password', [Controller::class, 'updatePassword']);
    });

});


