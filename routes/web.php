<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController;
use App\Models\Jadwal;
use Carbon\Carbon;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// RUTE DASHBOARD
Route::get('/admin/dashboard', function () {
    $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');

    return view('admin.dashboard', [
        'totalSantri' => \App\Models\Santri::count(),
        'totalGuru' => \App\Models\User::where('role', 'guru')->count(),
        'totalKelas' => \App\Models\Kelas::count(),
        'totalMapel' => \App\Models\MataPelajaran::count(),
        'jadwalHariIni' => Jadwal::where('hari', $hariIni)->get(),
    ]);
})->middleware('auth');

// RUTE KELOLA USER
Route::get('/admin/user', [UserController::class, 'index'])->middleware('auth');
Route::post('/admin/user', [UserController::class, 'store'])->middleware('auth');
Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->middleware('auth');

// RUTE MATA PELAJARAN
Route::get('/admin/mata-pelajaran', [MataPelajaranController::class, 'index'])->middleware('auth');
Route::post('/admin/mata-pelajaran', [MataPelajaranController::class, 'store'])->middleware('auth');
Route::delete('/admin/mata-pelajaran/{id}', [MataPelajaranController::class, 'destroy'])->middleware('auth');

// RUTE KELOLA KELAS
Route::get('/admin/kelas', [KelasController::class, 'index'])->middleware('auth');
Route::post('/admin/kelas', [KelasController::class, 'store'])->middleware('auth');
Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->middleware('auth');

// RUTE KELOLA JADWAL
Route::get('/admin/jadwal', [JadwalController::class, 'index'])->middleware('auth');
Route::get('/admin/jadwal/{nama_kelas}/atur', [JadwalController::class, 'create'])->middleware('auth');
Route::post('/admin/jadwal', [JadwalController::class, 'store'])->middleware('auth');

// RUTE LAPORAN
Route::get('/admin/laporan', function () {
    return view('admin.laporan');
})->middleware('auth');

// RUTE ABSENSI SANTRI
Route::get('/admin/absensi-santri', function () {
    return view('admin.absensi_santri');
})->middleware('auth');

// RUTE ABSENSI GURU
Route::get('/admin/absensi-guru', function () {
    return view('admin.absensi_guru');
})->middleware('auth');

// RUTE NILAI (TAMBAHAN BARU)
Route::get('/admin/nilai', function () {
    return view('admin.nilai');
})->middleware('auth');

// RUTE DASHBOARD GURU (SEMENTARA)
Route::get('/guru/dashboard', function () {
    return "<h1>Halaman Dashboard Guru</h1>";
})->middleware('auth');