@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informasi Detail Kategori</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th scope="row">Nama Kategori</th>
                    <td>{{ $kategori->nama }}</td>
                </tr>
                <tr>
                    <th scope="row">Deskripsi</th>
                    <td>{{ $kategori->deskripsi }}</td>
                </tr>
                <tr>
                    <th scope="row">Artikel Terkait</th>
                    <td>
                        @if ($kategori->artikel->isEmpty())
                            <span class="text-muted">Tidak ada artikel terkait.</span>
                        @else
                            <ul class="mb-0">
                                @foreach ($kategori->artikel as $artikel)
                                    <li>{{ $artikel->judul }} (ID: {{ $artikel->id }})</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
            </table>

            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</div>
@endsection
