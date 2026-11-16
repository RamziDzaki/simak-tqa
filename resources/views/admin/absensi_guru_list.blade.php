@extends('layouts.app')

@section('content')
<style>
    .header-custom { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; border: none; }
    .guru-list-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .guru-list-card .info { display: flex; align-items: center; gap: 20px; }
    .avatar-list { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .btn-lihat { background-color: #0b6b4f; color: white; text-decoration: none; padding: 8px 20px; border-radius: 8px; font-weight: 600; }
</style>

<div class="header-custom">
    <a href="{{ url('/admin/laporan') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <div>
        <h2 style="font-weight: 700; margin: 0; font-size: 1.5rem;">Daftar Guru</h2>
        <p style="margin: 0; color: #555;">Pilih guru untuk melihat detail absensi.</p>
    </div>
</div>

@foreach ($gurus as $guru)
    <div class="guru-list-card">
        <div class="info">
            <div class="avatar-list"><i class="fa-solid fa-user"></i></div>
            <div>
                <h5 class="fw-bold m-0">{{ $guru->name }}</h5>
                <small class="text-muted">NIP: {{ $guru->nip ?? '-' }}</small>
            </div>
        </div>
        <a href="{{ url('/admin/absensi-guru/'.$guru->id.'/detail') }}" class="btn-lihat">Lihat Absensi</a>
    </div>
@endforeach

@endsection