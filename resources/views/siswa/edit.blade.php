<!-- Modal Edit Siswa -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="editStudentModalLabel">
                    <i class="fas fa-user-edit me-2"></i>Edit Data Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form id="editStudentForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body p-4">
                    <input type="hidden" id="edit_original_nis" name="original_nis">

                    <div class="row g-3">
                        <!-- NIS -->
                        <div class="col-md-6">
                            <label for="edit_nis" class="form-label fw-semibold">
                                <i class="fas fa-id-card me-2 text-primary"></i>NIS <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_nis" 
                                   name="nis" 
                                   placeholder="Masukkan NIS" 
                                   required>
                            <div class="invalid-feedback">NIS wajib diisi</div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="col-md-6">
                            <label for="edit_nama" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_nama" 
                                   name="nama" 
                                   placeholder="Masukkan nama lengkap" 
                                   required>
                            <div class="invalid-feedback">Nama lengkap wajib diisi</div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="edit_email" 
                                   name="email" 
                                   placeholder="Masukkan email" 
                                   required>
                            <div class="invalid-feedback">Email valid wajib diisi</div>
                        </div>

                        <!-- Kelas -->
                        <div class="col-md-6">
                            <label for="edit_kelas" class="form-label fw-semibold">
                                <i class="fas fa-school me-2 text-primary"></i>Kelas <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_kelas" 
                                   name="kelas" 
                                   placeholder="Masukkan kelas" 
                                   required>
                            <div class="invalid-feedback">Kelas wajib diisi</div>
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <hr class="my-3">
                            <p class="text-muted small mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Kosongkan password jika tidak ingin mengubahnya
                            </p>
                        </div>

                        <!-- Password Baru -->
                        <div class="col-md-6">
                            <label for="edit_password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="edit_password" 
                                       name="password" 
                                       placeholder="Kosongkan jika tidak diubah">
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePasswordVisibility('edit_password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">Minimal 6 karakter</div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6">
                            <label for="edit_password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="edit_password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password baru">
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePasswordVisibility('edit_password_confirmation', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Password tidak cocok</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="editSubmitBtn">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Fix Modal Backdrop Issue
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editStudentModal');
    
    if (editModal) {
        // Reset modal state when hidden
        editModal.addEventListener('hidden.bs.modal', function () {
            // Remove all backdrops
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            // Reset body
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            // Reset form
            this.querySelector('form').reset();
            this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        });
        
        // Form validation
        const editForm = document.getElementById('editStudentForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const password = document.getElementById('edit_password').value;
                const passwordConfirm = document.getElementById('edit_password_confirmation').value;
                
                // Validate password match if password is filled
                if (password && password !== passwordConfirm) {
                    document.getElementById('edit_password_confirmation').classList.add('is-invalid');
                    return false;
                }
                
                // Show loading
                const submitBtn = document.getElementById('editSubmitBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
                submitBtn.disabled = true;
                
                // Submit form
                this.submit();
            });
        }
    }
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
}

.modal-content {
    border: none !important;
    overflow: hidden;
}

.modal-header {
    border-bottom: none;
    padding: 1.5rem 2rem;
}

.modal-body {
    max-height: calc(100vh - 250px);
    overflow-y: auto;
}

.modal-footer {
    border-top: 1px solid #e2e8f0;
    padding: 1rem 2rem;
}

.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
}

.input-group .btn-outline-secondary {
    border-color: #e2e8f0;
}

.input-group .btn-outline-secondary:hover {
    background-color: #f8fafc;
    border-color: #2563eb;
    color: #2563eb;
}

/* Smooth modal transitions */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: none;
}
</style>