@extends('layouts.app')

@section('title', 'Detail Artikel - ' . $artikel->judul)
@section('page-title', 'Detail Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Enhanced Styles -->
    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #3b82f6;
            --dark-blue: #1e40af;
            --accent-blue: #60a5fa;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --border-light: #e2e8f0;

            --primary-gradient: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            --secondary-gradient: linear-gradient(135deg, var(--light-blue) 0%, var(--accent-blue) 100%);
            --success-gradient: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            --danger-gradient: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            --card-shadow: var(--shadow-lg);
            --hover-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --glass-bg: rgba(248, 250, 252, 0.95);
            --glass-border: rgba(37, 99, 235, 0.1);
        }

        body {
            background: linear-gradient(135deg, var(--bg-light) 0%, #dbeafe 50%, #eff6ff 100%);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(96, 165, 250, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .page-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            margin: 0.5rem 0 1.5rem 0;
            opacity: 0.8;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 45px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
        }

        .btn-outline-custom:hover {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            color: white;
            border: 2px solid transparent;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }

        .btn-danger-custom {
            background: var(--danger-gradient);
            color: white;
            border: 2px solid transparent;
        }

        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
        }

        .main-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .main-card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-2px);
        }

        .card-header-custom {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 2rem;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            position: relative;
        }

        .card-header-custom::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        .card-body-custom {
            padding: 2rem;
        }

        .article-detail-image {
            text-align: center;
            margin-bottom: 2rem;
        }

        .article-detail-image img {
            max-width: 100%;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .article-detail-image img:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }

        .article-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(30, 64, 175, 0.05) 100%);
            border-radius: 16px;
            border: 1px solid var(--glass-border);
        }

        .meta-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid var(--border-light);
        }

        .meta-item:hover {
            background: var(--bg-white);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .meta-item i {
            color: var(--primary-blue);
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-dark);
            padding: 2rem;
            background: rgba(248, 250, 252, 0.9);
            border-radius: 16px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow);
        }

        .article-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(30, 64, 175, 0.05) 100%);
            border-radius: 16px;
            margin: 2rem 0;
        }

        .stats-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 1.5rem;
            background: rgba(248, 250, 252, 0.9);
            border-radius: 50px;
            font-weight: 600;
            color: var(--text-dark);
            transition: all 0.3s ease;
            border: 1px solid var(--border-light);
        }

        .stats-item:hover {
            background: var(--bg-white);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .stats-item i {
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .article-rating {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 152, 0, 0.1) 100%);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 193, 7, 0.2);
            margin: 2rem 0;
        }

        .rating-display {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin: 1rem 0;
        }

        .stars {
            display: flex;
            gap: 0.25rem;
        }

        .stars i {
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .rating-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #666;
        }

        .rating-value {
            font-size: 1.5rem;
            color: #ffc107;
            font-weight: 700;
        }

        .article-comments {
            background: rgba(255, 255, 255, 0.6);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .comment-form {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .form-control {
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }

        .select2-container--default .select2-selection--single {
            height: 45px !important;
            border: 2px solid rgba(102, 126, 234, 0.2) !important;
            border-radius: 12px !important;
            background: rgba(255, 255, 255, 0.9) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 41px !important;
            padding-left: 15px !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px 20px 0 0;
        }

        .modal-footer {
            border-top: 1px solid rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.5);
            border-radius: 0 0 20px 20px;
        }

        .custom-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border: none;
            border-radius: 12px;
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-lg);
            animation: slideInRight 0.3s ease;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.9);
            color: white;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn {
                margin-bottom: 0.5rem;
            }
            
            .article-meta {
                grid-template-columns: 1fr;
            }
            
            .article-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .card-body-custom {
                padding: 1rem;
            }
        }

        /* Enhanced animations */
        .main-card {
            animation: fadeInUp 0.6s ease;
        }

        .page-header {
            animation: fadeInDown 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating elements effect */
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>

    <div class="page-header floating-element">
        <h1 class="page-title">Detail Artikel</h1>
        <p class="page-subtitle">Lihat informasi lengkap artikel literasi akhlak</p>
        <div class="action-buttons">
            <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-custom">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>
            @if (Auth::guard('admin')->check())
                <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn btn-primary-custom">
                    <i class="fas fa-edit me-2"></i>Edit Artikel
                </a>
                <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" style="display:inline;"
                    id="deleteForm_{{ $artikel->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger-custom no-loading" onclick="confirmDelete({{ $artikel->id }})">
                        <i class="fas fa-trash me-2"></i>Hapus Artikel
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="main-card detail-card full-width">
        <div class="card-header-custom">
            <i class="fas fa-book-open me-2"></i>{{ $artikel->judul }}
        </div>
        <div class="card-body-custom">
            <div class="article-detail-content">
                <div class="article-detail-image">
                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}"
                        alt="{{ $artikel->judul }}"
                        onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}';"
                        class="floating-element">
                </div>
                <div class="article-meta">
                    <div class="meta-item">
                        <i class="fas fa-folder me-1"></i>
                        <span>Kategori: {{ $artikel->kategori->nama ?? 'Tanpa Kategori' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-user me-1"></i>
                        <span>Penulis:
                            {{ $artikel->penulis_type === 'siswa' && $artikel->siswa ? $artikel->siswa->nama : 'Admin' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt me-1"></i>
                        <span>Diterbitkan:
                            {{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : 'Belum diterbitkan' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-check-circle me-1"></i>
                        <span>Status: {{ ucfirst($artikel->status) }}</span>
                    </div>
                    @if ($artikel->status === 'ditolak' && $artikel->alasan_penolakan)
                        <div class="meta-item text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <span>Alasan Penolakan: {{ $artikel->alasan_penolakan }}</span>
                        </div>
                    @endif
                </div>
                <div class="article-content mt-4">
                    {!! $artikel->isi !!}
                </div>
                <div class="article-stats mt-4">
                    <div class="stats-item">
                        <i class="fas fa-eye me-1"></i> {{ $artikel->jumlah_dilihat }} Dilihat
                    </div>
                    <div class="stats-item">
                        <i class="fas fa-heart me-1"></i> {{ $artikel->jumlah_suka }} Suka
                    </div>
                    <div class="stats-item">
                        <i class="fas fa-comment me-1"></i>
                        {{ $artikel->komentarArtikel->where('id_komentar_parent', null)->count() }} Komentar
                    </div>
                </div>
                <div class="article-rating mt-4">
                    <h5><i class="fas fa-star text-warning me-2"></i>Rating Artikel</h5>
                    <div class="rating-display">
                        @php
                            $rating = $avgRating ?? ($artikel->nilai_rata_rata ?? 0);
                            $totalReviews = $artikel->ratingArtikel->count();
                            $fullStars = floor($rating);
                            $hasHalfStar = $rating - $fullStars >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                        @endphp
                        <div class="stars">
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star star-filled text-warning"></i>
                            @endfor
                            @if ($hasHalfStar)
                                <i class="fas fa-star-half-alt star-half text-warning"></i>
                            @endif
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star star-empty text-warning"></i>
                            @endfor
                        </div>
                        <div class="rating-info">
                            <span class="rating-value">{{ number_format($rating, 1) }}</span>
                            <span class="rating-count">({{ $totalReviews }} ulasan)</span>
                        </div>
                    </div>
                    @if (Auth::guard('admin')->check() || Auth::guard('siswa')->check())
                        <form id="ratingForm" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label for="rating"><i class="fas fa-star text-warning me-1"></i>Beri Rating:</label>
                                <div class="d-flex align-items-center gap-3 mt-2">
                                    <select name="rating" id="rating" class="form-select w-auto">
                                        <option value="">Pilih Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">⭐ {{ $i }}</option>
                                        @endfor
                                    </sele
                                    <button type="submit" class="btn btn-primary-custom no-loading">

                                    <button type="submit" class="btn btn-primary-custom">

                                        <i class="fas fa-star me-1"></i>Simpan Rating
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            <div class="article-comments mt-5">

                <h5><i class="fas fa-comments me-2" style="color: var(--primary-blue);"></i>Komentar ({{ $artikel->komentarArtikel->where('id_komentar_parent', null)->count() }})</h5>

                        <h5><i class="fas fa-comments me-2" style="color: var(--primary-blue);"></i>Komentar ({{ $artikel->komentarArtikel->where('id_komentar_parent', null)->count() }})</h5>
                @php
                    $rootComments = $artikel->komentarArtikel->where('id_komentar_parent', null);
                @endphp
                @if ($rootComments->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted fs-5">Belum ada komentar untuk artikel ini.</p>
                        <p class="text-muted">Jadilah yang pertama memberikan komentar!</p>
                    </div>
                @else
                    @foreach ($rootComments as $comment)
                        <x-comment-card :comment="$comment" :depth="0" :artikel="$artikel" />
                    @endforeach
                @endif
                @if (Auth::guard('admin')->check() || Auth::guard('siswa')->check())
                    <div class="comment-form mt-4">
                        <h5><i class="fas fa-plus-circle me-2" style="color: var(--primary-blue);"></i>Tambahkan Komentar</h5>
                        <form
                            action="{{ Auth::guard('siswa')->check() ? route('artikel-siswa.komentar.store', $artikel->id) : route('admin.komentar.store', $artikel->id) }}"
                            method="POST" id="commentForm">
                            @csrf
                            <input type="hidden" name="id_komentar_parent" value="">
                            <input type="hidden" name="depth" value="0">
                            <div class="form-group">
                                <textarea name="komentar" id="commentInput" class="form-control @error('komentar') is-invalid @enderror" rows="4"
                                    placeholder="Tulis komentar Anda..." required>{{ old('komentar') }}</textarea>
                                @error('komentar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary-custom mt-3">
                                <i class="fas fa-comment me-1"></i>Kirim Komentar
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Artikel -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Artikel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p class="fs-5">Apakah Anda yakin ingin menghapus artikel ini?</p>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>

                    <button type="button" class="btn btn-danger-custom no-loading" id="confirmDeleteBtn">

                    <button type="button" class="btn btn-danger-custom" id="confirmDeleteBtn">

                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Komentar -->
    <div class="modal fade" id="deleteCommentConfirmModal" tabindex="-1"
        aria-labelledby="deleteCommentConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCommentConfirmModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Komentar
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-comment-slash fa-3x text-danger mb-3"></i>
                    <p class="fs-5">Apakah Anda yakin ingin menghapus komentar ini?</p>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>

                    <button type="button" class="btn btn-danger-custom no-loading" id="confirmDeleteCommentBtn">

                    <button type="button" class="btn btn-danger-custom" id="confirmDeleteCommentBtn">

                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk rating
            $('#rating').select2({
                placeholder: 'Pilih Rating',
                allowClear: true,
                minimumResultsForSearch: Infinity
            });

            // AJAX untuk Rating
            $('#ratingForm').on('submit', function(e) {
                e.preventDefault();
                const rating = $('#rating').val();
                if (!rating) {
                    showAlert('error', 'Harap pilih rating terlebih dahulu.');
                    return;
                }

                $.ajax({
                    url: '{{ Auth::guard('siswa')->check() ? route('artikel-siswa.rate', $artikel->id) : route('admin.artikel.rate', $artikel->id) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        rating: rating
                    },
                    beforeSend: function() {
                        $('#ratingForm button').html(
                            '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
                    },
                    success: function(response) {
                        showAlert('success', response.message);
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        showAlert('error', xhr.responseJSON?.message || 'Gagal menyimpan rating.');
                    },
                    complete: function() {
                        $('#ratingForm button').html(
                            '<i class="fas fa-star me-1"></i>Simpan Rating').prop('disabled', false);
                    }
                });
            });

            // Konfirmasi Hapus Artikel
            window.confirmDelete = function(id) {
                $('#deleteConfirmModal').modal('show');
                $('#confirmDeleteBtn').off('click').on('click', function() {
                    const form = $('#deleteForm_' + id);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        beforeSend: function() {
                            $('#confirmDeleteBtn').html(
                                '<i class="fas fa-spinner fa-spin"></i> Menghapus...');
                        },
                        success: function(response) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('success', response.message);
                            setTimeout(() => window.location.href = response.redirect, 1500);
                        },
                        error: function(xhr) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('error', xhr.responseJSON?.message || 'Gagal menghapus artikel.');
                        },
                        complete: function() {
                            $('#confirmDeleteBtn').html('<i class="fas fa-trash me-1"></i>Hapus');
                        }
                    });
                });
            };

            // Konfirmasi Hapus Komentar
            window.confirmDeleteComment = function(id) {
                $('#deleteCommentConfirmModal').modal('show');
                $('#confirmDeleteCommentBtn').off('click').on('click', function() {
                    const form = $('#deleteCommentForm_' + id);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        beforeSend: function() {
                            $('#confirmDeleteCommentBtn').html(
                                '<i class="fas fa-spinner fa-spin"></i> Menghapus...');
                        },
                        success: function(response) {
                            $('#deleteCommentConfirmModal').modal('hide');
                            showAlert('success', response.message || 'Komentar berhasil dihapus!');
                            $('#comment_' + id).fadeOut(() => $('#comment_' + id).remove());
                        },
                        error: function(xhr) {
                            $('#deleteCommentConfirmModal').modal('hide');
                            showAlert('error', xhr.responseJSON?.message || 'Gagal menghapus komentar.');
                        },
                        complete: function() {
                            $('#confirmDeleteCommentBtn').html('<i class="fas fa-trash me-1"></i>Hapus');
                        }
                    });
                });
            };

            // Edit Komentar
            window.editComment = function(id) {
                $('#commentBody_' + id).addClass('d-none');
                $('#editCommentForm_' + id).removeClass('d-none');
            };

            window.cancelEditComment = function(id) {
                $('#commentBody_' + id).removeClass('d-none');
                $('#editCommentForm_' + id).addClass('d-none');
            };

            // Balas Komentar
            window.showReplyForm = function(id) {
                $('#replyForm_' + id).removeClass('d-none');
            };

            window.hideReplyForm = function(id) {
                $('#replyForm_' + id).addClass('d-none');
            };

            // Fungsi Alert dengan enhanced design
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show custom-alert" role="alert">
                        <i class="fas ${iconClass} me-2"></i>${message}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.custom-alert').remove();
                $('body').append(alertHtml);
                setTimeout(() => $('.custom-alert').fadeOut(() => $('.custom-alert').remove()), 5000);
            }

            // Tangani alert dari sesi
            @if (session('success'))
                showAlert('success', '{{ session('success') }}');
            @endif
            @if (session('error'))
                showAlert('error', '{{ session('error') }}');
            @endif

            // Enhanced scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Apply animation to elements
            document.querySelectorAll('.meta-item, .stats-item').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'all 0.6s ease';
                observer.observe(el);
            });

            // Smooth scroll for anchors
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            });

            // Add loading state to all buttons
            $('.btn').on('click', function(e) {
                if (!$(this).hasClass('no-loading')) {
                    const $btn = $(this);
                    const originalText = $btn.html();
                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Memproses...');
                    
                    setTimeout(() => {
                        $btn.prop('disabled', false).html(originalText);
                    }, 2000);
                }
            });


            // Enhanced hover effects for interactive elements
            $('.stats-item, .meta-item').hover(
                function() {
                    $(this).css('transform', 'translateY(-3px) scale(1.02)');
                },
                function() {
                    $(this).css('transform', 'translateY(0) scale(1)');
                }
            );

            // Parallax effect for background
            $(window).scroll(function() {
                const scrolled = $(this).scrollTop();
                const rate = scrolled * -0.5;
                $('body::before').css('transform', 'translateY(' + rate + 'px)');
            });

            // Add ripple effect to buttons (exclude buttons with no-loading class)
            $('.btn:not(.no-loading)').on('click', function(e) {
            // Add ripple effect to buttons
            $('.btn').on('click', function(e) {
                const $btn = $(this);
                const ripple = $('<span class="ripple"></span>');
                $btn.append(ripple);

                const x = e.offsetX;
                const y = e.offsetY;

                ripple.css({
                    left: x + 'px',
                    top: y + 'px'
                });

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });

            // Add CSS for ripple effect
            $('<style>')
                .prop('type', 'text/css')
                .html(`
                    .btn {
                        position: relative;
                        overflow: hidden;
                    }
                    .ripple {
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.6);
                        transform: scale(0);
                        animation: ripple-animation 0.6s linear;
                        pointer-events: none;
                    }
                    @keyframes ripple-animation {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                `)
                .appendTo('head');

        });
    </script>
@endsection