@extends('layouts.app')

@section('content')
@php
    $urlBack      = url('/admin/jadwal');
    $urlStore     = url('/admin/jadwal');                          // POST   -> store
    $urlUpdate    = url('/admin/jadwal');                          // PUT    -> {id}
    $urlDestroy   = url('/admin/jadwal');                          // DELETE -> {id}
    $urlGenerate  = url('/admin/jadwal/' . $kelas->id . '/generate-pertemuan'); // POST -> generatePertemuan
    $urlPertemuan = url('/admin/jadwal/' . $kelas->id . '/daftar-pertemuan');

    $totalPertemuan = \App\Models\Pertemuan::whereIn('jadwal_id', $jadwals->pluck('id'))->count();
    $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $jam = fn($t) => str_replace(':', '.', substr($t, 0, 5));
@endphp

<style>
    :root { --hijau: #0b6b4f; --hijau-muda: #d1f0e5; --abu: #64748b; }

    .atur-header { display: flex; align-items: center; gap: 16px; margin-bottom: 22px; }
    .btn-kembali { width: 48px; height: 48px; border-radius: 12px; background: var(--hijau-muda); color: var(--hijau); display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.2rem; }
    .atur-header h2 { margin: 0; font-size: 1.5rem; font-weight: 700; color: #111; }
    .atur-header p { margin: 2px 0 0; font-size: .85rem; color: #333; font-weight: 500; }

    .tab-bar { display: flex; align-items: center; gap: 0; margin-bottom: 16px; flex-wrap: wrap; }
    .tab-bar .tabs { display: flex; }
    .tab-item { padding: 10px 26px; font-size: .85rem; font-weight: 600; text-decoration: none; border-radius: 8px 8px 0 0; }
    .tab-item.aktif { background: var(--hijau); color: #fff; }
    .tab-item.pasif { background: var(--hijau-muda); color: var(--hijau); }
    .tab-bar .btn-simpan { margin-left: auto; background: var(--hijau); color: #fff; border: 0; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: .85rem; text-decoration: none; }

    .kartu { background: #fff; border-radius: 12px; padding: 18px 22px; margin-bottom: 16px; box-shadow: 0 2px 6px rgba(0,0,0,.06); }

    .info-kelas { display: flex; align-items: center; gap: 28px; flex-wrap: wrap; }
    .info-kelas .ikon { width: 52px; height: 52px; border-radius: 12px; background: var(--hijau-muda); color: var(--hijau); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
    .info-kelas .nama strong { display: block; font-size: .95rem; }
    .info-kelas .nama small { color: var(--abu); }
    .info-kelas .guru { flex: 1; min-width: 200px; border-right: 1px solid #e5e7eb; padding-right: 24px; }
    .info-kelas label { font-size: .72rem; color: var(--abu); display: block; margin-bottom: 4px; }
    .info-kelas select { width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 8px 10px; font-size: .85rem; }
    .statistik { display: flex; align-items: center; gap: 12px; }
    .statistik i { color: #111; font-size: 1.1rem; }
    .statistik small { display: block; font-size: .72rem; color: var(--abu); }
    .statistik b { font-size: 1.15rem; }

    .periode h6, .tabel-jadwal h6 { font-weight: 700; margin: 0 0 12px; font-size: 1rem; }
    .periode-grid { display: flex; align-items: flex-end; gap: 18px; flex-wrap: wrap; }
    .periode-grid .field { flex: 1; min-width: 180px; }
    .periode-grid .field.kecil { flex: 0 0 120px; min-width: 100px; }
    .periode-grid label { font-size: .75rem; color: var(--abu); display: block; margin-bottom: 4px; }
    .periode-grid input { width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 9px 10px; font-size: .85rem; }
    .periode-grid .catatan { font-size: .68rem; color: var(--abu); margin-top: 4px; }
    .btn-generate { background: var(--hijau); color: #fff; border: 0; padding: 10px 22px; border-radius: 8px; font-weight: 600; font-size: .85rem; white-space: nowrap; }

    .tabel-jadwal .judul { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .btn-tambah { background: var(--hijau); color: #fff; border: 0; padding: 9px 20px; border-radius: 8px; font-weight: 600; font-size: .85rem; }
    .tabel-jadwal table { width: 100%; border-collapse: collapse; text-align: center; }
    .tabel-jadwal th { background: #e6f3ee; padding: 12px 8px; font-size: .85rem; font-weight: 700; }
    .tabel-jadwal td { padding: 12px 8px; font-size: .85rem; border-bottom: 1px solid #eef0f2; }
    .pill-hari { display: inline-block; padding: 4px 18px; border-radius: 20px; font-size: .72rem; font-weight: 700; background: #fbe4f3; color: #9d2b73; text-transform: uppercase; }
    .pill-hari.h-selasa { background: #e0e7ff; color: #3b4ba8; }
    .pill-hari.h-rabu { background: #dcfce7; color: #166534; }
    .pill-hari.h-kamis { background: #fef3c7; color: #92400e; }
    .pill-hari.h-jumat { background: #cffafe; color: #155e75; }
    .pill-hari.h-sabtu { background: #ffedd5; color: #9a3412; }
    .pill-hari.h-minggu { background: #fee2e2; color: #991b1b; }
    .aksi { display: inline-flex; gap: 8px; }
    .aksi button { width: 34px; height: 34px; border: 0; border-radius: 8px; font-size: .9rem; }
    .btn-edit { background: #fef3c7; color: #d97706; }
    .btn-hapus { background: #fee2e2; color: #dc2626; }
    .kosong { padding: 28px 0; color: var(--abu); font-size: .9rem; }

    .modal-jadwal .modal-content { border-radius: 14px; border: 0; }
    .modal-jadwal .modal-header { background: var(--hijau); color: #fff; border-radius: 14px 14px 0 0; }
    .modal-jadwal .btn-close { filter: invert(1); }
    .modal-jadwal label { font-size: .8rem; font-weight: 600; margin-bottom: 4px; }
    .modal-jadwal .btn-simpan-modal { background: var(--hijau); color: #fff; font-weight: 600; border: 0; }

    @media (max-width: 768px) {
        .info-kelas .guru { border-right: 0; padding-right: 0; }
        .tabel-jadwal { overflow-x: auto; }
    }
</style>

{{-- Header --}}
<div class="atur-header">
    <a href="{{ $urlBack }}" class="btn-kembali" aria-label="Kembali"><i class="fa-solid fa-arrow-left"></i></a>
    <div>
        <h2>Jadwal Kelas {{ ucwords(strtolower($kelas->nama_kelas)) }}</h2>
        <p>Kelola data Jadwal TQA Darussalam</p>
    </div>
</div>

{{-- Notifikasi --}}
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
@endif

{{-- Tab --}}
<div class="tab-bar">
    <div class="tabs">
        <a href="#" class="tab-item aktif">Pengaturan Jadwal</a>
        <a href="{{ $urlPertemuan }}" class="tab-item pasif">Daftar Pertemuan ({{ $totalPertemuan }})</a>
    </div>
    <button type="submit" form="formPeriode" class="btn-simpan"><i class="fa-regular fa-floppy-disk"></i> Simpan Jadwal</button>
</div>

{{-- Info kelas --}}
<div class="kartu info-kelas">
    <div class="ikon"><i class="fa-solid fa-door-open"></i></div>
    <div class="nama">
        <strong>{{ strtoupper($kelas->nama_kelas) }}</strong>
        <small>{{ $kelas->ruangan ?? 'Ruangan belum diatur' }}</small>
    </div>
    <div class="guru">
        <label for="guruDefault">Guru</label>
        <select id="guruDefault">
            @foreach ($gurus as $guru)
                <option value="{{ $guru->name ?? $guru->nama }}">{{ $guru->name ?? $guru->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="statistik">
        <i class="fa-solid fa-users"></i>
        <div><small>Kapasitas</small><b>{{ $kelas->kapasitas ?? 0 }}</b></div>
    </div>
    <div class="statistik">
        <i class="fa-solid fa-user"></i>
        <div><small>Jumlah Santri</small><b>{{ $kelas->jumlah_santri ?? 0 }}</b></div>
    </div>
</div>

{{-- Periode pembelajaran + generate --}}
<form id="formPeriode" action="{{ $urlGenerate }}" method="POST" class="kartu periode">
    @csrf
    <h6>Periode Pembelajaran</h6>
    <div class="periode-grid">
        <div class="field">
            <label for="tgl_mulai">*Tanggal Mulai</label>
            <input type="date" id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required>
        </div>
        <div class="field">
            <label for="tgl_selesai">Tanggal Selesai</label>
            <input type="date" id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai') }}" required>
        </div>
        <div class="field kecil">
            <label for="jumlah_pertemuan">Jumlah Pertemuan</label>
            <input type="number" id="jumlah_pertemuan" name="jumlah_pertemuan" min="1" value="{{ old('jumlah_pertemuan', 16) }}" required>
            <div class="catatan">*Sistem akan membuat pertemuan otomatis.</div>
        </div>
        <button type="submit" class="btn-generate"
                onclick="return confirm('Pertemuan lama pada kelas ini akan diganti. Lanjutkan?')">
            <i class="fa-solid fa-rotate"></i> Generate Jadwal
        </button>
    </div>
</form>

{{-- Jadwal pembelajaran --}}
<div class="kartu tabel-jadwal">
    <div class="judul">
        <h6>Jadwal Pembelajaran</h6>
        <button type="button" class="btn-tambah" id="btnTambah"><i class="fa-solid fa-plus"></i> Tambah Jadwal</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengajar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jadwals as $j)
                <tr>
                    <td><span class="pill-hari h-{{ strtolower($j->hari) }}">{{ $j->hari }}</span></td>
                    <td>{{ $jam($j->waktu_mulai) }} - {{ $jam($j->waktu_selesai) }}</td>
                    <td>{{ $j->mata_pelajaran }}</td>
                    <td>{{ $j->guru }}</td>
                    <td>
                        <div class="aksi">
                            <button type="button" class="btn-edit" title="Ubah"
                                data-id="{{ $j->id }}"
                                data-hari="{{ $j->hari }}"
                                data-mulai="{{ substr($j->waktu_mulai, 0, 5) }}"
                                data-selesai="{{ substr($j->waktu_selesai, 0, 5) }}"
                                data-mapel="{{ $j->mata_pelajaran }}"
                                data-guru="{{ $j->guru }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form action="{{ $urlDestroy }}/{{ $j->id }}" method="POST"
                                  onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="kosong">Belum ada jadwal. Klik "Tambah Jadwal" untuk mulai.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal tambah / ubah --}}
<div class="modal fade modal-jadwal" id="modalJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="formJadwal" method="POST" action="{{ $urlStore }}" class="modal-content">
            @csrf
            <span id="methodSpoof"></span>
            <input type="hidden" name="kelas" value="{{ $kelas->nama_kelas }}">

            <div class="modal-header">
                <h5 class="modal-title" id="judulModal">Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="fHari">Hari</label>
                    <select class="form-select" id="fHari" name="hari" required>
                        @foreach ($hariList as $h) <option value="{{ $h }}">{{ $h }}</option> @endforeach
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="fMulai">Waktu mulai</label>
                        <input type="time" class="form-control" id="fMulai" name="waktu_mulai" required>
                    </div>
                    <div class="col">
                        <label for="fSelesai">Waktu selesai</label>
                        <input type="time" class="form-control" id="fSelesai" name="waktu_selesai" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="fMapel">Mata pelajaran</label>
                    <select class="form-select" id="fMapel" name="mata_pelajaran" required>
                        @foreach ($mapels as $m)
                            <option value="{{ $m->nama ?? $m->nama_mapel }}">{{ $m->nama ?? $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fGuru">Guru pengajar</label>
                    <select class="form-select" id="fGuru" name="guru" required>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->name ?? $guru->nama }}">{{ $guru->name ?? $guru->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-simpan-modal">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('modalJadwal');
        const modal   = new bootstrap.Modal(modalEl);
        const form    = document.getElementById('formJadwal');
        const spoof   = document.getElementById('methodSpoof');
        const judul   = document.getElementById('judulModal');
        const guruDefault = document.getElementById('guruDefault');

        // Tambah: form kosong, guru terisi dari pilihan "Guru" di atas
        document.getElementById('btnTambah').addEventListener('click', function () {
            form.reset();
            form.action = @json($urlStore);
            spoof.innerHTML = '';
            judul.textContent = 'Tambah Jadwal';
            if (guruDefault) document.getElementById('fGuru').value = guruDefault.value;
            modal.show();
        });

        // Ubah: isi form dari data-* pada tombol
        document.querySelectorAll('.btn-edit').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const d = btn.dataset;
                form.action = @json($urlUpdate) + '/' + d.id;
                spoof.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                judul.textContent = 'Ubah Jadwal';
                document.getElementById('fHari').value    = d.hari;
                document.getElementById('fMulai').value   = d.mulai;
                document.getElementById('fSelesai').value = d.selesai;
                document.getElementById('fMapel').value   = d.mapel;
                document.getElementById('fGuru').value    = d.guru;
                modal.show();
            });
        });

        // Tanggal selesai tidak boleh sebelum tanggal mulai
        const mulai = document.getElementById('tgl_mulai');
        const selesai = document.getElementById('tgl_selesai');
        mulai.addEventListener('change', function () { selesai.min = mulai.value; });
    });
</script>
@endsection
