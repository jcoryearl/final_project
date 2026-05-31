<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('equipment', EquipmentController::class);
Route::resource('maintenance', MaintenanceController::class);
Route::resource('users', UserController::class);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/equipment', [ReportController::class, 'equipmentReport'])->name('reports.equipment');
Route::get('/reports/maintenance', [ReportController::class, 'maintenanceReport'])->name('reports.maintenance');