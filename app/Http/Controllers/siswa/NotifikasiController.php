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
            ->latest('created_at') // Menggunakan created_at standar Laravel
            ->paginate(15); // Menampilkan 15 notifikasi per halaman

        // Hitung notifikasi yang belum dibaca
        $unreadCount = Notifikasi::where('id_siswa', $siswaId)
            ->where('sudah_dibaca', false)
            ->count();

        return view('siswa.notifikasi', compact('notifikasis', 'unreadCount'));
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead(Request $request)
    {
        $siswaId = Auth::guard('siswa')->id();

        if ($request->has('id')) {
            // Tandai notifikasi spesifik
            Notifikasi::where('id', $request->id)
                ->where('id_siswa', $siswaId)
                ->update(['sudah_dibaca' => true]);
        } else {
            // Tandai semua notifikasi sebagai sudah dibaca
            Notifikasi::where('id_siswa', $siswaId)
                ->where('sudah_dibaca', false)
                ->update(['sudah_dibaca' => true]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Ambil jumlah notifikasi yang belum dibaca (untuk AJAX)
     */
    public function getUnreadCount()
    {
        $siswaId = Auth::guard('siswa')->id();

        $count = Notifikasi::where('id_siswa', $siswaId)
            ->where('sudah_dibaca', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Ambil notifikasi terbaru (untuk dropdown)
     */
    public function getRecent()
    {
        $siswaId = Auth::guard('siswa')->id();

        $notifications = Notifikasi::where('id_siswa', $siswaId)
            ->latest('created_at')
            ->take(5)
            ->get();

        return response()->json(['notifications' => $notifications]);
    }
}
