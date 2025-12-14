<?php

use App\Http\Controllers\Controller;

namespace App\Http\Controllers\Admin;

use App\Models\AktivitasSiswa;
use Illuminate\Http\Request;

class AktivitasSiswaController extends Controller
{
    // Tampilkan laporan aktivitas siswa
    public function laporan()
    {
        $aktivitas = AktivitasSiswa::latest()->get();
        return view('admin.laporan.laporan', compact('aktivitas'));
    }

    // Simpan data aktivitas siswa
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'aktivitas' => 'required|string|max:255',
            'artikel' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        AktivitasSiswa::create($validated);

        return redirect()->back()->with('success', 'Aktivitas siswa berhasil disimpan.');
    }
}
