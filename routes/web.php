<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelolaSiswaController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\CkeditorController;

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================
// RUTE UNTUK GUEST (belum login)
// ==========================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register']);
});

// ==========================
// RUTE UNTUK ADMIN (sudah login)
// ==========================
Route::middleware(['admin'])->group(function () {
    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // ==========================
    // ARTIKEL
    // ==========================
    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::get('/artikel/{id}/edit-ajax', [ArtikelController::class, 'editAjax'])->name('artikel.edit-ajax');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
    Route::get('/artikel/export', [ArtikelController::class, 'export'])->name('artikel.export');
    Route::get('/admin/search-siswa', [ArtikelController::class, 'searchSiswa'])->name('admin.search.siswa');

    // ==========================
    // KATEGORI
    // ==========================
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/kategori/export', [KategoriController::class, 'export'])->name('kategori.export');
    Route::get('/kategori/{id}/detail', [KategoriController::class, 'detail'])->name('kategori.detail');

    // ==========================
    // PENGHARGAAN
    // ==========================
    Route::prefix('penghargaan')->group(function () {
        Route::get('/', [PenghargaanController::class, 'index'])->name('penghargaan');
        Route::get('/create', [PenghargaanController::class, 'create'])->name('penghargaan.create');
        Route::post('/', [PenghargaanController::class, 'store'])->name('penghargaan.store');
        Route::get('/{id}', [PenghargaanController::class, 'show'])->name('penghargaan.show');
        Route::get('/{id}/edit', [PenghargaanController::class, 'edit'])->name('penghargaan.edit');
        Route::put('/{id}', [PenghargaanController::class, 'update'])->name('penghargaan.update');
        Route::delete('/{id}', [PenghargaanController::class, 'destroy'])->name('penghargaan.destroy');
        Route::post('/send-award-notification', [PenghargaanController::class, 'sendAwardNotification'])->name('send.award.notification');
    });

    // ==========================
    // SISWA
    // ==========================
    Route::get('/siswa', [KelolaSiswaController::class, 'index'])->name('siswa');
    Route::post('/siswa/store', [KelolaSiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{nis}/detail', [KelolaSiswaController::class, 'show'])->name('siswa.detail');
    Route::get('/siswa/{nis}/edit', [KelolaSiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{nis}', [KelolaSiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{nis}', [KelolaSiswaController::class, 'destroy'])->name('siswa.destroy');

    // ==========================
    // LAPORAN
    // ==========================
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    // ==========================
    // PENGATURAN
    // ==========================
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::patch('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::get('/pengaturan/keamanan', [PengaturanController::class, 'keamanan'])->name('pengaturan.keamanan');
    Route::put('/pengaturan/umum', [PengaturanController::class, 'updateUmum'])->name('pengaturan.umum.update');
});
