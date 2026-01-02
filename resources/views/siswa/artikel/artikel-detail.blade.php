@extends('layouts.siswa')

@section('content')
    <div class="article-detail-page bg-light-subtle min-vh-100">
        
        <!-- MOBILE: Hero Image (Full Width di atas) -->
        <div class="d-lg-none">
            <div class="mobile-hero-image position-relative">
                @if ($konten->gambar)
                    <!-- Adaptive: JS akan mendeteksi orientasi gambar -->
                    <img id="mobileHeroImage" src="{{ asset('storage/' . $konten->gambar) }}" class="w-100" style="max-height: 300px; object-fit: contain; object-position: center; background: #f0f0f0;" alt="{{ $konten->judul }}">
                @else
                    <!-- Default Image jika tidak ada gambar -->
                    <img src="{{ asset('images/default-article.png') }}" class="w-100" style="max-height: 300px; object-fit: contain; background: #f5f5f5;" alt="Default">
                @endif
                <div class="position-absolute top-0 start-0 p-3">
                    <a href="{{ route('artikel-siswa.index') }}" class="btn btn-light btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="container py-4 py-lg-5">
            <!-- DESKTOP: Back Button (Hidden on Mobile karena sudah ada di Hero) -->
            <a href="{{ route('artikel-siswa.index') }}" class="text-decoration-none text-muted mb-4 d-none d-lg-inline-block hover-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Artikel
            </a>

            <div class="row g-4">
                <!-- LEFTSIDE: Content (Judul + Isi + Komentar) -->
                <div class="col-lg-8">
                    <!-- Article Header -->
                    <header class="mb-4">
                        <!-- Kategori & Tanggal -->
                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold">
                                {{ $konten->kategori->nama ?? 'Umum' }}
                            </span>
                            <span class="text-muted small">•</span>
                            <span class="text-muted small">{{ $konten->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                        
                        <!-- Judul (Responsive Size) -->
                        <h1 class="fw-bold text-dark mb-3 lh-tight article-title">{{ $konten->judul }}</h1>
                        
                        <!-- Author Info -->
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="avatar-sm bg-secondary-subtle rounded-circle d-flex align-items-center justify-content-center fw-bold text-secondary" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($konten->siswa->nama ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="mb-0 fw-semibold small text-dark">{{ $konten->siswa->nama ?? 'Admin' }}</p>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;">Penulis</p>
                            </div>
                        </div>

                        <!-- Stats Row (Mobile Optimized Grid) -->
                        @php
                            $avgRating = $konten->ratingArtikel->avg('rating') ?? 0;
                            $countRating = $konten->ratingArtikel->count();
                        @endphp
                        <div class="stats-row d-flex flex-wrap gap-3 text-muted small">
                            <div class="stat-item" title="Dilihat">
                                <i class="far fa-eye me-1"></i> {{ number_format($konten->jumlah_dilihat) }}
                            </div>
                            <div class="stat-item" title="Disukai">
                                <i class="fas fa-heart text-danger me-1"></i> <span id="like-count-header">{{ $konten->jumlah_suka }}</span>
                            </div>
                            <div class="stat-item" title="Rating">
                                <i class="fas fa-star text-warning me-1"></i> 
                                <span class="fw-semibold text-dark">{{ number_format($avgRating, 1) }}</span>
                                <span class="text-secondary">({{ $countRating }})</span>
                            </div>
                        </div>
                    </header>

                    <!-- Article Body -->
                    <article class="article-content bg-white p-4 p-md-5 rounded-4 shadow-sm text-dark mb-5 border-0">
                        {!! $konten->isi ?? '<p class="text-muted text-center">Konten tidak tersedia.</p>' !!}
                    </article>

                    <!-- Rating Section -->
                    @auth('siswa')
                    <div class="section-rating mb-5">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-4 text-center bg-white">
                                <h5 class="fw-bold mb-3">Apa pendapatmu tentang artikel ini?</h5>
                                <div class="rating-stars-modern justify-content-center mb-2">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating_separate"
                                            value="{{ $i }}"
                                            {{ $userRating && $userRating->rating == $i ? 'checked' : '' }}
                                            class="rating-input">
                                        <label for="star{{ $i }}" class="rating-label p-1">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                <p class="text-muted small mb-0">Klik bintang untuk menilai</p>
                                @if($userRating)
                                    <button id="btnDeleteRating" class="btn btn-sm btn-link text-danger text-decoration-none mt-2">Hapus Rating Saya</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endauth

                    <!-- Comments Section -->
                    <div class="section-comments">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h4 class="fw-bold mb-0">Komentar <span class="badge bg-light text-dark ms-2 border">{{ $konten->komentarArtikel->count() }}</span></h4>
                        </div>

                        <!-- Comment Form -->
                        @auth('siswa')
                        <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                            <form id="feedbackForm" action="{{ route('komentar.store', $konten->id) }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <textarea class="form-control border bg-light" id="komentar" name="komentar" rows="3" placeholder="Tulis komentar kamu disini..." required style="border-radius: 12px;"></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="submit" id="submitBtn" class="btn btn-primary rounded-pill px-4 fw-medium">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endauth

                        <!-- Comment List -->
                        <div id="comment-list" class="d-flex flex-column gap-3">
                            @forelse($konten->komentarArtikel as $komentar)
                                @include('partials.komentar', ['komentar' => $komentar, 'konten' => $konten])
                            @empty
                                <div class="text-center py-5">
                                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="No Comments" style="width: 150px; opacity: 0.5;">
                                    <p class="text-muted mt-3">Belum ada komentar. Jadilah yang pertama!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Reply Form Hidden -->
                     @auth('siswa')
                    <div id="replyFormContainer" class="card border-0 shadow-sm bg-white border p-3 mt-3 position-relative" style="display: none; border-radius: 12px;">
                         <button type="button" id="cancelReplyBtn" class="btn-close position-absolute top-0 end-0 m-2 small"></button>
                         <small class="text-muted d-block mb-2"><i class="fas fa-reply me-1"></i>Membalas <strong id="replyingToName"></strong></small>
                         <form id="replyForm" action="{{ route('komentar.store', $konten->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" id="replyParentId" value="">
                            <div class="input-group">
                                <input type="text" class="form-control" name="komentar" id="komentarInput" placeholder="Ketik balasan..." required>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                            </div>
                         </form>
                    </div>
                    @endauth
                </div>

                <!-- RIGHTSIDE: Sidebar (Image & Actions) -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="sticky-top" style="top: 100px; z-index: 10;">
                        
                        <!-- Sidebar: Featured Image -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            @if ($konten->gambar)
                                <!-- HAPUS height fixed & object-fit-cover agar gambar menyesuaikan aslinya (Cover Buku/Poster Film aman) -->
                                <img src="{{ asset('storage/' . $konten->gambar) }}" class="card-img-top w-100" style="height: auto; min-height: 200px;" alt="{{ $konten->judul }}">
                            @else
                                <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-image fa-4x opacity-50"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Sidebar: Actions Card -->
                        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                            <h6 class="fw-bold text-muted mb-3 text-uppercase small ls-1">Interaksi</h6>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                @auth('siswa')
                                <button class="btn btn-outline-danger w-100 py-2 rounded-pill btn-action d-flex align-items-center justify-content-center gap-2 {{ $userHasLiked ? 'active' : '' }}" 
                                        data-action="suka" data-id="{{ $konten->id }}">
                                    <i class="{{ $userHasLiked ? 'fas' : 'far' }} fa-heart"></i>
                                    <span id="like-count-sidebar">{{ $konten->jumlah_suka }}</span>
                                </button>
                                <button class="btn btn-outline-primary w-100 py-2 rounded-pill btn-action d-flex align-items-center justify-content-center gap-2 {{ $userHasBookmarked ? 'active' : '' }}" 
                                        data-action="bookmark" data-id="{{ $konten->id }}">
                                    <i class="{{ $userHasBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                                    <span>Simpan</span>
                                </button>
                                @endauth
                            </div>
                             <div class="d-grid">
                                <button class="btn btn-light rounded-pill text-muted small" onclick="navigator.share({title: '{{ $konten->judul }}', url: window.location.href})">
                                    <i class="fas fa-share-alt me-2"></i>Bagikan Artikel
                                </button>
                             </div>
                        </div>

                        <!-- Optional: Other meta/ad could go here -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Modal -->
    <div class="modal fade" id="ratingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow rounded-4 text-center p-4">
                <div class="mb-3 text-warning"><i class="fas fa-star fa-3x"></i></div>
                <h5 class="fw-bold">Konfirmasi</h5>
                <p class="text-muted small">Kirim rating <strong id="ratingValueModal"></strong> bintang?</p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary rounded-pill" id="confirmRatingBtn">Ya, Kirim</button>
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Rating Modal -->
    <div class="modal fade" id="deleteRatingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow rounded-4 p-4 text-center">
                <div class="mb-3 text-danger"><i class="fas fa-trash-alt fa-3x"></i></div>
                <h5 class="fw-bold">Hapus Rating?</h5>
                <p class="text-muted small">Rating yang sudah diberikan akan dihapus.</p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-danger rounded-pill" id="confirmDeleteRatingBtn">Ya, Hapus</button>
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
    
     <!-- Delete Msg Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow rounded-4 p-3">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-circle fa-2x text-danger mb-2"></i>
                    <h6 class="fw-bold">Hapus Komentar?</h6>
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-light btn-sm rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger btn-sm rounded-pill px-3" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MOBILE: Floating Action Bar (Only visible on mobile) -->
    @auth('siswa')
    <div class="mobile-action-bar d-lg-none">
        <button class="action-btn btn-action {{ $userHasLiked ? 'active' : '' }}" data-action="suka" data-id="{{ $konten->id }}">
            <i class="{{ $userHasLiked ? 'fas' : 'far' }} fa-heart"></i>
            <span id="like-count-mobile">{{ $konten->jumlah_suka }}</span>
        </button>
        <button class="action-btn btn-action {{ $userHasBookmarked ? 'active' : '' }}" data-action="bookmark" data-id="{{ $konten->id }}">
            <i class="{{ $userHasBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
            <span>Simpan</span>
        </button>
        <button class="action-btn" onclick="shareArtikel()">
            <i class="fas fa-share-alt"></i>
            <span>Bagikan</span>
        </button>
    </div>
    @else
    <div class="mobile-action-bar d-lg-none">
        <a href="{{ route('siswa.login') }}" class="action-btn">
            <i class="far fa-heart"></i>
            <span>Suka</span>
        </a>
        <a href="{{ route('siswa.login') }}" class="action-btn">
            <i class="far fa-bookmark"></i>
            <span>Simpan</span>
        </a>
        <button class="action-btn" onclick="shareArtikel()">
            <i class="fas fa-share-alt"></i>
            <span>Bagikan</span>
        </button>
    </div>
    @endauth

    @endsection

    @section('additional_css')
    <style>
        /* --- FIX LAYOUT SANGAT AGRESIF --- */
        
        /* 1. Paksa Container Utama */
        .article-content {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #2d3748;
            width: 100%;
            overflow: hidden; /* Potong apapun yang memaksa keluar */
            word-wrap: break-word;
        }

        /* 2. Paksa SEMUA elemen di dalam artikel agar tidak lebih lebar dari artikel itu sendiri */
        .article-content * {
            max-width: 100% !important;
            box-sizing: border-box;
        }

        /* 3. Target Spesifik Gambar & Video */
        .article-content img,
        .article-content iframe,
        .article-content video,
        .article-content figure {
            width: 100% !important; /* Paksa lebar penuh mengikuti kolom */
            height: auto !important; /* Jaga rasio aspek */
            object-fit: contain;
            border-radius: 8px;
            margin: 1rem 0;
            display: block;
        }

        /* --- END FIX LAYOUT --- */

        /* --- FIX RATING BINTANG (ULTIMATE) --- */
        
        /* 1. Sembunyikan Radio Button (TEKNIK SILUMAN) */
        input.rating-input { 
            position: absolute !important;
            opacity: 0 !important;
            width: 1px !important; /* Tetap ada dimensi 1px agar dideteksi browser */
            height: 1px !important;
            overflow: hidden !important;
            clip: rect(0,0,0,0) !important;
            pointer-events: none !important;
            margin: 0 !important;
        }
        
        /* 2. Container Bintang */
        .rating-stars-modern {
            display: flex !important;
            flex-direction: row-reverse !important;
            justify-content: center !important;
            gap: 10px !important;
        }
        
        /* 3. Tampilan Bintang */
        .rating-label {
            color: #d1d5db !important; /* Abu-abu terang */
            font-size: 3rem !important; /* Ukuran BESAR */
            cursor: pointer !important;
            transition: color 0.2s ease, transform 0.2s ease !important;
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1 !important;
        }
        
        /* 4. Efek Hover & Checked (Emas) */
        .rating-label:hover,
        .rating-label:hover ~ .rating-label,
        input.rating-input:checked ~ .rating-label {
            color: #fbbf24 !important; /* Kuning Emas Cerah */
            transform: scale(1.1);
        }

        /* Hilangkan efek hover pada bintang di depannya */
        .rating-label:hover ~ .rating-label {
            text-shadow: none !important;
        }
        
        /* --- END FIX RATING --- */

        /* Sidebar Styling */
        .sticky-top {
            top: 20px; /* Jarak dari atas saat scroll */
            z-index: 10;
        }

        /* Fix Button States (Hover & Active) */
        /* Tombol Suka (Merah) */
        .btn-action[data-action="suka"] {
            color: #dc2626;
            border-color: #dc2626;
            background-color: transparent;
        }
        .btn-action[data-action="suka"]:hover,
        .btn-action.active[data-action="suka"] {
            background-color: #dc2626 !important;
            color: white !important;
            border-color: #dc2626 !important;
        }

        /* Tombol Bookmark (Biru) */
        .btn-action[data-action="bookmark"] {
            color: #0d6efd;
            border-color: #0d6efd;
            background-color: transparent;
        }
        .btn-action[data-action="bookmark"]:hover,
        .btn-action.active[data-action="bookmark"] {
            background-color: #0d6efd !important;
            color: white !important;
            border-color: #0d6efd !important;
        }

        .hover-primary:hover { color: var(--bs-primary) !important; }

        /* ========================================= */
        /*     MOBILE OPTIMIZATION STYLES            */
        /* ========================================= */
        
        /* Responsive Title */
        .article-title {
            font-size: 1.75rem;
        }
        @media (min-width: 768px) {
            .article-title {
                font-size: 2.25rem;
            }
        }
        @media (min-width: 992px) {
            .article-title {
                font-size: 2.5rem;
            }
        }

        /* Stats Row */
        .stats-row {
            padding: 0.75rem 0;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Rating Stars Mobile */
        @media (max-width: 575px) {
            .rating-label {
                font-size: 2rem !important;
            }
            .rating-stars-modern {
                gap: 5px !important;
            }
        }

        /* Article Content Mobile */
        @media (max-width: 767px) {
            .article-content {
                padding: 1.25rem !important;
                font-size: 1rem;
                line-height: 1.75;
            }
            .article-content p {
                margin-bottom: 1rem;
            }
        }

        /* Mobile Floating Action Bar */
        .mobile-action-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 0.5rem 0;
            z-index: 1000;
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
        }
        
        /* Reset all button styles for mobile */
        .mobile-action-bar .action-btn {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 0.25rem !important;
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            color: #9ca3af !important;
            font-size: 0.65rem !important;
            padding: 0.5rem 1.5rem !important;
            transition: color 0.2s ease !important;
            text-decoration: none !important;
        }
        
        .mobile-action-bar .action-btn i {
            font-size: 1.5rem !important;
        }
        
        /* Active State: Hanya warna icon yang berubah */
        .mobile-action-bar .action-btn.active {
            background: transparent !important;
            background-color: transparent !important;
        }
        .mobile-action-bar .action-btn.active[data-action="suka"],
        .mobile-action-bar .action-btn.active[data-action="suka"] i {
            color: #ef4444 !important; /* Merah */
        }
        .mobile-action-bar .action-btn.active[data-action="bookmark"],
        .mobile-action-bar .action-btn.active[data-action="bookmark"] i {
            color: #3b82f6 !important; /* Biru */
        }
        
        /* Give space for floating bar */
        @media (max-width: 991px) {
            .article-detail-page {
                padding-bottom: 80px;
            }
            
            /* DISABLE hover effects on mobile */
            .mobile-action-bar .action-btn:hover,
            .mobile-action-bar .action-btn:active,
            .mobile-action-bar .action-btn:focus {
                background: transparent !important;
                background-color: transparent !important;
            }
            
            /* Only change color when active (clicked), not on hover */
            .mobile-action-bar .action-btn:not(.active):hover,
            .mobile-action-bar .action-btn:not(.active):active {
                color: #9ca3af !important;
            }
        }

        /* Toast Animation */
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateX(-50%) translateY(20px); }
            15% { opacity: 1; transform: translateX(-50%) translateY(0); }
            85% { opacity: 1; transform: translateX(-50%) translateY(0); }
            100% { opacity: 0; transform: translateX(-50%) translateY(-10px); }
        }
    </style>
    @endsection

    @section('scripts')
    <script>
        // --- SHARE ARTIKEL FUNCTION ---
        function shareArtikel() {
            const title = @json($konten->judul);
            const url = window.location.href;
            
            // Coba Web Share API dulu (mobile)
            if (navigator.share) {
                navigator.share({ title, url }).catch(() => {
                    // Jika user cancel, tidak apa-apa
                });
            } else {
                // Fallback: Copy link ke clipboard
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Link berhasil disalin! 📋');
                }).catch(() => {
                    // Fallback untuk browser lama
                    prompt('Salin link artikel:', url);
                });
            }
        }
        
        // --- TOAST NOTIFICATION ---
        function showToast(message) {
            // Buat elemen toast
            const toast = document.createElement('div');
            toast.innerText = message;
            toast.style.cssText = `
                position: fixed;
                bottom: 100px;
                left: 50%;
                transform: translateX(-50%);
                background: #333;
                color: white;
                padding: 12px 24px;
                border-radius: 25px;
                font-size: 0.9rem;
                z-index: 9999;
                animation: fadeInOut 2.5s ease;
            `;
            document.body.appendChild(toast);
            
            // Hapus setelah 2.5 detik
            setTimeout(() => toast.remove(), 2500);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // --- FIX JS: Hapus atribut width/height bawaan editor ---
            const contentImages = document.querySelectorAll('.article-content img');
            contentImages.forEach(img => {
                img.removeAttribute('width');
                img.removeAttribute('height');
                img.style.width = ''; 
                img.style.height = ''; 
                // Paksa class bootstrap img-fluid sebagai cadangan
                img.classList.add('img-fluid'); 
            });
            // --------------------------------------------------------

            // --- ADAPTIVE IMAGE: Deteksi orientasi gambar (Portrait vs Landscape) ---
            const heroImg = document.getElementById('mobileHeroImage');
            if (heroImg) {
                heroImg.onload = function() {
                    // Jika gambar lebih lebar dari tinggi (landscape), pakai cover
                    if (this.naturalWidth > this.naturalHeight) {
                        this.style.objectFit = 'cover';
                        this.style.background = 'transparent';
                    } else {
                        // Portrait atau Square, pakai contain agar tidak terpotong
                        this.style.objectFit = 'contain';
                        this.style.background = '#f0f0f0';
                    }
                };
                // Trigger jika gambar sudah di-cache
                if (heroImg.complete) {
                    heroImg.onload();
                }
            }
            // --------------------------------------------------------

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let selectedCommentId = null;
            // ... (rest of the script)

            // --- 1. Rating System ---
            const ratingModalEl = document.getElementById('ratingModal');
            if(ratingModalEl) {
                const ratingModal = new bootstrap.Modal(ratingModalEl);
                let selectedRating = null;
                let currentChecked = document.querySelector('.rating-input:checked');

                document.querySelectorAll('.rating-label').forEach(label => {
                    label.addEventListener('click', function() {
                        const inputId = this.getAttribute('for');
                        const input = document.getElementById(inputId);
                        if(input) {
                            selectedRating = input.value;
                            document.getElementById('ratingValueModal').innerText = selectedRating;
                            ratingModal.show();
                        }
                    });
                });

                document.getElementById('confirmRatingBtn').addEventListener('click', function() {
                    this.disabled = true; this.innerText = '...';
                    fetch("{{ route('artikel-siswa.rate', $konten->id) }}", {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
                        body: JSON.stringify({ rating: selectedRating })
                    }).then(() => window.location.reload());
                });

                 // Restore state if cancelled
                ratingModalEl.addEventListener('hidden.bs.modal', function () {
                   if(currentChecked) { currentChecked.checked = true; } 
                   else { document.querySelectorAll('.rating-input').forEach(i => i.checked = false); }
                });

                // --- HAPUS RATING (MODAL BARU) ---
                const btnDeleteRating = document.getElementById('btnDeleteRating');
                if(btnDeleteRating) {
                     const deleteRatingModal = new bootstrap.Modal(document.getElementById('deleteRatingModal'));
                     
                     btnDeleteRating.addEventListener('click', () => {
                         deleteRatingModal.show();
                     });

                     document.getElementById('confirmDeleteRatingBtn').addEventListener('click', function() {
                        this.disabled = true; this.innerText = '...';
                        fetch("{{ route('artikel-siswa.rate', $konten->id) }}", {
                             method: 'POST',
                             headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
                             body: JSON.stringify({ rating: 0 })
                         }).then(() => window.location.reload());
                     });
                }
            }

            // --- 2. Action Buttons (Like/Bookmark) ---
            // Sync semua button dengan action & id yang sama
             document.querySelectorAll('.btn-action').forEach(btn => {
                btn.addEventListener('click', function() {
                    const jenis = this.dataset.action;
                    const artikelId = this.dataset.id;
                    const isLike = jenis === 'suka';
                    const wasActive = this.classList.contains('active');
                    const isNowActive = !wasActive;
                    
                    // SYNC: Update SEMUA button dengan action dan id yang sama
                    document.querySelectorAll(`.btn-action[data-action="${jenis}"][data-id="${artikelId}"]`).forEach(siblingBtn => {
                        const siblingIcon = siblingBtn.querySelector('i');
                        
                        // Toggle class active
                        if (isNowActive) {
                            siblingBtn.classList.add('active');
                        } else {
                            siblingBtn.classList.remove('active');
                        }
                        
                        // Toggle Icon (Solid vs Outline)
                        if (siblingIcon) {
                            if (isNowActive) {
                                siblingIcon.classList.remove('far');
                                siblingIcon.classList.add('fas');
                            } else {
                                siblingIcon.classList.remove('fas');
                                siblingIcon.classList.add('far');
                            }
                        }
                    });

                    // Update Like Counts
                    if(isLike) {
                        const countElSide = document.getElementById('like-count-sidebar');
                        const countElHead = document.getElementById('like-count-header');
                        const countElMobile = document.getElementById('like-count-mobile');
                        
                        let currentVal = 0;
                        if(countElSide) currentVal = parseInt(countElSide.innerText);
                        else if(countElHead) currentVal = parseInt(countElHead.innerText);
                        else if(countElMobile) currentVal = parseInt(countElMobile.innerText);

                        let newVal = wasActive ? Math.max(0, currentVal - 1) : currentVal + 1;

                        if(countElSide) countElSide.innerText = newVal;
                        if(countElHead) countElHead.innerText = newVal;
                        if(countElMobile) countElMobile.innerText = newVal;
                    }

                    // Send to server
                    fetch("{{ route('artikel-siswa.interaksi', ':id') }}".replace(':id', artikelId), {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken},
                        body: JSON.stringify({ jenis })
                    });
                });
            });

            // --- 3. Comment Form ---
             const feedbackForm = document.getElementById('feedbackForm');
            if(feedbackForm) {
                feedbackForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    document.getElementById('submitBtn').disabled = true;
                    fetch(this.action, {
                        method: 'POST', body: new FormData(this),
                        headers: {'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest'}
                    }).then(r => r.json()).then(d => {
                        if(d.success) window.location.reload();
                        else { alert(d.message); document.getElementById('submitBtn').disabled = false; }
                    });
                });
            }

            // --- 4. Reply & Delete Comment ---
             document.querySelectorAll('.btn-reply, .btn-reply-inline').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const container = document.getElementById('replyFormContainer');
                    container.style.display = 'block';
                    document.getElementById('replyingToName').innerText = this.dataset.name;
                    document.getElementById('replyParentId').value = this.dataset.id;
                    document.getElementById('replyForm').action = `/artikel-siswa/{{ $konten->id }}/komentar/${this.dataset.id}`;
                    container.scrollIntoView({behavior: 'smooth', block: 'center'});
                    document.getElementById('komentarInput').focus();
                });
            });

             document.getElementById('cancelReplyBtn')?.addEventListener('click', () => {
                 document.getElementById('replyFormContainer').style.display = 'none';
             });

            document.querySelectorAll('.delete-comment').forEach(btn => {
                btn.addEventListener('click', function(e) { e.preventDefault(); selectedCommentId = this.dataset.id; new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show(); });
            });
            
             document.getElementById('confirmDeleteBtn')?.addEventListener('click', () => {
                 if(selectedCommentId) {
                     fetch("{{ route('komentar.destroy', ':id') }}".replace(':id', selectedCommentId), {
                         method: 'DELETE', headers: {'X-CSRF-TOKEN': csrfToken}
                     }).then(r => r.json()).then(d => { if(d.success) window.location.reload(); });
                 }
             });

            // --- 5. Toggle Replies (Instagram Style) ---
            document.querySelectorAll('.toggle-replies').forEach(btn => {
                btn.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    const repliesCount = this.dataset.repliesCount;
                    const container = document.getElementById(`replies-${commentId}`);
                    const line = '<span style="width: 20px; height: 1px; background-color: #ccc; display: inline-block;"></span>';
                    
                    if (container.style.display === 'none') {
                        container.style.display = 'block';
                        this.innerHTML = `${line} <span class="fw-medium">Sembunyikan balasan</span>`;
                    } else {
                        container.style.display = 'none';
                        this.innerHTML = `${line} <span class="fw-medium">Lihat ${repliesCount} balasan lainnya</span>`;
                    }
                });
            });
        });
    </script>
    @endsection

