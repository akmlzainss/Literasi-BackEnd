@extends('layouts.app')

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
                    Bulan aktif: <strong>{{ \Carbon\Carbon::parse($currentMonth)->translatedFormat('F Y') }}</strong>
                </p>
            </div>
            <div class="action-buttons d-flex gap-2">
                <a href="{{ route('admin.penghargaan.create', ['month' => $currentMonth]) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Manual</span>
                </a>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#resetConfirmModal">
                    <i class="fas fa-refresh"></i>
                    <span>Reset Bulanan</span>
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resetConfirmModal" tabindex="-1" aria-labelledby="resetConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-warning-modal">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="resetConfirmModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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

    @include('penghargaan.modal-edit')
    @include('penghargaan.modal-confirm-pilih')

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
                <span>Total: <strong>{{ $totalPenghargaan ?? 0 }}</strong> penghargaan</span>
            </div>
        </div>

        <div class="card-body-custom">
            <div class="tab-content" id="penghargaanTabContent">
                <div class="tab-pane fade {{ $activeTab == 'artikel' ? 'show active' : '' }}" id="artikel" role="tabpanel"
                     aria-labelledby="artikel-tab">
                    <div class="filter-section">
                        <form method="GET" action="{{ route('admin.penghargaan.index') }}" id="filterFormArtikel">
                            <input type="hidden" name="active_tab" value="artikel">
                            <div class="filter-grid">
                                <div class="filter-item">
                                    <label class="filter-label">
                                        <i class="fas fa-calendar me-2"></i>Tahun
                                    </label>
                                    <select name="year" class="form-select filter-select" id="yearFilterArtikel" onchange="this.form.submit()">
                                        @for ($y = $maxYear; $y >= $minYear; $y--)
                                            <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="filter-item">
                                    <label class="filter-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Bulan
                                    </label>
                                    <select name="month_number" class="form-select filter-select" id="monthFilterArtikel" onchange="this.form.submit()">
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $currentMonthNumber == $m ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Debug: Tampilkan jumlah data -->
                    <div class="alert alert-info mb-3">Debug: Jumlah Artikel = {{ $artikel->count() }}, Top Artikel = {{ $topArtikel->count() }}</div>

                    @if ($topArtikel->count() > 0)
                        <div class="top-candidates-section">
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
                                            <h6 class="candidate-title">{{ Str::limit($item->judul ?? 'Tanpa Judul', 40) }}</h6>
                                            <div class="candidate-rating">
                                                <div class="rating-stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="star {{ $i <= round($item->avg_rating ?? 0) ? 'filled' : 'empty' }}">
                                                            <i class="fas fa-star"></i>
                                                        </span>
                                                    @endfor
                                                </div>
                                                <span class="rating-value">{{ number_format($item->avg_rating ?? 0, 1) }}/5</span>
                                            </div>
                                            <div class="candidate-author">
                                                <i class="fas fa-user-circle me-2"></i>
                                                <span>{{ $item->siswa->nama ?? 'Unknown' }}</span>
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
                        <div class="alert alert-warning">Tidak ada artikel untuk bulan ini.</div>
                    @endif

                    <div class="datatable-section">
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
                                                    {{ $item->siswa->nama ?? 'Unknown' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="rating-display">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="star-sm {{ $i <= round($item->avg_rating ?? 0) ? 'filled' : 'empty' }}">
                                                            <i class="fas fa-star"></i>
                                                        </span>
                                                    @endfor
                                                    <span class="rating-num">{{ number_format($item->avg_rating ?? 0, 1) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="item-date">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    {{ \Carbon\Carbon::parse($item->diterbitkan_pada ?? $item->created_at ?? now())->translatedFormat('d F Y') }}
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
                    <div class="filter-section">
                        <form method="GET" action="{{ route('admin.penghargaan.index') }}" id="filterFormVideo">
                            <input type="hidden" name="active_tab" value="video">
                            <div class="filter-grid">
                                <div class="filter-item">
                                    <label class="filter-label">
                                        <i class="fas fa-calendar me-2"></i>Tahun
                                    </label>
                                    <select name="year" class="form-select filter-select" id="yearFilterVideo" onchange="this.form.submit()">
                                        @for ($y = $maxYear; $y >= $minYear; $y--)
                                            <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="filter-item">
                                    <label class="filter-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Bulan
                                    </label>
                                    <select name="month_number" class="form-select filter-select" id="monthFilterVideo" onchange="this.form.submit()">
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $currentMonthNumber == $m ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Debug: Tampilkan jumlah data -->
                    <div class="alert alert-info mb-3">Debug: Jumlah Video = {{ $video->count() }}, Top Video = {{ $topVideo->count() }}</div>

                    @if ($topVideo->count() > 0)
                        <div class="top-candidates-section">
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
                                            <h6 class="candidate-title">{{ Str::limit($item->judul ?? 'Tanpa Judul', 40) }}</h6>
                                            <div class="candidate-likes">
                                                <i class="fas fa-heart text-danger me-2"></i>
                                                <span class="likes-value">{{ $item->jumlah_like ?? 0 }} Like</span>
                                            </div>
                                            <div class="candidate-author">
                                                <i class="fas fa-user-circle me-2"></i>
                                                <span>{{ $item->siswa->nama ?? 'Unknown' }}</span>
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
                        <div class="alert alert-warning">Tidak ada video untuk bulan ini.</div>
                    @endif

                    <div class="datatable-section">
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
                                                    {{ $item->siswa->nama ?? 'Unknown' }}
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
                                                    {{ \Carbon\Carbon::parse($item->diterbitkan_pada ?? $item->created_at ?? now())->translatedFormat('d F Y') }}
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

    <div class="winners-section">
        <div class="section-header-winners">
            <div class="header-left">
                <i class="fas fa-trophy me-2"></i>
                <h5 class="mb-0">Pemenang Penghargaan Bulan Ini</h5>
            </div>
            <div class="header-right">
                <span class="badge-count">{{ $penghargaan->count() ?? 0 }} Pemenang</span>
            </div>
        </div>
        <div class="winners-content">
            @forelse ($penghargaan ?? [] as $item)
                @if (is_object($item) && isset($item->id) && isset($item->siswa))
                    <div class="winner-card fade-in">
                        <div class="winner-left">
                            <div class="winner-avatar"
                                 style="background: linear-gradient(135deg, {{ $item->jenis == 'bulanan' ? '#f59e0b, #d97706' : '#8b5cf6, #7c3aed' }});">
                                {{ Str::substr($item->siswa->nama ?? '-', 0, 1) }}
                            </div>
                            <div class="winner-info">
                                <div class="winner-name">
                                    {{ $item->siswa->nama ?? 'Siswa tidak ditemukan' }}
                                </div>
                                <div class="winner-badge">
                                    <i class="fas {{ $item->jenis == 'bulanan' ? 'fa-calendar-check' : 'fa-star' }} me-1"></i>
                                    {{ $item->jenis == 'bulanan' ? 'Pemenang Bulanan' : 'Penghargaan Spesial' }}
                                </div>
                                <div class="winner-description">
                                    @if ($item->artikel)
                                        <i class="fas fa-book me-2"></i>
                                        Artikel: {{ Str::limit($item->artikel->judul, 50) }}
                                    @elseif($item->video)
                                        <i class="fas fa-video me-2"></i>
                                        Video: {{ Str::limit($item->video->judul, 50) }}
                                    @else
                                        <i class="fas fa-info-circle me-2"></i>
                                        {{ $item->deskripsi_penghargaan ?? 'Tidak ada deskripsi' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="winner-actions">
                            <button class="btn-winner-action btn-edit btn-edit-card" data-id="{{ $item->id }}"
                                    data-bs-toggle="modal" data-bs-target="#editPenghargaanModal" title="Edit penghargaan">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.penghargaan.destroy', $item->id) }}" method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus penghargaan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-winner-action btn-delete" title="Hapus penghargaan">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h5 class="empty-title">Belum Ada Pemenang</h5>
                    <p class="empty-text">Pilih pemenang dari daftar di atas untuk bulan ini!</p>
                </div>
            @endforelse
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
            const tableConfig = {
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    zeroRecords: 'Tidak ada data yang ditemukan',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Selanjutnya',
                        previous: 'Sebelumnya'
                    }
                },
                columnDefs: [
                    { orderable: false, targets: 4 },
                    { searchable: false, targets: [2, 4] }
                ],
                drawCallback: function() {
                    $(this).find('tbody tr').addClass('fade-in-row');
                }
            };

            $('#artikelTable').DataTable({
                ...tableConfig,
                order: [[2, 'desc']],
                language: {
                    ...tableConfig.language,
                    emptyTable: 'Tidak ada artikel untuk bulan yang dipilih.'
                }
            });

            $('#videoTable').DataTable({
                ...tableConfig,
                order: [[2, 'desc']],
                language: {
                    ...tableConfig.language,
                    emptyTable: 'Tidak ada video untuk bulan yang dipilih.'
                }
            });

            const updateYearFilter = (selectElement) => {
                const currentYear = new Date().getFullYear(); // 2025
                const minYear = currentYear - 5; // 2020
                const maxYear = currentYear + 1; // 2026
                selectElement.innerHTML = '';

                for (let y = maxYear; y >= minYear; y--) {
                    const option = document.createElement('option');
                    option.value = y;
                    option.textContent = y;
                    if (y === currentYear) option.selected = true;
                    selectElement.appendChild(option);
                }
            };

            const yearFilters = [
                document.getElementById('yearFilterArtikel'),
                document.getElementById('yearFilterVideo')
            ];

            yearFilters.forEach(filter => {
                if (filter) {
                    updateYearFilter(filter);
                    setInterval(() => updateYearFilter(filter), 60000);
                }
            });

            const setupFilter = (type) => {
                const yearSelect = document.getElementById(`yearFilter${type}`);
                const monthSelect = document.getElementById(`monthFilter${type}`);
                const currentMonthValue = '{{ $currentMonth }}';
                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                    'September', 'Oktober', 'November', 'Desember'];

                const updateMonths = (shouldSubmit) => {
                    const selectedYear = yearSelect.value;
                    monthSelect.innerHTML = '';

                    monthNames.forEach((name, index) => {
                        const monthNumber = String(index + 1).padStart(2, '0');
                        const monthValue = `${selectedYear}-${monthNumber}`;
                        const option = document.createElement('option');
                        option.value = monthNumber;
                        option.textContent = name;

                        if (monthValue === currentMonthValue) {
                            option.selected = true;
                        }

                        monthSelect.appendChild(option);
                    });

                    if (shouldSubmit) {
                        yearSelect.form.submit();
                    }
                };

                yearSelect.addEventListener('change', () => updateMonths(true));
                updateMonths(false);
            };

            setupFilter('Artikel');
            setupFilter('Video');

            document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('pilih-cepat') || e.target.closest('.pilih-cepat')) {
                    const btn = e.target.closest('.pilih-cepat');
                    const id = btn.dataset.id;
                    const type = btn.dataset.type;
                    document.getElementById('confirmId').value = id;
                    document.getElementById('confirmType').value = type;
                    document.getElementById('confirmModalLabel').textContent =
                        `Konfirmasi Pemenang ${type === 'artikel' ? 'Artikel' : 'Video'}`;
                    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
                    modal.show();
                }
            });

            const confirmForm = document.getElementById('confirmForm');
            if (confirmForm) {
                confirmForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const id = document.getElementById('confirmId').value;
                    const type = document.getElementById('confirmType').value;
                    const activeTabPane = document.querySelector('.tab-pane.active');
                    const monthSelect = activeTabPane.querySelector('select[name="month_number"]');
                    const month = monthSelect ? monthSelect.value : '{{ $currentMonthNumber }}';
                    const year = activeTabPane.querySelector('select[name="year"]').value;
                    window.location.href =
                        `/admin/penghargaan/create?type=${type}&${type}_id=${id}&month=${year}-${month.padStart(2, '0')}`;
                });
            }

            document.querySelectorAll('.btn-edit-card').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    fetch(`/admin/penghargaan/${id}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            const form = document.getElementById('editPenghargaanForm');
                            form.action = `/admin/penghargaan/${id}`;

                            document.getElementById('edit_id').value = data.penghargaan.id;
                            document.getElementById('edit_type').value = data.type;
                            document.getElementById('edit_id_siswa').value = data.penghargaan.id_siswa;
                            document.getElementById('edit_nama_siswa').value = data.penghargaan.siswa?.nama || 'Siswa tidak ditemukan';
                            document.getElementById('edit_jenis').value = data.penghargaan.jenis;
                            document.getElementById('edit_bulan_tahun').value = data.penghargaan.bulan_tahun;
                            document.getElementById('edit_deskripsi_penghargaan').value = data.penghargaan.deskripsi_penghargaan;

                            const itemSelect = document.getElementById('edit_id_item');
                            const itemLabel = document.getElementById('editItemLabel');
                            itemLabel.textContent = `Pilih ${data.type.charAt(0).toUpperCase() + data.type.slice(1)}`;
                            itemSelect.innerHTML = '<option value="">-- Pilih --</option>';

                            if (data.items?.length) {
                                data.items.forEach(item => {
                                    const ratingText = data.type === 'artikel' ?
                                        `Rating: ${parseFloat(item.rating || 0).toFixed(1)}` :
                                        `Like: ${item.rating || 0}`;
                                    itemSelect.innerHTML += `<option value="${item.id}">${item.judul} (${ratingText})</option>`;
                                });
                            }

                            const selectedItemId = data.penghargaan[data.type === 'artikel' ? 'id_artikel' : 'id_video'];
                            if (selectedItemId) {
                                itemSelect.value = selectedItemId;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat memuat data penghargaan.');
                        });
                });
            });

            const alertNotification = document.querySelector('.alert-notification');
            if (alertNotification) {
                setTimeout(() => {
                    alertNotification.classList.add('fade-out');
                    setTimeout(() => alertNotification.remove(), 300);
                }, 5000);
            }
        });
    </script>
@endsection