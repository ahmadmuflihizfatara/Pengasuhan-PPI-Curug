<x-app-layout>
<x-form-glass-style />
<style>
    /* Kartu aksi pengelola — pola kartu ajukan tab surat & barak */
    .br-aksi-kartu { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .br-aksi-kartu__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
    .br-aksi-kartu__teks i { color: var(--accent); margin-right: var(--space-1-5); }

    /* Filter kategori + pencarian */
    .br-filter { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: var(--space-3); }
    .br-chips { display: flex; flex-wrap: wrap; gap: var(--space-1-5); }
    .br-chip {
        display: inline-flex; align-items: center; gap: var(--space-1-5); padding: var(--space-1-5) var(--space-3);
        border-radius: var(--radius-pill); border: 1px solid var(--border-glass-glow); background: var(--glass-card);
        font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); text-decoration: none;
        transition: background-color .15s, color .15s, box-shadow .15s;
    }
    .br-chip:hover { background: var(--glass-solid); color: var(--ink-900); }
    .br-chip:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .br-chip--aktif, .br-chip--aktif:hover { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .br-chip__dot { width: 8px; height: 8px; border-radius: 50%; }
    .br-chip__jml { font-family: var(--font-mono); font-size: 11px; opacity: .8; }
    .br-cari { display: flex; gap: var(--space-2); flex: 1; min-width: 240px; max-width: 420px; }
    .br-cari__input { position: relative; flex: 1; }
    .br-cari__input i { position: absolute; left: var(--space-3); top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .br-cari__input .form-control { padding-left: 34px; }
    @media (max-width: 640px) { .br-cari { max-width: none; } }

    /* Kartu berita */
    .br-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-4); }
    @media (max-width: 1023px) { .br-grid { grid-template-columns: 1fr; } }
    .br-card {
        position: relative; display: flex; min-width: 0; overflow: hidden;
        border-radius: var(--radius-lg); background: var(--glass-card); border: 1px solid var(--border-glass-glow);
        transition: background-color .2s, box-shadow .2s, transform .2s;
    }
    .br-card:hover { background: var(--glass-solid); box-shadow: var(--shadow-card-hover); transform: translateY(-2px); }
    .br-card:focus-within { box-shadow: var(--shadow-focus); }
    .br-card--pin { border-color: var(--warning-border); }
    .br-thumb { position: relative; width: 200px; flex-shrink: 0; min-height: 190px; overflow: hidden; }
    .br-thumb img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .br-grad { position: absolute; inset: 0; display: grid; place-items: center; font-size: 38px; color: rgba(255,255,255,.8); }
    .br-thumb__pin { position: absolute; z-index: 1; top: var(--space-2-5); left: var(--space-2-5); background: var(--glass-solid); box-shadow: var(--shadow-glass-sm); }
    .br-body { display: flex; flex-direction: column; flex: 1; min-width: 0; padding: var(--space-4) var(--space-5); }
    .br-meta { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-1-5) var(--space-2-5); margin-bottom: var(--space-2-5); }
    .br-waktu { font-size: 11px; line-height: 16px; font-weight: 600; color: var(--ink-600); }
    .br-judul { margin: 0 0 var(--space-1-5); font-size: 15px; line-height: 21px; font-weight: 800; color: var(--ink-900); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .br-link { color: inherit; text-decoration: none; }
    .br-link:focus { outline: none; }
    .br-link::after { content: ''; position: absolute; inset: 0; }
    .br-ringkas { flex: 1; margin: 0; font-size: 12px; line-height: 18px; font-weight: 500; color: var(--ink-700); display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .br-foot { display: flex; align-items: center; justify-content: space-between; gap: var(--space-2); margin-top: var(--space-3-5); padding-top: var(--space-3); border-top: 1px solid var(--border-glass-subtle); }
    .br-penulis { display: flex; align-items: center; gap: var(--space-2); min-width: 0; font-size: 11px; font-weight: 700; color: var(--ink-700); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .br-baca { flex-shrink: 0; font-size: 12px; font-weight: 800; color: var(--accent-ink); }
    .br-baca i { font-size: 10px; margin-left: 2px; transition: transform .15s; }
    .br-card:hover .br-baca i { transform: translateX(3px); }
    .br-aksi { position: relative; z-index: 1; display: flex; flex-wrap: wrap; gap: var(--space-1-5); margin-top: var(--space-2-5); }
    .br-aksi form { margin: 0; }
    @media (max-width: 640px) {
        .br-card { flex-direction: column; }
        .br-thumb { width: 100%; min-height: 150px; }
    }
    .br-pagination { margin-top: var(--space-5); }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php
    $kategoriAktif = request('kategori', 'semua');
    $chips = [
        'semua'      => ['Semua',      'var(--accent)',  $stats['total']],
        'pengumuman' => ['Pengumuman', 'var(--danger)',  $stats['pengumuman']],
        'prestasi'   => ['Prestasi',   'var(--warning)', $stats['prestasi']],
        'kegiatan'   => ['Kegiatan',   'var(--success)', $stats['kegiatan']],
        'informasi'  => ['Informasi',  'var(--info-ink)', $stats['informasi']],
    ];
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab poin, surat & barak --}}
        <x-page-banner title="Berita Taruna" icon="fa-newspaper"
            subtitle="Artikel, pengumuman, dan informasi seputar kegiatan taruna" />

        @unless(Auth::user()->hasTarunaAccess())
        <div class="ds-card br-aksi-kartu mb-4">
            <span class="br-aksi-kartu__teks"><i class="fa-solid fa-pen-nib"></i>Bagikan pengumuman, prestasi, atau kegiatan terbaru kepada taruna</span>
            <a href="{{ route('berita.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Tulis Berita</a>
        </div>
        @endunless

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif

        {{-- Filter kategori & pencarian --}}
        <div class="ds-card br-filter mb-4">
            <nav class="br-chips" aria-label="Kategori berita">
                @foreach($chips as $key => [$label, $warna, $jumlah])
                <a href="{{ route('berita.index', array_filter(['kategori' => $key === 'semua' ? null : $key, 'search' => request('search')])) }}"
                   class="br-chip {{ $kategoriAktif === $key ? 'br-chip--aktif' : '' }}" @if($kategoriAktif === $key) aria-current="page" @endif>
                    @unless($kategoriAktif === $key)<span class="br-chip__dot" style="background: {{ $warna }}"></span>@endunless
                    {{ $label }} <span class="br-chip__jml">{{ $jumlah }}</span>
                </a>
                @endforeach
            </nav>

            <form method="GET" action="{{ route('berita.index') }}" class="br-cari" role="search">
                @if(request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
                <div class="br-cari__input">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}" aria-label="Cari berita">
                </div>
                <button type="submit" class="ds-btn ds-btn--primary">Cari</button>
                @if(request('search') || request('kategori'))
                <a href="{{ route('berita.index') }}" class="ds-btn" title="Reset filter"><i class="fa-solid fa-xmark"></i></a>
                @endif
            </form>
        </div>

        {{-- Berita dipin --}}
        @if($pinned->isNotEmpty() && !request('search'))
        <div class="ds-card mb-4">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-thumbtack ds-icon"></i> Berita Dipin</h3>
                    <p class="ds-card__desc">Penting untuk dibaca</p>
                </div>
                <span class="ds-badge ds-badge--warning">{{ $pinned->count() }} berita</span>
            </div>
            <div class="br-grid">
                @foreach($pinned as $item)
                    @include('berita._kartu', ['item' => $item])
                @endforeach
            </div>
        </div>
        @endif

        {{-- Semua berita --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-list ds-icon"></i> Semua Berita</h3>
                    <p class="ds-card__desc">
                        @if(request('search'))Hasil pencarian "{{ request('search') }}"@else Berita terbaru tampil paling atas @endif
                    </p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ $berita->total() }} artikel</span>
            </div>

            @if($berita->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-newspaper ds-icon"></i>
                @if(request('search'))
                    Tidak ada hasil untuk "{{ request('search') }}". Coba kata kunci lain.
                @elseif($pinned->isNotEmpty())
                    Tidak ada berita lain selain berita yang dipin.
                @else
                    Belum ada berita yang dipublikasikan.
                @endif
            </div>
            @else
            <div class="br-grid">
                @foreach($berita as $item)
                    @include('berita._kartu', ['item' => $item])
                @endforeach
            </div>
            @if($berita->hasPages())
            <div class="br-pagination">{{ $berita->links() }}</div>
            @endif
            @endif
        </div>

    </div>
</main>

@unless(Auth::user()->hasTarunaAccess())
    @include('berita._modal-hapus')
@endunless
</x-app-layout>
