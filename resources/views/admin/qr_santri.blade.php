@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h3 class="fw-bold">QR Code Santri</h3>
    <div class="card shadow-sm p-4 mt-4 d-inline-block" style="border: 2px solid #0b6b4f;">
        <h5 class="fw-bold">{{ $santri->nama }}</h5>
        <p class="text-muted">Kelas: {{ $santri->kelas }}</p>
        <div class="mt-3 bg-white p-3 rounded">
            {!! $qrCode !!}
        </div>
        <p class="mt-3 fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">{{ $santri->qr_code }}</p>
    </div>
    <br>
    <a href="#" onclick="window.print()" class="btn btn-success mt-3" style="background-color: #0b6b4f;">
        <i class="fa-solid fa-print"></i> Cetak QR
    </a>
</div>
@endsection