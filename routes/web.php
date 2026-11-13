
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\AuthController;

// ==========================================
// LANDING PAGE
// ==========================================
Route::get('/', [AuthController::class, 'showLanding']);

// ==========================================
// LOGIN & REGISTER
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// ==========================================
// ROUTE YANG MEMBUTUHKAN LOGIN
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // ==========================================
    // ADMIN & STAFF: READ, ADD, EDIT
    // ==========================================
    Route::middleware(['role:admin,staff'])->group(function () {

        // Katalog
        Route::get('/katalog', [EquipmentController::class, 'index']);
        Route::post('/tambah', [EquipmentController::class, 'store']);
        Route::post('/edit', [EquipmentController::class, 'update']);

        // Transaksi
        Route::get('/transaksi', [EquipmentController::class, 'transaksi']);
        Route::post('/transaksi/tambah', [EquipmentController::class, 'storeSewa']);

    });

    // ==========================================
    // ADMIN ONLY
    // ==========================================
    Route::middleware(['role:admin'])->group(function () {

        // Hapus perlengkapan
        Route::post('/hapus', [EquipmentController::class, 'destroy']);

        // Ubah status transaksi
        Route::post('/transaksi/status', [EquipmentController::class, 'updateStatusSewa']);

    });

});
