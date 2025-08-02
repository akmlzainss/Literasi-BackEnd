@extends('layouts.app')

@section('title', 'Kelola Artikel')
@section('page-title', 'Kelola Artikel Literasi Akhlak')

@section('content')
<link rel="stylesheet" href="css/artikel.css">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Kelola Artikel</h1>
        <p class="page-subtitle">Kelola dan atur semua artikel literasi akhlak untuk sistem pembelajaran</p>
        
        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambahArtikel">
                <i class="fas fa-plus"></i>
                Tambah Artikel Baru
            </button>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-upload"></i>
                Import Artikel
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-download"></i>
                Export Data
            </a>
        </div>
    </div>

    <!-- Modal Tambah Artikel -->
    <div class="modal fade" id="modalTambahArtikel" tabindex="-1" aria-labelledby="modalTambahArtikelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahArtikelLabel">Tambah Artikel Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Artikel</label>
                            <input type="text" name="judul" id="judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Artikel</label>
                            <textarea name="isi" id="isi" class="form-control" rows="6" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar (opsional)</label>
                            <input type="file" name="gambar" id="gambar" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Artikel</button>
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
                <i class="fas fa-newspaper me-2"></i>Daftar Artikel
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: 245 artikel</span>
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
                            <input type="text" class="form-control search-input border-start-0" placeholder="Cari artikel...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Kategori</option>
                            <option value="akhlak-mulia">Akhlak Mulia</option>
                            <option value="karakter-islami">Karakter Islami</option>
                            <option value="literasi-digital">Literasi Digital</option>
                            <option value="kearifan-lokal">Kearifan Lokal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Status</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary w-100" style="border-radius: 12px;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="articles-grid">
                <div class="row g-4">
                    <!-- Article Card 1 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="article-card">
                            <div class="article-image">
                                <img src="https://via.placeholder.com/400x200/2563eb/ffffff?text=Literasi+Digital" alt="Article">
                                <div class="article-overlay">
                                    <div class="article-actions">
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
                                <div class="article-status">
                                    <span class="status-badge status-published">Published</span>
                                </div>
                            </div>
                            <div class="article-content">
                                <div class="article-category">
                                    <span class="category-tag">Literasi Digital</span>
                                </div>
                                <h5 class="article-title-card">Pentingnya Literasi Digital dalam Era Modern</h5>
                                <p class="article-excerpt-card">Membahas bagaimana literasi digital menjadi keterampilan penting bagi generasi muda dalam menghadapi tantangan teknologi modern dan cara mengimplementasikannya...</p>
                                
                                <div class="article-author-card">
                                    <div class="author-avatar">SN</div>
                                    <div class="author-info">
                                        <div class="author-name">Dra. Siti Nurhaliza</div>
                                        <div class="author-role">Guru Bahasa Indonesia</div>
                                    </div>
                                </div>
                                
                                <div class="article-meta-card">
                                    <div class="meta-stats">
                                        <span><i class="fas fa-eye"></i> 1,234</span>
                                        <span><i class="fas fa-heart"></i> 89</span>
                                        <span><i class="fas fa-comment"></i> 23</span>
                                    </div>
                                    <div class="article-date">
                                        <small>28 Jul 2025</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Card 2 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="article-card">
                            <div class="article-image">
                                <img src="https://via.placeholder.com/400x200/10b981/ffffff?text=Karakter+Islami" alt="Article">
                                <div class="article-overlay">
                                    <div class="article-actions">
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
                                <div class="article-status">
                                    <span class="status-badge status-published">Published</span>
                                </div>
                            </div>
                            <div class="article-content">
                                <div class="article-category">
                                    <span class="category-tag">Karakter Islami</span>
                                </div>
                                <h5 class="article-title-card">Membangun Karakter Islami di Lingkungan Sekolah</h5>
                                <p class="article-excerpt-card">Strategi dan metode untuk membangun karakter islami yang kuat pada siswa melalui kegiatan-kegiatan positif di sekolah dan lingkungan belajar...</p>
                                
                                <div class="article-author-card">
                                    <div class="author-avatar">AH</div>
                                    <div class="author-info">
                                        <div class="author-name">Ahmad Hidayat, S.Pd.I</div>
                                        <div class="author-role">Guru PAI</div>
                                    </div>
                                </div>
                                
                                <div class="article-meta-card">
                                    <div class="meta-stats">
                                        <span><i class="fas fa-eye"></i> 987</span>
                                        <span><i class="fas fa-heart"></i> 67</span>
                                        <span><i class="fas fa-comment"></i> 18</span>
                                    </div>
                                    <div class="article-date">
                                        <small>27 Jul 2025</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Card 3 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="article-card">
                            <div class="article-image">
                                <img src="https://via.placeholder.com/400x200/f59e0b/ffffff?text=Akhlak+Mulia" alt="Article">
                                <div class="article-overlay">
                                    <div class="article-actions">
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
                                <div class="article-status">
                                    <span class="status-badge status-draft">Draft</span>
                                </div>
                            </div>
                            <div class="article-content">
                                <div class="article-category">
                                    <span class="category-tag">Akhlak Mulia</span>
                                </div>
                                <h5 class="article-title-card">Implementasi Akhlak Mulia dalam Kehidupan Sehari-hari</h5>
                                <p class="article-excerpt-card">Panduan praktis untuk mengimplementasikan nilai-nilai akhlak mulia dalam kehidupan sehari-hari siswa, baik di sekolah maupun di rumah...</p>
                                
                                <div class="article-author-card">
                                    <div class="author-avatar">FA</div>
                                    <div class="author-info">
                                        <div class="author-name">Fatimah Azzahra, S.Pd</div>
                                        <div class="author-role">Guru BK</div>
                                    </div>
                                </div>
                                
                                <div class="article-meta-card">
                                    <div class="meta-stats">
                                        <span><i class="fas fa-eye"></i> 456</span>
                                        <span><i class="fas fa-heart"></i> 34</span>
                                        <span><i class="fas fa-comment"></i> 12</span>
                                    </div>
                                    <div class="article-date">
                                        <small>26 Jul 2025</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Card 4 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="article-card">
                            <div class="article-image">
                                <img src="https://via.placeholder.com/400x200/06b6d4/ffffff?text=Kearifan+Lokal" alt="Article">
                                <div class="article-overlay">
                                    <div class="article-actions">
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
                                <div class="article-status">
                                    <span class="status-badge status-published">Published</span>
                                </div>
                            </div>
                            <div class="article-content">
                                <div class="article-category">
                                    <span class="category-tag">Kearifan Lokal</span>
                                </div>
                                <h5 class="article-title-card">Melestarikan Kearifan Lokal Sunda di Era Digital</h5>
                                <p class="article-excerpt-card">Bagaimana generasi muda dapat melestarikan kearifan lokal Sunda sambil tetap beradaptasi dengan perkembangan teknologi digital...</p>
                                
                                <div class="article-author-card">
                                    <div class="author-avatar">RH</div>
                                    <div class="author-info">
                                        <div class="author-name">R. Hendra Gunawan, M.Pd</div>
                                        <div class="author-role">Guru Seni Budaya</div>
                                    </div>
                                </div>
                                
                                <div class="article-meta-card">
                                    <div class="meta-stats">
                                        <span><i class="fas fa-eye"></i> 789</span>
                                        <span><i class="fas fa-heart"></i> 56</span>
                                        <span><i class="fas fa-comment"></i> 29</span>
                                    </div>
                                    <div class="article-date">
                                        <small>25 Jul 2025</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Card 5 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="article-card">
                            <div class="article-image">
                                <img src="https://via.placeholder.com/400x200/8b5cf6/ffffff?text=Toleransi" alt="Article">
                                <div class="article-overlay">
                                    <div class="article-actions">
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
                                <div class="article-status">
                                    <span class="status-badge status-archived">Archived</span>
                                </div>
                            </div>
                            <div class="article-content">
                                <div class="article-category">
                                    <span class="category-tag">Toleransi</span>
                                </div>
                                <h5 class="article-title-card">Membangun Toleransi Antar Sesama di Sekolah</h5>
                                <p class="article-excerpt-card">Pentingnya membangun sikap toleransi dan saling menghormati antar siswa dari berbagai latar belakang yang berbeda di lingkungan sekolah...</p>
                                
                                <div class="article-author-card">
                                    <div class="author-avatar">DN</div>
                                    <div class="author-info">
                                        <div class="author-name">Dini Nurhayati, S.Sos</div>
                                        <div class="author-role">Guru PKn</div>
                                    </div>
                                </div>
                                
                                <div class="article-meta-card">
                                    <div class="meta-stats">
                                        <span><i class="fas fa-eye"></i> 1,123</span>
                                        <span><i class="fas fa-heart"></i> 78</span>
                                        <span><i class="fas fa-comment"></i> 45</span>
                                    </div>
                                    <div class="article-date">
                                        <small>24 Jul 2025</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Card 6 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="article-card">
                            <div class="article-image">
                                <img src="https://via.placeholder.com/400x200/ec4899/ffffff?text=Kepemimpinan" alt="Article">
                                <div class="article-overlay">
                                    <div class="article-actions">
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
                                <div class="article-status">
                                    <span class="status-badge status-published">Published</span>
                                </div>
                            </div>
                            <div class="article-content">
                                <div class="article-category">
                                    <span class="category-tag">Kepemimpinan</span>
                                </div>
                                <h5 class="article-title-card">Menumbuhkan Jiwa Kepemimpinan pada Siswa</h5>
                                <p class="article-excerpt-card">Cara efektif untuk menumbuhkan dan mengembangkan jiwa kepemimpinan pada siswa melalui berbagai kegiatan dan program sekolah...</p>
                                
                                <div class="article-author-card">
                                    <div class="author-avatar">BP</div>
                                    <div class="author-info">
                                        <div class="author-name">Bambang Priyanto, M.Pd</div>
                                        <div class="author-role">Wakil Kepala Sekolah</div>
                                    </div>
                                </div>
                                
                                <div class="article-meta-card">
                                    <div class="meta-stats">
                                        <span><i class="fas fa-eye"></i> 892</span>
                                        <span><i class="fas fa-heart"></i> 63</span>
                                        <span><i class="fas fa-comment"></i> 31</span>
                                    </div>
                                    <div class="article-date">
                                        <small>23 Jul 2025</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
@endsection