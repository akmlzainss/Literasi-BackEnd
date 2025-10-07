@extends('layouts.layouts')

@section('title', $konten->judul . ' - SiPena')

@section('body_class', 'page-artikel-detail')

@php \Carbon\Carbon::setLocale('id'); @endphp
 <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@section('content')
    <div class="container py-4">
        <section class="content-section">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <a href="{{ session('previous_artikel_url', route('artikel-siswa.index')) }}"
                            class="btn-kembali mb-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        @if ($konten->gambar)
                            <img src="{{ asset('storage/' . $konten->gambar) }}"
                                alt="{{ $konten->judul ?? 'Gambar Artikel' }}" class="detail-page-image"
                                onerror="this.src='{{ asset('images/fallback.jpg') }}';">
                        @else
                            <img src="{{ asset('images/fallback.jpg') }}" alt="Gambar Default" class="detail-page-image">
                        @endif
                        <div class="author-card-siswa mt-3">
                            <div class="author-avatar-siswa">
                                {{ strtoupper(substr($konten->siswa->nama ?? 'AD', 0, 2)) }}
                            </div>
                            <div class="author-info-siswa">
                                <p class="name">{{ $konten->siswa->nama ?? 'Admin' }}</p>
                                <p class="date">
                                    Dipublikasikan pada
                                    {{ $konten->created_at ? $konten->created_at->translatedFormat('d F Y') : 'Tanggal tidak tersedia' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <article>
                        <header>
                            <span
                                class="badge bg-primary-subtle text-primary-emphasis rounded-pill mb-3 fs-6">{{ $konten->kategori->nama ?? 'Umum' }}</span>
                            <h1 class="detail-page-title">{{ $konten->judul ?? 'Judul Tidak Tersedia' }}</h1>
                            <div class="meta-info">
                                <span><i class="fas fa-eye"></i> {{ $konten->jumlah_dilihat ?? 0 }} Dilihat</span>
                                <span id="comment-count"><i class="fas fa-comments"></i>
                                    {{ $konten->komentarArtikel->count() ?? 0 }} Komentar</span>
                                <span id="rating-summary">
                                    <i class="fas fa-star"></i>
                                    @if ($konten->ratingArtikel->count() > 0)
                                        {{ round($konten->ratingArtikel->avg('rating'), 1) }}/5
                                    @else
                                        Belum ada rating
                                    @endif
                                </span>
                                <span id="like-count"><i class="fas fa-heart"></i> {{ $konten->jumlah_suka ?? 0 }}
                                    Suka</span>
                            </div>
                        </header>
                        <div class="article-body mt-4">{!! $konten->isi ?? 'Konten tidak tersedia' !!}</div>
                    </article>

                    @auth('siswa')
                        <div class="action-buttons-wrapper mt-4">
                            <button class="btn-action {{ $userHasLiked ? 'active' : '' }}" data-action="suka"
                                data-id="{{ $konten->id }}">
                                <i class="{{ $userHasLiked ? 'fas' : 'far' }} fa-heart"></i> Suka
                            </button>
                            <button class="btn-action {{ $userHasBookmarked ? 'active' : '' }}" data-action="bookmark"
                                data-id="{{ $konten->id }}">
                                <i class="{{ $userHasBookmarked ? 'fas' : 'far' }} fa-bookmark"></i> Simpan
                            </button>
                        </div>
                    @endauth

                    <div class="feedback-section mt-4">
                        @auth('siswa')
                            <form id="feedbackForm" action="{{ route('komentar.store', $konten->id) }}" method="POST">
                                @csrf
                                <h3 class="mb-3">Beri Tanggapan Anda</h3>
                                <div class="mb-3">
                                    <label class="form-label">Beri Rating:</label>
                                    <div class="rating-stars-modern">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating"
                                                value="{{ $i }}"
                                                {{ $userRating && $userRating->rating == $i ? 'checked' : '' }}
                                                class="rating-input">
                                            <label for="star{{ $i }}" class="rating-label"
                                                title="{{ ['Buruk', 'Kurang', 'Cukup', 'Bagus', 'Luar Biasa'][$i - 1] }}">
                                                <i class="fas fa-star"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="komentar" class="form-label">Tulis Komentar:</label>
                                    <textarea class="form-control" id="komentar" name="komentar" rows="4" placeholder="Bagikan pendapat Anda..."></textarea>
                                </div>
                                <button type="submit" id="submitBtn" class="btn btn-primary">Kirim Tanggapan</button>
                            </form>
                        @else
                            <div class="text-center p-4 border rounded">
                                <p class="mb-1">Silakan <a href="{{ route('login') }}">masuk</a> untuk memberi rating dan
                                    komentar.</p>
                            </div>
                        @endauth

                        {{-- SECTION: KOMENTAR YANG SUDAH DIPERBAIKI --}}
                        <div class="komentar-section mt-5">
                            <div class="komentar-header">
                                <h3 id="comment-title">
                                    <i class="fas fa-comments"></i>
                                    Komentar ({{ $konten->komentarArtikel->count() }})
                                </h3>
                            </div>

                            <div id="comment-list" class="comment-list-wrapper">
                                @forelse($konten->komentarArtikel as $komentar)
                                    <div class="komentar-item" id="komentar-{{ $komentar->id }}">
                                        {{-- Header Komentar --}}
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="author-avatar-siswa">
                                                {{ strtoupper(substr($komentar->siswa->nama ?? 'AN', 0, 2)) }}
                                            </div>
                                            
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <p class="name mb-1">{{ $komentar->siswa->nama ?? 'Anonim' }}</p>
                                                        <p class="date">
                                                            <i class="far fa-clock me-1"></i>
                                                            {{ optional($komentar->created_at)->diffForHumans() ?? '-' }}

                                                        </p>
                                                    </div>
                                                    
                                                    @auth('siswa')
                                                        @if(auth('siswa')->id() === $komentar->siswa_id)
                                                            <button class="btn-delete delete-comment" data-id="{{ $komentar->id }}" title="Hapus komentar">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        @endif
                                                    @endauth
                                                </div>

                                                {{-- Isi Komentar --}}
                                                <div class="komentar-text">
                                                    {{ $komentar->komentar }}
                                                </div>

                                                {{-- Tombol Aksi --}}
                                                @auth('siswa')
                                                    <div class="komentar-actions mt-3">
                                                        <button class="btn-reply" data-id="{{ $komentar->id }}">
                                                            <i class="fas fa-reply"></i> Balas
                                                        </button>
                                                    </div>

                                                    {{-- Form Balasan --}}
                                                    <div class="reply-form" data-parent-id="{{ $komentar->id }}">
                                                        <form action="{{ route('komentar.store', $konten->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="parent_id" value="{{ $komentar->id }}">
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">
                                                                    <i class="fas fa-comment-dots me-2"></i>Tulis Balasan
                                                                </label>
                                                                <textarea 
                                                                    class="form-control" 
                                                                    name="komentar" 
                                                                    rows="3" 
                                                                    placeholder="Tulis balasan Anda..." 
                                                                    required></textarea>
                                                            </div>
                                                            
                                                            <div class="d-flex gap-2">
                                                                <button type="submit" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-paper-plane me-1"></i> Kirim
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-secondary btn-cancel-reply">
                                                                    <i class="fas fa-times me-1"></i> Batal
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endauth

                                                {{-- Balasan Komentar --}}
                                                @if($komentar->balasan && $komentar->balasan->count() > 0)

                                                    <div class="komentar-replies">
                                                        @foreach($komentar->balasan as $balasan)
                                                            <div class="komentar-item komentar-reply" id="komentar-{{ $balasan->id }}">
                                                                <div class="d-flex align-items-start gap-3">
                                                                    <div class="author-avatar-siswa author-avatar-small">
                                                                        {{ strtoupper(substr($balasan->siswa->nama ?? 'AN', 0, 2)) }}
                                                                    </div>
                                                                    
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                                            <div>
                                                                                <p class="name mb-1">{{ $balasan->siswa->nama ?? 'Anonim' }}</p>
                                                                                <p class="date">
                                                                                    <i class="far fa-clock me-1"></i>
                                                                                    {{ $balasan->created_at->diffForHumans() }}
                                                                                </p>
                                                                            </div>
                                                                            
                                                                            @auth('siswa')
                                                                                @if(auth('siswa')->id() === $balasan->siswa_id)
                                                                                    <button class="btn-delete delete-comment" data-id="{{ $balasan->id }}" title="Hapus balasan">
                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                    </button>
                                                                                @endif
                                                                            @endauth
                                                                        </div>

                                                                        <div class="komentar-text">
                                                                            {{ $balasan->komentar }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="no-comment-wrapper">
                                        <div class="no-comment-icon">
                                            <i class="far fa-comment-dots"></i>
                                        </div>
                                        <p id="no-comment-msg">Belum ada komentar. Jadilah yang pertama memberikan tanggapan!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <style>
        /* ========================================
           RATING STARS - KUNING MODERN
        ======================================== */
        .rating-stars-modern {
            display: flex;
            gap: 0.5rem;
            direction: rtl;
            margin-bottom: 1rem;
            justify-content: flex-start;
        }

        .rating-label {
            font-size: 2rem;
            color: #d1d5db;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
        }

        .rating-input {
            display: none;
        }

        .rating-input:checked~.rating-label,
        .rating-input:checked~.rating-label:hover,
        .rating-label:hover,
        .rating-label:hover~.rating-label {
            color: #fbbf24;
            filter: drop-shadow(0 2px 4px rgba(251, 191, 36, 0.4));
        }

        .rating-label:hover {
            transform: scale(1.15) rotate(-5deg);
        }

        .rating-input:checked~.rating-label {
            animation: starPop 0.4s ease;
        }

        @keyframes starPop {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }

        /* ========================================
           ACTION BUTTONS - MODERN DENGAN SHADOW
        ======================================== */
        .action-buttons-wrapper {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-action {
            transition: var(--transition-smooth);
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            border: 2px solid var(--border);
            background: var(--white);
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-primary);
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-light);
        }

        .btn-action.active {
            border-color: transparent;
            box-shadow: var(--shadow-md);
        }

        .btn-action[data-action="suka"].active {
            background: linear-gradient(135deg, #fecaca 0%, #fee2e2 100%);
            color: #dc2626;
            animation: heartBeat 0.6s ease;
        }

        .btn-action[data-action="bookmark"].active {
            background: linear-gradient(135deg, #bfdbfe 0%, #dbeafe 100%);
            color: #1e40af;
            animation: bookmarkSave 0.6s ease;
        }

        @keyframes heartBeat {
            0%, 100% {
                transform: scale(1);
            }
            25% {
                transform: scale(1.1);
            }
            50% {
                transform: scale(1);
            }
            75% {
                transform: scale(1.05);
            }
        }

        @keyframes bookmarkSave {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        .btn-action i {
            transition: transform 0.3s ease;
        }

        .btn-action:hover i {
            transform: scale(1.2);
        }

        /* ========================================
           FEEDBACK SECTION - CARD MODERN
        ======================================== */
        .feedback-section {
            background: linear-gradient(135deg, var(--light) 0%, var(--white) 100%);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            margin-top: 2rem;
        }

        .feedback-section h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .feedback-section h3:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--gradient-blue-enhanced);
            border-radius: 2px;
        }

        /* ========================================
           KOMENTAR SECTION - MODERN DESIGN
        ======================================== */
        .komentar-section {
            margin-top: 3rem;
        }

        .komentar-header h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-light);
        }

        .komentar-header h3 i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .comment-list-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* ========================================
           KOMENTAR ITEM - CARD DESIGN
        ======================================== */
        .komentar-item {
            padding: 1.75rem;
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border-light);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            position: relative;
        }

        .komentar-item:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-light);
            transform: translateY(-2px);
        }

        .komentar-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--gradient-blue-enhanced);
            border-radius: 16px 0 0 16px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .komentar-item:hover::before {
            opacity: 1;
        }

        /* ========================================
           AVATAR SISWA
        ======================================== */
        .author-avatar-siswa {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 12px;
            background: var(--gradient-blue-enhanced);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
            transition: transform 0.3s ease;
        }

        .author-avatar-small {
            width: 40px;
            height: 40px;
            min-width: 40px;
            font-size: 0.95rem;
        }

        .komentar-item:hover .author-avatar-siswa {
            transform: scale(1.05);
        }

        /* ========================================
           KOMENTAR CONTENT
        ======================================== */
        .komentar-item .name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem;
            margin: 0;
        }

        .komentar-item .date {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .komentar-item .date i {
            font-size: 0.8rem;
        }

        .komentar-text {
            color: var(--text-primary);
            line-height: 1.7;
            margin-top: 0.75rem;
            font-size: 0.95rem;
            word-wrap: break-word;
        }

        /* ========================================
           TOMBOL AKSI
        ======================================== */
        .komentar-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .btn-reply {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .btn-reply:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .btn-reply i {
            font-size: 0.85rem;
        }

        .btn-delete {
            padding: 0.5rem;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-delete:hover {
            background: #fee2e2;
            color: #dc2626;
            transform: scale(1.1);
        }

        /* ========================================
           REPLY FORM - MODERN DESIGN
        ======================================== */
        .reply-form {
            margin-top: 1.25rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border-radius: 12px;
            border: 2px dashed var(--border);
            display: none;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reply-form .form-label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .reply-form .form-label i {
            color: var(--primary);
        }

        .reply-form textarea {
            border-radius: 10px;
            border: 2px solid var(--border);
            transition: all 0.3s ease;
            resize: none;
            font-size: 0.95rem;
            color: var(--text-primary);
            padding: 0.875rem;
        }

        .reply-form textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
            background: var(--white);
        }

        .reply-form textarea::placeholder {
            color: var(--text-secondary);
        }

        .reply-form .btn {
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
        }

        /* ========================================
           KOMENTAR REPLIES - NESTED DESIGN
        ======================================== */
        .komentar-replies {
            margin-top: 1.5rem;
            padding-left: 2.5rem;
            border-left: 3px solid var(--border-light);
            position: relative;
        }

        .komentar-replies::before {
            content: '';
            position: absolute;
            left: -3px;
            top: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary) 0%, transparent 100%);
            opacity: 0.3;
        }

        .komentar-replies .komentar-item {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .komentar-reply {
            margin-bottom: 1rem;
        }

        .komentar-reply:last-child {
            margin-bottom: 0;
        }

        /* ========================================
           NO COMMENT MESSAGE
        ======================================== */
        .no-comment-wrapper {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, var(--light) 0%, var(--white) 100%);
            border-radius: 20px;
            border: 2px dashed var(--border);
        }

        .no-comment-icon {
            font-size: 4rem;
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        #no-comment-msg {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }

        /* ========================================
           FORM CONTROLS - ENHANCED
        ======================================== */
        .form-control {
            border-radius: 12px;
            border: 2px solid var(--border);
            padding: 0.875rem 1.25rem;
            transition: var(--transition-smooth);
            font-size: 0.95rem;
            color: var(--text-primary);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
            background: var(--white);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.625rem;
            font-size: 0.95rem;
        }

        /* ========================================
           SUBMIT BUTTON - GRADIENT MODERN
        ======================================== */
        #submitBtn {
            background: var(--gradient-blue-enhanced);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2.5rem;
            font-weight: 600;
            font-size: 1rem;
            color: var(--white);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            transition: var(--transition-smooth);
            cursor: pointer;
        }

        #submitBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        #submitBtn:active {
            transform: translateY(0);
        }

        #submitBtn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        /* ========================================
           META INFO - ENHANCED
        ======================================== */
        .meta-info {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-light);
        }

        .meta-info span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .meta-info i {
            color: var(--primary);
        }

        /* ========================================
           RESPONSIVE DESIGN
        ======================================== */
        @media (max-width: 768px) {
            .feedback-section {
                padding: 1.5rem;
                border-radius: 16px;
            }

            .rating-label {
                font-size: 1.75rem;
            }

            .komentar-section h3 {
                font-size: 1.5rem;
            }
            
            .komentar-item {
                padding: 1.25rem;
            }
            
            .reply-form {
                padding: 1.25rem;
            }
            
            .komentar-replies {
                padding-left: 1.5rem;
                margin-top: 1rem;
            }
            
            .author-avatar-siswa {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .author-avatar-small {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }

            .btn-action {
                padding: 0.625rem 1.25rem;
                font-size: 0.875rem;
            }

            .meta-info {
                gap: 1rem;
            }

            .meta-info span {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .komentar-section h3 {
                font-size: 1.35rem;
            }

            .feedback-section h3 {
                font-size: 1.25rem;
            }
            
            .komentar-item {
                padding: 1rem;
                border-radius: 12px;
            }
            
            .komentar-replies {
                padding-left: 1rem;
                margin-left: 0;
            }
            
            .no-comment-wrapper {
                padding: 3rem 1.5rem;
            }
            
            .no-comment-icon {
                font-size: 3rem;
            }

            .action-buttons-wrapper {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }

        /* ========================================
           UTILITY ANIMATIONS
        ======================================== */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 2px;
        }

        /* ========================================
           SMOOTH TRANSITIONS
        ======================================== */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Handle Suka & Simpan
            function initializeActionButtons() {
                document.querySelectorAll('.btn-action').forEach(button => {
                    button.replaceWith(button.cloneNode(true));
                });

                document.querySelectorAll('.btn-action').forEach(button => {
                    button.addEventListener('click', function() {
                        this.disabled = true;
                        const jenis = this.dataset.action;
                        const artikelId = this.dataset.id;
                        const url = "{{ route('artikel-siswa.interaksi', ':id') }}".replace(':id', artikelId);

                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({ jenis })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.classList.toggle('active');
                                    const icon = this.querySelector('i');
                                    icon.classList.toggle('far');
                                    icon.classList.toggle('fas');
                                    if (jenis === 'suka') {
                                        document.getElementById('like-count').innerHTML =
                                            `<i class="fas fa-heart"></i> ${data.like_count} Suka`;
                                    }
                                    this.style.transform = 'scale(1.2)';
                                    setTimeout(() => {
                                        this.style.transform = 'scale(1)';
                                    }, 300);
                                } else {
                                    alert('Gagal menyimpan interaksi.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan. Silakan coba lagi.');
                            })
                            .finally(() => {
                                this.disabled = false;
                            });
                    });
                });
            }

            // Handle Form Komentar & Rating
            const form = document.getElementById('feedbackForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('submitBtn');
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';

                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: new FormData(form)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                submitBtn.classList.replace('btn-primary', 'btn-success');
                                submitBtn.innerHTML = '<i class="fas fa-check"></i> Terkirim!';
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                alert(data.message || 'Gagal mengirim tanggapan.');
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnText;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Pastikan Anda sudah login.');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        });
                });
            }

            // Handle Balas Komentar
            function initializeReplyButtons() {
                document.querySelectorAll('.btn-reply').forEach(button => {
                    button.replaceWith(button.cloneNode(true));
                });

                document.querySelectorAll('.btn-cancel-reply').forEach(button => {
                    button.replaceWith(button.cloneNode(true));
                });

                document.querySelectorAll('.btn-reply').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const komentarId = this.dataset.id;
                        const parentComment = this.closest('.komentar-item');
                        if (!parentComment) return;

                        const form = parentComment.querySelector(`.reply-form[data-parent-id="${komentarId}"]`);

                        if (form) {
                            document.querySelectorAll('.reply-form').forEach(f => {
                                if (f !== form) {
                                    f.style.display = 'none';
                                    const otherParentId = f.dataset.parentId;
                                    const otherReplyButton = document.querySelector(`.btn-reply[data-id="${otherParentId}"]`);
                                    if (otherReplyButton) {
                                        otherReplyButton.innerHTML = '<i class="fas fa-reply"></i> Balas';
                                        otherReplyButton.classList.remove('btn-secondary');
                                        otherReplyButton.classList.add('btn-outline-secondary');
                                    }
                                }
                            });

                            const isVisible = form.style.display === 'block';
                            form.style.display = isVisible ? 'none' : 'block';
                            if (!isVisible) {
                                form.querySelector('textarea').focus();
                            }
                            this.innerHTML = isVisible ? '<i class="fas fa-reply"></i> Balas' : '<i class="fas fa-times"></i> Batal';
                            this.classList.toggle('btn-secondary');
                            this.classList.toggle('btn-outline-secondary');
                        } else {
                            console.error('Form balasan tidak ditemukan untuk komentar ID:', komentarId);
                        }
                    });
                });

                document.querySelectorAll('.btn-cancel-reply').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('.reply-form');
                        if (form) {
                            form.style.display = 'none';
                            form.querySelector('textarea').value = '';
                            const parentId = form.dataset.parentId;
                            const replyButton = document.querySelector(`.btn-reply[data-id="${parentId}"]`);
                            if (replyButton) {
                                replyButton.innerHTML = '<i class="fas fa-reply"></i> Balas';
                                replyButton.classList.remove('btn-secondary');
                                replyButton.classList.add('btn-outline-secondary');
                            }
                        }
                    });
                });

                document.querySelectorAll('.reply-form').forEach(form => {
                    const newForm = form.cloneNode(true);
                    form.parentNode.replaceChild(newForm, form);

                    newForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const submitBtn = this.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;
                        const textarea = this.querySelector('textarea[name="komentar"]');

                        if (!textarea.value.trim()) {
                            alert('Silakan tulis balasan terlebih dahulu.');
                            return;
                        }

                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';

                        fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: new FormData(this)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    submitBtn.classList.replace('btn-primary', 'btn-success');
                                    submitBtn.innerHTML = '<i class="fas fa-check"></i> Terkirim!';
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    alert(data.message || 'Gagal mengirim balasan.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan. Silakan coba lagi.');
                            })
                            .finally(() => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            });
                    });
                });
            }

            // Handle Delete Komentar
            function initializeDeleteButtons() {
                document.querySelectorAll('.delete-comment').forEach(button => {
                    button.replaceWith(button.cloneNode(true));
                });

                document.querySelectorAll('.delete-comment').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (!confirm('Apakah Anda yakin ingin menghapus komentar ini beserta balasannya?')) {
                            return;
                        }

                        const komentarId = this.dataset.id;
                        const url = "{{ route('komentar.destroy', ':id') }}".replace(':id', komentarId);

                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const commentElement = document.getElementById(`komentar-${komentarId}`);
                                if (commentElement) {
                                    const repliesContainer = commentElement.querySelector('.komentar-replies');
                                    const replyCount = repliesContainer ? repliesContainer.querySelectorAll('.komentar-item').length : 0;
                                    
                                    commentElement.remove();

                                    const commentCount = document.getElementById('comment-count');
                                    const commentTitle = document.getElementById('comment-title');
                                    let currentCount = parseInt(commentCount.textContent.match(/\d+/)[0]);
                                    const newCount = Math.max(0, currentCount - 1 - replyCount);
                                    commentCount.innerHTML = `<i class="fas fa-comments"></i> ${newCount} Komentar`;
                                    commentTitle.innerHTML = `<i class="fas fa-comments"></i> Komentar (${newCount})`;

                                    if (newCount === 0) {
                                        const commentList = document.getElementById('comment-list');
                                        commentList.innerHTML = `
                                            <div class="no-comment-wrapper">
                                                <div class="no-comment-icon">
                                                    <i class="far fa-comment-dots"></i>
                                                </div>
                                                <p id="no-comment-msg">Belum ada komentar. Jadilah yang pertama memberikan tanggapan!</p>
                                            </div>
                                        `;
                                    }
                                }

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                alert(data.message || 'Gagal menghapus komentar.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menghapus komentar.');
                        });
                    });
                });
            }

            // Initialize all event listeners
            initializeActionButtons();
            initializeReplyButtons();
            initializeDeleteButtons();

            // Re-bind for dynamically added comments
            document.addEventListener('DOMNodeInserted', function(event) {
                if (event.target.classList && event.target.classList.contains('komentar-item')) {
                    initializeReplyButtons();
                    initializeDeleteButtons();
                }
            });
        });
    </script>
@endsection