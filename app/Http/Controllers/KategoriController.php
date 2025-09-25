<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
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
            return redirect()->route('kategori')->with('error', 'Gagal memuat kategori.');
        }
    }

    public function create()
    {
        try {
            return view('kategori.create');
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->route('kategori')->with('error', 'Gagal memuat form tambah kategori.');
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
                    'detail' => json_encode(['nama' => $request->nama, 'deskripsi' => $request->deskripsi]),
                    'dibuat_pada' => now(),
                ]);
            }

            $total = Kategori::count();
            $lastPage = ceil($total / 6);
            return redirect()->route('kategori', ['page' => $lastPage])->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_create',
                    'aksi' => 'Gagal menambahkan kategori baru',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => null,
                    'detail' => json_encode(['nama' => $request->nama, 'error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_create',
                    'aksi' => 'Gagal menambahkan kategori baru',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => null,
                    'detail' => json_encode(['nama' => $request->nama, 'error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->back()->with('error', 'Gagal menambahkan kategori.');
        }
    }

    public function edit($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            return view('kategori.edit', compact('kategori')); // Ganti dengan view biasa, hapus JSON
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return redirect()->route('kategori')->with('error', 'Gagal memuat data kategori.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:kategori,nama,' . $id,
                'deskripsi' => 'required|string',
            ], [
                'nama.unique' => 'Nama kategori sudah digunakan. Silakan gunakan nama lain.',
            ]);

            $kategori = Kategori::findOrFail($id);
            $kategori->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);

            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'update',
                    'aksi' => 'Mengedit kategori',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => $kategori->id,
                    'detail' => json_encode(['nama' => $request->nama, 'deskripsi' => $request->deskripsi]),
                    'dibuat_pada' => now(),
                ]);
            }

            return redirect()->route('kategori')->with('success', 'Data berhasil diedit.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_update',
                    'aksi' => 'Gagal mengedit kategori',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => $id,
                    'detail' => json_encode(['nama' => $request->nama, 'error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_update',
                    'aksi' => 'Gagal mengedit kategori',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => $id,
                    'detail' => json_encode(['nama' => $request->nama, 'error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->route('kategori')->with('error', 'Gagal memperbarui kategori.');
        }
    }

    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'delete',
                    'aksi' => 'Menghapus kategori',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => $kategori->id,
                    'detail' => json_encode(['nama' => $kategori->nama, 'deskripsi' => $kategori->deskripsi]),
                    'dibuat_pada' => now(),
                ]);
            }

            $kategori->delete();

            return redirect()->route('kategori')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_delete',
                    'aksi' => 'Gagal menghapus kategori',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => $id,
                    'detail' => json_encode(['error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->route('kategori')->with('error', 'Gagal menghapus kategori.');
        }
    }

    public function detail($id)
    {
        try {
            $kategori = Kategori::with('artikel')->findOrFail($id);
            return view('kategori.detail', compact('kategori'));
        } catch (\Exception $e) {
            Log::error('Error loading category detail: ' . $e->getMessage());
            return redirect()->route('kategori.index')->with('error', 'Gagal memuat detail kategori.');
        }
    }

    public function export()
    {
        try {
            $kategoris = Kategori::all();

            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'export',
                    'aksi' => 'Mengekspor data kategori',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => null,
                    'detail' => json_encode(['total' => $kategoris->count()]),
                    'dibuat_pada' => now(),
                ]);
            }

            $filename = 'kategori_' . date('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($kategoris) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Nama', 'Deskripsi', 'Dibuat Pada']);

                foreach ($kategoris as $kategori) {
                    fputcsv($file, [
                        $kategori->id,
                        $kategori->nama,
                        $kategori->deskripsi,
                        $kategori->dibuat_pada,
                    ]);
                }

                fclose($file);
            };

            return new StreamedResponse($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error exporting categories: ' . $e->getMessage());
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_export',
                    'aksi' => 'Gagal menekspor data kategori',
                    'referensi_tipe' => 'kategori',
                    'referensi_id' => null,
                    'detail' => json_encode(['error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->route('kategori')->with('error', 'Gagal menekspor data.');
        }
    }
}