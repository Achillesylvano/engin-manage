<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DailyUsage\DailyUsageController;
use App\Http\Controllers\Api\DailyUsageEncours\DailyUsageController as DailyUsageEncoursController;
use App\Http\Controllers\Api\Engin\EnginDisponibleController;
use App\Http\Controllers\Api\Engin\EnginSortieController;
use App\Http\Controllers\Api\Maintenance\MaintenanceController;
use App\Http\Controllers\Api\User\OperateurController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'store']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', fn(Request $request): \App\Http\Resources\UserResource => new UserResource($request->user()));

    Route::apiResource('/daily-usages', DailyUsageController::class);

    Route::get('/engin-disponibles', EnginDisponibleController::class);

    Route::get('/operateur', OperateurController::class);

    Route::get('/engin-sortie', EnginSortieController::class);

    Route::get('/daily-usages-encours', DailyUsageEncoursController::class);
    Route::get('/maintenances',MaintenanceController::class);
});
