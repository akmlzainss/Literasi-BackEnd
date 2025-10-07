@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('content')
    <style>
        .card-header-custom {
            background-color: #2563eb;
            color: #fff;
            font-weight: 600;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
        }

        .card-header-custom i {
            margin-right: 8px;
        }

        .card-body-custom {
            background-color: #f8fbff;
            border: 1px solid #dbeafe;
            border-top: none;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 25px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table th {
            width: 25%;
            text-align: left;
            padding: 10px;
            color: #1e40af;
            font-weight: 600;
            background-color: #e0efff;
            border-bottom: 1px solid #dbeafe;
        }

        .detail-table td {
            padding: 10px;
            color: #334155;
            background-color: #f9fbff;
            border-bottom: 1px solid #dbeafe;
        }

        .artikel-list {
            background: #f1f5ff;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #dbeafe;
        }

        .artikel-list li {
            margin-bottom: 6px;
            color: #1e3a8a;
        }

        .btn-primary-custom {
            background-color: #2563eb;
            border-color: #2563eb;
            color: white;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 18px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            transform: translateY(-2px);
        }
    </style>

    <div class="main-card shadow-sm">
        <div class="card-header-custom">
            <i class="fas fa-info-circle"></i> Detail Kategori
        </div>

        <div class="card-body-custom">
            <table class="detail-table">
                <tr>
                    <th>Nama Kategori</th>
                    <td>{{ $kategori->nama }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $kategori->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Artikel Terkait</th>
                    <td>
                        @if ($kategori->artikel->isEmpty())
                            <span class="text-muted">Tidak ada artikel yang terkait dengan kategori ini.</span>
                        @else
                            <ul class="artikel-list">
                                @foreach ($kategori->artikel as $artikel)
                                    <li>{{ $artikel->judul }} <span class="text-muted">(ID: {{ $artikel->id }})</span></li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
            </table>

            <div class="mt-4">
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Kategori
                </a>
            </div>
        </div>
    </div>
@endsection
