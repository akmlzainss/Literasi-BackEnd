<!-- Modal Edit Penghargaan -->
<div class="modal fade" id="modalEditPenghargaan" tabindex="-1" aria-labelledby="modalEditPenghargaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editPenghargaanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPenghargaanLabel">Edit Penghargaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">

                    {{-- Pilih Artikel --}}
                    <div class="mb-3">
                        <label for="edit_id_artikel" class="form-label">Pilih Artikel (Opsional)</label>
                        <select name="id_artikel" id="edit_id_artikel" class="form-control">
                            <option value="">-- Pilih Artikel --</option>
                        </select>
                        @error('id_artikel')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview Artikel --}}
                    <div class="mb-3" id="editArtikelInfo" style="display: none;">
                        <div class="card shadow-sm border-0" style="max-width: 500px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img id="edit_artikelFoto" src="" class="img-fluid rounded-start" alt="Artikel Image">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1" id="edit_artikelJudul"></h5>
                                        <p class="card-text mb-1"><strong>Penulis:</strong> <span id="edit_artikelPenulis"></span></p>
                                        <p class="card-text mb-1"><strong>Kelas:</strong> <span id="edit_artikelKelas"></span></p>
                                        <p class="card-text mb-1">
                                            <strong>Rating:</strong> <span id="edit_artikelRating"></span>
                                            <span id="edit_artikelStars" class="ms-2"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btnEdit');
    const artikelSelect = document.getElementById('edit_id_artikel');
    const artikelInfo = document.getElementById('editArtikelInfo');
    const artikelFoto = document.getElementById('edit_artikelFoto');
    const artikelJudul = document.getElementById('edit_artikelJudul');
    const artikelPenulis = document.getElementById('edit_artikelPenulis');
    const artikelKelas = document.getElementById('edit_artikelKelas');
    const artikelRating = document.getElementById('edit_artikelRating');
    const artikelStars = document.getElementById('edit_artikelStars');
    const deskripsi = document.getElementById('edit_deskripsi_penghargaan');

    // Event tombol edit
    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            fetch(`/penghargaan/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                const p = data.penghargaan;
                const artikel = data.artikel;

                // set form
                document.getElementById('edit_id').value = p.id;
                document.getElementById('edit_jenis').value = p.jenis;
                document.getElementById('edit_bulan_tahun').value = p.bulan_tahun;
                deskripsi.value = p.deskripsi_penghargaan;

                // isi dropdown artikel
                artikelSelect.innerHTML = '<option value="">-- Pilih Artikel --</option>';
                artikel.forEach(a => {
                    let option = document.createElement('option');
                    option.value = a.id;
                    option.setAttribute('data-judul', a.judul);
                    option.setAttribute('data-nama', a.siswa_nama ?? 'Unknown');
                    option.setAttribute('data-kelas', a.siswa_kelas ?? '-');
                    option.setAttribute('data-foto', a.gambar); // gambar sudah full URL dari controller
                    option.setAttribute('data-rating', a.rating);
                    option.innerText = a.judul + ' (Rating: ' + (a.rating ?? 'N/A') + ')';

                    if(p.id_artikel == a.id) option.selected = true;
                    artikelSelect.appendChild(option);
                });

                // trigger change untuk tampil preview
                artikelSelect.dispatchEvent(new Event('change'));

                // buka modal
                const modal = new bootstrap.Modal(document.getElementById('modalEditPenghargaan'));
                modal.show();
            });
        });
    });

    // Preview saat pilih artikel
    artikelSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            artikelInfo.style.display = 'block';
            artikelFoto.src = selected.dataset.foto;
            artikelJudul.textContent = selected.dataset.judul;
            artikelPenulis.textContent = selected.dataset.nama;
            artikelKelas.textContent = selected.dataset.kelas;
            artikelRating.textContent = selected.dataset.rating;

            let rating = parseFloat(selected.dataset.rating) || 0;
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += (i <= rating) ? '⭐' : '☆';
            }
            artikelStars.innerHTML = starsHtml;

            // auto isi deskripsi jika kosong
            if (!deskripsi.value.trim()) {
                deskripsi.value = "Penghargaan untuk artikel: " + selected.dataset.judul;
            }
        } else {
            artikelInfo.style.display = 'none';
            artikelFoto.src = '';
            artikelJudul.textContent = '';
            artikelPenulis.textContent = '';
            artikelKelas.textContent = '';
            artikelRating.textContent = '';
            artikelStars.innerHTML = '';
        }
    });
});
</script>
