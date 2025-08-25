<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash; // Import the Hash facade

class KelolaSiswaController extends Controller
{
    /**
     * Display a paginated list of students with search, filter, and sort functionality.
     */
    public function index(Request $request)
    {
        $query = Siswa::query();

        // Allowed class levels for filtering
        $kelasOptions = ['X', 'XI', 'XII'];

        // General search by NIS, Name, or Email
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('nis', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        // Filter by class level (X, XI, XII)
        if ($request->filled('kelas')) {
            $kelas = strtoupper(trim($request->input('kelas')));
            if (in_array($kelas, $kelasOptions)) {
                $query->whereRaw("UPPER(SUBSTRING_INDEX(kelas, ' ', 1)) = ?", [$kelas]);
            }
        }

        // Sorting logic
        $sort = $request->input('sort', 'created_at_desc');
        match ($sort) {
            'nama_asc' => $query->orderBy('nama', 'asc'),
            'nama_desc' => $query->orderBy('nama', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $siswa = $query->paginate(10);

        return view('siswa.siswa', compact('siswa', 'kelasOptions'));
    }

    /**
     * Store a new student in the database.
     */
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
                'password' => Hash::make($validated['password']), // Updated to Hash::make()
            ]);

            return redirect()->route('siswa')->with('success', 'Siswa berhasil ditambahkan.');
        } catch (QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->with('error', 'NIS atau email sudah digunakan.');
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified student's details.
     */
    public function show($nis)
    {
        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        return view('siswa.detail', compact('siswa'));
    }

    /**
     * Return student data as JSON for editing.
     */
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

    /**
     * Update the specified student in the database.
     */
    public function update(Request $request, $nis)
    {
        $student = Siswa::where('nis', $nis)->firstOrFail();

        $rules = [
            'nis' => ['required', 'string', 'max:20', Rule::unique('siswa', 'nis')->ignore($student->id)],
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('siswa', 'email')->ignore($student->id)],
            'kelas' => 'required|string|max:50|regex:/^[A-Za-z0-9\s]+$/',
        ];

        // Add password validation rule only if a new password is provided
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
                $student->password = Hash::make($validated['password']); // Updated to Hash::make()
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

    /**
     * Remove the specified student from the database.
     */
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