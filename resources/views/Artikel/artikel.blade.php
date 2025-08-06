@extends('layouts.app')

@section('title', 'Kelola Artikel')
@section('page-title', 'Kelola Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Kelola Artikel</h1>
        <p class="page-subtitle">Kelola dan atur semua artikel literasi akhlak untuk sistem pembelajaran</p>

        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambahArtikel">
                <i class="fas fa-plus"></i>
                Tambah Artikel Baru
            </button>
            <a href="{{ route('artikel.export') }}" class="btn-outline-custom">
                <i class="fas fa-download"></i>
                Export Data
            </a>
        </div>
    </div>

    <!-- Modal Tambah Artikel -->
    <div class="modal fade" id="modalTambahArtikel" tabindex="-1" aria-labelledby="modalTambahArtikelLabel"
        aria-hidden="true">
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
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="form-select">
                                <option value="">Pilih Kategori</option>
                                @foreach (\App\Models\Kategori::all() as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_siswa" class="form-label">Siswa</label>
                            <select name="id_siswa" id="id_siswa" class="form-select" required>
                                <option value="">Pilih Siswa</option>
                                @foreach (\App\Models\Siswa::all() as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select name="jenis" id="jenis" class="form-select" required>
                                <option value="bebas">Bebas</option>
                                <option value="resensi_buku">Resensi Buku</option>
                                <option value="resensi_film">Resensi Film</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="menunggu">Menunggu</option>
                                <option value="draf">Draf</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
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
                <span>Total: {{ $artikels->total() }} artikel</span>
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
                            <input type="text" id="searchInput" class="form-control search-input border-start-0"
                                placeholder="Cari artikel..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select id="filterCategory" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach (\App\Models\Kategori::all() as $kategori)
                                <option value="{{ $kategori->nama }}"
                                    {{ request('filter') == $kategori->nama ? 'selected' : '' }}>{{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('filter') == 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="draft" {{ request('filter') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ request('filter') == 'archived' ? 'selected' : '' }}>Archived
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary w-100" onclick="applyFilters()">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="articles-grid">
                @forelse ($artikels as $artikel)
                    <div class="article-card">
                        <div class="article-image">
                            <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://via.placeholder.com/400x200' }}"
                                alt="{{ $artikel->judul }}" title="Path: {{ $artikel->gambar ?? 'Tidak ada' }}"
                                onerror="this.src='https://via.placeholder.com/400x200'; console.log('Gagal memuat gambar: ' + this.src + ', Path DB: ' + '{{ $artikel->gambar ?? 'null' }}');">
                            <div class="article-overlay">
                                <div class="article-actions">
                                    <a href="{{ route('artikel.show', $artikel->id) }}"
                                        class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn-action-card btn-edit-card"
                                        data-bs-toggle="modal" data-bs-target="#modalEditArtikel"
                                        data-id="{{ $artikel->id }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('artikel.destroy', $artikel->id) }}" method="POST"
                                        style="display:inline;" id="deleteForm_{{ $artikel->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action-card btn-delete-card"
                                            data-id="{{ $artikel->id }}"
                                            onclick="confirmDelete({{ $artikel->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="article-status">
                                <span
                                    class="status-badge status-{{ $artikel->status == 'disetujui' && $artikel->diterbitkan_pada ? 'published' : ($artikel->status == 'draf' ? 'draft' : 'archived') }}">
                                    {{ ucfirst($artikel->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="article-content">
                            <div class="article-category">
                                <span
                                    class="category-tag">{{ $artikel->kategori->nama ?? 'Tanpa Kategori' }}</span>
                            </div>
                            <h5 class="article-title-card">{{ $artikel->judul }}</h5>
                            <p class="article-excerpt-card">{{ Str::limit($artikel->isi, 100) }}</p>

                            <div class="article-author-card">
                                <div class="author-avatar">{{ substr($artikel->siswa->nama ?? 'Unknown', 0, 2) }}
                                </div>
                                <div class="author-info">
                                    <div class="author-name">{{ $artikel->siswa->nama ?? 'Unknown' }}</div>
                                    <div class="author-role">{{ $artikel->siswa->role ?? 'Siswa' }}</div>
                                </div>
                            </div>

                            <div class="article-meta-card">
                                <div class="meta-stats">
                                    <span><i class="fas fa-eye"></i> {{ $artikel->jumlah_dilihat }}</span>
                                    <span><i class="fas fa-heart"></i> {{ $artikel->jumlah_suka }}</span>
                                    <span><i class="fas fa-comment"></i>
                                        {{ $artikel->komentarArtikel->count() }}</span>
                                    <div class="article-date">
                                        <small>Dibuat:
                                            {{ $artikel->dibuat_pada instanceof \Carbon\Carbon ? $artikel->dibuat_pada->format('d M Y') : (is_string($artikel->dibuat_pada) ? \Carbon\Carbon::parse($artikel->dibuat_pada)->format('d M Y') : '') }}</small>
                                        @if ($artikel->deleted_at)
                                            <small>Dihapus:
                                                {{ $artikel->deleted_at instanceof \Carbon\Carbon ? $artikel->deleted_at->format('d M Y') : (is_string($artikel->deleted_at) ? \Carbon\Carbon::parse($artikel->deleted_at)->format('d M Y') : '') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Tidak ada artikel yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pagination-custom mt-5 pt-4">
                {{ $artikels->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Edit Artikel -->
    <div class="modal fade" id="modalEditArtikel" tabindex="-1" aria-labelledby="modalEditArtikelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data" id="editForm">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditArtikelLabel">Edit Artikel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId">
                        <div class="mb-3">
                            <label for="edit_judul" class="form-label">Judul Artikel</label>
                            <input type="text" name="judul" id="edit_judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_isi" class="form-label">Isi Artikel</label>
                            <textarea name="isi" id="edit_isi" class="form-control" rows="6" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_gambar" class="form-label">Gambar (opsional)</label>
                            <input type="file" name="gambar" id="edit_gambar" class="form-control">
                            <img id="edit_gambar_preview" src="" alt="Gambar Preview"
                                style="max-width: 200px; display: none;" class="mt-2">
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_kategori" class="form-label">Kategori</label>
                            <select name="id_kategori" id="edit_id_kategori" class="form-select">
                                <option value="">Pilih Kategori</option>
                                @foreach (\App\Models\Kategori::all() as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_siswa" class="form-label">Siswa</label>
                            <select name="id_siswa" id="edit_id_siswa" class="form-select" required>
                                <option value="">Pilih Siswa</option>
                                @foreach (\App\Models\Siswa::all() as $siswa)
                                    <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_jenis" class="form-label">Jenis</label>
                            <select name="jenis" id="edit_jenis" class="form-select" required>
                                <option value="bebas">Bebas</option>
                                <option value="resensi_buku">Resensi Buku</option>
                                <option value="resensi_film">Resensi Film</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-select" required>
                                <option value="menunggu">Menunggu</option>
                                <option value="draf">Draf</option>
                                <option value="disetujui">Disetujui</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script>
            // Auto-hide alerts
            document.addEventListener('DOMContentLoaded', function() {
                var successAlert = document.getElementById('successAlert');
                var errorAlert = document.getElementById('errorAlert');
                if (successAlert) setTimeout(() => successAlert.style.display = 'none', 5000);
                if (errorAlert) setTimeout(() => errorAlert.style.display = 'none', 5000);
            });

            // Apply Filters
            function applyFilters() {
                var search = document.getElementById('searchInput').value;
                var category = document.getElementById('filterCategory').value;
                var status = document.getElementById('filterStatus').value;
                var filter = category || status;
                var url = "{{ route('artikel') }}";
                var params = [];
                if (search) params.push('search=' + encodeURIComponent(search));
                if (filter) params.push('filter=' + encodeURIComponent(filter));
                if (params.length > 0) url += '?' + params.join('&');
                window.location.href = url;
            }

            // Load Edit Modal
            $('.btn-edit-card').on('click', function() {
                var id = $(this).data('id');
                $.get(`/artikel/${id}/edit`, function(data) {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    $('#editId').val(data.id);
                    $('#edit_judul').val(data.judul);
                    $('#edit_isi').val(data.isi);
                    $('#edit_id_kategori').val(data.id_kategori);
                    $('#edit_id_siswa').val(data.id_siswa);
                    $('#edit_jenis').val(data.jenis);
                    $('#edit_status').val(data.status);
                    if (data.gambar) {
                        $('#edit_gambar_preview').attr('src', '{{ asset('storage/') }}/' + data.gambar).show();
                    } else {
                        $('#edit_gambar_preview').hide();
                    }
                    $('#editForm').attr('action', `/artikel/${id}`);
                    $('#modalEditArtikel').modal('show');
                }).fail(function(xhr, status, error) {
                    alert('Gagal memuat data edit: ' + error);
                    console.log(xhr.responseText);
                });
            });

            // Confirm Delete
            function confirmDelete(id) {
                if (confirm('Yakin ingin menghapus artikel ini?')) {
                    $('#deleteForm_' + id).submit();
                }
            }

            // Handle Enter key for search
            $('#searchInput').on('keypress', function(e) {
                if (e.key === 'Enter') applyFilters();
            });
        </script>
    @endsection
@endsection