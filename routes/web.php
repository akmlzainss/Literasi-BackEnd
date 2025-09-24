<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelolaSiswaController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\BackupController;

use App\Http\Controllers\LogAdminController;
use App\Http\Controllers\DashboardController as AdminDashboardController;
use App\Http\Controllers\Siswa\SiswaArtikelController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

// ==========================
// RUTE ROOT
// ==========================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================
// RUTE UNTUK GUEST (belum login)
// ==========================
Route::middleware(['guest'])->group(function () {
    // Form login (satu untuk admin & siswa)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    // Registrasi (hanya untuk siswa, diproses oleh satu fungsi)
    // PERBAIKAN: Route GET /register tidak diperlukan lagi karena form ada di halaman login
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
});

// ==========================
// RUTE UNTUK ADMIN (dilindungi middleware 'admin')
// ==========================
Route::middleware(['admin'])->group(function () {
    // Logout & dashboard
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout'); // URL: /logout
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart/{type}', [AdminDashboardController::class, 'getChartDataAjax'])->name('dashboard.chart');

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
    Route::get('/artikel/status/{status}', [ArtikelController::class, 'status'])->name('artikel.status');

    // Komentar (ADMIN)
    Route::post('/komentar/{id}', [KomentarController::class, 'store'])->name('admin.komentar.store');
    Route::delete('/komentar/{id}', [KomentarController::class, 'destroy'])->name('admin.komentar.destroy');

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
        Route::get('/create', [PenghargaanController::class, 'create'])->name('penghargaan.create');
        Route::post('/', [PenghargaanController::class, 'store'])->name('penghargaan.store');
        Route::get('/{id}', [PenghargaanController::class, 'show'])->name('penghargaan.show');
        Route::get('/{id}/edit', [PenghargaanController::class, 'edit'])->name('penghargaan.edit');
        Route::put('/{id}', [PenghargaanController::class, 'update'])->name('penghargaan.update');
        Route::delete('/{id}', [PenghargaanController::class, 'destroy'])->name('penghargaan.destroy');
        Route::post('/send-award-notification', [PenghargaanController::class, 'sendAwardNotification'])->name('send.award.notification');
    });

    // Siswa (kelola oleh admin)
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
    // Profil Admin
    Route::prefix('pengaturan')->group(function () {
    Route::get('/', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::get('/keamanan', [PengaturanController::class, 'keamanan'])->name('pengaturan.keamanan');

    // Trash
    Route::get('/trash', [PengaturanController::class, 'trash'])->name('pengaturan.trash');
    Route::post('/restore/{model}/{id}', [PengaturanController::class, 'restore'])->name('pengaturan.restore');
    Route::delete('/force-delete/{model}/{id}', [PengaturanController::class, 'forceDelete'])->name('pengaturan.forceDelete');
});

});

// ==========================
// RUTE UNTUK SISWA (dilindungi middleware 'siswa')
// ==========================
Route::middleware(['siswa'])->group(function () {
    // PERBAIKAN: URL logout siswa dibuat unik untuk menghindari konflik
    Route::post('/siswa/logout', [AdminAuthController::class, 'logoutSiswa'])->name('logout-siswa'); // URL: /siswa/logout
    
    Route::get('/dashboard-siswa', [SiswaDashboardController::class, 'indexSiswa'])->name('dashboard-siswa');

    // Artikel siswa
    Route::get('/artikel-siswa', [SiswaArtikelController::class, 'index'])->name('artikel-siswa');
    Route::get('/artikel-siswa/{id}', [SiswaArtikelController::class, 'show'])->name('artikel-siswa.show');

    // Komentar (SISWA)
    Route::post('/artikel-siswa/{id}/komentar', [SiswaArtikelController::class, 'storeKomentar'])->name('siswa.komentar.store');

    // Interaksi artikel
    Route::post('/artikel-siswa/{id}/interaksi', [SiswaArtikelController::class, 'storeInteraksi'])->name('artikel.interaksi');
});
// ==========================
// Backup Semua Data (Excel - Multi Sheet)
// ==========================
Route::prefix('backup')->group(function () {
    Route::get('/', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/all', [BackupController::class, 'backupAll'])->name('backup.all');
});
