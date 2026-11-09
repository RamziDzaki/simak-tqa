@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .back-btn { background-color: #d1f0e5; color: #0b6b4f; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; text-decoration: none; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }

    .filter-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .filter-card label { font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; display: block; }
    .filter-card select, .filter-card input { border-radius: 8px; }
    
    .table-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .table th { background-color: #e6f4f0; color: #111; font-weight: 600; border-bottom: 2px solid #d1f0e5; text-align: center; }
    .table td { text-align: center; vertical-align: middle; font-weight: 500; }
    
    .btn-tampilkan { background-color: #0b6b4f; color: white; font-weight: 600; border-radius: 8px; padding: 10px 20px; }
    .btn-detail { background-color: #0b6b4f; color: white; padding: 5px 15px; border-radius: 6px; font-size: 0.8rem; text-decoration: none; }
</style>

<div class="page-header">
    <a href="{{ url('/admin/laporan') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div>
        <h2>Absensi Santri</h2>
        <p>Kelola Absensi Santri TQA Darussalam</p>
    </div>
</div>

<!-- Filter -->
<div class="filter-card">
    <div class="row g-3 align-items-end">
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
        <div class="col-md-2">
            <label>Tahun</label>
            <input type="number" class="form-control" value="2026">
        </div>
        <div class="col-md-2">
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
        <input type="text" class="form-control" placeholder="Cari Nama Santri...">
    </div>
    <button class="btn btn-tampilkan"><i class="fa-solid fa-filter"></i> Tampilkan</button>
</div>

<!-- Tabel Absensi -->
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0">Daftar Absensi Santri</h5>
        <button class="btn btn-outline-dark"><i class="fa-solid fa-download"></i> Export</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Santri</th>
                    <th>Kelas</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sementara kosong karena belum ada data absensi -->
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Belum ada data absensi.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                <li class="page-item disabled"><a class="page-link" href="#">&lt;</a></li>
                <li class="page-item active"><a class="page-link" href="#" style="background-color: #0b6b4f; border-color: #0b6b4f;">1</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">&gt;</a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection