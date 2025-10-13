
    <!-- Modal Ubah Password -->
    <div class="modal fade modal-modern" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profil.update-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label form-label-modern">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control form-control-modern"
                                required>
                            @error('password_lama')
                                <div class="text-danger mt-2 small">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label form-label-modern">Password Baru</label>
                            <input type="password" name="password" class="form-control form-control-modern" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label form-label-modern">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-modern"
                                required>
                            @error('password')
                                <div class="text-danger mt-2 small">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-shield-check me-2"></i>Simpan Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>