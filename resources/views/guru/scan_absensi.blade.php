@extends('layouts.guru')

@section('content')
<style>
    .header-info { background: white; border-radius: 12px; padding: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .header-info .item { text-align: center; }
    .header-info .item .label { font-size: 0.75rem; color: #666; }
    .header-info .item .value { font-weight: 700; font-size: 1rem; }
    .btn-back { background-color: #d1f0e5; color: #0b6b4f; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; }

    .scan-card { background: white; border-radius: 16px; padding: 20px; text-align: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
    .scan-title { font-weight: 700; font-size: 1.2rem; }
    .scan-desc { font-size: 0.85rem; color: #555; }
    #reader { width: 100%; border-radius: 12px; overflow: hidden; margin-bottom: 15px; }

    .table-card { background: white; border-radius: 16px; padding: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%; }
    .table thead th { background-color: #f8f9fa; border-bottom: none; font-weight: 700; text-align: center; padding: 10px; }
    .table tbody td { text-align: center; vertical-align: middle; padding: 10px; }
    .badge-status { padding: 5px 10px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; }
</style>

<!-- Library html5-qrcode untuk kamera -->
<script src="https://unpkg.com/html5-qrcode"></script>

<div class="header-info">
    <a href="{{ url('/guru/jadwal/'.$jadwal->id.'/absensi/'.$pertemuan->id) }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="item"><div class="label">Kelas</div><div class="value">{{ $jadwal->kelas }}</div></div>
    <div class="item"><div class="label">Mata Pelajaran</div><div class="value">{{ $jadwal->mata_pelajaran }}</div></div>
    <div class="item"><div class="label">Tanggal</div><div class="value">{{ \Carbon\Carbon::parse($pertemuan->tanggal)->isoFormat('D MMM YYYY') }}</div></div>
</div>

<div class="row">
    <!-- Kolom Scan QR (KAMERA) -->
    <div class="col-md-4 mb-4">
        <div class="scan-card">
            <div id="reader"></div>
            <h5 class="scan-title">Scan QR Code</h5>
            <p class="scan-desc">Arahkan kamera ke Barcode Santri untuk melakukan Absensi</p>
            <div id="scan-result" class="mt-2"></div>
        </div>
    </div>

    <!-- Kolom Hadir -->
    <div class="col-md-4 mb-4">
        <div class="table-card">
            <h6 class="fw-bold mb-3">Teridentifikasi Hadir</h6>
            <table class="table">
                <thead><tr><th>No</th><th>Nama</th><th>Status</th></tr></thead>
                <tbody id="table-hadir">
                    @foreach($absensi->where('status', 'Hadir') as $index => $a)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $a->santri->nama ?? '-' }}</td>
                            <td><span class="badge-status bg-success-subtle text-success">✓ Hadir</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom Tidak Hadir -->
    <div class="col-md-4 mb-4">
        <div class="table-card">
            <h6 class="fw-bold mb-3">Tidak Hadir Hari ini</h6>
            <table class="table">
                <thead><tr><th>No</th><th>Nama</th><th>Status</th></tr></thead>
                <tbody>
                    @php
                        $santriHadir = $absensi->where('status', 'Hadir')->pluck('santri_id')->toArray();
                        $santriTidakHadir = $santris->whereNotIn('id', $santriHadir);
                    @endphp
                    @forelse($santriTidakHadir as $index => $s)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $s->nama }}</td>
                            <td><span class="badge-status bg-danger-subtle text-danger">Alfa</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">Semua santri hadir.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let html5QrCode;
    const pertemuanId = {{ $pertemuan->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.addEventListener('DOMContentLoaded', function() {
        html5QrCode = new Html5Qrcode("reader");
        
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            (decodedText) => {
                handleScan(decodedText);
            },
            (errorMessage) => { /* abaikan */ }
        ).catch(err => {
            document.getElementById('reader').innerHTML = '<div class="alert alert-danger">Kamera tidak dapat diakses: ' + err + '</div>';
        });
    });

    function handleScan(decodedText) {
        html5QrCode.pause();

        fetch('{{ url("/guru/absensi/scan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                qr_code: decodedText,
                pertemuan_id: pertemuanId
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('scan-result').innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'}">${data.message}</div>`;
            setTimeout(() => {
                html5QrCode.resume();
                document.getElementById('scan-result').innerHTML = '';
                // Reload halaman untuk update tabel hadir
                if (data.success) location.reload();
            }, 2000);
        })
        .catch(err => {
            console.error(err);
            html5QrCode.resume();
        });
    }
</script>
@endpush

@endsection