<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Comments\CommentController;
use App\Http\Controllers\Tasks\ChiefTaskController;
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
        Route::prefix('employee')->middleware('role:employee')->group(function () {
            Route::prefix('tasks')->group(function () {
                Route::get('/', [EmployeeTaskController::class, 'index'])->name('employee.tasks.index');
                Route::post('accept', [EmployeeTaskController::class, 'accept'])->name('employee.tasks.accept');
                Route::post('close', [EmployeeTaskController::class, 'close'])->name('employee.tasks.close');
                Route::post('extend', [EmployeeTaskController::class, 'extend'])->name('employee.tasks.extend');
            });
        });

        Route::prefix('chief')->middleware('role:chief')->group(function () {
            Route::prefix('tasks')->group(function () {
                Route::get('/', [ChiefTaskController::class, 'index'])->name('chief.tasks.index');
                Route::post('create', [ChiefTaskController::class, 'create'])->name('chief.tasks.create');
                Route::get('show/{id}', [ChiefTaskController::class, 'show'])->name('chief.tasks.show');
                Route::match(['put', 'patch'], 'udpate', [ChiefTaskController::class, 'update'])->name('chief.tasks.update');
                // Route::post('accept', [EmployeeTaskController::class, 'accept'])->name('chief.tasks.accept');
                // Route::post('close', [EmployeeTaskController::class, 'close'])->name('chief.tasks.close');
                // Route::post('extend', [EmployeeTaskController::class, 'extend'])->name('chief.tasks.extend');
            });
        });

        Route::prefix('comments')->group(function () {
            Route::get('/', [CommentController::class, 'index'])->name('comments.index');
        });
    });
});
