<x-app-layout>
<x-administration-table-style />
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

/* ── Page Header ── */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 18px; padding: 28px 32px;
    color: white; margin-bottom: 24px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:200px; height:200px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:90px; bottom:-70px; width:160px; height:160px; background:rgba(255,255,255,.05); border-radius:50%; }
.page-header-text    { position:relative; z-index:1; }
.page-header-text h1 { font-size:22px; font-weight:800; margin:0 0 5px; }
.page-header-text p  { font-size:13px; opacity:.85; margin:0; }
.page-header-actions { position:relative; z-index:1; display:flex; gap:10px; align-items:center; }

/* ── Stats Row ── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 12px; margin-bottom: 22px;
}
.stat-pill {
    background: white; border-radius: 12px;
    padding: 14px 16px; text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
    cursor: pointer; transition: transform .15s, box-shadow .15s;
    text-decoration: none; display: block;
    border: 2px solid transparent;
}
.stat-pill:hover          { transform: translateY(-2px); box-shadow: 0 5px 18px rgba(0,0,0,.1); }
.stat-pill.active         { border-color: #667eea; }
.stat-pill .sp-count      { font-size: 20px; font-weight: 800; color: #333; }
.stat-pill .sp-label      { font-size: 11px; color: #888; font-weight: 500; margin-top: 2px; }
.stat-pill .sp-dot        { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 5px; }

/* ── Filter & Search Bar ── */
.filter-bar {
    background: white; border-radius: 14px;
    padding: 14px 18px; margin-bottom: 22px;
    display: flex; gap: 10px; align-items: center;
    flex-wrap: wrap; box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.filter-bar .search-wrap { position: relative; flex: 1; min-width: 200px; }
.filter-bar .search-wrap .fa-search { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#bbb; font-size:12px; }
.filter-bar input[type=text] {
    width:100%; padding:9px 12px 9px 32px;
    border:1.5px solid #edf0f7; border-radius:9px;
    font-size:13px; font-family:'Inter',sans-serif;
    outline:none; color:#444; transition:border-color .15s;
}
.filter-bar input:focus { border-color:#667eea; }
.filter-bar select {
    padding:9px 32px 9px 12px; border:1.5px solid #edf0f7;
    border-radius:9px; font-size:13px; color:#444;
    font-family:'Inter',sans-serif; appearance:none;
    background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23999' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right 10px center;
    outline:none; cursor:pointer;
}
.filter-bar select:focus { border-color:#667eea; }
.filter-btn {
    padding:9px 18px; border-radius:9px; font-size:13px;
    font-weight:600; border:none; cursor:pointer;
    transition:background .15s;
}
.filter-btn.primary { background:linear-gradient(135deg,#667eea,#764ba2); color:white; }
.filter-btn.secondary { background:#f0f1fb; color:#667eea; }

/* ── Pinned Banner ── */
.pinned-section { margin-bottom: 24px; }
.pinned-banner {
    background: linear-gradient(135deg,#fff7e6,#fff0f0);
    border: 1.5px solid #fdd;
    border-radius: 14px; padding: 14px 18px;
    display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
}
.pinned-banner i { color: #e07020; font-size: 15px; }
.pinned-banner span { font-size: 13px; font-weight: 700; color: #c05020; }

.pinned-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}
@media (max-width: 1100px) { .pinned-grid { grid-template-columns: 1fr; } }

/* ── Berita Cards Grid ── */
.berita-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
    margin-bottom: 28px;
}
@media (max-width: 1100px) { .berita-grid { grid-template-columns: 1fr; } }

/* ── Card ── */
.berita-card {
    background: white; border-radius: 16px;
    box-shadow: 0 2px 14px rgba(0,0,0,.06);
    overflow: hidden; display: flex; flex-direction: row;
    transition: transform .2s, box-shadow .2s;
    text-decoration: none; color: inherit;
}
.berita-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,.12); }
.berita-card.pinned-card { border: 2px solid #f6ad55; }

.bc-img {
    width: 240px; position: relative; flex-shrink: 0;
}
.bc-img img { width:100%; height:100%; object-fit:cover; }
.bc-img .bc-gradient {
    width:100%; height:100%; min-height: 180px;
    display:flex; align-items:center; justify-content:center;
    font-size:38px; color:rgba(255,255,255,.8);
}
.bc-img .bc-pin-badge {
    position:absolute; top:10px; right:10px;
    background:#e07020; color:white;
    border-radius:20px; padding:3px 9px;
    font-size:10px; font-weight:800; display:flex; align-items:center; gap:4px;
}

.bc-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
.bc-meta  { display:flex; align-items:center; gap:8px; margin-bottom:10px; flex-wrap:wrap; }
.kat-badge  {
    display:inline-flex; align-items:center; gap:5px;
    padding:3px 10px; border-radius:20px; font-size:10px; font-weight:700;
}
.bc-date  { font-size:11px; color:#aab; display:flex; align-items:center; gap:4px; }
.bc-title { font-size:14px; font-weight:700; color:#2d3748; line-height:1.45; margin:0 0 8px; }
.bc-desc  { font-size:12px; color:#718096; line-height:1.6; flex:1; }
.bc-footer {
    margin-top:14px; padding-top:12px; border-top:1px solid #f0f2f7;
    display:flex; align-items:center; justify-content:space-between;
}
.bc-author { display:flex; align-items:center; gap:7px; }
.bc-ava  { width:24px; height:24px; border-radius:50%; background:linear-gradient(135deg,#667eea,#764ba2); color:white; font-size:9px; font-weight:800; display:flex; align-items:center; justify-content:center; }
.bc-author-name { font-size:11px; color:#888; }
.bc-read-more   { font-size:11px; color:#667eea; font-weight:700; display:flex; align-items:center; gap:4px; }

/* ── Staff Actions ── */
.bc-staff-actions { display:flex; gap:6px; margin-top:8px; }
.bc-action-btn {
    padding:5px 10px; border-radius:7px; font-size:11px; font-weight:600;
    border:none; cursor:pointer; display:inline-flex; align-items:center; gap:4px;
    text-decoration:none; transition:opacity .15s;
}
.bc-action-btn:hover { opacity:.85; }
.bc-action-btn.edit  { background:#eef0ff; color:#667eea; }
.bc-action-btn.del   { background:#fff0f0; color:#e53e3e; }
.bc-action-btn.pin   { background:#fff7e6; color:#e07020; }

/* ── Empty State ── */
.empty-state { text-align:center; padding:60px 20px; background:white; border-radius:16px; }
.empty-state i   { font-size:48px; color:#e2e5ee; display:block; margin-bottom:14px; }
.empty-state h3  { font-size:16px; color:#aab; font-weight:600; margin:0 0 6px; }
.empty-state p   { font-size:13px; color:#bbb; margin:0; }

@media (max-width: 768px) {
    .berita-card { flex-direction: column; }
    .bc-img { width: 100%; height: 180px; }
}

/* ── Pagination ── */
.pagination-wrap { display:flex; justify-content:center; margin-top:8px; }
.pagination-wrap nav { font-size:13px; }

/* ── Alert ── */
.alert { padding:12px 18px; border-radius:10px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:9px; }
.alert-success { background:#e6fff5; color:#276749; border:1px solid #b2f5ea; }
.alert-error   { background:#fff0f0; color:#9b2c2c; border:1px solid #fed7d7; }

/* ── Btn styles ── */
.btn-create {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.18); color:white;
    padding:9px 18px; border-radius:10px; font-size:13px;
    font-weight:700; text-decoration:none; border:1px solid rgba(255,255,255,.3);
    backdrop-filter:blur(4px); transition:background .15s;
}
.btn-create:hover { background:rgba(255,255,255,.28); color:white; }
</style>

<div class="app-layout">
    <x-sidebar active="berita" />

    <div class="main-content">

        {{-- Alert --}}
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-header-text">
                <h1><i class="fas fa-newspaper" style="margin-right:10px;"></i>Berita Taruna</h1>
                <p>Artikel, pengumuman, dan informasi seputar kegiatan taruna</p>
            </div>
            <div class="page-header-actions">
                @if(!Auth::user()->isTaruna())
                <a href="{{ route('berita.create') }}" class="btn-create">
                    <i class="fas fa-plus"></i> Tulis Berita
                </a>
                @endif
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="stats-row">
            <a href="{{ route('berita.index') }}" class="stat-pill {{ !request('kategori') || request('kategori') === 'semua' ? 'active' : '' }}">
                <div class="sp-count">{{ $stats['total'] }}</div>
                <div class="sp-label"><span class="sp-dot" style="background:#667eea;"></span>Semua</div>
            </a>
            <a href="{{ route('berita.index', ['kategori' => 'pengumuman']) }}" class="stat-pill {{ request('kategori') === 'pengumuman' ? 'active' : '' }}">
                <div class="sp-count">{{ $stats['pengumuman'] }}</div>
                <div class="sp-label"><span class="sp-dot" style="background:#e53e3e;"></span>Pengumuman</div>
            </a>
            <a href="{{ route('berita.index', ['kategori' => 'prestasi']) }}" class="stat-pill {{ request('kategori') === 'prestasi' ? 'active' : '' }}">
                <div class="sp-count">{{ $stats['prestasi'] }}</div>
                <div class="sp-label"><span class="sp-dot" style="background:#d69e2e;"></span>Prestasi</div>
            </a>
            <a href="{{ route('berita.index', ['kategori' => 'kegiatan']) }}" class="stat-pill {{ request('kategori') === 'kegiatan' ? 'active' : '' }}">
                <div class="sp-count">{{ $stats['kegiatan'] }}</div>
                <div class="sp-label"><span class="sp-dot" style="background:#38a169;"></span>Kegiatan</div>
            </a>
            <a href="{{ route('berita.index', ['kategori' => 'informasi']) }}" class="stat-pill {{ request('kategori') === 'informasi' ? 'active' : '' }}">
                <div class="sp-count">{{ $stats['informasi'] }}</div>
                <div class="sp-label"><span class="sp-dot" style="background:#3182ce;"></span>Informasi</div>
            </a>
        </div>

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('berita.index') }}">
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            <div class="filter-bar admin-list-filter">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="search-input" placeholder="Cari judul, isi berita..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
                @if(request('search') || request('kategori'))
                <a href="{{ route('berita.index') }}" class="btn-reset"><i class="fas fa-times"></i> Reset</a>
                @endif
            </div>
        </form>

        {{-- Pinned Articles --}}
        @if($pinned->isNotEmpty() && (!request('search')))
        <div class="pinned-section">
            <div class="pinned-banner">
                <i class="fas fa-thumbtack"></i>
                <span>Berita Dipin — Penting untuk dibaca</span>
            </div>
            <div class="pinned-grid">
                @foreach($pinned as $item)
                <div class="berita-card pinned-card" onclick="window.location='{{ route('berita.show', $item) }}'" style="cursor:pointer;">
                    <div class="bc-img">
                        @if($item->gambar)
                            <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}">
                        @else
                            <div class="bc-gradient" style="background:{{ $item->card_gradient }};">
                                <i class="fas {{ $item->kategori_icon }}"></i>
                            </div>
                        @endif
                        <span class="bc-pin-badge"><i class="fas fa-thumbtack"></i> Pinned</span>
                    </div>
                    <div class="bc-body">
                        <div class="bc-meta">
                            <span class="kat-badge" style="background:{{ $item->kategori_bg_color }};color:{{ $item->kategori_color }};">
                                <i class="fas {{ $item->kategori_icon }}" style="font-size:9px;"></i>
                                {{ $item->kategori_label }}
                            </span>
                            <span class="bc-date"><i class="far fa-clock"></i> {{ $item->waktu_relatif }}</span>
                        </div>
                        <div class="bc-title">{{ $item->judul }}</div>
                        <div class="bc-desc">{{ $item->ringkasan_auto }}</div>
                        <div class="bc-footer">
                            <div class="bc-author">
                                <div class="bc-ava">{{ strtoupper(substr($item->penulis->name ?? 'A', 0, 2)) }}</div>
                                <span class="bc-author-name">{{ $item->penulis->name ?? 'Admin' }}</span>
                            </div>
                            <span class="bc-read-more">Baca <i class="fas fa-arrow-right" style="font-size:9px;"></i></span>
                        </div>
                        @if(!Auth::user()->isTaruna())
                        <div class="bc-staff-actions">
                            <a href="{{ route('berita.edit', $item) }}" class="bc-action-btn edit" onclick="event.preventDefault(); event.stopPropagation(); window.location='{{ route('berita.edit', $item) }}';">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('berita.toggle-pin', $item) }}" style="display:inline;" onclick="event.stopPropagation();">
                                @csrf @method('PATCH')
                                <button type="submit" class="bc-action-btn pin">
                                    <i class="fas fa-thumbtack"></i> {{ $item->is_pinned ? 'Unpin' : 'Pin' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('berita.destroy', $item) }}" style="display:inline;" onclick="event.stopPropagation();" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bc-action-btn del"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Main Grid --}}
        @if($berita->isEmpty() && $pinned->isEmpty())
        <div class="empty-state">
            <i class="fas fa-newspaper"></i>
            <h3>Belum ada berita</h3>
            <p>
                @if(request('search'))
                    Tidak ada hasil untuk "<strong>{{ request('search') }}</strong>". Coba kata kunci lain.
                @elseif(!Auth::user()->isTaruna())
                    Mulai tulis berita pertama untuk taruna.
                @else
                    Belum ada berita yang dipublikasikan.
                @endif
            </p>
            @if(!Auth::user()->isTaruna())
            <a href="{{ route('berita.create') }}" style="display:inline-flex;align-items:center;gap:8px;margin-top:16px;background:linear-gradient(135deg,#667eea,#764ba2);color:white;padding:10px 22px;border-radius:10px;text-decoration:none;font-weight:700;font-size:13px;">
                <i class="fas fa-plus"></i> Tulis Berita Pertama
            </a>
            @endif
        </div>
        @elseif($berita->isNotEmpty())
        <div class="section-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
            <h3 style="font-size:15px;font-weight:700;color:#333;margin:0;">
                <i class="fas fa-list" style="color:#667eea;margin-right:8px;"></i>
                Semua Berita
                @if(request('search'))
                <span style="font-size:12px;color:#888;font-weight:400;"> — hasil pencarian "{{ request('search') }}"</span>
                @endif
            </h3>
            <span style="font-size:12px;color:#aab;">{{ $berita->total() }} artikel</span>
        </div>
        <div class="berita-grid">
            @foreach($berita as $item)
            <div class="berita-card" onclick="window.location='{{ route('berita.show', $item) }}'" style="cursor:pointer;">
                <div class="bc-img">
                    @if($item->gambar)
                        <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}">
                    @else
                        <div class="bc-gradient" style="background:{{ $item->card_gradient }};">
                            <i class="fas {{ $item->kategori_icon }}"></i>
                        </div>
                    @endif
                </div>
                <div class="bc-body">
                    <div class="bc-meta">
                        <span class="kat-badge" style="background:{{ $item->kategori_bg_color }};color:{{ $item->kategori_color }};">
                            <i class="fas {{ $item->kategori_icon }}" style="font-size:9px;"></i>
                            {{ $item->kategori_label }}
                        </span>
                        <span class="bc-date"><i class="far fa-clock"></i> {{ $item->waktu_relatif }}</span>
                    </div>
                    <div class="bc-title">{{ $item->judul }}</div>
                    <div class="bc-desc">{{ $item->ringkasan_auto }}</div>
                    <div class="bc-footer">
                        <div class="bc-author">
                            <div class="bc-ava">{{ strtoupper(substr($item->penulis->name ?? 'A', 0, 2)) }}</div>
                            <span class="bc-author-name">{{ $item->penulis->name ?? 'Admin' }}</span>
                        </div>
                        <span class="bc-read-more">Baca <i class="fas fa-arrow-right" style="font-size:9px;"></i></span>
                    </div>
                    @if(!Auth::user()->isTaruna())
                    <div class="bc-staff-actions">
                        <a href="{{ route('berita.edit', $item) }}" class="bc-action-btn edit" onclick="event.preventDefault(); event.stopPropagation(); window.location='{{ route('berita.edit', $item) }}';">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('berita.toggle-pin', $item) }}" style="display:inline;" onclick="event.stopPropagation();">
                            @csrf @method('PATCH')
                            <button type="submit" class="bc-action-btn pin">
                                <i class="fas fa-thumbtack"></i> Pin
                            </button>
                        </form>
                        <form method="POST" action="{{ route('berita.destroy', $item) }}" style="display:inline;" onclick="event.stopPropagation();" onsubmit="return confirm('Hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bc-action-btn del"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            {{ $berita->links() }}
        </div>
        @endif

    </div>
</div>
</x-app-layout>
