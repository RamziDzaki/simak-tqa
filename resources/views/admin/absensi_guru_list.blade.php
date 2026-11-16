@extends('layouts.app')

@section('content')
<style>
    .header-custom { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; border: none; }
    .title-area h2 { margin: 0; font-weight: 700; font-size: 1.5rem; }
    .title-area p { margin: 0; color: #555; font-size: 0.9rem; }
    
    /* Filter Card */
    .filter-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap; border: 1px solid #e2e8f0; }
    .filter-item { flex: 1; min-width: 150px; }
    .filter-label { font-size: 0.8rem; font-weight: 600; margin-bottom: 5px; display: block; }
    
    /* Search bar */
    .search-wrapper { display: flex; gap: 10px; margin-bottom: 25px; }
    .search-input { flex: 1; position: relative; }
    .search-input input { width: 100%; padding: 12px 12px 12px 40px; border-radius: 8px; border: 1px solid #ddd; outline: none; }
    .search-input .fa-magnifying-glass { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; }
    .btn-tampilkan { background-color: #0b6b4f; color: white; border: none; padding: 10px 30px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
    
    /* Guru Card */
    .guru-card-item { background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
    .guru-info { display: flex; align-items: center; gap: 20px; }
    .avatar-circle { background-color: #d1f0e5; color: #0b6b4f; width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    .guru-details h5 { margin: 0 0 5px 0; font-weight: 700; }
    .guru-details p { margin: 0; font-size: 0.85rem; color: #555; display: flex; align-items: center; gap: 8px; margin-bottom: 2px; }
    .btn-arrow { color: #0b6b4f; font-size: 2rem; text-decoration: none; }
</style>

<!-- Header -->
<div class="header-custom">
    <a href="{{ url('/admin/laporan') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="title-area">
        <h2>Absensi Guru</h2>
        <p>Kelola dan Lihat Data Kehadiran Guru</p>
    </div>
</div>

<!-- Card Filter -->
<div class="filter-card">
    <div class="filter-item">
        <label class="filter-label">Kelas</label>
        <select class="form-select">
            <option>Semua Kelas</option>
        </select>
    </div>
    <div class="filter-item">
        <label class="filter-label">Mata Pelajaran</label>
        <select class="form-select">
            <option>Semua Mapel</option>
        </select>
    </div>
    <div class="filter-item">
        <label class="filter-label">Hari</label>
        <select class="form-select">
            <option>Semua Hari</option>
        </select>
    </div>
    <div class="filter-item">
        <label class="filter-label">Semester</label>
        <select class="form-select">
            <option>Ganjil</option>
            <option>Genap</option>
        </select>
    </div>
</div>

<!-- Search Bar -->
<div class="search-wrapper">
    <div class="search-input">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari Nama Guru...">
    </div>
    <button class="btn-tampilkan"><i class="fa-solid fa-filter me-2"></i> Tampilkan</button>
</div>

<!-- Daftar Guru -->
@forelse($gurus as $guru)
    @php
        // Ambil jadwal guru untuk ditampilkan di card
        $jadwalGuru = \App\Models\Jadwal::where('guru', $guru->name)->first();
    @endphp
    <div class="guru-card-item">
        <div class="guru-info">
            <div class="avatar-circle"><i class="fa-solid fa-chalkboard-user"></i></div>
            <div class="guru-details">
                <h5>{{ $guru->name }}</h5>
                @if($jadwalGuru)
                    <p><i class="fa-regular fa-calendar"></i> {{ $jadwalGuru->hari }}</p>
                    <p><i class="fa-solid fa-door-open"></i> {{ $jadwalGuru->kelas }}</p>
                    <p><i class="fa-solid fa-book"></i> {{ $jadwalGuru->mata_pelajaran }}</p>
                    <p><i class="fa-regular fa-clock"></i> {{ $jadwalGuru->waktu_mulai }} - {{ $jadwalGuru->waktu_selesai }}</p>
                @else
                    <p class="text-muted">Belum ada jadwal</p>
                @endif
            </div>
        </div>
        <a href="{{ url('/admin/absensi-guru/'.$guru->id.'/detail') }}" class="btn-arrow">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
@empty
    <div class="alert alert-info">Belum ada data guru.</div>
@endforelse

@endsection