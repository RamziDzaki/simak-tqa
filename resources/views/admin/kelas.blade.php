
@extends('layouts.app')

@section('content')

<style>
    :root {
        --simak-green: #0b6b4f;
        --simak-light: #e6f4f0;
        --simak-soft: #d1f0e5;
        --simak-dark: #164e3b;
    }

    .kelas-page {
        padding-bottom: 30px;
    }

    .page-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 28px;
    }

    .page-header .icon-box {
        background: var(--simak-soft);
        color: var(--simak-green);
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 1.6rem;
        flex-shrink: 0;
    }

    .page-header h2 {
        font-weight: 700;
        margin: 0;
        font-size: 1.65rem;
        color: #17221d;
    }

    .page-header p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: .93rem;
    }

    .tabs {
        display: flex;
        gap: 9px;
        margin-bottom: 24px;
    }

    .tab-btn {
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: .2s;
    }

    .tab-btn.active {
        background: var(--simak-green);
        color: white;
    }

    .tab-btn.inactive {
        background: #eef2f1;
        color: #475569;
    }

    .tab-btn.inactive:hover {
        background: var(--simak-soft);
        color: var(--simak-green);
    }

    .top-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
        min-width: 220px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-box input {
        width: 100%;
        padding: 11px 15px 11px 42px;
        border-radius: 9px;
        border: 1px solid #e2e8f0;
        background: white;
        outline: none;
        transition: .2s;
    }

    .search-box input:focus {
        border-color: var(--simak-green);
        box-shadow: 0 0 0 3px rgba(11, 107, 79, .09);
    }

    .btn-tambah {
        background: var(--simak-green);
        color: white;
        padding: 11px 19px;
        border-radius: 9px;
        font-weight: 600;
        border: none;
        text-decoration: none;
        transition: .2s;
    }

    .btn-tambah:hover {
        background: var(--simak-dark);
        color: white;
        transform: translateY(-1px);
    }

    .table-container {
        background: white;
        border-radius: 13px;
        padding: 20px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, .045);
        border: 1px solid #edf0ef;
    }

    .table {
        margin-bottom: 0;
        min-width: 750px;
    }

    .table thead th {
        background: var(--simak-light);
        color: #244d3e;
        font-weight: 700;
        text-align: center;
        padding: 15px 12px;
        border-bottom: 2px solid var(--simak-soft);
        font-size: .85rem;
        white-space: nowrap;
    }

    .table tbody td {
        text-align: center;
        vertical-align: middle;
        padding: 14px 12px;
        font-size: .9rem;
        color: #334155;
    }

    .table tbody tr:hover {
        background: #f8fcfa;
    }

    .badge-tersedia,
    .badge-tidak {
        padding: 7px 12px;
        border-radius: 7px;
        font-size: .78rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-tersedia {
        background: #dcfce7;
        color: #166534;
    }

    .badge-tidak {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: .2s;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #fff1d6;
        color: #a16207;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .empty-state {
        padding: 40px 15px !important;
        color: #94a3b8 !important;
    }

    .empty-state i {
        display: block;
        font-size: 2rem;
        margin-bottom: 10px;
        color: #b8c9c1;
    }

    .modal-content {
        border: none;
        border-radius: 14px;
        overflow: hidden;
    }

    .modal-header {
        background: var(--simak-light);
        border-bottom: 1px solid #d9ebe3;
        padding: 18px 22px;
    }

    .modal-title {
        font-weight: 700;
        color: var(--simak-dark);
    }

    .modal-body {
        padding: 22px;
    }

    .modal-footer {
        padding: 15px 22px;
        background: #fafcfb;
    }

    .form-label {
        font-weight: 600;
        color: #334155;
        font-size: .9rem;
    }

    .form-control,
    .form-select {
        padding: 10px 12px;
        border-radius: 8px;
        border-color: #dce5e0;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--simak-green);
        box-shadow: 0 0 0 3px rgba(11, 107, 79, .09);
    }

    .btn-simpan {
        background: var(--simak-green);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-weight: 600;
    }

    .btn-simpan:hover {
        background: var(--simak-dark);
        color: white;
    }

    .alert {
        border-radius: 9px;
    }

    @media (max-width: 576px) {
        .page-header h2 {
            font-size: 1.35rem;
        }

        .page-header .icon-box {
            width: 50px;
            height: 50px;
        }

        .top-actions {
            align-items: stretch;
        }

        .search-box {
            max-width: 100%;
        }

        .btn-tambah {
            text-align: center;
        }

        .table-container {
            padding: 12px;
        }
    }
</style>

<div class="kelas-page">

    <!-- Header -->
    <div class="page-header">
        <div class="icon-box">
            <i class="fa-solid fa-door-open"></i>
        </div>
        <div>
            <h2>Kelola Kelas</h2>
            <p>Kelola data kelas dan ruangan pelajaran TQA Darussalam.</p>
        </div>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong><i class="fa-solid fa-circle-exclamation me-2"></i>Periksa kembali data yang diisi:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabs -->
    <div class="tabs">
        <a href="{{ url('/admin/kelas') }}" class="tab-btn active">
            <i class="fa-solid fa-users"></i> Kelas
        </a>

        <a href="{{ url('/admin/ruangan') }}" class="tab-btn inactive">
            <i class="fa-solid fa-building"></i> Ruangan
        </a>
    </div>

    <!-- Search dan Tambah -->
    <div class="top-actions">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input
                type="text"
                id="searchKelas"
                placeholder="Cari nama kelas atau ruangan..."
            >
        </div>

        <button
            class="btn-tambah"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#tambahKelasModal"
        >
            <i class="fa-solid fa-plus me-1"></i> Tambah Kelas
        </button>
    </div>

    <!-- Tabel Kelas -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover" id="tabelKelas">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Kelas</th>
                        <th>Ruangan</th>
                        <th>Kapasitas</th>
                        <th>Jumlah Santri</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($kelas as $index => $item)
                        <tr class="baris-kelas">
                            <td>{{ $index + 1 }}</td>

                            <td class="fw-semibold">
                                {{ $item->nama_kelas }}
                            </td>

                            <td>
                                {{ $item->ruangan ?: '-' }}
                            </td>

                            <td>{{ $item->kapasitas }} orang</td>

                            <td>{{ $item->jumlah_santri ?? 0 }} orang</td>

                            <td>
                                @if($item->status == 'Tersedia')
                                    <span class="badge-tersedia">
                                        {{ $item->status }}
                                    </span>
                                @else
                                    <span class="badge-tidak">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a
                                        href="{{ url('/admin/kelas/'.$item->id.'/edit') }}"
                                        class="btn-icon btn-edit"
                                        title="Edit kelas"
                                    >
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>

                                    <form
                                        action="{{ url('/admin/kelas/'.$item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kelas ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-icon btn-delete"
                                            title="Hapus kelas"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state text-center">
                                <i class="fa-solid fa-folder-open"></i>
                                <strong>Belum ada data kelas</strong>
                                <div class="mt-1">
                                    Silakan tambahkan kelas terlebih dahulu.
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="hasilPencarianKosong" style="display:none;">
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            Kelas yang kamu cari tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Tambah Kelas -->
<div
    class="modal fade"
    id="tambahKelasModal"
    tabindex="-1"
    aria-labelledby="judulTambahKelas"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="judulTambahKelas">
                    <i class="fa-solid fa-circle-plus me-2"></i>
                    Tambah Kelas
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Tutup"
                ></button>
            </div>

            <form action="{{ url('/admin/kelas') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input
                            type="text"
                            name="nama_kelas"
                            class="form-control"
                            placeholder="Contoh: Kelas A"
                            value="{{ old('nama_kelas') }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <select name="ruangan" class="form-select">
                            <option value="">-- Pilih Ruangan --</option>

                            @foreach($ruangans as $ruangan)
                                <option
                                    value="{{ $ruangan->nama_ruangan }}"
                                    {{ old('ruangan') == $ruangan->nama_ruangan ? 'selected' : '' }}
                                >
                                    {{ $ruangan->nama_ruangan }}
                                    ({{ $ruangan->status }})
                                </option>
                            @endforeach
                        </select>

                        @if($ruangans->isEmpty())
                            <small class="text-danger d-block mt-2">
                                Belum ada data ruangan. Tambahkan ruangan terlebih dahulu.
                            </small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kapasitas Santri</label>
                        <input
                            type="number"
                            name="kapasitas"
                            class="form-control"
                            placeholder="Contoh: 20"
                            min="1"
                            value="{{ old('kapasitas') }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Ketersediaan</label>
                        <select name="status" class="form-select" required>
                            <option value="Tersedia"
                                {{ old('status', 'Tersedia') == 'Tersedia' ? 'selected' : '' }}>
                                Tersedia
                            </option>

                            <option value="Tidak Tersedia"
                                {{ old('status') == 'Tidak Tersedia' ? 'selected' : '' }}>
                                Tidak Tersedia
                            </option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button type="submit" class="btn-simpan">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Simpan Kelas
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Pencarian kelas
    const searchInput = document.getElementById('searchKelas');
    const rows = document.querySelectorAll('.baris-kelas');
    const emptySearch = document.getElementById('hasilPencarianKosong');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                const match = text.includes(keyword);

                row.style.display = match ? '' : 'none';

                if (match) {
                    visibleCount++;
                }
            });

            if (emptySearch) {
                emptySearch.style.display =
                    (visibleCount === 0 && rows.length > 0) ? '' : 'none';
            }
        });
    }

    // Buka kembali modal jika validasi gagal
    @if($errors->any())
        const modalElement = document.getElementById('tambahKelasModal');

        if (modalElement && window.bootstrap) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    @endif

});
</script>

@endsection
