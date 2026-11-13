@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 30px;">
    <h2>Edit Ruangan</h2>
</div>

<div class="table-container" style="max-width: 600px;">
    <form action="{{ url('/admin/ruangan/'.$ruangan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Ruangan</label>
            <input type="text" name="nama_ruangan" class="form-control" value="{{ $ruangan->nama_ruangan }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="{{ $ruangan->keterangan }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-select" required>
                <option value="Tersedia" {{ $ruangan->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Tidak Tersedia" {{ $ruangan->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success" style="background-color: #0b6b4f; border: none;">Update Data</button>
        <a href="{{ url('/admin/ruangan') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection