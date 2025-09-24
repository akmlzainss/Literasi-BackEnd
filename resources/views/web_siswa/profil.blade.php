@extends('layouts.layouts')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <img src="{{ $siswa->foto_profil ? asset('storage/' . $siswa->foto_profil) : 'https://via.placeholder.com/150' }}" alt="Foto Profil"
                        class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h5 class="my-3">{{ $siswa->nama }}</h5>
                    <p class="text-muted mb-1">{{ $siswa->kelas }}</p>
                    <p class="text-muted mb-4">{{ $siswa->email }}</p>
                </div>
            </div>

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

        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-4">Edit Detail Profil</h5>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Nama Lengkap</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" value="{{ old('email', $siswa->email) }}">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Kelas</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas) }}">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Foto Profil</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="file" name="foto_profil" class="form-control">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection