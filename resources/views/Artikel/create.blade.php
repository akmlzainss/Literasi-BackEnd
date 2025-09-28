@extends('layouts.app')

@section('title', 'Tambah Artikel')
@section('page-title', 'Tambah Artikel Baru')

@section('content')
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="main-card">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <i class="fas fa-plus me-2"></i> Form Tambah Artikel
                    </div>

                    <!-- Card Body -->
                    <div class="card-body-custom">
                        <!-- Error and Success Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" id="create-artikel-form" novalidate>
                            @csrf

                            <!-- Article Title -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
                            </div>

                            <!-- Article Content -->
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                                <textarea name="isi" id="tambah_isi" class="form-control" rows="10" required>{{ old('isi') }}</textarea>
                                <div id="charCount" class="text-muted mt-1" style="font-size: 0.9em;">0/3000</div>
                            </div>

                            <!-- Article Image -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar (opsional)</label>
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                            </div>

                            <!-- Category Selection -->
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="id_kategori" id="id_kategori" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach (\App\Models\Kategori::all() as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Author Type Selection -->
                            <div class="mb-3">
                                <label class="form-label">Penulis Artikel <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="penulis_type" id="penulis_admin" value="admin" {{ old('penulis_type', 'admin') == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="penulis_admin">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="penulis_type" id="penulis_siswa" value="siswa" {{ old('penulis_type') == 'siswa' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="penulis_siswa">Siswa</label>
                                </div>
                            </div>

                            <!-- Student Fields (Conditional) -->
                            <div id="siswa-fields" class="row {{ old('penulis_type') == 'siswa' ? '' : 'd-none' }}">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="id_siswa" class="form-label">Cari Nama Siswa <span class="text-danger">*</span></label>
                                        <select name="id_siswa" id="id_siswa" class="form-control select2" style="width: 100%;">
                                            @if (old('id_siswa'))
                                                <option value="{{ old('id_siswa') }}" selected>
                                                    {{ \App\Models\Siswa::find(old('id_siswa'))->nama ?? 'Siswa Tidak Ditemukan' }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="kelas_siswa" class="form-label">Kelas</label>
                                        <input type="text" id="kelas_siswa" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Article Type -->
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                                <select name="jenis" id="jenis" class="form-select" required>
                                    <option value="bebas" {{ old('jenis') == 'bebas' ? 'selected' : '' }}>Bebas</option>
                                    <option value="resensi_buku" {{ old('jenis') == 'resensi_buku' ? 'selected' : '' }}>Resensi Buku</option>
                                    <option value="resensi_film" {{ old('jenis') == 'resensi_film' ? 'selected' : '' }}>Resensi Film</option>
                                    <option value="video" {{ old('jenis') == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                            </div>

                            <!-- Article Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="menunggu" {{ old('status', 'menunggu') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="draf" {{ old('status') == 'draf' ? 'selected' : '' }}>Draf</option>
                                    <option value="disetujui" {{ old('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <!-- Initial Rating (optional) -->
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating Awal (opsional)</label>
                                <select name="rating" id="rating" class="form-select">
                                    <option value="">Belum ada</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>⭐ {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Form Actions -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">Simpan Artikel</button>
                                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- External Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4xazwn7uf3t198xvx4jq99bmdaj364wz6x88joubmdqdtlrn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize TinyMCE Editor
            tinymce.init({
                selector: '#tambah_isi',
                height: 500,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                setup: function (editor) {
                    const updateCharCount = () => {
                        const charCount = editor.getContent({ format: 'text' }).length;
                        $('#charCount').text(`${charCount}/3000`);
                        $('#charCount').css('color', charCount > 3000 ? 'red' : 'inherit');
                    };

                    editor.on('keydown', function (e) {
                        const charCount = editor.getContent({ format: 'text' }).length;
                        if (charCount >= 3000 && e.keyCode !== 8 && e.keyCode !== 46) {
                            e.preventDefault();
                        }
                    });

                    editor.on('input change', updateCharCount);
                    editor.on('init', updateCharCount);
                }
            });

            // Initialize Select2 for Student Search
            $('#id_siswa').select2({
                placeholder: 'Ketik nama atau NIS siswa',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.search.siswa') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data,
                            pagination: {
                                more: data.length === 10
                            }
                        };
                    },
                    cache: true
                }
            });

            // Handle Author Type Radio Button
            $('input[name="penulis_type"]').change(function () {
                const isSiswa = this.value === 'siswa';
                $('#siswa-fields').toggleClass('d-none', !isSiswa);
                $('#id_siswa').prop('required', isSiswa).val(null).trigger('change');
                $('#kelas_siswa').val('');
            });

            // Update Student Class on Selection
            $('#id_siswa').on('select2:select', function (e) {
                const data = e.params.data;
                $('#kelas_siswa').val(data.kelas || '-');
            });

            // Trigger TinyMCE Save on Form Submit
            $('#create-artikel-form').on('submit', function () {
                tinymce.triggerSave();
            });

            // Restore Form State
            if ('{{ old('penulis_type') }}' === 'siswa') {
                $('#siswa-fields').removeClass('d-none');
                $('#id_siswa').prop('required', true);
            }
        });
    </script>
@endsection