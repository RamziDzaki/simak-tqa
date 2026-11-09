@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .page-header .icon-box { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.8rem; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }
    .top-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    .search-box { position: relative; flex: 1; min-width: 250px; }
    .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; }
    .search-box input { width: 100%; padding: 10px 10px 10px 40px; border-radius: 8px; border: 1px solid #ddd; outline: none; }
    .btn-tambah { background-color: #0b6b4f; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; text-decoration: none; }
    .table-container { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .table th { background-color: #e6f4f0; font-weight: 700; text-align: center; padding: 15px; color: #111; border-bottom: 2px solid #d1f0e5; font-size: 0.9rem; }
    .table td { text-align: center; vertical-align: middle; font-weight: 600; padding: 15px; font-size: 0.9rem; }
    .badge-aktif { background-color: #d1f0e5; color: #0b6b4f; padding: 8px 20px; border-radius: 6px; font-weight: 600; display: inline-block; }
    .badge-nonaktif { background-color: #fce4c4; color: #b36b00; padding: 8px 20px; border-radius: 6px; font-weight: 600; display: inline-block; }
    .btn-icon { width: 35px; height: 35px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; text-decoration: none; }
    .btn-edit { background-color: #fce4c4; color: #b36b00; }
    .btn-delete { background-color: #fee2e2; color: #dc2626; }
</style>

<div class="page-header">
    <div class="icon-box"><i class="fa-solid fa-book"></i></div>
    <div>
        <h2>Kelola Mata Pelajaran</h2>
        <p>Kelola data mata pelajaran TQA Darussalam.</p>
    </div>
</div>

<div class="top-actions">
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari Mata Pelajaran...">
    </div>
    <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#tambahMapelModal">
        <i class="fa-solid fa-plus"></i> Tambah Mata Pelajaran
    </button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">NO</th>
                <th style="width: 25%;">Nama Mata Pelajaran</th>
                <th style="width: 40%;">Deskripsi</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 10%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mapels as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td style="text-align: left; font-weight: 400;">{{ $item->deskripsi ?? '-' }}</td>
                    <td>
                        <span class="{{ $item->status == 'Aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">{{ $item->status }}</span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn-icon btn-edit"><i class="fa-solid fa-pencil"></i></button>
                            <form action="{{ url('/admin/mata-pelajaran/'.$item->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Yakin hapus data ini?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada data mata pelajaran.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah Mata Pelajaran -->
<div class="modal fade" id="tambahMapelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Mata Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url('/admin/mata-pelajaran') }}" method="POST">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label class="form-label">Nama Mata Pelajaran</label>
                  <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label">Deskripsi</label>
                  <textarea name="deskripsi" class="form-control" rows="3"></textarea>
              </div>
              <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-select" required>
                      <option value="Aktif">Aktif</option>
                      <option value="Nonaktif">Nonaktif</option>
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