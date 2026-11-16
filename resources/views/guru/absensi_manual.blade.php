@extends('layouts.guru')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .header-left { display: flex; align-items: center; gap: 15px; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; border: none; }
    .title-area h2 { margin: 0; font-weight: 700; font-size: 1.5rem; }
    .title-area p { margin: 0; color: #555; font-size: 0.9rem; }
    .btn-export { border: 2px solid #0b6b4f; color: #0b6b4f; background: transparent; padding: 8px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px; }

    .info-card { background: white; border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; flex-wrap: wrap; gap: 20px; }
    .info-item { text-align: center; }
    .info-label { font-size: 0.8rem; color: #666; margin-bottom: 5px; display: block; }
    .info-value { font-weight: 700; font-size: 1.1rem; }
    .icon-circle { background-color: #d1f0e5; color: #0b6b4f; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }

    .search-wrapper { display: flex; gap: 10px; margin-bottom: 20px; }
    .search-input { flex: 1; position: relative; }
    .search-input input { width: 100%; padding: 12px 12px 12px 40px; border-radius: 8px; border: 1px solid #ddd; outline: none; }
    .search-input .fa-magnifying-glass { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; }
    .btn-simpan { background-color: #0b6b4f; color: white; border: none; padding: 10px 30px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; gap: 8px; }

    .table-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .table thead th { background-color: #f8f9fa; border-bottom: none; font-weight: 700; text-align: center; padding: 15px; }
    .table tbody td { text-align: center; vertical-align: middle; padding: 12px; font-weight: 500; }
    
    /* Custom Radio Button */
    .custom-radio { appearance: none; width: 20px; height: 20px; border: 2px solid #ccc; border-radius: 50%; outline: none; cursor: pointer; position: relative; }
    .custom-radio:checked { border-color: #0b6b4f; background-color: #0b6b4f; }
    .custom-radio:checked::after { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 8px; height: 8px; background: white; border-radius: 50%; }
    .custom-radio.hadir:checked { border-color: #0b6b4f; background-color: #0b6b4f; }
    .custom-radio.izin:checked { border-color: #f59e0b; background-color: #f59e0b; }
    .custom-radio.sakit:checked { border-color: #ec4899; background-color: #ec4899; }
    .custom-radio.alpha:checked { border-color: #dc2626; background-color: #dc2626; }

    .btn-detail { background-color: #0b6b4f; color: white; border: none; padding: 5px 15px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; }
</style>

<!-- Header -->
<div class="page-header">
    <div class="header-left">
        <a href="{{ url('/guru/jadwal/'.$jadwal->id.'/absensi/'.$pertemuan->id) }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
        <div class="title-area">
            <h2>Absensi Manual</h2>
            <p>Kelola Absensi Santri TQA Darussalam</p>
        </div>
    </div>
    <button type="button" class="btn-export" onclick="window.print()">
    <i class="fa-solid fa-download"></i> Export
</button>
</div>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Info Jadwal -->
<div class="info-card">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-circle"><i class="fa-solid fa-arrow-left"></i></div>
        <div class="info-item text-start">
            <span class="info-label">Kelas</span>
            <span class="info-value">{{ $jadwal->kelas }}</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="icon-circle"><i class="fa-solid fa-book"></i></div>
        <div class="info-item text-start">
            <span class="info-label">Mata Pelajaran</span>
            <span class="info-value">{{ $jadwal->mata_pelajaran }}</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <div class="icon-circle"><i class="fa-regular fa-calendar"></i></div>
        <div class="info-item text-start">
            <span class="info-label">Tanggal</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($pertemuan->tanggal)->isoFormat('D MMM YYYY') }}</span>
        </div>
    </div>
</div>

<form action="{{ url('/guru/jadwal/'.$jadwal->id.'/absensi/'.$pertemuan->id.'/manual') }}" method="POST">
    @csrf
    <!-- Search & Simpan -->
    <div class="search-wrapper">
        <div class="search-input">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="Cari Nama Santri..." onkeyup="filterTable()">
        </div>
        <button type="submit" class="btn-simpan">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Absensi
        </button>
    </div>

    <!-- Tabel Absensi -->
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0">Daftar Absensi Santri</h5>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="hadirSemua" onclick="tandaiHadirSemua()">
                <label class="form-check-label fw-bold" for="hadirSemua">Tandai Hadir Semua</label>
            </div>
        </div>
        <table class="table" id="absensiTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Santri</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santris as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-start fw-bold">{{ $s->nama }}</td>
                        <td>
                            <input type="radio" name="status[{{ $s->id }}]" value="Hadir" class="custom-radio hadir" {{ (isset($absensi[$s->id]) && $absensi[$s->id]->status == 'Hadir') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="radio" name="status[{{ $s->id }}]" value="Izin" class="custom-radio izin" {{ (isset($absensi[$s->id]) && $absensi[$s->id]->status == 'Izin') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="radio" name="status[{{ $s->id }}]" value="Sakit" class="custom-radio sakit" {{ (isset($absensi[$s->id]) && $absensi[$s->id]->status == 'Sakit') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="radio" name="status[{{ $s->id }}]" value="Alfa" class="custom-radio alpha" {{ (isset($absensi[$s->id]) && $absensi[$s->id]->status == 'Alfa') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <button type="button" class="btn-detail">Detail</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Belum ada data santri di kelas ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>

@push('scripts')
<script>
    // Fitur Tandai Hadir Semua
    function tandaiHadirSemua() {
        const checked = document.getElementById('hadirSemua').checked;
        const radios = document.querySelectorAll('.custom-radio.hadir');
        radios.forEach(radio => {
            radio.checked = checked;
        });
    }

    // Fitur Pencarian Nama Santri
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('absensiTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const nama = rows[i].getElementsByTagName('td')[1];
            if (nama) {
                const textValue = nama.textContent || nama.innerText;
                rows[i].style.display = textValue.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }
</script>
@endpush

@endsection