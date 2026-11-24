@extends('layouts.guru')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .page-header .icon-box { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.8rem; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }

    .search-box { position: relative; margin-bottom: 20px; }
    .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; }
    .search-box input { width: 100%; padding: 12px 12px 12px 40px; border-radius: 8px; border: 1px solid #ddd; outline: none; }

    .jadwal-card { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        background: white; 
        border-radius: 12px; 
        padding: 20px; 
        margin-bottom: 15px; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.05); 
        border: 1px solid #e2e8f0;
        text-decoration: none; 
        color: inherit; 
        transition: 0.3s;
    }
    .jadwal-card:hover { border-color: #0b6b4f; }
    .jadwal-info { display: flex; align-items: center; gap: 20px; }
    .jadwal-icon { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .jadwal-info h5 { margin: 0; font-weight: 700; color: #111; }
    .jadwal-info p { margin: 0; font-size: 0.85rem; color: #555; }
</style>

<div class="page-header">
    <div class="icon-box"><i class="fa-solid fa-book"></i></div>
    <div>
        <h2>Kelola Nilai</h2>
        <p>Input Nilai Santri disini...</p>
    </div>
</div>

<h5 class="fw-bold mb-3">Kelas yang diampu</h5>

<div class="search-box">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" placeholder="Cari Kelas...">
</div>

@forelse($jadwals as $j)
    <a href="{{ url('/guru/nilai/'.$j->id.'/input') }}" class="jadwal-card">
        <div class="jadwal-info">
            <div class="jadwal-icon"><i class="fa-solid fa-book"></i></div>
            <div>
                <h5 class="text-uppercase">{{ $j->kelas }}</h5>
                <p><i class="fa-regular fa-clock"></i> {{ $j->waktu_mulai }} - {{ $j->waktu_selesai }}</p>
                <p><i class="fa-solid fa-book"></i> {{ $j->mata_pelajaran }}</p>
                <p><i class="fa-solid fa-door-open"></i> {{ $j->ruangan ?? 'R1 (Dalam Masjid)' }}</p>
            </div>
        </div>
        <i class="fa-solid fa-chevron-right" style="color: #0b6b4f; font-size: 1.5rem;"></i>
    </a>
@empty
    <div class="alert alert-info">Belum ada jadwal mengajar.</div>
@endforelse

@endsection