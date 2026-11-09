@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .page-header .icon-box { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.8rem; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }
    .top-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    .tabs { display: flex; gap: 10px; }
    .tab-btn { padding: 10px 25px; border-radius: 8px; font-weight: 600; border: none; transition: 0.3s; text-decoration: none; display: inline-block; }
    .tab-btn.active { background-color: #0b6b4f; color: white; }
    .tab-btn.inactive { background-color: #e2e8f0; color: #333; }
    .search-box { position: relative; flex: 1; min-width: 250px; }
    .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; }
    .search-box input { width: 100%; padding: 10px 10px 10px 40px; border-radius: 8px; border: 1px solid #ddd; outline: none; }
    .btn-tambah { background-color: #0b6b4f; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; text-decoration: none; }
    .table-container { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .table th { background-color: #e6f4f0; font-weight: 700; text-align: center; padding: 15px; color: #111; border-bottom: 2px solid #d1f0e5; font-size: 0.9rem; }
    .table td { text-align: center; vertical-align: middle; font-weight: 600; padding: 15px; font-size: 0.9rem; }
    .badge-tersedia { background-color: #d1f0e5; color: #0b6b4f; padding: 8px 15px; border-radius: 6px; font-weight: 600; display: inline-block; }
    .badge-tidak { background-color: #fee2e2; color: #dc2626; padding: 8px 15px; border-radius: 6px; font-weight: 600; display: inline-block; }
    .btn-icon { width: 35px; height: 35px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; text-decoration: none; }
    .btn-edit { background-color: #fce4c4; color: #b36b00; }
    .btn-delete { background-color: #fee2e2; color: #dc2626; }
</style>

<div class="page-header">
    <div class="icon-box"><i class="fa-solid fa-door-open"></i></div>
    <div>
        <h2>Kelola Kelas</h2>
        <p>Kelola kelas pelajaran TQA Darussalam.</p>
    </div>
</div>

<!-- Tabs -->
<div class="tabs mb-4">
    <a href="#" class="tab-btn active">Kelas</a>
    <a href="#" class="tab-btn inactive">Ruangan</a>
</div>

<div class="top-actions">
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari Kelas...">
    </div>
    <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
        <i class="fa-solid fa-plus"></i> Tambah Kelas
    </button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 20%;">Nama Kelas</th>
                <th style="width: 20%;">Ruangan</th>
                <th style="width: 10%;">Kapasitas</th>
                <th style="width: 15%;">Jumlah Santri</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kelas as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_kelas }}</td>
                    <td>{{ $item->ruangan ?? '-' }}</td>
                    <td>{{ $item->kapasitas }}</td>
                    <td>{{ $item->jumlah_santri }}</td>
                    <td>
                        <span class="{{ $item->status == 'Tersedia' ? 'badge-tersedia' : 'badge-tidak' }}">{{ $item->status }}</span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn-icon btn-edit"><i class="fa-solid fa-pencil"></i></button>
                            <form action="{{ url('/admin/kelas/'.$item->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Yakin hapus kelas ini?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Belum ada data kelas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="tambahKelasModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url('/admin/kelas') }}" method="POST">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">Nama Kelas</label>
                  <input type="text" name="nama_kelas" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Ruangan</label>
                  <input type="text" name="ruangan" class="form-control" placeholder="Contoh: R1 (Dalam Masjid)">
              </div>
              <div class="mb-3">
                  <label class="form-label">Kapasitas</label>
                  <input type="number" name="kapasitas" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-select" required>
                      <option value="Tersedia">Tersedia</option>
                      <option value="Tidak Tersedia">Tidak Tersedia</option>
                  </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success" style="background-color: #0b6b4f;">Simpan</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection