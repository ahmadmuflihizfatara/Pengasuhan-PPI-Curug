<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

/* Header */
.page-header {
    background: linear-gradient(135deg, #4a3aa7 0%, #2a78d6 100%);
    border-radius: 18px; padding: 28px 32px;
    color: white; margin-bottom: 22px;
    position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:220px; height:220px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:70px; bottom:-80px; width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.88; font-size:13px; position:relative; z-index:1; }

.btn-primary {
    background:white; color:#4a3aa7; border:none;
    padding:10px 18px; border-radius:11px; font-size:13px; font-weight:700;
    cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px;
    position:relative; z-index:1; transition:transform .15s, box-shadow .15s;
    box-shadow:0 4px 14px rgba(0,0,0,.12); font-family:'Inter',sans-serif;
}
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 22px rgba(0,0,0,.18); color:#4a3aa7; }

.flash-success { background:#f0fff4; border:1px solid #c6f6d5; color:#276749; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:8px; }

/* Hero: petugas hari ini */
.hero-card {
    background:linear-gradient(135deg,#4a3aa7,#2a78d6); border-radius:18px; padding:24px 28px;
    color:white; margin-bottom:22px; display:flex; align-items:center; gap:20px; flex-wrap:wrap;
    box-shadow:0 6px 20px rgba(74,58,167,.25);
}
.hero-avatar {
    width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,.22);
    display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:800; flex-shrink:0;
}
.hero-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; opacity:.8; margin-bottom:3px; }
.hero-name { font-size:20px; font-weight:800; margin-bottom:2px; }
.hero-sub { font-size:12.5px; opacity:.85; }
.hero-badge { margin-left:auto; background:rgba(255,255,255,.2); border-radius:20px; padding:7px 16px; font-size:12px; font-weight:700; display:flex; align-items:center; gap:6px; }

/* Roster mingguan */
.roster-card { background:white; border-radius:16px; padding:18px 22px; box-shadow:0 2px 12px rgba(0,0,0,.05); margin-bottom:22px; }
.roster-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; margin-bottom:12px; }
.roster-row { display:flex; gap:10px; flex-wrap:wrap; }
.roster-chip { display:flex; align-items:center; gap:8px; background:#fafbff; border:1px solid #eef0f7; border-radius:11px; padding:8px 12px; }
.roster-chip .day { font-size:10px; font-weight:800; color:#4a3aa7; text-transform:uppercase; }
.roster-chip .nm  { font-size:12px; font-weight:600; color:#333; }

/* Month nav + generate */
.month-bar { display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; flex-wrap:wrap; gap:12px; }
.month-nav { display:flex; align-items:center; gap:10px; background:white; border-radius:12px; padding:8px 10px; box-shadow:0 2px 12px rgba(0,0,0,.05); }
.month-nav-btn { width:32px; height:32px; border-radius:8px; border:none; background:#f4f3ff; color:#4a3aa7; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .15s; text-decoration:none; }
.month-nav-btn:hover { background:#e7e4ff; }
.month-title { font-size:15px; font-weight:800; color:#333; min-width:150px; text-align:center; }
.btn-generate {
    background:linear-gradient(135deg,#4a3aa7,#2a78d6); color:white; border:none;
    padding:10px 20px; border-radius:11px; font-size:13px; font-weight:700;
    cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:opacity .15s;
    font-family:'Inter',sans-serif;
}
.btn-generate:hover { opacity:.9; }
.generated-badge { background:#f0fff4; color:#276749; border:1px solid #c6f6d5; border-radius:11px; padding:9px 16px; font-size:12.5px; font-weight:700; display:flex; align-items:center; gap:7px; }

/* Timeline */
.timeline { position:relative; padding-left:38px; }
.timeline::before { content:''; position:absolute; left:14px; top:8px; bottom:8px; width:2px; background:#e8ebf5; }

.tl-item { position:relative; margin-bottom:14px; }
.tl-dot {
    position:absolute; left:-38px; top:14px; width:30px; height:30px; border-radius:50%;
    background:white; border:2px solid #e8ebf5; color:#98a0b3;
    display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; z-index:1;
}
.tl-item.is-today .tl-dot { background:linear-gradient(135deg,#4a3aa7,#2a78d6); border-color:transparent; color:white; box-shadow:0 0 0 4px rgba(74,58,167,.15); }

.tl-card {
    background:white; border-radius:14px; padding:14px 18px; box-shadow:0 2px 10px rgba(0,0,0,.05);
    display:flex; align-items:center; gap:14px; flex-wrap:wrap; border:2px solid transparent; transition:border-color .15s;
}
.tl-item.is-today .tl-card { border-color:#4a3aa7; background:#f8f7ff; }
.tl-date { min-width:120px; }
.tl-date .day-name { font-size:11px; font-weight:700; color:#8a93b0; text-transform:uppercase; letter-spacing:.04em; }
.tl-date .day-full  { font-size:13px; font-weight:700; color:#333; }

.tl-pengasuh { display:flex; align-items:center; gap:10px; flex:1; min-width:180px; }
.tl-avatar { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#4a3aa7,#2a78d6); color:white; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; flex-shrink:0; }
.tl-pengasuh-name { font-size:13.5px; font-weight:700; color:#2b2b33; }
.tl-catatan { font-size:11.5px; color:#98a0b3; margin-top:1px; }

.tl-status { font-size:10.5px; font-weight:700; padding:3px 10px; border-radius:20px; white-space:nowrap; }
.tl-status.saved   { background:#f0fff4; color:#276749; }
.tl-status.default { background:#fff8ec; color:#a06a0a; }

.btn-swap {
    background:#f4f3ff; color:#4a3aa7; border:none; padding:7px 13px; border-radius:9px;
    font-size:11.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:5px; transition:background .15s;
}
.btn-swap:hover { background:#e7e4ff; }

.empty-roster { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); text-align:center; padding:60px 24px; }
.empty-roster i { font-size:46px; color:#e2e5ee; display:block; margin-bottom:14px; }
.empty-roster p { font-size:14px; color:#98a0b3; margin:0 0 6px; font-weight:600; }
.empty-roster small { color:#c3c8d6; }

/* Modal swap */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:18px; padding:26px 26px 22px; max-width:380px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,.2); animation:modalIn .15s ease; }
@keyframes modalIn { from{transform:scale(.95);opacity:0} to{transform:scale(1);opacity:1} }
.modal-box h3 { margin:0 0 4px; font-size:16px; font-weight:800; color:#333; }
.modal-box .modal-sub { font-size:12px; color:#98a0b3; margin:0 0 18px; }
.modal-box label { font-size:11.5px; font-weight:700; color:#555; display:block; margin-bottom:6px; }
.modal-box select, .modal-box textarea {
    width:100%; padding:10px 12px; border:2px solid #e8ebf5; border-radius:10px;
    font-size:13px; font-family:'Inter',sans-serif; color:#333; outline:none; margin-bottom:14px; background:#fafbff;
}
.modal-box select:focus, .modal-box textarea:focus { border-color:#4a3aa7; background:white; }
.modal-box textarea { resize:vertical; min-height:64px; }
.modal-actions { display:flex; gap:10px; justify-content:flex-end; }
.modal-cancel { background:#f4f5f9; color:#666; border:none; padding:10px 20px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-cancel:hover { background:#e8e9f0; }
.modal-confirm { background:linear-gradient(135deg,#4a3aa7,#2a78d6); color:white; border:none; padding:10px 20px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-confirm:hover { opacity:.9; }
</style>

<div class="app-layout">
    <x-sidebar active="jadwal" />

    <div class="main-content">

        <div class="page-header">
            <div>
                <h1><i class="fas fa-user-clock" style="margin-right:10px;"></i>Jadwal Pengasuh</h1>
                <p>Jadwal jaga pengasuh bulanan — satu pengasuh bertugas tetap per hari</p>
            </div>
        </div>

        @if(session('success'))
        <div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        {{-- Petugas hari ini --}}
        @if($petugasHariIni && $petugasHariIni['pengasuh'])
        <div class="hero-card">
            <div class="hero-avatar">{{ strtoupper(substr($petugasHariIni['pengasuh']->nama, 0, 2)) }}</div>
            <div>
                <div class="hero-label">Bertugas Hari Ini</div>
                <div class="hero-name">{{ $petugasHariIni['pengasuh']->nama }}</div>
                <div class="hero-sub">{{ $petugasHariIni['tanggal']->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
            </div>
            <div class="hero-badge">
                <i class="fas {{ $petugasHariIni['tersimpan'] ? 'fa-check-circle' : 'fa-circle-info' }}"></i>
                {{ $petugasHariIni['tersimpan'] ? 'Jadwal Tersimpan' : 'Jadwal Default Mingguan' }}
            </div>
        </div>
        @endif

        {{-- Roster mingguan tetap --}}
        @if($semuaPengasuh->isNotEmpty())
        <div class="roster-card">
            <div class="roster-title"><i class="fas fa-repeat" style="margin-right:5px;"></i>Roster Mingguan Tetap</div>
            <div class="roster-row">
                @foreach($semuaPengasuh as $p)
                <div class="roster-chip">
                    <span class="day">{{ $p->hari_label }}</span>
                    <span class="nm">{{ $p->nama }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Navigasi bulan + generate --}}
        <div class="month-bar">
            <div class="month-nav">
                @php
                    $prev = \Carbon\Carbon::create($tahun, $bulan, 1)->subMonth();
                    $next = \Carbon\Carbon::create($tahun, $bulan, 1)->addMonth();
                @endphp
                <a href="{{ route('jadwal.index', ['bulan' => $prev->month, 'tahun' => $prev->year]) }}" class="month-nav-btn">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <span class="month-title">{{ \Carbon\Carbon::create($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM Y') }}</span>
                <a href="{{ route('jadwal.index', ['bulan' => $next->month, 'tahun' => $next->year]) }}" class="month-nav-btn">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>

            @if($semuaPengasuh->isNotEmpty())
                @if($sudahDigenerate)
                <div class="generated-badge"><i class="fas fa-check-circle"></i> Jadwal bulan ini sudah digenerate</div>
                @else
                <form method="POST" action="{{ route('jadwal.generate') }}">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <button type="submit" class="btn-generate">
                        <i class="fas fa-wand-magic-sparkles"></i> Generate Jadwal Bulan Ini
                    </button>
                </form>
                @endif
            @endif
        </div>

        {{-- Timeline --}}
        @if($semuaPengasuh->isEmpty())
        <div class="empty-roster">
            <i class="fas fa-user-clock"></i>
            <p>Belum ada data pengasuh.</p>
            <small>Jalankan seeder PengasuhSeeder untuk membuat 7 akun roster mingguan.</small>
        </div>
        @else
        <div class="timeline">
            @foreach($timeline as $item)
            <div class="tl-item {{ $item['is_today'] ? 'is-today' : '' }}">
                <div class="tl-dot">{{ $item['tanggal']->format('d') }}</div>
                <div class="tl-card">
                    <div class="tl-date">
                        <div class="day-name">{{ $item['tanggal']->locale('id')->isoFormat('dddd') }}</div>
                        <div class="day-full">{{ $item['tanggal']->locale('id')->isoFormat('D MMM Y') }}</div>
                    </div>

                    <div class="tl-pengasuh">
                        @if($item['pengasuh'])
                        <div class="tl-avatar">{{ strtoupper(substr($item['pengasuh']->nama, 0, 2)) }}</div>
                        <div>
                            <div class="tl-pengasuh-name">{{ $item['pengasuh']->nama }}</div>
                            @if($item['catatan'])
                            <div class="tl-catatan"><i class="fas fa-note-sticky"></i> {{ $item['catatan'] }}</div>
                            @endif
                        </div>
                        @else
                        <span style="color:#ccc; font-size:12.5px;">Belum ada pengasuh untuk hari ini</span>
                        @endif
                    </div>

                    <span class="tl-status {{ $item['tersimpan'] ? 'saved' : 'default' }}">
                        {{ $item['tersimpan'] ? 'Tersimpan' : 'Default' }}
                    </span>

                    <button type="button" class="btn-swap"
                            onclick="bukaSwapModal('{{ $item['tanggal']->format('Y-m-d') }}', '{{ $item['tanggal']->locale('id')->isoFormat('dddd, D MMMM Y') }}', {{ $item['pengasuh']?->id ?? 'null' }}, '{{ addslashes($item['catatan'] ?? '') }}')">
                        <i class="fas fa-right-left"></i> Tukar
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

{{-- Modal tukar jaga --}}
<div class="modal-overlay" id="swapModal">
    <div class="modal-box">
        <h3><i class="fas fa-right-left" style="color:#4a3aa7; margin-right:6px;"></i>Tukar Jaga</h3>
        <p class="modal-sub" id="swapTanggalLabel"></p>
        <form method="POST" action="{{ route('jadwal.set') }}">
            @csrf
            <input type="hidden" name="tanggal" id="swapTanggal">

            <label for="swapPengasuh">Pengasuh Bertugas</label>
            <select name="pengasuh_id" id="swapPengasuh" required>
                @foreach($semuaPengasuh as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->hari_label }})</option>
                @endforeach
            </select>

            <label for="swapCatatan">Catatan <span style="font-weight:400; color:#b9bfcc;">(opsional)</span></label>
            <textarea name="catatan" id="swapCatatan" placeholder="Contoh: tukar jaga dengan pengasuh hari Rabu"></textarea>

            <div class="modal-actions">
                <button type="button" class="modal-cancel" onclick="tutupSwapModal()">Batal</button>
                <button type="submit" class="modal-confirm"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaSwapModal(tanggal, tanggalLabel, pengasuhId, catatan) {
    document.getElementById('swapTanggal').value = tanggal;
    document.getElementById('swapTanggalLabel').textContent = tanggalLabel;
    document.getElementById('swapCatatan').value = catatan || '';
    const select = document.getElementById('swapPengasuh');
    if (pengasuhId) select.value = pengasuhId;
    document.getElementById('swapModal').classList.add('open');
}
function tutupSwapModal() {
    document.getElementById('swapModal').classList.remove('open');
}
document.getElementById('swapModal').addEventListener('click', function(e) {
    if (e.target === this) tutupSwapModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupSwapModal();
});
</script>
</x-app-layout>
