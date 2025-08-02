<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KategoriController extends Controller
{
    // Tampilkan semua kategori (Read - Index) with search, filter, and pagination
    public function index(Request $request)
    {
        try {
            $query = Kategori::withCount('artikel')
                ->search($request->input('search'))
                ->applyFilter($request->input('filter'));

            $kategoris = $query->paginate(6); // 6 items per page

            return view('kategori.kategori', compact('kategoris'));
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return redirect()->route('kategori')->with('error', 'Gagal memuat kategori.');
        }
    }

    // Tampilkan form untuk kategori baru (Create - Show Form)
    public function create()
    {
        try {
            return view('kategori.create'); // View untuk form create akan diisi nanti
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->route('kategori')->with('error', 'Gagal memuat form tambah kategori.');
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
            return redirect()->route('kategori', ['page' => $lastPage])->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan kategori.');
        }
    }

    public function edit($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            return response()->json([
                'id' => $kategori->id,
                'nama' => $kategori->nama,
                'deskripsi' => $kategori->deskripsi,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
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

            return redirect()->route('kategori')->with('success', 'Data berhasil diedit.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            return redirect()->route('kategori')->with('error', 'Gagal memperbarui kategori.');
        }
    }

    // Hapus kategori (Delete)
    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return redirect()->route('kategori')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
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
            return redirect()->route('kategori')->with('error', 'Gagal menekspor data.');
        }
    }
}