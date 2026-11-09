<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMAK TQA Darussalam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #9e9e9e; margin: 0; overflow-x: hidden; }
        .sidebar { width: 260px; height: 100vh; background-color: #0b6b4f; color: white; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 1000; }
        .sidebar .brand { padding: 20px; display: flex; align-items: center; gap: 15px; font-weight: 600; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar .menu { list-style: none; padding: 0; margin-top: 10px; }
        .sidebar .menu li a, .sidebar .menu li button { display: flex; align-items: center; gap: 15px; padding: 15px 20px; color: white; text-decoration: none; font-weight: 500; transition: 0.3s; background: none; border: none; width: 100%; text-align: left; }
        .sidebar .menu li a:hover, .sidebar .menu li a.active { background-color: #129b74; border-left: 4px solid #fff; }
        .main-content { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background-color: #9e9e9e; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #888; }
        .content-area { padding: 30px; flex: 1; }
        
        /* Custom Modal Style */
        .modal-content { border-radius: 15px; border: 2px solid #0b6b4f; }
        .modal-header { border-bottom: none; justify-content: center; }
        .modal-footer { border-top: none; justify-content: center; gap: 10px; }
        .btn-tidak { background-color: #fce4c4; color: #333; font-weight: 600; padding: 8px 30px; border-radius: 8px; border: none; }
        .btn-ya { background-color: #2563eb; color: white; font-weight: 600; padding: 8px 30px; border-radius: 8px; border: none; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="brand"><i class="fa-solid fa-mosque" style="font-size: 1.5rem;"></i> TQA Darussalam</div>
        <ul class="menu">
            <li><a href="{{ url('/admin/dashboard') }}"><i class="fa-solid fa-border-all"></i> Dashboard</a></li>
            <li><a href="{{ url('/admin/user') }}"><i class="fa-solid fa-users"></i> Kelola User</a></li>
            <li><a href="{{ url('/admin/mata-pelajaran') }}"><i class="fa-solid fa-book"></i> Mata Pelajaran</a></li>
            <li><a href="{{ url('/admin/kelas') }}"><i class="fa-solid fa-door-open"></i> Kelola Kelas</a></li>
            <li><a href="{{ url('/admin/jadwal') }}"><i class="fa-regular fa-calendar-check"></i> Kelola Jadwal</a></li>
            <li><a href="{{ url('/admin/laporan') }}"><i class="fa-solid fa-chart-simple"></i> Laporan</a></li>
            <li>
                <!-- Tombol Logout dengan Modal -->
                <button type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </button>
            </li>
        </ul>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="main-content">
        <div class="topbar">
            <div class="date fw-bold">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
            <div class="user-actions"><i class="fa-regular fa-bell"></i> <span class="fw-bold ms-2">{{ Auth::user()->name }}</span></div>
        </div>
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- MODAL KONFIRMASI LOGOUT -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-4">
                    <h5 class="fw-bold mb-4">Apakah Anda Yakin ingin Keluar ?</h5>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn-tidak" data-bs-dismiss="modal">Tidak</button>
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-ya">Ya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (PENTING) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>