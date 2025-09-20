<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPena - Jelajahi Dunia Literasi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/websiswa.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
</head>
<body class="dashboard-page">

    <header class="header">
        <nav class="container navbar navbar-expand-lg">
            <a href="{{ route('dashboard-siswa') }}" class="logo"><i class="fas fa-graduation-cap"></i> SIPENA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a href="{{ route('dashboard-siswa') }}" class="nav-link active">Beranda</a></li>
                    <li class="nav-item">
    <a class="nav-link" href="{{ route('artikel-siswa') }}">Artikel</a>
</li>
                    <li class="nav-item"><a href="#" class="nav-link">Upload</a></li>
                    <li class="nav-item d-none d-lg-block"><div class="vr mx-3"></div></li>
                    @auth('siswa')
                        <li class="nav-item"><a href="#" class="nav-link" title="Notifikasi"><i class="fas fa-bell fs-5"></i></a></li>
                        <li class="nav-item"><a href="#" class="nav-link" title="Profil"><i class="fas fa-user-circle fs-5"></i></a></li>
                        <li class="nav-item ms-lg-3"><form action="{{ route('logout-siswa') }}" method="POST">@csrf<button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt me-1"></i> Keluar</button></form></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Masuk</a></li>
                        <li class="nav-item ms-2"><a href="#" class="btn btn-primary btn-sm">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>

    {{-- ============================================= --}}
    {{-- HERO SECTION BARU SESUAI PERMINTAAN ANDA --}}
    {{-- ============================================= --}}
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
                                        @if(isset($kategoris))
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->nama }}" {{ request('kategori') == $kategori->nama ? 'selected' : '' }}>
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
                                            <option value="{{ sprintf('%02d', $m) }}" {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
    <label class="form-label">Tahun</label>
    <input type="number" 
           name="year" 
           class="form-control" 
           placeholder="Contoh: 2025" 
           value="{{ request('year') }}"
           min="2020" 
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

    {{-- Konten Terbaru dengan ID untuk tombol scroll --}}
    <main class="container" id="konten-terbaru">
        <section class="content-section">
            <h2 class="section-title">Konten Terbaru</h2>
            <div class="row g-4">
                @forelse ($artikels as $artikel)
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('artikel-siswa.show', $artikel->id) }}" class="content-card">
                            <div class="card-img-top-wrapper"><img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $artikel->judul }}"></div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $artikel->judul }}</h5>
                                <p class="card-author">Penulis: {{ $artikel->siswa->nama ?? 'Admin' }}</p>
                                <div class="card-stats">
                                    @php $avgRating = $artikel->nilai_rata_rata ?? 0; @endphp
                                    <span><i class="fas fa-eye fa-xs"></i> {{ $artikel->jumlah_dilihat ?? 0 }}</span>
                                    <span><i class="fas fa-star fa-xs"></i> {{ number_format($avgRating, 1) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12"><p class="text-center text-muted">Konten tidak ditemukan.</p></div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $artikels->appends(request()->query())->links() }}
            </div>
        </section>
    </main>

    <section class="carousel-section">
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
                                <div class="card-img-top-wrapper"><img src="{{ $populer->gambar ? asset('storage/' . $populer->gambar) : asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $populer->judul }}"></div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $populer->judul }}</h5>
                                    <p class="card-author">Penulis: {{ $populer->siswa->nama ?? 'Admin' }}</p>
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

    <section class="kategori-section">
        <div class="container">
            <h2 class="kategori-title">Pilihan Sesuai Tema</h2>
            <p class="kategori-subtitle">Jelajahi pilihan artikel terbaik berdasarkan kategori berikut:</p>
            <div class="kategori-grid">
                @if(isset($kategoris))
                    @foreach ($kategoris as $kategori)
                        <a href="{{ route('dashboard-siswa', ['kategori' => $kategori->nama]) }}" class="kategori-item">
                            <div class="kategori-icon"><i class="fas fa-{{ $kategori->icon ?? 'book-open' }}"></i></div>
                            <div class="kategori-name">{{ $kategori->nama }}</div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center p-3">
        <p class="mb-0">&copy; {{ date('Y') }} EduHub. Hak Cipta Dilindungi.</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.artikel-swiper', {
            slidesPerView: 2, spaceBetween: 20,
            autoplay: { delay: 2500, disableOnInteraction: false, },
            breakpoints: {
                576: { slidesPerView: 3, spaceBetween: 20 },
                768: { slidesPerView: 4, spaceBetween: 30 },
                1024: { slidesPerView: 5, spaceBetween: 30 },
            },
        });
    });
    </script>
</body>
</html>