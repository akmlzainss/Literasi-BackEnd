@extends('layouts.app')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="css/artikel.css">

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Edit Artikel</h1>
        <p class="page-subtitle">Ubah data artikel literasi akhlak</p>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-body-custom">
            <form action="{{ route('artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Artikel</label>
                    <input type="text" name="judul" id="judul" class="form-control" value="{{ $artikel->judul }}" required>
                </div>
                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Artikel</label>
                    <textarea name="isi" id="isi" class="form-control" rows="6" required>{{ $artikel->isi }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar (opsional)</label>
                    <input type="file" name="gambar" id="gambar" class="form-control">
                    @if ($artikel->gambar)
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar Saat Ini" style="max-width: 200px; margin-top: 10px;">
                    @endif
                </div>
                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select">
                        <option value="">Pilih Kategori</option>
                        @foreach (\App\Models\Kategori::all() as $kategori)
                            <option value="{{ $kategori->id }}" {{ $artikel->id_kategori == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_siswa" class="form-label">Siswa</label>
                    <select name="id_siswa" id="id_siswa" class="form-select" required>
                        <option value="">Pilih Siswa</option>
                        @foreach (\App\Models\Siswa::all() as $siswa)
                            <option value="{{ $siswa->id }}" {{ $artikel->id_siswa == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select name="jenis" id="jenis" class="form-select" required>
                        <option value="bebas" {{ $artikel->jenis == 'bebas' ? 'selected' : '' }}>Bebas</option>
                        <option value="resensi_buku" {{ $artikel->jenis == 'resensi_buku' ? 'selected' : '' }}>Resensi Buku</option>
                        <option value="resensi_film" {{ $artikel->jenis == 'resensi_film' ? 'selected' : '' }}>Resensi Film</option>
                        <option value="video" {{ $artikel->jenis == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="menunggu" {{ $artikel->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="draf" {{ $artikel->status == 'draf' ? 'selected' : '' }}>Draf</option>
                        <option value="disetujui" {{ $artikel->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $artikel->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('artikel') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection