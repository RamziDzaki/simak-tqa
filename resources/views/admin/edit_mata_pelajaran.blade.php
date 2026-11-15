@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 30px;">
    <h2>Edit Mata Pelajaran</h2>
</div>

<div class="table-container" style="max-width: 600px;">
    <form action="{{ url('/admin/mata-pelajaran/'.$mapel->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Mata Pelajaran</label>
            <input type="text" name="nama" class="form-control" value="{{ $mapel->nama }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ $mapel->deskripsi }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-select" required>
                <option value="Aktif" {{ $mapel->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ $mapel->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success" style="background-color: #0b6b4f; border: none;">Update Data</button>
        <a href="{{ url('/admin/mata-pelajaran') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection