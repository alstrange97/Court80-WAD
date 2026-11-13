<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COURT 80 - Transaksi Sewa</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

    <!-- Navbar Header -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-retro sticky-top py-3">
        <div class="container px-4">
            <a class="navbar-brand fs-3 text-warning" href="{{ url('/') }}">
                <i class="bi bi-trophy-fill me-2"></i>COURT 80
            </a>
            <button class="navbar-toggler border-neo bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-bold">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/katalog') }}">
                            <i class="bi bi-box-seam me-1"></i>MASTER ALAT
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-warning" href="{{ url('/transaksi') }}">
                            <i class="bi bi-receipt me-1"></i>TRANSAKSI SEWA
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container my-5">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-extrabold mb-1" style="color: var(--secondary-navy);">TRANSAKSI SEWA ALAT</h2>
                <p class="fw-bold mb-0 text-muted">Kelola Pemesanan & Pengembalian Perlengkapan Olahraga</p>
            </div>
            <button class="btn btn-retro-primary btn-lg shadow-neo" data-bs-toggle="modal" data-bs-target="#modalTambahSewa">
                <i class="bi bi-plus-square-fill me-2"></i>BUAT SEWA BARU
            </button>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ url('/transaksi') }}" class="card card-retro shadow-neo p-3 mb-5">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text fw-bold"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="CARI NAMA / NO TELP PENYEWA..." value="{{ $filter_search }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <label class="input-group-text fw-bold" for="filterStatus"><i class="bi bi-funnel-fill me-1"></i>STATUS</label>
                        <select class="form-select fw-bold" id="filterStatus" name="status" onchange="this.form.submit()">
                            <option value="all" {{ $filter_status === 'all' ? 'selected' : '' }}>SEMUA STATUS</option>
                            <option value="ACTIVE" {{ $filter_status === 'ACTIVE' ? 'selected' : '' }}>ACTIVE (BERLANGSUNG)</option>
                            <option value="COMPLETED" {{ $filter_status === 'COMPLETED' ? 'selected' : '' }}>COMPLETED (SELESAI)</option>
                            <option value="CANCELLED" {{ $filter_status === 'CANCELLED' ? 'selected' : '' }}>CANCELLED (BATAL)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-retro-warning w-100 fw-bold"><i class="bi bi-filter"></i> FILTER</button>
                </div>
            </div>
        </form>

        <!-- List Transaksi Table -->
        <div class="card card-retro shadow-neo p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle border-dark">
                    <thead class="table-warning border-dark border-3">
                        <tr>
                            <th class="fw-extrabold">ID SEWA</th>
                            <th class="fw-extrabold">PENYEWA</th>
                            <th class="fw-extrabold">WAKTU SEWA</th>
                            <th class="fw-extrabold">DURASI</th>
                            <th class="fw-extrabold">TOTAL</th>
                            <th class="fw-extrabold">STATUS</th>
                            <th class="fw-extrabold text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($rentals))
                            <tr>
                                <td colspan="7" class="text-center py-4 fw-bold text-muted">Belum ada data transaksi sewa.</td>
                            </tr>
                        @else
                            @foreach ($rentals as $rent)
                                <tr>
                                    <td class="fw-extrabold">#TRX-{{ str_pad($rent['id'], 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div class="fw-bold">{{ htmlspecialchars($rent['renter_name']) }}</div>
                                        <small class="text-muted"><i class="bi bi-telephone"></i> {{ htmlspecialchars($rent['renter_phone']) }}</small>
                                    </td>
                                    <td class="fw-bold">{{ date('d M Y, H:i', strtotime($rent['start_time'])) }} WIB</td>
                                    <td class="fw-bold">{{ $rent['duration_hours'] }} Hari/Jam</td>
                                    <td class="fw-extrabold text-danger">Rp {{ number_format($rent['total_amount'], 0, ',', '.') }}</td>
                                    <td>
                                        @if ($rent['status'] === 'ACTIVE')
                                            <span class="badge bg-warning text-dark border-neo fw-bold">ACTIVE</span>
                                        @elseif ($rent['status'] === 'COMPLETED')
                                            <span class="badge bg-success text-white border-neo fw-bold">COMPLETED</span>
                                        @else
                                            <span class="badge bg-danger text-white border-neo fw-bold">CANCELLED</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($rent['status'] === 'ACTIVE')
                                            <form action="{{ url('/transaksi/status') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="rental_id" value="{{ $rent['id'] }}">
                                                <input type="hidden" name="action" value="complete">
                                                <button type="submit" class="btn btn-sm btn-retro-primary fw-bold" onclick="return confirm('Selesaikan transaksi sewa ini?')">
                                                    <i class="bi bi-check-circle-fill"></i> SELESAI
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary border-neo fw-bold" disabled>-</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Tambah Sewa -->
    <div class="modal fade" id="modalTambahSewa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content card-retro">
                <div class="modal-header border-bottom border-dark border-3 bg-warning">
                    <h4 class="modal-title fw-extrabold text-dark"><i class="bi bi-plus-circle-fill me-2"></i>TRANSAKSI SEWA BARU</h4>
                    <button type="button" class="btn-close border-neo bg-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('/transaksi/tambah') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NAMA PENYEWA</label>
                                <input type="text" name="renter_name" class="form-control" placeholder="Contoh: Budi Santoso" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NO. TELEPON / WA</label>
                                <input type="text" name="renter_phone" class="form-control" placeholder="Contoh: 08123456789" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">PILIH ALAT OLAHRAGA</label>
                                <select name="equipment_id" class="form-select fw-bold" required>
                                    <option value="" disabled selected>-- PILIH BARANG --</option>
                                    @foreach ($equipments as $eq)
                                        <option value="{{ $eq['id'] }}">
                                            {{ htmlspecialchars($eq['name']) }} (Stok: {{ $eq['stock'] }}) - Rp {{ number_format($eq['rental_rate'], 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">DURASI</label>
                                <input type="number" name="duration_hours" class="form-control" min="1" value="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">WAKTU MULAI SEWA</label>
                                <input type="datetime-local" name="start_time" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">JUMLAH BARANG (QTY)</label>
                                <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-dark border-3">
                        <button type="button" class="btn btn-secondary border-neo fw-bold" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-retro-primary"><i class="bi bi-save-fill me-1"></i>PROSES SEWA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Identitas Mahasiswa -->
    <div class="container">
        <div class="card card-retro shadow-neo p-3 mb-5 text-center bg-warning my-5">
            <div class="fw-extrabold text-dark text-uppercase fs-6">
                <span>NAMA: AISYAH ZULAIKHA</span> 
                <span class="mx-2">|</span> 
                <span>NIM: 102022500006</span> 
                <span class="mx-2">|</span> 
                <span>KELOMPOK: 3</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>