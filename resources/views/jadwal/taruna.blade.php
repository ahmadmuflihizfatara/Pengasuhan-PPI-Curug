<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

.page-header {
    background: linear-gradient(135deg, #4a3aa7 0%, #2a78d6 100%);
    border-radius: 18px; padding: 28px 32px; color: white; margin-bottom: 22px;
    position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:220px; height:220px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:70px; bottom:-80px; width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.88; font-size:13px; position:relative; z-index:1; }

/* Pengasuh hari ini */
.hero-card {
    background:linear-gradient(135deg,#4a3aa7,#2a78d6); border-radius:18px; padding:24px 28px;
    color:white; margin-bottom:22px; display:flex; align-items:center; gap:20px; flex-wrap:wrap;
    box-shadow:0 6px 20px rgba(74,58,167,.25);
}
.hero-avatar { width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,.22); display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:800; flex-shrink:0; }
.hero-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; opacity:.8; margin-bottom:3px; }
.hero-name { font-size:20px; font-weight:800; margin-bottom:2px; }
.hero-sub { font-size:12.5px; opacity:.85; }
.hero-note { margin-left:auto; background:rgba(255,255,255,.2); border-radius:12px; padding:9px 15px; font-size:12px; font-weight:600; max-width:280px; }

.hero-kosong { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); padding:34px 24px; text-align:center; margin-bottom:22px; }
.hero-kosong i { font-size:40px; color:#e2e5ee; display:block; margin-bottom:12px; }
.hero-kosong p { margin:0; font-size:14px; color:#98a0b3; font-weight:600; }

/* Duty */
.card { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; }
.card-head { padding:16px 22px; border-bottom:1px solid #f0f2f7; display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
.card-head h2 { font-size:15px; font-weight:700; color:#333; margin:0; display:flex; align-items:center; gap:8px; }
.periode-badge { background:#e8f8f2; color:#128a5f; font-size:12px; font-weight:700; padding:4px 13px; border-radius:20px; }

table { width:100%; border-collapse:collapse; }
thead tr { background:linear-gradient(135deg,#4a3aa7,#2a78d6); }
th { padding:12px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:white; }
td { padding:12px 16px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr:hover { background:#fafbff; }
.duty-avatar { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#1baf7a,#2a78d6); color:white; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; flex-shrink:0; }
.duty-name { font-weight:700; color:#2b2b33; }
.npm-badge { font-family:monospace; font-size:12px; color:#777; }
.pill { background:#eef0ff; color:#5a67d8; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:700; }
.pill-tingkat { background:#f0fff4; color:#38a169; }
.saya-badge { background:#fff0f6; color:#d53f8c; padding:2px 9px; border-radius:20px; font-size:10.5px; font-weight:800; margin-left:6px; }

.empty { text-align:center; padding:48px 20px; }
.empty i { font-size:40px; color:#e2e5ee; display:block; margin-bottom:12px; }
.empty p { margin:0; font-size:14px; font-weight:600; color:#98a0b3; }
</style>

<div class="app-layout">
    <x-sidebar active="jadwal" />

    <div class="main-content">

        <div class="page-header">
            <h1><i class="fas fa-user-clock" style="margin-right:10px;"></i>Jadwal</h1>
            <p>Pengasuh yang bertugas hari ini dan daftar duty taruna minggu ini</p>
        </div>

        {{-- Pengasuh bertugas hari ini --}}
        @if($pengasuh)
        <div class="hero-card">
            <div class="hero-avatar">{{ strtoupper(substr($pengasuh->nama, 0, 2)) }}</div>
            <div>
                <div class="hero-label">Pengasuh Bertugas Hari Ini</div>
                <div class="hero-name">{{ $pengasuh->nama }}</div>
                <div class="hero-sub">{{ $hariIni->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
            </div>
            @if($catatan)
            <div class="hero-note"><i class="fas fa-note-sticky"></i> {{ $catatan }}</div>
            @endif
        </div>
        @else
        <div class="hero-kosong">
            <i class="fas fa-user-clock"></i>
            <p>Belum ada pengasuh yang dijadwalkan untuk hari ini.</p>
        </div>
        @endif

        {{-- Duty taruna minggu ini --}}
        <div class="card">
            <div class="card-head">
                <h2><i class="fas fa-user-group" style="color:#1baf7a;"></i> Duty Taruna Minggu Ini</h2>
                <span class="periode-badge">{{ \App\Models\DutyTaruna::labelPeriode($mingguIni) }}</span>
            </div>

            @if($duty->isEmpty())
            <div class="empty">
                <i class="fas fa-clipboard-list"></i>
                <p>Belum ada duty taruna yang ditetapkan untuk minggu ini.</p>
            </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAMA TARUNA</th>
                        <th>NPM</th>
                        <th>PRODI</th>
                        <th>TINGKAT</th>
                    </tr>
                </thead>
                <tbody>
                    @php $mahasiswaSaya = Auth::user()->mahasiswa?->id; @endphp
                    @foreach($duty as $i => $d)
                    <tr>
                        <td style="color:#bbb; font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="duty-avatar">{{ strtoupper(substr($d->mahasiswa->nama ?? '?', 0, 2)) }}</div>
                                <span class="duty-name">{{ $d->mahasiswa->nama ?? '—' }}</span>
                                @if($mahasiswaSaya && $d->mahasiswa_id === $mahasiswaSaya)
                                <span class="saya-badge">SAYA</span>
                                @endif
                            </div>
                        </td>
                        <td><span class="npm-badge">{{ $d->mahasiswa->npm ?? '-' }}</span></td>
                        <td><span class="pill">{{ $d->mahasiswa->prodi ?? '-' }}</span></td>
                        <td><span class="pill pill-tingkat">{{ $d->mahasiswa->tingkat ?? '-' }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

    </div>
</div>
</x-app-layout>
