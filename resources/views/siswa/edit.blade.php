<!-- Modal Edit Siswa -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="editStudentForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content shadow-lg border-0 rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editStudentModalLabel">
                        <i class="fas fa-user-edit me-2"></i>Edit Data Siswa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body p-4">
                    <input type="hidden" id="edit_original_nis" name="original_nis">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_nis" class="form-label fw-semibold">NIS</label>
                            <input type="text" class="form-control" id="edit_nis" name="nis" placeholder="Masukkan NIS" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_nama" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" placeholder="Masukkan email" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_kelas" class="form-label fw-semibold">Kelas</label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                   id="edit_kelas" name="kelas" value="{{ old('kelas') }}" placeholder="Masukkan kelas" required>
                            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="mt-3 mb-2">

                        <div class="col-md-6">
                            <label for="edit_password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <div class="col-md-6">
                            <label for="edit_password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
