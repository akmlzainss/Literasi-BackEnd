<!-- Modal Edit Profil -->
    <div class="modal fade modal-modern" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if (session('success'))
                        <div class="alert alert-success rounded-3 border-0" style="background: #e8f5e9;">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label form-label-modern">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control form-control-modern"
                                value="{{ old('nama', $siswa->nama) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label form-label-modern">Email</label>
                            <input type="email" name="email" class="form-control form-control-modern"
                                value="{{ old('email', $siswa->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label form-label-modern">Kelas</label>
                            <input type="text" name="kelas" class="form-control form-control-modern"
                                value="{{ old('kelas', $siswa->kelas) }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label form-label-modern">Foto Profil</label>
                            <input type="file" name="foto_profil" class="form-control form-control-modern"
                                accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                        </div>
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>