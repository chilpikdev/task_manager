<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tasks\EmployeeTaskController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '\d+');
Route::pattern('hash', '[a-z0-9]+');
Route::pattern('hex', '[a-f0-9]+');
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
Route::pattern('base', '[a-zA-Z0-9]+');
Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('username', '[a-z0-9_-]{3,16}');

/**
 * Public Routes
 */

/**
 * For Guest
 */
Route::middleware('guest:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });
});

/**
 * For Authorized
 */
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('me', [AuthController::class, 'getMe'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    /**
     * Routes for Verifieds & Actives Users
     */
    Route::middleware(['user.active'])->group(function () {
        Route::prefix('employee')->group(function () {
            Route::prefix('tasks')->group(function () {
                Route::get('/', [EmployeeTaskController::class, 'index'])->name('employee.tasks.index');
                Route::get('show/{id}', [EmployeeTaskController::class, 'show'])->name('employee.tasks.show');
            });
        });

    });
});
