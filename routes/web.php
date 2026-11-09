<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MataPelajaranController; // <-- TAMBAHKAN INI

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// RUTE DASHBOARD
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', [
        'totalSantri' => \App\Models\Santri::count(),
        'totalGuru' => \App\Models\User::where('role', 'guru')->count(),
        'totalKelas' => \App\Models\Kelas::count(),
        'totalMapel' => \App\Models\MataPelajaran::count(),
    ]);
})->middleware('auth');

// RUTE KELOLA USER
Route::get('/admin/user', [UserController::class, 'index'])->middleware('auth');
Route::post('/admin/user', [UserController::class, 'store'])->middleware('auth');
Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->middleware('auth');

// RUTE MATA PELAJARAN (TAMBAHAN BARU)
Route::get('/admin/mata-pelajaran', [MataPelajaranController::class, 'index'])->middleware('auth');
Route::post('/admin/mata-pelajaran', [MataPelajaranController::class, 'store'])->middleware('auth');
Route::delete('/admin/mata-pelajaran/{id}', [MataPelajaranController::class, 'destroy'])->middleware('auth');

// RUTE DASHBOARD GURU (SEMENTARA)
Route::get('/guru/dashboard', function () {
    return "<h1>Halaman Dashboard Guru</h1>";
})->middleware('auth');