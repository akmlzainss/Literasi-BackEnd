@extends('layouts.app')

@section('title', 'Kelola Artikel')
@section('page-title', 'Kelola Artikel Literasi Akhlak')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">

    <div class="page-header">
        <h1 class="page-title">Kelola Artikel</h1>
        <p class="page-subtitle">Kelola dan atur semua artikel literasi akhlak untuk sistem pembelajaran</p>

       <div class="action-buttons d-flex flex-wrap gap-3">
    <div class="card shadow-sm">
        <div class="card-body p-2">
            <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary-custom w-100">
                <i class="fas fa-plus me-2"></i>Tambah Artikel Baru
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-2">
            <a href="{{ route('admin.artikel.status', ['status' => 'menunggu']) }}" class="btn btn-warning-custom w-100">
                <i class="fas fa-clock me-2"></i>Status Menunggu
            </a>
        </div>
    </div>

    @if (isset($status) && $status)
        <div class="card shadow-sm">
            <div class="card-body p-2">
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary-custom w-100">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Semua Artikel
                </a>
            </div>
        </div>
    @endif
    </div>
</div>

        </div>
    </div>

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
            <div class="search-filter-section">
                <form id="filterForm" method="GET" action="{{ route('admin.artikel.index') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" id="searchInput" class="form-control border-start-0"
                                    placeholder="Cari artikel..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-list-alt text-muted"></i>
                                </span>
                                <select name="kategori" id="filterCategory" class="form-select border-start-0">
                                    <option value="">Pilih Kategori</option>
                                    @foreach (\App\Models\Kategori::all() as $kategori)
                                        <option value="{{ $kategori->nama }}"
                                            {{ request('kategori') == $kategori->nama ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-check-circle text-muted"></i>
                                </span>
                                <select name="status" id="filterStatus" class="form-select border-start-0">
                                    <option value="">Semua Status</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="draf" {{ request('status') == 'draf' ? 'selected' : '' }}>Draf
                                    </option>
                                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="articles-grid" id="articlesGrid">
                @forelse ($artikels as $artikel)
                    <div class="article-card">
                        <div class="article-image">
                            <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}"
                                alt="{{ $artikel->judul }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}';">
                            <div class="article-overlay">
                                <div class="article-actions">
                                    <a href="{{ route('admin.artikel.show', $artikel->id) }}"
                                        class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if (Auth::guard('admin')->check())
                                        <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                                            class="btn-action-card btn-edit-card">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST"
                                            style="display:inline;" id="deleteForm_{{ $artikel->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-action-card btn-delete-card"
                                                data-id="{{ $artikel->id }}" onclick="confirmDelete({{ $artikel->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="article-status">
                                <span class="status-badge status-{{ $artikel->status }}">
                                    {{ ucfirst($artikel->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="article-content">
                            <div class="article-category">
                                <span class="category-tag">{{ $artikel->kategori->nama ?? 'Tanpa Kategori' }}</span>
                            </div>
                            <h5 class="article-title-card">{{ $artikel->judul }}</h5>
                            <p class="article-excerpt-card">{{ Str::limit(strip_tags($artikel->isi), 100) }}</p>
                            <div class="article-rating">
                                <div class="rating-display">
                                    @php
                                        $rating = $artikel->ratingArtikel->avg('rating') ?? ($artikel->nilai_rata_rata ?? 0);
                                        $totalReviews = $artikel->ratingArtikel->count();
                                        $fullStars = floor($rating);
                                        $hasHalfStar = $rating - $fullStars >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                    @endphp
                                    <div class="stars">
                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <i class="fas fa-star star-filled text-warning"></i>
                                        @endfor
                                        @if ($hasHalfStar)
                                            <i class="fas fa-star-half-alt star-half text-warning"></i>
                                        @endif
                                        @for ($i = 0; $i < $emptyStars; $i++)
                                            <i class="far fa-star star-empty text-warning"></i>
                                        @endfor
                                    </div>
                                    <div class="rating-info">
                                        <span class="rating-value">{{ number_format($rating, 1) }}</span>
                                        <span class="rating-count">({{ $totalReviews }} ulasan)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="article-author-card">
                                <div class="author-avatar">
                                    {{ $artikel->siswa ? strtoupper(substr($artikel->siswa->nama, 0, 2)) : 'AD' }}
                                </div>
                                <div class="author-info">
                                    <div class="author-name">{{ $artikel->siswa->nama ?? 'Admin' }}</div>
                                    <div class="author-role">{{ $artikel->siswa->kelas ?? 'Administrator' }}</div>
                                </div>
                            </div>
                            <div class="article-meta-card">
                                <div class="meta-stats">
                                    <span><i class="fas fa-eye"></i> {{ $artikel->jumlah_dilihat }}</span>
                                    <span><i class="fas fa-heart"></i> {{ $artikel->jumlah_suka }}</span>
                                    <span><i class="fas fa-comment"></i> {{ $artikel->komentarArtikel->count() }}</span>
                                    <div class="article-date">
                                        <small>Dibuat: {{ $artikel->created_at?->format('d M Y') }}</small>
                                        @if ($artikel->deleted_at)
                                            <small>Dihapus: {{ $artikel->deleted_at?->format('d M Y') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p>Tidak ada artikel yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-custom mt-5 pt-4">
                {{ $artikels->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#filterCategory').select2({
                placeholder: 'Pilih Kategori',
                allowClear: true
            });
            $('#filterStatus').select2({
                placeholder: 'Semua Status',
                allowClear: true
            });

            // AJAX Filter
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('admin.artikel.index') }}',
                    method: 'GET',
                    data: formData,
                    beforeSend: function() {
                        $('#articlesGrid').html('<div class="text-center py-5"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');
                    },
                    success: function(response) {
                        $('#articlesGrid').html($(response).find('#articlesGrid').html());
                        $('.pagination-custom').html($(response).find('.pagination-custom').html());
                    },
                    error: function(xhr) {
                        showAlert('error', 'Gagal memuat artikel: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan.'));
                    }
                });
            });

            // Delete Confirmation
            window.confirmDelete = function(id) {
                $('#deleteConfirmModal').modal('show');
                $('#confirmDeleteBtn').off('click').on('click', function() {
                    const form = $('#deleteForm_' + id);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        beforeSend: function() {
                            $('#confirmDeleteBtn').html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');
                        },
                        success: function(response) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('success', response.message);
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('error', xhr.responseJSON?.message || 'Gagal menghapus artikel.');
                        },
                        complete: function() {
                            $('#confirmDeleteBtn').html('Hapus');
                        }
                    });
                });
            };

            // Alert Function
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show custom-alert" role="alert">
                        <i class="fas ${iconClass} me-2"></i>${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.custom-alert').remove();
                $('body').append(alertHtml);
                setTimeout(() => $('.custom-alert').fadeOut(() => $('.custom-alert').remove()), 5000);
            }

            // Handle session alerts
            @if (session('success'))
                showAlert('success', '{{ session('success') }}');
            @endif
            @if (session('error'))
                showAlert('error', '{{ session('error') }}');
            @endif
        });
    </script>
@endsection