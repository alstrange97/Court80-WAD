<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COURT 80 - Rental Alat & Perlengkapan Olahraga</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    
    <!-- Panggil CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar Header -->
    <!-- Navbar Header -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-retro sticky-top py-3">
        <div class="container px-4">
            <a class="navbar-brand fs-3 text-warning" href="{{ url('/') }}">
                <i class="bi bi-trophy-fill me-2"></i>COURT 80
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                @if (session()->has('user_id'))
                    <span class="text-white fw-bold">Halo, {{ session('user_name') }}</span>
                    <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm fw-bold">LOGOUT</button>
                    </form>
                @else
                 
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-5 my-auto">
        <div class="container px-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="badge badge-retro-category fs-6 mb-3 border-neo shadow-neo">
                        <i class="bi bi-lightning-charge-fill me-1"></i> RETRO ATHLETICS RENTAL SYSTEM
                    </span>
                    <h1 class="display-3 fw-extrabold mb-3 text-uppercase" style="color: var(--secondary-navy);">
                        SEWA ALAT OLAHRAGA <span class="text-warning bg-dark px-2 border-neo">TANPA RIBET!</span>
                    </h1>
                    <p class="fs-5 fw-bold text-muted mb-4">
                        Sistem manajemen rental peralatan, sepatu, dan pakaian olahraga terpadu untuk kawasan lapangan COURT 80. Cepat, transparan, dan lengkap.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @if (session()->has('user_id'))
                            <a href="{{ url('/katalog') }}" class="btn btn-retro-primary btn-lg shadow-neo px-4 py-3 fs-5">
                                <i class="bi bi-box-seam me-2"></i>KELOLA MASTER ALAT
                            </a>
                            <a href="{{ url('/transaksi') }}" class="btn btn-retro-warning btn-lg shadow-neo px-4 py-3 fs-5">
                                <i class="bi bi-receipt me-2"></i>KELOLA TRANSAKSI
                            </a>
                        @else
                            <a href="{{ url('/login') }}" class="btn btn-retro-primary btn-lg shadow-neo px-5 py-3 fs-5">
                               Login
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card card-retro shadow-neo p-4 text-center" style="background-color: var(--accent-yellow);">
                        <div class="bg-white border-neo p-4 mb-3">
                            <i class="bi bi-trophy-fill display-1 text-warning mb-2 d-block"></i>
                            <h2 class="fw-extrabold text-dark mb-0">COURT 80</h2>
                            <p class="fw-bold text-muted mb-0">SPORTS EQUIPMENT RENTAL</p>
                        </div>
                        <div class="row g-2 text-start fw-bold">
                            <div class="col-6">
                                <div class="bg-white border-neo p-2 text-center">
                                    <i class="bi bi-dribbble text-primary fs-4 d-block"></i>
                                    <small>MULTI SPORT</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-white border-neo p-2 text-center">
                                    <i class="bi bi-check-circle-fill text-success fs-4 d-block"></i>
                                    <small>STOK REALTIME</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Identitas Mahasiswa -->
    <footer class="mt-auto py-4">
        <div class="container">
            <div class="card card-retro shadow-neo p-3 text-center bg-warning">
                <div class="fw-extrabold text-dark text-uppercase fs-6">
                    <span>NAMA: AISYAH ZULAIKHA</span> 
                    <span class="mx-2">|</span> 
                    <span>NIM: 102022500006</span> 
                    <span class="mx-2">|</span> 
                    <span>KELOMPOK: 3</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>