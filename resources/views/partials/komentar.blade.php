{{-- Instagram-style Comment Item --}}
@php
    $isReply = isset($isReply) && $isReply;
    $authorName = $komentar->siswa->nama ?? ($komentar->admin->nama ?? 'U');
    $authorPhoto = $komentar->siswa->foto_profil ?? null;
@endphp

<div class="komentar-item {{ $isReply ? 'reply-item' : 'parent-item' }}" 
     id="komentar-{{ $komentar->id }}" 
     data-parent-id="{{ $komentar->id_komentar_parent ?? '' }}"
     data-created-at="{{ $komentar->dibuat_pada ? $komentar->dibuat_pada->toIso8601String() : now()->toIso8601String() }}">
    <div class="d-flex align-items-start">
        @if($authorPhoto)
            <img src="{{ asset('storage/' . $authorPhoto) }}" alt="{{ $authorName }}" class="comment-avatar flex-shrink-0 me-3">
        @else
            <div class="comment-avatar-placeholder flex-shrink-0 me-3">
                {{ strtoupper(substr($authorName, 0, 1)) }}
            </div>
        @endif

        <div class="komentar-body flex-grow-1">
            <div class="d-flex justify-content-between align-items-start">
                <div class="comment-content">
                    {{-- Author name with @mention if reply --}}
                    <span class="comment-author fw-semibold">
                        {{ $authorName }}
                        @if ($komentar->admin)
                            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill ms-1" style="font-size: 0.65rem;">Admin</span>
                        @endif
                    </span>
                    
                    {{-- Instagram style: @mention inline with comment text --}}
                    @if ($komentar->id_komentar_parent && $komentar->parent)
                        @php
                            $parentName = $komentar->parent->siswa->nama ?? ($komentar->parent->admin->nama ?? 'User');
                        @endphp
                        <span class="mention-text text-primary fw-semibold">{{ '@' . $parentName }}</span>
                    @endif
                    
                    <span class="comment-text">{{ $komentar->komentar }}</span>
                    
                    {{-- Comment metadata --}}
                    <div class="comment-meta mt-1">
                        <span class="comment-time text-muted" id="comment-time-{{ $komentar->id }}">
                            @php
                                $now = now();
                                $createdAt = $komentar->dibuat_pada ?? $now;
                                $diffInMonths = $now->diffInMonths($createdAt);
                                if ($diffInMonths >= 1) {
                                    echo $createdAt->format('d-m-Y');
                                } else {
                                    echo $createdAt->diffForHumans();
                                }
                            @endphp
                        </span>
                        @auth('siswa')
                            <button class="btn-reply-inline" data-id="{{ $komentar->id }}" data-name="{{ $authorName }}">Balas</button>
                        @endauth
                    </div>
                </div>

                {{-- Actions --}}
                <div class="comment-actions">
                    @auth('siswa')
                        @if ((Auth::guard('siswa')->check() && Auth::guard('siswa')->id() == $komentar->id_siswa) || Auth::guard('admin')->check())
                            <button class="btn btn-sm delete-comment text-danger p-1" data-id="{{ $komentar->id }}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

{{-- If this is a parent comment, show "View replies" button and flat replies --}}
@if (!$isReply)
    @php
        // Get ALL descendants flattened (Instagram style)
        $allReplies = $komentar->getAllDescendants();
    @endphp
    
    @if ($allReplies->count() > 0)
        <div class="replies-toggle-section ms-5 mt-2">
            <button class="btn-view-replies toggle-replies" 
                    data-comment-id="{{ $komentar->id }}"
                    data-replies-count="{{ $allReplies->count() }}">
                <span class="toggle-line"></span>
                Lihat balasan ({{ $allReplies->count() }})
            </button>
            
            <div class="flat-replies-container" id="replies-{{ $komentar->id }}" style="display: none;">
                @foreach ($allReplies as $reply)
                    @include('partials.komentar', ['komentar' => $reply, 'isReply' => true])
                @endforeach
            </div>
        </div>
    @endif
@endif