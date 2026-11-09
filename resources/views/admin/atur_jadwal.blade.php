@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
    <div class="icon-box" style="background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.8rem;">
        <i class="fa-regular fa-calendar-plus"></i>
    </div>
    <div>
        <h2 style="font-weight: 700; margin: 0; font-size: 1.8rem;">Atur Jadwal: {{ $kelas->nama_kelas }}</h2>
        <p style="margin: 0; color: #333;">Tambahkan jadwal pelajaran untuk kelas ini.</p>
    </div>
</div>

<div class="row">
    <!-- Form Tambah Jadwal -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Tambah Jadwal Baru</div>
            <div class="card-body">
                <form action="{{ url('/admin/jadwal') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kelas" value="{{ $kelas->nama_kelas }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-control" required placeholder="Contoh: Tahsin">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Guru Pengajar</label>
                        <input type="text" name="guru" class="form-control" required placeholder="Contoh: Ust. Rifky">
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
                    <button type="submit" class="btn btn-success w-100" style="background-color: #0b6b4f;">Simpan Jadwal</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Jadwal yang Sudah Ada -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Daftar Jadwal</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwals as $j)
                            <tr>
                                <td>{{ $j->hari }}</td>
                                <td>{{ $j->waktu_mulai }} - {{ $j->waktu_selesai }}</td>
                                <td>{{ $j->mata_pelajaran }}</td>
                                <td>{{ $j->guru }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada jadwal untuk kelas ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{ url('/admin/jadwal') }}" class="btn btn-secondary mt-3"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kelas</a>
    </div>
</div>
@endsection