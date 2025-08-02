@php
    $kategori = $kategori ?? null;
@endphp

@if ($kategori)
    <input type="hidden" name="id" value="{{ $kategori->id }}">
    <div class="mb-3">
        <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
        <input type="text" name="nama" id="edit_nama_kategori" class="form-control" value="{{ $kategori->nama }}" required>
    </div>
    <div class="mb-3">
        <label for="edit_deskripsi" class="form-label">Deskripsi Kategori (opsional)</label>
        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="4">{{ $kategori->deskripsi }}</textarea>
    </div>
@else
    <p>Data tidak ditemukan.</p>
@endif