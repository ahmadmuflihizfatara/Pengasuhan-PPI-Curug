<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }
.app-layout   { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

/* ── Breadcrumb ── */
.bc-breadcrumb {
    display:flex; align-items:center; gap:7px;
    margin-bottom:20px; font-size:12px; color:#888;
    list-style:none; padding:0; background:none;
}
.bc-breadcrumb a  { color:#fdbb11; text-decoration:none; font-weight:600; }
.bc-breadcrumb a:hover { text-decoration:underline; }
.bc-breadcrumb i  { font-size:10px; }

/* ── Article Layout ── */
.article-wrap {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 24px;
    align-items: start;
}

/* ── Main Article ── */
.article-card {
    background: white; border-radius: 20px;
    border: 1px solid #d4dbe5; overflow: hidden;
}
.article-hero {
    width:100%; height:320px; object-fit:cover;
}
.article-hero-gradient {
    width:100%; height:240px;
    display:flex; align-items:center; justify-content:center;
    font-size:72px; color:rgba(255,255,255,.75);
}
.article-content-wrap { padding: 32px 36px; }

.article-meta {
    display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:18px;
}
.kat-badge {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700;
}
.bc-pin-badge {
    display:inline-flex; align-items:center; gap:5px;
    background:#fff7e6; color:#e07020;
    padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700;
}
.meta-date { font-size:12px; color:#6b7c93; display:flex; align-items:center; gap:5px; }

.article-title {
    font-size:26px; font-weight:800; color:#1a202c;
    line-height:1.35; margin:0 0 16px;
}
.article-summary {
    font-size:15px; color:#718096; line-height:1.7;
    border-left:4px solid #fdbb11; padding-left:16px;
    margin-bottom:28px; font-style:italic;
}

/* ── Article body typography ── */
.article-body { font-size:14px; color:#444; line-height:1.85; }
.article-body p   { margin:0 0 16px; }
.article-body h2  { font-size:18px; font-weight:700; color:#2d3748; margin:28px 0 12px; }
.article-body h3  { font-size:15px; font-weight:700; color:#2d3748; margin:22px 0 10px; }
.article-body ul, .article-body ol { padding-left:22px; margin:0 0 16px; }
.article-body li  { margin-bottom:6px; }
.article-body strong { color:#2d3748; }
.article-body a   { color:#fdbb11; }
.article-body blockquote {
    border-left:4px solid #fdbb11; padding:12px 18px;
    background:#f7f8ff; border-radius:0 10px 10px 0;
    margin:18px 0; font-style:italic; color:#555;
}

/* ── Divider ── */
.article-divider { border:none; border-top:1px solid #d4dbe5; margin:28px 0; }

/* ── Author Section ── */
.author-section {
    display:flex; align-items:center; gap:14px;
    background:#f5f7fa; border-radius:14px; padding:18px;
}
.author-big-ava {
    width:48px; height:48px; border-radius:50%;
    background:#12283a;
    color:white; font-size:18px; font-weight:800;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.author-info .author-role { font-size:11px; color:#6b7c93; }
.author-info .author-name { font-size:14px; font-weight:700; color:#333; }

/* ── Staff Edit Bar ── */
.staff-bar {
    display:flex; align-items:center; gap:10px;
    background:#f5f7fa; border-radius:14px; padding:14px 18px;
    margin-top:28px; flex-wrap:wrap;
}
.staff-bar span { font-size:12px; color:#6b7c93; font-weight:600; margin-right:4px; }
.bc-action-btn {
    padding:8px 16px; border-radius:9px; font-size:12px; font-weight:600;
    border:none; cursor:pointer; display:inline-flex; align-items:center; gap:6px;
    text-decoration:none; transition:opacity .15s;
}
.bc-action-btn:hover { opacity:.85; }
.bc-action-btn.edit  { background:#eef3f9; color:#fdbb11; }
.bc-action-btn.del   { background:#fff0f0; color:#e53e3e; }
.bc-action-btn.pin   { background:#fff7e6; color:#e07020; }

/* ── Sidebar (related + nav) ── */
.sidebar-right {}

/* Back link */
.back-btn {
    display:flex; align-items:center; gap:8px;
    background:white; border-radius:12px; padding:13px 16px;
    text-decoration:none; font-size:13px; font-weight:600; color:#fdbb11;
    border:1px solid #d4dbe5; margin-bottom:16px;
    transition:background .15s;
}
.back-btn:hover { background:#eef3f9; }

/* Related articles */
.related-card { background:white; border-radius:16px; border:1px solid #d4dbe5; overflow:hidden; }
.related-header { padding:16px 18px 12px; border-bottom:1px solid #d4dbe5; }
.related-header h3 { font-size:13px; font-weight:700; color:#333; margin:0; }

.related-item {
    display:flex; gap:10px; padding:12px 16px;
    text-decoration:none; color:inherit;
    border-bottom:1px solid #d4dbe5;
    transition:background .1s;
    align-items:flex-start;
}
.related-item:last-child { border-bottom:none; }
.related-item:hover { background:#eef3f9; }
.related-thumb {
    width:56px; height:56px; border-radius:10px; overflow:hidden; flex-shrink:0;
}
.related-thumb img { width:100%; height:100%; object-fit:cover; }
.related-thumb .thumb-grad {
    width:100%; height:100%; display:flex; align-items:center; justify-content:center;
    color:rgba(255,255,255,.8); font-size:18px;
}
.related-info .rel-title { font-size:12px; font-weight:700; color:#333; line-height:1.4; margin-bottom:4px; }
.related-info .rel-date  { font-size:10px; color:#6b7c93; }

/* ── Alert ── */
.bc-alert { padding:12px 18px; border-radius:10px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:9px; }
.bc-alert-success { background:#e6fff5; color:#276749; border:1px solid #b2f5ea; }
</style>

<div class="app-layout">
    <x-sidebar active="berita" />

    <div class="main-content">

        @if(session('success'))
        <div class="bc-alert bc-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        {{-- Breadcrumb --}}
        <div class="bc-breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('berita.index') }}">Berita Taruna</a>
            <i class="fas fa-chevron-right"></i>
            <span style="color:#333;font-weight:600;">{{ Str::limit($beritum->judul, 40) }}</span>
        </div>

        <div class="article-wrap">

            {{-- Main Article --}}
            <div class="article-card">
                {{-- Hero Image --}}
                @if($beritum->gambar)
                    <img src="{{ Storage::url($beritum->gambar) }}" alt="{{ $beritum->judul }}" class="article-hero">
                @else
                    <div class="article-hero-gradient" style="background:{{ $beritum->card_gradient }};">
                        <i class="fas {{ $beritum->kategori_icon }}"></i>
                    </div>
                @endif

                <div class="article-content-wrap">
                    {{-- Meta --}}
                    <div class="article-meta">
                        <span class="kat-badge" style="background:{{ $beritum->kategori_bg_color }};color:{{ $beritum->kategori_color }};">
                            <i class="fas {{ $beritum->kategori_icon }}" style="font-size:9px;"></i>
                            {{ $beritum->kategori_label }}
                        </span>
                        @if($beritum->is_pinned)
                        <span class="bc-pin-badge"><i class="fas fa-thumbtack" style="font-size:9px;"></i> Pinned</span>
                        @endif
                        <span class="meta-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ $beritum->created_at->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </span>
                        <span class="meta-date">
                            <i class="far fa-clock"></i>
                            {{ $beritum->waktu_relatif }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1 class="article-title">{{ $beritum->judul }}</h1>

                    {{-- Summary --}}
                    @if($beritum->ringkasan)
                    <div class="article-summary">{{ $beritum->ringkasan }}</div>
                    @endif

                    {{-- Body --}}
                    <div class="article-body">
                        {!! nl2br(e($beritum->konten)) !!}
                    </div>

                    <hr class="article-divider">

                    {{-- Author --}}
                    <div class="author-section">
                        <div class="author-big-ava">{{ strtoupper(substr($beritum->penulis->name ?? 'A', 0, 2)) }}</div>
                        <div class="author-info">
                            <div class="author-role">Ditulis oleh</div>
                            <div class="author-name">{{ $beritum->penulis->name ?? 'Admin' }}</div>
                            <div class="author-role">{{ $beritum->penulis->jabatan ?? ($beritum->penulis->role_label ?? '') }}</div>
                        </div>
                    </div>

                    {{-- Staff Actions --}}
                    @if(!Auth::user()->isTaruna())
                    <div class="staff-bar">
                        <span><i class="fas fa-tools"></i> Kelola:</span>
                        <a href="{{ route('berita.edit', $beritum) }}" class="bc-action-btn edit">
                            <i class="fas fa-pen"></i> Edit Berita
                        </a>
                        <form method="POST" action="{{ route('berita.toggle-pin', $beritum) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="bc-action-btn pin">
                                <i class="fas fa-thumbtack"></i> {{ $beritum->is_pinned ? 'Unpin' : 'Pin Berita' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('berita.destroy', $beritum) }}" style="display:inline;" onsubmit="return confirm('Yakin hapus berita ini? Tindakan tidak dapat dibatalkan.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bc-action-btn del"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Sidebar Right --}}
            <div class="sidebar-right">

                <a href="{{ route('berita.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>

                @if($terkait->isNotEmpty())
                <div class="related-card">
                    <div class="related-header">
                        <h3><i class="fas fa-layer-group" style="color:#fdbb11;margin-right:7px;"></i>Berita Terkait</h3>
                    </div>
                    @foreach($terkait as $r)
                    <a href="{{ route('berita.show', $r) }}" class="related-item">
                        <div class="related-thumb">
                            @if($r->gambar)
                                <img src="{{ Storage::url($r->gambar) }}" alt="{{ $r->judul }}">
                            @else
                                <div class="thumb-grad" style="background:{{ $r->card_gradient }};">
                                    <i class="fas {{ $r->kategori_icon }}"></i>
                                </div>
                            @endif
                        </div>
                        <div class="related-info">
                            <div class="rel-title">{{ Str::limit($r->judul, 60) }}</div>
                            <div class="rel-date"><i class="far fa-clock"></i> {{ $r->waktu_relatif }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div style="background:white;border-radius:14px;padding:24px;text-align:center;border:1px solid #d4dbe5;">
                    <i class="fas fa-newspaper" style="font-size:28px;color:#e2e5ee;display:block;margin-bottom:10px;"></i>
                    <p style="font-size:12px;color:#6b7c93;margin:0;">Tidak ada berita terkait lainnya.</p>
                </div>
                @endif

            </div>
        </div>

    </div>
</div>
</x-app-layout>
