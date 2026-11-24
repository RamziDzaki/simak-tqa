@extends('layouts.guru')

@section('content')
<style>
    .header-card { background: white; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 25px; border: 1px solid #e2e8f0; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; text-decoration: none; }
    .header-info h3 { margin: 0; font-weight: 700; font-size: 1.5rem; }
    .header-info p { margin: 0; font-size: 0.9rem; color: #555; }

    .table-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
    .table thead th { background-color: #f8f9fa; border-bottom: none; font-weight: 700; text-align: center; padding: 15px; }
    .table tbody td { text-align: center; vertical-align: middle; padding: 12px; }
</style>

<div class="header-card">
    <a href="{{ url('/guru/nilai') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-info">
        <h3>{{ $jadwal->kelas }}</h3>
        <p>{{ $jadwal->mata_pelajaran }} - {{ $jadwal->hari }}, {{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-card">
    <h5 class="fw-bold mb-3">Daftar Santri</h5>
    <form action="{{ url('/guru/nilai/'.$jadwal->id.'/input') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Santri</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($santris as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-start">{{ $s->nama }}</td>
                        <td>
                            <input type="number" name="nilai[{{ $s->id }}]" class="form-control text-center" min="0" max="100" placeholder="0-100" style="width: 100px; margin: 0 auto;" value="{{ $nilais[$s->id]->nilai ?? '' }}">
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted">Belum ada data santri.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-success" style="background-color: #0b6b4f; padding: 10px 30px; border-radius: 8px;">
                <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Nilai
            </button>
        </div>
    </form>
</div>

@endsection