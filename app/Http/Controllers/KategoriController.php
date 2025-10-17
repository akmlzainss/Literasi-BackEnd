<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Artikel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\LogAdmin;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        try {
            $query = Kategori::withCount('artikel')
                ->search($request->input('search'))
                ->applyFilter($request->input('filter'));

            $kategoris = $query->paginate(6);

            return view('kategori.kategori', compact('kategoris'));
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal memuat kategori.');
        }
    }

    public function create()
    {
        try {
            return view('kategori.create');
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal memuat form tambah kategori.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:kategori,nama',
                'deskripsi' => 'nullable|string',
            ], [
                'nama.unique' => 'Nama kategori sudah digunakan. Silakan gunakan nama lain.',
            ]);

            $kategori = Kategori::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'dibuat_pada' => now(),
            ]);

            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'create',
                    'aksi' => 'Menambahkan kategori baru',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => $kategori->id,
                    'detail' => json_encode([
                        'nama' => $request->nama,
                        'deskripsi' => $request->deskripsi
                    ]),
                    'dibuat_pada' => now(),
                ]);
            }

            $total = Kategori::count();
            $lastPage = ceil($total / 6);
            return redirect()->route('admin.kategori.index', ['page' => $lastPage])
                             ->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->logError('gagal_create', 'Gagal menambahkan kategori baru', null, [
                'nama' => $request->nama,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            $this->logError('gagal_create', 'Gagal menambahkan kategori baru', null, [
                'nama' => $request->nama,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Gagal menambahkan kategori.');
        }
    }

    public function edit($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            return view('kategori.edit', compact('kategori'));
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal memuat data kategori.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:kategori,nama,' . $id,
                'deskripsi' => 'nullable|string',
            ], [
                'nama.unique' => 'Nama kategori sudah digunakan. Silakan gunakan nama lain.',
            ]);

            $kategori = Kategori::findOrFail($id);
            $oldData = $kategori->toArray();
            $kategori->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);

            $this->logSuccess('update', 'Mengedit kategori', $kategori->id, [
                'old' => $oldData,
                'new' => [
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi
                ]
            ]);

            // Clear cache setelah update
            Cache::forget("kategori_stats_{$kategori->id}");

            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Data berhasil diedit.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->logError('gagal_update', 'Gagal mengedit kategori', $id, [
                'nama' => $request->nama,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            $this->logError('gagal_update', 'Gagal mengedit kategori', $id, [
                'nama' => $request->nama,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal memperbarui kategori.');
        }
    }

    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            $this->logSuccess('delete', 'Menghapus kategori', $kategori->id, [
                'nama' => $kategori->nama,
                'deskripsi' => $kategori->deskripsi,
                'artikel_count' => $kategori->artikel()->count()
            ]);

            // Clear cache sebelum delete
            Cache::forget("kategori_stats_{$id}");

            $kategori->delete();

            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            $this->logError('gagal_delete', 'Gagal menghapus kategori', $id, [
                'error' => $e->getMessage()
            ]);
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal menghapus kategori. Pastikan tidak ada artikel yang terkait.');
        }
    }

    /**
     * ✅ FIXED: Optimized detail method dengan pagination & caching
     */
    public function detail($id)
{
    try {
        $kategori = Kategori::findOrFail($id);

        // Cache stats 15 menit
        $stats = Cache::remember("kategori_{$id}_stats", 900, function () use ($id) {
            return [
                'total' => Artikel::where('id_kategori', $id)->count(),
                'disetujui' => Artikel::where('id_kategori', $id)->where('status', 'disetujui')->count(),
            ];
        });

        // Pagination artikel dengan 10 item per halaman
        $artikels = Artikel::with('siswa:id,nama')
            ->where('id_kategori', $id)
            ->latest()
            ->paginate(10); // Ganti get() dengan paginate(10)

        return view('kategori.detail', compact('kategori', 'stats', 'artikels'));
    } catch (\Exception $e) {
        Log::error('Error detail kategori: ' . $e->getMessage(), [
            'kategori_id' => $id,
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->route('admin.kategori.index')
                         ->with('error', 'Gagal memuat detail kategori: ' . $e->getMessage());
    }
}

    public function export()
    {
        try {
            $kategoris = Kategori::withCount('artikel')->get();

            $this->logSuccess('export', 'Mengekspor data kategori', null, [
                'total' => $kategoris->count()
            ]);

            $filename = 'kategori_' . date('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($kategoris) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Nama', 'Deskripsi', 'Jumlah Artikel', 'Dibuat Pada']);

                foreach ($kategoris as $kategori) {
                    fputcsv($file, [
                        $kategori->id,
                        $kategori->nama,
                        $kategori->deskripsi ?? '',
                        $kategori->artikel_count,
                        $kategori->dibuat_pada,
                    ]);
                }

                fclose($file);
            };

            return new StreamedResponse($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error exporting categories: ' . $e->getMessage());
            $this->logError('gagal_export', 'Gagal mengekspor data kategori', null, [
                'error' => $e->getMessage()
            ]);
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal mengekspor data.');
        }
    }

    /* =====================
     |   HELPER LOGGING
     ===================== */
    private function logSuccess($jenis, $aksi, $referensiId = null, array $detail = [])
    {
        $adminId = Auth::guard('admin')->id();
        if ($adminId) {
            LogAdmin::create([
                'id_admin' => $adminId,
                'jenis_aksi' => $jenis,
                'aksi' => $aksi,
                'referensi_tipe' => 'kategori',
                'referensi_id' => $referensiId,
                'detail' => json_encode($detail),
                'dibuat_pada' => now(),
            ]);
        }
    }

    private function logError($jenis, $aksi, $referensiId = null, array $detail = [])
    {
        $adminId = Auth::guard('admin')->id();
        if ($adminId) {
            LogAdmin::create([
                'id_admin' => $adminId,
                'jenis_aksi' => $jenis,
                'aksi' => $aksi . ' (ERROR)',
                'referensi_tipe' => 'kategori',
                'referensi_id' => $referensiId,
                'detail' => json_encode($detail),
                'dibuat_pada' => now(),
            ]);
        }
    }
}