<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController; // <-- TAMBAHKAN INI

// Rute Login
Route::post('/login', [AuthController::class, 'login']);

// Rute yang butuh login (pakai token)
Route::middleware('auth:sanctum')->group(function () {
    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // RUTE KELOLA USER (TAMBAHAN BARU)
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Rute User (bawaan Laravel)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});