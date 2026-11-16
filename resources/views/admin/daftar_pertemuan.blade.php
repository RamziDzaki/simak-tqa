@extends('layouts.app')

@section('content')
<style>
    .header-custom { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .header-left { display: flex; align-items: center; gap: 15px; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; border: none; }
    .nav-tabs-custom { border-bottom: none; margin-bottom: 20px; gap: 10px; }
    .nav-tabs-custom .nav-link { border: none; background-color: #e2e8f0; color: #475569; border-radius: 8px; padding: 10px 20px; font-weight: 600; }
    .nav-tabs-custom .nav-link.active { background-color: #0b6b4f; color: white; }
    .periode-card { background: white; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .table-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .table thead th { background-color: #f8f9fa; border-bottom: none; font-weight: 700; text-align: center; padding: 15px; }
    .table tbody td { text-align: center; vertical-align: middle; padding: 15px; }
</style>

<div class="header-custom">
    <div class="header-left">
        <a href="{{ url('/admin/jadwal') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
        <div>
            <h2 style="font-weight: 700; margin: 0; font-size: 1.5rem;">Jadwal Kelas {{ $kelas->nama_kelas }}</h2>
            <p style="margin: 0; color: #555;">Kelola data Jadwal TQA Darussalam</p>
        </div>
    </div>
</div>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Tab Navigasi -->
<ul class="nav nav-tabs nav-tabs-custom">
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/jadwal/'.$kelas->id.'/atur') }}">Pengaturan Jadwal</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Daftar Pertemuan</a>
    </li>
</ul>

<!-- Card Periode -->
<div class="periode-card">
    <div class="fw-bold me-3">Periode</div>
    <div>
        <div style="font-weight: 600;">Senin, 6 Okt 2026 - Jum'at, 5 Des 2026</div>
    </div>
    <div class="ms-auto d-flex gap-5">
        <div class="text-center">
            <span class="text-muted" style="font-size: 0.85rem;">Jumlah Pertemuan</span>
            <h5 class="fw-bold m-0">{{ $pertemuans->count() }}</h5>
        </div>
        <div class="text-center">
            <span class="text-muted" style="font-size: 0.85rem;">Sisa Pertemuan</span>
            <h5 class="fw-bold m-0">{{ $pertemuans->count() }}</h5>
        </div>
    </div>
</div>

<!-- Tabel Pertemuan -->
<div class="table-card">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengajar</th>
                <th>Sub Materi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pertemuans as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('D MMM YYYY') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('dddd') }}</td>
                    <td>{{ $p->jadwal->waktu_mulai }} - {{ $p->jadwal->waktu_selesai }}</td>
                    <td>{{ $p->jadwal->mata_pelajaran }}</td>
                    <td>{{ $p->jadwal->guru }}</td>
                    <td>{{ $p->sub_materi ?? '-' }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-success" style="background-color: #0b6b4f;">Detail</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Belum ada pertemuan. Silakan kembali ke Pengaturan Jadwal dan klik "Generate Jadwal".</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection