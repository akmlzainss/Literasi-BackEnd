@extends('layouts.app')

@section('title', 'Detail Artikel - ' . $artikel->judul)
@section('page-title', 'Detail Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">

    <div class="page-header">
        <h1 class="page-title">Detail Artikel</h1>
        <p class="page-subtitle">Lihat informasi lengkap artikel literasi akhlak</p>
        <div class="action-buttons">
            <a href="{{ route('admin.artikel.index') }}" class="btn-outline-custom">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="main-card detail-card full-width">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-book-open me-2"></i>{{ $artikel->judul }}
            </div>
        </div>
        <div class="card-body-custom">
            <div class="article-detail-content">
                <!-- Gambar -->
                <div class="article-detail-image">
                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://via.placeholder.com/800x450' }}"
                        alt="{{ $artikel->judul }}" class="img-fluid detail-image"
                        onerror="this.src='https://via.placeholder.com/800x450';">
                </div>

                <!-- Konten -->
                <div class="article-detail-text">
                    <div class="article-category mb-3">
                        <span class="category-tag">{{ $artikel->kategori->nama ?? 'Tanpa Kategori' }}</span>
                    </div>
                    <h2 class="article-title-detail">{{ $artikel->judul }}</h2>

                    <!-- Penulis -->
                    <div class="article-author-card mb-4">
                        <div class="author-avatar">{{ strtoupper(substr($artikel->penulis_nama, 0, 2)) }}</div>
                        <div class="author-info">
                            <div class="author-name">{{ $artikel->penulis_nama }}</div>
                            <div class="author-role">{{ $artikel->siswa->kelas ?? 'Administrator' }}</div>
                        </div>
                    </div>

                    <div class="article-content-detail mb-4">
                        {!! $artikel->isi !!}
                    </div>

                    <!-- Meta -->
                    <div class="article-meta-detail">
                        <p><strong>Jenis:</strong> {{ ucfirst($artikel->jenis) }}</p>
                        <p><strong>Status:</strong>
                            <span class="status-badge status-{{ $artikel->status }}">
                                {{ ucfirst($artikel->status) }}
                            </span>
                        </p>
                        <p><strong>Dibuat pada:</strong>
                            {{ $artikel->created_at ? $artikel->created_at->format('d M Y, H:i') : 'Tanggal tidak tersedia' }}
                        </p>
                        <p><strong>Diterbitkan pada:</strong>
                            {{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y, H:i') : 'Tanggal tidak tersedia' }}
                        </p>

                        <p><strong>Jumlah Dilihat:</strong> {{ $artikel->jumlah_dilihat }}</p>
                        <p><strong>Jumlah Suka:</strong> {{ $artikel->jumlah_suka }}</p>
                        <p><strong>Jumlah Komentar:</strong> {{ $artikel->komentarArtikel->count() }}</p>
                        <p><strong>Rating Artikel:</strong>
                            @php
                                $avgRating =
                                    $artikel->ratingArtikel->count() > 0
                                        ? round($artikel->ratingArtikel->avg('rating'), 1)
                                        : 0;
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $avgRating ? 'filled' : '' }}">&#9733;</span>
                            @endfor
                            ({{ $avgRating }}/5)
                        </p>
                    </div>

                    <!-- Komentar -->
                    <div class="comments-section mt-4">
                        <h3>Komentar</h3>

                        <!-- Daftar Komentar -->
                        @forelse ($artikel->komentarArtikel as $komentar)
                            <div class="comment-card mb-3">
                                <div class="comment-header d-flex align-items-center">
                                    <div class="comment-avatar">
                                        {{ strtoupper(substr($komentar->siswa->nama ?? ($komentar->admin->nama_pengguna ?? 'U'), 0, 2)) }}
                                    </div>
                                    <div class="comment-meta ms-2">
                                        <span class="author-name">
                                            @if ($komentar->siswa)
                                                {{ $komentar->siswa->nama }}
                                            @elseif ($komentar->admin)
                                                {{ $komentar->admin->nama_pengguna }}
                                            @else
                                                Pengguna Tidak Dikenal
                                            @endif
                                        </span>
                                        <small class="author-role">
                                            @if ($komentar->admin)
                                                Admin
                                            @elseif ($komentar->siswa)
                                                Siswa
                                            @else
                                                -
                                            @endif
                                        </small>
                                        <br>
                                        <small class="comment-date">
                                            {{ $komentar->dibuat_pada ? \Carbon\Carbon::parse($komentar->dibuat_pada)->format('d M Y, H:i') : 'Tanggal tidak tersedia' }}
                                        </small>
                                    </div>
                                </div>
                                <div class="comment-body mt-2">
                                    <p class="comment-text">{{ $komentar->komentar }}</p>
                                </div>

                                <!-- Tombol hapus (hanya pemilik komentar) -->
                                @if (
                                    (Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) ||
                                        (Auth::guard('admin')->check() && $komentar->id_admin == Auth::guard('admin')->id()))
                                    <form action="{{ route('admin.komentar.destroy', $komentar->id) }}" method="POST"
                                        class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <p>Belum ada komentar.</p>
                        @endforelse

                        <!-- Form Tambah Komentar -->
                        @if (Auth::guard('siswa')->check() || Auth::guard('admin')->check())
                            <div class="add-comment-form mt-4">
                                <form action="{{ route('admin.komentar.store', $artikel->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="komentar" class="form-control" rows="3" placeholder="Tulis komentar Anda..." required>{{ old('komentar') }}</textarea>
                                        @error('komentar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn-custom mt-2">Kirim Komentar</button>
                                </form>
                            </div>
                        @else
                            <p class="text-muted">Silakan <a href="{{ route('login') }}">login</a> untuk menambahkan
                                komentar.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
