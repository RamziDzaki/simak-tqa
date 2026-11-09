<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;

// Rute Login
Route::post('/login', [AuthController::class, 'login']);

// Rute yang butuh login (pakai token)
Route::middleware('auth:sanctum')->group(function () {
    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Rute User (bawaan Laravel)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});