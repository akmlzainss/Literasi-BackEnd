@extends('layouts.layouts')

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
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari berdasarkan judul..." value="{{ request('search') }}">
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
                                    <input type="number" name="year" class="form-control"
                                        placeholder="Contoh: 2025" value="{{ request('year') }}" min="2020"
                                        max="{{ date('Y') }}">
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

    <div class="container" id="konten-terbaru">
        <section class="content-section">
            <h2 class="section-title">Konten Terbaru</h2>
            <div class="row g-4">
                @forelse ($artikels as $artikel)
                    <div class="col-6 col-md-3 col-lg-2">
                         <a href="{{ route('artikel-siswa.show', $artikel->id) }}" class="content-card">
                            <div class="card-img-top-wrapper">
                                <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $artikel->judul }}">
                                @if($artikel->kategori)
                                <div class="category-badge">
                                    <span class="badge">{{ $artikel->kategori->nama }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ Str::limit($artikel->judul, 30) }}</h5>
                                <p class="card-author">Oleh: {{ Str::limit($artikel->siswa->nama ?? 'Admin', 15) }}</p>
                                <div class="card-stats">
                                    @php $avgRating = $artikel->nilai_rata_rata ?? 0; @endphp
                                    <span><i class="fas fa-eye fa-xs"></i> {{ $artikel->jumlah_dilihat ?? 0 }}</span>
                                    <span><i class="fas fa-star fa-xs"></i> {{ number_format($avgRating, 1) }}</span>
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
            @if($artikels->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $artikels->appends(request()->query())->links() }}
                </div>
            @endif
        </section>
    </div>

    <section class="carousel-section has-wave-top">
        <div class="container">
            <div class="carousel-header">
                <h2 class="carousel-title">Paling Populer</h2>
                <p class="carousel-subtitle">Artikel yang paling sering dilihat oleh teman-temanmu</p>
            </div>
            <div class="swiper artikel-swiper">
                <div class="swiper-wrapper">
                    @foreach ($artikelPopuler as $populer)
                        <div class="swiper-slide">
                            <a href="{{ route('artikel-siswa.show', $populer->id) }}" class="content-card">
                                <div class="card-img-top-wrapper">
                                    <img src="{{ $populer->gambar ? asset('storage/' . $populer->gambar) : asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $populer->judul }}">
                                    
                                    @if($populer->kategori)
                                    <div class="category-badge">
                                        <span class="badge">{{ $populer->kategori->nama }}</span>
                                    </div>
                                    @endif

                                    @if($populer->created_at->diffInDays() < 7)
                                    <div class="new-badge">
                                        <span class="badge">Baru</span>
                                    </div>
                                    @endif
                                    </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($populer->judul, 30) }}</h5>
                                    <p class="card-author">Oleh: {{ Str::limit($populer->siswa->nama ?? 'Admin', 15) }}</p>
                                    <div class="card-stats">
                                        @php $avgRating = $populer->nilai_rata_rata ?? 0; @endphp
                                        <span><i class="fas fa-eye fa-xs"></i> {{ $populer->jumlah_dilihat ?? 0 }}</span>
                                        <span><i class="fas fa-star fa-xs"></i> {{ number_format($avgRating, 1) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="kategori-section has-wave-bottom">
        <div class="container">
            <h2 class="kategori-title">Pilihan Sesuai Tema</h2>
            <p class="kategori-subtitle">Jelajahi pilihan artikel terbaik berdasarkan kategori berikut:</p>

            <div class="swiper kategori-swiper">
                <div class="swiper-wrapper">
                    @if (isset($kategoris))
                        @foreach ($kategoris as $kategori)
                            <div class="swiper-slide">
                                <a href="{{ route('artikel-siswa', ['kategori' => $kategori->nama]) }}"
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
                    576: { slidesPerView: 3, spaceBetween: 20 },
                    768: { slidesPerView: 4, spaceBetween: 30 },
                    1024: { slidesPerView: 5, spaceBetween: 30 },
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
                    576: { slidesPerView: 4, spaceBetween: 20 },
                    768: { slidesPerView: 6, spaceBetween: 20 },
                    1024: { slidesPerView: 8, spaceBetween: 30 },
                },
            });
        });
    </script>
@endsection