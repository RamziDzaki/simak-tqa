@extends('layouts.guru')

@section('content')
<style>
    /* Header */
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .page-header .icon-box { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.8rem; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }

    /* Statistik */
    .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px; border: 1px solid #e2e8f0; }
    .stat-icon { background-color: #d1f0e5; color: #0b6b4f; width: 55px; height: 55px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; flex-shrink: 0; }
    .stat-value { font-size: 1.5rem; font-weight: 700; margin: 0; }
    .stat-label { font-size: 0.9rem; color: #333; margin: 0; font-weight: 500; }

    /* Tabel */
    .table-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
    .table-card h5 { font-weight: 700; margin-bottom: 20px; }
    .table thead th { background-color: #f8f9fa; border-bottom: none; font-weight: 700; text-align: center; padding: 15px; }
    .table tbody td { text-align: center; vertical-align: middle; padding: 15px; }
    .badge-status { padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; display: inline-block; width: 100%; max-width: 150px; margin: 0 auto; }
</style>

<!-- Header -->
<div class="page-header">
    <div class="icon-box"><i class="fa-solid fa-border-all"></i></div>
    <div>
        <h2>Dashboard Guru</h2>
        <p>Selamat datang, {{ $guru->name }}...</p>
    </div>
</div>

<!-- Statistik -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
        <div>
            <p class="stat-label">Jadwal Hari Ini</p>
            <p class="stat-value">{{ $jadwalHariIni->count() }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
        <div>
            <p class="stat-label">Total Mata Pelajaran</p>
            <p class="stat-value">{{ $totalMapel }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
        <div>
            <p class="stat-label">Jadwal yang sudah selesai</p>
            <p class="stat-value">{{ $jadwalSelesai }}</p>
        </div>
    </div>
</div>

<!-- Tabel Jadwal Hari Ini -->
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold m-0">Jadwal Hari ini</h5>
        <span class="fw-bold">{{ $hariIni }}, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</span>
    </div>
    <table class="table align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Kelas</th>
                <th>Ruangan</th>
                <th>Mata Pelajaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwalHariIni as $index => $j)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $j->waktu_mulai }} - {{ $j->waktu_selesai }}</td>
                    <td>{{ $j->kelas }}</td>
                    <td>{{ $j->ruangan ?? 'R1 (Dalam Masjid)' }}</td>
                    <td>{{ $j->mata_pelajaran }}</td>
                    <td>
                        <span class="badge-status {{ $j->warna }}">{{ $j->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Tidak ada jadwal mengajar hari ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection