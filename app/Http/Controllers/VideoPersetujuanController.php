<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Kategori;
use App\Models\Siswa;
use App\Models\LogAdmin;
// Gunakan kelas Notifikasi yang sesuai dengan sistem Anda (misalnya: Illuminate\Support\Facades\Notification)
// Saya akan menggunakan Log untuk simulasi notifikasi ke siswa
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VideoPersetujuanController extends Controller
{
    public function __construct()
    {
        // Pastikan guard 'admin' sudah terkonfigurasi
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $query = Video::with(['kategori', 'siswa']);

        // Inisialisasi variabel untuk data filter yang dipilih
        $selectedKategori = null;
        $selectedSiswa = null;

        // 1. FILTER STATUS (Diperbarui untuk mendukung 'all')
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        // Jika status tidak diisi, default ke 'menunggu'
        elseif (!$request->filled('status')) {
            $query->where('status', 'menunggu');
        }


        // 2. FILTER SEARCH JUDUL
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // 3. FILTER KATEGORI
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
            // Ambil data Kategori yang dipilih untuk Select2
            $selectedKategori = Kategori::select('id', 'nama')->find($request->kategori);
        }

        // 4. FILTER SISWA
        if ($request->filled('siswa')) {
            $query->where('id_siswa', $request->siswa);
            // Ambil data Siswa yang dipilih untuk Select2
            $selectedSiswa = Siswa::select('id', 'nama', 'nis')->find($request->siswa);
        }

        // 5. FILTER BULAN & TAHUN
        if ($request->filled('bulan_tahun')) {
            // Format input: YYYY-MM
            $date = \Carbon\Carbon::createFromFormat('Y-m', $request->bulan_tahun);
            $query->whereYear('created_at', $date->year)
                  ->whereMonth('created_at', $date->month);
        }

        $videos = $query->latest()->paginate(10)->appends($request->all());

        // Kirimkan data video, kategori, dan siswa yang dipilih ke view
        return view('video.persetujuan', compact('videos', 'selectedKategori', 'selectedSiswa'));
    }

    public function update(Request $request, $id)
    {
        try {
            $video = Video::findOrFail($id);
            $updateType = $request->input('update_type', 'status_only');
            $successMessage = 'Perubahan berhasil disimpan!';
            $logAction = 'Memperbarui video';
            $logDetails = [];

            if ($updateType === 'status_only') {
                $request->validate([
                    'status' => ['required', Rule::in(['menunggu', 'disetujui', 'ditolak'])],
                    // Validasi alasan hanya jika statusnya ditolak
                    'alasan_penolakan' => 'nullable|string|required_if:status,ditolak',
                ]);

                $newStatus = $request->status;
                $oldStatus = $video->status;
                $alasanPenolakan = $request->status === 'ditolak' ? $request->alasan_penolakan : null;

                $updateData = [
                    'status' => $newStatus,
                    'alasan_penolakan' => $alasanPenolakan,
                    // Set diterbitkan_pada hanya jika status berubah ke 'disetujui' dan sebelumnya bukan 'disetujui'
                    'diterbitkan_pada' => ($newStatus === 'disetujui' && $oldStatus !== 'disetujui') ? now() : $video->diterbitkan_pada,
                ];

                $video->update($updateData);

                // LOGIKA NOTIFIKASI KE SISWA (Placeholder)
                if ($newStatus === 'ditolak' && $video->siswa) {
                    $message = "Video Anda: '{$video->judul}' Ditolak. Alasan: {$alasanPenolakan}";
                    // Anda harus mengimplementasikan sistem notifikasi di sini.
                    // Contoh: $video->siswa->notify(new VideoDitolakNotification($message));
                    Log::info("NOTIFIKASI KE SISWA {$video->siswa->nis}: " . $message);
                }

                $logAction = "Memperbarui status video menjadi: {$newStatus}";
                $logDetails = ['status_lama' => $oldStatus, 'status_baru' => $newStatus, 'alasan_penolakan' => $alasanPenolakan];
                $successMessage = "Status video berhasil diubah menjadi **{$newStatus}**.";

            } elseif ($updateType === 'detail_only') {
                $request->validate([
                    'judul' => 'required|string|max:255',
                    'deskripsi' => 'nullable|string',
                    'id_kategori' => 'required|exists:kategori,id',
                    'id_siswa' => 'required|exists:siswa,id',
                ]);

                $video->update($request->only('judul', 'deskripsi', 'id_kategori', 'id_siswa'));
                $logAction = 'Mengedit detail video';
                $logDetails = $request->only('judul', 'deskripsi', 'id_kategori', 'id_siswa');
                $successMessage = "Detail video berhasil diperbarui!";
            }
            
            // Log Aksi Admin
            $this->logAction('update', $logAction, 'video', $video->id, $logDetails);

            // Jika ini adalah permintaan AJAX (untuk delete, misalnya, meskipun update tidak harus)
            if ($request->wantsJson()) {
                return response()->json(['message' => $successMessage]);
            }

            return redirect()->route('admin.video.persetujuan', ['status' => $video->status])->with('success', $successMessage);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            return back()->withInput()->withErrors($e->errors())->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error updating video: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui video.');
        }
    }

    public function destroy($id)
    {
        try {
            $video = Video::findOrFail($id);
            $judul = $video->judul;

            // Delete associated files from storage
            if ($video->video_path && Storage::exists($video->video_path)) {
                Storage::delete($video->video_path);
            }
            if ($video->thumbnail_path && Storage::exists($video->thumbnail_path)) {
                Storage::delete($video->thumbnail_path);
            }

            $video->delete();

            $this->logAction('delete', "Menghapus video: {$judul}", 'video', $id);

            // Respon JSON untuk AJAX delete
            return response()->json(['message' => 'Video berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error('Error deleting video: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus video.'], 500);
        }
    }

    public function searchKategori(Request $request)
    {
        $search = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $kategoris = Kategori::where('nama', 'like', "%$search%")
            ->whereNull('deleted_at')
            ->select('id', 'nama as text')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'results' => $kategoris->items(),
            'pagination' => [
                'more' => $kategoris->hasMorePages()
            ]
        ]);
    }

    public function searchSiswa(Request $request)
    {
        $search = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $siswas = Siswa::where(function ($query) use ($search) {
            $query->where('nama', 'like', "%$search%")
                ->orWhere('nis', 'like', "%$search%");
        })
            ->paginate($perPage, ['*'], 'page', $page);

        $results = $siswas->map(function ($siswa) {
            return [
                'id' => $siswa->id,
                'text' => "{$siswa->nama} ({$siswa->nis})"
            ];
        });

        return response()->json([
            'results' => $results->toArray(),
            'pagination' => [
                'more' => $siswas->hasMorePages()
            ]
        ]);
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