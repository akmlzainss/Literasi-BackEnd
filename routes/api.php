<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\InteraksiController;
use App\Http\Controllers\Api\KategoriController;

// --- Rute Publik (Tidak Perlu Login) ---
Route::post('/siswa/register', [SiswaAuthController::class, 'register']);
Route::post('/siswa/login', [SiswaAuthController::class, 'login']);
Route::get('/kategori', [KategoriController::class, 'index']);


// --- Rute Terproteksi (Wajib Login) ---
Route::middleware(['auth:siswa-api', 'ability:siswa-access'])->group(function () {
    // Auth
    Route::post('/siswa/logout', [SiswaAuthController::class, 'logout']);
    Route::get('/siswa/me', function (Request $request) {
        return $request->user();
    });

    // Artikel
    Route::get('/artikel', [ArtikelController::class, 'index']); // Timeline semua artikel
    Route::post('/artikel', [ArtikelController::class, 'store']); // Upload artikel baru
    Route::get('/siswa/artikel-saya', [ArtikelController::class, 'myArticles']); // Artikel milik sendiri

    // Interaksi
    Route::post('/artikel/{artikel}/interaksi', [InteraksiController::class, 'toggleInteraksi']);
    Route::post('/artikel/{artikel}/rating', [InteraksiController::class, 'beriRating']);
    Route::get('/siswa/interaksi', [InteraksiController::class, 'getInteractedArticles']); // Ambil artikel yg disukai/dibookmark

    Route::post('/artikel/{artikel}/komentar', [ArtikelController::class, 'storeComment']);
    Route::get('/artikel/{artikel}/komentar', [ArtikelController::class, 'indexComments']);
});