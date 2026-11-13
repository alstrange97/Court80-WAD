
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Alat Olahraga - COURT 80</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

@php
    $user = Auth::user();
    $isAdmin = $user && $user->role === 'admin';
@endphp

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-retro sticky-top py-3">
    <div class="container px-4">

        <a class="navbar-brand fs-3 text-warning" href="{{ url('/') }}">
            <i class="bi bi-trophy-fill me-2"></i>COURT 80
        </a>

        <button class="navbar-toggler border-neo bg-white text-dark"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-bold align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link active text-white" href="{{ url('/katalog') }}">
                        <i class="bi bi-box-seam me-1"></i>MASTER ALAT
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-warning" href="{{ url('/transaksi') }}">
                        <i class="bi bi-receipt me-1"></i>TRANSAKSI SEWA
                    </a>
                </li>

                @if($user)
                    <li class="nav-item dropdown ms-lg-3">

                        <a class="nav-link dropdown-toggle fw-bold text-warning border-neo px-3 py-1 bg-dark text-decoration-none d-inline-block"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">

                            <i class="bi bi-person-circle me-1"></i>
                            {{ $user->name }}

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end card-retro shadow-neo p-2 mt-2 border-dark border-2">

                            <li>
                                <div class="px-3 py-2 text-muted small fw-bold text-uppercase border-bottom pb-2 mb-2">

                                    @if($isAdmin)
                                        <i class="bi bi-shield-fill-check me-1"></i>
                                        ADMINISTRATOR
                                    @else
                                        <i class="bi bi-person-badge-fill me-1"></i>
                                        STAFF
                                    @endif

                                </div>
                            </li>

                            <li>
                                <form action="{{ url('/logout') }}" method="POST">
                                    @csrf

                                    <button type="submit" class="dropdown-item fw-bold text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        KELUAR (LOGOUT)
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-3">
                        <a href="{{ url('/login') }}" class="btn btn-sm btn-retro-warning fw-bold text-dark px-3 mt-1 mt-lg-0">
                            <i class="bi bi-box-arrow-in-right me-1"></i> LOGIN
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>


<div class="container my-5">

    <!-- ALERT STATUS -->
    @if (session('status') === 'success' || request('status') === 'success')
        <div class="alert alert-success card-retro shadow-neo fw-bold mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            BERHASIL! DATA BARANG BARU TELAH DISIMPAN.
        </div>

    @elseif (session('status') === 'success_edit' || request('status') === 'success_edit')
        <div class="alert alert-warning card-retro shadow-neo fw-bold mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            BERHASIL! DATA BARANG TELAH DIPERBARUI.
        </div>

    @elseif (session('status') === 'success_delete' || request('status') === 'success_delete')
        <div class="alert alert-danger card-retro shadow-neo fw-bold mb-4">
            <i class="bi bi-trash-fill me-2"></i>
            BERHASIL! DATA BARANG TELAH DIHAPUS.
        </div>

    @elseif (session('status') === 'error' || request('status') === 'error')
        <div class="alert alert-danger card-retro shadow-neo fw-bold mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            GAGAL: {{ session('message') ?? request('message') ?? 'Terjadi kesalahan.' }}
        </div>
    @endif


    <!-- VALIDATION ERROR -->
    @if ($errors->any())
        <div class="alert alert-danger card-retro shadow-neo mb-4">
            <strong>GAGAL MENYIMPAN DATA:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- HEADER KATALOG -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div>
            <h2 class="fw-extrabold mb-1" style="color: var(--secondary-navy, #1e293b);">
                PARADE PERLENGKAPAN OLAHRAGA
            </h2>

            <p class="fw-bold mb-0 text-muted">
                Katalog Master Data Rental Alat, Sepatu & Pakaian
            </p>
        </div>

        <button class="btn btn-retro-primary btn-lg shadow-neo"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahAlat">

            <i class="bi bi-plus-square-fill me-2"></i>
            TAMBAH BARANG

        </button>

    </div>


    <!-- FILTER -->
    <form method="GET" action="{{ url('/katalog') }}" class="card card-retro shadow-neo p-3 mb-5">

        <div class="row g-3">

            <div class="col-md-4">
                <div class="input-group">

                    <span class="input-group-text fw-bold">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="CARI NAMA BARANG..."
                           value="{{ $filter_search ?? '' }}"
                           onchange="this.form.submit()">

                </div>
            </div>


            <div class="col-md-4">
                <div class="input-group">

                    <label class="input-group-text fw-bold">
                        <i class="bi bi-dribbble me-1"></i>SPORT
                    </label>

                    <select name="sport"
                            class="form-select fw-bold"
                            onchange="this.form.submit()">

                        <option value="all">SEMUA OLAHRAGA</option>

                        @foreach ($sportsList as $sport)
                            <option value="{{ $sport->slug }}"
                                {{ ($filter_sport ?? 'all') == $sport->slug ? 'selected' : '' }}>
                                {{ strtoupper($sport->name) }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>


            <div class="col-md-4">
                <div class="input-group">

                    <label class="input-group-text fw-bold">
                        <i class="bi bi-tags-fill me-1"></i>KATEGORI
                    </label>

                    <select name="category"
                            class="form-select fw-bold"
                            onchange="this.form.submit()">

                        <option value="all">SEMUA KATEGORI</option>

                        @foreach ($categoriesList as $cat)
                            <option value="{{ $cat->slug }}"
                                {{ ($filter_category ?? 'all') == $cat->slug ? 'selected' : '' }}>
                                {{ strtoupper($cat->name) }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

        </div>
    </form>


    <!-- KATALOG BARANG -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

        @forelse ($equipments as $item)

            <div class="col">
                <div class="card card-retro shadow-neo h-100">

                    <img src="{{ $item->image_url ?: 'https://via.placeholder.com/300x180/FF6B35/111827?text=NO+IMAGE' }}"
                         class="card-img-top"
                         alt="{{ $item->name }}">

                    <div class="card-body">

                        <div class="d-flex gap-1 mb-2">

                            <span class="badge badge-retro-sport">
                                {{ strtoupper($item->sport->name ?? '-') }}
                            </span>

                            <span class="badge badge-retro-category">
                                {{ strtoupper($item->category->name ?? '-') }}
                            </span>

                        </div>

                        <h5 class="card-title fw-bold text-uppercase mb-2">
                            {{ $item->name }}
                        </h5>

                        <p class="fs-5 fw-extrabold mb-1" style="color: var(--primary-orange, #ff6b35);">

                            Rp {{ number_format($item->rental_rate, 0, ',', '.') }}

                            <span class="fs-6 text-dark fw-bold">
                                / {{ strtoupper($item->unit_type) }}
                            </span>

                        </p>

                        <span class="badge bg-white text-dark border-neo fw-bold">
                            STOK: {{ $item->stock }}
                        </span>

                    </div>


                    <!-- TOMBOL AKSI -->
                    <div class="card-footer bg-white border-top-0 d-flex gap-2 pb-3 pt-0">

                        <!-- EDIT: ADMIN DAN STAFF -->
                        <button type="button"
                                class="btn btn-sm btn-retro-warning w-100 btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditAlat"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}"
                                data-sport="{{ $item->sport_id }}"
                                data-category="{{ $item->category_id }}"
                                data-rate="{{ $item->rental_rate }}"
                                data-unit="{{ $item->unit_type }}"
                                data-stock="{{ $item->stock }}"
                                data-image="{{ $item->image_url }}">

                            <i class="bi bi-pencil-fill"></i> EDIT

                        </button>


                        <!-- HAPUS: ADMIN SAJA -->
                        @if($isAdmin)

                            <button type="button"
                                    class="btn btn-sm btn-retro-danger w-100 btn-delete"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHapusAlat"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}">

                                <i class="bi bi-trash-fill"></i> HAPUS

                            </button>

                        @endif

                    </div>
                </div>
            </div>

        @empty

            <div class="col-12 text-center py-5">
                <h4 class="fw-bold text-muted">BARANG TIDAK DITEMUKAN</h4>
                <p>Coba ganti kata kunci atau pilihan filter kamu.</p>
            </div>

        @endforelse

    </div>
</div>


<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambahAlat" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-bottom border-3 border-dark"
                 style="background-color: var(--accent-yellow, #ECA72C);">

                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-square-fill me-2"></i>TAMBAH ALAT OLAHRAGA
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>


            <form action="{{ url('/tambah') }}" method="POST">
                @csrf

                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label class="form-label fw-bold">NAMA BARANG / PERALATAN</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Contoh: Raket Tenis Wilson"
                               required>
                    </div>


                    <div class="row g-3 mb-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">CABANG OLAHRAGA</label>

                            <select name="sport_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Sport --</option>

                                @foreach ($sportsList as $sport)
                                    <option value="{{ $sport->id }}">
                                        {{ strtoupper($sport->name) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label fw-bold">KATEGORI</label>

                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>

                                @foreach ($categoriesList as $cat)
                                    <option value="{{ $cat->id }}">
                                        {{ strtoupper($cat->name) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>


                    <div class="row g-3 mb-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">HARGA SEWA (Rp)</label>

                            <input type="number"
                                   name="rental_rate"
                                   class="form-control"
                                   placeholder="50000"
                                   min="0"
                                   step="1000"
                                   required>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label fw-bold">SATUAN SEWA</label>

                            <select name="unit_type" class="form-select" required>
                                <option value="hari" selected>HARI</option>
                                <option value="jam">JAM</option>
                                <option value="sesi">SESI</option>
                            </select>
                        </div>

                    </div>


                    <div class="mb-3">
                        <label class="form-label fw-bold">STOK AWAL</label>

                        <input type="number"
                               name="stock"
                               class="form-control"
                               placeholder="10"
                               min="0"
                               value="1"
                               required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label fw-bold">URL GAMBAR (OPSIONAL)</label>

                        <input type="url"
                               name="image_url"
                               class="form-control"
                               placeholder="https://images.unsplash.com/...">
                    </div>

                </div>


                <div class="modal-footer border-top border-3 border-dark justify-content-between">

                    <button type="button" class="btn btn-retro-danger" data-bs-dismiss="modal">
                        BATAL
                    </button>

                    <button type="submit" class="btn btn-retro-primary px-4">
                        <i class="bi bi-save-fill me-1"></i> SIMPAN BARANG
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>


<!-- MODAL EDIT: ADMIN DAN STAFF -->
<div class="modal fade" id="modalEditAlat" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-bottom border-3 border-dark"
                 style="background-color: var(--primary-orange, #FF6B35); color: #fff;">

                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>EDIT ALAT OLAHRAGA
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>

            </div>


            <form action="{{ url('/edit') }}" method="POST">
                @csrf

                <input type="hidden" name="id" id="edit_id">

                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label class="form-label fw-bold">NAMA BARANG / PERALATAN</label>

                        <input type="text"
                               name="name"
                               id="edit_name"
                               class="form-control"
                               required>
                    </div>


                    <div class="row g-3 mb-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">CABANG OLAHRAGA</label>

                            <select name="sport_id" id="edit_sport_id" class="form-select" required>

                                @foreach ($sportsList as $sport)
                                    <option value="{{ $sport->id }}">
                                        {{ strtoupper($sport->name) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label fw-bold">KATEGORI</label>

                            <select name="category_id" id="edit_category_id" class="form-select" required>

                                @foreach ($categoriesList as $cat)
                                    <option value="{{ $cat->id }}">
                                        {{ strtoupper($cat->name) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>


                    <div class="row g-3 mb-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">HARGA SEWA (Rp)</label>

                            <input type="number"
                                   name="rental_rate"
                                   id="edit_rental_rate"
                                   class="form-control"
                                   min="0"
                                   step="1000"
                                   required>
                        </div>


                        <div class="col-md-6">
                            <label class="form-label fw-bold">SATUAN SEWA</label>

                            <select name="unit_type"
                                    id="edit_unit_type"
                                    class="form-select"
                                    required>

                                <option value="hari">HARI</option>
                                <option value="jam">JAM</option>
                                <option value="sesi">SESI</option>

                            </select>
                        </div>

                    </div>


                    <div class="mb-3">
                        <label class="form-label fw-bold">STOK</label>

                        <input type="number"
                               name="stock"
                               id="edit_stock"
                               class="form-control"
                               min="0"
                               required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label fw-bold">URL GAMBAR</label>

                        <input type="url"
                               name="image_url"
                               id="edit_image_url"
                               class="form-control">
                    </div>

                </div>


                <div class="modal-footer border-top border-3 border-dark justify-content-between">

                    <button type="button" class="btn btn-retro-danger" data-bs-dismiss="modal">
                        BATAL
                    </button>

                    <button type="submit" class="btn btn-retro-primary px-4">
                        <i class="bi bi-check-lg me-1"></i> UPDATE BARANG
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>


<!-- MODAL HAPUS: ADMIN SAJA -->
@if($isAdmin)

<div class="modal fade" id="modalHapusAlat" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <div class="modal-header border-bottom border-3 border-dark bg-danger text-white">

                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>HAPUS BARANG
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>

            </div>


            <form action="{{ url('/hapus') }}" method="POST">
                @csrf

                <input type="hidden" name="id" id="delete_id">

                <div class="modal-body p-4 text-center">

                    <p class="fw-bold mb-1">
                        Yakin ingin menghapus barang ini?
                    </p>

                    <p class="text-danger fw-extrabold fs-5 mb-0 text-uppercase"
                       id="delete_name"></p>

                </div>


                <div class="modal-footer border-top border-3 border-dark justify-content-between">

                    <button type="button"
                            class="btn btn-retro-primary"
                            data-bs-dismiss="modal">
                        BATAL
                    </button>

                    <button type="submit" class="btn btn-retro-danger">
                        <i class="bi bi-trash-fill me-1"></i> YA, HAPUS
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>

@endif


<!-- JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // MENGISI FORM EDIT
    document.querySelectorAll('.btn-edit').forEach(button => {

        button.addEventListener('click', function () {

            document.getElementById('edit_id').value = this.dataset.id;
            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_sport_id').value = this.dataset.sport;
            document.getElementById('edit_category_id').value = this.dataset.category;
            document.getElementById('edit_rental_rate').value = this.dataset.rate;
            document.getElementById('edit_unit_type').value = this.dataset.unit;
            document.getElementById('edit_stock').value = this.dataset.stock;
            document.getElementById('edit_image_url').value = this.dataset.image || '';

        });

    });


    // MENGISI FORM HAPUS (ADMIN SAJA)
    document.querySelectorAll('.btn-delete').forEach(button => {

        button.addEventListener('click', function () {

            document.getElementById('delete_id').value = this.dataset.id;
            document.getElementById('delete_name').textContent = this.dataset.name;

        });

    });

});
</script>

</body>
</html>
