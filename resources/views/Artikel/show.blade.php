@extends('layouts.app')

@section('title', 'Detail Artikel - {{ $artikel->judul }}')
@section('page-title', 'Detail Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">

    <!-- Page Header -->
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

    <!-- Article Detail Card -->
    <div class="main-card detail-card full-width">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-book-open me-2"></i>{{ $artikel->judul }}
            </div>
        </div>
        <div class="card-body-custom">
            <div class="article-detail-content">
                <!-- Image Section -->
                <div class="article-detail-image">
                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://via.placeholder.com/800x600' }}"
                         alt="{{ $artikel->judul }}" class="img-fluid detail-image"
                         onerror="this.src='https://via.placeholder.com/800x600'; console.log('Gagal memuat gambar: ' + this.src);">
                </div>

                <!-- Article Content -->
                <div class="article-detail-text">
                    <div class="article-category mb-3">
                        <span class="category-tag">{{ $artikel->kategori->nama ?? 'Tanpa Kategori' }}</span>
                    </div>
                    <h2 class="article-title-detail">{{ $artikel->judul }}</h2>
                    <div class="article-author-card mb-4">
                        <div class="author-avatar">{{ substr($artikel->siswa->nama ?? 'Unknown', 0, 2) }}</div>
                        <div class="author-info">
                            <div class="author-name">{{ $artikel->siswa->nama ?? 'Unknown' }}</div>
                            <div class="author-role">{{ $artikel->siswa->role ?? 'Siswa' }}</div>
                        </div>
                    </div>
                    <div class="article-content-detail mb-4">
                        {!! nl2br(e($artikel->isi)) !!}
                    </div>
                    <div class="article-meta-detail">
                        <p><strong>Jenis:</strong> {{ $artikel->jenis }}</p>
                        <p><strong>Status:</strong> <span
                                class="status-badge status-{{ $artikel->status == 'disetujui' && $artikel->diterbitkan_pada ? 'published' : ($artikel->status == 'draf' ? 'draft' : 'archived') }}">{{ ucfirst($artikel->status) }}</span>
                        </p>
                        <p><strong>Dibuat pada:</strong>
                            {{ $artikel->dibuat_pada instanceof \Carbon\Carbon ? $artikel->dibuat_pada->format('d M Y') : \Carbon\Carbon::parse($artikel->dibuat_pada)->format('d M Y') }}
                        </p>
                        @if ($artikel->diterbitkan_pada)
                            <p><strong>Diterbitkan pada:</strong>
                                {{ $artikel->diterbitkan_pada instanceof \Carbon\Carbon ? $artikel->diterbitkan_pada->format('d M Y') : \Carbon\Carbon::parse($artikel->diterbitkan_pada)->format('d M Y') }}
                            </p>
                        @endif
                        <p><strong>Jumlah Dilihat:</strong> {{ $artikel->jumlah_dilihat }}</p>
                        <p><strong>Jumlah Suka:</strong> {{ $artikel->jumlah_suka }}</p>
                        <p><strong>Jumlah Komentar:</strong> {{ $artikel->komentarArtikel->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection