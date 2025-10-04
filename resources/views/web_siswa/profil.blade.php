@extends('layouts.layouts')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Profil -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <img src="{{ $siswa->foto_profil ? asset('storage/' . $siswa->foto_profil) : 'https://via.placeholder.com/150' }}" 
                         alt="Foto Profil"
                         class="rounded-circle img-fluid mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                    <h5 class="my-3">{{ $siswa->nama }}</h5>
                    <p class="text-muted mb-1">{{ $siswa->kelas }}</p>
                    <p class="text-muted mb-4">{{ $siswa->email }}</p>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Ubah Password</h5>
                    <form action="{{ route('profil.update-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="password_lama" class="form-label">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control" required>
                            @error('password_lama') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                            @error('password') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Password</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-4">Edit Detail Profil</h5>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">Nama Lengkap</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" value="{{ old('email', $siswa->email) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">Kelas</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <p class="mb-0">Foto Profil</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="file" name="foto_profil" class="form-control">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- Tabs: Video & Artikel yang Disukai/Disimpan -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="profilTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="video-like-tab" data-bs-toggle="tab" data-bs-target="#video-like" type="button" role="tab">
                                Video Disukai
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="video-bookmark-tab" data-bs-toggle="tab" data-bs-target="#video-bookmark" type="button" role="tab">
                                Video Disimpan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="artikel-like-tab" data-bs-toggle="tab" data-bs-target="#artikel-like" type="button" role="tab">
                                Artikel Disukai
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Video Disukai -->
                        <div class="tab-pane fade show active" id="video-like" role="tabpanel">
                            @forelse($videoDisukai as $video)
                                <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                    <img src="{{ asset('storage/' . $video->thumbnail_path) }}" width="100" class="me-3 rounded">
                                    <div>
                                        <h6 class="mb-1">{{ $video->judul }}</h6>
                                        <small class="text-muted">{{ Str::limit($video->deskripsi, 80) }}</small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Belum ada video yang disukai.</p>
                            @endforelse
                        </div>

<!-- Video Disimpan -->
<div class="tab-pane fade" id="video-bookmark" role="tabpanel">
    @forelse($videoDisimpan as $video)
        <div class="d-flex align-items-center mb-3 border-bottom pb-2">
            <img src="{{ asset('storage/' . $video->thumbnail_path) }}" width="100" class="me-3 rounded">
            <div>
                <h6 class="mb-1">{{ $video->judul }}</h6>
                <small class="text-muted">{{ Str::limit($video->deskripsi, 80) }}</small>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada video yang disimpan.</p>
    @endforelse
</div>

                        <!-- Artikel Disukai -->
                        <div class="tab-pane fade" id="artikel-like" role="tabpanel">
                            @forelse($artikelDisukai as $artikel)
                                <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://via.placeholder.com/100' }}" width="100" class="me-3 rounded">
                                    <div>
                                        <h6 class="mb-1">{{ $artikel->judul }}</h6>
                                        <small class="text-muted">{{ Str::limit(strip_tags($artikel->isi), 80) }}</small>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Belum ada artikel yang disukai.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- col-lg-8 -->
    </div>
</div>
@endsection
