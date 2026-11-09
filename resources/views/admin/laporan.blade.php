@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .page-header .icon-box { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.8rem; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }

    .report-card { background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-decoration: none; color: inherit; transition: 0.3s; }
    .report-card:hover { background-color: #f8f9fa; transform: translateX(5px); }
    .report-card .left { display: flex; align-items: center; gap: 20px; }
    .report-icon { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    .report-info h5 { margin: 0; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; }
    .report-info p { margin: 5px 0 0; font-size: 0.85rem; color: #555; }
    .arrow-btn { background-color: #0b6b4f; color: white; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
</style>

<div class="page-header">
    <div class="icon-box"><i class="fa-solid fa-chart-simple"></i></div>
    <div>
        <h2>Kelola Laporan</h2>
        <p>Kelola semua laporan TQA Darussalam.</p>
    </div>
</div>

<!-- Card 1: Absensi Santri -->
<a href="{{ url('/admin/absensi-santri') }}" class="report-card">
    <div class="left">
        <div class="report-icon"><i class="fa-solid fa-users"></i></div>
        <div class="report-info">
            <h5>Absensi Santri</h5>
            <p>Kelola dan Lihat Data Kehadiran Santri</p>
        </div>
    </div>
    <div class="arrow-btn"><i class="fa-solid fa-arrow-right"></i></div>
</a>

<!-- Card 2: Absensi Guru -->
<a href="{{ url('/admin/absensi-guru') }}" class="report-card">
    <div class="left">
        <div class="report-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <div class="report-info">
            <h5>Absensi Guru</h5>
            <p>Kelola dan Lihat Data Kehadiran Guru</p>
        </div>
    </div>
    <div class="arrow-btn"><i class="fa-solid fa-arrow-right"></i></div>
</a>

<!-- Card 3: Nilai -->
<a href="{{ url('/admin/nilai') }}" class="report-card">
    <div class="left">
        <div class="report-icon"><i class="fa-solid fa-file-lines"></i></div>
        <div class="report-info">
            <h5>Nilai</h5>
            <p>Kelola dan Lihat Data Nilai</p>
        </div>
    </div>
    <div class="arrow-btn"><i class="fa-solid fa-arrow-right"></i></div>
</a>
@endsection