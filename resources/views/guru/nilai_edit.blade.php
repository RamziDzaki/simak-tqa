@extends('layouts.guru')

@section('content')
<style>
    .edit-card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); max-width: 500px; margin: 50px auto; border: 1px solid #e2e8f0; }
    .edit-card h4 { font-weight: 700; margin-bottom: 20px; }
    .edit-card p { margin: 0 0 8px; font-size: 0.9rem; }
    .btn-simpan { background-color: #0b6b4f; color: white; border: none; padding: 10px 25px; border-radius: 8px; font-weight: 600; }
    .btn-batal { background-color: #e2e8f0; color: #333; border: none; padding: 10px 25px; border-radius: 8px; font-weight: 600; text-decoration: none; }
</style>

<div class="edit-card">
    <h4>Edit Nilai</h4>
    
    <p><strong>Santri:</strong> {{ $santri->nama }}</p>
    <p><strong>Kelas:</strong> {{ $jadwal->kelas }}</p>
    <p><strong>Mapel:</strong> {{ $jadwal->mata_pelajaran }}</p>
    <hr>

    <form action="{{ url('/guru/nilai/'.$jadwal->id.'/edit/'.$santri->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Nilai</label>
            <input type="number" name="nilai" class="form-control" min="0" max="100" value="{{ $nilai->nilai ?? '' }}" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ url('/guru/nilai/'.$jadwal->id.'/input') }}" class="btn-batal">Batal</a>
        </div>
    </form>
</div>
@endsection