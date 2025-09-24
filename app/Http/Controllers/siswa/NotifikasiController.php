<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Menampilkan halaman notifikasi untuk siswa yang sedang login.
     */
    public function index()
    {
        $siswaId = Auth::guard('siswa')->id();

        // Ambil notifikasi untuk siswa ini, urutkan dari yang terbaru, dan paginasi
        $notifikasis = Notifikasi::where('id_siswa', $siswaId)
                                 ->latest('dibuat_pada') // Mengurutkan berdasarkan kolom 'dibuat_pada'
                                 ->paginate(15); // Menampilkan 15 notifikasi per halaman

        // Tandai semua notifikasi yang belum dibaca sebagai sudah dibaca
        Notifikasi::where('id_siswa', $siswaId)
                  ->where('sudah_dibaca', false)
                  ->update(['sudah_dibaca' => true]);

        return view('web_siswa.notifikasi', compact('notifikasis'));
    }
}