@extends('layouts.app')

@section('title', 'Kelola Penghargaan')
@section('page-title', 'Kelola Penghargaan Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/penghargaan.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <div class="page-header">
        <h1 class="page-title">Kelola Penghargaan Bulan Ini</h1>
        <p class="page-subtitle" id="monthDisplay">Pilih pemenang berdasarkan rating (artikel) atau like (video). Bulan aktif: {{ \Carbon\Carbon::parse($currentMonth)->translatedFormat('F Y') }}</p>
        <div class="action-buttons">
            <a href="{{ route('admin.penghargaan.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i> Tambah Manual
            </a>
            <a href="{{ route('admin.penghargaan.reset') }}" class="btn btn-warning" onclick="return confirm('Anda yakin ingin mengarsipkan semua pemenang dari bulan lalu?')">
                <i class="fas fa-refresh"></i> Reset Bulanan
            </a>
        </div>
    </div>

    @include('penghargaan.modal-edit')
    @include('penghargaan.modal-confirm-pilih')

    <hr>

    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <ul class="nav nav-tabs" id="penghargaanTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'artikel' ? 'active' : '' }}" id="artikel-tab" data-bs-toggle="tab" data-bs-target="#artikel" type="button" role="tab">
                            <i class="fas fa-book me-1"></i> Artikel (Rating Tertinggi)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab == 'video' ? 'active' : '' }}" id="video-tab" data-bs-toggle="tab" data-bs-target="#video" type="button" role="tab">
                            <i class="fas fa-video me-1"></i> Video (Like Terbanyak)
                        </button>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: {{ $totalPenghargaan ?? 0 }} penghargaan</span>
            </div>
        </div>

        <div class="card-body-custom">
            <div class="tab-content" id="penghargaanTabContent">
                {{-- TAB ARTIKEL --}}
                <div class="tab-pane fade {{ $activeTab == 'artikel' ? 'show active' : '' }}" id="artikel" role="tabpanel" aria-labelledby="artikel-tab">
                    <div class="search-filter-section">
                        <form method="GET" action="{{ route('admin.penghargaan.index') }}" id="filterFormArtikel">
                            <input type="hidden" name="active_tab" value="artikel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <select name="year" class="form-select filter-select" id="yearFilterArtikel">
                                        @for ($y = $maxYear; $y >= $minYear; $y--)
                                            <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="month" class="form-select filter-select" id="monthFilterArtikel" onchange="this.form.submit()">
                                        {{-- Opsi bulan akan diisi oleh JavaScript --}}
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <hr>

                    @if($topArtikel->count() > 0)
                    <div class="top-candidates mb-4">
                        <h5 class="text-warning"><i class="fas fa-crown me-2"></i> Rekomendasi Pemenang (Top 3 Rating)</h5>
                        <div class="row g-3">
                            @foreach($topArtikel as $item)
                            <div class="col-md-4">
                                <div class="card bg-warning bg-opacity-10 border-warning">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ Str::limit($item->judul ?? 'Tanpa Judul', 40) }}</h6>
                                        <div class="rating-display">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="rating-star {{ $i <= ($item->avg_rating ?? 0) ? 'filled' : '' }}">{{ $i <= ($item->avg_rating ?? 0) ? '⭐' : '☆' }}</span>
                                            @endfor
                                            <span class="ms-1 fw-bold">{{ number_format($item->avg_rating ?? 0, 1) }}/5</span>
                                        </div>
                                        <p class="card-text small text-muted mt-2">{{ $item->siswa->nama ?? 'Unknown' }}</p>
                                        <button class="btn btn-warning btn-sm mt-2 pilih-cepat" data-id="{{ $item->id }}" data-type="artikel">
                                            <i class="fas fa-award"></i> Pilih sebagai Pemenang
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table id="artikelTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Rating</th>
                                    <th>Tanggal Post</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- PERBAIKAN: @empty DIHAPUS, BIARKAN DATATABLES YANG MENANGANI --}}
                                @foreach ($artikel ?? [] as $item)
                                <tr>
                                    <td>{{ Str::limit($item->judul ?? 'Tanpa Judul', 50) }}</td>
                                    <td>{{ $item->siswa->nama ?? 'Unknown' }}</td>
                                    <td>
                                        <div class="rating-display">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="rating-star {{ $i <= ($item->avg_rating ?? 0) ? 'filled' : '' }}">{{ $i <= ($item->avg_rating ?? 0) ? '⭐' : '☆' }}</span>
                                            @endfor
                                            <span class="ms-1">{{ number_format($item->avg_rating ?? 0, 1) }}</span>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->diterbitkan_pada ?? now())->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm pilih-cepat" data-id="{{ $item->id }}" data-type="artikel">
                                            <i class="fas fa-award"></i> Pilih
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB VIDEO --}}
                <div class="tab-pane fade {{ $activeTab == 'video' ? 'show active' : '' }}" id="video" role="tabpanel" aria-labelledby="video-tab">
                    <div class="search-filter-section">
                         <form method="GET" action="{{ route('admin.penghargaan.index') }}" id="filterFormVideo">
                            <input type="hidden" name="active_tab" value="video">
                             <div class="row g-3">
                                <div class="col-md-6">
                                    <select name="year" class="form-select filter-select" id="yearFilterVideo">
                                         @for ($y = $maxYear; $y >= $minYear; $y--)
                                            <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="month" class="form-select filter-select" id="monthFilterVideo" onchange="this.form.submit()">
                                        {{-- Opsi bulan akan diisi oleh JavaScript --}}
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <hr>

                    @if($topVideo->count() > 0)
                    <div class="top-candidates mb-4">
                        <h5 class="text-warning"><i class="fas fa-crown me-2"></i> Rekomendasi Pemenang (Top 3 Like)</h5>
                        <div class="row g-3">
                            @foreach($topVideo as $item)
                            <div class="col-md-4">
                                <div class="card bg-warning bg-opacity-10 border-warning">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ Str::limit($item->judul ?? 'Tanpa Judul', 40) }}</h6>
                                        <div class="rating-display">
                                            <i class="fas fa-heart text-danger"></i>
                                            <span class="ms-1 fw-bold">{{ $item->jumlah_like ?? 0 }} Like</span>
                                        </div>
                                        <p class="card-text small text-muted mt-2">{{ $item->siswa->nama ?? 'Unknown' }}</p>
                                        <button class="btn btn-warning btn-sm mt-2 pilih-cepat" data-id="{{ $item->id }}" data-type="video">
                                            <i class="fas fa-award"></i> Pilih sebagai Pemenang
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table id="videoTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Like</th>
                                    <th>Tanggal Post</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- PERBAIKAN: @empty DIHAPUS, BIARKAN DATATABLES YANG MENANGANI --}}
                                @foreach ($video ?? [] as $item)
                                <tr>
                                    <td>{{ Str::limit($item->judul ?? 'Tanpa Judul', 50) }}</td>
                                    <td>{{ $item->siswa->nama ?? 'Unknown' }}</td>
                                    <td>
                                        <div class="rating-display">
                                            <i class="fas fa-heart text-danger"></i>
                                            <span class="ms-1">{{ $item->jumlah_like ?? 0 }}</span>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->diterbitkan_pada ?? now())->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm pilih-cepat" data-id="{{ $item->id }}" data-type="video">
                                            <i class="fas fa-award"></i> Pilih
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        @forelse ($penghargaan ?? [] as $item)
                            @if (is_object($item) && isset($item->id) && isset($item->siswa))
                                <div class="winner-item fade-in">
                                    <div class="winner-avatar" style="background: linear-gradient(135deg, {{ $item->jenis == 'bulanan' ? '#f59e0b, #d97706' : '#8b5cf6, #7c3aed' }});">
                                        {{ Str::substr($item->siswa->nama ?? '-', 0, 1) }}
                                    </div>
                                    <div class="winner-info">
                                        <div class="winner-name">
                                            {{ $item->siswa->nama ?? 'Siswa tidak ditemukan' }}
                                        </div>
                                        <div class="winner-description">
                                            {{ ($item->artikel ? 'Artikel: ' . Str::limit($item->artikel->judul, 50) : ($item->video ? 'Video: ' . Str::limit($item->video->judul, 50) : ($item->deskripsi_penghargaan ?? 'Tidak ada deskripsi'))) }}
                                        </div>
                                    </div>
                                    <div class="winner-actions">
                                        <button class="btn btn-outline-primary btn-sm btn-edit-card" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#editPenghargaanModal">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.penghargaan.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus penghargaan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="alert alert-info text-center">
                                <i class="fas fa-crown fa-3x mb-3 text-muted"></i>
                                <h5>Belum Ada Pemenang</h5>
                                <p class="mb-0">Pilih pemenang dari daftar di atas untuk bulan ini!</p>
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
document.addEventListener('DOMContentLoaded', () => {
    // Inisialisasi DataTable dengan pesan 'emptyTable'
    $('#artikelTable').DataTable({
        "pageLength": 10,
        "order": [[2, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
            "emptyTable": "Tidak ada artikel untuk bulan yang dipilih."
        },
        "columnDefs": [{ "orderable": false, "targets": 4 }, { "searchable": false, "targets": [2, 4] }],
    });
    $('#videoTable').DataTable({
        "pageLength": 10,
        "order": [[2, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json",
            "emptyTable": "Tidak ada video untuk bulan yang dipilih."
        },
        "columnDefs": [{ "orderable": false, "targets": 4 }, { "searchable": false, "targets": [2, 4] }],
    });
    
    const setupFilter = (type) => {
        const yearSelect = document.getElementById(`yearFilter${type}`);
        const monthSelect = document.getElementById(`monthFilter${type}`);
        const currentMonthValue = '{{ $currentMonth }}';

        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        const updateMonths = (shouldSubmit) => {
            const selectedYear = yearSelect.value;
            const currentSelectedMonth = monthSelect.value;
            monthSelect.innerHTML = '';

            let monthExistsInNewYear = false;
            let firstOption = null;

            monthNames.forEach((name, index) => {
                const monthNumber = String(index + 1).padStart(2, '0');
                const monthValue = `${selectedYear}-${monthNumber}`;
                const option = document.createElement('option');
                option.value = monthValue;
                option.textContent = `${name} ${selectedYear}`;
                
                if(index === 0) firstOption = option;

                // Coba pertahankan bulan yang sama saat tahun berganti
                if (currentSelectedMonth && currentSelectedMonth.substring(5) === monthNumber) {
                    option.selected = true;
                    monthExistsInNewYear = true;
                } else if (!currentSelectedMonth && monthValue === currentMonthValue) {
                    option.selected = true;
                    monthExistsInNewYear = true;
                }

                monthSelect.appendChild(option);
            });
            
            if (!monthExistsInNewYear && firstOption) {
                firstOption.selected = true;
            }

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
            document.getElementById('confirmModalLabel').textContent = `Konfirmasi Pemenang ${type === 'artikel' ? 'Artikel' : 'Video'}`;
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
            // Ambil bulan dari filter yang aktif
            const activeTabPane = document.querySelector('.tab-pane.active');
            const monthSelect = activeTabPane.querySelector('select[name="month"]');
            const month = monthSelect ? monthSelect.value : '{{ $currentMonth }}';
            window.location.href = `/admin/penghargaan/create?type=${type}&${type}_id=${id}&month=${month}`;
        });
    }
    
    document.querySelectorAll('.btn-edit-card').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            fetch(`/admin/penghargaan/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        console.error('Server response:', response);
                        throw new Error(`Gagal memuat data: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const form = document.getElementById('editPenghargaanForm');
                    if (!form) return;

                    form.action = `/admin/penghargaan/${id}`;
                    
                    const setInputValue = (elId, value) => {
                        const element = document.getElementById(elId);
                        if (element) element.value = value || '';
                    };

                    const itemType = data.type;
                    setInputValue('edit_id', data.penghargaan?.id);
                    setInputValue('edit_type', itemType);
                    setInputValue('edit_id_siswa', data.penghargaan?.id_siswa);
                    setInputValue('edit_nama_siswa', data.penghargaan?.siswa?.nama || 'Siswa tidak ditemukan');
                    setInputValue('edit_jenis', data.penghargaan?.jenis);
                    setInputValue('edit_bulan_tahun', data.penghargaan?.bulan_tahun);
                    setInputValue('edit_deskripsi_penghargaan', data.penghargaan?.deskripsi_penghargaan);

                    const itemSelect = document.getElementById('edit_id_item');
                    const itemLabel = document.getElementById('editItemLabel');
                    
                    itemLabel.textContent = `Pilih ${itemType.charAt(0).toUpperCase() + itemType.slice(1)}`;
                    itemSelect.innerHTML = `<option value="">-- Pilih ${itemType.charAt(0).toUpperCase() + itemType.slice(1)} --</option>`;

                    if (data.items?.length) {
                        data.items.forEach(item => {
                            const ratingText = itemType === 'artikel' ? `Rating: ${parseFloat(item.rating || 0).toFixed(1)}` : `Like: ${item.rating || 0}`;
                            itemSelect.innerHTML += `<option value="${item.id}">${item.judul} (${ratingText})</option>`;
                        });
                    }
                    
                    const selectedItemId = data.penghargaan?.[itemType === 'artikel' ? 'id_artikel' : 'id_video'];
                    if (selectedItemId) {
                        itemSelect.value = selectedItemId;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memuat data penghargaan. Cek console untuk detail.');
                });
        });
    });

    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(() => {
            new bootstrap.Alert(successAlert).close();
        }, 5000);
    }
});
</script>
@endsection