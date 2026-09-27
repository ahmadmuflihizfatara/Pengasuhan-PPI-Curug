<x-app-layout>
@php $varian = $beritum->kategori_varian; @endphp
<style>
    .br-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .br-kembali:hover { color: var(--accent-ink); }

    /* Artikel */
    .ar-card { padding: 0; overflow: hidden; }
    .ar-hero { position: relative; height: 300px; overflow: hidden; }
    .ar-grad { position: absolute; inset: 0; display: grid; place-items: center; font-size: 72px; color: rgba(255,255,255,.75); }
    .ar-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .ar-hero--ikon { height: 240px; }
    @media (max-width: 640px) { .ar-hero { height: 190px; } .ar-hero--ikon { height: 170px; } .ar-grad { font-size: 52px; } }
    .ar-isi { padding: var(--space-6) var(--space-7, 28px); }
    @media (max-width: 640px) { .ar-isi { padding: var(--space-5) var(--space-4); } }
    .ar-meta { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-2) var(--space-3); margin-bottom: var(--space-3-5); }
    .ar-meta__item { font-size: 12px; line-height: 16px; font-weight: 600; color: var(--ink-600); }
    .ar-meta__item i { margin-right: var(--space-1); color: var(--accent); }
    .ar-judul { margin: 0 0 var(--space-4); font-size: 26px; line-height: 34px; font-weight: 900; letter-spacing: -0.02em; color: var(--ink-900); }
    @media (max-width: 640px) { .ar-judul { font-size: 21px; line-height: 28px; } }
    .ar-ringkas { margin: 0 0 var(--space-5); padding: var(--space-3-5) var(--space-4); border-radius: var(--radius-md); border-left: 4px solid var(--accent); background: var(--glass-card); font-size: 14px; line-height: 22px; font-weight: 600; color: var(--ink-800); }
    .ar-body { font-size: 14.5px; line-height: 1.85; font-weight: 500; color: var(--ink-800); overflow-wrap: anywhere; }
    .ar-penulis { display: flex; align-items: center; gap: var(--space-3); margin-top: var(--space-6); padding: var(--space-3-5) var(--space-4); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .ar-penulis .ds-avatar { width: 44px; height: 44px; font-size: 15px; }
    .ar-penulis__label { display: block; font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .ar-penulis__nama { display: block; font-size: 14px; line-height: 20px; font-weight: 800; color: var(--ink-900); }
    .ar-penulis__jabatan { display: block; font-size: 12px; line-height: 16px; font-weight: 500; color: var(--ink-600); }
    .ar-kelola { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-2); margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border-glass-subtle); }
    .ar-kelola form { margin: 0; }
    .ar-kelola__label { font-size: 12px; font-weight: 700; color: var(--ink-600); margin-right: var(--space-1); }

    /* Berita terkait */
    .rl-list { display: flex; flex-direction: column; gap: var(--space-2); }
    .rl-item { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-2) var(--space-2-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); color: inherit; text-decoration: none; transition: background-color .15s, box-shadow .15s; }
    .rl-item:hover { background: var(--glass-solid); box-shadow: var(--shadow-glass-sm); color: inherit; }
    .rl-item:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .rl-thumb { position: relative; width: 52px; height: 52px; flex-shrink: 0; overflow: hidden; border-radius: var(--radius-sm); }
    .rl-grad { position: absolute; inset: 0; display: grid; place-items: center; font-size: 18px; color: rgba(255,255,255,.8); }
    .rl-thumb img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .rl-body { min-width: 0; }
    .rl-judul { font-size: 12px; line-height: 17px; font-weight: 800; color: var(--ink-900); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .rl-waktu { margin-top: 2px; font-size: 11px; line-height: 14px; font-weight: 600; color: var(--ink-600); }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Berita Taruna" icon="fa-newspaper"
            subtitle="Artikel, pengumuman, dan informasi seputar kegiatan taruna" />

        <a href="{{ route('berita.index') }}" class="ds-btn ds-btn--pill br-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
        </a>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
            {{-- Artikel --}}
            <article class="ds-card ar-card lg:col-span-2">
                <div class="ar-hero {{ $beritum->gambar ? '' : 'ar-hero--ikon' }}">
                    @if($beritum->gambar)
                        <img src="{{ Storage::url($beritum->gambar) }}" alt="{{ $beritum->judul }}">
                    @else
                        <div class="ar-grad" style="background: {{ $beritum->card_gradient }}" aria-hidden="true"><i class="fa-solid {{ $beritum->kategori_icon }}"></i></div>
                    @endif
                </div>

                <div class="ar-isi">
                    <div class="ar-meta">
                        <span class="ds-badge ds-badge--{{ $varian }}"><i class="fa-solid {{ $beritum->kategori_icon }}"></i> {{ $beritum->kategori_label }}</span>
                        @if($beritum->is_pinned)
                        <span class="ds-badge ds-badge--warning"><i class="fa-solid fa-thumbtack"></i> Dipin</span>
                        @endif
                        <span class="ar-meta__item"><i class="fa-regular fa-calendar"></i>{{ $beritum->created_at->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                        <span class="ar-meta__item"><i class="fa-regular fa-clock"></i>{{ $beritum->waktu_relatif }}</span>
                    </div>

                    <h1 class="ar-judul">{{ $beritum->judul }}</h1>

                    @if($beritum->ringkasan)
                    <p class="ar-ringkas">{{ $beritum->ringkasan }}</p>
                    @endif

                    <div class="ar-body">{!! nl2br(e($beritum->konten)) !!}</div>

                    <div class="ar-penulis">
                        <span class="ds-avatar">{{ strtoupper(substr($beritum->penulis->name ?? 'A', 0, 2)) }}</span>
                        <div>
                            <span class="ar-penulis__label">Ditulis oleh</span>
                            <span class="ar-penulis__nama">{{ $beritum->penulis->name ?? 'Admin' }}</span>
                            @if($beritum->penulis?->jabatan || $beritum->penulis?->role_label)
                            <span class="ar-penulis__jabatan">{{ $beritum->penulis->jabatan ?? $beritum->penulis->role_label }}</span>
                            @endif
                        </div>
                    </div>

                    @unless(Auth::user()->hasTarunaAccess())
                    <div class="ar-kelola">
                        <span class="ar-kelola__label"><i class="fa-solid fa-screwdriver-wrench"></i> Kelola:</span>
                        <a href="{{ route('berita.edit', $beritum) }}" class="ds-btn ds-btn--sm"><i class="fa-solid fa-pen"></i> Edit Berita</a>
                        <form method="POST" action="{{ route('berita.toggle-pin', $beritum) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="ds-btn ds-btn--sm"><i class="fa-solid fa-thumbtack"></i> {{ $beritum->is_pinned ? 'Lepas Pin' : 'Pin Berita' }}</button>
                        </form>
                        <form method="POST" action="{{ route('berita.destroy', $beritum) }}" onsubmit="return confirm('Yakin hapus berita ini? Tindakan tidak dapat dibatalkan.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="ds-btn ds-btn--sm ds-btn--danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                    @endunless
                </div>
            </article>

            {{-- Berita terkait --}}
            <aside class="ds-card">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-layer-group ds-icon"></i> Berita Terkait</h3>
                    <p class="ds-card__desc">Berita lain dalam kategori {{ strtolower($beritum->kategori_label) }}</p>
                </div>
                @if($terkait->isEmpty())
                <div class="ds-empty">
                    <i class="fa-solid fa-newspaper ds-icon"></i>
                    Tidak ada berita terkait lainnya.
                </div>
                @else
                <div class="rl-list">
                    @foreach($terkait as $r)
                    <a href="{{ route('berita.show', $r) }}" class="rl-item">
                        <span class="rl-thumb">
                            @if($r->gambar)
                                <img src="{{ Storage::url($r->gambar) }}" alt="" loading="lazy">
                            @else
                                <span class="rl-grad" style="background: {{ $r->card_gradient }}" aria-hidden="true"><i class="fa-solid {{ $r->kategori_icon }}"></i></span>
                            @endif
                        </span>
                        <span class="rl-body">
                            <span class="rl-judul">{{ $r->judul }}</span>
                            <span class="rl-waktu d-block"><i class="fa-regular fa-clock"></i> {{ $r->waktu_relatif }}</span>
                        </span>
                    </a>
                    @endforeach
                </div>
                @endif
            </aside>
        </div>

    </div>
</main>
</x-app-layout>
