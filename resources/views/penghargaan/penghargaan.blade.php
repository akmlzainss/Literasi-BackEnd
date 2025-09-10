@extends('layouts.app')

@section('title', 'Kelola Penghargaan')
@section('page-title', 'Kelola Penghargaan Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/penghargaan.css') }}">

    <div class="page-header">
        <h1 class="page-title">Kelola Penghargaan</h1>
        <p class="page-subtitle">Atur dan kelola semua penghargaan untuk artikel literasi akhlak</p>

        <div class="action-buttons">
            <a href="{{ route('penghargaan.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i> Tambah Penghargaan Baru
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-upload"></i> Import Penghargaan
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-download"></i> Export Data
            </a>
        </div>
    </div>

    @include('penghargaan.modal-edit')

    <hr>

    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-trophy me-2"></i>Daftar Penghargaan
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: {{ $totalPenghargaan ?? 0 }} penghargaan</span>
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
                                <option value="bulanan" {{ request('jenis') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                <option value="spesial" {{ request('jenis') == 'spesial' ? 'selected' : '' }}>Spesial</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="month" class="form-select filter-select">
                                <option value="">Semua Bulan</option>
                                @for ($month = 1; $month <= 12; $month++)
                                    <option value="{{ sprintf('%d-%02d', now()->year, $month) }}"
                                        {{ ($selectedMonth ?? '') == sprintf('%d-%02d', now()->year, $month) ? 'selected' : '' }}>
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
                    @forelse ($penghargaan ?? [] as $item)
                        @if (is_object($item) && isset($item->id) && isset($item->siswa))
                            <div class="col-lg-4 col-md-6">
                                <div class="award-card">
                                    <div class="award-icon">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div class="award-content">
                                        <div class="award-title">{{ Str::limit($item->deskripsi_penghargaan ?? 'Tidak ada deskripsi', 100) }}</div>
                                        <div class="award-meta">
                                            <span>
                                                <i class="fas fa-award"></i> Jenis: {{ ucfirst($item->jenis ?? 'Tidak diketahui') }}
                                            </span>
                                            <span>
                                                <i class="fas fa-calendar"></i> Tanggal:
                                                @if($item->bulan_tahun)
                                                    {{ \Carbon\Carbon::parse($item->bulan_tahun)->translatedFormat('d F Y') }}
                                                @else
                                                    Tanggal tidak tersedia
                                                @endif
                                            </span>
                                        </div>
                                        <div class="award-recipient">
                                            <div class="recipient-avatar">{{ substr($item->siswa->nama ?? '?', 0, 2) }}</div>
                                            <div class="recipient-name">{{ $item->siswa->nama ?? 'Unknown' }}</div>
                                        </div>
                                        
                                        <!-- Rating Section - Dipindahkan ke dalam award-content -->
                                        @if(isset($item->artikel) && isset($item->artikel->rating))
                                            <div class="award-rating mt-3">
                                                <div class="rating-info">
                                                    <i class="fas fa-star rating-icon"></i>
                                                    <span class="rating-label">Rating:</span>
                                                    <span class="rating-value">{{ number_format($item->artikel->rating, 1) }}</span>
                                                </div>
                                                <div class="rating-stars">
                                                    @php 
                                                        $rating = floatval($item->artikel->rating ?? 0);
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="rating-star {{ $i <= $rating ? 'filled' : 'empty' }}">
                                                            {{ $i <= $rating ? '⭐' : '☆' }}
                                                        </span>
                                                    @endfor
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="award-actions">
                                        <button class="btn-action-card btn-edit-card" data-bs-toggle="modal"
                                            data-bs-target="#modalEditPenghargaan" data-id="{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('penghargaan.destroy', $item->id) }}" method="POST" class="d-inline">
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
                            <div class="alert alert-info text-center">
                                <i class="fas fa-trophy fa-3x mb-3 text-muted"></i>
                                <h5>Belum Ada Penghargaan</h5>
                                <p class="mb-0">Tidak ada penghargaan yang ditemukan. Silakan tambahkan penghargaan baru.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                
                @if(isset($penghargaan) && method_exists($penghargaan, 'links'))
                    {{ $penghargaan->links() }}
                @endif
            </div>

            <hr>

            <div class="artikel-section mt-5">
                <div class="card-header-custom">
                    <div>
                        <i class="fas fa-book me-2"></i>Daftar Artikel Bulan Ini 
                        @if(isset($selectedMonth))
                            (Filter: {{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }})
                        @endif
                        
                        <form method="GET" style="display:inline;" class="ms-3">
                            <select name="year" onchange="this.form.submit()" class="form-select d-inline" style="width: auto; margin-right: 10px;">
                                @for ($year = ($minYear ?? date('Y')); $year <= ($maxYear ?? date('Y')); $year++)
                                    <option value="{{ $year }}"
                                        {{ (isset($selectedMonth) && date('Y', strtotime($selectedMonth)) == $year) ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            <select name="month" onchange="this.form.submit()" class="form-select d-inline" style="width: auto;">
                                @foreach (range(1, 12) as $month)
                                    @php
                                        $monthName = \Carbon\Carbon::create(now()->year, $month, 1)->translatedFormat('F');
                                        $monthValue = date('Y-m', mktime(0, 0, 0, $month, 1, date('Y', strtotime($selectedMonth ?? now()))));
                                    @endphp
                                    <option value="{{ $monthValue }}"
                                        {{ ($selectedMonth ?? '') == $monthValue ? 'selected' : '' }}>
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
                            @forelse ($artikel ?? [] as $index => $artikelItem)
                                @if (is_object($artikelItem) && isset($artikelItem->id))
                                    <div class="col-lg-4 col-md-6">
                                        <div class="article-card">
                                            <div class="article-image">
                                                <img src="{{ isset($artikelItem->gambar) && $artikelItem->gambar ? asset('storage/' . $artikelItem->gambar) : 'https://via.placeholder.com/400x200' }}"
                                                    alt="{{ $artikelItem->judul ?? 'Artikel' }}"
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
                                                    <span class="category-tag">
                                                        {{ (isset($artikelItem->kategori) && $artikelItem->kategori->nama) ? $artikelItem->kategori->nama : 'Tanpa Kategori' }}
                                                    </span>
                                                </div>
                                                <h5 class="article-title-card">
                                                    {{ $artikelItem->judul ?? 'Judul Tidak Tersedia' }}
                                                </h5>
                                                <p class="article-excerpt-card">
                                                    {{ Str::limit(strip_tags($artikelItem->isi ?? 'Isi tidak tersedia'), 100) }}
                                                </p>
                                                <div class="article-author-card">
                                                    <div class="author-avatar">
                                                        {{ substr((isset($artikelItem->siswa) ? $artikelItem->siswa->nama : '?'), 0, 2) }}
                                                    </div>
                                                    <div class="author-info">
                                                        <div class="author-name">
                                                            {{ (isset($artikelItem->siswa) && $artikelItem->siswa->nama) ? $artikelItem->siswa->nama : 'Siswa Tidak Ditemukan' }}
                                                        </div>
                                                        <div class="author-role">Penulis</div>
                                                    </div>
                                                </div>
                                                <div class="article-meta-card">
                                                    <div class="meta-stats">
                                                        <span>
                                                            <i class="fas fa-calendar"></i>
                                                            @if(isset($artikelItem->diterbitkan_pada))
                                                                {{ \Carbon\Carbon::parse($artikelItem->diterbitkan_pada)->translatedFormat('d F Y') }}
                                                            @else
                                                                Tanggal tidak tersedia
                                                            @endif
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
                                    <div class="alert alert-info text-center">
                                        <i class="fas fa-book fa-3x mb-3 text-muted"></i>
                                        <h5>Tidak Ada Artikel</h5>
                                        <p class="mb-0">Tidak ada artikel untuk bulan ini.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if(isset($artikel) && method_exists($artikel, 'links'))
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="pagination-info text-muted">
                                {{ 'Showing ' . $artikel->firstItem() . ' to ' . $artikel->lastItem() . ' of ' . $artikel->total() . ' results' }}
                            </div>

                            <div>
                                {{ $artikel->appends(request()->query())->links('vendor.pagination.custom-pagination') }}
                            </div>
                        </div>
                    @endif
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
                        @forelse ($penghargaan ?? [] as $item)
                            @if (is_object($item) && isset($item->id) && isset($item->siswa))
                                <div class="winner-item fade-in">
                                    <div class="winner-avatar"
                                        style="background: linear-gradient(135deg, {{ ($item->jenis ?? '') == 'bulanan' ? '#f59e0b, #d97706' : '#8b5cf6, #7c3aed' }});">
                                        {{ isset($item->siswa) ? Str::substr($item->siswa->nama, 0, 1) : '-' }}
                                    </div>
                                    <div class="winner-info">
                                        <div class="winner-name">
                                            {{ isset($item->siswa) ? $item->siswa->nama : 'Siswa tidak ditemukan' }}
                                        </div>
                                        <div class="winner-description">
                                            {{ (isset($item->artikel) && $item->artikel->judul) ? $item->artikel->judul : ($item->deskripsi_penghargaan ?? 'Tidak ada deskripsi') }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="winner-item fade-in">
                                    <div class="winner-avatar" style="background: linear-gradient(135deg, #f59e0b, #d97706);">-</div>
                                    <div class="winner-info">
                                        <div class="winner-name">Data tidak valid</div>
                                        <div class="winner-description">
                                            {{ (is_object($item) ? ($item->deskripsi_penghargaan ?? 'Tidak ada deskripsi') : 'Tidak ada deskripsi') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="alert alert-info text-center">
                                <i class="fas fa-crown fa-3x mb-3 text-muted"></i>
                                <h5>Belum Ada Pemenang</h5>
                                <p class="mb-0">Tidak ada pemenang penghargaan yang ditemukan untuk bulan ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 1050;">
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
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const form = document.getElementById('editPenghargaanForm');
                            if (form) {
                                form.action = `/penghargaan/${id}`;
                                
                                // Helper function to safely set input values
                                const setInputValue = (elementId, value) => {
                                    const element = document.getElementById(elementId);
                                    if (element) {
                                        element.value = value || '';
                                    }
                                };
                                
                                setInputValue('edit_id', data.penghargaan?.id);
                                setInputValue('edit_id_artikel', data.penghargaan?.id_artikel);
                                setInputValue('edit_id_siswa', data.penghargaan?.id_siswa);
                                setInputValue('edit_jenis', data.penghargaan?.jenis);
                                setInputValue('edit_bulan_tahun', data.penghargaan?.bulan_tahun);
                                setInputValue('edit_deskripsi_penghargaan', data.penghargaan?.deskripsi_penghargaan);
                                
                                // Update artikel select
                                const select = document.getElementById('edit_id_artikel');
                                if (select) {
                                    select.innerHTML = '<option value="">Pilih Artikel</option>';
                                    
                                    if (data.highestRatedArtikel) {
                                        select.innerHTML += `<option value="${data.highestRatedArtikel.id}">${data.highestRatedArtikel.judul} (Rating Tertinggi: ${data.highestRatedArtikel.nilai_rata_rata || 'N/A'})</option>`;
                                    }
                                    
                                    if (data.artikel && Array.isArray(data.artikel)) {
                                        data.artikel.forEach(artikel => {
                                            if (!data.highestRatedArtikel || artikel.id != data.highestRatedArtikel.id) {
                                                select.innerHTML += `<option value="${artikel.id}">${artikel.judul} (Rating: ${artikel.nilai_rata_rata || 'N/A'})</option>`;
                                            }
                                        });
                                    }
                                    
                                    if (data.penghargaan?.id_artikel) {
                                        select.value = data.penghargaan.id_artikel;
                                    }
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat memuat data penghargaan.');
                        });
                });
            });

            // Global function for selecting artikel
            window.selectArtikel = function(button) {
                const artikelId = button.getAttribute('data-id');
                if (artikelId) {
                    window.location.href = `{{ route('penghargaan.create') }}?artikel_id=${artikelId}`;
                }
            };
            
            // Auto-hide success alert after 5 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.3s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 300);
                }, 5000);
            }
        });
    </script>
@endsection