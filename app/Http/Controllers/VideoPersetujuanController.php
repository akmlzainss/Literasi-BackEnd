<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Kategori;
use App\Models\Siswa;
use App\Models\LogAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoPersetujuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query = Video::with(['kategori', 'siswa'])->where('status', 'menunggu');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('siswa')) {
            $query->where('id_siswa', $request->siswa);
        }

        $videos = $query->latest()->paginate(10)->appends($request->all());
        return view('video.persetujuan', compact('videos'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:disetujui,ditolak',
                'alasan_penolakan' => 'nullable|string|required_if:status,ditolak',
            ]);

            $video = Video::findOrFail($id);
            $video->update([
                'status' => $request->status,
                'alasan_penolakan' => $request->status === 'ditolak' ? $request->alasan_penolakan : null,
                'diterbitkan_pada' => $request->status === 'disetujui' ? now() : $video->diterbitkan_pada,
            ]);

            $this->logAction('update', 'Memperbarui status video', 'video', $video->id, [
                'status' => $request->status,
                'alasan_penolakan' => $request->alasan_penolakan,
            ]);

            return redirect()->route('admin.video.persetujuan')->with('success', 'Status video berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating video status: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui status video.');
        }
    }

    private function logAction($actionType, $action, $refType, $refId, $details = [])
    {
        LogAdmin::create([
            'id_admin' => Auth::guard('admin')->id(),
            'jenis_aksi' => $actionType,
            'aksi' => $action,
            'referensi_tipe' => $refType,
            'referensi_id' => $refId,
            'detail' => !empty($details) ? json_encode($details) : null,
            'dibuat_pada' => now(),
        ]);
    }
}
