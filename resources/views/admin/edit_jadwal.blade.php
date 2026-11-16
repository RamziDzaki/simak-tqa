@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .back-btn { background-color: #d1f0e5; color: #0b6b4f; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; text-decoration: none; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }

    .form-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 700px; }
    .form-label { font-weight: 600; font-size: 0.9rem; color: #111; margin-bottom: 6px; }
    .form-control, .form-select { border: 1px solid #ddd; border-radius: 8px; padding: 10px 15px; font-weight: 500; }
    .form-control:focus, .form-select:focus { border-color: #0b6b4f; box-shadow: 0 0 0 0.2rem rgba(11,107,79,0.15); }
    .btn-simpan { background-color: #0b6b4f; color: white; border: none; border-radius: 8px; padding: 12px 25px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; }
    .btn-simpan:hover { background-color: #09553f; color: white; }
    .btn-batal { background-color: #e5e7eb; color: #333; border: none; border-radius: 8px; padding: 12px 25px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .btn-batal:hover { background-color: #d1d5db; color: #333; }
</style>

<div class="page-header">
    <a href="{{ url('/admin/jadwal/'.$jadwal->kelas.'/atur') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div>
        <h2>Edit Jadwal</h2>
        <p>Perbarui data jadwal TQA Darussalam</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ url('/admin/jadwal/'.$jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" class="form-control" 
                   value="{{ old('mata_pelajaran', $jadwal->mata_pelajaran) }}" required>
            @error('mata_pelajaran')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Guru Pengajar</label>
            <select name="guru" class="form-select" required>
                @foreach($gurus as $guru)
                    <option value="{{ $guru->name }}" 
                        {{ old('guru', $jadwal->guru) == $guru->name ? 'selected' : '' }}>
                        {{ $guru->name }}
                    </option>
                @endforeach
            </select>
            @error('guru')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Hari</label>
            <select name="hari" class="form-select" required>
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                    <option value="{{ $hari }}" 
                        {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
            @error('hari')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="row">
            <div class="col-6 mb-3">
                <label class="form-label">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" class="form-control" 
                       value="{{ old('waktu_mulai', $jadwal->waktu_mulai) }}" required>
                @error('waktu_mulai')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" class="form-control" 
                       value="{{ old('waktu_selesai', $jadwal->waktu_selesai) }}" required>
                @error('waktu_selesai')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn-simpan">
                <i class="fa-regular fa-floppy-disk"></i> Simpan Perubahan
            </button>
            <a href="{{ url('/admin/jadwal/'.$jadwal->kelas.'/atur') }}" class="btn-batal">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection