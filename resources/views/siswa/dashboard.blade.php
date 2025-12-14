@extends('layouts.siswa')

@section('title', 'SiPena - Jelajahi Dunia Literasi')

@section('body_class', 'dashboard-page')

@section('content')
    <section class="hero-section" style="background-image: url('{{ asset('images/bg-reading.jpg') }}');">
        <div class="hero-content container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="hero-title">Jelajahi Pengetahuan, <br> Tumbuhkan Literasi di Sekolahmu</h1>
                    <p class="lead mt-3">
                        SIPENA hadir untuk membantu siswa menemukan artikel inspiratif, berbagi tulisan,
                        dan memperluas wawasan. Yuk, mulai belajar dengan cara yang seru dan menyenangkan!
                    </p>
                    <a href="#konten-terbaru" class="btn btn-primary mt-3 fw-bold">
                        <i class="fas fa-arrow-down me-2"></i> Lihat Konten Terbaru
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="search-card">
                        <h3 class="text-center fw-bold text-uppercase mb-4">Pencarian Artikel</h3>
                        <form action="{{ route('dashboard-siswa') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Kata Kunci</label>
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari berdasarkan judul atau isi artikel..."
                                            value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Tips: Gunakan kata kunci spesifik untuk hasil yang lebih
                                        akurat</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-select" name="kategori">
                                        <option value="">Semua Kategori</option>
                                        @if (isset($kategoris))
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->nama }}"
                                                    {{ request('kategori') == $kategori->nama ? 'selected' : '' }}>
                                                    {{ $kategori->nama }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Bulan</label>
                                    <select class="form-select" name="month">
                                        <option value="">Semua Bulan</option>
                                        @foreach (range(1, 12) as $m)
                                            <option value="{{ sprintf('%02d', $m) }}"
                                                {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Tahun</label>
                                    <select class="form-select" name="year">
                                        <option value="">Semua Tahun</option>
                                        @for ($year = date('Y'); $year >= 2020; $year--)
                                            <option value="{{ $year }}"
                                                {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Filter Tambahan</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <select class="form-select form-select-sm" name="rating">
                                                <option value="">Semua Rating</option>
                                                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>
                                                    ⭐⭐⭐⭐⭐ (5)</option>
                                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>
                                                    ⭐⭐⭐⭐ (4+)</option>
                                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐
                                                    (3+)</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select class="form-select form-select-sm" name="views">
                                                <option value="">Semua Views</option>
                                                <option value="popular"
                                                    {{ request('views') == 'popular' ? 'selected' : '' }}>Populer (100+
                                                    views)</option>
                                                <option value="trending"
                                                    {{ request('views') == 'trending' ? 'selected' : '' }}>Trending (50+
                                                    views)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                                        <i class="fas fa-search me-2"></i> CARI ARTIKEL
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Personal untuk Siswa yang Login -->
    @auth('siswa')
        <div class="container mb-5">
            <section class="personal-stats-section">
                <h2 class="section-title">Statistik Personal Anda</h2>
                <div class="row g-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card primary">
                            <div class="stat-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{ $personalStats['artikel_saya'] ?? 0 }}</h3>
                                <p>Artikel Saya</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card success">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{ $personalStats['artikel_disetujui'] ?? 0 }}</h3>
                                <p>Disetujui</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card warning">
                            <div class="stat-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{ number_format($personalStats['total_views'] ?? 0) }}</h3>
                                <p>Total Views</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card info">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{ number_format($personalStats['avg_rating'] ?? 0, 1) }}</h3>
                                <p>Rata-rata Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Rekomendasi Artikel -->
        @if (isset($rekomendasiArtikel) && $rekomendasiArtikel->count() > 0)
            <div class="container mb-5">
                <section class="recommendation-section">
                    <h2 class="section-title">Rekomendasi Untuk Anda</h2>
                    <p class="section-subtitle">Berdasarkan kategori yang sering Anda baca</p>
                    <div class="row g-4">
                        @foreach ($rekomendasiArtikel as $rekomendasi)
                            <div class="col-6 col-md-4 col-lg-2">
                                <a href="{{ route('artikel-siswa.show', $rekomendasi->id) }}"
                                    class="content-card recommendation-card">
                                    <div class="card-img-top-wrapper">
                                        <img src="{{ $rekomendasi->gambar ? asset('storage/' . $rekomendasi->gambar) : asset('images/no-image.jpg') }}"
                                            class="card-img-top" alt="{{ $rekomendasi->judul }}">
                                        <div class="recommendation-badge">
                                            <span class="badge">Rekomendasi</span>
                                        </div>
                                        @if ($rekomendasi->kategori)
                                            <div class="category-badge">
                                                <span class="badge">{{ $rekomendasi->kategori->nama }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ Str::limit($rekomendasi->judul, 25) }}</h5>
                                        <p class="card-author">{{ Str::limit($rekomendasi->siswa->nama ?? 'Admin', 12) }}</p>
                                        <div class="card-stats">
                                            <span><i class="fas fa-star fa-xs"></i>
                                                {{ number_format($rekomendasi->nilai_rata_rata ?? 0, 1) }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        @endif

        <!-- Artikel Bookmark -->
        @if (isset($artikelBookmark) && $artikelBookmark->count() > 0)
            <div class="container mb-5">
                <section class="bookmark-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-bookmark me-2 text-primary"></i>
                            Artikel Tersimpan
                        </h2>
                        <a href="{{ route('artikel-siswa.index', ['bookmark' => 1]) }}" class="btn btn-outline-primary btn-sm">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="row g-4">
                        @foreach ($artikelBookmark as $bookmark)
                            <div class="col-6 col-md-4 col-lg-2">
                                <a href="{{ route('artikel-siswa.show', $bookmark->id) }}"
                                    class="content-card bookmark-card">
                                    <div class="card-img-top-wrapper">
                                        <img src="{{ $bookmark->gambar ? asset('storage/' . $bookmark->gambar) : asset('images/no-image.jpg') }}"
                                            class="card-img-top" alt="{{ $bookmark->judul }}">
                                        <div class="bookmark-indicator-modern">
                                            <i class="fas fa-bookmark"></i>
                                        </div>
                                        @if ($bookmark->kategori)
                                            <div class="category-badge">
                                                <span class="badge">{{ $bookmark->kategori->nama }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ Str::limit($bookmark->judul, 25) }}</h5>
                                        <p class="card-author">{{ Str::limit($bookmark->siswa->nama ?? 'Admin', 12) }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        @endif
    @endauth

    <!-- Artikel Populer Bulan Ini -->
    <section class="carousel-section-modern has-wave-top-modern">
        <div class="container">
            <div class="carousel-header">
                <h2 class="carousel-title">
                    <i class="fas fa-fire me-2"></i>
                    Paling Populer Bulan Ini
                </h2>
                <p class="carousel-subtitle">Artikel dengan pembaca terbanyak di bulan {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}</p>
            </div>
            <div class="swiper artikel-swiper">
                <div class="swiper-wrapper">
                    @forelse ($artikelPopuler as $populer)
                        <div class="swiper-slide">
                            <a href="{{ route('artikel-siswa.show', $populer->id) }}" class="content-card">
                                <div class="card-img-top-wrapper">
                                    <img src="{{ $populer->gambar ? asset('storage/' . $populer->gambar) : asset('images/no-image.jpg') }}"
                                        class="card-img-top" alt="{{ $populer->judul }}">

                                    @if ($populer->kategori)
                                        <div class="category-badge">
                                            <span class="badge">{{ $populer->kategori->nama }}</span>
                                        </div>
                                    @endif

                                    <div class="popular-badge-fire">
                                        <span class="badge"><i class="fas fa-fire"></i> Populer</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($populer->judul, 50) }}</h5>
                                    <p class="card-author">Oleh: {{ Str::limit($populer->siswa->nama ?? 'Admin', 20) }}
                                    </p>
                                    <div class="card-stats">
                                        @php $avgRating = $populer->nilai_rata_rata ?? 0; @endphp
                                        <span><i class="fas fa-eye fa-xs"></i> {{ number_format($populer->jumlah_dilihat ?? 0) }}</span>
                                        <span><i class="fas fa-star fa-xs"></i> {{ number_format($avgRating, 1) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center text-white py-5">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                            <p class="mb-0">Belum ada artikel populer bulan ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <div class="container" id="konten-terbaru">
        <section class="content-section">
            <div class="section-header">
                <h2 class="section-title">Konten Terbaru</h2>
                <div class="filter-controls">
                    <select class="form-select form-select-sm" id="sortFilter" onchange="applySortFilter()">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi
                        </option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
            </div>
            <div class="row g-4">
                @forelse ($artikels as $artikel)
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('artikel-siswa.show', $artikel->id) }}" class="content-card">
                            <div class="card-img-top-wrapper">
                                <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}"
                                    class="card-img-top" alt="{{ $artikel->judul }}">
                                @if ($artikel->kategori)
                                    <div class="category-badge">
                                        <span class="badge">{{ $artikel->kategori->nama }}</span>
                                    </div>
                                @endif
                                @if ($artikel->created_at->diffInDays() < 3)
                                    <div class="new-badge">
                                        <span class="badge">Baru</span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ Str::limit($artikel->judul, 30) }}</h5>
                                <p class="card-author">Oleh: {{ Str::limit($artikel->siswa->nama ?? 'Admin', 15) }}</p>
                                <div class="card-stats">
                                    @php $avgRating = $artikel->nilai_rata_rata ?? 0; @endphp
                                    <span><i class="fas fa-eye fa-xs"></i>
                                        {{ number_format($artikel->jumlah_dilihat ?? 0) }}</span>
                                    <span><i class="fas fa-star fa-xs"></i> {{ number_format($avgRating, 1) }}</span>
                                    @if ($artikel->jumlah_suka > 0)
                                        <span><i class="fas fa-heart fa-xs"></i> {{ $artikel->jumlah_suka }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-file-alt"></i>
                            <h4>Belum Ada Artikel</h4>
                            <p>Tidak ada artikel yang cocok dengan pencarian Anda. Jadilah yang pertama menulis!</p>
                        </div>
                    </div>
                @endforelse
            </div>
            @if ($artikels->hasPages())
                <div class="pagination-wrapper animate-ready">
                    <div class="pagination-info text-center mt-4">
                        <small class="text-muted">
                            Menampilkan {{ $artikels->firstItem() }}-{{ $artikels->lastItem() }}
                            dari {{ $artikels->total() }} artikel
                        </small>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <nav aria-label="Pagination Navigation" class="pagination-enhanced">
                            {{ $artikels->appends(request()->query())->links('vendor.pagination.custom-pagination') }}
                        </nav>
                    </div>
                </div>
            @endif
        </section>
    </div>

    <section class="kategori-section-modern has-wave-bottom-modern">
        <div class="container">
            <h2 class="kategori-title">Pilihan Sesuai Tema</h2>
            <p class="kategori-subtitle">Jelajahi pilihan artikel terbaik berdasarkan kategori berikut:</p>

            <div class="swiper kategori-swiper">
                <div class="swiper-wrapper">
                    @if (isset($kategoris))
                        @foreach ($kategoris as $kategori)
                            <div class="swiper-slide">
                                <a href="{{ route('artikel-siswa.index', ['kategori' => $kategori->nama]) }}"
                                    class="kategori-item">
                                    <div class="kategori-icon"><i
                                            class="fas fa-{{ $kategori->icon ?? 'book-open' }}"></i>
                                    </div>
                                    <div class="kategori-name">{{ $kategori->nama }}</div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.artikel-swiper', {
                slidesPerView: 2,
                spaceBetween: 20,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 30
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 30
                    },
                },
            });

            new Swiper('.kategori-swiper', {
                slidesPerView: 3,
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    },
                    768: {
                        slidesPerView: 6,
                        spaceBetween: 20
                    },
                    1024: {
                        slidesPerView: 8,
                        spaceBetween: 30
                    },
                },
            });
        });

        // Function untuk sort filter
        function applySortFilter() {
            const sortValue = document.getElementById('sortFilter').value;
            const url = new URL(window.location);
            url.searchParams.set('sort', sortValue);
            window.location.href = url.toString();
        }

        // Function untuk clear search
        function clearSearch() {
            document.querySelector('input[name="search"]').value = '';
            document.querySelector('select[name="kategori"]').value = '';
            document.querySelector('select[name="month"]').value = '';
            document.querySelector('select[name="year"]').value = '';
            if (document.querySelector('select[name="rating"]')) {
                document.querySelector('select[name="rating"]').value = '';
            }
            if (document.querySelector('select[name="views"]')) {
                document.querySelector('select[name="views"]').value = '';
            }
        }

        // Animasi untuk stat cards saat scroll
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

        // Observe stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>
@endsection