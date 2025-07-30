<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel; // Pastikan model Artikel sudah ada

class ArtikelController extends Controller
{
    public function index()
    {
        // Menampilkan daftar artikel
        $artikel = Artikel::all(); // Ambil semua data artikel dari database
        return view('artikel.artikel', compact('artikel')); // Pastikan view 'artikel.index' ada
    }

    public function create()
    {
        // Menampilkan form tambah artikel
        return view('artikel.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('artikel', 'public');
        }

        // Simpan ke database (pastikan model Artikel sudah ada)
        \App\Models\Artikel::create($validated);

        // Redirect ke halaman artikel dengan pesan sukses
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }
}