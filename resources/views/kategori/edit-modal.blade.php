<!-- Modal Edit Kategori -->
<div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <form id="editForm" action="" method="POST">
        @method('PUT')
        @csrf

        @if ($errors->any())
          <div class="alert alert-danger m-3">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if (session('success'))
          <div class="alert alert-success m-3">
            {{ session('success') }}
          </div>
        @endif

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalEditKategoriLabel">Edit Kategori</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>

        <div class="modal-body text-center">
          <input type="hidden" name="id" id="editId">

          <div class="mb-3 text-start">
            <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
            <input 
              type="text" 
              name="nama" 
              id="edit_nama_kategori" 
              class="form-control @error('nama') is-invalid @enderror" 
              value="" 
              required
            >
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 text-start">
            <label for="edit_deskripsi" class="form-label">Deskripsi Kategori (opsional)</label>
            <textarea 
              name="deskripsi" 
              id="edit_deskripsi" 
              class="form-control @error('deskripsi') is-invalid @enderror" 
              rows="4"
            ></textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
