<?php

namespace App\Http\Controllers;

use App\Models\LogAdmin;
use App\Models\AktivitasSiswa;

class LogAdminController extends Controller
{
    public function laporan()
    {
        // Ambil aktivitas admin
        $aktivitasAdmin = LogAdmin::with('admin')
            ->orderByDesc('dibuat_pada')
            ->get();

        // Ambil aktivitas siswa (opsional)
        $aktivitas = AktivitasSiswa::latest()->get();

        // Kirim ke view
        return view('laporan.laporan', compact('aktivitasAdmin', 'aktivitas'));
    }
    
}
