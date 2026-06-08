<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.app-layout {
    display: flex;
    min-height: 100vh;
}

/* ===== MAIN ===== */
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

/* Header Banner */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 18px; padding: 28px 32px;
    color: white; margin-bottom: 24px;
    position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: space-between;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:100px; bottom:-60px; width:120px; height:120px; background:rgba(255,255,255,.05); border-radius:50%; }
.page-header-text { position:relative; z-index:1; }
.page-header-text h1 { margin:0 0 4px; font-size:22px; font-weight:800; display:flex; align-items:center; gap:10px; }
.page-header-text p  { margin:0; opacity:.85; font-size:13px; }
.page-header-badge {
    position:relative; z-index:1;
    background:rgba(255,255,255,.15);
    border:1px solid rgba(255,255,255,.25);
    border-radius:14px; padding:14px 22px; text-align:center;
}
.page-header-badge .num  { font-size:28px; font-weight:800; color:white; line-height:1; }
.page-header-badge .desc { font-size:11px; color:rgba(255,255,255,.8); margin-top:3px; }

/* Stats row */
.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
.stat-card {
    background:white; border-radius:14px; padding:18px;
    box-shadow:0 2px 12px rgba(0,0,0,.05);
    display:flex; align-items:center; gap:14px;
}
.stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; color:white; flex-shrink:0; }
.stat-num   { font-size:24px; font-weight:800; color:#333; line-height:1.1; }
.stat-label { font-size:12px; color:#888; margin-top:2px; }

/* Filter panel */
.filter-panel {
    background:white; border-radius:14px;
    padding:18px 22px; margin-bottom:20px;
    box-shadow:0 2px 12px rgba(0,0,0,.05);
}
.filter-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr auto; gap:10px; align-items:end; }
.filter-label { font-size:11px; font-weight:700; color:#888; text-transform:uppercase; letter-spacing:.05em; display:block; margin-bottom:5px; }
.filter-input, .filter-select {
    width:100%; padding:9px 12px;
    border:1.5px solid #edf0f7; border-radius:9px;
    font-size:13px; font-family:'Inter',sans-serif;
    outline:none; color:#444; background:#fafbff;
    transition:border-color .15s;
}
.filter-input:focus, .filter-select:focus { border-color:#667eea; }
.filter-search { position:relative; }
.filter-search .fa-search { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#bbb; font-size:12px; pointer-events:none; }
.filter-search .filter-input { padding-left:32px; }
.btn-filter {
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white; border:none; border-radius:9px;
    padding:9px 20px; font-size:13px; font-family:'Inter',sans-serif;
    font-weight:700; cursor:pointer; white-space:nowrap;
    display:flex; align-items:center; gap:6px;
}
.btn-reset {
    background:#f4f5f9; color:#666; border:none; border-radius:9px;
    padding:9px 14px; font-size:13px; font-family:'Inter',sans-serif;
    font-weight:700; cursor:pointer; text-decoration:none;
    display:flex; align-items:center;
}

/* Log table card */
.log-card { background:white; border-radius:14px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.05); }
.log-card-header {
    padding:16px 22px; border-bottom:1px solid #f0f2f7;
    display:flex; align-items:center; justify-content:space-between;
}
.log-card-title { font-size:15px; font-weight:700; color:#333; display:flex; align-items:center; gap:8px; }
.log-card-count { font-size:12px; color:#9aa0bc; }

table { width:100%; border-collapse:collapse; }
thead tr { background:#f8f9ff; }
th { padding:12px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#8a93b0; white-space:nowrap; }
td { padding:13px 16px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; vertical-align:middle; }
tbody tr { transition:background .1s; }
tbody tr:hover { background:#fafbff; }

/* Badge */
.badge-pill {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 11px; border-radius:20px;
    font-size:11px; font-weight:700; white-space:nowrap;
}

/* Pelaku */
.pelaku-wrap { display:flex; align-items:center; gap:9px; }
.pelaku-ava  {
    width:32px; height:32px; border-radius:50%;
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white; font-size:12px; font-weight:800;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pelaku-name { font-size:13px; font-weight:600; color:#333; }
.pelaku-role { font-size:11px; color:#9aa0bc; text-transform:capitalize; }

/* Detail button */
.btn-detail {
    background:#eef0ff; color:#667eea; border:none;
    border-radius:20px; padding:5px 14px; font-size:11px;
    font-family:'Inter',sans-serif; font-weight:700; cursor:pointer;
    display:inline-flex; align-items:center; gap:5px; transition:background .1s;
}
.btn-detail:hover { background:#dde2ff; }

/* Detail expanded row */
.detail-row { background:#fafbff !important; }
.detail-inner {
    border-radius:10px; padding:14px 18px;
    border-left:4px solid #667eea;
    background:#f4f6ff; margin:4px 0;
}
.detail-label { font-size:11px; font-weight:700; color:#667eea; text-transform:uppercase; letter-spacing:.05em; margin-bottom:10px; }
.detail-grid  { display:flex; flex-wrap:wrap; gap:8px; }
.detail-chip  { background:white; border:1px solid #e5e7eb; border-radius:8px; padding:7px 12px; min-width:120px; }
.detail-chip-key   { font-size:10px; color:#9aa0bc; font-weight:700; text-transform:uppercase; letter-spacing:.04em; margin-bottom:2px; }
.detail-chip-value { font-size:13px; color:#333; font-weight:600; }

/* Waktu */
.time-main { font-size:13px; font-weight:600; color:#333; }
.time-sub  { font-size:11px; color:#9aa0bc; margin-top:1px; }

/* Empty state */
.empty-state { text-align:center; padding:60px 20px; }
.empty-icon  { width:72px; height:72px; background:#f3f4f6; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.empty-icon i { font-size:28px; color:#ccc; }
.empty-state h4 { color:#888; margin:0 0 8px; font-size:16px; font-weight:700; }
.empty-state p  { color:#9aa0bc; margin:0; font-size:13px; }

/* Pagination */
.pagination { display:flex; gap:4px; list-style:none; padding:0; margin:0; }
.pagination .page-item .page-link { border-radius:8px !important; border:1.5px solid #e5e7eb; color:#667eea; font-size:13px; font-weight:600; padding:6px 12px; font-family:'Inter',sans-serif; }
.pagination .page-item.active .page-link { background:linear-gradient(135deg,#667eea,#764ba2); border-color:transparent; color:white; }
.pagination .page-item.disabled .page-link { color:#ccc; }

/* Alert success */
.alert-success-bar {
    background:linear-gradient(135deg,#43e97b,#38f9d7);
    color:white; padding:14px 20px; border-radius:12px;
    margin-bottom:20px; display:flex; align-items:center; gap:10px;
    font-weight:600; font-size:14px;
}
</style>

<div class="app-layout">

    {{-- ── SIDEBAR ── --}}
    <x-sidebar active="activity-log" />

    <!-- Main Content -->
    <div class="main-content">

        {{-- Flash message --}}
        @if(session('success'))
        <div class="alert-success-bar">
            <i class="fas fa-check-circle" style="font-size:18px;"></i> {{ session('success') }}
        </div>
        @endif

        {{-- ── HEADER ── --}}
        <div class="page-header">
            <div class="page-header-text">
                <h1><i class="fas fa-history"></i> Log Aktivitas</h1>
                <p>Rekam jejak seluruh aktivitas sistem — Poin, Acara &amp; Surat</p>
            </div>
            <div class="page-header-badge">
                <div class="num">{{ $stats['hari_ini'] }}</div>
                <div class="desc">Aktivitas Hari Ini</div>
            </div>
        </div>

        {{-- ── STATS ── --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#667eea,#764ba2);">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div>
                    <div class="stat-num">{{ number_format($stats['total']) }}</div>
                    <div class="stat-label">Total Log</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#9f7aea,#764ba2);">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <div class="stat-num">{{ number_format($stats['poin']) }}</div>
                    <div class="stat-label">Aktivitas Poin</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#43e97b,#38a169);">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <div class="stat-num">{{ number_format($stats['acara']) }}</div>
                    <div class="stat-label">Aktivitas Acara</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <div class="stat-num">{{ number_format($stats['surat']) }}</div>
                    <div class="stat-label">Aktivitas Surat</div>
                </div>
            </div>
        </div>

        {{-- ── FILTER ── --}}
        <div class="filter-panel">
            <form method="GET" action="{{ route('activity-log.index') }}">
                <div class="filter-grid">
                    <div>
                        <label class="filter-label">Cari Aktivitas</label>
                        <div class="filter-search">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" class="filter-input"
                                   value="{{ request('search') }}"
                                   placeholder="Cari deskripsi atau pelaku...">
                        </div>
                    </div>
                    <div>
                        <label class="filter-label">Modul</label>
                        <select name="modul" class="filter-select">
                            <option value="semua" {{ request('modul','semua')==='semua'?'selected':'' }}>Semua Modul</option>
                            <option value="poin"  {{ request('modul')==='poin' ?'selected':'' }}>⭐ Poin</option>
                            <option value="acara" {{ request('modul')==='acara'?'selected':'' }}>📅 Acara</option>
                            <option value="surat" {{ request('modul')==='surat'?'selected':'' }}>✉️ Surat</option>
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Aksi</label>
                        <select name="aksi" class="filter-select">
                            <option value="semua"   {{ request('aksi','semua')==='semua'  ?'selected':'' }}>Semua Aksi</option>
                            <option value="tambah"  {{ request('aksi')==='tambah' ?'selected':'' }}>➕ Tambah</option>
                            <option value="buat"    {{ request('aksi')==='buat'   ?'selected':'' }}>🆕 Buat</option>
                            <option value="ubah"    {{ request('aksi')==='ubah'   ?'selected':'' }}>✏️ Ubah</option>
                            <option value="hapus"   {{ request('aksi')==='hapus'  ?'selected':'' }}>🗑️ Hapus</option>
                            <option value="setujui" {{ request('aksi')==='setujui'?'selected':'' }}>✅ Setujui</option>
                            <option value="tolak"   {{ request('aksi')==='tolak'  ?'selected':'' }}>❌ Tolak</option>
                            <option value="selesai" {{ request('aksi')==='selesai'?'selected':'' }}>🏁 Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Dari Tanggal</label>
                        <input type="date" name="dari" class="filter-input" value="{{ request('dari') }}">
                    </div>
                    <div>
                        <label class="filter-label">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="filter-input" value="{{ request('sampai') }}">
                    </div>
                    <div style="display:flex;gap:6px;">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        @if(request()->hasAny(['search','modul','aksi','dari','sampai']))
                        <a href="{{ route('activity-log.index') }}" class="btn-reset" title="Reset filter">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- ── TABEL LOG ── --}}
        <div class="log-card">
            <div class="log-card-header">
                <div class="log-card-title">
                    <i class="fas fa-history" style="color:#667eea;"></i>
                    Riwayat Aktivitas
                </div>
                <div class="log-card-count">{{ $logs->total() }} entri ditemukan</div>
            </div>

            @if($logs->count() > 0)
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Waktu</th>
                            <th>Modul</th>
                            <th>Aksi</th>
                            <th>Deskripsi Aktivitas</th>
                            <th>Pelaku</th>
                            <th style="text-align:center;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $index => $log)

                        {{-- Baris utama --}}
                        <tr>
                            <td style="color:#bbb;font-weight:600;font-size:12px;">
                                {{ $logs->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="time-main">{{ $log->created_at->format('d/m/Y') }}</div>
                                <div class="time-sub">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td>
                                <span class="badge-pill"
                                      style="background:{{ $log->modul_bg_color }};color:{{ $log->modul_color }};">
                                    <i class="fas {{ $log->modul_icon }}" style="font-size:10px;"></i>
                                    {{ $log->modul_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-pill"
                                      style="background:{{ $log->aksi_bg_color }};color:{{ $log->aksi_color }};">
                                    {{ $log->aksi_label }}
                                </span>
                            </td>
                            <td style="max-width:340px;line-height:1.5;">
                                {{ $log->deskripsi }}
                            </td>
                            <td>
                                <div class="pelaku-wrap">
                                    <div class="pelaku-ava">
                                        {{ strtoupper(substr($log->user_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="pelaku-name">{{ $log->user_name }}</div>
                                        <div class="pelaku-role">{{ $log->user_role }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                @if($log->detail)
                                <button class="btn-detail" onclick="toggleDetail({{ $log->id }}, this)">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                                @else
                                <span style="color:#ddd;font-size:13px;">—</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Baris detail (expand) --}}
                        @if($log->detail)
                        <tr id="detail-row-{{ $log->id }}" style="display:none;" class="detail-row">
                            <td colspan="7" style="padding:6px 16px 14px;">
                                <div class="detail-inner" style="border-left-color:{{ $log->modul_color }};">
                                    <div class="detail-label">
                                        <i class="fas fa-info-circle"></i> Detail Lengkap
                                    </div>
                                    <div class="detail-grid">
                                        @foreach($log->detail as $key => $value)
                                            @if($value !== null && $value !== '')
                                            <div class="detail-chip">
                                                <div class="detail-chip-key">{{ str_replace('_',' ',$key) }}</div>
                                                <div class="detail-chip-value">
                                                    {{ is_array($value) ? implode(', ', $value) : $value }}
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif

                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($logs->hasPages())
            <div style="padding:16px 22px;border-top:1px solid #f0f2f7;display:flex;justify-content:flex-end;">
                {{ $logs->links() }}
            </div>
            @endif

            @else

            {{-- Empty state --}}
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-history"></i></div>
                <h4>Belum ada log aktivitas</h4>
                <p>
                    @if(request()->hasAny(['search','modul','aksi','dari','sampai']))
                        Tidak ada hasil yang cocok dengan filter.
                        <a href="{{ route('activity-log.index') }}" style="color:#667eea;font-weight:600;">Reset filter</a>
                    @else
                        Log akan muncul otomatis saat ada aktivitas pada sistem.
                    @endif
                </p>
            </div>

            @endif
        </div>

    </div>{{-- end main-content --}}
</div>{{-- end app-layout --}}

<script>
function toggleDetail(id, btn) {
    const row  = document.getElementById('detail-row-' + id);
    const open = row.style.display !== 'none';
    row.style.display = open ? 'none' : 'table-row';
    btn.innerHTML = open
        ? '<i class="fas fa-eye"></i> Lihat'
        : '<i class="fas fa-eye-slash"></i> Tutup';
}
</script>
</x-app-layout>
