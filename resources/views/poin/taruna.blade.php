<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.poin-layout { display: flex; min-height: 100vh; }
.main-content { flex:1; padding:28px 30px; min-width:0; }
.page-header { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius:18px; padding:28px 36px; color:white; margin-bottom:24px; position:relative; overflow:hidden; }
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:200px; height:200px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header-inner { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; }
.page-header h1 { margin:0 0 4px 0; font-size:22px; font-weight:800; }
.page-header p { margin:0; opacity:.85; font-size:13px; }
.poin-badge-header { background:rgba(255,255,255,.2); border-radius:14px; padding:10px 18px; text-align:center; backdrop-filter:blur(4px); }
.poin-badge-header .num { font-size:26px; font-weight:800; line-height:1; }
.poin-badge-header .lbl { font-size:11px; opacity:.85; }
.card { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:visible; margin-bottom:18px; }
.table-wrapper { border-radius:16px; overflow:hidden; }
.card-header { padding:16px 20px; border-bottom:1px solid #f0f2f7; display:flex; align-items:center; gap:10px; }
.card-header h3 { margin:0; font-size:14px; font-weight:700; color:#333; }
.icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:14px; color:white; }
.icon-green { background:linear-gradient(135deg,#38a169,#48bb78); }
.card-body { padding:20px; }
.badge-prestasi { display:inline-flex; align-items:center; gap:4px; background:#e6f9f0; color:#38a169; padding:3px 10px; border-radius:50px; font-size:11px; font-weight:700; }
.badge-pelanggaran { display:inline-flex; align-items:center; gap:4px; background:#fff5f5; color:#e53e3e; padding:3px 10px; border-radius:50px; font-size:11px; font-weight:700; }
.poin-positif { color:#38a169; font-weight:700; font-size:14px; }
.poin-negatif { color:#e53e3e; font-weight:700; font-size:14px; }
table { width:100%; border-collapse:collapse; }
thead tr { background:#f8f9ff; }
th { padding:11px 14px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; }
td { padding:12px 14px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr:hover { background:#fafbff; }
.empty-state { text-align:center; padding:48px; color:#bbb; }
.empty-state i { font-size:36px; display:block; margin-bottom:12px; }
.alert { padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:16px; display:flex; gap:8px; align-items:center; }
.alert-success { background:#e6f9f0; border:1px solid #9ae6b4; color:#276749; }
</style>

<div class="poin-layout">
    <x-sidebar active="poin" />

    <div class="main-content">
        <div class="page-header">
            <div class="page-header-inner">
                <div>
                    <h1><i class="fas fa-star"></i> Raport Poin Saya</h1>
                    <p>Lihat riwayat poin pengasuhan kamu &mdash; Prestasi &amp; Pelanggaran</p>
                </div>
                @if($selectedStudent)
                <div class="poin-badge-header">
                    <div class="num">{{ $totalPoin >= 0 ? '+' : '' }}{{ $totalPoin }}</div>
                    <div class="lbl">Total Poin {{ $selectedStudent['nickname'] }}</div>
                </div>
                @endif
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if(!$selectedStudent)
        <div class="card">
            <div class="empty-state">
                <i class="fas fa-user-graduate" style="color:#e8ebf5;"></i>
                <p>Data poin kamu tidak ditemukan.<br>Hubungi Pengasuh untuk verifikasi akun.</p>
            </div>
        </div>
        @else

        {{-- Ringkasan --}}
        <div class="card">
            <div class="card-header">
                <div class="icon icon-green"><i class="fas fa-chart-bar"></i></div>
                <h3>Ringkasan Poin &mdash; {{ $selectedStudent['nama'] }}</h3>
                <span style="margin-left:auto; background:#eef0ff; color:#667eea; font-size:11px; font-weight:700; padding:3px 10px; border-radius:50px;">
                    Kelas {{ $selectedStudent['kelas'] }}
                </span>
            </div>
            <div class="card-body" style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                @php
                    $totalPrestasi    = $riwayat->where('kategori','prestasi')->sum('nilai');
                    $totalPelanggaran = $riwayat->where('kategori','pelanggaran')->sum('nilai');
                @endphp
                <div style="background:#e6f9f0; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:#38a169;">+{{ $totalPrestasi }}</div>
                    <div style="font-size:12px; color:#38a169; font-weight:600; margin-top:4px;"><i class="fas fa-trophy"></i> Prestasi</div>
                </div>
                <div style="background:#fff5f5; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:#e53e3e;">-{{ $totalPelanggaran }}</div>
                    <div style="font-size:12px; color:#e53e3e; font-weight:600; margin-top:4px;"><i class="fas fa-exclamation-triangle"></i> Pelanggaran</div>
                </div>
                <div style="background:{{ $totalPoin >= 0 ? '#e6f9f0' : '#fff5f5' }}; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:{{ $totalPoin >= 0 ? '#38a169' : '#e53e3e' }};">
                        {{ $totalPoin >= 0 ? '+' : '' }}{{ $totalPoin }}
                    </div>
                    <div style="font-size:12px; color:#888; font-weight:600; margin-top:4px;"><i class="fas fa-star"></i> Total</div>
                </div>
            </div>
        </div>

        {{-- Riwayat (read-only) --}}
        <div class="card">
            <div class="card-header">
                <div class="icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);"><i class="fas fa-history"></i></div>
                <h3>Riwayat Poin</h3>
                <span style="margin-left:auto; background:#fdf0ff; color:#c026d3; font-size:12px; font-weight:700; padding:3px 10px; border-radius:50px;">
                    {{ $riwayat->count() }} entri
                </span>
            </div>
            @if($riwayat->isEmpty())
            <div class="empty-state">
                <i class="fas fa-inbox" style="color:#e8ebf5;"></i>
                <p>Belum ada data poin untukmu.</p>
            </div>
            @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Kegiatan</th>
                            <th>Poin</th>
                            <th>Pengasuh</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $r)
                        <tr>
                            <td style="white-space:nowrap; font-size:12px; color:#888;">{{ $r->tanggal->format('d M Y') }}</td>
                            <td>
                                @if($r->kategori === 'prestasi')
                                <span class="badge-prestasi"><i class="fas fa-trophy"></i> Prestasi</span>
                                @else
                                <span class="badge-pelanggaran"><i class="fas fa-exclamation-triangle"></i> Pelanggaran</span>
                                @endif
                            </td>
                            <td style="max-width:200px; font-weight:500;">{{ $r->kegiatan }}</td>
                            <td>
                                @if($r->kategori === 'prestasi')
                                <span class="poin-positif">+{{ $r->nilai }}</span>
                                @else
                                <span class="poin-negatif">-{{ $r->nilai }}</span>
                                @endif
                            </td>
                            <td style="font-size:12px; color:#666;">{{ $r->pengasuh }}</td>
                            <td style="font-size:12px; color:#888;">{{ $r->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
</x-app-layout>
