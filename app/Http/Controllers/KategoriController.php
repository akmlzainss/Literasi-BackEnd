<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KategoriController extends Controller
{
    // Tampilkan semua kategori (Read - Index) with search and pagination
    public function index(Request $request)
    {
        try {
            $query = Kategori::query();

            // Search
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
            }

            $kategoris = $query->paginate(6); // 6 items per page

            // Debug untuk memastikan data dimuat
            // Log::info('Kategoris loaded: ', $kategoris->items());

            return view('kategori.kategori', compact('kategoris'));
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch categories'], 500);
        }
    }

    // Tampilkan form untuk kategori baru (Create - Show Form)
    public function create()
    {
        try {
            return view('kategori.create'); // View untuk form create akan diisi nanti
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load create form'], 500);
        }
    }

    // Simpan kategori baru (Create - Store)
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:kategori,nama',
                'deskripsi' => 'required|string',
            ]);

            $kategori = Kategori::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'dibuat_pada' => now(),
            ]);

            $total = Kategori::count();
            $lastPage = ceil($total / 6); // Hitung halaman terakhir berdasarkan 6 item per halaman
            return redirect()->route('kategori.index', ['page' => $lastPage])->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan kategori.');
        }
    }

    // Tampilkan form untuk mengedit kategori dalam modal
    public function edit($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            return view('kategori.edit-modal', compact('kategori')); // Return partial view for modal
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load edit form'], 500);
        }
    }

    // Perbarui kategori (Update)
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:kategori,nama,' . $id,
                'deskripsi' => 'required|string',
            ]);

            $kategori = Kategori::findOrFail($id);
            $kategori->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui kategori.');
        }
    }

    // Hapus kategori (Delete)
    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus kategori'], 500);
        }
    }

    // Export data to CSV
    public function export()
    {
        try {
            $kategoris = Kategori::all();
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
            return redirect()->back()->with('error', 'Gagal menekspor data.');
        }
    }
}