<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelolaSiswaController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\LogAdminController;
use App\Http\Controllers\DashboardController as AdminDashboardController;
use App\Http\Controllers\Siswa\SiswaArtikelController;
use App\Http\Controllers\Siswa\NotifikasiController;
use App\Http\Controllers\Siswa\ProfilController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
});

// ==========================
// RUTE UNTUK SEMUA PENGUNJUNG (SISWA & GUEST)
// ==========================
Route::name('artikel-siswa.')->group(function () {
    Route::get('/artikel-siswa', [SiswaArtikelController::class, 'index'])->name('index');
    Route::get('/artikel-siswa/{id}', [SiswaArtikelController::class, 'show'])->name('show');
});

// ===================================================================
// RUTE KHUSUS SISWA (memerlukan login siswa)
// ===================================================================
Route::middleware(['auth:siswa'])->group(function () {
    Route::post('/siswa/logout', [AdminAuthController::class, 'logoutSiswa'])->name('logout-siswa');
    Route::get('/dashboard-siswa', [SiswaDashboardController::class, 'indexSiswa'])->name('dashboard-siswa');
    
    // Rute Interaksi & Komentar
    Route::post('/artikel-siswa/{id}/komentar', [SiswaArtikelController::class, 'storeKomentar'])->name('komentar.store');
    Route::post('/artikel-siswa/{id}/interaksi', [SiswaArtikelController::class, 'storeInteraksi'])->name('artikel-siswa.interaksi');

    // Upload Artikel oleh Siswa
    Route::get('/upload', [SiswaArtikelController::class, 'showUploadChoice'])->name('artikel-siswa.upload');
    Route::get('/upload/artikel/create', [SiswaArtikelController::class, 'createArtikel'])->name('artikel-siswa.create');
    Route::post('/upload/artikel', [SiswaArtikelController::class, 'storeArtikel'])->name('artikel-siswa.store');

    // Notifikasi & Profil Siswa
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/update-password', [ProfilController::class, 'updatePassword'])->name('profil.update-password');
});

// ===================================================================
// RUTE ADMIN (memerlukan login admin dan prefix /admin)
// ===================================================================
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart/{type}', [AdminDashboardController::class, 'getChartDataAjax'])->name('dashboard.chart');

    Route::resource('artikel', ArtikelController::class)->except(['show']);
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
    Route::post('/artikel/{id}/rate', [ArtikelController::class, 'rate'])->name('artikel.rate');
    Route::get('/artikel/export', [ArtikelController::class, 'export'])->name('artikel.export');
    Route::get('/search-siswa', [ArtikelController::class, 'searchSiswa'])->name('search.siswa');
    Route::get('/artikel/status/{status}', [ArtikelController::class, 'status'])->name('artikel.status');

    Route::post('/komentar/{artikel}', [KomentarController::class, 'store'])->name('komentar.store');
    Route::delete('/komentar/{id}', [KomentarController::class, 'destroy'])->name('komentar.destroy');
    
    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::get('/kategori/export', [KategoriController::class, 'export'])->name('kategori.export');
    Route::get('/kategori/{id}/detail', [KategoriController::class, 'detail'])->name('kategori.detail');
    
    Route::resource('penghargaan', PenghargaanController::class);
    Route::post('/send-award-notification', [PenghargaanController::class, 'sendAwardNotification'])->name('send.award.notification');

    Route::resource('siswa', KelolaSiswaController::class)->except(['create', 'show', 'edit']);
    Route::get('/siswa/{nis}/detail', [KelolaSiswaController::class, 'show'])->name('siswa.detail');
    Route::get('/siswa/{nis}/edit', [KelolaSiswaController::class, 'edit'])->name('siswa.edit');
    Route::get('/siswa/export', [KelolaSiswaController::class, 'exportCsv'])->name('siswa.export');
    Route::post('/siswa/import', [KelolaSiswaController::class, 'import'])->name('siswa.import');

    Route::get('/laporan/aktivitas', [LogAdminController::class, 'laporan'])->name('laporan.aktivitas');

    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/', [PengaturanController::class, 'index'])->name('index');
        Route::patch('/', [PengaturanController::class, 'update'])->name('update');
        Route::get('/keamanan', [PengaturanController::class, 'keamanan'])->name('keamanan');
        Route::put('/umum', [PengaturanController::class, 'updateUmum'])->name('umum.update');
        Route::get('/trash', [PengaturanController::class, 'trash'])->name('trash');
        Route::post('/restore/{model}/{id}', [PengaturanController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{model}/{id}', [PengaturanController::class, 'forceDelete'])->name('forceDelete');
    });

    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::get('/all', [BackupController::class, 'backupAll'])->name('all');
    });
});