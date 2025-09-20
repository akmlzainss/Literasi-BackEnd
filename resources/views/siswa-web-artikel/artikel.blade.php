<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Artikel - SiPena</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/websiswa.css') }}">
</head>
<body class="dashboard-page">

    <header class="header">
        <nav class="container navbar navbar-expand-lg">
            <a href="{{ route('dashboard-siswa') }}" class="logo"><i class="fas fa-graduation-cap"></i> SIPENA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a href="{{ route('dashboard-siswa') }}" class="nav-link">Beranda</a></li>
                    <li class="nav-item"><a href="{{ route('artikel-siswa') }}" class="nav-link active">Artikel</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Upload</a></li>
                    <li class="nav-item d-none d-lg-block"><div class="vr mx-3"></div></li>
                    @auth('siswa')
                        <li class="nav-item"><a href="#" class="nav-link" title="Notifikasi"><i class="fas fa-bell fs-5"></i></a></li>
                        <li class="nav-item"><a href="#" class="nav-link" title="Profil"><i class="fas fa-user-circle fs-5"></i></a></li>
                        <li class="nav-item ms-lg-3"><form action="{{ route('logout-siswa') }}" method="POST">@csrf<button type="submit" class="btn btn-danger btn-sm">Keluar</button></form></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Masuk</a></li>
                        <li class="nav-item ms-2"><a href="#" class="btn btn-primary btn-sm">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>

    <main class="container my-4">
        <section class="content-section">
            <h2 class="section-title">Jelajahi Semua Artikel</h2>
            
            {{-- ============================================= --}}
            {{-- FORM FILTER YANG DISEMPURNAKAN --}}
            {{-- ============================================= --}}
            <form action="{{ route('artikel-siswa') }}" method="GET" class="mb-5 p-4 border rounded-3 bg-light">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-12">
                        <label class="form-label fw-semibold">Kata Kunci</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari judul artikel..." value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select class="form-select" name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach (\App\Models\Kategori::orderBy('nama', 'asc')->get() as $kategori)
                                <option value="{{ $kategori->nama }}" {{ request('kategori') == $kategori->nama ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold">Urutkan Berdasarkan</label>
                        <select class="form-select" name="sort">
                            <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Paling Populer</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-2"></i>Cari</button>
                    </div>
                </div>
            </form>

            <div class="row g-4">
                @forelse ($artikels as $artikel)
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('artikel-siswa.show', $artikel->id) }}" class="content-card">
                            <div class="card-img-top-wrapper"><img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}" class="card-img-top" alt="{{ $artikel->judul }}"></div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $artikel->judul }}</h5>
                                <p class="card-author">Oleh: {{ $artikel->siswa->nama ?? 'Admin' }}</p>
                                <div class="card-stats">
                                    @php $avgRating = $artikel->nilai_rata_rata ?? 0; @endphp
                                    <span><i class="fas fa-eye fa-xs"></i> {{ $artikel->jumlah_dilihat ?? 0 }}</span>
                                    <span><i class="fas fa-star fa-xs"></i> {{ number_format($avgRating, 1) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Artikel tidak ditemukan</h4>
                        <p>Coba gunakan kata kunci atau filter yang berbeda.</p>
                    </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $artikels->appends(request()->query())->links() }}
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-5">
        <p class="mb-0">&copy; {{ date('Y') }} EduHub. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>