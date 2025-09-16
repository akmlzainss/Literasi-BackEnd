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
    Route::get('/artikel', [ArtikelController::class, 'index']);
    Route::post('/artikel', [ArtikelController::class, 'store']);
    Route::get('/siswa/artikel-saya', [ArtikelController::class, 'myArticles']);

    // Interaksi
    Route::post('/artikel/{id}/interaksi', [InteraksiController::class, 'toggleInteraksi'])->where('id', '[0-9]+');
    Route::post('/artikel/{id}/rating', [InteraksiController::class, 'beriRating'])->where('id', '[0-9]+');
    Route::get('/siswa/interaksi', [InteraksiController::class, 'getInteractedArticles']);

    // Komentar
    Route::post('/artikel/{id}/komentar', [ArtikelController::class, 'storeComment'])->where('id', '[0-9]+');
    Route::get('/artikel/{id}/komentar', [ArtikelController::class, 'indexComments'])->where('id', '[0-9]+');
});