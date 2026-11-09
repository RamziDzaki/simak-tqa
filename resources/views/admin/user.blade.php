@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
    .page-header .icon-box { background-color: #d1f0e5; color: #0b6b4f; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.8rem; }
    .page-header h2 { font-weight: 700; margin: 0; font-size: 1.8rem; color: #111; }
    .page-header p { margin: 0; color: #333; font-weight: 500; }
    .top-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    .tab-btn { padding: 10px 25px; border-radius: 8px; font-weight: 600; border: none; transition: 0.3s; text-decoration: none; display: inline-block; }
    .tab-btn.active { background-color: #0b6b4f; color: white; }
    .tab-btn.inactive { background-color: #e2e8f0; color: #333; }
    .btn-tambah { background-color: #0b6b4f; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; text-decoration: none; }
    .table-container { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .table th { background-color: #e6f4f0; font-weight: 700; text-align: center; padding: 15px; color: #111; border-bottom: 2px solid #d1f0e5; font-size: 0.9rem; }
    .table td { text-align: center; vertical-align: middle; font-weight: 600; padding: 15px; font-size: 0.9rem; }
    .badge-aktif { background-color: #d1f0e5; color: #0b6b4f; padding: 8px 20px; border-radius: 6px; font-weight: 600; display: inline-block; }
    .badge-nonaktif { background-color: #fce4c4; color: #b36b00; padding: 8px 20px; border-radius: 6px; font-weight: 600; display: inline-block; }
    .btn-icon { width: 35px; height: 35px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; text-decoration: none; }
    .btn-qr { background-color: #e2e8f0; color: #333; }
    .btn-print { background-color: #e2e8f0; color: #333; }
    .btn-edit { background-color: #fce4c4; color: #b36b00; }
    .btn-delete { background-color: #fee2e2; color: #dc2626; }
</style>

<div class="page-header">
    <div class="icon-box"><i class="fa-solid fa-users"></i></div>
    <div>
        <h2>Kelola User</h2>
        <p>Kelola data santri, guru dan Admin...</p>
    </div>
</div>

<div class="top-actions">
    <div class="d-flex gap-2">
        <a href="{{ url('/admin/user?tab=santri') }}" class="tab-btn {{ $tab == 'santri' ? 'active' : 'inactive' }}"><i class="fa-solid fa-user-group"></i> Santri</a>
        <a href="{{ url('/admin/user?tab=guru') }}" class="tab-btn {{ $tab == 'guru' ? 'active' : 'inactive' }}"><i class="fa-solid fa-chalkboard-user"></i> Guru</a>
        <a href="{{ url('/admin/user?tab=admin') }}" class="tab-btn {{ $tab == 'admin' ? 'active' : 'inactive' }}"><i class="fa-solid fa-user-gear"></i> Admin</a>
    </div>
    <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
        <i class="fa-solid fa-plus"></i> Tambah {{ ucfirst($tab) }}
    </button>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama {{ ucfirst($tab) }}</th>
                @if($tab == 'santri')
                    <th>Kelas</th>
                @else
                    <th>Email</th>
                @endif
                <th>Status</th>
                @if($tab == 'santri')
                    <th>QR Barcode</th>
                @endif
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama ?? $item->name }}</td>
                    @if($tab == 'santri')
                        <td>{{ $item->kelas }}</td>
                    @else
                        <td>{{ $item->email }}</td>
                    @endif
                    <td>
                        <span class="{{ ($item->status ?? 'Aktif') == 'Aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">{{ $item->status ?? 'Aktif' }}</span>
                    </td>
                    @if($tab == 'santri')
                        <td>
                            <button class="btn-icon btn-qr"><i class="fa-solid fa-qrcode"></i></button>
                            <button class="btn-icon btn-print"><i class="fa-solid fa-print"></i></button>
                        </td>
                    @endif
                    <td>
                        <button class="btn-icon btn-edit"><i class="fa-solid fa-pencil"></i></button>
                        <form action="{{ url('/admin/user/'.$item->id.'?tab='.$tab) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Yakin hapus data ini?')"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">Belum ada data {{ $tab }}.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah {{ ucfirst($tab) }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url('/admin/user') }}" method="POST">
          @csrf
          <input type="hidden" name="tab" value="{{ $tab }}">
          <div class="modal-body">
              @if($tab == 'santri')
                  <div class="mb-3">
                      <label class="form-label">Nama Santri</label>
                      <input type="text" name="nama" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Kelas</label>
                      <select name="kelas" class="form-select" required>
                          <option value="Mubtadi'">Mubtadi'</option>
                          <option value="Mutawassit A">Mutawassit A</option>
                          <option value="Mutawassit B">Mutawassit B</option>
                          <option value="Mutqin">Mutqin</option>
                      </select>
                  </div>
              @else
                  <div class="mb-3">
                      <label class="form-label">Nama Lengkap</label>
                      <input type="text" name="name" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Jenis Kelamin</label>
                      <select name="jenis_kelamin" class="form-select">
                          <option value="laki-laki">Laki-laki</option>
                          <option value="perempuan">Perempuan</option>
                      </select>
                  </div>
              @endif
              <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-select">
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

<!-- Bootstrap JS (PENTING AGAR MODAL BISA TERBUKA) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection