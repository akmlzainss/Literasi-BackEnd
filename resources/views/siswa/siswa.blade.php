@extends('layouts.app')

@section('title', 'Kelola Siswa')
@section('page-title', 'Kelola Siswa')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">

    <!-- Notifikasi Flash -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Halaman -->
    <div class="page-header">
        <h1 class="page-title">Kelola Siswa</h1>
        <p class="page-subtitle">Kelola dan pantau data siswa beserta prestasi dan aktivitas literasi akhlak mereka</p>

        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fas fa-user-plus"></i> Tambah Siswa Baru
            </button>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-download"></i> Import Data
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-file-export"></i> Export Data
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-award"></i> Kelola Prestasi
            </a>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Tambah Siswa Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm" action="{{ route('siswa.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nis" class="form-label">NIS</label>
                                    <input type="text" class="form-control @error('nis') is-invalid @enderror"
                                        id="nis" name="nis" placeholder="Masukkan NIS" value="{{ old('nis') }}"
                                        required>
                                    @error('nis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" placeholder="Masukkan Nama Lengkap"
                                        value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan Email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select class="form-control @error('kelas') is-invalid @enderror"
                                        id="kelas" name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                                        <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                                    </select>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan Password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Konfirmasi Password" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="addStudentForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editStudentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStudentModalLabel">Edit Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_original_nis" name="original_nis">
                        <div class="mb-3">
                            <label for="edit_nis" class="form-label">NIS</label>
                            <input type="text" class="form-control" id="edit_nis" name="nis" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kelas" class="form-label">Kelas</label>
                            <select class="form-control" id="edit_kelas" name="kelas" required>
                                <option value="">Pilih Kelas</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="edit_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="edit_password_confirmation"
                                name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus Siswa -->
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteStudentForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteStudentModalLabel">Hapus Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus siswa <strong id="delete_nama"></strong> (NIS: <span
                                id="delete_nis"></span>)?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Card: Students Table -->
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
            <!-- Search and Filter Section -->
            <div class="search-filter-section mb-4">
                <form action="{{ route('siswa') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <!-- Pencarian -->
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

                        <!-- Filter Kelas -->
                        <div class="col-md-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-filter text-muted"></i>
                                </span>
                                <select class="form-control border-start-0 filter-input" name="kelas" id="kelas">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach ($kelasOptions as $kelas)
                                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                            {{ $kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Filter Awalan Nama -->
                       

                        <!-- Sorting -->
                        <div class="col-md-3">
                            <label for="sort" class="form-label">Urutkan Nama</label>
                            <select class="form-control" name="sort" id="sort">
                                <option value="">-- Default (Tanggal) --</option>
                                <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>A-Z</option>
                                <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Z-A</option>
                            </select>
                        </div>

                        <!-- Tombol -->
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('siswa') }}" class="btn btn-outline-success flex-fill">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Students Table -->
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
                                            <a href="{{ route('siswa.detail', $student->nis) }}"
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
                                    <td colspan="6" class="text-center">Belum ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($siswa instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="pagination-custom">
                        {{ $siswa->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap dan jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Validasi Form Tambah
            const addStudentForm = document.getElementById('addStudentForm');
            if (addStudentForm) {
                addStudentForm.addEventListener('submit', function (event) {
                    const requiredFields = ['nis', 'nama', 'email', 'kelas', 'password', 'password_confirmation'];
                    let isValid = true;

                    requiredFields.forEach(function (id) {
                        const input = document.getElementById(id);
                        if (!input || !input.value.trim()) {
                            isValid = false;
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        event.preventDefault();
                        alert('Harap isi semua kolom yang diperlukan.');
                    }
                });
            }

            // Fungsi untuk mengisi form edit siswa
            window.editStudent = function (nis) {
                fetch(`/siswa/${nis}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // Isi form edit
                        document.getElementById('edit_nis').value = data.nis;
                        document.getElementById('edit_nama').value = data.nama;
                        document.getElementById('edit_email').value = data.email;
                        document.getElementById('edit_kelas').value = data.kelas;
                        document.getElementById('edit_password').value = '';
                        document.getElementById('edit_password_confirmation').value = '';

                        // Ubah action form sesuai nis
                        const form = document.getElementById('editStudentForm');
                        form.action = `/siswa/${data.nis}`;
                    })
                    .catch(error => {
                        console.error('Gagal mengambil data siswa:', error);
                        alert('Gagal mengambil data siswa.');
                    });
            };

            // Fungsi untuk menyiapkan form hapus
            window.prepareDelete = function (nis, nama) {
                document.getElementById('delete_nis').textContent = nis;
                document.getElementById('delete_nama').textContent = nama;
                const deleteForm = document.getElementById('deleteStudentForm');
                deleteForm.action = `/siswa/${nis}`;
            };
        });
    </script>
@endsection