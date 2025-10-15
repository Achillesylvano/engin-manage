<?php

use App\Http\Controllers\CreateMaintenanceFromAutomatiqueController;
use App\Http\Controllers\DailyUsageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnginController;
use App\Http\Controllers\MaintenanceAutomatiqueController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::resource('engins', EnginController::class);
    Route::resource('users', UserController::class);

    Route::resource('maintenances', MaintenanceController::class);
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::resource('daily-usages', DailyUsageController::class);

    Route::resource('maintenance-automatiques', MaintenanceAutomatiqueController::class)->except('create');
    Route::get('maintenance-automatiques/create/{engin}', [MaintenanceAutomatiqueController::class, 'create'])
        ->name('maintenance-automatiques.create');
    Route::get('maintenances/auto/create/{alertMaintenance}', CreateMaintenanceFromAutomatiqueController::class)
        ->name('maintenances.auto.create');

});
Route::get('engins/{engin}/pdf', [EnginController::class, 'generatePdf'])->name('engins.pdf');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
