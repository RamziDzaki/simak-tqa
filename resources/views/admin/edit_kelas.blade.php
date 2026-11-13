@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 30px;">
    <h2>Edit Kelas</h2>
</div>

<div class="table-container" style="max-width: 600px;">
    <form action="{{ url('/admin/kelas/'.$kelas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" value="{{ $kelas->nama_kelas }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Ruangan</label>
            <input type="text" name="ruangan" class="form-control" value="{{ $kelas->ruangan }}" placeholder="Contoh: R1 (Dalam Masjid)">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Kapasitas</label>
            <input type="number" name="kapasitas" class="form-control" value="{{ $kelas->kapasitas }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-select" required>
                <option value="Tersedia" {{ $kelas->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Tidak Tersedia" {{ $kelas->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success" style="background-color: #0b6b4f; border: none;">Update Data</button>
        <a href="{{ url('/admin/kelas') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection