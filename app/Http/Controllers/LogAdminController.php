<?php

namespace App\Http\Controllers;

use App\Models\LogAdmin;
use App\Models\AktivitasSiswa;
use Illuminate\Pagination\Paginator;

class LogAdminController extends Controller
{
    public function laporan()
    {
        Paginator::useBootstrapFive(); // Supaya pagination Bootstrap 5

        // Ambil aktivitas admin terbaru dengan paginate
        $aktivitasAdmin = LogAdmin::with('admin')
            ->orderByDesc('dibuat_pada')
            ->paginate(5); // 10 log per halaman

        // Ambil aktivitas siswa (opsional, bisa juga di paginate jika perlu)
        $aktivitas = AktivitasSiswa::latest()->get();

        // Kirim ke view
        return view('laporan.laporan', compact('aktivitasAdmin', 'aktivitas'));
    }
}
