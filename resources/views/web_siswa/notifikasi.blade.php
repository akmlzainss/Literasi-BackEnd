@extends('layouts.layouts')

@section('title', 'Notifikasi Anda')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h2 class="h4 mb-0 text-center"><i class="fas fa-bell me-2 text-primary"></i>Notifikasi Anda</h2>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse ($notifikasis as $notifikasi)
                            @php
                                // Menentukan link berdasarkan tipe referensi
                                $link = '#';
                                if ($notifikasi->referensi_tipe == 'artikel') {
                                    $link = route('artikel-siswa.show', $notifikasi->referensi_id);
                                }
                                // Tambahkan kondisi lain jika ada tipe referensi lain di masa depan
                                // elseif ($notifikasi->referensi_tipe == 'penghargaan') { ... }

                                // Menentukan ikon berdasarkan jenis notifikasi
                                $icon = 'fa-info-circle';
                                switch ($notifikasi->jenis) {
                                    case 'like':
                                        $icon = 'fa-heart text-danger';
                                        break;
                                    case 'komentar':
                                        $icon = 'fa-comment text-primary';
                                        break;
                                    case 'disetujui':
                                        $icon = 'fa-check-circle text-success';
                                        break;
                                    case 'ditolak':
                                        $icon = 'fa-times-circle text-danger';
                                        break;
                                    case 'diberi_penghargaan':
                                        $icon = 'fa-trophy text-warning';
                                        break;
                                }
                            @endphp

                            <a href="{{ $link }}" class="list-group-item list-group-item-action py-3 px-4">
                                <div class="d-flex w-100 align-items-center">
                                    <div class="me-3 fs-4">
                                        <i class="fas {{ $icon }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $notifikasi->judul }}</h6>
                                        <p class="mb-1">{{ $notifikasi->pesan }}</p>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($notifikasi->dibuat_pada)->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="list-group-item text-center p-5">
                                <i class="fas fa-bell-slash fs-1 text-muted mb-3"></i>
                                <p class="mb-0">Tidak ada notifikasi baru.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if ($notifikasis->hasPages())
                    <div class="card-footer bg-white d-flex justify-content-center">
                        {{ $notifikasis->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 