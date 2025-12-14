@extends('layouts.admin')

@section('title', 'Persetujuan Video - SMKN 11 Bandung')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/video-persetujuan.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="path/to/bootstrap-datepicker.css"> --}}
@endsection

@section('content')
    <div class="page-header">
        <h1 class="page-title">Persetujuan Video</h1>
        <p class="page-subtitle">Kelola dan atur semua video yang menunggu, disetujui, dan ditolak</p>

        <div class="action-buttons d-flex flex-wrap gap-3">
            <div class="card shadow-sm">
                <div class="card-body p-2">
                    {{-- Tombol untuk menampilkan SEMUA --}}
                    <a href="{{ route('admin.video.persetujuan', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}"
                        class="btn w-100 {{ request('status') === 'all' || !request('status') ? 'btn-primary-custom' : 'btn-outline-secondary' }}">
                        <i class="fas fa-list-ul me-2"></i>Semua Status
                    </a>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body p-2">
                    {{-- Tombol untuk Status MENUNGGU --}}
                    <a href="{{ route('admin.video.persetujuan', array_merge(request()->except(['status', 'page']), ['status' => 'menunggu'])) }}"
                        class="btn w-100 {{ request('status') === 'menunggu' ? 'btn-primary-custom' : 'btn-outline-warning' }}">
                        <i class="fas fa-clock me-2"></i>Status Menunggu
                    </a>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body p-2">
                    {{-- Tombol untuk Status DISETUJUI --}}
                    <a href="{{ route('admin.video.persetujuan', array_merge(request()->except(['status', 'page']), ['status' => 'disetujui'])) }}"
                        class="btn w-100 {{ request('status') === 'disetujui' ? 'btn-primary-custom' : 'btn-outline-success' }}">
                        <i class="fas fa-check-circle me-2"></i>Status Disetujui
                    </a>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body p-2">
                    {{-- Tombol untuk Status DITOLAK --}}
                    <a href="{{ route('admin.video.persetujuan', array_merge(request()->except(['status', 'page']), ['status' => 'ditolak'])) }}"
                        class="btn w-100 {{ request('status') === 'ditolak' ? 'btn-primary-custom' : 'btn-outline-danger' }}">
                        <i class="fas fa-times-circle me-2"></i>Status Ditolak
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-video me-2"></i>Daftar Video
                @if (request('status') && request('status') !== 'all')
                    Status: <span class="text-uppercase">{{ request('status') }}</span>
                @else
                    Semua Status
                @endif
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: {{ $videos->total() }} video</span>
            </div>
        </div>
        <div class="card-body-custom">
            <div class="search-filter-section">
                <form id="filterForm" method="GET" action="{{ route('admin.video.persetujuan') }}">
                    {{-- Hidden input for status to maintain filter state --}}
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" id="searchInput" class="form-control border-start-0"
                                    placeholder="Cari judul video..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-list-alt text-muted"></i>
                                </span>
                                <select name="kategori" id="filterCategory" class="form-select border-start-0"
                                    style="width: 100%;">
                                    <option value="">Pilih Kategori</option>
                                    @if ($selectedKategori)
                                        <option value="{{ $selectedKategori->id }}" selected>{{ $selectedKategori->nama }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <select name="siswa" id="filterSiswa" class="form-select border-start-0"
                                    style="width: 100%;">
                                    <option value="">Pilih Siswa</option>
                                    @if ($selectedSiswa)
                                        <option value="{{ $selectedSiswa->id }}" selected>{{ $selectedSiswa->nama }}
                                            ({{ $selectedSiswa->nis }})</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        {{-- FILTER BULAN & TAHUN BARU --}}
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-calendar text-muted"></i>
                                </span>
                                <input type="month" name="bulan_tahun" id="filterBulanTahun"
                                    class="form-control border-start-0" value="{{ request('bulan_tahun') }}"
                                    title="Filter Bulan & Tahun Unggah">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.video.persetujuan') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-redo me-1"></i>Reset Filter
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="articles-grid" id="videosGrid">
                @forelse($videos as $video)
                    <div class="article-card fade-in">
                        <div class="article-image">
                            <img src="{{ asset('storage/' . $video->thumbnail_path) }}"
                                alt="Thumbnail {{ $video->judul }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}';">
                            <div class="article-overlay">
                                <div class="article-actions">
                                    <a href="{{ asset('storage/' . $video->video_path) }}" target="_blank"
                                        class="btn-action-card btn-view-card" title="Lihat Video">
                                        <i class="fas fa-play"></i>
                                    </a>

                                    {{-- Tombol Edit Detail --}}
                                    <button type="button" class="btn-action-card btn-edit-card" data-bs-toggle="modal"
                                        data-bs-target="#editDetailModal{{ $video->id }}" title="Edit Detail Video">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    {{-- Tombol Ubah Status --}}
                                    <button type="button" class="btn-action-card btn-status-card" data-bs-toggle="modal"
                                        data-bs-target="#persetujuanModal{{ $video->id }}" title="Ubah Status">
                                        <i class="fas fa-check-circle"></i>
                                    </button>

                                    <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST"
                                        style="display:inline;" id="deleteForm_{{ $video->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action-card btn-delete-card"
                                            data-id="{{ $video->id }}" onclick="confirmDelete({{ $video->id }})"
                                            title="Hapus Video">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="article-status">
                                <span
                                    class="status-badge status-{{ $video->status }}">{{ ucfirst($video->status) }}</span>
                            </div>
                        </div>
                        <div class="article-content">
                            <div class="article-category">
                                <span class="category-tag">{{ $video->kategori->nama ?? 'Tanpa Kategori' }}</span>
                            </div>
                            <h5 class="article-title-card">{{ Str::limit($video->judul, 50) }}</h5>
                            <p class="article-excerpt-card">{{ Str::limit($video->deskripsi, 100) }}</p>
                            <div class="article-author-card">
                                <div class="author-avatar">{{ Str::upper(substr($video->siswa->nama ?? 'Anonim', 0, 1)) }}
                                </div>
                                <div class="author-info">
                                    <div class="author-name">{{ $video->siswa->nama ?? 'Anonim' }}</div>
                                    <div class="author-role">{{ $video->siswa->nis ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="article-meta-card">
                                <div class="meta-stats">
                                    <span><i class="fas fa-eye"></i> {{ $video->jumlah_dilihat ?? 0 }}</span>
                                    <span><i class="fas fa-heart"></i>
                                        {{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
                                </div>
                                <div class="article-date">{{ $video->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL UBAH STATUS (Sama seperti sebelumnya, fokus hanya pada status dan alasan) --}}
                    <div class="modal fade" id="persetujuanModal{{ $video->id }}" tabindex="-1"
                        aria-labelledby="persetujuanModalLabel{{ $video->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="persetujuanModalLabel{{ $video->id }}">Ubah Status
                                        Video: {{ Str::limit($video->judul, 30) }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.video.update', $video->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="update_type" value="status_only">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="status{{ $video->id }}" class="form-label">Status</label>
                                            <select name="status" id="status{{ $video->id }}" class="form-select"
                                                onchange="toggleAlasan(this.value, 'alasanContainer{{ $video->id }}')">
                                                <option value="menunggu"
                                                    {{ $video->status === 'menunggu' ? 'selected' : '' }}>
                                                    Menunggu</option>
                                                <option value="disetujui"
                                                    {{ $video->status === 'disetujui' ? 'selected' : '' }}>
                                                    Disetujui</option>
                                                <option value="ditolak"
                                                    {{ $video->status === 'ditolak' ? 'selected' : '' }}>
                                                    Ditolak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="alasanContainer{{ $video->id }}"
                                            style="display: {{ $video->status === 'ditolak' ? 'block' : 'none' }};">
                                            <label for="alasan_penolakan{{ $video->id }}" class="form-label">Alasan
                                                Penolakan (akan dikirim sebagai notifikasi)</label>
                                            <textarea name="alasan_penolakan" id="alasan_penolakan{{ $video->id }}" class="form-control" rows="4">{{ $video->alasan_penolakan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-custom"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary-custom">Simpan Status</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL EDIT DETAIL (BARU) --}}
                    <div class="modal fade" id="editDetailModal{{ $video->id }}" tabindex="-1"
                        aria-labelledby="editDetailModalLabel{{ $video->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="editDetailModalLabel{{ $video->id }}">Edit Detail
                                        Video: {{ Str::limit($video->judul, 30) }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.video.update', $video->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="update_type" value="detail_only">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="judul{{ $video->id }}" class="form-label">Judul Video</label>
                                            <input type="text" name="judul" id="judul{{ $video->id }}"
                                                class="form-control" value="{{ $video->judul }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi{{ $video->id }}" class="form-label">Deskripsi
                                                Video</label>
                                            <textarea name="deskripsi" id="deskripsi{{ $video->id }}" class="form-control" rows="3" required>{{ $video->deskripsi }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kategori_edit{{ $video->id }}"
                                                    class="form-label">Kategori</label>
                                                {{-- Input Select2 untuk Kategori di dalam Modal --}}
                                                <select name="id_kategori" id="kategori_edit{{ $video->id }}"
                                                    class="form-select kategori-edit-select2"
                                                    data-placeholder="Pilih Kategori" required style="width: 100%;">
                                                    @if ($video->kategori)
                                                        <option value="{{ $video->kategori->id }}" selected>
                                                            {{ $video->kategori->nama }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="siswa_edit{{ $video->id }}" class="form-label">Pengunggah
                                                    (Siswa)
                                                </label>
                                                {{-- Input Select2 untuk Siswa di dalam Modal --}}
                                                <select name="id_siswa" id="siswa_edit{{ $video->id }}"
                                                    class="form-select siswa-edit-select2" data-placeholder="Pilih Siswa"
                                                    required style="width: 100%;">
                                                    @if ($video->siswa)
                                                        <option value="{{ $video->siswa->id }}" selected>
                                                            {{ $video->siswa->nama }} ({{ $video->siswa->nis }})</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary-custom">Simpan Detail</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <h5>Tidak ada video yang sesuai dengan kriteria filter.</h5>
                        <p class="text-muted">Coba ubah filter pencarian atau status.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-custom mt-5 pt-4">
                {{ $videos->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-warning-modal">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    Data yang dihapus <strong>tidak dapat dikembalikan!</strong>
                    <br><br>
                    Yakin ingin menghapus video ini?
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Jika menggunakan datepicker pihak ketiga --}}
    {{-- <script src="path/to/bootstrap-datepicker.js"></script> --}}

    <script>
        $(document).ready(function() {

            // ===================================================================
            // 1. SELECT2 INITIALIZATION
            // ===================================================================

            function initializeSelect2(selector, routeName, placeholderText, parentSelector = null) {
                $(selector).select2({
                    placeholder: placeholderText,
                    allowClear: true,
                    // PENTING: Gunakan dropdownParent untuk mengatasi masalah lebar dan tampilan dropdown di dalam modal/layout
                    dropdownParent: parentSelector ? $(parentSelector) : $(selector).parent(),
                    ajax: {
                        url: routeName,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function(data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1
                });
            }

            // Initialize Select2 for Filter Section
            initializeSelect2('#filterCategory', '{{ route('admin.search.kategori') }}', 'Pilih Kategori');
            initializeSelect2('#filterSiswa', '{{ route('admin.search.siswa') }}', 'Pilih Siswa');

            // Initialize Select2 for Edit Modals
            // Perlu inisialisasi setiap kali modal dibuka atau inisialisasi di luar
            // dengan menetapkan dropdownParent ke body atau modal itu sendiri
            $('.modal').on('shown.bs.modal', function() {
                // Inisialisasi Select2 untuk Kategori di dalam modal
                $(this).find('.kategori-edit-select2').each(function() {
                    const id = $(this).attr('id');
                    // Hancurkan Select2 yang sudah ada jika ada, lalu inisialisasi ulang
                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                    initializeSelect2('#' + id, '{{ route('admin.search.kategori') }}',
                        'Pilih Kategori',
                        '#' + $(this).closest('.modal').attr('id'));
                });

                // Inisialisasi Select2 untuk Siswa di dalam modal
                $(this).find('.siswa-edit-select2').each(function() {
                    const id = $(this).attr('id');
                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                    initializeSelect2('#' + id, '{{ route('admin.search.siswa') }}', 'Pilih Siswa',
                        '#' + $(
                            this).closest('.modal').attr('id'));
                });
            });


            // ===================================================================
            // 2. AJAX FILTER SUBMISSION
            // ===================================================================

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                const currentUrl = new URL(window.location.href);
                const newUrl = new URL(this.action);

                // Salin semua parameter form ke URL baru
                const params = new URLSearchParams(formData);

                // Pastikan untuk mempertahankan parameter status dari URL jika ada
                if (currentUrl.searchParams.has('status')) {
                    params.set('status', currentUrl.searchParams.get('status'));
                }

                newUrl.search = params.toString();

                // Perbarui URL browser tanpa reload
                history.pushState(null, '', newUrl.toString());

                $.ajax({
                    url: this.action,
                    method: 'GET',
                    data: formData,
                    beforeSend: function() {
                        $('#videosGrid').html(
                            '<div class="text-center py-5"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>'
                        );
                        $('.pagination-custom').empty(); // Kosongkan pagination
                    },
                    success: function(response) {
                        // Ganti seluruh konten main-card untuk mengambil update terbaru
                        const newGrid = $(response).find('#videosGrid').html();
                        const newPagination = $(response).find('.pagination-custom').html();
                        const newTotal = $(response).find('.card-header-custom .d-flex span')
                            .text();

                        $('#videosGrid').html(newGrid);
                        $('.pagination-custom').html(newPagination);
                        // Update total count
                        $('.card-header-custom .d-flex span').text(newTotal);

                        // Re-attach pagination event handlers if needed (Laravel's default pagination uses full page reload by default)
                        // Jika Anda ingin pagination juga AJAX, Anda perlu menambahkan logic untuk itu di sini.
                    },
                    error: function(xhr) {
                        showAlert('error', 'Gagal memuat video: ' + (xhr.responseJSON
                            ?.message || 'Terjadi kesalahan.'));
                        $('#videosGrid').html(
                            '<div class="text-center py-5 text-danger">Gagal memuat data. Silakan coba lagi.</div>'
                        );
                    }
                });
            });

            // ===================================================================
            // 3. DELETE CONFIRMATION (AJAX)
            // ===================================================================

            window.confirmDelete = function(id) {
                $('#deleteConfirmModal').modal('show');
                // URL diset dengan route('admin.video.destroy', [id])
                $('#deleteForm').attr('action', '{{ url('admin/video/persetujuan') }}/' + id);

                $('#confirmDeleteBtn').off('click').on('click', function(e) {
                    e.preventDefault();
                    const form = $('#deleteForm');

                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        beforeSend: function() {
                            $('#confirmDeleteBtn').html(
                                '<i class="fas fa-spinner fa-spin"></i> Menghapus...');
                        },
                        success: function(response) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('success', response.message ||
                                'Video berhasil dihapus.');
                            // Reload halaman setelah delete berhasil
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function(xhr) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('error', xhr.responseJSON?.message ||
                                'Gagal menghapus video.');
                        },
                        complete: function() {
                            $('#confirmDeleteBtn').html('Ya, Hapus');
                        }
                    });
                });
            };

            // ===================================================================
            // 4. UTILITIES & ALERTS
            // ===================================================================

            // Alert Function (Dibiarkan sama)
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

            // Handle session alerts (Dibiarkan sama)
            @if (session('success'))
                showAlert('success', '{{ session('success') }}');
            @endif
            @if (session('error'))
                showAlert('error', '{{ session('error') }}');
            @endif

            // Toggle Alasan Penolakan (Dibiarkan sama)
            window.toggleAlasan = function(status, alasanContainerId) {
                document.getElementById(alasanContainerId).style.display = status === 'ditolak' ? 'block' :
                    'none';
            }

        });
    </script>
@endsection
