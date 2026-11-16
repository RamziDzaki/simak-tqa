@extends('layouts.app')

@section('content')
<style>
    .header-custom { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .header-left { display: flex; align-items: center; gap: 15px; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; border: none; }
    .title-area h2 { margin: 0; font-weight: 700; font-size: 1.5rem; }
    .title-area p { margin: 0; color: #555; font-size: 0.9rem; }
    .nav-tabs-custom { border-bottom: none; margin-bottom: 20px; gap: 10px; }
    .nav-tabs-custom .nav-link { border: none; background-color: #e2e8f0; color: #475569; border-radius: 8px; padding: 10px 20px; font-weight: 600; }
    .nav-tabs-custom .nav-link.active { background-color: #0b6b4f; color: white; }
    .info-card { background: white; border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; flex-wrap: wrap; gap: 20px; }
    .info-item { display: flex; flex-direction: column; }
    .info-label { font-size: 0.8rem; color: #666; margin-bottom: 5px; }
    .info-value { font-weight: 700; font-size: 1.1rem; }
    .guru-select { width: 250px; border-radius: 8px; }
    .icon-box-large { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .periode-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }
    .table-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .table-card .table thead th { background-color: #f8f9fa; border-bottom: none; font-weight: 700; text-align: center; }
    .table-card .table tbody td { text-align: center; vertical-align: middle; }
    .btn-edit-custom { background-color: #fef3c7; color: #d97706; border: none; border-radius: 8px; padding: 6px 12px; margin-right: 5px; }
    .btn-hapus-custom { background-color: #fee2e2; color: #dc2626; border: none; border-radius: 8px; padding: 6px 12px; }
</style>

<!-- Header -->
<div class="header-custom">
    <div class="header-left">
        <a href="{{ url('/admin/jadwal') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
        <div class="title-area">
            <h2>Jadwal Kelas {{ $kelas->nama_kelas }}</h2>
            <p>Kelola data Jadwal TQA Darussalam</p>
        </div>
    </div>
    <!-- TAMBAHAN: Tombol Simpan Jadwal -->
    <button type="submit" form="formPeriode" class="btn btn-success" style="background-color: #0b6b4f; padding: 10px 20px; border-radius: 8px; font-weight: 600;">
        <i class="fa-regular fa-floppy-disk me-2"></i> Simpan Jadwal
    </button>
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
        <a class="nav-link active" href="#">Pengaturan Jadwal</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/admin/jadwal/'.$kelas->id.'/daftar-pertemuan') }}">Daftar Pertemuan</a>
    </li>
</ul>

<!-- Card Info Kelas -->
<div class="info-card">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-box-large"><i class="fa-solid fa-door-open"></i></div>
        <div>
            <h5 class="fw-bold mb-1 text-uppercase">{{ $kelas->nama_kelas }}</h5>
            <small class="text-muted">{{ $kelas->ruangan ?? 'R1 (Dalam Masjid)' }}</small>
        </div>
    </div>
    
    <div class="info-item">
        <span class="info-label">Guru</span>
        <select class="form-select guru-select">
            <option selected>Pilih Guru</option>
            @foreach($gurus as $g)
                <option value="{{ $g->name }}">{{ $g->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="info-item text-center">
        <span class="info-label">Kapasitas</span>
        <span class="info-value"><i class="fa-solid fa-users me-1"></i> {{ $kelas->kapasitas }}</span>
    </div>

    <div class="info-item text-center">
        <span class="info-label">Jumlah Santri</span>
        <span class="info-value"><i class="fa-solid fa-user me-1"></i> {{ $kelas->jumlah_santri ?? 0 }}</span>
    </div>
</div>

<!-- Card Periode Pembelajaran (Sudah dibungkus form) -->
<form id="formPeriode" action="{{ url('/admin/jadwal/'.$kelas->id.'/generate-pertemuan') }}" method="POST">
    @csrf
    <div class="periode-card">
        <div class="fw-bold me-3">Periode Pembelajaran</div>
        <div>
            <label class="info-label">Tanggal Mulai</label>
            <input type="text" id="tgl_mulai" name="tgl_mulai" class="form-control" style="width: 220px;" placeholder="Pilih Tanggal" required>
        </div>
        <div>
            <label class="info-label">Tanggal Selesai</label>
            <input type="text" id="tgl_selesai" name="tgl_selesai" class="form-control" style="width: 220px;" placeholder="Pilih Tanggal" required>
        </div>
        <div>
            <label class="info-label">Jumlah Pertemuan</label>
            <input type="number" name="jumlah_pertemuan" class="form-control" style="width: 100px;" value="16" required>
        </div>
        <div class="ms-auto mt-4">
            <button type="submit" class="btn btn-success" style="background-color: #0b6b4f;">
                <i class="fa-solid fa-rotate me-2"></i> Generate Jadwal
            </button>
        </div>
    </div>
</form>

<!-- Card Tabel Jadwal -->
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0">Jadwal Pembelajaran</h5>
        <button class="btn btn-success" style="background-color: #0b6b4f;" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
            <i class="fa-solid fa-plus me-1"></i> Tambah Jadwal
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Waktu</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru Pengajar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwals as $j)
                    <tr>
                        <td><span class="badge bg-light text-dark border px-3 py-2 rounded-pill">{{ strtoupper($j->hari) }}</span></td>
                        <td>{{ $j->waktu_mulai }} - {{ $j->waktu_selesai }}</td>
                        <td>{{ $j->mata_pelajaran }}</td>
                        <td>{{ $j->guru }}</td>
                        <td>
                            <button class="btn-edit-custom btn-edit-jadwal" 
                                    data-id="{{ $j->id }}" 
                                    data-mapel="{{ $j->mata_pelajaran }}" 
                                    data-guru="{{ $j->guru }}" 
                                    data-hari="{{ $j->hari }}" 
                                    data-mulai="{{ $j->waktu_mulai }}" 
                                    data-selesai="{{ $j->waktu_selesai }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditJadwal">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <form action="{{ url('/admin/jadwal/'.$j->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus-custom"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada jadwal untuk kelas ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="modalTambahJadwal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Jadwal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/jadwal') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas" value="{{ $kelas->nama_kelas }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="mata_pelajaran" class="form-select" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach ($mapels as $mapel)
                                <option value="{{ $mapel->nama }}">{{ $mapel->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guru Pengajar</label>
                        <select name="guru" class="form-select" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->name }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <select name="hari" class="form-select" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" style="background-color: #0b6b4f;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Jadwal -->
<div class="modal fade" id="modalEditJadwal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditJadwal" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="mata_pelajaran" id="edit_mapel" class="form-select" required>
                            @foreach ($mapels as $mapel)
                                <option value="{{ $mapel->nama }}">{{ $mapel->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guru Pengajar</label>
                        <select name="guru" id="edit_guru" class="form-select" required>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->name }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <select name="hari" id="edit_hari" class="form-select" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Mulai</label>
                            <input type="time" name="waktu_mulai" id="edit_mulai" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Selesai</label>
                            <input type="time" name="waktu_selesai" id="edit_selesai" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" style="background-color: #0b6b4f;">Update Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Flatpickr
       flatpickr("#tgl_mulai", {
    locale: "id",
    altInput: true,
    altFormat: "l, j F Y", // Tampilan: Rabu, 1 Juli 2026
    dateFormat: "Y-m-d",   // Nilai yang dikirim ke server: 2026-07-01
    defaultDate: "2027-10-12"
});

flatpickr("#tgl_selesai", {
    locale: "id",
    altInput: true,
    altFormat: "l, j F Y",
    dateFormat: "Y-m-d",
    defaultDate: "2028-10-12"
});

        // Script untuk mengisi Modal Edit otomatis
        const editButtons = document.querySelectorAll('.btn-edit-jadwal');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const mapel = this.getAttribute('data-mapel');
                const guru = this.getAttribute('data-guru');
                const hari = this.getAttribute('data-hari');
                const mulai = this.getAttribute('data-mulai');
                const selesai = this.getAttribute('data-selesai');

                document.getElementById('formEditJadwal').action = '/admin/jadwal/' + id;
                document.getElementById('edit_mapel').value = mapel;
                document.getElementById('edit_guru').value = guru;
                document.getElementById('edit_hari').value = hari;
                document.getElementById('edit_mulai').value = mulai;
                document.getElementById('edit_selesai').value = selesai;
            });
        });
    });
</script>
@endpush

@endsection