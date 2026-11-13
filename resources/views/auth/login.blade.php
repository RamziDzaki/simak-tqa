<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMAK TQA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: #ffffff; }

        /* Bagian Kiri: Gambar Masjid */
        .bg-image {
            background-image: url('https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=1000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            padding-top: 50px;
        }
        
        .bg-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0) 40%);
            z-index: 1;
        }

        .logo-container { position: relative; z-index: 2; text-align: center; color: #0b6b4f; }
        .logo-container h1 { font-size: 2rem; font-weight: 700; margin: 0; line-height: 1; }
        .logo-container p { font-size: 1.1rem; font-weight: 600; margin: 0; }
        .logo-container .tagline { font-size: 0.9rem; font-weight: 500; margin-top: 10px; }

        /* Bagian Kanan: Form Login */
        .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px; }
        .login-form { width: 100%; max-width: 400px; }
        
        .login-form h2 { color: #0b6b4f; font-weight: 700; font-size: 2.2rem; margin-bottom: 10px; }
        .login-form .subtitle { font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 30px; line-height: 1.5; }

        .form-label { font-weight: 500; color: #0b6b4f; }
        .input-group-text { background-color: #fff; border-right: none; color: #555; }
        .form-control { border-left: none; padding-left: 0; }
        .form-control:focus { box-shadow: none; border-color: #ced4da; }
        .input-group:focus-within { box-shadow: 0 0 0 0.25rem rgba(11, 107, 79, 0.25); border-radius: 0.375rem; }

        .btn-login { background-color: #0b6b4f; color: white; font-weight: 600; padding: 12px; border-radius: 8px; border: none; transition: 0.3s; }
        .btn-login:hover { background-color: #08523c; color: white; }

        .divider { display: flex; align-items: center; text-align: center; margin: 20px 0; color: #888; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid #ddd; }
        .divider:not(:empty)::before { margin-right: .25em; }
        .divider:not(:empty)::after { margin-left: .25em; }

        .btn-google { background-color: #fff; border: 1px solid #ddd; color: #333; font-weight: 500; padding: 12px; border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; }
        .btn-google:hover { background-color: #f8f9fa; }
        .footer-text { font-size: 0.85rem; color: #888; text-align: center; margin-top: 40px; }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- KIRI: Gambar & Logo -->
            <div class="col-md-6 d-none d-md-block">
                <div class="bg-image">
                    <div class="bg-overlay"></div>
                    <div class="logo-container">
                        <i class="fa-solid fa-mosque" style="font-size: 4rem; margin-bottom: 10px;"></i>
                        <h1>TQA</h1>
                        <p>Darussalam</p>
                        <div class="tagline">Ilmu • Akhlak • Prestasi</div>
                    </div>
                </div>
            </div>

            <!-- KANAN: Form Login -->
            <div class="col-md-6">
                <div class="login-container">
                    <div class="login-form">
                        <h2>Selamat Datang</h2>
                        <p class="subtitle">Silahkan Login untuk mengakses<br>Sistem Informasi Akademik TQA Darussalam</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form action="{{ url('/login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email..." required>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                    <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Masukkan Password..." required>
                                    <span class="input-group-text" style="cursor: pointer; border-left: none;" onclick="togglePassword()">
                                        <i class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="text-end mb-4">
                                <a href="#" class="text-decoration-none" style="color: #0b6b4f; font-size: 0.9rem;">Lupa Password?</a>
                            </div>

                            <button type="submit" class="btn btn-login w-100 mb-3">Login</button>
                            
                            <div class="divider">atau</div>

                            <button type="button" class="btn btn-google w-100 mb-4">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google" width="20">
                                Login dengan Google
                            </button>

                            <div class="text-center mb-4">
                                <span style="font-size: 0.9rem;">Belum punya Akun? <a href="{{ url('/register') }}" class="text-decoration-none" style="color: #0b6b4f; font-weight: 600;">Daftar sekarang</a></span>
                            </div>

                            <div class="footer-text">
                                <i class="fa-solid fa-shield-halved"></i> Akun Anda aman bersama Kami
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("passwordInput");
            var toggleIcon = document.getElementById("toggleIcon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>
</html>