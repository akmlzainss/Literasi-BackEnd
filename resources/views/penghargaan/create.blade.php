@extends('layouts.app')

@section('title', 'Tambah Penghargaan')
@section('page-title', 'Tambah Penghargaan Literasi Akhlak')

@section('content')
<link rel="stylesheet" href="{{ asset('css/penghargaan.css') }}">

<div class="page-header">
    <h1 class="page-title">Tambah Penghargaan Baru</h1>
    <p class="page-subtitle">Isi formulir berikut untuk menambahkan penghargaan baru</p>
    <a href="{{ route('admin.penghargaan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Penghargaan
    </a>
</div>

<div class="main-card">
    <div class="card-body-custom">
        <form action="{{ route('admin.penghargaan.store') }}" method="POST">
            @csrf

            {{-- Pilih Artikel (Top 5 Rating Tertinggi) --}}
            <div class="mb-3">
                <label for="id_artikel" class="form-label">Pilih Artikel (Top 5 Rating)</label>
                <select name="id_artikel" class="form-control" id="id_artikel">
                    <option value="">-- Pilih Artikel --</option>
                    @foreach ($topArtikel as $artikel)
                        <option value="{{ $artikel->id }}"
                            data-judul="{{ $artikel->judul }}"
                            data-nama="{{ $artikel->siswa->nama ?? 'Unknown' }}"
                            data-kelas="{{ $artikel->siswa->kelas ?? '-' }}"
                            data-foto="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/default.jpg') }}"
                            data-rating="{{ $artikel->rating }}">
                            {{ $artikel->judul }} (Rating: {{ $artikel->rating ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('id_artikel')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Info Artikel Preview --}}
            <div class="mb-3" id="artikelInfo" style="display: none;">
                <div class="card shadow-sm border-0" style="max-width: 500px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img id="artikelFoto" src="" class="img-fluid rounded-start" alt="Artikel Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title mb-1" id="artikelJudul"></h5>
                                <p class="card-text mb-1"><strong>Penulis:</strong> <span id="artikelPenulis"></span></p>
                                <p class="card-text mb-1"><strong>Kelas:</strong> <span id="artikelKelas"></span></p>
                                <p class="card-text mb-1">
                                    <strong>Rating:</strong> <span id="artikelRating"></span>
                                    <span id="artikelStars" class="ms-2"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bulan & Tahun --}}
            <div class="mb-3">
                <label for="bulan_tahun" class="form-label">Bulan dan Tahun</label>
                <input type="date" name="bulan_tahun" id="bulan_tahun" class="form-control"
                    value="{{ old('bulan_tahun', ($selectedMonth ?? now()->format('Y-m')) . '-01') }}" required>
                @error('bulan_tahun')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jenis --}}
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Penghargaan</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="bulanan" {{ old('jenis') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="spesial" {{ old('jenis') == 'spesial' ? 'selected' : '' }}>Spesial</option>
                </select>
                @error('jenis')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label for="deskripsi_penghargaan" class="form-label">Deskripsi Penghargaan</label>
                <textarea name="deskripsi_penghargaan" id="deskripsi_penghargaan" class="form-control" rows="4" required>{{ old('deskripsi_penghargaan') }}</textarea>
                @error('deskripsi_penghargaan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Simpan Penghargaan</button>
                <a href="{{ route('admin.penghargaan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const artikelSelect = document.getElementById('id_artikel');
    const artikelInfo = document.getElementById('artikelInfo');
    const artikelFoto = document.getElementById('artikelFoto');
    const artikelJudul = document.getElementById('artikelJudul');
    const artikelPenulis = document.getElementById('artikelPenulis');
    const artikelKelas = document.getElementById('artikelKelas');
    const artikelRating = document.getElementById('artikelRating');
    const artikelStars = document.getElementById('artikelStars');
    const deskripsi = document.getElementById('deskripsi_penghargaan');

    artikelSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            artikelInfo.style.display = 'block';
            artikelFoto.src = selected.dataset.foto;
            artikelJudul.textContent = selected.dataset.judul;
            artikelPenulis.textContent = selected.dataset.nama;
            artikelKelas.textContent = selected.dataset.kelas;
            artikelRating.textContent = selected.dataset.rating;

            // Generate bintang rating
            let rating = parseFloat(selected.dataset.rating) || 0;
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += (i <= rating) ? '⭐' : '☆';
            }
            artikelStars.innerHTML = starsHtml;

            // Auto isi deskripsi
            deskripsi.value = "Penghargaan untuk artikel: " + selected.dataset.judul;
        } else {
            artikelInfo.style.display = 'none';
            artikelFoto.src = "";
            artikelJudul.textContent = "";
            artikelPenulis.textContent = "";
            artikelKelas.textContent = "";
            artikelRating.textContent = "";
            artikelStars.innerHTML = "";
            deskripsi.value = "";
        }
    });
});
</script>
@endsection
