@extends('layouts.app')

@section('title', 'Kelola Penghargaan')
@section('page-title', 'Kelola Penghargaan Literasi Akhlak')

@section('content')
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

    <style>
        .page-header {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .page-title {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-light);
            font-weight: 400;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-custom:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        .main-card {
            background: var(--bg-white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: none;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            padding: 1.5rem 2rem;
            border: none;
            font-weight: 600;
            font-size: 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body-custom {
            padding: 2rem;
        }

        .search-filter-section {
            background: var(--bg-light);
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .search-input {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .filter-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            background: white;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .awards-grid {
            margin-top: 1rem;
        }

        .award-card {
            background: var(--bg-white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            height: 100%;
            border: 1px solid rgba(37, 99, 235, 0.1);
            position: relative;
        }

        .award-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .award-header {
            padding: 1.5rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .award-title {
            font-weight: 700;
            font-size: 1.3rem;
            margin: 0;
            line-height: 1.4;
        }

        .award-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.2);
        }

        .status-active {
            color: #10b981;
            background: rgba(16, 185, 129, 0.2);
        }

        .status-inactive {
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.2);
        }

        .award-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .award-description {
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .award-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .award-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .award-meta i {
            font-size: 0.7rem;
        }

        .award-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .btn-action-card {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .btn-view-card {
            background: rgba(37, 99, 235, 0.9);
            color: white;
        }

        .btn-view-card:hover {
            background: var(--primary-blue);
            transform: scale(1.1);
        }

        .btn-edit-card {
            background: rgba(245, 158, 11, 0.9);
            color: white;
        }

        .btn-edit-card:hover {
            background: var(--warning);
            transform: scale(1.1);
        }

        .btn-delete-card {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .btn-delete-card:hover {
            background: var(--danger);
            transform: scale(1.1);
        }

        .winners-section {
            background: var(--bg-white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin-top: 2rem;
            overflow: hidden;
        }

        .winners-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .winner-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            background: rgba(37, 99, 235, 0.05);
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .winner-item:hover {
            background: rgba(37, 99, 235, 0.1);
            transform: translateX(5px);
        }

        .winner-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .winner-info {
            flex: 1;
        }

        .winner-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .winner-description {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .winner-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .rating-stars {
            color: #f59e0b;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 1rem;
            }

            .award-title {
                font-size: 1.1rem;
            }

            .award-actions {
                justify-content: center;
            }
        }
    </style>

    <script>
        document.querySelectorAll('.btn-action-card').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.querySelector('i').classList;
                if (action.contains('fa-eye')) {
                    alert('Membuka detail penghargaan...');
                } else if (action.contains('fa-edit')) {
                    alert('Membuka form edit penghargaan...');
                } else if (action.contains('fa-trash')) {
                    if (confirm('Apakah Anda yakin ingin menghapus penghargaan ini?')) {
                        alert('Penghargaan berhasil dihapus!');
                    }
                }
            });
        });
    </script>
@endsection