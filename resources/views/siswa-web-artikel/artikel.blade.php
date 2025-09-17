<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Konten</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/websiswa.css') }}">
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --primary-light: #3b82f6;
            --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
            --secondary-blue: #0ea5e9;
            --accent-blue: #06b6d4;
            --dark-blue: #0f172a;
            --light-blue: #f0f9ff;
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .container-fluid {
            padding: 0 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .welcome-section {
            background: var(--bg-secondary);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .quick-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .quick-action-btn {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transform: perspective(1000px) rotateX(0deg);
        }

        .quick-action-btn:hover {
            color: white;
            transform: perspective(1000px) rotateX(-10deg) translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .quick-action-btn.secondary {
            background: var(--bg-secondary);
            color: var(--primary-blue);
            border: 2px solid var(--primary-light);
        }

        .quick-action-btn.secondary:hover {
            background: var(--primary-light);
            color: white;
        }

        .content-explorer {
            padding: 0 1rem;
        }

        .search-filter-section {
            background: var(--bg-secondary);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .input-group-text {
            background: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            border: none;
            color: white;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
        }

        .content-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .content-card {
            background: var(--bg-secondary);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .content-image {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
        }

        .img-fluid {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        .content-type-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .content-info {
            padding: 1.2rem;
        }

        .content-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .content-excerpt {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .content-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-light);
            color: var(--primary-blue);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-light);
            color: white;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        .fade-in-delay-2 { animation-delay: 0.2s; }
        .fade-in-delay-3 { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
        }

        @media (max-width: 1024px) {
            .content-cards-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .welcome-section { padding: 1.5rem; }
            .welcome-title { font-size: 2rem; }
            .quick-actions { justify-content: center; }
            .quick-action-btn { padding: 0.5rem 1rem; font-size: 0.9rem; }
            .search-filter-section { padding: 1rem; }
            .content-image { height: 150px; }
        }

        @media (max-width: 480px) {
            .welcome-title { font-size: 1.75rem; }
            .quick-action-btn { width: 100%; justify-content: center; }
            .content-image { height: 120px; }
            .row.g-3 { flex-direction: column; }
            .col-md-2, .col-md-3, .col-md-4 { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Welcome Section -->
        <section class="welcome-section fade-in">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="welcome-title">Jelajahi Konten</h1>
                    <p class="welcome-subtitle">Temukan artikel, video, dan sumber belajar menarik untuk perjalanan Anda.</p>
                    <div class="quick-actions">
                        <a href="{{ route('artikel.create') }}" class="quick-action-btn">
                            <i class="fas fa-plus me-2"></i>Buat Konten Baru
                        </a>
                        <a href="#" class="quick-action-btn secondary">
                            <i class="fas fa-bookmark me-2"></i>Konten Tersimpan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Content Explorer -->
        <div class="content-explorer fade-in fade-in-delay-2">
            <!-- Search and Filter -->
            <div class="search-filter-section mb-4">
                <form method="GET" action="{{ route('artikel-siswa') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0"
                                    placeholder="Cari konten..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-list-alt text-muted"></i>
                                </span>
                                <select name="jenis" class="form-select border-start-0">
                                    <option value="">Semua Jenis</option>
                                    <option value="artikel" {{ request('jenis') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                                    <option value="video" {{ request('jenis') == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-tag text-muted"></i>
                                </span>
                                <select name="kategori" class="form-select border-start-0">
                                    <option value="">Semua Kategori</option>
                                    @foreach (\App\Models\Kategori::all() as $kategori)
                                        <option value="{{ $kategori->nama }}"
                                            {{ request('kategori') == $kategori->nama ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-filter me-1"></i>Terapkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Content Cards -->
            <div class="content-cards-grid">
                @forelse ($artikels as $item)
                    <div class="content-card fade-in fade-in-delay-3" data-type="{{ $item->jenis ?? 'artikel' }}">
                        <div class="content-image">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/no-image.png') }}"
                                alt="{{ $item->judul }}" class="img-fluid"
                                onerror="this.src='{{ asset('images/no-image.png') }}';">
                            <div class="content-type-badge">
                                <i class="fas fa-book"></i>Artikel
                            </div>
                        </div>
                        <div class="content-info">
                            <h5 class="content-title">{{ $item->judul }}</h5>
                            <p class="content-excerpt">{{ Str::limit(strip_tags($item->isi ?? ''), 100) }}</p>
                            <div class="content-meta">
                                <span><i class="fas fa-user"></i> {{ $item->siswa->nama ?? 'Admin' }}</span>
                                <span><i class="fas fa-eye"></i> {{ $item->jumlah_dilihat }}</span>
                                <span><i class="fas fa-clock"></i> {{ $item->created_at?->format('d M Y') }}</span>
                            </div>
                            <a href="{{ route('artikel-siswa.show', $item->id) }}"
                                class="btn btn-outline-primary btn-sm mt-2">
                                <i class="fas fa-eye me-1"></i>Lihat
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted">Tidak ada konten yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="text-center mt-4">
                {{ $artikels->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('.fade-in').forEach(el => {
                el.style.animationPlayState = 'paused';
                observer.observe(el);
            });

            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            if (successAlert) setTimeout(() => successAlert.style.display = 'none', 5000);
            if (errorAlert) setTimeout(() => errorAlert.style.display = 'none', 5000);

            document.querySelectorAll('.content-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px) scale(1.02)';
                    card.style.boxShadow = 'var(--shadow-lg)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                    card.style.boxShadow = 'var(--shadow-md)';
                });
            });
        });
    </script>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show glass-card position-fixed top-0 end-0 m-3" role="alert" id="successAlert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show glass-card position-fixed top-0 end-0 m-3" role="alert" id="errorAlert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</body>
</html>