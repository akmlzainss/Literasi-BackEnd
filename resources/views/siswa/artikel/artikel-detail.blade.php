@extends('layouts.siswa')

@section('title', $konten->judul . ' - SiPena')

@section('body_class', 'page-artikel-detail')

@php \Carbon\Carbon::setLocale('id'); @endphp
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

        0%,
        100% {
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

        0%,
        100% {
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

        0%,
        100% {
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
           KOMENTAR SECTION - ULTRA MODERN
        ======================================== */
    .komentar-section {
        margin-top: 3rem;
    }

    .komentar-section h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .komentar-section h3:before {
        content: '💬';
        font-size: 1.5rem;
    }

    /* ========================================
           KOMENTAR ITEM - TIKTOK FLAT STYLE
        ======================================== */
    .komentar-item {
        margin-bottom: 0;
        padding: 1rem 0;
        background: transparent;
        border-radius: 0;
        border: none;
        border-bottom: 1px solid var(--border-light);
        box-shadow: none;
        transition: var(--transition-smooth);
    }

    .komentar-item:last-child {
        border-bottom: none;
    }

    .komentar-item:hover {
        background: rgba(0, 0, 0, 0.02);
        box-shadow: none;
        transform: none;
    }

    /* Komentar Header */
    .komentar-item .author-avatar-siswa {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--gradient-blue-enhanced);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: none;
    }

    /* Avatar image for profile photos */
    .author-avatar-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .komentar-item .comment-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.25rem;
    }

    .komentar-item .name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    /* TikTok-style reply indicator */
    .reply-indicator {
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
    }

    .reply-indicator .text-primary {
        color: var(--primary) !important;
        font-weight: 500;
    }

    .komentar-item .date {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin: 0;
        width: 100%;
    }

    .komentar-item .komentar-text {
        color: var(--text-primary);
        line-height: 1.5;
        margin-top: 0.25rem;
        font-size: 0.9rem;
    }

    .komentar-item .comment-actions .btn {
        padding: 0.25rem 0.5rem;
        border: none;
        background: transparent;
        color: var(--text-secondary);
    }

    .komentar-item .comment-actions .btn:hover {
        color: var(--primary);
        background: rgba(59, 130, 246, 0.1);
    }

    /* Reply form container */
    .reply-form-container {
        position: sticky;
        bottom: 0;
        background: var(--light) !important;
        z-index: 10;
    }

    .replying-to-indicator {
        background: rgba(59, 130, 246, 0.1);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
    }

    /* ========================================
           INSTAGRAM-STYLE COMMENTS
        ======================================== */
    
    /* Comment Avatar - same size for all */
    .comment-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }

    .comment-avatar-placeholder {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* Comment author */
    .comment-author {
        font-size: 0.85rem;
        color: var(--dark);
        margin-right: 0.25rem;
    }

    /* @mention text - Instagram blue */
    .mention-text {
        font-size: 0.85rem;
        margin-right: 0.25rem;
    }

    /* Comment text inline */
    .comment-text {
        font-size: 0.85rem;
        color: var(--text-primary);
        line-height: 1.4;
    }

    /* Comment metadata row */
    .comment-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .comment-time {
        font-size: 0.75rem;
    }

    /* Inline reply button - Instagram style */
    .btn-reply-inline {
        background: none;
        border: none;
        color: var(--text-secondary);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0;
        cursor: pointer;
        transition: color 0.2s;
    }

    .btn-reply-inline:hover {
        color: var(--dark);
    }

    /* View replies toggle - Instagram style */
    .replies-toggle-section {
        margin-bottom: 0.5rem;
    }

    .btn-view-replies {
        background: none;
        border: none;
        color: var(--text-secondary);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-view-replies:hover {
        color: var(--dark);
    }

    .toggle-line {
        width: 24px;
        height: 1px;
        background: var(--text-secondary);
    }

    /* Flat replies container - NO extra indent */
    .flat-replies-container {
        margin-top: 0.5rem;
        animation: fadeIn 0.3s ease;
    }

    .flat-replies-container .komentar-item {
        padding: 0.5rem 0;
        border-bottom: none;
    }

    /* Reply item - same level as parent visually */
    .reply-item {
        /* No extra margin - flat like Instagram */
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* ========================================
           REPLY FORM - MODERN DESIGN
        ======================================== */
    .reply-form {
        margin-left: 2rem;
        margin-top: 1rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, var(--white) 100%);
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

    .reply-form textarea {
        border-radius: 10px;
        border: 2px solid var(--border);
        transition: var(--transition-smooth);
        resize: none;
        font-size: 0.95rem;
        color: var(--text-primary);
    }

    .reply-form textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .reply-form textarea::placeholder {
        color: var(--text-secondary);
    }

    /* ========================================
           KOMENTAR REPLIES - NESTED DESIGN
        ======================================== */
    .komentar-replies {
        margin-left: 3rem;
        margin-top: 1.25rem;
        padding-left: 1.5rem;
        border-left: 3px solid var(--border-light);
        position: relative;
    }

    .komentar-replies:before {
        content: '';
        position: absolute;
        left: -3px;
        top: 0;
        width: 3px;
        height: 100%;
        background: linear-gradient(180deg, var(--primary) 0%, transparent 100%);
        opacity: 0.5;
    }

    /* ========================================
           BUTTON BALAS - MODERN STYLE
        ======================================== */
    .btn-reply {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: var(--transition-smooth);
        font-weight: 500;
        border: 1px solid var(--border);
        background: var(--white);
        color: var(--text-primary);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-reply:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-sm);
        border-color: var(--primary-light);
        background: var(--light);
    }

    .btn-reply.btn-secondary {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }

    .btn-cancel-reply {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: var(--transition-smooth);
        font-weight: 500;
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
           NO COMMENT MESSAGE
        ======================================== */
    #no-comment-msg {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--text-secondary);
        font-style: italic;
        background: linear-gradient(135deg, var(--light) 0%, var(--white) 100%);
        border-radius: 16px;
        border: 2px dashed var(--border);
        font-size: 0.95rem;
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

        .reply-form {
            margin-left: 0;
            margin-top: 0.75rem;
            padding: 1.25rem;
        }

        .komentar-replies {
            margin-left: 1rem;
            padding-left: 1rem;
        }

        .komentar-item {
            padding: 1.25rem;
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
            font-size: 1.5rem;
        }

        .feedback-section h3 {
            font-size: 1.25rem;
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

        0%,
        100% {
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
</style>


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
                        <div class="article-body mt-4">{!! $konten->konten ?? 'Konten tidak tersedia' !!}</div>
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
                                <p class="mb-1">Silakan <a href="{{ route('siswa.login') }}">masuk</a> untuk memberi rating dan
                                    komentar.</p>
                            </div>
                        @endauth

                        <div class="komentar-section mt-5">
                            <h3 class="mb-4" id="comment-title">Komentar ({{ $konten->komentarArtikel->count() }})</h3>
                            <div id="comment-list">
                                {{-- TikTok-style flat comments --}}
                                @forelse($konten->komentarArtikel as $komentar)
                                    @include('partials.komentar', [
                                        'komentar' => $komentar,
                                        'konten' => $konten,
                                    ])
                                @empty
                                    <p id="no-comment-msg">Belum ada komentar. Jadilah yang pertama!</p>
                                @endforelse
                            </div>
                            
                            {{-- Floating Reply Form (TikTok-style) --}}
                            @auth('siswa')
                            <div class="reply-form-container mt-4 p-3 bg-light rounded-3 border" id="replyFormContainer">
                                <div class="replying-to-indicator mb-2" id="replyingToIndicator" style="display: none;">
                                    <span class="text-muted small">
                                        <i class="fas fa-reply me-1"></i>Membalas 
                                        <strong id="replyingToName">@username</strong>
                                    </span>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" id="cancelReplyBtn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <form id="replyForm" action="{{ route('komentar.store', $konten->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="parent_id" id="replyParentId" value="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="komentar" id="komentarInput" 
                                            placeholder="Tulis komentar..." required>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @else
                            <div class="text-center p-3 bg-light rounded-3 border mt-4">
                                <a href="{{ route('siswa.login') }}" class="text-primary">Masuk</a> untuk berkomentar
                            </div>
                            @endauth

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1"
                                aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel">
                                                <i class="fas fa-exclamation-triangle me-2"></i> Konfirmasi Hapus
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah kamu yakin ingin menghapus komentar ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Ya,
                                                Hapus</button>
                                        </div>
                                    </div>
                                </div>
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
        /* Kode CSS yang sudah ada dan diperbarui */
        .rating-stars-modern {
            display: flex;
            gap: 0.25rem;
            direction: rtl;
            /* Membuat bintang terbalik untuk efek hover */
            margin-bottom: 0.5rem;
        }

        .rating-label {
            font-size: 1.5rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
            display: flex;
            align-items: center;
        }

        .rating-input {
            display: none;
        }

        .rating-input:checked~.rating-label,
        .rating-input:checked~.rating-label:hover,
        .rating-label:hover,
        .rating-label:hover~.rating-label {
            color: var(--gradient-blue-enhanced);
            /* Warna biru gradient modern */
        }

        .rating-label:hover {
            transform: scale(1.2);
        }

        .btn-action {
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-action.active {
            border-color: transparent;
        }

        .btn-action[data-action="suka"].active {
            background-color: #fee2e2;
            /* Merah muda lembut */
            color: #dc2626;
            /* Merah tua */
            animation: pulse 0.5s ease;
        }

        .btn-action[data-action="bookmark"].active {
            background-color: #dbeafe;
            /* Biru muda lembut */
            color: #1e40af;
            /* Biru tua */
            animation: pulse 0.5s ease;
        }

        .btn-action:hover {
            transform: scale(1.1);
            background-color: var(--light);
        }

        .btn-action i {
            margin-right: 0.5rem;
            transition: color 0.3s ease;
        }

        .reply-form {
            margin-left: 2rem;
            margin-top: 0.5rem;
            padding: 1rem;
            background-color: var(--white);
            border-radius: 8px;
            border: 1px solid var(--border);
            display: none;
        }

        .komentar-section {
            margin-top: 2rem;
        }

        .komentar-item {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background-color: var(--white);
            border-radius: 8px;
            border: 1px solid var(--border-light);
        }

        .komentar-replies {
            margin-left: 2rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .reply-form {
                margin-left: 0;
                margin-top: 0.5rem;
            }

            .komentar-replies {
                margin-left: 1rem;
            }
        }

        /* Animasi Pulse */
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let selectedCommentId = null;

            // ==============================
            // 1️⃣ Handle Suka & Simpan
            // ==============================
            function initializeActionButtons() {
                document.querySelectorAll('.btn-action').forEach(button => {
                    button.replaceWith(button.cloneNode(true));
                });

                document.querySelectorAll('.btn-action').forEach(button => {
                    button.addEventListener('click', function() {
                        this.disabled = true;
                        const jenis = this.dataset.action;
                        const artikelId = this.dataset.id;
                        const url = "{{ route('artikel-siswa.interaksi', ':id') }}".replace(':id',
                            artikelId);

                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    jenis
                                })
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
                                    setTimeout(() => this.style.transform = 'scale(1)', 300);
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

            // ==============================
            // 2️⃣ Handle Form Komentar
            // ==============================
            const form = document.getElementById('feedbackForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('submitBtn');
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm"></span> Mengirim...';

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
                                setTimeout(() => window.location.reload(), 1000);
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

            // ==============================
            // 3️⃣ Handle Balas Komentar (Instagram-style)
            // ==============================
            function initializeReplyButtons() {
                const replyFormContainer = document.getElementById('replyFormContainer');
                const replyingToIndicator = document.getElementById('replyingToIndicator');
                const replyingToName = document.getElementById('replyingToName');
                const replyParentId = document.getElementById('replyParentId');
                const cancelReplyBtn = document.getElementById('cancelReplyBtn');
                const komentarInput = document.getElementById('komentarInput');
                const replyForm = document.getElementById('replyForm');

                if (!replyFormContainer) return; // User not logged in

                // Handle both old .btn-reply and new .btn-reply-inline buttons
                const replyButtons = document.querySelectorAll('.btn-reply, .btn-reply-inline');
                replyButtons.forEach(button => {
                    button.replaceWith(button.cloneNode(true));
                });

                document.querySelectorAll('.btn-reply, .btn-reply-inline').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const komentarId = this.dataset.id;
                        const userName = this.dataset.name;
                        
                        // Update form to reply mode
                        replyParentId.value = komentarId;
                        replyingToName.textContent = '@' + userName;
                        replyingToIndicator.style.display = 'block';
                        komentarInput.placeholder = `Balas ke ${userName}...`;
                        
                        // Update form action for reply
                        const artikelId = {{ $konten->id }};
                        replyForm.action = `/artikel-siswa/${artikelId}/komentar/${komentarId}`;
                        
                        // Scroll to form and focus
                        replyFormContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(() => komentarInput.focus(), 300);
                    });
                });

                // Cancel reply button
                if (cancelReplyBtn) {
                    cancelReplyBtn.addEventListener('click', function() {
                        replyParentId.value = '';
                        replyingToIndicator.style.display = 'none';
                        komentarInput.placeholder = 'Tulis komentar...';
                        replyForm.action = "{{ route('komentar.store', $konten->id) }}";
                    });
                }
            }


            // ==============================
            // 5️⃣ Handle Hapus Komentar
            // ==============================
            function initializeDeleteButtons() {
                document.querySelectorAll('.delete-comment').forEach(button => {
                    button.replaceWith(button.cloneNode(true));
                });

                document.querySelectorAll('.delete-comment').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        selectedCommentId = this.dataset.id;
                        const deleteModal = new bootstrap.Modal(document.getElementById(
                            'confirmDeleteModal'));
                        deleteModal.show();
                    });
                });

                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    if (!selectedCommentId) return;

                    const url = "{{ route('komentar.destroy', ':id') }}".replace(':id', selectedCommentId);

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
                                const commentElement = document.getElementById(
                                    `komentar-${selectedCommentId}`);
                                if (commentElement) commentElement.remove();

                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'confirmDeleteModal'));
                                modal.hide();

                                const toast = document.createElement('div');
                                toast.className =
                                    'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
                                toast.innerHTML = `
                                <i class="fas fa-check-circle"></i> Komentar berhasil dihapus!
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
                                document.body.appendChild(toast);
                                setTimeout(() => toast.remove(), 3000);
                            } else {
                                alert(data.message || 'Gagal menghapus komentar.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menghapus komentar.');
                        });
                });
            }

            // ==============================
            // 6️⃣ Update Relative Time
            // ==============================
            function updateRelativeTime() {
                document.querySelectorAll('.date').forEach(dateElement => {
                    const commentId = dateElement.getAttribute('id').replace('comment-time-', '');
                    const createdAt = new Date(document.querySelector(`#komentar-${commentId}`).dataset
                        .createdAt || Date.now());
                    const now = new Date();
                    const diffInMonths = Math.floor((now - createdAt) / (1000 * 60 * 60 * 24 * 30));

                    if (diffInMonths < 1) {
                        const diffInSeconds = Math.floor((now - createdAt) / 1000);
                        if (diffInSeconds < 60) {
                            dateElement.textContent = `${diffInSeconds} detik yang lalu`;
                        } else if (diffInSeconds < 3600) {
                            const diffInMinutes = Math.floor(diffInSeconds / 60);
                            dateElement.textContent = `${diffInMinutes} menit yang lalu`;
                        } else {
                            const diffInHours = Math.floor(diffInSeconds / 3600);
                            dateElement.textContent = `${diffInHours} jam yang lalu`;
                        }
                    }
                });
            }

            // Jalankan semua inisialisasi
            initializeActionButtons();
            initializeReplyButtons();
            initializeDeleteButtons();
            initializeToggleReplies();

            // Jalankan update pertama kali
            updateRelativeTime();

            // Update waktu setiap 1 menit
            setInterval(updateRelativeTime, 10000);

            // ==============================
            // 6️⃣ Toggle Replies (Instagram/TikTok style)
            // ==============================
            function initializeToggleReplies() {
                document.querySelectorAll('.toggle-replies').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const commentId = this.dataset.commentId;
                        const repliesCount = this.dataset.repliesCount;
                        const repliesContainer = document.getElementById(`replies-${commentId}`);
                        
                        if (repliesContainer.style.display === 'none') {
                            repliesContainer.style.display = 'block';
                            this.innerHTML = `<i class="fas fa-comment me-1"></i>Sembunyikan ${repliesCount} balasan`;
                        } else {
                            repliesContainer.style.display = 'none';
                            this.innerHTML = `<i class="fas fa-comment me-1"></i>Lihat ${repliesCount} balasan`;
                        }
                    });
                });
            }

            // Untuk komentar yang dimuat dinamis
            document.addEventListener('DOMNodeInserted', function(event) {
                if (event.target.classList && event.target.classList.contains('komentar-item')) {
                    initializeReplyButtons();
                    initializeDeleteButtons();
                    initializeToggleReplies();
                }
            });
        });
    </script>
@endsection

