
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Administrator - COURT 80</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body class="d-flex align-items-center min-vh-100 py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="mb-3">
                <a href="{{ url('/login') }}" class="btn btn-sm btn-retro-warning fw-bold shadow-neo">
                    <i class="bi bi-arrow-left me-1"></i>
                    KEMBALI KE LOGIN
                </a>
            </div>

            <div class="card card-retro shadow-neo">

                <div class="card-header bg-warning text-center border-bottom border-dark border-3 py-3">
                    <h3 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-trophy-fill me-2"></i>COURT 80
                    </h3>
                    <small class="fw-bold text-uppercase">
                        Pendaftaran Administrator
                    </small>
                </div>

                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ url('/register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">NAMA LENGKAP</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('name') }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">EMAIL</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Masukkan email"
                                value="{{ old('email') }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">PASSWORD</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Minimal 8 karakter"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">KONFIRMASI PASSWORD</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-retro-primary w-100 btn-lg shadow-neo fw-bold">
                            <i class="bi bi-person-plus-fill me-1"></i>
                            DAFTAR AKUN
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <small>Sudah punya akun?</small>
                        <a href="{{ url('/login') }}" class="fw-bold text-decoration-none">
                            Login di sini
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
