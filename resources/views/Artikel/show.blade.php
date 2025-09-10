@extends('layouts.app')

@section('title', 'Detail Artikel - ' . $artikel->judul)
@section('page-title', 'Detail Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">

    <div class="page-header">
        <h1 class="page-title">Detail Artikel</h1>
        <p class="page-subtitle">Lihat informasi lengkap artikel literasi akhlak</p>
        <div class="action-buttons">
            <a href="{{ route('artikel') }}" class="btn-outline-custom">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar
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
                <div class="article-detail-image">
                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://via.placeholder.com/800x450' }}"
                        alt="{{ $artikel->judul }}" class="img-fluid detail-image"
                        onerror="this.src='https://via.placeholder.com/800x450';">
                </div>

                <div class="article-detail-text">
                    <div class="article-category mb-3">
                        <span class="category-tag">{{ $artikel->kategori->nama ?? 'Tanpa Kategori' }}</span>
                    </div>
                    <h2 class="article-title-detail">{{ $artikel->judul }}</h2>
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

                    <div class="article-meta-detail">
                        <p><strong>Jenis:</strong> {{ ucfirst($artikel->jenis) }}</p>
                        <p><strong>Status:</strong> <span
                                class="status-badge status-{{ $artikel->status }}">{{ ucfirst($artikel->status) }}</span>
                        </p>

                        {{-- PERBAIKAN DI SINI --}}
                        <p><strong>Dibuat pada:</strong> {{ $artikel->created_at?->format('d M Y, H:i') }}</p>

                        @if ($artikel->diterbitkan_pada)
                            <p><strong>Diterbitkan pada:</strong> {{ $artikel->diterbitkan_pada?->format('d M Y, H:i') }}
                            </p>
                        @endif

                        <p><strong>Jumlah Dilihat:</strong> {{ $artikel->jumlah_dilihat }}</p>
                        <p><strong>Jumlah Suka:</strong> {{ $artikel->jumlah_suka }}</p>
                        <p><strong>Jumlah Komentar:</strong> {{ $artikel->komentarArtikel->count() }}</p>
                        <p><strong>Rating:</strong>
                            @if ($artikel->ratingArtikel->count() > 0)
                                @php
                                    $avgRating = round($artikel->ratingArtikel->avg('rating'), 1);
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($avgRating))
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                                ({{ $avgRating }}/5)
                            @else
                                Belum ada rating
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
