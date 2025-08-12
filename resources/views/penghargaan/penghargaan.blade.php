@extends('layouts.app')

@section('title', 'Kelola Penghargaan')
@section('page-title', 'Kelola Penghargaan Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/penghargaan.css') }}">

    <div class="page-header">
        <h1 class="page-title">Kelola Penghargaan</h1>
        <p class="page-subtitle">Atur dan kelola semua penghargaan untuk artikel literasi akhlak</p>

        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambahPenghargaan">
                <i class="fas fa-plus"></i> Tambah Penghargaan Baru
            </button>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-upload"></i> Import Penghargaan
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-download"></i> Export Data
            </a>
        </div>
    </div>

    <div class="modal fade" id="modalTambahPenghargaan" tabindex="-1" aria-labelledby="modalTambahPenghargaanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('penghargaan.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahPenghargaanLabel">Tambah Penghargaan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_artikel" class="form-label">Artikel (Opsional)</label>
                            <select name="id_artikel" id="id_artikel" class="form-control">
                                <option value="">Pilih Artikel</option>
                                @if ($highestRatedArtikel)
                                    <option value="{{ $highestRatedArtikel->id }}" selected>
                                        {{ $highestRatedArtikel->judul }} (Rating Tertinggi:
                                        {{ $highestRatedArtikel->nilai_rata_rata }})
                                    </option>
                                @endif
                                @foreach ($artikel as $artikelItem)
                                    @if ($highestRatedArtikel && $artikelItem->id != $highestRatedArtikel->id)
                                        <option value="{{ $artikelItem->id }}">{{ $artikelItem->judul }} (Rating:
                                            {{ $artikelItem->nilai_rata_rata }})</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('id_artikel')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_siswa" class="form-label">Siswa</label>
                            <select name="id_siswa" id="id_siswa" class="form-control" required>
                                <option value="">Pilih Siswa</option>
                                @if ($highestRatedArtikel && $highestRatedArtikel->siswa)
                                    <option value="{{ $highestRatedArtikel->siswa->id }}" selected>
                                        {{ $highestRatedArtikel->siswa->nama }} (Penulis Artikel Tertinggi)
                                    </option>
                                @endif
                                @foreach ($siswa as $item)
                                    @if (!$highestRatedArtikel || $item->id != $highestRatedArtikel->siswa->id)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('id_siswa')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis Penghargaan</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="bulanan">Bulanan</option>
                                <option value="spesial">Spesial</option>
                            </select>
                            @error('jenis')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bulan_tahun" class="form-label">Bulan dan Tahun</label>
                            <input type="date" name="bulan_tahun" id="bulan_tahun" class="form-control"
                                value="{{ $selectedMonth }}-01" required>
                            @error('bulan_tahun')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_penghargaan" class="form-label">Deskripsi Penghargaan</label>
                            <textarea name="deskripsi_penghargaan" id="deskripsi_penghargaan" class="form-control" rows="4" required></textarea>
                            @error('deskripsi_penghargaan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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

    <div class="modal fade" id="modalEditPenghargaan" tabindex="-1" aria-labelledby="modalEditPenghargaanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editPenghargaanForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPenghargaanLabel">Edit Penghargaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_id_artikel" class="form-label">Artikel (Opsional)</label>
                            <select name="id_artikel" id="edit_id_artikel" class="form-control">
                                <option value="">Pilih Artikel</option>
                            </select>
                            @error('id_artikel')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_siswa" class="form-label">Siswa</label>
                            <select name="id_siswa" id="edit_id_siswa" class="form-control" required>
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('id_siswa')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_jenis" class="form-label">Jenis Penghargaan</label>
                            <select name="jenis" id="edit_jenis" class="form-control" required>
                                <option value="bulanan">Bulanan</option>
                                <option value="spesial">Spesial</option>
                            </select>
                            @error('jenis')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_bulan_tahun" class="form-label">Bulan dan Tahun</label>
                            <input type="date" name="bulan_tahun" id="edit_bulan_tahun" class="form-control"
                                required>
                            @error('bulan_tahun')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi_penghargaan" class="form-label">Deskripsi Penghargaan</label>
                            <textarea name="deskripsi_penghargaan" id="edit_deskripsi_penghargaan" class="form-control" rows="4" required></textarea>
                            @error('deskripsi_penghargaan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Perbarui Penghargaan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <hr>

    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-trophy me-2"></i>Daftar Penghargaan
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: {{ $totalPenghargaan }} penghargaan</span>
            </div>
        </div>

        <div class="card-body-custom">
            <div class="search-filter-section">
                <form method="GET" action="{{ route('penghargaan') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control search-input border-start-0"
                                    placeholder="Cari penghargaan..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="jenis" class="form-select filter-select">
                                <option value="">Semua Jenis</option>
                                <option value="bulanan" {{ request('jenis') == 'bulanan' ? 'selected' : '' }}>Bulanan
                                </option>
                                <option value="spesial" {{ request('jenis') == 'spesial' ? 'selected' : '' }}>Spesial
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="month" class="form-select filter-select">
                                <option value="">Semua Bulan</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ sprintf('%d-%02d', now()->year, $month) }}"
                                        {{ $selectedMonth == sprintf('%d-%02d', now()->year, $month) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(now()->year, $month, 1)->translatedFormat('F Y') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-secondary w-100" style="border-radius: 12px;">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <hr>

            <div class="awards-grid mt-4">
                <div class="row g-4">
                    @forelse ($penghargaan as $item)
                        @if (is_object($item) && $item->id && $item->siswa)
                            <div class="col-lg-4 col-md-6">
                                <div class="award-card">
                                    <div class="award-icon">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div class="award-content">
                                        <div class="award-title">{{ Str::limit($item->deskripsi_penghargaan, 100) }}</div>
                                        <div class="award-meta">
                                            <span>
                                                <i class="fas fa-award"></i> Jenis: {{ ucfirst($item->jenis) }}
                                            </span>
                                            <span>
                                                <i class="fas fa-calendar"></i> Tanggal:
                                                {{ \Carbon\Carbon::parse($item->bulan_tahun)->translatedFormat('d F Y') }}
                                            </span>
                                        </div>
                                        <div class="award-recipient">
                                            <div class="recipient-avatar">{{ substr($item->siswa->nama ?? '?', 0, 2) }}
                                            </div>
                                            <div class="recipient-name">{{ $item->siswa->nama ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                    <div class="award-actions">
                                        <button class="btn-action-card btn-edit-card" data-bs-toggle="modal"
                                            data-bs-target="#modalEditPenghargaan" data-id="{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('penghargaan.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-card btn-delete-card"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus penghargaan ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <p class="text-center text-muted">Data penghargaan tidak valid.</p>
                            </div>
                        @endif
                    @empty
                        <div class="col-12">
                            <p class="text-center text-muted">Tidak ada penghargaan yang ditemukan.</p>
                        </div>
                    @endforelse
                </div>
                {{ $penghargaan->links() }}
            </div>

            <hr>

            <div class="artikel-section mt-5">
                <div class="card-header-custom">
                    <div>
                        <i class="fas fa-book me-2"></i>Daftar Artikel Bulan Ini (Filter: {{ $selectedMonth }})
                        <form method="GET" style="display:inline;">
                            <select name="year" onchange="this.form.submit()" style="margin-right: 10px;">
                                @for ($year = $minYear; $year <= $maxYear; $year++)
                                    <option value="{{ $year }}"
                                        {{ date('Y', strtotime($selectedMonth)) == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            <select name="month" onchange="this.form.submit()">
                                @foreach (range(1, 12) as $month)
                                    <?php
                                    $monthName = \Carbon\Carbon::create(now()->year, $month, 1)->translatedFormat('F');
                                    $monthValue = date('Y-m', mktime(0, 0, 0, $month, 1, date('Y', strtotime($selectedMonth))));
                                    ?>
                                    <option value="{{ $monthValue }}"
                                        {{ $selectedMonth == $monthValue ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body-custom">
                    <div class="articles-grid">
                        <div class="row g-4">
                            @forelse ($artikel as $index => $artikelItem)
                                @if (is_object($artikelItem) && $artikelItem->id)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="article-card">
                                            <div class="article-image">
                                                <img src="{{ $artikelItem->gambar ? asset('storage/' . $artikelItem->gambar) : 'https://via.placeholder.com/400x200' }}"
                                                    alt="{{ $artikelItem->judul }}"
                                                    title="Path: {{ $artikelItem->gambar ?? 'Tidak ada' }}"
                                                    onerror="this.src='https://via.placeholder.com/400x200'; console.log('Gagal memuat gambar: ' + this.src + ', Path DB: ' + '{{ $artikelItem->gambar ?? 'null' }}');">
                                                <div class="article-overlay">
                                                    <div class="article-actions">
                                                        <a href="{{ route('artikel.show', $artikelItem->id) }}"
                                                            class="btn-action-card btn-view-card">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn-action-card btn-select-article"
                                                            data-id="{{ $artikelItem->id }}"
                                                            onclick="selectArtikel(this)">
                                                            <i class="fas fa-award"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="article-status">
                                                    <span class="status-badge status-published">Disetujui</span>
                                                </div>
                                            </div>
                                            <div class="article-content">
                                                <div class="article-category">
                                                    <span
                                                        class="category-tag">{{ $artikelItem->kategori->nama ?? 'Tanpa Kategori' }}</span>
                                                </div>
                                                <h5 class="article-title-card">
                                                    {{ $artikelItem->judul ?? 'Judul Tidak Tersedia' }}</h5>
                                                <p class="article-excerpt-card">
                                                    {{ Str::limit(strip_tags($artikelItem->isi ?? 'Isi tidak tersedia'), 100) }}
                                                </p>
                                                <div class="article-author-card">
                                                    <div class="author-avatar">
                                                        {{ substr($artikelItem->siswa->nama ?? '?', 0, 2) }}
                                                    </div>
                                                    <div class="author-info">
                                                        <div class="author-name">
                                                            {{ $artikelItem->siswa ? $artikelItem->siswa->nama : 'Siswa Tidak Ditemukan' }}
                                                        </div>
                                                        <div class="author-role">Penulis</div>
                                                    </div>
                                                </div>
                                                <div class="article-meta-card">
                                                    <div class="meta-stats">
                                                        <span>
                                                            <i class="fas fa-calendar"></i>
                                                            {{ \Carbon\Carbon::parse($artikelItem->diterbitkan_pada)->translatedFormat('d F Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <p class="text-center text-muted">Data artikel tidak valid.</p>
                                    </div>
                                @endif
                            @empty
                                <div class="col-12">
                                    <p class="text-center text-muted">Tidak ada artikel untuk bulan ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="pagination-info text-muted">
                            {{ 'Showing ' . $artikel->firstItem() . ' to ' . $artikel->lastItem() . ' of ' . $artikel->total() . ' results' }}
                        </div>

                        <div>
                            {{ $artikel->appends(request()->query())->links('vendor.pagination.custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="winners-section mt-5">
                <div class="card-header-custom">
                    <div>
                        <i class="fas fa-crown me-2"></i>Pemenang Penghargaan Bulan Ini
                    </div>
                </div>
                <div class="card-body-custom">
                    <div class="winners-list">
                        @forelse ($penghargaan as $item)
                            @if (is_object($item) && $item->id && $item->siswa)
                                <div class="winner-item fade-in">
                                    <div class="winner-avatar"
                                        style="background: linear-gradient(135deg, {{ $item->jenis == 'bulanan' ? '#f59e0b, #d97706' : '#8b5cf6, #7c3aed' }});">
                                        {{ $item->siswa ? Str::substr($item->siswa->nama, 0, 1) : '-' }}
                                    </div>
                                    <div class="winner-info">
                                        <div class="winner-name">
                                            {{ $item->siswa ? $item->siswa->nama : 'Siswa tidak ditemukan' }}</div>
                                        <div class="winner-description">
                                            {{ $item->artikel ? $item->artikel->judul : $item->deskripsi_penghargaan }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="winner-item fade-in">
                                    <div class="winner-avatar"
                                        style="background: linear-gradient(135deg, #f59e0b, #d97706);">-</div>
                                    <div class="winner-info">
                                        <div class="winner-name">Data tidak valid</div>
                                        <div class="winner-description">
                                            {{ $item->deskripsi_penghargaan ?? 'Tidak ada deskripsi' }}</div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-center text-muted">Tidak ada pemenang penghargaan yang ditemukan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-edit-card');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    fetch(`/penghargaan/${id}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            const form = document.getElementById('editPenghargaanForm');
                            form.action = `/penghargaan/${id}`;
                            document.getElementById('edit_id').value = data.penghargaan.id ||
                                '';
                            document.getElementById('edit_id_artikel').value = data.penghargaan
                                .id_artikel || '';
                            document.getElementById('edit_id_siswa').value = data.penghargaan
                                .id_siswa || '';
                            document.getElementById('edit_jenis').value = data.penghargaan
                                .jenis || '';
                            document.getElementById('edit_bulan_tahun').value = data.penghargaan
                                .bulan_tahun || '';
                            document.getElementById('edit_deskripsi_penghargaan').value = data
                                .penghargaan.deskripsi_penghargaan || '';
                            const select = document.getElementById('edit_id_artikel');
                            select.innerHTML = '<option value="">Pilih Artikel</option>';
                            if (data.highestRatedArtikel) {
                                select.innerHTML +=
                                    `<option value="${data.highestRatedArtikel.id}">${data.highestRatedArtikel.judul} (Rating Tertinggi: ${data.highestRatedArtikel.nilai_rata_rata})</option>`;
                            }
                            data.artikel.forEach(artikel => {
                                if (!data.highestRatedArtikel || artikel.id != data
                                    .highestRatedArtikel.id) {
                                    select.innerHTML +=
                                        `<option value="${artikel.id}">${artikel.judul} (Rating: ${artikel.nilai_rata_rata})</option>`;
                                }
                            });
                            // Select the correct article in the edit modal
                            if (data.penghargaan.id_artikel) {
                                document.getElementById('edit_id_artikel').value = data
                                    .penghargaan.id_artikel;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            window.selectArtikel = function(button) {
                const artikelId = button.getAttribute('data-id');
                fetch(`/artikel/${artikelId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('id_artikel').value = data.id;
                        document.getElementById('id_siswa').value = data.siswa_id;
                        document.getElementById('bulan_tahun').value = data.diterbitkan_pada.substring(0,
                            7) + '-01';
                        document.getElementById('deskripsi_penghargaan').value =
                            `Penghargaan untuk artikel: ${data.judul}`;
                        // Automatically open the modal after filling the data
                        const modal = new bootstrap.Modal(document.getElementById(
                            'modalTambahPenghargaan'));
                        modal.show();
                    })
                    .catch(error => console.error('Error:', error));
            };
        });
    </script>
@endsection
