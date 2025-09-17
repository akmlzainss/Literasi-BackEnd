<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konten - {{ $konten->judul }}</title>
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

        .detail-card {
            background: var(--bg-secondary);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card-header-custom {
            background: var(--primary-gradient);
            color: white;
            padding: 1.2rem;
            border-radius: 16px 16px 0 0;
            margin: -2rem -2rem 2rem;
            font-weight: 600;
        }

        .detail-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .detail-image {
            width: 100%;
            max-height: 400px;
            overflow: hidden;
            border-radius: 12px;
        }

        .img-fluid {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }

        .content-type .category-tag {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary-blue);
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .detail-title {
            font-size: 2rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1rem;
        }

        .content-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .article-content-detail {
            font-size: 1rem;
            line-height: 1.6;
            color: var(--text-primary);
        }

        .video-content video {
            border-radius: 12px;
        }

        .video-content p {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .detail-stats p {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .detail-stats strong {
            color: var(--text-primary);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        .fade-in-delay-2 { animation-delay: 0.2s; }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1024px) {
            .detail-content { gap: 1rem; }
        }

        @media (max-width: 768px) {
            .welcome-section { padding: 1.5rem; }
            .welcome-title { font-size: 2rem; }
            .quick-actions { justify-content: center; }
            .quick-action-btn { padding: 0.5rem 1rem; font-size: 0.9rem; }
            .card-header-custom { margin: -1.5rem -1.5rem 1.5rem; padding: 1rem; }
            .detail-card { padding: 1.5rem; }
            .detail-title { font-size: 1.5rem; }
        }

        @media (max-width: 480px) {
            .welcome-title { font-size: 1.75rem; }
            .quick-action-btn { width: 100%; justify-content: center; }
            .detail-image { max-height: 200px; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Welcome Section -->
        <section class="welcome-section fade-in">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="welcome-title">Detail Konten</h1>
                    <p class="welcome-subtitle">Jelajahi isi lengkap konten literasi akhlak.</p>
                    <div class="quick-actions">
                        <a href="{{ route('artikel-siswa') }}" class="quick-action-btn secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Jelajah
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Detail Card -->
        <div class="detail-card fade-in fade-in-delay-2">
            <div class="card-header-custom">
                <div>
                    <i class="{{ $konten->jenis == 'artikel' ? 'fas fa-book-open' : 'fas fa-play' }} me-2"></i>{{ $konten->judul }}
                </div>
            </div>
            <div class="card-body-custom">
                <div class="detail-content">
                    <div class="detail-image">
                        <img src="{{ $konten->gambar ? asset('storage/' . $konten->gambar) : ($konten->jenis == 'video' ? asset('images/video-placeholder.jpg') : asset('images/no-image.png')) }}"
                            alt="{{ $konten->judul }}" class="img-fluid"
                            onerror="this.src='{{ $konten->jenis == 'video' ? asset('images/video-placeholder.jpg') : asset('images/no-image.png') }}';">
                    </div>
                    <div class="detail-info">
                        <div class="content-type mb-3">
                            <span class="category-tag">{{ ucfirst($konten->jenis) }}</span>
                        </div>
                        <h2 class="detail-title">{{ $konten->judul }}</h2>
                        <div class="content-meta mb-3">
                            <span><i class="fas fa-user"></i> {{ $konten->siswa->nama ?? 'Admin' }}</span>
                            <span><i class="fas fa-eye"></i> {{ $konten->jumlah_dilihat }}</span>
                            <span><i class="fas fa-clock"></i> {{ $konten->created_at?->format('d M Y') }}</span>
                        </div>
                        <div class="detail-body">
                            @if ($konten->jenis == 'artikel')
                                <div class="article-content-detail">
                                    {!! $konten->isi !!}
                                </div>
                            @else
                                <div class="video-content">
                                    <video controls class="w-100" poster="{{ $konten->gambar ?? asset('images/video-placeholder.jpg') }}">
                                        <source src="{{ asset('storage/' . $konten->file) }}" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                    <p class="mt-2">{{ $konten->deskripsi }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="detail-stats mt-4">
                            <p><strong>Jenis:</strong> {{ ucfirst($konten->jenis) }}</p>
                            <p><strong>Dibuat pada:</strong> {{ $konten->created_at?->format('d M Y, H:i') }}</p>
                            @if ($konten->diterbitkan_pada)
                                <p><strong>Diterbitkan pada:</strong> {{ $konten->diterbitkan_pada?->format('d M Y, H:i') }}</p>
                            @endif
                            <p><strong>Jumlah Suka:</strong> {{ $konten->jumlah_suka }}</p>
                            <p><strong>Jumlah Komentar:</strong> {{ $konten->komentarKonten->count() }}</p>
                            <p><strong>Rating:</strong>
                                @if ($konten->ratingKonten->count() > 0)
                                    @php
                                        $avgRating = round($konten->ratingKonten->avg('rating'), 1);
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($avgRating))
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                    <span>({{ $avgRating }}/5)</span>
                                @else
                                    Belum ada rating
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
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
        });
    </script>
</body>
</html>