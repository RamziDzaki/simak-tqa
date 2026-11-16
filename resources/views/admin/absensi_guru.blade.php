@extends('layouts.app')

@section('content')
<style>
    .header-custom { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; justify-content: space-between; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; border: none; }
    .title-area h2 { margin: 0; font-weight: 700; font-size: 1.5rem; }
    .title-area p { margin: 0; color: #555; font-size: 0.9rem; }
    
    /* Card Profil Guru */
    .guru-card { background: white; border-radius: 16px; padding: 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 25px; border: 1px solid #e2e8f0; }
    .guru-info { display: flex; align-items: center; gap: 20px; }
    .avatar-box { background-color: #d1f0e5; color: #0b6b4f; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; }
    .guru-details h4 { margin: 0 0 8px 0; font-weight: 700; }
    .guru-details p { margin: 0; font-size: 0.9rem; color: #555; display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
    .btn-export { border: 2px solid #0b6b4f; color: #0b6b4f; background: transparent; padding: 8px 20px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px; text-decoration: none; }
    .btn-export:hover { background-color: #0b6b4f; color: white; }

    /* Tabel */
    .table-card { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
    .table thead th { background-color: #f8f9fa; border-bottom: none; font-weight: 700; text-align: center; padding: 15px; }
    .table tbody td { text-align: center; vertical-align: middle; padding: 15px; }
    .badge-hadir { background-color: #d1f0e5; color: #0b6b4f; padding: 6px 15px; border-radius: 20px; font-weight: 600; font-size: 0.85rem; }
    .badge-tidak { background-color: #fecaca; color: #dc2626; padding: 6px 15px; border-radius: 20px; font-weight: 600; font-size: 0.85rem; }
    .btn-detail { background-color: #0b6b4f; color: white; border: none; padding: 6px 15px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; }
</style>

<!-- Header -->
<div class="header-custom">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ url('/admin/absensi-guru') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
        <div class="title-area">
            <h2>Absensi Guru</h2>
            <p>Kelola Absensi Guru TQA Darussalam</p>
        </div>
    </div>
    <!-- Tombol Absen Hari Ini -->
    <a href="{{ url('/admin/absensi-guru/'.$guru->id.'/absen') }}" class="btn btn-success" style="background-color: #0b6b4f;">
        <i class="fa-solid fa-check"></i> Absen Hari Ini
    </a>
</div>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Card Profil Guru -->
<div class="guru-card">
    <div class="guru-info">
        <div class="avatar-box"><i class="fa-solid fa-user"></i></div>
        <div class="guru-details">
            <h4>{{ $guru->name ?? 'Nama Guru' }}</h4>
            <p><i class="fa-solid fa-id-card"></i> NIP: {{ $guru->nip ?? '200617724682' }}</p>
            <p><i class="fa-regular fa-calendar"></i> Hari: {{ $jadwal->hari ?? 'Senin' }}</p>
            <p><i class="fa-solid fa-book"></i> Kelas: {{ $jadwal->kelas ?? 'Mutawassit A' }} | Mapel: {{ $jadwal->mata_pelajaran ?? 'Tafsir' }}</p>
            <p><i class="fa-regular fa-clock"></i> Jam: {{ $jadwal->waktu_mulai ?? '14:00' }} - {{ $jadwal->waktu_selesai ?? '15:00' }}</p>
        </div>
    </div>
    <!-- Tombol Export -->
   <a href="{{ url('/admin/absensi-guru/'.$guru->id.'/export') }}" class="btn-export">
        <i class="fa-solid fa-download"></i> Export
    </a>
</div>

<!-- Tabel Riwayat Absensi -->
<div class="table-card">
    <table class="table table-hover align-middle">
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
            @forelse ($absensis as $index => $absen)
                <tr>
                    <td>{{ $absensis->firstItem() + $index }}</td>
                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->isoFormat('D MMM Y') }}</td>
                    <td>{{ $absen->jadwal->waktu_mulai ?? '14:00' }} - {{ $absen->jadwal->waktu_selesai ?? '16:00' }}</td>
                    <td>
                        @if($absen->status == 'Hadir')
                            <span class="badge-hadir">Hadir</span>
                        @else
                            <span class="badge-tidak">{{ $absen->status }}</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn-detail" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalDetail"
                                data-nama="{{ $guru->name ?? 'Guru' }}"
                                data-tanggal="{{ \Carbon\Carbon::parse($absen->tanggal)->isoFormat('D MMM Y') }}"
                                data-status="{{ $absen->status }}">
                            Detail
                        </button>
                    </td>
                </tr>
            @empty
                <!-- Data Dummy jika database kosong -->
                <tr>
                    <td>1</td><td>6 Okt 2026</td><td>14:00 - 16:00</td>
                    <td><span class="badge-hadir">Hadir</span></td>
                    <td><button class="btn-detail" data-bs-toggle="modal" data-bs-target="#modalDetail" data-nama="{{ $guru->name ?? 'Guru' }}" data-tanggal="6 Okt 2026" data-status="Hadir">Detail</button></td>
                </tr>
                <tr>
                    <td>2</td><td>6 Okt 2026</td><td>14:00 - 16:00</td>
                    <td><span class="badge-hadir">Hadir</span></td>
                    <td><button class="btn-detail" data-bs-toggle="modal" data-bs-target="#modalDetail" data-nama="{{ $guru->name ?? 'Guru' }}" data-tanggal="6 Okt 2026" data-status="Hadir">Detail</button></td>
                </tr>
                <tr>
                    <td>3</td><td>6 Okt 2026</td><td>14:00 - 16:00</td>
                    <td><span class="badge-hadir">Hadir</span></td>
                    <td><button class="btn-detail" data-bs-toggle="modal" data-bs-target="#modalDetail" data-nama="{{ $guru->name ?? 'Guru' }}" data-tanggal="6 Okt 2026" data-status="Hadir">Detail</button></td>
                </tr>
                <tr>
                    <td>4</td><td>6 Okt 2026</td><td>14:00 - 16:00</td>
                    <td><span class="badge-tidak">Tidak Hadir</span></td>
                    <td><button class="btn-detail" data-bs-toggle="modal" data-bs-target="#modalDetail" data-nama="{{ $guru->name ?? 'Guru' }}" data-tanggal="6 Okt 2026" data-status="Tidak Hadir">Detail</button></td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    @if($absensis->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $absensis->links() }}
        </div>
    @endif
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Detail Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Guru:</strong> <span id="detail-nama"></span></p>
                <p><strong>Tanggal:</strong> <span id="detail-tanggal"></span></p>
                <p><strong>Status:</strong> <span id="detail-status"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const detailButtons = document.querySelectorAll('.btn-detail');
        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('detail-nama').innerText = this.getAttribute('data-nama');
                document.getElementById('detail-tanggal').innerText = this.getAttribute('data-tanggal');
                document.getElementById('detail-status').innerText = this.getAttribute('data-status');
            });
        });
    });
</script>
@endpush

@endsection