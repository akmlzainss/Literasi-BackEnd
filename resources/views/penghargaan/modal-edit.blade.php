<div class="modal fade" id="editPenghargaanModal" tabindex="-1" aria-labelledby="editPenghargaanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editPenghargaanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editPenghargaanModalLabel">Edit Penghargaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="type" id="edit_type">

                    {{-- Konten Pilihan (Artikel/Video) --}}
                    <div class="mb-3">
                        <label for="edit_id_item" class="form-label" id="editItemLabel">Pilih Konten</label>
                        <select name="id_item" id="edit_id_item" class="form-control">
                            <option value="">-- Pilih Konten --</option>
                            {{-- Opsi akan diisi oleh JavaScript --}}
                        </select>
                    </div>

                    {{-- Siswa (Otomatis terisi) --}}
                    <div class="mb-3">
                        <label for="edit_nama_siswa" class="form-label">Siswa</label>
                        <input type="text" id="edit_nama_siswa" class="form-control" readonly>
                        <input type="hidden" name="id_siswa" id="edit_id_siswa">
                    </div>
                    
                    {{-- Bulan & Tahun --}}
                    <div class="mb-3">
                        <label for="edit_bulan_tahun" class="form-label">Bulan dan Tahun</label>
                        <input type="date" name="bulan_tahun" id="edit_bulan_tahun" class="form-control" required>
                    </div>

                    {{-- Jenis --}}
                    <div class="mb-3">
                        <label for="edit_jenis" class="form-label">Jenis Penghargaan</label>
                        <select name="jenis" id="edit_jenis" class="form-control" required>
                            <option value="bulanan">Bulanan</option>
                            <option value="spesial">Spesial</option>
                        </select>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label for="edit_deskripsi_penghargaan" class="form-label">Deskripsi Penghargaan</label>
                        <textarea name="deskripsi_penghargaan" id="edit_deskripsi_penghargaan" class="form-control" rows="4" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Perbarui Penghargaan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>