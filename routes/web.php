<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KategoriController;

// Redirect dari root ke login
Route::get('/', function () {
    return redirect()->route('login.admin');
});
Route::get('/login/admin', [AdminAuthController::class, 'showLoginForm'])->name('login.admin');
Route::post('/login/admin', [AdminAuthController::class, 'login']);
Route::get('/register/admin', [AdminAuthController::class, 'showRegisterForm'])->name('register.admin');
Route::post('/register/admin', [AdminAuthController::class, 'register']);
Route::post('/logout/admin', [AdminAuthController::class, 'logout'])->name('logout.admin');
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('penghargaan.penghargaan', function () {
        return view('penghargaan.penghargaan');
    })->name('penghargaan.penghargaan');

});

// artikel
Route::get('/admin/artikel', [ArtikelController::class, 'index'])->name('artikel.artikel');
Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');

// siswa
Route::get('/siswa', function () {
    return view('siswa.siswa');
})->name('siswa.siswa');

// kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.kategori');

// kategori
Route::get('/laporan', function () {
    return view('laporan.laporan');
})->name('laporan.laporan');

Route::get('/pengaturan', function () {
    return view('pengaturan.pengaturan');
})->name('pengaturan.pengaturan');