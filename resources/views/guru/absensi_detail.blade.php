@extends('layouts.guru')

@section('content')
<style>
    .header-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #e2e8f0; }
    .header-info { display: flex; align-items: center; gap: 20px; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; text-decoration: none; }
    .header-info h3 { margin: 0; font-weight: 700; font-size: 1.5rem; }
    .header-info p { margin: 0; font-size: 0.9rem; color: #555; display: flex; align-items: center; gap: 8px; margin-top: 5px; }
    .badge-status { padding: 5px 15px; border-radius: 20px; font-weight: 600; font-size: 0.8rem; }
    .btn-absensi { background-color: #d1f0e5; color: #0b6b4f; border: 2px solid #0b6b4f; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px; }
    .btn-absensi.disabled { background-color: #ccc; color: #666; border-color: #ccc; cursor: not-allowed; }
    .table-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
    .table thead th { background-color: #f8f9fa; border-bottom: none; font-weight: 700; text-align: center; padding: 15px; }
    .table tbody td { text-align: center; vertical-align: middle; padding: 15px; }
</style>

<!-- Header Info -->
<div class="header-card">
    <div class="header-info">
        <a href="{{ url('/guru/absensi') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
        <div>
            <h3>{{ $jadwal->kelas }}</h3>
            <p><i class="fa-solid fa-book"></i> {{ $jadwal->mata_pelajaran }}</p>
            <p><i class="fa-regular fa-clock"></i> {{ $jadwal->hari }}, {{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</p>
            <p><i class="fa-solid fa-users"></i> Guru: {{ $jadwal->guru }}</p>
            <p><i class="fa-solid fa-door-open"></i> {{ $jadwal->ruangan ?? 'R1 (Dalam Masjid)' }}</p>
        </div>
    </div>
    <div class="text-end">
        <span class="badge-status {{ $jadwal->warna }} mb-3 d-inline-block">{{ $jadwal->status }}</span>
        <br>
        @if($sudah_absen)
            <button class="btn-absensi disabled" disabled>
                <i class="fa-solid fa-check"></i> Sudah Absen
            </button>
        @elseif($jadwal->status == 'Sedang Berlangsung')
            <a href="{{ url('/guru/absensi/'.$jadwal->id.'/absen') }}" class="btn-absensi" onclick="return confirm('Yakin ingin absen untuk jadwal ini?')">
                <i class="fa-solid fa-clipboard-check"></i> Lakukan Absensi
            </a>
        @else
            <button class="btn-absensi disabled" disabled>
                <i class="fa-solid fa-clock"></i> Belum Waktunya
            </button>
        @endif
    </div>
</div>

<!-- Tabel Pertemuan -->
<div class="table-card">
    <h5 class="fw-bold mb-3">Daftar Pertemuan</h5>
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Pertemuan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pertemuans as $p)
                <tr>
                    <td>{{ $p->pertemuan_ke }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->isoFormat('D MMM YYYY') }}</td>
                    <td>{{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</td>
                    <td>
                        @if(\Carbon\Carbon::parse($p->tanggal)->isToday())
                            <span class="badge-status bg-success-subtle text-success">Sedang Berlangsung</span>
                        @elseif(\Carbon\Carbon::parse($p->tanggal)->isPast())
                            <span class="badge-status bg-danger-subtle text-danger">Selesai</span>
                        @else
                            <span class="badge-status bg-secondary-subtle text-secondary">Belum Dimulai</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('/guru/jadwal/'.$jadwal->id.'/absensi/'.$p->id) }}" class="btn btn-sm btn-success" style="background-color: #0b6b4f;">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada pertemuan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection