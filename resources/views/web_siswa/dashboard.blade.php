<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPena - Jelajahi Dunia Literasi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0073E6; --primary-dark: #005bbd; --primary-blue: #1e3a8a;
            --primary-light: #3b82f6; --secondary-blue: #0ea5e9; --light-blue: #f0f9ff;
            --secondary: #6c757d; --light: #f9fafb; --white: #ffffff;
            --dark: #111827; --text-primary: #1e293b; --text-secondary: #64748b;
            --border: #e2e8f0; --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08); --shadow-lg: 0 10px 20px rgba(0, 0, 0, 0.1);
            --gradient-blue: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--light); color: var(--dark); }
        
        /* HEADER & NAVIGATION */
        .header { background: var(--white); box-shadow: var(--shadow-sm); position: sticky; top: 0; z-index: 1020; padding: 0.5rem 0; border-bottom: 1px solid var(--border); }
        .logo { font-size: 1.5rem; font-weight: 800; color: var(--primary); text-decoration: none; }
        .navbar-nav .nav-link { color: var(--dark); font-weight: 500; padding: 0.3rem 0.8rem !important; transition: all 0.3s ease; border-radius: 6px; font-size: 0.9rem; }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { color: var(--primary); background-color: rgba(0, 115, 230, 0.05); }
        .dropdown-menu { border-radius: 6px; border: 1px solid var(--border); box-shadow: var(--shadow-md); font-size: 0.9rem; }
        .nav-icon { font-size: 1.1rem; color: var(--secondary); transition: color 0.3s ease; }
        .nav-icon:hover { color: var(--primary); }
        .btn-sm { padding: 0.25rem 0.75rem; font-size: 0.8rem; }
        .navbar-collapse { flex-grow: 0; }
        @media (max-width: 991px) {
            .navbar-nav { margin-top: 0.5rem; }
            .navbar-nav .nav-link { padding: 0.5rem 1rem !important; }
            .dropdown-menu { margin-left: 1rem; }
            .d-flex.align-items-center { flex-direction: column; gap: 0.5rem; margin-top: 0.5rem; }
            .btn-sm { width: 100%; }
        }

        /* HERO SECTION */
        .hero-section {
            position: relative; padding: 4rem 0;
            background-image: url("{{ asset('images/hero-background.jpg') }}");
            background-size: cover; background-position: center center;
            min-height: 550px; display: flex; align-items: center;
        }
        .hero-section::before { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0, 20, 40, 0.8), rgba(0, 20, 40, 0.6)); }
        .hero-content { position: relative; z-index: 2; width: 100%; color: var(--white); }
        .hero-greeting { font-size: 1.2rem; font-weight: 500; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px;}
        .hero-title { font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; line-height: 1.3; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5); }
        .search-card {
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
            border-radius: 16px; padding: 1.5rem; box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .search-title { color: var(--dark); font-size: 1.1rem; font-weight: 700; text-align: center; margin-bottom: 1.5rem; text-transform: uppercase; }
        .search-card .form-label { color: var(--dark); font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem; }
        .search-card .form-select, .search-card .form-control { border: 1px solid var(--border); border-radius: 8px; padding: 0.6rem 1rem; font-size: 0.9rem; }
        .btn-search {
            background: var(--dark); color: var(--white); border: none; padding: 0.75rem 2rem;
            font-weight: 600; border-radius: 8px; font-size: 0.9rem; transition: all 0.3s ease;
        }
        .btn-search:hover { background: var(--primary); color: var(--white); transform: translateY(-2px); }

        /* CONTENT SECTION */
        .content-section {
            padding: 3rem 0;
            background-color: var(--white);
            border-radius: 16px;
            margin: 2rem 0;
            box-shadow: var(--shadow-md);
        }
        .section-title { font-size: 2rem; font-weight: 700; margin-bottom: 2rem; text-align: center; }
        .content-card { 
            background: var(--white); 
            border: 1px solid var(--border); 
            border-radius: 8px; 
            text-decoration: none; 
            color: var(--dark); 
            transition: all 0.3s ease; 
            display: flex; 
            flex-direction: column; 
            height: 100%; 
            overflow: hidden; 
            padding: 0.5rem; /* Tambahan padding untuk ruang */
        }
        .content-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--primary); }
        .card-img-top-wrapper { 
            position: relative; 
            width: 100%; 
            padding-top: 140%; 
            overflow: hidden; 
            background-color: #f0f0f0; 
            margin-bottom: 1rem; /* Jarak dari gambar ke teks */
        }
        .card-img-top { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        .card-type-badge { 
            position: absolute; top: 10px; right: 10px; 
            background-color: var(--primary); 
            color: var(--white); 
            padding: 4px 10px; 
            border-radius: 15px; 
            font-size: 0.75rem; 
            font-weight: 500; 
            display: flex; 
            align-items: center; 
            gap: 5px; 
        }
        .card-body { padding: 1rem; flex-grow: 1; display: flex; flex-direction: column; }
        .card-title { font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; line-height: 1.4; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .card-author { font-size: 0.85rem; color: var(--secondary); margin-bottom: 1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .card-stats { 
            display: flex; 
            align-items: center; 
            gap: 0.75rem; 
            font-size: 0.85rem; 
            color: var(--secondary); 
            border-top: 1px solid var(--border); 
            padding-top: 0.75rem; 
            margin-top: auto; 
        }
        .card-stats .stat-item { display: flex; align-items: center; gap: 0.25rem; }
        .card-stats .fa-star { color: #ffc107; }

        /* KATEGORI SECTION */
        .kategori-section {
            background: var(--gradient-blue); color: var(--white); padding: 5rem 0;
            position: relative; overflow: hidden;
        }
        .kategori-section::after {
            content: ''; position: absolute; top: -50px; left: 0; right: 0; height: 100px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100"><path fill="%23f9fafb" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,42.7C384,43,480,53,576,58.7C672,64,768,64,864,58.7C960,53,1056,43,1152,37.3C1248,32,1344,32,1392,32L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>') no-repeat top center;
            background-size: cover;
        }
        .kategori-title { font-size: clamp(1.8rem, 4vw, 2.5rem); font-weight: 700; text-align: center; margin-bottom: 0.5rem; }
        .kategori-subtitle { font-size: 1.1rem; text-align: center; opacity: 0.9; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto; }
        .kategori-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1.5rem; }
        .kategori-item { text-decoration: none; color: var(--white); text-align: center; transition: all 0.3s ease; }
        .kategori-item:hover { transform: translateY(-8px); color: var(--white); }
        .kategori-icon {
            width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); border-radius: 16px;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;
            font-size: 1.8rem; transition: all 0.3s ease; backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .kategori-item:hover .kategori-icon { background: rgba(255, 255, 255, 0.25); transform: scale(1.1) rotate(5deg); }
        .kategori-name { font-weight: 500; font-size: 0.9rem; }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 2rem; }
        .empty-state-icon { font-size: 3rem; color: var(--secondary); margin-bottom: 1rem; }
        .empty-state-title { font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem; }
        .empty-state-subtitle { font-size: 1rem; color: var(--secondary); max-width: 400px; margin: 0 auto; }

        @media (max-width: 768px) {
            .hero-section { min-height: 400px; padding: 2rem 0; }
            .hero-title { font-size: 1.8rem; }
            .search-card { padding: 1rem; }
            .content-section { padding: 2rem 0; margin: 1rem 0; }
            .section-title { font-size: 1.5rem; }
            .card-img-top-wrapper { padding-top: 120%; }
            .kategori-section { padding: 3rem 0; }
            .kategori-title { font-size: 1.5rem; }
            .col-6, .col-md-4, .col-lg-2 { width: 100%; margin-bottom: 1rem; }
        }
    </style>
</head>
<body>

    <header class="header">
        <nav class="container navbar navbar-expand-lg">
            <a href="{{ route('dashboard-siswa') }}" class="logo"><i class="fas fa-graduation-cap"></i> SIPENA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a href="{{ route('dashboard-siswa') }}" class="nav-link active">Beranda</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Artikel</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboard-siswa') }}">Semua Artikel</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @if(isset($kategoris))
                                @foreach ($kategoris->slice(0, 4) as $kategori) <!-- Ambil 4 kategori pertama -->
                                    <li><a class="dropdown-item" href="{{ route('dashboard-siswa', ['kategori' => $kategori->nama]) }}">{{ $kategori->nama }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">Upload</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    @auth('siswa')
                        <a href="#" class="nav-icon me-3" title="Notifikasi"><i class="fas fa-bell"></i></a>
                        <a href="#" class="nav-icon me-4" title="Profil"><i class="fas fa-user-circle"></i></a>
                        <form action="{{ route('logout-siswa') }}" method="POST"> @csrf <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt me-1"></i> Keluar</button></form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm"><i class="fas fa-user me-1"></i> Masuk</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h4 class="hero-greeting mb-3">Ayo, Bertualang!</h4>
                        <h1 class="hero-title">Temukan keseruan dan keajaiban dari setiap kisah di dalam artikel digital.</h1>
                    </div>
                    <div class="col-lg-6">
                        <div class="search-card">
                            <h3 class="search-title">PENCARIAN EDUHUB</h3>
                            <form action="{{ route('dashboard-siswa') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Kata Kunci</label>
                                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan judul..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Kategori</label>
                                        <select class="form-select" name="kategori">
                                            <option value="">Semua Kategori</option>
                                            @if(isset($kategoris))
                                                @foreach ($kategoris as $kategori)
                                                    <option value="{{ $kategori->nama }}" {{ request('kategori') == $kategori->nama ? 'selected' : '' }}>{{ $kategori->nama }}</option>
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
                                        <select class="form-select" name="year">
                                            <option value="">Semua Tahun</option>
                                            @php
                                                $currentYear = date('Y');
                                                $startYear = $currentYear - 5; // 5 tahun ke belakang
                                                for ($y = $currentYear; $y >= $startYear; $y--) {
                                                    echo "<option value='$y' " . (request('year') == $y ? 'selected' : '') . ">$y</option>";
                                                }
                                            @endphp
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-search w-100">CARI ARTIKEL</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="container">
        <section class="content-section pt-5">
            <h2 class="section-title mb-4">
                @if(request('kategori'))
                    Konten Kategori "{{ request('kategori') }}"
                @elseif(request('search'))
                    Hasil Pencarian "{{ request('search') }}"
                @elseif(request('month') && request('year'))
                    Artikel Bulan {{ date('F', mktime(0, 0, 0, request('month'), 1)) }} {{ request('year') }}
                @else
                    Konten Terbaru
                @endif
            </h2>
            
            <div class="row g-3 g-md-4">
                @forelse ($artikels as $artikel)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('artikel-siswa.show', $artikel->id) }}" class="content-card">
                            <div class="card-img-top-wrapper">
                                <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}"
                                     class="card-img-top" alt="{{ $artikel->judul }}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}';">
                                
                                <div class="card-type-badge">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $artikel->kategori->nama ?? 'Umum' }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $artikel->judul }}</h5>
                                <p class="card-author">Penulis: {{ $artikel->siswa->nama ?? 'Admin' }}</p>
                                <div class="card-stats">
                                    @php $avgRating = $artikel->ratingArtikel->avg('rating') ?? 0; @endphp
                                    <span class="stat-item" title="Dilihat"><i class="fas fa-eye fa-xs"></i> {{ $artikel->jumlah_dilihat ?? 0 }}</span>
                                    <span class="stat-item" title="Rating"><i class="fas fa-star fa-xs"></i> {{ number_format($avgRating, 1) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-search empty-state-icon"></i>
                            <h3 class="empty-state-title">Konten tidak ditemukan.</h3>
                            <p class="empty-state-subtitle">Coba gunakan kata kunci atau filter yang lain.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $artikels->appends(request()->query())->links() }}
            </div>
        </section>
    </main>

    <section class="kategori-section">
        <div class="container">
            <h2 class="kategori-title">Coba Baca Ini, Sepertinya Cocok Untukmu</h2>
            <p class="kategori-subtitle">Jelajahi pilihan artikel terbaik berdasarkan kategori berikut:</p>
            <div class="kategori-grid">
                @php
                    $kategoris = \App\Models\Kategori::all(); // Ambil semua kategori dari database
                @endphp
                @foreach ($kategoris as $kategori)
                    <a href="{{ route('dashboard-siswa', ['kategori' => $kategori->nama]) }}" class="kategori-item">
                        <div class="kategori-icon">
                            <i class="fas fa-{{ $kategori->icon ?? 'book-open' }}"></i>
                        </div>
                        <div class="kategori-name">{{ $kategori->nama }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center p-3">
        <p class="mb-0">&copy; {{ date('Y') }} EduHub. Hak Cipta Dilindungi.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

    