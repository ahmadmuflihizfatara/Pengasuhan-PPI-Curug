<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

.page-header {
    background: linear-gradient(135deg, #f7b733 0%, #fc4a1a 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:80px; bottom:-60px; width:140px; height:140px; background:rgba(255,255,255,.06); border-radius:50%; }
.page-header-text { position:relative; z-index:1; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; }
.page-header p  { margin:0; opacity:.85; font-size:13px; }

.alert-success { background:linear-gradient(135deg,#43e97b,#38f9d7); color:white; padding:14px 20px; border-radius:12px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:14px; }
.alert-error   { background:linear-gradient(135deg,#fc5c7d,#e53e3e); color:white; padding:14px 20px; border-radius:12px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:14px; }

.stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 20px; }
.stat-card  { background: white; border-radius: 14px; padding: 16px; box-shadow: 0 2px 10px rgba(0,0,0,.05); text-align: center; }
.stat-icon  { width: 36px; height: 36px; border-radius: 10px; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
.stat-count { font-size: 22px; font-weight: 800; color: #333; }
.stat-label { font-size: 10px; color: #aab; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin-top: 2px; }

.filter-bar { background: white; border-radius: 14px; padding: 16px 20px; box-shadow: 0 2px 10px rgba(0,0,0,.05); margin-bottom: 18px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.search-wrap { position: relative; flex: 1; min-width: 200px; }
.search-wrap .fa-search { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 12px; pointer-events: none; }
.search-input { width: 100%; padding: 9px 14px 9px 34px; border: 1.5px solid #edf0f7; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; color: #444; outline: none; background: #fafbff; }
.search-input:focus { border-color: #f5b301; }
.filter-select { padding: 9px 14px; border: 1.5px solid #edf0f7; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; color: #444; outline: none; background: #fafbff; cursor: pointer; }
.btn-filter { background: linear-gradient(135deg,#f7b733,#fc4a1a); color: white; border: none; padding: 9px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px; }
.btn-reset { color: #b45309; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; }

.card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.06); }
.empty-state { text-align:center; padding:60px 20px; }
.empty-state i  { font-size:56px; color:#e2e5ee; margin-bottom:16px; display:block; }
.empty-state h4 { color:#aab; margin:0 0 8px; font-size:16px; }
.empty-state p  { color:#ccc; margin:0; font-size:14px; }

table { width: 100%; border-collapse: collapse; }
thead tr { background: linear-gradient(135deg,#f7b733,#fc4a1a); }
th { padding: 14px 18px; text-align: left; color: white; font-size: 11px; font-weight: 700; letter-spacing: .06em; }
td { padding: 14px 18px; font-size: 13px; color: #444; border-top: 1px solid #f0f2f7; }
tbody tr { transition: background .1s; }
tbody tr:hover { background: #fffaf0; }

.jenis-pill { background:#fef3e0; color:#b45309; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px; }
.status-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; gap: 5px; }
.btn-view { background: #fef3e0; color: #b45309; border: none; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; }
.btn-view:hover { background: #fde3ae; }

.pagination-bar   { padding: 14px 18px; border-top: 1px solid #f0f2f7; display: flex; align-items: center; justify-content: space-between; }
.pagination-info  { font-size: 12px; color: #aab; }
.pagination-links { display: flex; gap: 6px; }
.page-btn { padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; }
.page-btn.normal { background: #f4f5f9; color: #666; }
.page-btn.active-pg { background: linear-gradient(135deg,#f7b733,#fc4a1a); color: white; }
.page-btn.disabled { background: #f4f5f9; color: #ccc; pointer-events: none; }
</style>

<div class="app-layout">
    <x-sidebar active="reward" />

    <div class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1><i class="fas fa-award" style="margin-right:10px;"></i>Kelola Reward Taruna</h1>
                <p>Lihat, proses, dan setujui pengajuan reward dari taruna</p>
            </div>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:18px;"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle" style="font-size:18px;"></i> {{ session('error') }}
        </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#a78bfa,#6d28d9);"><i class="fas fa-award"></i></div>
                <div class="stat-count">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Reward</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#f6ad55,#e07020);"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-count">{{ $stats['diajukan'] }}</div>
                <div class="stat-label">Diajukan</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#63b3ed,#3182ce);"><i class="fas fa-spinner"></i></div>
                <div class="stat-count">{{ $stats['diproses'] }}</div>
                <div class="stat-label">Diproses</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#48bb78,#38a169);"><i class="fas fa-check-circle"></i></div>
                <div class="stat-count">{{ $stats['disetujui'] }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#fc8181,#e53e3e);"><i class="fas fa-times-circle"></i></div>
                <div class="stat-count">{{ $stats['ditolak'] }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>

        <div class="filter-bar">
            <form method="GET" action="{{ route('reward.kelola') }}" style="display:contents;">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama, email, NPM..." class="search-input">
                </div>
                <select name="kategori" class="filter-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $k)
                        <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
                @if(request()->hasAny(['search','kategori','status']))
                <a href="{{ route('reward.kelola') }}" class="btn-reset"><i class="fas fa-times"></i> Reset</a>
                @endif
            </form>
        </div>

        @if($daftarReward->isEmpty())
        <div class="card">
            <div class="empty-state">
                <i class="fas fa-award"></i>
                <h4>Belum ada reward</h4>
                <p>Belum ada pengajuan reward yang cocok dengan filter Anda.</p>
            </div>
        </div>
        @else
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>PENGAJU</th>
                        <th>KATEGORI</th>
                        <th>JENIS</th>
                        <th>TANGGAL</th>
                        <th style="text-align:center;">STATUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarReward as $i => $r)
                    <tr>
                        <td style="color:#bbb; font-weight:600;">{{ $daftarReward->firstItem() + $i }}</td>
                        <td>
                            <div style="font-weight:700; color:#333;">{{ $r->nama }}</div>
                            <div style="font-size:11px; color:#aab;">{{ $r->email }}</div>
                            <div style="font-size:11px; color:#aab; margin-top:2px;">{{ $r->npm }} · {{ $r->prodi }}</div>
                        </td>
                        <td>
                            <span style="font-weight:700; color:#333;">{{ $r->kategori }}</span>
                        </td>
                        <td>
                            <span class="jenis-pill">
                                <i class="fas {{ $r->jenis === 'kelompok' ? 'fa-users' : 'fa-user' }}"></i>
                                {{ ucfirst($r->jenis) }}{{ $r->jenis === 'kelompok' ? ' ('.$r->jumlah_anggota.')' : '' }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:#666; white-space:nowrap;">
                            <i class="fas fa-calendar" style="color:#f5b301; margin-right:5px;"></i>
                            {{ $r->tanggal_prestasi->locale('id')->isoFormat('D MMM Y') }}
                        </td>
                        <td style="text-align:center;">
                            <span class="status-badge" style="background:{{ $r->status_bg_color }}; color:{{ $r->status_badge_color }};">
                                {{ $r->status }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <a href="{{ route('reward.detail', $r->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($daftarReward->hasPages())
            <div class="pagination-bar">
                <div class="pagination-info">Menampilkan {{ $daftarReward->firstItem() }}–{{ $daftarReward->lastItem() }} dari {{ $daftarReward->total() }} reward</div>
                <div class="pagination-links">
                    @if($daftarReward->onFirstPage())
                        <span class="page-btn disabled">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $daftarReward->previousPageUrl() }}" class="page-btn normal">‹ Sebelumnya</a>
                    @endif
                    @if($daftarReward->hasMorePages())
                        <a href="{{ $daftarReward->nextPageUrl() }}" class="page-btn active-pg">Berikutnya ›</a>
                    @else
                        <span class="page-btn disabled">Berikutnya ›</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
</x-app-layout>
