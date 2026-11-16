@extends('layouts.guru')

@section('content')
<style>
    .header-info { background: white; border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
    .header-info .item { text-align: center; }
    .header-info .item .label { font-size: 0.85rem; color: #666; }
    .header-info .item .value { font-weight: 700; font-size: 1.1rem; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; text-decoration: none; }

    .pilih-card { background: white; border-radius: 16px; padding: 40px 20px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 2px solid #e2e8f0; transition: 0.3s; }
    .pilih-card:hover { border-color: #0b6b4f; transform: translateY(-5px); }
    .pilih-icon { font-size: 5rem; color: #0b6b4f; margin-bottom: 20px; }
    .pilih-title { font-weight: 700; margin-bottom: 10px; }
    .pilih-desc { color: #666; margin-bottom: 20px; font-size: 0.9rem; }
    .btn-pilih { background-color: #0b6b4f; color: white; padding: 12px 30px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; }
</style>

<div class="header-info">
    <a href="{{ url('/guru/jadwal/'.$jadwal->id.'/pertemuan') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="item">
        <div class="label">Kelas</div>
        <div class="value">{{ $jadwal->kelas }}</div>
    </div>
    <div class="item">
        <div class="label">Mata Pelajaran</div>
        <div class="value">{{ $jadwal->mata_pelajaran }}</div>
    </div>
    <div class="item">
        <div class="label">Tanggal</div>
        <div class="value">{{ \Carbon\Carbon::parse($pertemuan->tanggal)->isoFormat('D MMM YYYY') }}</div>
    </div>
</div>

<div class="row justify-content-center mt-5">
    <div class="col-md-5 mb-4">
        <div class="pilih-card">
            <div class="pilih-icon"><i class="fa-solid fa-qrcode"></i></div>
            <h4 class="pilih-title">Absensi QR CODE</h4>
            <p class="pilih-desc">Scan QR Code Santri untuk melakukan Absensi</p>
            <a href="{{ url('/guru/jadwal/'.$jadwal->id.'/absensi/'.$pertemuan->id.'/scan') }}" class="btn-pilih">Mulai Scan</a>
        </div>
    </div>
    <div class="col-md-5 mb-4">
        <div class="pilih-card">
            <div class="pilih-icon"><i class="fa-solid fa-user-plus"></i></div>
            <h4 class="pilih-title">Absensi Manual</h4>
            <p class="pilih-desc">Input kehadiran santri secara manual</p>
            <a href="{{ url('/guru/jadwal/'.$jadwal->id.'/absensi/'.$pertemuan->id.'/manual') }}" class="btn-pilih">Input Manual</a>
        </div>
    </div>
</div>

@endsection