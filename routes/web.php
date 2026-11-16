<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\AbsensiGuruController;
use App\Models\Jadwal;
use Carbon\Carbon;

Route::get('/', function () {
    return redirect('/login');
});

// RUTE LOGIN & REGISTER
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// RUTE DASHBOARD ADMIN
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
Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->middleware('auth');
Route::put('/admin/user/{id}', [UserController::class, 'update'])->middleware('auth');

// RUTE MATA PELAJARAN
Route::get('/admin/mata-pelajaran', [MataPelajaranController::class, 'index'])->middleware('auth');
Route::post('/admin/mata-pelajaran', [MataPelajaranController::class, 'store'])->middleware('auth');
Route::delete('/admin/mata-pelajaran/{id}', [MataPelajaranController::class, 'destroy'])->middleware('auth');
Route::get('/admin/mata-pelajaran/{id}/edit', [MataPelajaranController::class, 'edit'])->middleware('auth');
Route::put('/admin/mata-pelajaran/{id}', [MataPelajaranController::class, 'update'])->middleware('auth');

// RUTE KELOLA KELAS
Route::get('/admin/kelas', [KelasController::class, 'index'])->middleware('auth');
Route::post('/admin/kelas', [KelasController::class, 'store'])->middleware('auth');
Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->middleware('auth');
Route::get('/admin/kelas/{id}/edit', [KelasController::class, 'edit'])->middleware('auth');
Route::put('/admin/kelas/{id}', [KelasController::class, 'update'])->middleware('auth');

// RUTE KELOLA RUANGAN (TAMBAHAN BARU)
Route::get('/admin/ruangan', [RuanganController::class, 'index'])->middleware('auth');
Route::post('/admin/ruangan', [RuanganController::class, 'store'])->middleware('auth');
Route::get('/admin/ruangan/{id}/edit', [RuanganController::class, 'edit'])->middleware('auth');
Route::put('/admin/ruangan/{id}', [RuanganController::class, 'update'])->middleware('auth');
Route::delete('/admin/ruangan/{id}', [RuanganController::class, 'destroy'])->middleware('auth');

// RUTE KELOLA JADWAL
Route::get('/admin/jadwal', [JadwalController::class, 'index'])->middleware('auth');
Route::get('/admin/jadwal/{id}/atur', [JadwalController::class, 'create'])->middleware('auth');
Route::post('/admin/jadwal', [JadwalController::class, 'store'])->middleware('auth');
Route::get('/admin/jadwal/{id}/edit', [JadwalController::class, 'edit'])->middleware('auth');
Route::put('/admin/jadwal/{id}', [JadwalController::class, 'update'])->middleware('auth');
Route::delete('/admin/jadwal/{id}', [JadwalController::class, 'destroy'])->middleware('auth');
Route::post('/admin/jadwal/{id}/generate-pertemuan', [JadwalController::class, 'generatePertemuan'])->middleware('auth'); // <-- TAMBAH INI
Route::get('/admin/jadwal/{id}/daftar-pertemuan', [JadwalController::class, 'daftarPertemuan'])->middleware('auth');    // <-- TAMBAH INI
// RUTE LAPORAN
Route::get('/admin/laporan', function () {
    return view('admin.laporan');
})->middleware('auth');

// RUTE ABSENSI SANTRI
Route::get('/admin/absensi-santri', function () {
    return view('admin.absensi_santri');
})->middleware('auth');

// RUTE ABSENSI GURU (VERSI BARU: Daftar Guru & Detail)
Route::get('/admin/absensi-guru', [AbsensiGuruController::class, 'daftarGuru'])->middleware('auth');
Route::get('/admin/absensi-guru/{id}/detail', [AbsensiGuruController::class, 'index'])->middleware('auth');
Route::get('/admin/absensi-guru/{id}/export', [AbsensiGuruController::class, 'export'])->middleware('auth');
Route::get('/admin/absensi-guru/{id}/absen', [AbsensiGuruController::class, 'absenHariIni'])->middleware('auth');
Route::post('/admin/absensi-guru', [AbsensiGuruController::class, 'store'])->middleware('auth');

// RUTE NILAI
Route::get('/admin/nilai', function () {
    return view('admin.nilai');
})->middleware('auth');

// RUTE DASHBOARD GURU
Route::get('/guru/dashboard', [App\Http\Controllers\GuruController::class, 'dashboard'])->middleware('auth');

// RUTE JADWAL MENGAJAR GURU
Route::get('/guru/jadwal', [App\Http\Controllers\GuruController::class, 'jadwalIndex'])->middleware('auth');
Route::get('/guru/jadwal/{id}/pertemuan', [App\Http\Controllers\GuruController::class, 'pertemuanIndex'])->middleware('auth');
Route::get('/guru/jadwal/{id}/absensi/{pertemuan_id}', [App\Http\Controllers\GuruController::class, 'pilihMetodeAbsensi'])->middleware('auth');
Route::get('/guru/jadwal/{id}/absensi/{pertemuan_id}/scan', [App\Http\Controllers\GuruController::class, 'scanAbsensi'])->middleware('auth');

// RUTE ABSENSI MANUAL
Route::get('/guru/jadwal/{id}/absensi/{pertemuan_id}/manual', [App\Http\Controllers\GuruController::class, 'absensiManual'])->middleware('auth');
Route::post('/guru/jadwal/{id}/absensi/{pertemuan_id}/manual', [App\Http\Controllers\GuruController::class, 'simpanAbsensiManual'])->middleware('auth');

// RUTE QR CODE SANTRI & SCAN
Route::get('/admin/santri/{id}/qr', [App\Http\Controllers\UserController::class, 'showQr'])->middleware('auth');
Route::post('/guru/absensi/scan', [App\Http\Controllers\GuruController::class, 'processScan'])->middleware('auth');

// RUTE ABSENSI GURU (VERSI GURU)
Route::get('/guru/absensi', [App\Http\Controllers\GuruController::class, 'absensiIndex'])->middleware('auth');
Route::get('/guru/absensi/{id}/absen', [App\Http\Controllers\GuruController::class, 'absenGuru'])->middleware('auth');

Route::get('/guru/absensi/{id}/detail', [App\Http\Controllers\GuruController::class, 'absensiDetail'])->middleware('auth');