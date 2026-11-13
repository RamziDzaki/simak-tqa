@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 30px;">
    <h2>Edit Data {{ ucfirst($tab) }}</h2>
</div>

<div class="table-container" style="max-width: 600px;">
    <form action="{{ url('/admin/user/'.$item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="tab" value="{{ $tab }}">

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Lengkap</label>
            <input type="text" name="{{ $tab == 'santri' ? 'nama' : 'name' }}" class="form-control" value="{{ $item->nama ?? $item->name }}" required>
        </div>

        @if($tab == 'santri')
            <div class="mb-3">
                <label class="form-label fw-bold">Kelas</label>
                <select name="kelas" class="form-select" required>
                    <option value="Mubtadi'" {{ $item->kelas == "Mubtadi'" ? 'selected' : '' }}>Mubtadi'</option>
                    <option value="Mutawassit A" {{ $item->kelas == 'Mutawassit A' ? 'selected' : '' }}>Mutawassit A</option>
                    <option value="Mutawassit B" {{ $item->kelas == 'Mutawassit B' ? 'selected' : '' }}>Mutawassit B</option>
                    <option value="Mutqin" {{ $item->kelas == 'Mutqin' ? 'selected' : '' }}>Mutqin</option>
                </select>
            </div>
        @else
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $item->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diganti">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="laki-laki" {{ $item->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ $item->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            @if($tab == 'guru')
                <div class="mb-3">
                    <label class="form-label fw-bold">NIP/NIK</label>
                    <input type="text" name="nip_nik" class="form-control" value="{{ $item->nip_nik }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Mata Pelajaran</label>
                    <select name="mata_pelajaran" class="form-select" required>
                        <option value="Tahsin" {{ $item->mata_pelajaran == 'Tahsin' ? 'selected' : '' }}>Tahsin</option>
                        <option value="Tafsir" {{ $item->mata_pelajaran == 'Tafsir' ? 'selected' : '' }}>Tafsir</option>
                        <option value="Tahfiz" {{ $item->mata_pelajaran == 'Tahfiz' ? 'selected' : '' }}>Tahfiz</option>
                    </select>
                </div>
            @endif
        @endif

        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="status" class="form-select" required>
                <option value="Aktif" {{ ($item->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ ($item->status ?? '') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success" style="background-color: #0b6b4f; border: none;">Update Data</button>
        <a href="{{ url('/admin/user?tab='.$tab) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection