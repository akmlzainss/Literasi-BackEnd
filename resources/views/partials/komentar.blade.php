{{-- resources/views/partials/komentar.blade.php --}}
<div class="komentar-item mb-4" id="komentar-{{ $komentar->id }}">
    <div class="d-flex align-items-start">
        <div class="author-avatar-siswa flex-shrink-0 me-3">
            {{ strtoupper(substr($komentar->siswa->nama ?? ($komentar->admin->nama ?? 'U'), 0, 2)) }}
        </div>
        <div class="komentar-body">
            <p class="meta">
                <strong>
                    {{ $komentar->siswa->nama ?? ($komentar->admin->nama ?? 'Pengguna') }}
                    @if ($komentar->admin)
                        <span class="badge bg-secondary ms-1">Admin</span>
                    @endif
                </strong>
                <span class="text-muted ms-2">
                    {{ $komentar->dibuat_pada ? $komentar->dibuat_pada->diffForHumans() : 'Tanggal tidak tersedia' }}
                </span>
            </p>
            <p>{{ $komentar->komentar }}</p>
            @auth('siswa')
                <button class="btn btn-outline-secondary btn-sm mt-2 btn-reply" data-id="{{ $komentar->id }}">Balas</button>
                <form action="{{ route('komentar.store', [$konten->id, $komentar->id]) }}" method="POST" class="reply-form mt-2" style="display: none;">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control" name="komentar" rows="2" placeholder="Tulis balasan Anda..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                    <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply">Batal</button>
                </form>
            @endauth
        </div>
    </div>

    {{-- Menampilkan balasan (rekursif) --}}
    @if($komentar->replies->isNotEmpty())
        <div class="komentar-replies ms-5 mt-3">
            @foreach($komentar->replies as $balasan)
                @include('partials.komentar', ['komentar' => $balasan, 'konten' => $konten])
            @endforeach
        </div>
    @endif
</div>