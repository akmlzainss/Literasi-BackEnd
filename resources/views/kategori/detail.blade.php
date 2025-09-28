@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('content')
    <link rel="stylesheet" href="css/kategori.css">
    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-info-circle me-2"></i>Detail Kategori
            </div>
        </div>
        <div class="card-body-custom">
            <div class="detail-content">
                <h3>{{ $kategori->nama }}</h3>
                <p><strong>Deskripsi:</strong> {{ $kategori->deskripsi }}</p>
                <h4>Artikel yang Menggunakan Kategori Ini:</h4>
                @if ($kategori->artikel->isEmpty())
                    <p>Tidak ada artikel yang terkait dengan kategori ini.</p>
                @else
                    <ul>
                        @foreach ($kategori->artikel as $artikel)
                            <li>{{ $artikel->judul }} (ID: {{ $artikel->id }})</li>
                        @endforeach
                    </ul>
                @endif
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-primary mt-3">Kembali ke Daftar Kategori</a>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .detail-content {
            padding: 20px;
        }
        .detail-content h3 {
            color: #2563eb;
        }
        .detail-content ul {
            list-style-type: disc;
            padding-left: 20px;
        }
    </style>
@endsection