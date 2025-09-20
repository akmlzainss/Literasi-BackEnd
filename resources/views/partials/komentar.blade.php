{{-- resources/views/partials/komentar.blade.php --}}
<div class="komentar-item mb-4" id="komentar-{{ $komentar->id }}">
    <div class="d-flex align-items-start">
        <div class="author-avatar-siswa flex-shrink-0 me-3">
            {{ strtoupper(substr($komentar->siswa->nama ?? 'S', 0, 2)) }}
        </div>
        <div class="komentar-body">
            <p class="meta">
                <strong>{{ $komentar->siswa->nama ?? 'Siswa' }}</strong>
                <span class="text-muted ms-2">{{ $komentar->dibuat_pada->diffForHumans() }}</span>
            </p>
            <p>{{ $komentar->komentar }}</p>
            {{-- Tombol Balas akan ditambahkan di update selanjutnya jika diperlukan --}}
        </div>
    </div>

    {{-- Menampilkan balasan (rekursif) --}}
    @if($komentar->replies->isNotEmpty())
        <div class="komentar-replies ms-5 mt-3">
            @foreach($komentar->replies as $balasan)
                @include('partials.komentar', ['komentar' => $balasan])
            @endforeach
        </div>
    @endif
</div>