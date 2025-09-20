<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelolaSiswaController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\AktivitasSiswaController;
use App\Http\Controllers\LogAdminController;
use App\Http\Controllers\DashboardController; // Admin
use App\Http\Controllers\Siswa\SiswaArtikelController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================
// RUTE UNTUK GUEST (belum login)
// ==========================
Route::middleware(['guest'])->group(function () {
    // Form login tunggal untuk admin dan siswa
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    // Registrasi admin
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register']);

    // Registrasi siswa
    Route::get('/siswa/register', [AdminAuthController::class, 'showRegisterFormSiswa'])->name('register-siswa');
    Route::post('/siswa/register', [AdminAuthController::class, 'registerSiswa']);
});

// ==========================
// RUTE UNTUK ADMIN (sudah login)
// ==========================
Route::middleware(['admin'])->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart/{type}', [DashboardController::class, 'getChartDataAjax'])->name('dashboard.chart');

    // Artikel
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::get('/artikel/{id}/edit-ajax', [ArtikelController::class, 'editAjax'])->name('artikel.edit-ajax');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
    Route::post('/artikel/{id}/rate', [ArtikelController::class, 'rate'])->name('artikel.rate');
    Route::get('/artikel/export', [ArtikelController::class, 'export'])->name('artikel.export');
    Route::get('/admin/search-siswa', [ArtikelController::class, 'searchSiswa'])->name('admin.search.siswa');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/kategori/export', [KategoriController::class, 'export'])->name('kategori.export');
    Route::get('/kategori/{id}/detail', [KategoriController::class, 'detail'])->name('kategori.detail');

    // Penghargaan
    Route::prefix('penghargaan')->group(function () {
        Route::get('/', [PenghargaanController::class, 'index'])->name('penghargaan');
        Route::get('penghargaan/create', [PenghargaanController::class, 'create'])->name('penghargaan.create');
        Route::post('/', [PenghargaanController::class, 'store'])->name('penghargaan.store');
        Route::get('/{id}', [PenghargaanController::class, 'show'])->name('penghargaan.show');
        Route::get('/{id}/edit', [PenghargaanController::class, 'edit'])->name('penghargaan.edit');
        Route::put('/{id}', [PenghargaanController::class, 'update'])->name('penghargaan.update');
        Route::delete('/{id}', [PenghargaanController::class, 'destroy'])->name('penghargaan.destroy');
        Route::post('/send-award-notification', [PenghargaanController::class, 'sendAwardNotification'])->name('send.award.notification');
    });

    // Siswa
    Route::get('/siswa', [KelolaSiswaController::class, 'index'])->name('siswa');
    Route::post('/siswa/store', [KelolaSiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{nis}/detail', [KelolaSiswaController::class, 'show'])->name('siswa.detail');
    Route::get('/siswa/{nis}/edit', [KelolaSiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{nis}', [KelolaSiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{nis}', [KelolaSiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/siswa/export', [KelolaSiswaController::class, 'exportCsv'])->name('siswa.export');
    Route::post('/siswa/import', [KelolaSiswaController::class, 'import'])->name('siswa.import');

    // Laporan
    Route::get('/laporan/aktivitas', [LogAdminController::class, 'laporan'])->name('laporan.aktivitas');

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::patch('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::get('/pengaturan/keamanan', [PengaturanController::class, 'keamanan'])->name('pengaturan.keamanan');
    Route::put('/pengaturan/umum', [PengaturanController::class, 'updateUmum'])->name('pengaturan.umum.update');
});

// ==========================
// RUTE UNTUK SISWA (sudah login)
// ==========================
Route::middleware(['siswa'])->group(function () {
    Route::post('/siswa/logout', [AdminAuthController::class, 'logoutSiswa'])->name('logout-siswa');
    Route::get('/dashboard-siswa', [SiswaDashboardController::class, 'indexSiswa'])->name('dashboard-siswa');
    Route::get('/artikel-siswa', [SiswaArtikelController::class, 'index'])->name('artikel-siswa');
    Route::get('/artikel-siswa/{id}', [SiswaArtikelController::class, 'show'])->name('artikel-siswa.show');

    // BARIS INI YANG DITAMBAHKAN
    Route::post('/artikel-siswa/{id}/komentar', [SiswaArtikelController::class, 'storeKomentar'])->name('komentar.store');

    // Rute baru untuk Suka & Simpan
    Route::post('/artikel-siswa/{id}/interaksi', [SiswaArtikelController::class, 'storeInteraksi'])->name('artikel.interaksi');
});