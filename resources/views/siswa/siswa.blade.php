@extends('layouts.app')

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

    @include('siswa.modal_import')
    @include('siswa.edit')
    @include('siswa.create')

    <!-- Delete Student Modal -->
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-warning-modal">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteStudentModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <input type="text" class="form-control border-start-0 filter-input"
                                       name="kelas" id="kelas_filter"
                                       value="{{ request('kelas') ?? '' }}"
                                       placeholder="Masukkan kelas">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="sort" class="form-label">Urutkan Nama</label>
                            <select class="form-control" name="sort" id="sort">
                                <option value="">-- Default (Tanggal) --</option>
                                <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>A-Z</option>
                                <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Z-A</option>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Form Validation for Add Student
            const addStudentForm = document.getElementById('addStudentForm');
            if (addStudentForm) {
                addStudentForm.addEventListener('submit', function (event) {
                    const requiredFields = ['nis', 'nama', 'email', 'kelas', 'password', 'password_confirmation'];
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
                    }
                });
            }

            // Edit Student
            window.editStudent = function (nis) {
                fetch(`/admin/siswa/${nis}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        document.getElementById('edit_nis').value = data.nis;
                        document.getElementById('edit_original_nis').value = data.nis;
                        document.getElementById('edit_nama').value = data.nama;
                        document.getElementById('edit_email').value = data.email;
                        document.getElementById('edit_kelas').value = data.kelas;
                        document.getElementById('edit_password').value = '';
                        document.getElementById('edit_password_confirmation').value = '';

                        let url = "{{ route('admin.siswa.update', ':nis') }}";
                        url = url.replace(':nis', data.nis);
                        document.getElementById('editStudentForm').action = url;

                        const modal = new bootstrap.Modal(document.getElementById('editStudentModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Gagal mengambil data siswa:', error);
                        alert('Gagal mengambil data siswa.');
                    });
            };

            // Prepare Delete Student
            window.prepareDelete = function (nis, nama) {
                document.getElementById('delete_nis').textContent = nis;
                document.getElementById('delete_nama').textContent = nama;

                let url = "{{ route('admin.siswa.destroy', ':nis') }}";
                url = url.replace(':nis', nis);
                document.getElementById('deleteStudentForm').action = url;
            };
        });
    </script>
@endsection