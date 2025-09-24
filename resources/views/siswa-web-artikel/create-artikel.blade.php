@extends('layouts.layouts')

@section('title', 'Tulis Artikel Baru - SiPena')

@section('body_class', 'dashboard-page')

@section('content')
<main class="container my-4">
    <section class="content-section">
        <a href="{{ route('artikel-siswa.upload') }}" class="btn-kembali mb-4">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Pilihan Upload
        </a>
        <h2 class="section-title">Form Tulis Artikel</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('artikel-siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <label for="judul" class="form-label fw-bold fs-5">Judul Artikel</label>
                        <input type="text" name="judul" id="judul" class="form-control form-control-lg" value="{{ old('judul') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi_artikel" class="form-label fw-bold fs-5">Isi Artikel</label>
                        <textarea name="isi" id="isi_artikel" class="form-control" rows="18">{{ old('isi') }}</textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-3 border rounded-3 bg-light sticky-top" style="top: 100px;">
                        <h4 class="mb-3">Pengaturan</h4>
                        <div class="mb-3">
                            <label for="gambar" class="form-label fw-semibold">Gambar Utama (Opsional)</label>
                            <input type="file" name="gambar" id="gambar" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label fw-semibold">Jenis Tulisan</label>
                            <select name="jenis" id="jenis" class="form-select" required>
                                <option value="bebas" selected>Bebas</option>
                                <option value="resensi_buku">Resensi Buku</option>
                                <option value="resensi_film">Resensi Film</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label fw-semibold">Pilih Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="form-select">
                                <option value="">Pilih yang sudah ada...</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="usulan_kategori" class="form-label fw-semibold">Atau Usulkan Kategori Baru</label>
                            <input type="text" name="usulan_kategori" id="usulan_kategori" class="form-control" placeholder="Contoh: Teknologi" value="{{ old('usulan_kategori') }}">
                            <small class="form-text text-muted">Isi salah satu: pilih kategori atau usulkan baru.</small>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary fw-bold btn-lg">Kirim untuk Direview</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection

@section('scripts')
{{-- Menggunakan jQuery dan TinyMCE versi 5 seperti di admin --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.tiny.cloud/1/4xazwn7uf3t198xvx4jq99bmdaj364wz6x88joubmdqdtlrn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    $(document).ready(function () {
        tinymce.init({
            selector: 'textarea#isi_artikel',
            height: 500,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        });
        
        // Simpan isi TinyMCE ke textarea sebelum form disubmit
        $('form').on('submit', function () {
            tinymce.triggerSave();
        });
    });
</script>
@endsection