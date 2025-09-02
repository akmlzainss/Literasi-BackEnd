<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\Api\ArtikelController;

// ... (Rute login dan register tetap sama)
Route::post('/siswa/register', [SiswaAuthController::class, 'register']);
Route::post('/siswa/login', [SiswaAuthController::class, 'login']);

Route::middleware(['auth:siswa-api', 'abilities:siswa-access'])->group(function () {
    // ... (Rute logout dan /me tetap sama)
    Route::post('/siswa/logout', [SiswaAuthController::class, 'logout']);
    Route::get('/siswa/me', function (Request $request) {
        return $request->user();
    });

    // Rute untuk mengunggah artikel (POST)
    Route::post('/siswa/artikel', [ArtikelController::class, 'store']);
    
    // RUTE BARU: Untuk mendapatkan daftar artikel siswa (GET)
    Route::get('/siswa/artikel', [ArtikelController::class, 'index']);
});