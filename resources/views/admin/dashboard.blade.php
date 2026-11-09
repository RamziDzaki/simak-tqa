@extends('layouts.app')

@section('content')
<style>
    .dash-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .dash-header .icon-box { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.8rem; }
    .dash-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .dash-header p { margin: 0; color: #555; }
    
    .stat-card { background: white; border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 6px rgba(0,0,0,0.05); height: 100%; }
    .stat-card .left { display: flex; align-items: center; gap: 15px; }
    .stat-icon { background-color: #d1f0e5; color: #0b6b4f; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
    .stat-card h5 { margin: 0; font-size: 0.9rem; font-weight: 600; color: #333; }
    .stat-card h3 { margin: 0; font-size: 1.8rem; font-weight: 700; color: #111; }

    .table-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-top: 30px; }
    .table-card .header-table { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .table-card h4 { font-weight: 700; margin: 0; }
    .table th { background-color: #e6f4f0; color: #111; font-weight: 600; border-bottom: 2px solid #d1f0e5; }
    .table td { vertical-align: middle; font-weight: 500; }
    
    /* Status Badges */
    .badge-berlangsung { background-color: #d1f0e5; color: #0b6b4f; padding: 8px 15px; border-radius: 6px; font-weight: 600; }
    .badge-akandatang { background-color: #fce4c4; color: #b36b00; padding: 8px 15px; border-radius: 6px; font-weight: 600; }
    .badge-selesai { background-color: #e2e8f0; color: #475569; padding: 8px 15px; border-radius: 6px; font-weight: 600; }
</style>

<!-- Header Dashboard -->
<div class="dash-header">
    <div class="icon-box"><i class="fa-solid fa-border-all"></i></div>
    <div>
        <h2>Dashboard Admin</h2>
        <p>Selamat datang, {{ Auth::user()->name }}...</p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="left"><div class="stat-icon"><i class="fa-solid fa-user-group"></i></div><h5>Total Santri</h5></div>
            <h3>{{ $totalSantri }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="left"><div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div><h5>Total Guru</h5></div>
            <h3>{{ $totalGuru }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="left"><div class="stat-icon"><i class="fa-solid fa-door-open"></i></div><h5>Total Kelas</h5></div>
            <h3>{{ $totalKelas }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="left"><div class="stat-icon"><i class="fa-solid fa-book"></i></div><h5>Mata Pelajaran</h5></div>
            <h3>{{ $totalMapel }}</h3>
        </div>
    </div>
</div>

<!-- Tabel Jadwal Hari Ini -->
<div class="table-card">
    <div class="header-table">
        <h4>Jadwal Hari ini</h4>
        <a href="#" class="text-dark text-decoration-none" style="font-weight: 500;">Lihat Semua <i class="fa-solid fa-chevron-down ms-1"></i></a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sementara kita isi kosong dulu, atau data dummy -->
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada jadwal untuk hari ini.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection