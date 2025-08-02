@extends('layouts.app')

@section('title', 'Kelola Penghargaan')
@section('page-title', 'Kelola Penghargaan Literasi Akhlak')

@section('content')
<link rel="stylesheet" href="css/penghargaan.css">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Kelola Penghargaan</h1>
        <p class="page-subtitle">Atur dan kelola semua penghargaan untuk artikel literasi akhlak</p>
        
        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambahPenghargaan">
                <i class="fas fa-plus"></i>
                Tambah Penghargaan Baru
            </button>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-upload"></i>
                Import Penghargaan
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-download"></i>
                Export Data
            </a>
        </div>
    </div>

    <!-- Modal Tambah Penghargaan -->
    <div class="modal fade" id="modalTambahPenghargaan" tabindex="-1" aria-labelledby="modalTambahPenghargaanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPenghargaanLabel">Tambah Penghargaan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_penghargaan" class="form-label">Nama Penghargaan</label>
                            <input type="text" name="nama_penghargaan" id="nama_penghargaan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="periode" class="form-label">Periode</label>
                            <input type="text" name="periode" id="periode" class="form-control" placeholder="Contoh: 1 Januari - 31 Januari 2025" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat Penghargaan</label>
                            <select name="tingkat" id="tingkat" class="form-control">
                                <option value="gold">Emas</option>
                                <option value="silver">Perak</option>
                                <option value="bronze">Perunggu</option>
                                <option value="special">Khusus</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Penghargaan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-trophy me-2"></i>Daftar Penghargaan
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: 12 penghargaan</span>
            </div>
        </div>
        
        <div class="card-body-custom">
            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control search-input border-start-0" placeholder="Cari penghargaan...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Tingkat</option>
                            <option value="gold">Emas</option>
                            <option value="silver">Perak</option>
                            <option value="bronze">Perunggu</option>
                            <option value="special">Khusus</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Periode</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary w-100" style="border-radius: 12px;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Awards Grid -->
            <div class="awards-grid">
                <div class="row g-4">
                    <!-- Award Card 1 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="award-card fade-in">
                            <div class="award-header" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <h5 class="award-title">Artikel Terbaik Januari 2025</h5>
                                <span class="award-status status-active">Aktif</span>
                            </div>
                            <div class="award-content">
                                <p class="award-description">Penghargaan untuk artikel literasi akhlak terbaik pada periode Januari 2025.</p>
                                <div class="award-meta">
                                    <span><i class="fas fa-newspaper"></i> 10 Artikel</span>
                                    <span><i class="fas fa-star"></i> 100 Rating</span>
                                </div>
                                <div class="award-actions">
                                    <button class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action-card btn-edit-card">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action-card btn-delete-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Award Card 2 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="award-card fade-in">
                            <div class="award-header" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                                <h5 class="award-title">Artikel Terbaik Februari 2025</h5>
                                <span class="award-status status-active">Aktif</span>
                            </div>
                            <div class="award-content">
                                <p class="award-description">Penghargaan untuk artikel literasi akhlak terbaik pada periode Februari 2025.</p>
                                <div class="award-meta">
                                    <span><i class="fas fa-newspaper"></i> 5 Artikel</span>
                                    <span><i class="fas fa-star"></i> 90 Rating</span>
                                </div>
                                <div class="award-actions">
                                    <button class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action-card btn-edit-card">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action-card btn-delete-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Award Card 3 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="award-card fade-in">
                            <div class="award-header" style="background: linear-gradient(135deg, #92400e, #78350f);">
                                <h5 class="award-title">Artikel Terbaik Maret 2025</h5>
                                <span class="award-status status-inactive">Nonaktif</span>
                            </div>
                            <div class="award-content">
                                <p class="award-description">Penghargaan untuk artikel literasi akhlak terbaik pada periode Maret 2025.</p>
                                <div class="award-meta">
                                    <span><i class="fas fa-newspaper"></i> 8 Artikel</span>
                                    <span><i class="fas fa-star"></i> 85 Rating</span>
                                </div>
                                <div class="award-actions">
                                    <button class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action-card btn-edit-card">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action-card btn-delete-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Award Card 4 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="award-card fade-in">
                            <div class="award-header" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                                <h5 class="award-title">Artikel Terbaik April 2025</h5>
                                <span class="award-status status-active">Aktif</span>
                            </div>
                            <div class="award-content">
                                <p class="award-description">Penghargaan untuk artikel literasi akhlak terbaik pada periode April 2025.</p>
                                <div class="award-meta">
                                    <span><i class="fas fa-newspaper"></i> 12 Artikel</span>
                                    <span><i class="fas fa-star"></i> 92 Rating</span>
                                </div>
                                <div class="award-actions">
                                    <button class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action-card btn-edit-card">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action-card btn-delete-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Winners Section -->
            <div class="winners-section">
                <div class="card-header-custom">
                    <div>
                        <i class="fas fa-crown me-2"></i>Pemenang Penghargaan
                    </div>
                </div>
                <div class="card-body-custom">
                    <div class="winners-list">
                        <div class="winner-item fade-in">
                            <div class="winner-avatar" style="background: linear-gradient(135deg, #f59e0b, #d97706);">A</div>
                            <div class="winner-info">
                                <div class="winner-name">Ahmad Reza Pratama</div>
                                <div class="winner-description">"Penerapan Kejujuran dalam Kehidupan Sehari-hari"</div>
                            </div>
                            <div class="winner-rating">
                                <span class="rating-stars">★★★★★</span>
                                <span>4.9</span>
                            </div>
                        </div>
                        <div class="winner-item fade-in">
                            <div class="winner-avatar" style="background: linear-gradient(135deg, #6b7280, #4b5563);">S</div>
                            <div class="winner-info">
                                <div class="winner-name">Siti Nurhaliza</div>
                                <div class="winner-description">"Menghargai Perbedaan dan Toleransi"</div>
                            </div>
                            <div class="winner-rating">
                                <span class="rating-stars">★★★★☆</span>
                                <span>4.8</span>
                            </div>
                        </div>
                        <div class="winner-item fade-in">
                            <div class="winner-avatar" style="background: linear-gradient(135deg, #92400e, #78350f);">M</div>
                            <div class="winner-info">
                                <div class="winner-name">Muhammad Fajar</div>
                                <div class="winner-description">"Gotong Royong di Era Digital"</div>
                            </div>
                            <div class="winner-rating">
                                <span class="rating-stars">★★★★☆</span>
                                <span>4.5</span>
                            </div>
                        </div>
                        <div class="winner-item fade-in">
                            <div class="winner-avatar" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">A</div>
                            <div class="winner-info">
                                <div class="winner-name">Adrian Maulana</div>
                                <div class="winner-description">"Tanggung Jawab Bersama"</div>
                            </div>
                            <div class="winner-rating">
                                <span class="rating-stars">★★★★☆</span>
                                <span>4.5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection