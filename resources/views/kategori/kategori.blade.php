@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori Artikel')

@section('content')
    <link rel="stylesheet" href="css/kategori.css">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Kelola Kategori</h1>
        <p class="page-subtitle">Atur dan kelola semua kategori artikel literasi akhlak untuk sistem pembelajaran</p>
        
        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                <i class="fas fa-plus"></i>
                Tambah Kategori Baru
            </button>
            <a href="{{ route('kategori.export') }}" class="btn-outline-custom">
                <i class="fas fa-download"></i>
                Export Data
            </a>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama" id="nama_kategori" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Kategori (opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Kategori</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="editForm" action="" method="POST">
                    @method('PUT')
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKategoriLabel">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editId">
                        <div class="mb-3">
                            <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama" id="edit_nama_kategori" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi Kategori (opsional)</label>
                            <textarea name="deskripsi" id="edit_deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @endif
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

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-tags me-2"></i>Daftar Kategori
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: {{ $kategoris->total() }} kategori</span>
            </div>
        </div>
        
        <div class="card-body-custom">
            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control search-input border-start-0" placeholder="Cari kategori..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button id="filterButton" class="btn btn-outline-secondary w-100" style="border-radius: 12px;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="categories-grid">
                <div class="row g-4">
                    @if ($kategoris->isEmpty())
                        <div class="col-12 text-center">
                            <p>Tidak ada kategori yang ditemukan.</p>
                        </div>
                    @else
                        @foreach ($kategoris as $kategori)
                            <div class="col-lg-4 col-md-6">
                                <div class="category-card fade-in">
                                    <div class="category-header" style="background: linear-gradient(135deg, #2563eb, #60a5fa);">
                                        <h5 class="category-title">{{ $kategori->nama }}</h5>
                                    </div>
                                    <div class="category-content">
                                        <p class="category-description">{{ $kategori->deskripsi }}</p>
                                        <div class="category-meta">
                                            <span><i class="fas fa-newspaper"></i> {{ $kategori->artikel->count() }} Artikel</span>
                                            <span><i class="fas fa-eye"></i> {{ $kategori->views ?? '0' }}</span>
                                        </div>
                                        <div class="category-actions">
                                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn-action-card btn-view-card" data-bs-toggle="modal" data-bs-target="#modalEditKategori" data-id="{{ $kategori->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn-action-card btn-edit-card" data-bs-toggle="modal" data-bs-target="#modalEditKategori" data-id="{{ $kategori->id }}" data-nama="{{ $kategori->nama }}" data-deskripsi="{{ $kategori->deskripsi }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-card btn-delete-card" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-custom">
                {{ $kategoris->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Ensure modals are properly handled
        var modalTambahKategori = document.getElementById('modalTambahKategori');
        modalTambahKategori.addEventListener('shown.bs.modal', function () {
            document.getElementById('nama_kategori').focus();
        });

        var modalEditKategori = document.getElementById('modalEditKategori');
        modalEditKategori.addEventListener('shown.bs.modal', function () {
            var id = $('#modalEditKategori').data('id');
            if (id) {
                $.get('{{ route('kategori.edit', ['id' => ':id']) }}'.replace(':id', id), function(data) {
                    $('#editId').val(data.id);
                    $('#edit_nama_kategori').val(data.nama);
                    $('#edit_deskripsi').val(data.deskripsi);
                    $('#editForm').attr('action', '{{ route('kategori.update', ['id' => ':id']) }}'.replace(':id', id));
                }).fail(function() {
                    alert('Gagal memuat data untuk edit.');
                });
            }
        });

        // Search functionality
        document.getElementById('filterButton').addEventListener('click', function() {
            var search = document.getElementById('searchInput').value;
            window.location.href = "{{ route('kategori') }}?search=" + encodeURIComponent(search);
        });

        // Trigger filter on Enter key in search input
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('filterButton').click();
            }
        });

        // Handle edit button click to set modal data
        $('.btn-edit-card').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var deskripsi = $(this).data('deskripsi');
            $('#modalEditKategori').data('id', id);
            $('#editId').val(id);
            $('#edit_nama_kategori').val(nama);
            $('#edit_deskripsi').val(deskripsi);
            $('#editForm').attr('action', '{{ route('kategori.update', ['id' => ':id']) }}'.replace(':id', id));
        });
    </script>
@endsection