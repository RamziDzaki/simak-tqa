<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', [
        'totalSantri' => \App\Models\Santri::count(),
        'totalGuru' => \App\Models\User::where('role', 'guru')->count(),
        'totalKelas' => \App\Models\Kelas::count(),
        'totalMapel' => \App\Models\MataPelajaran::count(),
    ]);
})->middleware('auth');

Route::get('/guru/dashboard', function () {
    return "<h1>Halaman Dashboard Guru</h1>";
})->middleware('auth');