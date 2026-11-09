@extends('layouts.app')

@section('content')
<style>
    .stat-card { background: white; border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .stat-card .left { display: flex; align-items: center; gap: 15px; }
    .stat-icon { background-color: #d1f0e5; color: #0b6b4f; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
    .stat-card h5 { margin: 0; font-size: 0.9rem; font-weight: 600; color: #333; }
    .stat-card h3 { margin: 0; font-size: 1.8rem; font-weight: 700; color: #111; }
</style>

<h2 class="fw-bold mb-4">Dashboard Admin</h2>
<div class="row g-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="left"><div class="stat-icon"><i class="fa-solid fa-user-group"></i></div><h5>Total Santri</h5></div>
            <h3>{{ $totalSantri ?? 0 }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="left"><div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div><h5>Total Guru</h5></div>
            <h3>{{ $totalGuru ?? 0 }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="left"><div class="stat-icon"><i class="fa-solid fa-door-open"></i></div><h5>Total Kelas</h5></div>
            <h3>{{ $totalKelas ?? 0 }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="left"><div class="stat-icon"><i class="fa-solid fa-book"></i></div><h5>Mata Pelajaran</h5></div>
            <h3>{{ $totalMapel ?? 0 }}</h3>
        </div>
    </div>
</div>
@endsection