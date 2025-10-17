<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use App\Models\LogAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelolaSiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // List siswa dengan filter, search, dan pagination
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('nis', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
                // HAPUS kelas dari pencarian bebas
            });
        }

        if ($request->filled('kelas')) {
            $kelas = trim($request->input('kelas'));
            $query->where('kelas', 'like', "%{$kelas}%");
        }


        $sort = $request->input('sort', 'created_at_desc');
        match ($sort) {
            'nama_asc' => $query->orderBy('nama', 'asc'),
            'nama_desc' => $query->orderBy('nama', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $siswa = $query->paginate(10);
        $siswa->appends($request->all());


        return view('siswa.siswa', compact('siswa'));
    }

    // Tambah siswa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:siswa,nis|max:20',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:siswa,email|max:255',
            'kelas' => 'required|string|max:50|regex:/^[A-Za-z0-9\s]+$/',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nis.unique' => 'NIS sudah digunakan. Silakan gunakan NIS lain.',
            'email.unique' => 'Email sudah digunakan. Silakan gunakan email lain.',
        ]);

        try {
            $siswa = Siswa::create([
                'nis' => $validated['nis'],
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'kelas' => strtoupper(trim($validated['kelas'])),
                'password' => Hash::make($validated['password']),
            ]);

            $this->logAdmin('create', 'Menambahkan siswa baru', $siswa->id, [
                'nis' => $validated['nis'],
                'nama' => $validated['nama'],
                'kelas' => $validated['kelas'],
            ]);

            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('Error creating siswa: ' . $e->getMessage());
            $this->logAdmin('gagal_create', 'Gagal menambahkan siswa baru', null, [
                'nis' => $request->nis ?? '',
                'error' => $e->getMessage(),
            ]);

            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'NIS atau email sudah digunakan.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }

    // Tampilkan detail siswa
    public function show($nis)
    {
        try {
            $siswa = Siswa::where('nis', $nis)
                ->with(['artikel', 'video', 'penghargaan'])
                ->firstOrFail();

            // Fix timestamps null (sekali saja)
            if (!$siswa->created_at) {
                $siswa->created_at = now();
            }
            if (!$siswa->updated_at) {
                $siswa->updated_at = now();
            }
            $siswa->saveQuietly(); // Save tanpa trigger events

            return view('siswa.detail', compact('siswa'));
        } catch (\Exception $e) {
            Log::error('Error loading siswa detail: ' . $e->getMessage());
            return redirect()->route('admin.siswa.index')->with('error', 'Gagal memuat detail siswa.');
        }
    }

    // Edit siswa via AJAX
    public function edit($nis)
    {
        try {
            $student = Siswa::where('nis', $nis)->firstOrFail();

            return response()->json([
                'nis' => $student->nis,
                'nama' => $student->nama,
                'email' => $student->email,
                'kelas' => $student->kelas
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading edit data for siswa ' . $nis . ': ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data siswa.'], 404);
        }
    }


    // Update siswa
    public function update(Request $request, $nis)
    {
        $student = Siswa::where('nis', $nis)->firstOrFail();

        $rules = [
            'nis' => ['required', 'string', 'max:20', Rule::unique('siswa', 'nis')->ignore($student->id)],
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('siswa', 'email')->ignore($student->id)],
            'kelas' => 'required|string|max:50|regex:/^[A-Za-z0-9\s]+$/',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        $validated = $request->validate($rules, [
            'nis.unique' => 'NIS sudah digunakan. Silakan gunakan NIS lain.',
            'email.unique' => 'Email sudah digunakan. Silakan gunakan email lain.',
        ]);

        try {
            $student->nis = $validated['nis'];
            $student->nama = $validated['nama'];
            $student->email = $validated['email'];
            $student->kelas = strtoupper(trim($validated['kelas']));

            if ($request->filled('password')) {
                $student->password = Hash::make($validated['password']);
            }

            $student->save();

            $this->logAdmin('update', 'Mengedit data siswa', $student->id, $validated);

            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Error updating siswa: ' . $e->getMessage());
            $this->logAdmin('gagal_update', 'Gagal mengedit data siswa', $student->id ?? null, [
                'nis' => $request->nis ?? '',
                'error' => $e->getMessage(),
            ]);

            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'NIS atau email sudah digunakan.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui siswa: ' . $e->getMessage());
        }
    }

    // Hapus siswa
    public function destroy($nis)
    {
        try {
            $student = Siswa::where('nis', $nis)->firstOrFail();

            $this->logAdmin('delete', 'Menghapus siswa', $student->id, [
                'nis' => $student->nis,
                'nama' => $student->nama,
                'kelas' => $student->kelas,
            ]);

            $student->delete();
            return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('Error deleting siswa ' . $nis . ': ' . $e->getMessage());
            $this->logAdmin('gagal_delete', 'Gagal menghapus siswa', $student->id ?? null, [
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }

    // Export CSV
    public function exportCsv()
    {
        try {
            $siswas = Siswa::all();
            $filename = 'siswa_' . date('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $this->logAdmin('export', 'Mengekspor data siswa', null, ['total' => $siswas->count()]);

            $callback = function () use ($siswas) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['NIS', 'Nama Lengkap', 'Email', 'Kelas']);

                foreach ($siswas as $siswa) {
                    fputcsv($file, [
                        $siswa->nis,
                        $siswa->nama,
                        $siswa->email,
                        $siswa->kelas,
                    ]);
                }
                fclose($file);
            };

            return new StreamedResponse($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error exporting siswa: ' . $e->getMessage());
            $this->logAdmin('gagal_export', 'Gagal mengekspor data siswa', null, ['error' => $e->getMessage()]);
            return redirect()->route('admin.siswa.index')->with('error', 'Gagal mengekspor data siswa.');
        }
    }

    // Import Excel/CSV
    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:10240',
            ]);

            Excel::import(new SiswaImport, $request->file('file'));

            $this->logAdmin('import', 'Mengimpor data siswa', null, ['file' => $request->file('file')->getClientOriginalName()]);

            return redirect()->back()->with('success', 'Data Siswa berhasil diimport!');
        } catch (\Exception $e) {
            Log::error('Error importing siswa: ' . $e->getMessage());
            $this->logAdmin('gagal_import', 'Gagal mengimpor data siswa', null, ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal mengimpor data siswa: ' . $e->getMessage());
        }
    }

    // Fungsi helper untuk log admin
    private function logAdmin($jenis, $aksi, $referensiId = null, $detail = [])
    {
        $adminId = Auth::guard('admin')->id();
        if ($adminId) {
            LogAdmin::create([
                'id_admin' => $adminId,
                'jenis_aksi' => $jenis,
                'aksi' => $aksi,
                'referensi_tipe' => 'siswa',
                'referensi_id' => $referensiId,
                'detail' => json_encode($detail),
                'dibuat_pada' => now(),
            ]);
        }
    }
}
