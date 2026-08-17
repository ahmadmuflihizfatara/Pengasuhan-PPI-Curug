<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.app-layout {
    display: flex;
    min-height: 100vh;
    /* Margin negatif tidak lagi dibutuhkan karena navbar sudah dihapus dari app.blade.php */
}

/* === MAIN === */
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

/* === GREETING BANNER === */
.greeting-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 32px 36px;
    color: white;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.greeting-banner::before { content: ''; position: absolute; right: -60px; top: -60px; width: 220px; height: 220px; background: rgba(255,255,255,.08); border-radius: 50%; }
.greeting-banner::after  { content: ''; position: absolute; right: 100px; bottom: -80px; width: 180px; height: 180px; background: rgba(255,255,255,.06); border-radius: 50%; }
.greeting-text { position: relative; z-index: 1; }
.greeting-text .greeting { font-size: 13px; opacity: .8; margin-bottom: 4px; }
.greeting-text h1 { font-size: 24px; font-weight: 800; margin: 0 0 6px 0; }
.greeting-text p  { font-size: 13px; opacity: .85; margin: 0; }
.greeting-badge {
    position: relative; z-index: 1;
    background: rgba(255,255,255,.18);
    border-radius: 16px; padding: 16px 22px;
    text-align: center; backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,.25);
}
.greeting-badge .ava { width: 52px; height: 52px; border-radius: 50%; background: rgba(255,255,255,.25); display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; margin: 0 auto 8px; }
.greeting-badge .username { font-size: 13px; font-weight: 700; }
.greeting-badge .role     { font-size: 11px; opacity: .8; }

/* === STAT CARDS === */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.stat-card {
    background: white; border-radius: 14px; padding: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    text-decoration: none; display: block;
    transition: transform .2s, box-shadow .2s; cursor: pointer;
    color: inherit;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.1); color: inherit; }
.stat-icon  { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 18px; color: white; }
.stat-count { font-size: 26px; font-weight: 800; color: #333; line-height: 1; margin-bottom: 4px; }
.stat-label { font-size: 12px; color: #888; font-weight: 500; }
.stat-change { font-size: 11px; margin-top: 6px; font-weight: 600; }
.stat-change.up      { color: #38a169; }
.stat-change.neutral { color: #aab; }

/* === TWO COLUMN === */
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }

/* === SECTION HEADER === */
.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.section-title  { font-size: 15px; font-weight: 700; color: #333; margin: 0; }
.section-link   { font-size: 12px; color: #667eea; font-weight: 600; text-decoration: none; }
.section-link:hover { text-decoration: underline; }

/* === CARD === */
.card      { background: white; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.05); }
.card-body { padding: 20px; }

/* === ACARA CARDS === */
.acara-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px; }
.acara-card { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.06); transition: transform .2s; }
.acara-card:hover { transform: translateY(-4px); }
.acara-card-img  { height: 100px; display: flex; align-items: center; justify-content: center; position: relative; }
.acara-card-img .acara-time { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,.2); padding: 5px 12px; font-size: 11px; color: white; font-weight: 600; display: flex; align-items: center; gap: 5px; }
.acara-card-body  { padding: 14px; }
.acara-date       { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 5px; }
.acara-card-title { font-size: 13px; font-weight: 700; color: #333; line-height: 1.4; margin-bottom: 4px; }
.acara-card-desc  { font-size: 11px; color: #aab; line-height: 1.4; }

/* === TABLES === */
.surat-table table, .acara-table table { width: 100%; border-collapse: collapse; }
.surat-table th, .acara-table th { padding: 12px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #8a93b0; background: #f8f9ff; }
.surat-table td, .acara-table td { padding: 12px 16px; font-size: 13px; color: #444; border-top: 1px solid #f0f2f7; }
.surat-table tr:hover td, .acara-table tr:hover td { background: #fafbff; }
.status-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.time-badge   { background: #eef0ff; color: #667eea; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }

/* === EMPTY === */
.empty-mini { text-align: center; padding: 28px 16px; color: #bbb; }
.empty-mini i { font-size: 28px; display: block; margin-bottom: 8px; }
.empty-mini p { font-size: 13px; margin: 0; }
</style>

<div class="app-layout">

    {{-- ── SIDEBAR ── --}}
    <x-sidebar active="dashboard" />

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- Greeting Banner -->
        <div class="greeting-banner">
            <div class="greeting-text">
                @php
                    $hour     = (int) now()->setTimezone('Asia/Jakarta')->format('H');
                    $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
                @endphp
                <div class="greeting">{{ $greeting }},</div>
                <h1>{{ Auth::user()->name }} 👋</h1>
                <p>Selamat datang di Dashboard Pengasuhan — semua data tersaji dengan rapi.</p>
            </div>
            <div class="greeting-badge">
                <div class="ava">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="username">{{ Auth::user()->name }}</div>
                <div class="role">{{ Auth::user()->role_label }}</div>
            </div>
        </div>

        <!-- ── STAT CARDS ── -->
        @if(Auth::user()->isTaruna())
        <div class="stats-grid" style="grid-template-columns:repeat(2,1fr);">
            <div class="stat-card" style="cursor:default;">
                <div class="stat-icon" style="background:linear-gradient(135deg,#667eea,#764ba2);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-count" style="font-size:18px;">{{ Auth::user()->name }}</div>
                <div class="stat-label">Akun Taruna</div>
                <div class="stat-change neutral"><i class="fas fa-id-badge"></i> {{ Auth::user()->jabatan ?? 'Taruna' }}</div>
            </div>
            <a href="{{ route('poin.index') }}" class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-count" id="taruna-total-poin">{{ $totalPoin >= 0 ? '+' : '' }}{{ $totalPoin }}</div>
                <div class="stat-label">Raport Poin Saya</div>
                <div class="stat-change up"><i class="fas fa-arrow-right"></i> Klik untuk buka</div>
            </a>
        </div>

        <x-prodi-tingkat-chart :chart-data="$chartData" />

        @else
        <div class="stats-grid">
            <div class="stat-card" style="cursor:default;">
                <div class="stat-icon" style="background:linear-gradient(135deg,#667eea,#764ba2);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-count">{{ $totalMahasiswa }}</div>
                <div class="stat-label">Total Mahasiswa</div>
                <div class="stat-change neutral"><i class="fas fa-graduation-cap"></i> Semua kelas</div>
            </div>
            <a href="{{ route('acara.index') }}" class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#43e97b,#38a169);">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-count">{{ $semuaAcara->count() }}</div>
                <div class="stat-label">Total Acara</div>
                <div class="stat-change {{ $acaraMendatang->count() > 0 ? 'up' : 'neutral' }}">
                    <i class="fas fa-calendar-day"></i> {{ $acaraMendatang->count() }} mendatang
                </div>
            </a>
            <a href="{{ route('surat.index') }}" class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-count">{{ $suratStats['total'] }}</div>
                <div class="stat-label">Total Surat</div>
                <div class="stat-change neutral">
                    <i class="fas fa-spinner"></i> {{ $suratStats['diproses'] }} diproses
                </div>
            </a>
            <a href="{{ route('surat.index') }}" class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#0bc5ea,#3182ce);">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-count">{{ $suratStats['selesai'] }}</div>
                <div class="stat-label">Surat Selesai</div>
                <div class="stat-change up"><i class="fas fa-check-circle"></i> disetujui &amp; selesai</div>
            </a>
            <a href="{{ route('keluhan-barak.kelola') }}" class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="stat-count">{{ $keluhanStats['total'] }}</div>
                <div class="stat-label">Keluhan Barak</div>
                <div class="stat-change {{ $keluhanStats['diajukan'] > 0 ? 'up' : 'neutral' }}">
                    <i class="fas fa-hourglass-half"></i> {{ $keluhanStats['diajukan'] }} diajukan
                </div>
            </a>
        </div>
        @endif

        {{-- ── WIDGET MONITORING PERGERAKAN TARUNA ── --}}
        @php
            $activePergerakan = \App\Models\LogPergerakan::where('status', 'berangkat')->count();
            $kembaliHariIni   = \App\Models\LogPergerakan::whereDate('waktu_berangkat', \Carbon\Carbon::today())->where('status', 'kembali')->count();
        @endphp
        <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid #334155; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; color: white; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 50px; height: 50px; border-radius: 14px; background: rgba(59, 130, 246, 0.2); border: 1px solid #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px; color: #60a5fa;">
                    <i class="fas fa-walking"></i>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Log Pergerakan Taruna (Sistem Pos Jaga)</div>
                    <div style="font-size: 18px; font-weight: 800; color: white; margin-top: 2px;">
                        <span style="color: #f87171; font-weight: 900;">🔴 {{ $activePergerakan }} Taruna</span> sedang di luar asrama
                        <span style="font-size: 13px; color: #94a3b8; font-weight: 500; margin-left: 8px;">(🟢 {{ $kembaliHariIni }} kembali hari ini)</span>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('log-pergerakan.tablet') }}" style="background: #2563eb; color: white; border-radius: 10px; padding: 10px 18px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s;">
                    <i class="fas fa-tablet-alt"></i> Mode Tablet Pos Jaga
                </a>
                <a href="{{ route('log-pergerakan.tv') }}" target="_blank" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid #10b981; border-radius: 10px; padding: 10px 18px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-tv"></i> Buka TV Monitoring
                </a>
            </div>
        </div>

        <!-- ── ACARA MENDATANG ── -->
        @if(!Auth::user()->isTaruna())
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-calendar-star" style="color:#667eea;margin-right:8px;"></i>
                Acara Pengasuhan Mendatang
            </h3>
            <a href="{{ route('acara.index') }}" class="section-link">Kelola Acara →</a>
        </div>

        @if($acaraMendatang->isEmpty())
        <div class="card" style="margin-bottom:24px;">
            <div class="card-body">
                <div class="empty-mini">
                    <i class="fas fa-calendar-times" style="color:#e2e5ee;"></i>
                    <p>Belum ada acara dijadwalkan.
                        <a href="{{ route('acara.create') }}" style="color:#667eea;font-weight:600;">+ Tambah Acara</a>
                    </p>
                </div>
            </div>
        </div>
        @else
        <div class="acara-grid" style="margin-bottom:24px;">
            @php
                $acara_colors = [
                    ['#667eea','#764ba2'],['#f093fb','#f5576c'],
                    ['#43e97b','#38a169'],['#0bc5ea','#3182ce'],
                ];
                $ci = 0;
            @endphp
            @foreach($acaraMendatang as $event)
            @php $col = $acara_colors[$ci % count($acara_colors)]; $ci++; @endphp
            <div class="acara-card">
                <div class="acara-card-img" style="background:linear-gradient(135deg,{{ $col[0] }},{{ $col[1] }});">
                    <i class="fas fa-calendar-check" style="font-size:32px;color:rgba(255,255,255,.6);"></i>
                    <div class="acara-time">
                        <i class="fas fa-clock"></i>
                        {{ \Carbon\Carbon::parse($event->jam)->format('H:i') }} WIB
                    </div>
                </div>
                <div class="acara-card-body">
                    <div class="acara-date" style="color:{{ $col[0] }};">
                        <i class="fas fa-calendar-day" style="margin-right:4px;"></i>
                        {{ \Carbon\Carbon::parse($event->tanggal)->locale('id')->isoFormat('D MMMM Y') }}
                    </div>
                    <div class="acara-card-title">{{ $event->nama_acara }}</div>
                    @if($event->keterangan)
                    <div class="acara-card-desc">{{ Str::limit($event->keterangan, 60) }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- ── SURAT TERBARU + JADWAL ACARA ── -->
        <div class="two-col">
            <!-- Surat Terbaru -->
            <div>
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-envelope-open-text" style="color:#f5576c;margin-right:8px;"></i>Surat Terbaru
                    </h3>
                    <a href="{{ route('surat.index') }}" class="section-link">Lihat Semua →</a>
                </div>
                <div class="card surat-table">
                    @if($suratTerbaru->isEmpty())
                    <div class="card-body">
                        <div class="empty-mini">
                            <i class="fas fa-inbox" style="color:#e2e5ee;"></i>
                            <p>Belum ada surat.
                                <a href="{{ route('surat.create') }}" style="color:#667eea;font-weight:600;">+ Tambah</a>
                            </p>
                        </div>
                    </div>
                    @else
                    <table>
                        <thead>
                            <tr>
                                <th>PERIHAL</th>
                                <th>JENIS</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suratTerbaru as $s)
                            <tr onclick="window.location='{{ route('surat.show', $s->id) }}'" style="cursor:pointer;">
                                <td>
                                    <div style="font-weight:600;color:#333;font-size:12px;">{{ Str::limit($s->perihal, 30) }}</div>
                                    <div style="font-size:11px;color:#aab;">{{ $s->pengirim }}</div>
                                </td>
                                <td>
                                    <span style="background:#eef0ff;color:#667eea;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;white-space:nowrap;">
                                        {{ Str::limit($s->jenis_surat, 15) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge" style="background:{{ $s->status_bg_color }};color:{{ $s->status_badge_color }};">
                                        {{ $s->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

            <!-- Jadwal Acara -->
            <div>
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-calendar-alt" style="color:#667eea;margin-right:8px;"></i>Jadwal Acara
                    </h3>
                    <a href="{{ route('acara.create') }}" class="section-link">+ Tambah</a>
                </div>
                <div class="card acara-table">
                    @if($semuaAcara->isEmpty())
                    <div class="card-body">
                        <div class="empty-mini">
                            <i class="fas fa-calendar-times" style="color:#e2e5ee;"></i>
                            <p>Belum ada jadwal.</p>
                        </div>
                    </div>
                    @else
                    <table>
                        <thead>
                            <tr>
                                <th>NAMA ACARA</th>
                                <th>TANGGAL</th>
                                <th>JAM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semuaAcara->take(5) as $a)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <i class="fas fa-calendar-check" style="color:white;font-size:11px;"></i>
                                        </div>
                                        <span style="font-weight:600;color:#333;font-size:12px;">{{ Str::limit($a->nama_acara, 25) }}</span>
                                    </div>
                                </td>
                                <td style="font-size:12px;color:#666;white-space:nowrap;">
                                    {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                                </td>
                                <td><span class="time-badge">{{ \Carbon\Carbon::parse($a->jam)->format('H:i') }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- ── QUICK ACTIONS ── -->
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-bolt" style="color:#e07020;margin-right:8px;"></i>Aksi Cepat
            </h3>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;">
            <a href="{{ route('surat.create') }}" style="background:linear-gradient(135deg,#f093fb,#f5576c);border-radius:14px;padding:18px;color:white;text-decoration:none;display:flex;align-items:center;gap:12px;font-weight:700;font-size:13px;transition:transform .15s;box-shadow:0 4px 15px rgba(245,87,108,.3);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform=''">
                <i class="fas fa-file-alt" style="font-size:20px;opacity:.9;"></i>
                <div><div style="font-size:11px;opacity:.8;font-weight:400;">Buat</div>Surat Baru</div>
            </a>
            <a href="{{ route('acara.create') }}" style="background:linear-gradient(135deg,#667eea,#764ba2);border-radius:14px;padding:18px;color:white;text-decoration:none;display:flex;align-items:center;gap:12px;font-weight:700;font-size:13px;transition:transform .15s;box-shadow:0 4px 15px rgba(102,126,234,.3);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform=''">
                <i class="fas fa-calendar-plus" style="font-size:20px;opacity:.9;"></i>
                <div><div style="font-size:11px;opacity:.8;font-weight:400;">Tambah</div>Acara</div>
            </a>
            <a href="{{ route('poin.index') }}" style="background:linear-gradient(135deg,#43e97b,#38a169);border-radius:14px;padding:18px;color:white;text-decoration:none;display:flex;align-items:center;gap:12px;font-weight:700;font-size:13px;transition:transform .15s;box-shadow:0 4px 15px rgba(56,161,105,.3);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform=''">
                <i class="fas fa-star" style="font-size:20px;opacity:.9;"></i>
                <div><div style="font-size:11px;opacity:.8;font-weight:400;">Kelola</div>Poin Mahasiswa</div>
            </a>
            <a href="{{ route('mahasiswa.index') }}" style="background:linear-gradient(135deg,#0bc5ea,#3182ce);border-radius:14px;padding:18px;color:white;text-decoration:none;display:flex;align-items:center;gap:12px;font-weight:700;font-size:13px;transition:transform .15s;box-shadow:0 4px 15px rgba(49,130,206,.3);" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform=''">
                <i class="fas fa-users" style="font-size:20px;opacity:.9;"></i>
                <div><div style="font-size:11px;opacity:.8;font-weight:400;">Lihat</div>Database Mahasiswa</div>
            </a>
        </div>
        @endif

    </div>{{-- end main-content --}}
</div>{{-- end app-layout --}}

@if(Auth::user()->isTaruna())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const totalPoinEl = document.getElementById('taruna-total-poin');
        
        function pollPoints() {
            fetch("{{ route('api.myPoints') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const total = data.totalPoin;
                        if (totalPoinEl) {
                            totalPoinEl.textContent = (total >= 0 ? '+' : '') + total;
                        }
                    }
                })
                .catch(err => console.error("Error polling points:", err));
        }

        // Poll every 3 seconds
        setInterval(pollPoints, 3000);
    });
</script>
@endif

</x-app-layout>
