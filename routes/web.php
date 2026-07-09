<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkUjianController;
use App\Http\Controllers\SkPembimbingController;
use App\Http\Controllers\PortalMahasiswaController;
use App\Http\Controllers\FebiAuthController;
use App\Http\Controllers\InternalDashboardController;

/*
|--------------------------------------------------------------------------
| A. PORTAL MAHASISWA (PUBLIK)
|--------------------------------------------------------------------------
| Rute ini dapat diakses oleh siapa saja tanpa perlu login.
*/

// Halaman Utama Antrean
Route::get('/', [PortalMahasiswaController::class, 'index'])->name('portal.index');

// Grup Form Pendaftaran SK Pembimbing
Route::controller(SkPembimbingController::class)->prefix('sk-pembimbing')->name('sk-pembimbing.')->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
});

// Grup Form Pendaftaran SK Ujian
Route::controller(SkUjianController::class)->prefix('sk-ujian')->name('sk-ujian.')->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::get('/cek-nim/{nim}', 'cekNim')->name('cek-nim');
    Route::post('/store', 'store')->name('store');
});


/*
|--------------------------------------------------------------------------
| B. PANEL INTERNAL KAMPUS (ADMIN PRODI & WADEK 1)
|--------------------------------------------------------------------------
| Semua rute di dalam grup ini memiliki prefix '/febi'
*/

Route::prefix('febi')->group(function () {

    // 1. Jalur Autentikasi (Akses sebelum login)
    Route::controller(FebiAuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('febi.login');
        Route::post('/login', 'login')->name('febi.login.proses');
        Route::post('/logout', 'logout')->name('febi.logout');
    });

    // 2. Jalur Terlindungi (Wajib Login & Cek Peran)
    Route::middleware(['auth', 'cek_peran:admin_prodi,wadek_1'])
        ->controller(InternalDashboardController::class)
        ->group(function () {

            // ==========================================
            // Dashboard & Laporan
            // ==========================================
            Route::get('/dashboard', 'index')->name('internal.dashboard');
            Route::get('/wadek/riwayat', 'riwayatWadek')->name('internal.wadek.riwayat');
            Route::get('/internal/dosen', 'monitoringDosen')->name('internal.dosen.monitoring');

            // ==========================================
            // Aksi Kelola SK Pembimbing
            // ==========================================
            Route::patch('/validasi-sk-pembimbing/prodi/{id}', 'prosesProdi')->name('validasi.sk-pembimbing.prodi');
            Route::patch('/validasi-sk-pembimbing/wadek/{id}', 'prosesWadek')->name('validasi.sk-pembimbing.wadek');
            Route::patch('/tolak-sk-pembimbing/{id}', 'tolakWadek')->name('validasi.sk-pembimbing.tolak');
            Route::delete('/pengajuan-sk-pembimbing/{id}', 'hapusPengajuan')->name('internal.pengajuan.destroy');

            // ==========================================
            // Aksi Kelola SK Ujian
            // ==========================================
            Route::patch('/validasi-sk-ujian/prodi/{id}', 'prosesUjianProdi')->name('validasi.sk-ujian.prodi');
            Route::patch('/validasi-sk-ujian/wadek/{id}', 'prosesUjianWadek')->name('validasi.sk-ujian.wadek');
            Route::patch('/tolak-sk-ujian/{id}', 'tolakUjianWadek')->name('validasi.sk-ujian.tolak');
            Route::delete('/pengajuan-sk-ujian/{id}', 'hapusPengajuanUjian')->name('internal.pengajuan-ujian.destroy');
            Route::get('/internal/ujian', 'monitoringUjian')->name('internal.ujian.monitoring');
        });
});
