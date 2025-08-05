@extends('layouts.app')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Detail Siswa</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th scope="row">NIS</th>
                    <td>{{ $siswa->nis }}</td>
                </tr>
                <tr>
                    <th scope="row">Nama Lengkap</th>
                    <td>{{ $siswa->nama }}</td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>{{ $siswa->email }}</td>
                </tr>
                <tr>
                    <th scope="row">password</th>
                    <td>{{ $siswa->password }}</td>
                </tr>
                <tr>
                    <th scope="row">Kelas</th>
                    <td>{{ $siswa->kelas }}</td>
                </tr>
            </table>

            <a href="{{ route('siswa') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</div>
@endsection
