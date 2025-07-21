<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ModelTypeController;
use App\Http\Controllers\UserManagementController;

Route::middleware('auth')->group(function(){
    Route::middleware(['auth'])->resource('users', UserManagementController::class);
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('inventory', InventoryController::class);
    Route::resource('model-types', ModelTypeController::class);
    Route::resource('owners', \App\Http\Controllers\OwnerController::class);
    Route::resource('warehouses', \App\Http\Controllers\WarehouseController::class);
});

require __DIR__.'/auth.php';
