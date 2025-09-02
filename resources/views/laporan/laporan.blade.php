@extends('layouts.app')

@section('title', 'Laporan Aktivitas')
@section('page-title', 'Laporan Aktivitas Sistem Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Laporan Aktivitas</h1>
        <p class="page-subtitle">Monitor aktivitas real-time siswa dan admin dalam sistem literasi akhlak</p>

        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalFilterAktivitas">
                <i class="fas fa-filter"></i>
                Filter Aktivitas
            </button>
            <button type="button" class="btn-outline-custom" onclick="exportAktivitas()">
                <i class="fas fa-file-export"></i>
                Export Data
            </button>
            <button class="btn-success-custom" id="autoRefreshBtn">
                <i class="fas fa-sync-alt"></i>
                Auto Refresh
            </button>
        </div>
    </div>

    <!-- Modal Filter Aktivitas -->
    <div class="modal fade" id="modalFilterAktivitas" tabindex="-1" aria-labelledby="modalFilterAktivitasLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modern-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFilterAktivitasLabel">
                        <i class="fas fa-filter me-2"></i>Filter Aktivitas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group-modern">
                        <label for="filter_user_type" class="form-label-modern">Tipe Pengguna</label>
                        <select name="filter_user_type" id="filter_user_type" class="form-control-modern">
                            <option value="">👥 Semua Pengguna</option>
                            <option value="siswa">👨‍🎓 Hanya Siswa</option>
                            <option value="admin">👨‍💼 Hanya Admin</option>
                        </select>
                    </div>

                    <div class="form-group-modern">
                        <label for="filter_aktivitas" class="form-label-modern">Jenis Aktivitas</label>
                        <select name="filter_aktivitas" id="filter_aktivitas" class="form-control-modern">
                            <option value="">🎯 Semua Aktivitas</option>
                            <option value="upload_artikel">📝 Upload Artikel</option>
                            <option value="edit_artikel">✏️ Edit Artikel</option>
                            <option value="hapus_artikel">🗑️ Hapus Artikel</option>
                            <option value="approve_artikel">✅ Approve Artikel</option>
                            <option value="reject_artikel">❌ Reject Artikel</option>
                            <option value="beri_komentar">💬 Beri Komentar</option>
                            <option value="like_artikel">❤️ Like Artikel</option>
                            <option value="login">🔑 Login</option>
                            <option value="logout">🚪 Logout</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group-modern">
                            <label for="filter_tanggal_mulai" class="form-label-modern">Tanggal Mulai</label>
                            <input type="date" name="filter_tanggal_mulai" id="filter_tanggal_mulai"
                                class="form-control-modern">
                        </div>
                        <div class="form-group-modern">
                            <label for="filter_tanggal_selesai" class="form-label-modern">Tanggal Selesai</label>
                            <input type="date" name="filter_tanggal_selesai" id="filter_tanggal_selesai"
                                class="form-control-modern">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-primary-custom" onclick="applyFilter()">
                        <i class="fas fa-search"></i>Terapkan Filter
                    </button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

   <!-- Aktivitas Siswa Card -->
<div class="main-card">
    <div class="card-header-custom">
        <div>
            <i class="fas fa-user-graduate me-2"></i>Aktivitas Siswa Real-time
        </div>
        <div class="header-actions">
            <span class="live-indicator">
                <span class="live-dot"></span>
                Live Updates
            </span>
            <button class="refresh-btn" onclick="refreshSiswaTable()">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <div class="reports-table">
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Aktivitas</th>
                        <th>Artikel</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aktivitas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->aktivitas }}</td>
                            <td>{{ $item->artikel ?? '-' }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="badge bg-info">{{ ucfirst($item->status) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ optional($item->dibuat_pada)->diffForHumans() ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <i class="fas fa-info-circle"></i> Belum ada aktivitas siswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


    <!-- Aktivitas Admin Card -->
    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-user-shield me-2"></i>Aktivitas Admin Real-time
            </div>
            <div class="header-actions">
                <span class="live-indicator">
                    <span class="live-dot"></span>
                    Live Updates
                </span>
                <button class="refresh-btn" onclick="refreshAdminTable()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <div class="reports-table">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jenis Aksi</th>
                            <th>Aksi</th>
                            <th>User</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aktivitasAdmin as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="user-info-table">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->admin->nama_pengguna ?? 'Admin') }}&background=10b981&color=fff"
                                            alt="Avatar" class="user-avatar-small">
                                        <div class="user-details">
                                            <span
                                                class="user-name">{{ $item->admin->nama_pengguna ?? 'Tidak Diketahui' }}</span>
                                            <span class="user-role">{{ $item->admin->email ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->jenis_aksi }}</td>
                                <td>{{ $item->aksi }}</td>
                                <td>
                                    @if ($item->referensi_tipe == 'admin')
                                        Admin
                                    @else
                                        {{ ucfirst($item->referensi_tipe) }} - {{ $item->referensi_id }}
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($item->dibuat_pada)->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="fas fa-info-circle"></i> Belum ada aktivitas admin
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    <script>
        // ========================================
        // AUTO REFRESH FUNCTIONALITY
        // ========================================
        let autoRefreshInterval;
        let isAutoRefreshActive = false;

        document.getElementById('autoRefreshBtn').addEventListener('click', function() {
            if (isAutoRefreshActive) {
                stopAutoRefresh();
            } else {
                startAutoRefresh();
            }
        });

        function startAutoRefresh() {
            autoRefreshInterval = setInterval(() => {
                refreshSiswaTable();
                refreshAdminTable();
            }, 30000); // Refresh every 30 seconds

            const btn = document.getElementById('autoRefreshBtn');
            btn.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Auto Refresh ON';
            btn.classList.add('active');
            isAutoRefreshActive = true;
        }

        function stopAutoRefresh() {
            clearInterval(autoRefreshInterval);
            const btn = document.getElementById('autoRefreshBtn');
            btn.innerHTML = '<i class="fas fa-sync-alt"></i> Auto Refresh';
            btn.classList.remove('active');
            isAutoRefreshActive = false;
        }

        // ========================================
        // TABLE REFRESH FUNCTIONS
        // ========================================
        function refreshSiswaTable() {
            const refreshBtn = document.querySelector('.refresh-btn i');
            refreshBtn.classList.add('fa-spin');

            setTimeout(() => {
                refreshBtn.classList.remove('fa-spin');
                console.log('Siswa table refreshed');
            }, 1000);
        }

        function refreshAdminTable() {
            const refreshBtns = document.querySelectorAll('.refresh-btn i');
            refreshBtns.forEach(btn => btn.classList.add('fa-spin'));

            setTimeout(() => {
                refreshBtns.forEach(btn => btn.classList.remove('fa-spin'));
                console.log('Admin table refreshed');
            }, 1000);
        }

        // ========================================
        // FILTER FUNCTIONALITY
        // ========================================
        function applyFilter() {
            const userType = document.getElementById('filter_user_type').value;
            const activity = document.getElementById('filter_aktivitas').value;
            const startDate = document.getElementById('filter_tanggal_mulai').value;
            const endDate = document.getElementById('filter_tanggal_selesai').value;

            console.log('Applying filters:', {
                userType,
                activity,
                startDate,
                endDate
            });

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalFilterAktivitas'));
            modal.hide();
        }

        // ========================================
        // EXPORT AND LOAD MORE FUNCTIONS
        // ========================================
        function exportAktivitas() {
            console.log('Exporting activity data...');
            alert('Data aktivitas akan didownload dalam format Excel');
        }

        function loadMoreSiswaActivities() {
            const loadBtn = document.querySelector('#siswaTable').closest('.main-card').querySelector('.load-more-btn');
            loadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';

            setTimeout(() => {
                loadBtn.innerHTML = '<i class="fas fa-chevron-down"></i> Muat Aktivitas Siswa Lainnya';
                console.log('More siswa activities loaded');
            }, 1500);
        }

        function loadMoreAdminActivities() {
            const loadBtn = document.querySelector('#adminTable').closest('.main-card').querySelector('.load-more-btn');
            loadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';

            setTimeout(() => {
                loadBtn.innerHTML = '<i class="fas fa-chevron-down"></i> Muat Aktivitas Admin Lainnya';
                console.log('More admin activities loaded');
            }, 1500);
        }

        // ========================================
        // ACTION FUNCTIONS
        // ========================================
        function viewArticle(id) {
            console.log('Viewing article:', id);
        }

        function editArticle(id) {
            console.log('Editing article:', id);
        }

        function viewHistory(id) {
            console.log('Viewing history for article:', id);
        }

        function viewComment(id) {
            console.log('Viewing comment:', id);
        }

        function viewFeedback(id) {
            console.log('Viewing feedback for article:', id);
        }

        function viewApprovalLog(id) {
            console.log('Viewing approval log for article:', id);
        }

        function viewRejectionLog(id) {
            console.log('Viewing rejection log for article:', id);
        }
    </script>
 <div class="mt-3">
    {{ $aktivitasAdmin->links() }}
</div>
    </div>
@endsection
