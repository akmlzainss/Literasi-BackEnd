<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Pagination\Paginator;
use App\Models\LogAdmin;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        Paginator::useBootstrapFive();

        try {
            $artikels = Artikel::with('kategori', 'siswa')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->input('search');
                    $query->where(function ($q) use ($search) {
                        $q->where('judul', 'like', "%{$search}%")
                            ->orWhere('isi', 'like', "%{$search}%")
                            ->orWhereHas('siswa', fn($q_siswa) => $q_siswa->where('nama', 'like', "%{$search}%"));
                    });
                })
                ->when($request->filled('kategori'), function ($query) use ($request) {
                    $query->whereHas('kategori', fn($q) => $q->where('nama', $request->input('kategori')));
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->input('status'));
                })
                ->latest('dibuat_pada')
                ->paginate(9)
                ->appends($request->query());

            return view('artikel.artikel', compact('artikels'));
        } catch (\Exception $e) {
            Log::error('Error fetching articles: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat artikel.');
        }
    }

    public function create()
    {
        try {
            return view('artikel.create');
        } catch (\Exception $e) {
            Log::error('Error loading create form: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat form tambah artikel.');
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $this->prepareArtikelData($request);

            $artikel = Artikel::create($data);
            Log::info('Artikel created with data: ', $data);

            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'create',
                    'aksi' => 'Menambahkan artikel baru',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => $artikel->id,
                    'detail' => json_encode(['judul' => $data['judul'], 'jenis' => $data['jenis'], 'status' => $data['status']]),
                    'dibuat_pada' => now(),
                ]);
            }

            return redirect()->route('artikel')->with('success', 'Artikel berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error on store: ' . json_encode($e->errors()));
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_create',
                    'aksi' => 'Gagal menambahkan artikel baru',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => null,
                    'detail' => json_encode(['judul' => $request->judul ?? '', 'error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_create',
                    'aksi' => 'Gagal menambahkan artikel baru',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => null,
                    'detail' => json_encode(['judul' => $request->judul ?? '', 'error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->back()->with('error', 'Gagal menambahkan artikel: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $artikel = Artikel::with('kategori', 'siswa')->findOrFail($id);
            return view('artikel.edit', compact('artikel'));
        } catch (\Exception $e) {
            Log::error('Error loading edit page for article ' . $id . ': ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat halaman edit artikel.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            $data = $this->prepareArtikelData($request, $artikel);

            $artikel->update($data);
            Log::info('Artikel updated with ID ' . $id . ', Data: ', $data);

            $jenisAksi = 'update';
            $aksi = 'Mengedit artikel';
            if ($data['status'] === 'disetujui' && $artikel->status !== 'disetujui') {
                $jenisAksi = 'setujui_artikel';
                $aksi = 'Menyetujui artikel';
            } elseif ($data['status'] === 'ditolak' && $artikel->status !== 'ditolak') {
                $jenisAksi = 'tolak_artikel';
                $aksi = 'Menolak artikel';
            }

            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => $jenisAksi,
                    'aksi' => $aksi,
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => $artikel->id,
                    'detail' => json_encode([
                        'judul' => $data['judul'],
                        'isi' => $data['isi'],
                    ]),
                    'dibuat_pada' => now(),
                ]);
            }

            return redirect()->route('artikel')->with('success', 'Artikel berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error on update: ' . json_encode($e->errors()));
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_update',
                    'aksi' => 'Gagal mengedit artikel',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => $id,
                    'detail' => json_encode(['judul' => $request->judul ?? '', 'error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating article ' . $id . ': ' . $e->getMessage());
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_update',
                    'aksi' => 'Gagal mengedit artikel',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => $id,
                    'detail' => json_encode(['judul' => $request->judul ?? '', 'error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui artikel.');
        }
    }

    private function prepareArtikelData(Request $request, Artikel $artikel = null): array
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:3500',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_kategori' => 'nullable|exists:kategori,id',
            'penulis_type' => 'required|in:admin,siswa',
            'id_siswa' => 'required_if:penulis_type,siswa|nullable|exists:siswa,id',
            'jenis' => 'required|in:bebas,resensi_buku,resensi_film,video',
            'status' => 'required|in:draf,menunggu,disetujui,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak|nullable|string|max:1000',
        ]);

        $validated['isi'] = Purifier::clean($validated['isi']);
        $validated['id_siswa'] = $validated['penulis_type'] === 'siswa' ? $validated['id_siswa'] : null;

        if ($request->hasFile('gambar')) {
            if ($artikel && $artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        if (!$artikel) {
            $validated['dibuat_pada'] = now();
        }
        $validated['diterbitkan_pada'] = $validated['status'] === 'disetujui' && (!$artikel || !$artikel->diterbitkan_pada) ? now() : ($artikel->diterbitkan_pada ?? null);

        return $validated;
    }

    public function destroy($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);

            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }

            $artikel->delete();

            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'delete',
                    'aksi' => 'Menghapus artikel',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => $id,
                    'detail' => json_encode([
                        'judul' => $artikel->judul,
                        'jenis' => $artikel->jenis,
                        'status' => $artikel->status,
                    ]),
                    'dibuat_pada' => now(),
                ]);
            }

            return redirect()->route('artikel')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting article ' . $id . ': ' . $e->getMessage());
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_delete',
                    'aksi' => 'Gagal menghapus artikel',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => $id,
                    'detail' => json_encode(['error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->route('artikel')->with('error', 'Gagal menghapus artikel.');
        }
    }

    public function show($id)
    {
        try {
            $artikel = Artikel::with(['kategori', 'siswa', 'komentarArtikel'])->findOrFail($id);
            return view('artikel.show', compact('artikel'));
        } catch (\Exception $e) {
            Log::error('Error loading article details: ' . $e->getMessage());
            return redirect()->route('artikel')->with('error', 'Gagal memuat detail artikel.');
        }
    }

    public function export()
    {
        try {
            $artikels = Artikel::with('kategori', 'siswa')->get();

            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'export',
                    'aksi' => 'Mengekspor data artikel',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => null,
                    'detail' => json_encode(['total' => $artikels->count()]),
                    'dibuat_pada' => now(),
                ]);
            }

            $filename = 'artikels_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($artikels) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Judul', 'Isi', 'Kategori', 'Penulis', 'Jenis', 'Status', 'Dibuat Pada', 'Diterbitkan Pada', 'Jumlah Dilihat', 'Jumlah Suka', 'Jumlah Komentar']);

                foreach ($artikels as $artikel) {
                    fputcsv($file, [
                        $artikel->id,
                        $artikel->judul,
                        strip_tags($artikel->isi),
                        $artikel->kategori->nama ?? 'Tanpa Kategori',
                        $artikel->siswa->nama ?? ($artikel->penulis_type === 'admin' ? 'Admin' : 'Unknown'),
                        $artikel->jenis,
                        $artikel->status,
                        $artikel->dibuat_pada ? $artikel->dibuat_pada->format('d M Y') : '',
                        $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : '',
                        $artikel->jumlah_dilihat,
                        $artikel->jumlah_suka,
                        $artikel->komentarArtikel->count(),
                    ]);
                }

                fclose($file);
            };

            return Response::stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error exporting articles: ' . $e->getMessage());
            $adminId = Auth::guard('admin')->id();
            if ($adminId) {
                LogAdmin::create([
                    'id_admin' => $adminId,
                    'jenis_aksi' => 'gagal_export',
                    'aksi' => 'Gagal mengekspor data artikel',
                    'referensi_tipe' => 'artikel',
                    'referensi_id' => null,
                    'detail' => json_encode(['error' => $e->getMessage()]),
                    'dibuat_pada' => now(),
                ]);
            }
            return redirect()->route('artikel')->with('error', 'Gagal menekspor data artikel.');
        }
    }
}