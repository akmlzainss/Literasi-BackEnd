@extends('layouts.siswa')

@section('title', 'Jelajahi Artikel - SIPENA')

@section('body_class', 'artikel-page')

@section('content')
    <div class="hero-banner">
        <div class="container">
            <div class="hero-content text-center text-white">
                <div class="hero-icon mb-3">
                    <i class="fas fa-compass fa-3x"></i>
                </div>
                <h1 class="hero-title">Jelajahi Semua Artikel</h1>
                <p class="hero-subtitle">Temukan inspirasi dari berbagai tulisan kreatif teman-temanmu</p>
            </div>
        </div>
        <div class="hero-wave"></div>
    </div>

    <div class="container py-5">
        <section class="content-section">
            <div class="search-panel-card animate-ready">
                <div class="search-panel-header text-center mb-4">
                    <h3 class="search-panel-title">
                        <i class="fas fa-filter me-2 text-primary"></i>
                        Filter & Pencarian
                    </h3>
                    <p class="text-muted small">Gunakan filter di bawah untuk menemukan artikel yang kamu cari</p>
                </div>

                <form action="{{ route('artikel-siswa.index') }}" method="GET" class="search-form">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-search me-2"></i>Kata Kunci
                            </label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari judul artikel..." value="{{ request('search') }}">
                                <span class="input-group-text">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tags me-2"></i>Kategori
                            </label>
                            <select class="form-select" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach (\App\Models\Kategori::orderBy('nama', 'asc')->get() as $kategori)
                                    <option value="{{ $kategori->nama }}"
                                        {{ request('kategori') == $kategori->nama ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sort me-2"></i>Urutkan
                            </label>
                            <select class="form-select" name="sort">
                                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>
                                    Terbaru</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama
                                </option>
                                <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Paling Populer
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-12">
                            <button type="submit" class="btn btn-primary w-100 btn-search">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                        </div>
                    </div>

                    @if (request()->hasAny(['search', 'kategori', 'sort']))
                        <div class="active-filters mt-3">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span class="text-muted small me-2">Filter aktif:</span>
                                @if (request('search'))
                                    <span class="badge bg-primary">
                                        <i class="fas fa-search me-1"></i>
                                        "{{ request('search') }}"
                                        <a href="{{ route('artikel-siswa.index', request()->except('search')) }}"
                                            class="text-white ms-1">×</a>
                                    </span>
                                @endif
                                @if (request('kategori'))
                                    <span class="badge bg-success">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ request('kategori') }}
                                        <a href="{{ route('artikel-siswa.index', request()->except('kategori')) }}"
                                            class="text-white ms-1">×</a>
                                    </span>
                                @endif
                                @if (request('sort') && request('sort') != 'terbaru')
                                    <span class="badge bg-info">
                                        <i class="fas fa-sort me-1"></i>
                                        {{ ucfirst(request('sort')) }}
                                        <a href="{{ route('artikel-siswa.index', request()->except('sort')) }}"
                                            class="text-white ms-1">×</a>
                                    </span>
                                @endif
                                <a href="{{ route('artikel-siswa.index') }}" class="btn btn-link btn-sm text-danger p-0">
                                    <i class="fas fa-times me-1"></i>Reset semua
                                </a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <div class="results-summary animate-ready">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="results-info">
                        <h5 class="mb-1">
                            <i class="fas fa-list-ul me-2 text-primary"></i>
                            Hasil Pencarian
                        </h5>
                        <p class="text-muted mb-0 small">
                            Ditemukan {{ $artikels->total() }} artikel
                            @if (request()->hasAny(['search', 'kategori', 'sort']))
                                dengan filter yang dipilih
                            @endif
                        </p>
                    </div>
                    <div class="view-toggle d-none d-md-block">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary btn-sm active" id="gridView">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="listView">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="articles-container" id="articlesContainer">
                <div class="row g-4" id="articlesGrid">
                    @forelse ($artikels as $artikel)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-2 article-item animate-ready">
                            <a href="{{ route('artikel-siswa.show', $artikel->id) }}" class="content-card">
                                <div class="card-img-top-wrapper">
                                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}"
                                        class="card-img-top" alt="{{ $artikel->judul }}" loading="lazy">
                                    <div class="card-overlay">
                                        <i class="fas fa-eye"></i>
                                    </div>

                                    @if ($artikel->kategori)
                                        <div class="category-badge">
                                            <span class="badge">{{ $artikel->kategori->nama }}</span>
                                        </div>
                                    @endif

                                    @if ($artikel->created_at->diffInDays() < 7)
                                        <div class="new-badge">
                                            <span class="badge">Baru</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $artikel->judul }}</h5>
                                    <p class="card-author">
                                        <i class="fas fa-user-edit me-1"></i>
                                        {{ $artikel->siswa->nama ?? 'Admin' }}
                                    </p>
                                    <div class="card-meta">
                                        {{-- Badge kategori sudah dipindah ke atas --}}
                                        <small class="text-muted d-block">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $artikel->created_at->format('d M Y') }}
                                        </small>
                                    </div>
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
                            <div class="empty-state animate-ready">
                                <i class="fas fa-search empty-icon"></i>
                                <h4>Artikel tidak ditemukan</h4>
                                <p>
                                    Coba gunakan kata kunci atau filter yang berbeda, atau
                                    <a href="{{ route('artikel-siswa.index') }}">lihat semua artikel</a>
                                </p>
                                @auth('siswa')
                                <a href="{{ route('artikel-siswa.create') }}" class="btn btn-empty-action">
                                    <i class="fas fa-plus me-2"></i>Tulis Artikel Pertama
                                </a>
                                @else
                                <a href="{{ route('siswa.login') }}" class="btn btn-empty-action">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login untuk Menulis Artikel
                                </a>
                                @endauth
                            </div>
                        </div>
                    @endforelse
                </div>
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
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View toggle functionality
            const gridViewBtn = document.getElementById('gridView');
            const listViewBtn = document.getElementById('listView');
            const articlesContainer = document.getElementById('articlesContainer');

            if (gridViewBtn && listViewBtn) {
                gridViewBtn.addEventListener('click', function() {
                    articlesContainer.classList.remove('list-view');
                    gridViewBtn.classList.add('active');
                    listViewBtn.classList.remove('active');
                });

                listViewBtn.addEventListener('click', function() {
                    articlesContainer.classList.add('list-view');
                    listViewBtn.classList.add('active');
                    gridViewBtn.classList.remove('active');
                });
            }
        });
    </script>
@endsection
<script>
    // Normal pagination - no AJAX
</script>

@section('additional_css')
<style>
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: #64748b;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        max-width: 1200px;
        margin: 2rem auto;
    }

    .empty-state .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: #94a3b8;
        display: block;
    }

    .empty-state h4 {
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .empty-state a:not(.btn) {
        color: #3b82f6;
        text-decoration: none;
    }
    
    .empty-state a:not(.btn):hover {
        text-decoration: underline;
    }

    .empty-state .btn-empty-action {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important; /* Force background */
        border: none !important;
        border-radius: 6px !important;
        padding: 0.6rem 1.25rem !important;
        color: white !important;
        font-weight: 500 !important;
        font-size: 0.9rem !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
        display: inline-flex !important;
        align-items: center;
        gap: 0.5rem;
    }

    .empty-state .btn-empty-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59,130,246,0.4) !important;
    }

    .empty-state .btn-empty-action i {
        font-size: 0.8em !important;
        margin: 0 !important;
        position: relative !important;
        top: 1px !important;
        color: white !important; /* Ensure icon is white */
    }
    
    /* Ensure icon color is white explicitly */
    .empty-state .btn-empty-action .fa-plus,
    .empty-state .btn-empty-action .fa-sign-in-alt {
         color: white !important;
    }
</style>
@endsection
