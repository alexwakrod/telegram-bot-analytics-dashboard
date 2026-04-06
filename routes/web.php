<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return inertia('Auth/Login');
})->name('login');

// Protected routes (must be logged in and admin)
Route::middleware(['auth', 'admin'])->group(function () {
    // Inertia pages
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', fn() => inertia('Analytics'))->name('analytics');
    Route::get('/moderation', fn() => inertia('Moderation'))->name('moderation');
    Route::get('/reminders', fn() => inertia('Reminders'))->name('reminders');

    // API endpoints with /api prefix
    Route::prefix('api')->group(function () {
        Route::get('/heatmap', [AnalyticsController::class, 'heatmap']);
        Route::get('/hourly-stats', [AnalyticsController::class, 'hourlyStats']);
        Route::get('/top-users', [AnalyticsController::class, 'topUsers']);

        Route::apiResource('moderation-rules', ModerationController::class);
        Route::get('/reminders', [ReminderController::class, 'index']);
        Route::delete('/reminders/{id}', [ReminderController::class, 'destroy']);
    });
});

// Auth routes (Breeze)
require __DIR__.'/auth.php';