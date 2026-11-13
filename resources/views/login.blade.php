<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - COURT 80</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body class="d-flex align-items-center min-vh-100 py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                
                <div class="mb-3">
                    <a href="{{ url('/') }}" class="btn btn-sm btn-retro-warning fw-bold shadow-neo">
                        <i class="bi bi-arrow-left me-1"></i> KEMBALI KE HALAMAN DEPAN
                    </a>
                </div>

                <div class="card card-retro shadow-neo">
                    <div class="card-header bg-warning text-center border-bottom border-dark border-3 py-3">
                        <h3 class="fw-extrabold mb-0 text-dark">
                            <i class="bi bi-trophy-fill me-2"></i>COURT 80
                        </h3>
                        <small class="fw-bold text-uppercase">Portal Masuk Administrator</small>
                    </div>
                    <div class="card-body p-4">
                        
                        @if (session('error'))
                            <div class="alert alert-danger card-retro shadow-neo fw-bold mb-3">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success card-retro shadow-neo fw-bold mb-3">
                                <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ url('/login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">EMAIL ADMIN</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan username anda" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">PASSWORD</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password anda" required>
                            </div>
                            <button type="submit" class="btn btn-retro-primary w-100 btn-lg shadow-neo fw-bold">
                                <i class="bi bi-box-arrow-in-right me-1"></i> MASUK SISTEM
                            </button>
                            <div class="text-center mt-4">
    <small>Belum punya akun?</small>
    <a href="{{ url('/register') }}" class="fw-bold text-decoration-none">
        Daftar di sini
    </a>
</div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>