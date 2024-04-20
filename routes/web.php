<?php

use App\AppHelper\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ECGCodesController;
use App\Http\Controllers\GroupController;
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
    Route::get('staff-assigned-location/{userId}', [StaffController::class, 'locationAssign'])->name('user_location_assigned_table');
    Route::get('ecg-staff', [StaffController::class, 'tableRecord'])->name('staff_table');
    Route::resource('groups', GroupController::class);
    Route::get('ecg-group', [GroupController::class, 'tableRecord'])->name('group_table');

    Route::resource('ecg-codes', ECGCodesController::class);
    Route::get('code-sender-table/{id}', [ECGCodesController::class, 'senderTableList'])->name('ecg_code_sender_table');
    Route::get('code-receiver-table/{id}', [ECGCodesController::class, 'receiverTableList'])->name('ecg_code_receiver_table');
    Route::get('code-pressed-table/{userId}', [StaffController::class, 'codeInteraction'])->name('ecg_code_interaction_table');
    Route::post('ecg-codes/{id}', [ECGCodesController::class, 'updateEcgCode'])->name('update_ecg_code');
    Route::get('ecg-table-codes', [ECGCodesController::class, 'tableRecord'])->name('ecg_codes_table');
    Route::resource('locations', LocationController::class);
    Route::get('ecg-locations', [LocationController::class, 'tableRecord'])->name('location_table');
    Route::post('ecg-locations-update', [LocationController::class, 'update'])->name('update_location');
    Route::get('loc-floor-room', [LocationController::class, 'floorOrRooms'])->name('room_floor_on_based_of_loc');
    Route::prefix('reports')->group(function () {
        Route::get('/code-pressed', [ReportsController::class, 'index'])->name('reports.code_pressed');
        Route::any('/ecg-alert-pressed', [ReportsController::class, 'tableRecord'])->name('reports.code_pressed_table');
        Route::get('/amplifier-status', [ReportsController::class, 'amplifierStatus'])
            ->name('reports.amplifier_status');
        Route::get('/amplifier-json-status', [ReportsController::class, 'amplifierStatusTableRecord'])
            ->name('reports.amplifier_status_json');
    });
    Route::get('privacy-policy', [Controller::class, 'privacy_policy'])->name('privacy_policy');
    Route::get('delete_model', [Controller::class, 'deleteModel'])->name('delete_model');
    Route::get('load-dashboard-content', [Controller::class, 'loadDashboardContent'])->name('load_dashboard_content');
    Route::any('store-token', [Controller::class, 'saveFcmToken'])->name('store.token');
});
Route::get('test', [Controller::class, 'testFunction']);
