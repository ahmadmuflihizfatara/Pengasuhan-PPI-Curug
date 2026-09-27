{{-- Kartu berita (PPI Curug Glass) — dipakai section "Dipin" & "Semua Berita". Gaya .br-* ada di berita/index --}}
@php $varian = $item->kategori_varian; @endphp
<article class="br-card {{ $item->is_pinned ? 'br-card--pin' : '' }}">
    <div class="br-thumb" style="--br-tint: var(--{{ $varian }}-tint); --br-ink: var(--{{ $varian }}-ink);">
        @if($item->gambar)
            <img src="{{ Storage::url($item->gambar) }}" alt="" loading="lazy">
        @else
            <i class="fa-solid {{ $item->kategori_icon }}"></i>
        @endif
        @if($item->is_pinned)
        <span class="ds-badge ds-badge--warning br-thumb__pin"><i class="fa-solid fa-thumbtack"></i> Dipin</span>
        @endif
    </div>

    <div class="br-body">
        <div class="br-meta">
            <span class="ds-badge ds-badge--{{ $varian }}"><i class="fa-solid {{ $item->kategori_icon }}"></i> {{ $item->kategori_label }}</span>
            <span class="br-waktu"><i class="fa-regular fa-clock"></i> {{ $item->waktu_relatif }}</span>
        </div>
        {{-- Link judul menutupi seluruh kartu (::after) agar kartu bisa diklik --}}
        <h3 class="br-judul"><a href="{{ route('berita.show', $item) }}" class="br-link">{{ $item->judul }}</a></h3>
        <p class="br-ringkas">{{ $item->ringkasan_auto }}</p>

        <div class="br-foot">
            <span class="br-penulis">
                <span class="ds-avatar">{{ strtoupper(substr($item->penulis->name ?? 'A', 0, 2)) }}</span>
                {{ $item->penulis->name ?? 'Admin' }}
            </span>
            <span class="br-baca">Baca <i class="fa-solid fa-arrow-right"></i></span>
        </div>

        @unless(Auth::user()->hasTarunaAccess())
        <div class="br-aksi">
            <a href="{{ route('berita.edit', $item) }}" class="ds-btn ds-btn--xs"><i class="fa-solid fa-pen"></i> Edit</a>
            <form method="POST" action="{{ route('berita.toggle-pin', $item) }}">
                @csrf @method('PATCH')
                <button type="submit" class="ds-btn ds-btn--xs"><i class="fa-solid fa-thumbtack"></i> {{ $item->is_pinned ? 'Lepas Pin' : 'Pin' }}</button>
            </form>
            <form method="POST" action="{{ route('berita.destroy', $item) }}" onsubmit="return confirm('Hapus berita ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="ds-btn ds-btn--xs ds-btn--danger"><i class="fa-solid fa-trash"></i> Hapus</button>
            </form>
        </div>
        @endunless
    </div>
</article>
