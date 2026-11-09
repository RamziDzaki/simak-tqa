@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .back-btn { background-color: #d1f0e5; color: #0b6b4f; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; text-decoration: none; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }

    .filter-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .filter-card label { font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; display: block; }
    .filter-card select { border-radius: 8px; }
    
    .btn-tampilkan { background-color: #0b6b4f; color: white; font-weight: 600; border-radius: 8px; padding: 10px 20px; }

    /* Kartu Guru */
    .teacher-card { background: white; border-radius: 12px; padding: 20px 30px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: 0.3s; text-decoration: none; color: inherit; }
    .teacher-card:hover { background-color: #f8f9fa; }
    .teacher-card .left { display: flex; align-items: center; gap: 20px; }
    .teacher-icon { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    .teacher-info h5 { margin: 0; font-weight: 700; font-size: 1.1rem; }
    .teacher-info p { margin: 5px 0 0; font-size: 0.85rem; color: #555; display: flex; flex-direction: column; gap: 3px; }
    .teacher-info p span i { width: 20px; text-align: center; margin-right: 5px; }
</style>

<div class="page-header">
    <a href="{{ url('/admin/laporan') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div>
        <h2>Absensi Guru</h2>
        <p>Kelola dan Lihat Data Kehadiran Guru</p>
    </div>
</div>

<!-- Filter -->
<div class="filter-card">
    <div class="row g-3">
        <div class="col-md-3">
            <label>Kelas</label>
            <select class="form-select">
                <option>Mutawassit A</option>
                <option>Mutawassit B</option>
                <option>Mubtadi'</option>
                <option>Mutqin</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Mata Pelajaran</label>
            <select class="form-select">
                <option>Tahsin</option>
                <option>Tafsir</option>
                <option>Tahfidz</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Hari</label>
            <select class="form-select">
                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
                <option>Sabtu</option>
                <option>Minggu</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Semester</label>
            <select class="form-select">
                <option>Ganjil</option>
                <option>Genap</option>
            </select>
        </div>
    </div>
</div>

<!-- Search & Tampilkan -->
<div class="d-flex gap-3 mb-4">
    <div class="input-group" style="max-width: 400px;">
        <span class="input-group-text bg-white"><i class="fa-solid fa-magnifying-glass"></i></span>
        <input type="text" class="form-control" placeholder="Cari Nama Guru...">
    </div>
    <button class="btn btn-tampilkan"><i class="fa-solid fa-filter"></i> Tampilkan</button>
</div>

<!-- Daftar Guru (Sementara Kosong) -->
<div class="alert alert-info text-center">
    Belum ada data absensi guru untuk filter ini.
</div>

@endsection