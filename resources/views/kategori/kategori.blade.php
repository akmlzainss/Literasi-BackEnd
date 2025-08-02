@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori Artikel')

@section('content')
    <link rel="stylesheet" href="css/kategori.css">
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

    <!-- Custom Notification Modal -->
    <div class="modal fade" id="customNotificationModal" tabindex="-1" aria-labelledby="customNotificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customNotificationModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p id="notificationMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmAction">Ya</button>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Include Modal Tambah -->
    @include('kategori.tambah-modal')

    <!-- Include Modal Edit -->
    @include('kategori.edit-modal')

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
                            <input type="text" id="searchInput" class="form-control search-input border-start-0"
                                placeholder="Cari kategori..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select id="filterSelect" class="form-select">
                            <option value="">-- Pilih Filter --</option>
                            <option value="with_articles" {{ request('filter') === 'with_articles' ? 'selected' : '' }}>
                                Kategori dengan Artikel</option>
                            <option value="no_articles" {{ request('filter') === 'no_articles' ? 'selected' : '' }}>Kategori
                                tanpa Artikel</option>
                            <option value="az" {{ request('filter') === 'az' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="za" {{ request('filter') === 'za' ? 'selected' : '' }}>Nama Z-A</option>
                            <option value="newest" {{ request('filter') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('filter') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                        </select>
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
                                    <div class="category-header"
                                        style="background: linear-gradient(135deg, #2563eb, #60a5fa);">
                                        <h5 class="category-title">{{ $kategori->nama }}</h5>
                                    </div>
                                    <div class="category-content">
                                        <p class="category-description">{{ $kategori->deskripsi }}</p>
                                        <div class="category-meta">
                                            <span><i class="fas fa-newspaper"></i> {{ $kategori->artikel->count() }}
                                                Artikel</span>
                                            <span><i class="fas fa-eye"></i> {{ $kategori->views ?? '0' }}</span>
                                        </div>
                                        <div class="category-actions">
                                            <a href="{{ route('kategori.detail', $kategori->id) }}"
                                                class="btn-action-card btn-detail-card" data-id="{{ $kategori->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn-action-card btn-edit-card" data-bs-toggle="modal"
                                                data-bs-target="#modalEditKategori" data-id="{{ $kategori->id }}"
                                                data-nama="{{ $kategori->nama }}"
                                                data-deskripsi="{{ $kategori->deskripsi }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                                style="display:inline;" id="deleteForm_{{ $kategori->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-action-card btn-delete-card"
                                                    data-id="{{ $kategori->id }}"
                                                    data-action="{{ route('kategori.destroy', $kategori->id) }}">
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

            <!-- Pagination with Spacing -->
            <div class="pagination-custom mt-5 pt-4">
                @if ($kategoris->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            @if ($kategoris->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $kategoris->previousPageUrl() }}"
                                        rel="prev">&laquo;</a>
                                </li>
                            @endif

                            @foreach ($kategoris->getUrlRange(1, $kategoris->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $kategoris->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            @if ($kategoris->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $kategoris->nextPageUrl() }}"
                                        rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Auto-hide success and error alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var successAlert = document.getElementById('successAlert');
            var errorAlert = document.getElementById('errorAlert');
            if (successAlert) {
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(successAlert);
                    bsAlert.close();
                }, 5000); // 5000 ms = 5 detik
            }
            if (errorAlert) {
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(errorAlert);
                    bsAlert.close();
                }, 5000); // 5000 ms = 5 detik
            }
        });

        // Ensure modals are properly handled
        var modalTambahKategori = document.getElementById('modalTambahKategori');
        modalTambahKategori.addEventListener('shown.bs.modal', function() {
            document.getElementById('nama_kategori').focus();
        });

        var modalEditKategori = document.getElementById('modalEditKategori');
        modalEditKategori.addEventListener('shown.bs.modal', function() {
            var id = $('#modalEditKategori').data('id');
            console.log('Loading edit data for ID:', id); // Debug
            if (id) {
                $.get('{{ route('kategori.edit', ['id' => ':id']) }}'.replace(':id', id))
                    .done(function(data) {
                        console.log('Response data:', data); // Debug
                        if (data && data.id) {
                            $('#editId').val(data.id);
                            $('#edit_nama_kategori').val(data.nama);
                            $('#edit_deskripsi').val(data.deskripsi);
                            $('#editForm').attr('action', '{{ route('kategori.update', ['id' => ':id']) }}'
                                .replace(':id', id));
                        } else {
                            $('#customNotificationModal').modal('show');
                            $('#notificationMessage').text('Data tidak ditemukan.');
                            $('#confirmAction').hide();
                        }
                    })
                    .fail(function(xhr, status, error) {
                        console.error('AJAX Error:', error, 'Status:', status, 'Response:', xhr
                        .responseText); // Debug
                        $('#customNotificationModal').modal('show');
                        $('#notificationMessage').text('Gagal memuat data untuk edit.');
                        $('#confirmAction').hide();
                    });
            }
        });

        // Search and Filter functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });

        document.getElementById('filterSelect').addEventListener('change', function() {
            applyFilters();
        });

        function applyFilters() {
            var search = document.getElementById('searchInput').value;
            var filter = document.getElementById('filterSelect').value;
            var url = "{{ route('kategori') }}";
            var params = [];
            if (search) params.push('search=' + encodeURIComponent(search));
            if (filter) params.push('filter=' + encodeURIComponent(filter));
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            window.location.href = url;
        }

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
            $('#modalEditKategori').modal('show');
        });

        // Handle delete button click with custom confirmation
        $('.btn-delete-card').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var action = $(this).data('action');
            $('#customNotificationModal').modal('show');
            $('#notificationMessage').text('Yakin ingin menghapus data ini?');
            $('#confirmAction').show().off('click').on('click', function() {
                $('#deleteForm_' + id).submit();
                $('#customNotificationModal').modal('hide');
            });
        });
    </script>
@endsection
