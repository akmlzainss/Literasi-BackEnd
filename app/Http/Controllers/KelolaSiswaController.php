<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class KelolaSiswaController extends Controller
{
   public function index(Request $request)
{
    $query = Siswa::query();

    // Daftar kelas yang diizinkan
    $kelasOptions = ['X', 'XI', 'XII'];

    // Pencarian umum (NIS, Nama, Email)
    if ($request->filled('q')) {
        $q = trim($request->input('q'));
        $query->where(function ($sub) use ($q) {    
            $sub->where('nis', 'like', "%{$q}%")
                ->orWhere('nama', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%");
        });
    }

    // Filter kelas (X, XI, XII) — akurat hanya berdasarkan awalan kelas
    if ($request->filled('kelas')) {
        $kelas = strtoupper(trim($request->input('kelas')));
        if (in_array($kelas, $kelasOptions)) {
            $query->whereRaw("UPPER(SUBSTRING_INDEX(kelas, ' ', 1)) = ?", [$kelas]);
        }
    }

    // Sorting
    if ($request->filled('sort')) {
        $sort = $request->input('sort');
        if ($sort === 'nama_asc') {
            $query->orderBy('nama', 'asc');
        } elseif ($sort === 'nama_desc') {
            $query->orderBy('nama', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
    } else {
        $query->orderBy('created_at', 'desc');
    }

    // Pagination
    $siswa = $query->paginate(10);

    return view('siswa.siswa', compact('siswa', 'kelasOptions'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:siswa,nis|max:20',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:siswa,email|max:255',
            'kelas' => 'required|string|max:50|regex:/^[A-Za-z0-9\s]+$/',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            Siswa::create([
                'nis' => $validated['nis'],
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'kelas' => strtoupper(trim($validated['kelas'])),
                'password' => bcrypt($validated['password']),
            ]);

            return redirect()->route('siswa')->with('success', 'Siswa berhasil ditambahkan.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'NIS atau email sudah digunakan.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }

    public function show($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        return view('siswa.detail', compact('siswa'));
    }

    public function edit($nis)
    {
        $student = Siswa::where('nis', $nis)->firstOrFail();

        return response()->json([
            'nis' => $student->nis,
            'nama' => $student->nama,
            'email' => $student->email,
            'kelas' => $student->kelas,
        ]);
    }

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

        $validated = $request->validate($rules);

        try {
            $student->nis = $validated['nis'];
            $student->nama = $validated['nama'];
            $student->email = $validated['email'];
            $student->kelas = strtoupper(trim($validated['kelas']));
            if ($request->filled('password')) {
                $student->password = bcrypt($validated['password']);
            }
            $student->save();

            return redirect()->route('siswa')->with('success', 'Siswa berhasil diperbarui.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'NIS atau email sudah digunakan.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui siswa: ' . $e->getMessage());
        }
    }

    public function destroy($nis)
    {
        $student = Siswa::where('nis', $nis)->firstOrFail();

        try {
            $student->delete();
            return redirect()->route('siswa')->with('success', 'Siswa berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }
}
