<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkUjianController;
use App\Http\Controllers\SkPembimbingController;
use App\Http\Controllers\PortalMahasiswaController;
use App\Http\Controllers\FebiAuthController;
use App\Http\Controllers\InternalDashboardController;

// Route untuk menampilkan halaman form
Route::get('/sk-ujian/create', [SkUjianController::class, 'create'])->name('sk-ujian.create');

// Route web standar untuk dicek oleh jQuery AJAX
Route::get('/sk-ujian/cek-nim/{nim}', [SkUjianController::class, 'cekNim'])->name('sk-ujian.cek-nim');


// Halaman form pendaftaran SK Pembimbing
Route::get('/sk-pembimbing/create', [SkPembimbingController::class, 'create'])->name('sk-pembimbing.create');

// Proses submit form (Simpan data & upload file)
Route::post('/sk-pembimbing/store', [SkPembimbingController::class, 'store'])->name('sk-pembimbing.store');

// Route utama yang menampilkan dashboard antrean publik
Route::get('/', [PortalMahasiswaController::class, 'index'])->name('portal.index');

// ==========================================
// GRUP PANEL INTERNAL KAMPUS (PREFIKS: /febi)
// ==========================================
Route::prefix('febi')->group(function () {

    // 1. Jalur Autentikasi Publik Internal (Bisa diakses sebelum login)
    Route::get('/login', [FebiAuthController::class, 'showLogin'])->name('febi.login');
    Route::post('/login', [FebiAuthController::class, 'login'])->name('febi.login.proses');
    Route::post('/logout', [FebiAuthController::class, 'logout'])->name('febi.logout');

    Route::middleware(['auth', 'cek_peran:admin_prodi,wadek_1'])->group(function () {

        // Mengarahkan ke InternalDashboardController
        Route::get('/dashboard', [InternalDashboardController::class, 'index'])->name('internal.dashboard');
    });
});

// Cari bagian ini di routes/web.php kamu dan ubah menjadi:
