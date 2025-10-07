<!-- Modal Tambah Siswa -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addStudentModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Tambah Siswa Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form id="addStudentForm" action="{{ route('admin.siswa.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nis" class="form-label fw-semibold">NIS</label>
                            <input type="text" class="form-control @error('nis') is-invalid @enderror"
                                   id="nis" name="nis" placeholder="Masukkan NIS" value="{{ old('nis') }}" required>
                            @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" name="nama" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kelas" class="form-label fw-semibold">Kelas</label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                   id="kelas" name="kelas" placeholder="Masukkan kelas" value="{{ old('kelas') }}" required>
                            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" placeholder="Masukkan password" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                   id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                            @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
