<!-- Modal Tambah Siswa -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="addStudentModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Tambah Siswa Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form id="addStudentForm" action="{{ route('admin.siswa.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- NIS -->
                        <div class="col-md-6">
                            <label for="nis" class="form-label fw-semibold">
                                <i class="fas fa-id-card me-2 text-primary"></i>NIS <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nis') is-invalid @enderror"
                                   id="nis" 
                                   name="nis" 
                                   placeholder="Masukkan NIS" 
                                   value="{{ old('nis') }}" 
                                   required>
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">NIS wajib diisi</div>
                            @enderror
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" 
                                   name="nama" 
                                   placeholder="Masukkan nama lengkap" 
                                   value="{{ old('nama') }}" 
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Nama lengkap wajib diisi</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email" 
                                   name="email" 
                                   placeholder="Masukkan email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Email valid wajib diisi</div>
                            @enderror
                        </div>

                        <!-- Kelas -->
                        <div class="col-md-6">
                            <label for="kelas" class="form-label fw-semibold">
                                <i class="fas fa-school me-2 text-primary"></i>Kelas <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('kelas') is-invalid @enderror"
                                   id="kelas" 
                                   name="kelas" 
                                   placeholder="Masukkan kelas (contoh: X RPL 1)" 
                                   value="{{ old('kelas') }}" 
                                   required>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Kelas wajib diisi</div>
                            @enderror
                        </div>

                        <!-- Divider -->
                        <div class="col-12">
                            <hr class="my-3">
                            <p class="text-muted small mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Password harus minimal 6 karakter
                            </p>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password" 
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePasswordVisibility('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Password wajib diisi (min. 6 karakter)</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password" 
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePasswordVisibility('password_confirmation', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Konfirmasi password tidak cocok</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="addSubmitBtn">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fix Modal Backdrop Issue for Add Modal
document.addEventListener('DOMContentLoaded', function() {
    const addModal = document.getElementById('addStudentModal');
    
    if (addModal) {
        // Reset modal state when hidden
        addModal.addEventListener('hidden.bs.modal', function () {
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
        const addForm = document.getElementById('addStudentForm');
        if (addForm) {
            addForm.addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirmation').value;
                
                // Validate password match
                if (password !== passwordConfirm) {
                    e.preventDefault();
                    document.getElementById('password_confirmation').classList.add('is-invalid');
                    document.getElementById('password_confirmation').nextElementSibling.textContent = 'Password tidak cocok';
                    return false;
                }
                
                // Show loading
                const submitBtn = document.getElementById('addSubmitBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
                submitBtn.disabled = true;
            });
        }
    }
});
</script>