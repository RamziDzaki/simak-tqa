@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .page-header .icon-box { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.8rem; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }
    .search-box { position: relative; margin-bottom: 20px; }
    .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; }
    .search-box input { width: 100%; padding: 12px 12px 12px 40px; border-radius: 8px; border: 1px solid #ddd; outline: none; }
    
    .class-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .class-card .left { display: flex; align-items: center; gap: 20px; }
    .class-icon { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    .class-info h5 { margin: 0; font-weight: 700; font-size: 1.2rem; }
    .class-info p { margin: 5px 0 0; font-size: 0.85rem; color: #555; display: flex; gap: 15px; }
    
    .badge-pertemuan { background-color: #d1f0e5; color: #0b6b4f; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .badge-belum { background-color: #e2e8f0; color: #475569; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .btn-atur { background-color: white; color: #0b6b4f; border: 2px solid #0b6b4f; padding: 8px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.3s; }
    .btn-atur:hover { background-color: #0b6b4f; color: white; }
</style>

<div class="page-header">
    <div class="icon-box"><i class="fa-regular fa-calendar-check"></i></div>
    <div>
        <h2>Kelola Jadwal</h2>
        <p>Kelola data Jadwal TQA Darussalam.</p>
    </div>
</div>

<h5 class="fw-bold mb-3">Daftar Kelas</h5>

<div class="search-box">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" placeholder="Cari Kelas...">
</div>

@forelse ($kelas as $item)
    <div class="class-card">
        <div class="left">
            <div class="class-icon"><i class="fa-solid fa-door-open"></i></div>
            <div class="class-info">
                <h5>{{ strtoupper($item->nama_kelas) }}</h5>
                <p>
                    <span><i class="fa-solid fa-users"></i> Kapasitas: {{ $item->kapasitas }}</span>
                    <span><i class="fa-solid fa-user-group"></i> Jumlah Santri: {{ $item->jumlah_santri ?? 0 }}</span>
                    <span><i class="fa-solid fa-location-dot"></i> {{ $item->ruangan ?? 'Belum diatur' }}</span>
                </p>
            </div>
        </div>
        <div class="text-end">
            @if($item->jumlah_pertemuan > 0)
                <div class="badge-pertemuan mb-2"><i class="fa-solid fa-calendar-day"></i> {{ $item->jumlah_pertemuan }} Pertemuan</div>
            @else
                <div class="badge-belum mb-2"><i class="fa-regular fa-calendar"></i> Belum di Atur</div>
            @endif
            <br>
            <a href="{{ url('/admin/jadwal/'.$item->nama_kelas.'/atur') }}" class="btn-atur">Atur Jadwal <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
@empty
    <div class="alert alert-info">Belum ada data kelas. Silakan tambah kelas terlebih dahulu di menu Kelola Kelas.</div>
@endforelse

@endsection