<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Rute Login
Route::post('/login', [AuthController::class, 'login']);

// Rute User (bawaan Laravel, biarkan saja)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');