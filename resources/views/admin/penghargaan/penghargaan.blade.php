@extends('layouts.admin')

@section('title', 'Kelola Penghargaan')
@section('page-title', 'Kelola Penghargaan Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/penghargaan.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="page-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="page-title">
                    <i class="fas fa-trophy me-2"></i>Kelola Penghargaan Bulan Ini
                </h1>
                <p class="page-subtitle">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Pilih pemenang berdasarkan rating (artikel) atau like (video).
                    Bulan aktif: <strong
                        id="currentMonthDisplay">{{ \Carbon\Carbon::parse($currentMonth)->translatedFormat('F Y') }}</strong>
                </p>
            </div>
            <div class="action-buttons d-flex gap-2">
                {{-- ✅ FIXED #1: Tambah Manual SYNC bulan_tahun + active_tab --}}
                <a href="#" id="tambahManualBtnSync" data-bulan="{{ request('bulan_tahun', $currentMonth) }}"
                    data-tab="{{ $activeTab }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Manual
                </a>

                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#resetConfirmModal">
                    <i class="fas fa-refresh"></i>
                    <span>Reset Bulanan</span>
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resetConfirmModal" tabindex="-1" aria-labelledby="resetConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-warning-modal">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="resetConfirmModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    Semua penghargaan dari bulan lalu akan diarsipkan.
                    <br><br>
                    <strong>Tindakan ini tidak dapat dibatalkan!</strong>
                    <br><br>
                    Yakin ingin melanjutkan reset bulanan?
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.penghargaan.reset') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger" id="confirmResetBtn">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.penghargaan.modal-edit')
    @include('admin.penghargaan.modal-confirm-pilih')

    <div class="main-card">
        <div class="card-header-custom">
            <ul class="nav nav-tabs custom-tabs" id="penghargaanTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'artikel' ? 'active' : '' }}" id="artikel-tab"
                        data-bs-toggle="tab" data-bs-target="#artikel" type="button" role="tab">
                        <i class="fas fa-book me-2"></i>
                        <span>Artikel (Rating Tertinggi)</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'video' ? 'active' : '' }}" id="video-tab" data-bs-toggle="tab"
                        data-bs-target="#video" type="button" role="tab">
                        <i class="fas fa-video me-2"></i>
                        <span>Video (Like Terbanyak)</span>
                    </button>
                </li>
            </ul>
            <div class="header-info">
                <i class="fas fa-award me-2"></i>
                <span>Total: <strong id="totalPenghargaan">{{ $totalPenghargaan ?? 0 }}</strong> penghargaan</span>
            </div>
        </div>

        <div class="card-body-custom">
            {{-- FILTER BARU - IDENTIK DENGAN VIDEO PAGE --}}
            <div class="filter-section">
                <form id="filterForm" method="GET" action="{{ route('admin.penghargaan.index') }}">
                    <input type="hidden" name="active_tab" value="{{ $activeTab }}">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0"
                                    placeholder="Cari judul..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-calendar text-muted"></i>
                                </span>
                                <input type="month" name="bulan_tahun" id="filterBulanTahun"
                                    class="form-control border-start-0" value="{{ $currentMonth }}"
                                    title="Filter Bulan & Tahun">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary-custom w-100">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('admin.penghargaan.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-redo me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-content" id="penghargaanTabContent">
                <div class="tab-pane fade {{ $activeTab == 'artikel' ? 'show active' : '' }}" id="artikel"
                    role="tabpanel" aria-labelledby="artikel-tab">

                    @if ($topArtikel->count() > 0)
                        <div class="top-candidates-section" id="topArtikelSection">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-crown me-2"></i>
                                    Rekomendasi Pemenang (Top 3 Rating)
                                </h5>
                            </div>
                            <div class="candidates-grid">
                                @foreach ($topArtikel as $index => $item)
                                    <div class="candidate-card" data-rank="{{ $index + 1 }}">
                                        <div class="candidate-rank">
                                            <span class="rank-badge rank-{{ $index + 1 }}">
                                                #{{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div class="candidate-content">
                                            <h6 class="candidate-title">
                                                {{ Str::limit($item->judul ?? 'Tanpa Judul', 40) }}</h6>
                                            <div class="candidate-rating">
                                                <div class="rating-stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="star {{ $i <= round($item->avg_rating ?? 0) ? 'filled' : 'empty' }}">
                                                            <i class="fas fa-star"></i>
                                                        </span>
                                                    @endfor
                                                </div>
                                                <span
                                                    class="rating-value">{{ number_format($item->avg_rating ?? 0, 1) }}/5</span>
                                            </div>
                                            <div class="candidate-author">
                                                <i class="fas fa-user-circle me-2"></i>
                                                <span>{{ $item->nama ?? 'Unknown' }}</span>
                                            </div>
                                            <button class="btn-select-winner pilih-cepat" data-id="{{ $item->id }}"
                                                data-type="artikel">
                                                <i class="fas fa-award me-2"></i>
                                                <span>Pilih sebagai Pemenang</span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning" id="noArtikelAlert">Tidak ada artikel untuk bulan ini.</div>
                    @endif

                    <div class="datatable-section" id="artikelTableSection">
                        <div class="table-responsive">
                            <table id="artikelTable" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Rating</th>
                                        <th>Tanggal Post</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($artikel ?? [] as $item)
                                        <tr>
                                            <td>
                                                <div class="item-title">
                                                    <i class="fas fa-file-alt me-2 text-primary"></i>
                                                    {{ Str::limit($item->judul ?? 'Tanpa Judul', 50) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-author">
                                                    <i class="fas fa-user me-2"></i>
                                                    {{ $item->nama ?? 'Unknown' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="rating-display">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="star-sm {{ $i <= round($item->avg_rating ?? 0) ? 'filled' : 'empty' }}">
                                                            <i class="fas fa-star"></i>
                                                        </span>
                                                    @endfor
                                                    <span
                                                        class="rating-num">{{ number_format($item->avg_rating ?? 0, 1) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-date">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    {{ \Carbon\Carbon::parse($item->diterbitkan_pada ?? ($item->created_at ?? now()))->translatedFormat('d F Y') }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn-action-table pilih-cepat"
                                                    data-id="{{ $item->id }}" data-type="artikel"
                                                    title="Pilih sebagai pemenang">
                                                    <i class="fas fa-award"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade {{ $activeTab == 'video' ? 'show active' : '' }}" id="video"
                    role="tabpanel" aria-labelledby="video-tab">

                    @if ($topVideo->count() > 0)
                        <div class="top-candidates-section" id="topVideoSection">
                            <div class="section-header">
                                <h5 class="section-title">
                                    <i class="fas fa-crown me-2"></i>
                                    Rekomendasi Pemenang (Top 3 Like)
                                </h5>
                            </div>
                            <div class="candidates-grid">
                                @foreach ($topVideo as $index => $item)
                                    <div class="candidate-card" data-rank="{{ $index + 1 }}">
                                        <div class="candidate-rank">
                                            <span class="rank-badge rank-{{ $index + 1 }}">
                                                #{{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div class="candidate-content">
                                            <h6 class="candidate-title">
                                                {{ Str::limit($item->judul ?? 'Tanpa Judul', 40) }}</h6>
                                            <div class="candidate-likes">
                                                <i class="fas fa-heart text-danger me-2"></i>
                                                <span class="likes-value">{{ $item->jumlah_like ?? 0 }} Like</span>
                                            </div>
                                            <div class="candidate-author">
                                                <i class="fas fa-user-circle me-2"></i>
                                                <span>{{ $item->nama ?? 'Unknown' }}</span>
                                            </div>
                                            <button class="btn-select-winner pilih-cepat" data-id="{{ $item->id }}"
                                                data-type="video">
                                                <i class="fas fa-award me-2"></i>
                                                <span>Pilih sebagai Pemenang</span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning" id="noVideoAlert">Tidak ada video untuk bulan ini.</div>
                    @endif

                    <div class="datatable-section" id="videoTableSection">
                        <div class="table-responsive">
                            <table id="videoTable" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Like</th>
                                        <th>Tanggal Post</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($video ?? [] as $item)
                                        <tr>
                                            <td>
                                                <div class="item-title">
                                                    <i class="fas fa-video me-2 text-danger"></i>
                                                    {{ Str::limit($item->judul ?? 'Tanpa Judul', 50) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-author">
                                                    <i class="fas fa-user me-2"></i>
                                                    {{ $item->nama ?? 'Unknown' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="likes-display">
                                                    <i class="fas fa-heart text-danger me-2"></i>
                                                    <span class="likes-num">{{ $item->jumlah_like ?? 0 }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-date">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    {{ \Carbon\Carbon::parse($item->diterbitkan_pada ?? ($item->created_at ?? now()))->translatedFormat('d F Y') }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn-action-table pilih-cepat"
                                                    data-id="{{ $item->id }}" data-type="video"
                                                    title="Pilih sebagai pemenang">
                                                    <i class="fas fa-award"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ NEW: WINNERS SECTION WITH FILTER + CATEGORIES --}}
    <div class="winners-section">
        <div class="section-header-winners">
            <div class="header-left">
                <i class="fas fa-trophy me-2"></i>
                <h5 class="mb-0">Pemenang Penghargaan
                    {{ \Carbon\Carbon::parse($currentMonth)->translatedFormat('F Y') }}</h5>
            </div>
            <div class="header-right">
                <span class="badge-count">{{ $totalPenghargaan }} Pemenang</span>
            </div>
        </div>

        {{-- ✅ NEW: KATEGORI TABS --}}
        <ul class="nav nav-tabs winners-tabs mt-3" id="winnersTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="artikel-winners-tab" data-bs-toggle="tab"
                    data-bs-target="#artikel-winners" type="button" role="tab">
                    <i class="fas fa-book me-1"></i>
                    Artikel ({{ $penghargaan->where('type', 'artikel')->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="video-winners-tab" data-bs-toggle="tab" data-bs-target="#video-winners"
                    type="button" role="tab">
                    <i class="fas fa-video me-1"></i>
                    Video ({{ $penghargaan->where('type', 'video')->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content winners-tab-content mt-3">
            {{-- ✅ KATEGORI ARTIKEL --}}
            <div class="tab-pane fade show active" id="artikel-winners" role="tabpanel">
                <div class="winners-content">
                    @forelse($penghargaan->where('type', 'artikel') as $item)
                        <div class="winner-card fade-in artikel-winner">
                            <div class="winner-left">
                                <div class="winner-avatar" style="background: linear-gradient(135deg, #10b981, #059669);">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="winner-info">
                                    <div class="winner-name">{{ $item->siswa->nama ?? 'Siswa tidak ditemukan' }}</div>
                                    <div class="winner-badge">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        {{ $item->jenis == 'bulanan' ? 'Pemenang Bulanan' : 'Penghargaan Spesial' }}
                                    </div>
                                    <div class="winner-description">
                                        <i class="fas fa-book me-2 text-success"></i>
                                        {{ Str::limit($item->artikel->judul ?? 'Tanpa Judul', 50) }}
                                        @if ($item->artikel->avg_rating ?? false)
                                            <br><small class="text-muted">
                                                <i class="fas fa-star me-1"></i>
                                                Rating: {{ number_format($item->artikel->avg_rating, 1) }}/5
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="winner-actions">
                                <button class="btn-winner-action btn-edit btn-edit-card" data-id="{{ $item->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editPenghargaanModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.penghargaan.destroy', $item->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-winner-action btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-book"></i></div>
                            <h5>Belum Ada Pemenang Artikel</h5>
                            <p>Pilih pemenang artikel dari tab di atas!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ✅ KATEGORI VIDEO --}}
            <div class="tab-pane fade" id="video-winners" role="tabpanel">
                <div class="winners-content">
                    @forelse($penghargaan->where('type', 'video') as $item)
                        <div class="winner-card fade-in video-winner">
                            <div class="winner-left">
                                <div class="winner-avatar" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                    <i class="fas fa-video"></i>
                                </div>
                                <div class="winner-info">
                                    <div class="winner-name">{{ $item->siswa->nama ?? 'Siswa tidak ditemukan' }}</div>
                                    <div class="winner-badge">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        {{ $item->jenis == 'bulanan' ? 'Pemenang Bulanan' : 'Penghargaan Spesial' }}
                                    </div>
                                    <div class="winner-description">
                                        <i class="fas fa-video me-2 text-danger"></i>
                                        {{ Str::limit($item->video->judul ?? 'Tanpa Judul', 50) }}
                                        @if ($item->video->jumlah_like)
                                            <br><small class="text-muted">
                                                <i class="fas fa-heart me-1"></i>
                                                {{ $item->video->jumlah_like }} Like
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="winner-actions">
                                <button class="btn-winner-action btn-edit btn-edit-card" data-id="{{ $item->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editPenghargaanModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.penghargaan.destroy', $item->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-winner-action btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-video"></i></div>
                            <h5>Belum Ada Pemenang Video</h5>
                            <p>Pilih pemenang video dari tab di atas!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-notification alert-success">
            <div class="alert-content">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ========== 0. REAL-TIME MONTH ==========
            function setCurrentMonth() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                $('#filterBulanTahun').val(`${year}-${month}`);

                const monthNames = {
                    '01': 'Januari',
                    '02': 'Februari',
                    '03': 'Maret',
                    '04': 'April',
                    '05': 'Mei',
                    '06': 'Juni',
                    '07': 'Juli',
                    '08': 'Agustus',
                    '09': 'September',
                    '10': 'Oktober',
                    '11': 'November',
                    '12': 'Desember'
                };
                $('#currentMonthDisplay').text(`${monthNames[month]} ${year}`);
            }
            setCurrentMonth();

            // ========== 1. DATATABLES ==========
            function initDataTables() {
                if ($.fn.DataTable.isDataTable('#artikelTable')) $('#artikelTable').DataTable().destroy();
                if ($.fn.DataTable.isDataTable('#videoTable')) $('#videoTable').DataTable().destroy();

                $('#artikelTable').DataTable({
                    pageLength: 10,
                    order: [
                        [2, 'desc']
                    ],
                    language: {
                        search: 'Cari:',
                        emptyTable: 'Tidak ada artikel untuk bulan ini',
                        paginate: {
                            first: 'Pertama',
                            last: 'Terakhir',
                            next: 'Selanjutnya',
                            previous: 'Sebelumnya'
                        }
                    },
                    columnDefs: [{
                        orderable: false,
                        targets: 4
                    }, {
                        searchable: false,
                        targets: [2, 4]
                    }]
                });

                $('#videoTable').DataTable({
                    pageLength: 10,
                    order: [
                        [2, 'desc']
                    ],
                    language: {
                        search: 'Cari:',
                        emptyTable: 'Tidak ada video untuk bulan ini',
                        paginate: {
                            first: 'Pertama',
                            last: 'Terakhir',
                            next: 'Selanjutnya',
                            previous: 'Sebelumnya'
                        }
                    },
                    columnDefs: [{
                        orderable: false,
                        targets: 4
                    }, {
                        searchable: false,
                        targets: [2, 4]
                    }]
                });
            }
            initDataTables();

            // ========== 2. SIMPLE FILTER - KEDUA TAB! (TANPA NOTIFIKASI) ==========
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                // LOADING KEDUA TAB
                $('#artikel').html(
                    '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Memuat...</div>'
                    );
                $('#video').html(
                    '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Memuat...</div>'
                    );

                $.ajax({
                    url: this.action,
                    method: 'GET',
                    data: $(this).serialize(),
                    success: function(response) {
                        // **REPLACE KEDUA TAB**
                        $('#artikel').html($(response).find('#artikel').html());
                        $('#video').html($(response).find('#video').html());

                        // **RE-INIT DATATABLES**
                        initDataTables();

                        // **UPDATE WINNERS**
                        $('.winners-section').replaceWith($(response).find('.winners-section'));

                        // **UPDATE COUNTERS**
                        $('#totalPenghargaan').text($(response).find('#totalPenghargaan')
                        .text());

                        // **RE-ATTACH EVENTS**
                        attachEvents();

                        // **KEEP ACTIVE TAB**
                        const activeTab = $('.tab-pane.active').attr('id');
                        $(`#${activeTab}`).addClass('show active');

                        // ✅ **TIDAK ADA NOTIFIKASI - SILENT!**
                    },
                    error: function() {
                        Swal.fire('Error!', 'Gagal filter', 'error');
                        location.reload();
                    }
                });
            });

            // ========== 3. EVENTS ==========
            function attachEvents() {
                // Tambah Manual
                $(document).off('click', '#tambahManualBtnSync').on('click', '#tambahManualBtnSync', function(e) {
                    e.preventDefault();
                    const bulan = $(this).data('bulan');
                    const tab = $(this).data('tab');
                    window.location.href =
                        `/admin/penghargaan/create?bulan_tahun=${bulan}&active_tab=${tab}`;
                });

                // Tab Switch
                $('#penghargaanTab .nav-link').on('shown.bs.tab', function(e) {
                    const tab = $(e.target).data('bs-target').substring(1);
                    $('input[name="active_tab"]').val(tab);
                    $('#tambahManualBtnSync').attr('data-tab', tab);
                });

                // Pilih Cepat
                $(document).off('click', '.pilih-cepat').on('click', '.pilih-cepat', function() {
                    const id = $(this).data('id');
                    const type = $(this).data('type');
                    $('#confirmId').val(id);
                    $('#confirmType').val(type);
                    $('#confirmModalLabel').text(
                        `Konfirmasi Pemenang ${type === 'artikel' ? 'Artikel' : 'Video'}`);
                    new bootstrap.Modal(document.getElementById('confirmModal')).show();
                });

                // Confirm Form
                $(document).off('submit', '#confirmForm').on('submit', '#confirmForm', function(e) {
                    e.preventDefault();
                    const id = $('#confirmId').val();
                    const type = $('#confirmType').val();
                    const month = $('#filterBulanTahun').val();
                    const tab = $('input[name="active_tab"]').val();
                    window.location.href =
                        `/admin/penghargaan/create?bulan_tahun=${month}&active_tab=${tab}&${type}_id=${id}`;
                });

                // Edit Modal (LENGKAP DENGAN LOADING OVERLAY)
                $(document).off('click.btn-edit-card').on('click.btn-edit-card', '.btn-edit-card', function(e) {
                    e.stopImmediatePropagation();
                    const id = $(this).data('id');
                    const $modal = $('#editPenghargaanModal');
                    const $modalBody = $modal.find('.modal-body');

                    const loadingOverlay = `<div id="modal-loading-overlay" class="d-flex justify-content-center align-items-center position-absolute w-100 h-100" style="background: rgba(255, 255, 255, 0.8); z-index: 10;">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <p class="mb-0">Memuat data...</p>
                </div>
            </div>`;

                    $modalBody.css('position', 'relative').append(loadingOverlay);
                    $modal.modal('show');

                    $.get(`/admin/penghargaan/${id}/edit`)
                        .done(function(data) {
                            $('#modal-loading-overlay').remove();

                            $('#edit_id').val(data.penghargaan.id);
                            $('#edit_type').val(data.type);
                            $('#edit_id_siswa').val(data.penghargaan.id_siswa);
                            $('#edit_nama_siswa').val(data.penghargaan.siswa.nama);
                            $('#edit_bulan_tahun').val(data.penghargaan.bulan_tahun);
                            $('#edit_jenis').val(data.penghargaan.jenis);
                            $('#edit_deskripsi_penghargaan').val(data.penghargaan
                            .deskripsi_penghargaan);

                            const $select = $('#edit_id_item');
                            const $label = $('#editItemLabel');
                            $label.text(`Pilih ${data.type === 'artikel' ? 'Artikel' : 'Video'}`);
                            $select.html('<option value="">-- Pilih Konten --</option>');

                            data.items.forEach(item => {
                                const ratingValue = (data.type === 'artikel' ? item.rating
                                    .toFixed(1) : Math.round(item.rating));
                                const ratingText = data.type === 'artikel' ?
                                    `Rating: ${ratingValue}` : `Like: ${ratingValue}`;
                                $select.append(
                                    `<option value="${item.id}">${item.judul} (${ratingText})</option>`
                                    );
                            });

                            if (data.current_item_id) $select.val(data.current_item_id);
                            $('#editPenghargaanForm').attr('action',
                                `/admin/penghargaan/${data.penghargaan.id}`);
                        })
                        .fail(function(xhr) {
                            $('#modal-loading-overlay').remove();
                            $modal.find('.modal-body').prepend(`
                        <div class="alert alert-danger">
                            Gagal memuat data (${xhr.status}). <button class="btn btn-sm btn-primary mt-2" onclick="location.reload()">Refresh</button>
                        </div>
                    `);
                        });
                });

                // Edit Submit
                $(document).off('submit', '#editPenghargaanForm').on('submit', '#editPenghargaanForm', function(e) {
                    e.preventDefault();
                    const $form = $(this);
                    const $btn = $form.find('button[type="submit"]').prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin"></i> Saving...');

                    const formData = new FormData($form[0]);
                    formData.append('_method', 'PUT');

                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function() {
                            Swal.fire('Berhasil!', 'Penghargaan diperbarui!', 'success').then(
                            () => location.reload());
                        },
                        error: function() {
                            Swal.fire('Error!', 'Gagal menyimpan.', 'error');
                        },
                        complete: function() {
                            $btn.prop('disabled', false).html('Perbarui Penghargaan');
                        }
                    });
                });

                // Winners Tab
                $(document).off('shown.bs.tab', '.winners-tabs .nav-link').on('shown.bs.tab',
                    '.winners-tabs .nav-link',
                    function(e) {
                        const targetTab = $(e.target).data('bs-target');
                        $('.winners-tab-content .tab-pane').removeClass('show active');
                        $(targetTab).addClass('show active');
                    });
            }
            attachEvents();

            // Alert
            $('.alert-notification').fadeOut(5000);
        });
    </script>
@endsection
