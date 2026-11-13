@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="alert alert-success shadow-sm" style="background-color: #d1f0e5; color: #0b6b4f; border: none;">
        <h3 class="fw-bold m-0"><i class="fa-solid fa-hand-wave"></i> Selamat Datang, {{ Auth::user()->name }}!</h3>
        <p class="m-0 mt-2">Anda berhasil login sebagai <strong>Guru</strong>. Silakan pilih menu di sebelah kiri untuk mulai mengajar.</p>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-chalkboard-user" style="font-size: 5rem; color: #ccc;"></i>
                    <h4 class="mt-3 text-muted">Menu Fitur Guru Sedang Disiapkan</h4>
                    <p class="text-muted">Anda akan bisa melihat jadwal, melakukan absensi QR, dan menginput nilai di sini.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection