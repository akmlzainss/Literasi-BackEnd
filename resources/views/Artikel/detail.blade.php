@extends('layouts.app')

@section('content')
<div class="container">
    @if($artikel)
        <h1>{{ $artikel->judul }}</h1>
        @if($artikel->gambar)
            <img src="{{ asset($artikel->gambar) }}" alt="{{ $artikel->judul }}" style="max-width: 300px;">
        @endif
        <p>{!! $artikel->isi !!}</p>
        <p><strong>Kategori:</strong> {{ $artikel->id_kategori }}</p>

        <p><strong>Status:</strong> {{ $artikel->status }}</p>
    @else
        <p>Artikel tidak ditemukan.</p>
    @endif
</div>
@endsection
