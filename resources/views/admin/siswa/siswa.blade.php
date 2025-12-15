@extends('layouts.admin')

@section('title', 'Kelola Siswa')
@section('page-title', 'Kelola Siswa')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">

    <div class="page-header">
        <h1 class="page-title">Kelola Siswa</h1>
        <p class="page-subtitle">Kelola dan pantau data siswa beserta prestasi dan aktivitas literasi akhlak mereka</p>
        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fas fa-user-plus"></i> Tambah Siswa Baru
            </button>
            <a href="{{ route('admin.siswa.export') }}" class="btn-outline-custom">
                <i class="fas fa-file-export"></i> Export Data
            </a>
            <button type="button" class="btn-outline-custom" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import"></i> Import Data Siswa
            </button>
        </div>
    </div>

    @include('admin.siswa.modal_import')
    @include('admin.siswa.edit')
    @include('admin.siswa.create')

    <!-- Delete Student Modal -->
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-warning-modal">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteStudentModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    Yakin ingin melanjutkan penghapusan data ini?
                    <br><br>
                    <strong id="delete_nis"></strong> - <span id="delete_nama"></span>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteStudentForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-user-graduate me-2"></i>Daftar Siswa
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: {{ $siswa->total() }} siswa</span>
            </div>
        </div>

        <div class="card-body-custom">
            <div class="search-filter-section mb-4">
                <form action="{{ route('admin.siswa.index') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="q" class="form-label">Pencarian</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 search-input"
                                    placeholder="Cari NIS / Nama / Email..." name="q" value="{{ request('q') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="kelas_filter" class="form-label">Kelas</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-filter text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 filter-input" name="kelas"
                                    id="kelas_filter" value="{{ request('kelas') ?? '' }}" placeholder="Masukkan kelas">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="sort" class="form-label">Urutkan Nama</label>
                            <select class="form-control" name="sort" id="sort">
                                <option value="">-- Default (Tanggal) --</option>
                                <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>A-Z</option>
                                <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Z-A
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-success flex-fill">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="students-table">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NIS</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Email</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $index => $student)
                                <tr>
                                    <td>{{ $siswa->firstItem() + $index }}</td>
                                    <td>{{ $student->nis }}</td>
                                    <td>
                                        <div class="student-name">{{ $student->nama }}</div>
                                    </td>
                                    <td>
                                        <div class="student-email">{{ $student->email }}</div>
                                    </td>
                                    <td>
                                        <span class="class-badge">{{ $student->kelas }}</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons-table">
                                            <a href="{{ route('admin.siswa.detail', $student->nis) }}"
                                                class="btn-action-table btn-view-table" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn-action-table btn-edit-table" title="Edit"
                                                data-bs-toggle="modal" data-bs-target="#editStudentModal"
                                                onclick="editStudent('{{ $student->nis }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action-table btn-delete-table" title="Hapus"
                                                data-bs-toggle="modal" data-bs-target="#deleteStudentModal"
                                                onclick="prepareDelete('{{ $student->nis }}', '{{ $student->nama }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($siswa instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="pagination-custom">
                        {{ $siswa->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===================================
            // Fix All Modal Backdrop Issues
            // ===================================
            function resetModalState(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.addEventListener('hidden.bs.modal', function() {
                        // Remove all modal backdrops
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(backdrop => backdrop.remove());

                        // Reset body styles
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';

                        // Reset form if exists
                        const form = this.querySelector('form');
                        if (form) {
                            form.reset();
                            form.querySelectorAll('.is-invalid').forEach(el => {
                                el.classList.remove('is-invalid');
                            });
                        }
                    });
                }
            }

            // Apply fix to all modals
            resetModalState('addStudentModal');
            resetModalState('editStudentModal');
            resetModalState('deleteStudentModal');
            resetModalState('importModal');

            // ===================================
            // Form Validation for Add Student
            // ===================================
            const addStudentForm = document.getElementById('addStudentForm');
            if (addStudentForm) {
                addStudentForm.addEventListener('submit', function(event) {
                    const password = document.getElementById('password');
                    const passwordConfirm = document.getElementById('password_confirmation');

                    // Check if passwords match
                    if (password && passwordConfirm && password.value !== passwordConfirm.value) {
                        event.preventDefault();
                        passwordConfirm.classList.add('is-invalid');

                        // Show error message
                        let errorDiv = passwordConfirm.nextElementSibling;
                        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv.textContent = 'Password tidak cocok!';
                        }

                        return false;
                    }

                    // Validate required fields
                    const requiredFields = ['nis', 'nama', 'email', 'kelas', 'password',
                        'password_confirmation'
                    ];
                    let isValid = true;

                    requiredFields.forEach(field => {
                        const input = document.getElementById(field);
                        if (input && !input.value.trim()) {
                            isValid = false;
                            input.classList.add('is-invalid');
                        } else if (input) {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        event.preventDefault();
                        alert('Harap isi semua kolom yang diperlukan.');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = document.getElementById('addSubmitBtn');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
                        submitBtn.disabled = true;
                    }
                });

                // Remove invalid class on input
                addStudentForm.querySelectorAll('input').forEach(input => {
                    input.addEventListener('input', function() {
                        this.classList.remove('is-invalid');
                    });
                });
            }

            // ===================================
            // Form Validation for Edit Student
            // ===================================
            const editStudentForm = document.getElementById('editStudentForm');
            if (editStudentForm) {
                editStudentForm.addEventListener('submit', function(event) {
                    const password = document.getElementById('edit_password');
                    const passwordConfirm = document.getElementById('edit_password_confirmation');

                    // Only validate password if it's filled
                    if (password && password.value && passwordConfirm && password.value !== passwordConfirm
                        .value) {
                        event.preventDefault();
                        passwordConfirm.classList.add('is-invalid');

                        let errorDiv = passwordConfirm.nextElementSibling;
                        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                            errorDiv.textContent = 'Password tidak cocok!';
                        }

                        return false;
                    }

                    // Show loading state
                    const submitBtn = document.getElementById('editSubmitBtn');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
                        submitBtn.disabled = true;
                    }
                });

                // Remove invalid class on input
                editStudentForm.querySelectorAll('input').forEach(input => {
                    input.addEventListener('input', function() {
                        this.classList.remove('is-invalid');
                    });
                });
            }

            // ===================================
            // Edit Student Function
            // ===================================
            window.editStudent = function(nis) {
                fetch(`/admin/siswa/${nis}/edit`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // Fill form fields
                        document.getElementById('edit_nis').value = data.nis || '';
                        document.getElementById('edit_original_nis').value = data.nis || '';
                        document.getElementById('edit_nama').value = data.nama || '';
                        document.getElementById('edit_email').value = data.email || '';
                        document.getElementById('edit_kelas').value = data.kelas || '';
                        document.getElementById('edit_password').value = '';
                        document.getElementById('edit_password_confirmation').value = '';

                        // Set form action
                        let url = window.location.origin + '/admin/siswa/' + data.nis;
                        document.getElementById('editStudentForm').action = url;

                        // Show modal
                        const modalElement = document.getElementById('editStudentModal');
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error fetching student data:', error);
                        alert('Gagal mengambil data siswa. Silakan coba lagi.');
                    });
            };

            // ===================================
            // Prepare Delete Student
            // ===================================
            window.prepareDelete = function(nis, nama) {
                document.getElementById('delete_nis').textContent = nis;
                document.getElementById('delete_nama').textContent = nama;

                let url = window.location.origin + '/admin/siswa/' + nis;
                document.getElementById('deleteStudentForm').action = url;
            };

            // ===================================
            // Delete Confirmation
            // ===================================
            const deleteForm = document.getElementById('deleteStudentForm');
            if (deleteForm) {
                deleteForm.addEventListener('submit', function() {
                    const submitBtn = document.getElementById('confirmDeleteBtn');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menghapus...';
                        submitBtn.disabled = true;
                    }
                });
            }

            // ===================================
            // Auto-hide alerts after 5 seconds
            // ===================================
            const alerts = document.querySelectorAll('.alert:not(.permanent)');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // ===================================
            // Table Row Hover Effect
            // ===================================
            const tableRows = document.querySelectorAll('.custom-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.01)';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });

        // ===================================
        // Toggle Password Visibility
        // ===================================
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                button.setAttribute('aria-label', 'Hide password');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                button.setAttribute('aria-label', 'Show password');
            }
        }

        // ===================================
        // Prevent Multiple Modal Backdrops
        // ===================================
        document.addEventListener('show.bs.modal', function() {
            // Remove any existing backdrops before showing new modal
            const existingBackdrops = document.querySelectorAll('.modal-backdrop');
            if (existingBackdrops.length > 1) {
                existingBackdrops.forEach((backdrop, index) => {
                    if (index < existingBackdrops.length - 1) {
                        backdrop.remove();
                    }
                });
            }
        });
    </script>
@endsection
