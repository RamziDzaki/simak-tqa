<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - SIMAK TQA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }
        .bg-image {
            background-image: url('https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=1000&auto=format&fit=crop'); /* Placeholder gambar masjid */
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            position: relative;
        }
        .bg-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.2); }
        .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px; }
        .login-form { width: 100%; max-width: 450px; }
        .login-form h2 { color: #0b6b4f; font-weight: 700; font-size: 2.2rem; margin-bottom: 10px; }
        .login-form .subtitle { font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 30px; line-height: 1.5; }
        .form-label { font-weight: 500; color: #0b6b4f; }
        .input-group-text { background-color: #fff; border-right: none; color: #555; }
        .form-control { border-left: none; padding-left: 0; }
        .form-control:focus { box-shadow: none; border-color: #ced4da; }
        .input-group:focus-within { box-shadow: 0 0 0 0.25rem rgba(11, 107, 79, 0.25); border-radius: 0.375rem; }
        .btn-daftar { background-color: #0b6b4f; color: white; font-weight: 600; padding: 12px; border-radius: 8px; border: none; transition: 0.3s; }
        .btn-daftar:hover { background-color: #08523c; color: white; }
        .footer-text { font-size: 0.9rem; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Bagian Kiri: Gambar -->
            <div class="col-md-6 d-none d-md-block">
                <div class="bg-image">
                    <div class="bg-overlay"></div>
                </div>
            </div>

            <!-- Bagian Kanan: Form Register -->
            <div class="col-md-6">
                <div class="login-container">
                    <div class="login-form">
                        <h2>Selamat Datang</h2>
                        <p class="subtitle">Silahkan Daftar untuk mengakses<br>Sistem Informasi Akademik TQA Darussalam</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form action="{{ url('/register') }}" method="POST">
                            @csrf
                            
                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Lengkap..." required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email..." required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password..." required>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Masukkan Password..." required>
                                </div>
                            </div>

                            <!-- Syarat & Ketentuan -->
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms" style="font-size: 0.85rem;">
                                    Saya setuju dengan <a href="#" style="color: #0b6b4f;">Syarat & Ketentuan</a> dan <a href="#" style="color: #0b6b4f;">Kebijakan Privasi</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-daftar w-100">Daftar</button>
                        </form>

                        <div class="footer-text">
                            Sudah punya Akun? <a href="{{ url('/login') }}" style="color: #0b6b4f; font-weight: 600;">Login disini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>