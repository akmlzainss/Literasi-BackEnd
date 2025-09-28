@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('content')
    <style>
        .detail-content {
            padding: 20px;
            background: #f0f7ff; /* biru muda background */
            border-radius: 12px;
            border: 1px solid #cce0ff;
        }

        .detail-content h3 {
            color: #1e40af; /* biru tua */
            font-weight: bold;
            margin-bottom: 10px;
        }

        .detail-content p {
            font-size: 16px;
            color: #334155;
        }

        .detail-content strong {
            color: #2563eb; /* biru */
        }

        .detail-content h4 {
            margin-top: 20px;
            color: #2563eb;
            font-weight: 600;
        }

        .detail-content ul {
            list-style-type: disc;
            padding-left: 25px;
        }

        .detail-content ul li {
            margin-bottom: 6px;
            color: #1e3a8a; /* biru lebih gelap */
        }

        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
    </style>

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