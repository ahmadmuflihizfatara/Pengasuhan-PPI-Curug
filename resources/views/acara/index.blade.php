<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

/* ── Page Header ── */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: space-between;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:80px; bottom:-60px; width:140px; height:140px; background:rgba(255,255,255,.06); border-radius:50%; }
.page-header-text { position:relative; z-index:1; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; }
.page-header p  { margin:0; opacity:.85; font-size:13px; }

.header-actions { position:relative; z-index:1; display:flex; align-items:center; gap:10px; }

/* ── Toggle ── */
.view-toggle {
    display:flex; align-items:center;
    background:rgba(255,255,255,.18); border-radius:25px;
    padding:4px; gap:2px;
    border:1px solid rgba(255,255,255,.25); backdrop-filter:blur(4px);
}
.toggle-btn {
    padding:7px 14px; border-radius:20px; border:none;
    font-size:12px; font-weight:700; cursor:pointer;
    display:flex; align-items:center; gap:5px;
    transition:all .2s; color:rgba(255,255,255,.75); background:transparent;
}
.toggle-btn.active { background:white; color:#667eea; box-shadow:0 2px 8px rgba(0,0,0,.15); }
.toggle-btn:hover:not(.active) { color:white; background:rgba(255,255,255,.12); }

.btn-add {
    background:white; color:#667eea; padding:11px 22px; border-radius:25px;
    text-decoration:none; font-size:13px; font-weight:800;
    display:flex; align-items:center; gap:7px; white-space:nowrap;
    box-shadow:0 4px 15px rgba(0,0,0,.15); transition:transform .15s, box-shadow .15s;
}
.btn-add:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.2); color:#667eea; }

.alert-success {
    background:linear-gradient(135deg,#43e97b,#38f9d7); color:white;
    padding:14px 20px; border-radius:12px; margin-bottom:20px;
    display:flex; align-items:center; gap:10px; font-weight:600; font-size:14px;
}

/* ── Table View ── */
.card { background:white; border-radius:16px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,.06); }
.empty-state { text-align:center; padding:60px 20px; }
.empty-state i  { font-size:56px; color:#e2e5ee; margin-bottom:16px; display:block; }
.empty-state h4 { color:#aab; margin:0 0 8px; font-size:16px; }
.empty-state p  { color:#ccc; margin:0 0 20px; font-size:14px; }
.btn-primary-pill {
    background:linear-gradient(135deg,#667eea,#764ba2); color:white;
    padding:11px 28px; border-radius:25px; text-decoration:none; font-size:13px;
    font-weight:700; display:inline-flex; align-items:center; gap:7px;
    box-shadow:0 4px 15px rgba(102,126,234,.4);
}

table { width:100%; border-collapse:collapse; }
thead tr { background:linear-gradient(135deg,#667eea,#764ba2); }
th { padding:14px 18px; text-align:left; color:white; font-size:11px; font-weight:700; letter-spacing:.06em; }
td { padding:14px 18px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr { transition:background .1s; }
tbody tr:hover { background:#f8f9ff; }

.icon-box  { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,#667eea,#764ba2); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.time-badge { background:#eef0ff; color:#667eea; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; }
.btn-edit   { background:#eef0ff; color:#667eea; border:none; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; text-decoration:none; cursor:pointer; display:inline-flex; align-items:center; gap:5px; transition:background .1s; }
.btn-edit:hover { background:#dde2ff; }
.btn-delete { background:#fff0f0; color:#e53e3e; border:none; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:5px; transition:background .1s; }
.btn-delete:hover { background:#ffe0e0; }

/* ── Calendar View ── */
#calendarView { display:none; }

.calendar-wrapper { background:white; border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,.06); overflow:hidden; }

.calendar-nav {
    display:flex; align-items:center; justify-content:space-between;
    padding:20px 24px; border-bottom:1px solid #f0f2f7;
    background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white;
}
.calendar-nav h2 { font-size:18px; font-weight:800; margin:0; }
.cal-nav-btn {
    width:36px; height:36px; border-radius:50%; border:none;
    background:rgba(255,255,255,.2); color:white; cursor:pointer; font-size:14px;
    display:flex; align-items:center; justify-content:center; transition:background .15s;
}
.cal-nav-btn:hover { background:rgba(255,255,255,.35); }

.calendar-grid { display:grid; grid-template-columns:repeat(7,1fr); }
.cal-day-header {
    padding:10px 8px; text-align:center; font-size:11px; font-weight:800;
    letter-spacing:.06em; color:#667eea; background:#f8f9ff; border-bottom:1px solid #f0f2f7;
}
.cal-day-header:first-child, .cal-day-header:last-child { color:#e53e3e; }

.cal-cell {
    min-height:100px; padding:8px; border-right:1px solid #f0f2f7;
    border-bottom:1px solid #f0f2f7; position:relative; cursor:default; transition:background .1s;
}
.cal-cell:nth-child(7n) { border-right:none; }
.cal-cell.other-month   { background:#fafbff; }
.cal-cell.other-month .cal-date { color:#ccc; }
.cal-cell.today { background:#f0f2ff; }
.cal-cell.today .cal-date {
    background:linear-gradient(135deg,#667eea,#764ba2); color:white;
    width:26px; height:26px; border-radius:50%;
    display:flex; align-items:center; justify-content:center; font-weight:800;
}
.cal-cell.has-event { cursor:pointer; }
.cal-cell.has-event:hover { background:#f5f7ff; }

.cal-date {
    font-size:12px; font-weight:700; color:#444; margin-bottom:4px;
    width:26px; height:26px; display:flex; align-items:center; justify-content:center; border-radius:50%;
}
.cal-cell:nth-child(7n+1) .cal-date,
.cal-cell:nth-child(7n)   .cal-date { color:#e53e3e; }

.cal-event {
    background:linear-gradient(135deg,#667eea,#764ba2); color:white; border-radius:6px;
    padding:3px 7px; font-size:10px; font-weight:700; margin-bottom:3px;
    display:flex; align-items:center; gap:4px;
    overflow:hidden; white-space:nowrap; text-overflow:ellipsis;
    cursor:pointer; transition:opacity .15s; line-height:1.4;
}
.cal-event:hover { opacity:.85; }
.cal-event-apel { background:linear-gradient(135deg,#1baf7a,#2a78d6); }
.cal-event-more { font-size:10px; font-weight:700; color:#667eea; text-align:center; padding:2px; }

/* ── Popover ── */
.cal-popover {
    display:none; position:fixed; background:white; border-radius:14px;
    box-shadow:0 8px 32px rgba(0,0,0,.18); padding:16px;
    min-width:220px; max-width:280px; z-index:9000;
}
.cal-popover.show { display:block; }
.cal-popover h4 { margin:0 0 8px; font-size:14px; font-weight:800; color:#333; }
.cal-popover-row { display:flex; align-items:center; gap:7px; font-size:12px; color:#666; margin-bottom:5px; }
.cal-popover-row i { color:#667eea; width:14px; text-align:center; }
.cal-popover-desc { font-size:12px; color:#888; margin-top:8px; padding-top:8px; border-top:1px solid #f0f2f7; line-height:1.5; }
.cal-popover-actions { display:flex; gap:8px; margin-top:12px; padding-top:10px; border-top:1px solid #f0f2f7; }
.pop-btn-edit {
    flex:1; background:#eef0ff; color:#667eea; border:none; padding:7px 10px;
    border-radius:20px; font-size:11px; font-weight:700; cursor:pointer;
    text-decoration:none; text-align:center; display:flex; align-items:center; justify-content:center; gap:4px;
}
.pop-btn-edit:hover { background:#dde2ff; color:#667eea; }
.pop-btn-del {
    flex:1; background:#fff0f0; color:#e53e3e; border:none; padding:7px 10px;
    border-radius:20px; font-size:11px; font-weight:700; cursor:pointer;
    text-align:center; display:flex; align-items:center; justify-content:center; gap:4px;
}
.pop-btn-del:hover { background:#ffe0e0; }

/* ── Legend ── */
.calendar-legend {
    padding:14px 24px; border-top:1px solid #f0f2f7;
    display:flex; align-items:center; gap:20px; flex-wrap:wrap;
}
.legend-item { display:flex; align-items:center; gap:6px; font-size:12px; color:#666; }
.legend-dot  { width:10px; height:10px; border-radius:50%; }

/* ── Read-only badge for taruna ── */
.readonly-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.3);
    color:white; border-radius:20px; padding:8px 16px;
    font-size:12px; font-weight:700; backdrop-filter:blur(4px);
}

/* ── Delete Modal ── */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:20px; padding:32px 28px; max-width:400px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,.2); text-align:center; animation:modalIn .2s ease; }
@keyframes modalIn { from{transform:scale(.93);opacity:0} to{transform:scale(1);opacity:1} }
.modal-icon { width:60px; height:60px; border-radius:50%; background:#fff0f0; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.modal-icon i { font-size:26px; color:#e53e3e; }
.modal-box h3 { margin:0 0 8px; font-size:18px; font-weight:800; color:#333; }
.modal-box p  { margin:0 0 24px; font-size:13px; color:#888; line-height:1.5; }
.modal-actions { display:flex; gap:10px; justify-content:center; }
.modal-cancel  { background:#f4f5f9; color:#666; border:none; padding:11px 28px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-cancel:hover  { background:#e8e9f0; }
.modal-confirm { background:linear-gradient(135deg,#fc5c7d,#e53e3e); color:white; border:none; padding:11px 28px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-confirm:hover { opacity:.9; }
</style>

@php $isTaruna = Auth::user()->isTaruna(); @endphp

<div class="app-layout">

    <x-sidebar active="acara" />

    <div class="main-content">

        {{-- ── PAGE HEADER ── --}}
        <div class="page-header">
            <div class="page-header-text">
                <h1><i class="fas fa-calendar-alt" style="margin-right:10px;"></i>
                    {{ $isTaruna ? 'Kalender' : 'Kelola Acara' }}
                </h1>
                <p>{{ $isTaruna ? 'Lihat jadwal acara dan apel' : 'Daftar acara pengasuhan — kalender juga menampilkan jadwal apel' }}</p>
            </div>
            <div class="header-actions">
                {{-- Toggle view: hanya tampil untuk pengasuh & admin --}}
                @unless($isTaruna)
                <div class="view-toggle">
                    <button class="toggle-btn active" id="btnTableView" onclick="switchView('table')">
                        <i class="fas fa-list"></i> Tabel
                    </button>
                    <button class="toggle-btn" id="btnCalendarView" onclick="switchView('calendar')">
                        <i class="fas fa-calendar"></i> Kalender
                    </button>
                </div>
                <a href="{{ route('acara.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Acara
                </a>
                @else
                {{-- Taruna: label read-only saja --}}
                <div class="readonly-badge">
                    <i class="fas fa-eye"></i> Hanya Lihat
                </div>
                @endunless
            </div>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:18px;"></i>{{ session('success') }}
        </div>
        @endif

        {{-- ══════════════════════════════════════════════
             TABLE VIEW  (pengasuh & admin saja)
        ══════════════════════════════════════════════ --}}
        @unless($isTaruna)
        <div id="tableView">
            @if($acara->isEmpty())
            <div class="card">
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h4>Belum ada acara dijadwalkan</h4>
                    <p>Klik tombol "Tambah Acara" untuk menambahkan acara baru.</p>
                    <a href="{{ route('acara.create') }}" class="btn-primary-pill">
                        <i class="fas fa-plus"></i> Tambah Acara Pertama
                    </a>
                </div>
            </div>
            @else
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NAMA ACARA</th>
                            <th>TANGGAL</th>
                            <th>JAM</th>
                            <th>KETERANGAN</th>
                            <th style="text-align:center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($acara as $i => $a)
                        <tr>
                            <td style="color:#bbb; font-weight:600;">{{ $i + 1 }}</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div class="icon-box">
                                        <i class="fas fa-calendar-check" style="color:white; font-size:15px;"></i>
                                    </div>
                                    <span style="font-weight:700; color:#333;">{{ $a->nama_acara }}</span>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-calendar" style="color:#667eea; margin-right:6px;"></i>
                                {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </td>
                            <td>
                                <span class="time-badge">
                                    <i class="fas fa-clock" style="margin-right:4px;"></i>
                                    {{ \Carbon\Carbon::parse($a->jam)->format('H:i') }} WIB
                                </span>
                            </td>
                            <td style="max-width:200px; color:#777;">
                                {!! $a->keterangan ? Str::limit($a->keterangan, 80) : '<span style="color:#ccc;">—</span>' !!}
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; align-items:center; justify-content:center; gap:7px;">
                                    <a href="{{ route('acara.edit', $a->id) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn-delete"
                                            onclick="showDeleteModal('delete-acara-{{ $a->id }}', '{{ addslashes($a->nama_acara) }}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach($acara as $a)
            <form id="delete-acara-{{ $a->id }}" method="POST" action="{{ route('acara.destroy', $a->id) }}" style="display:none;">
                @csrf @method('DELETE')
            </form>
            @endforeach
            @endif
        </div>{{-- end #tableView --}}
        @endunless

        {{-- ══════════════════════════════════════════════
             CALENDAR VIEW
             — Selalu ditampilkan untuk taruna (auto-show)
             — Toggle untuk pengasuh & admin
        ══════════════════════════════════════════════ --}}
        <div id="calendarView" @if($isTaruna) style="display:block;" @else style="display:none;" @endif>
            <div class="calendar-wrapper">
                <div class="calendar-nav">
                    <button class="cal-nav-btn" onclick="changeMonth(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <h2 id="calendarTitle"></h2>
                    <button class="cal-nav-btn" onclick="changeMonth(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="calendar-grid">
                    <div class="cal-day-header">MIN</div>
                    <div class="cal-day-header">SEN</div>
                    <div class="cal-day-header">SEL</div>
                    <div class="cal-day-header">RAB</div>
                    <div class="cal-day-header">KAM</div>
                    <div class="cal-day-header">JUM</div>
                    <div class="cal-day-header">SAB</div>
                </div>

                <div class="calendar-grid" id="calendarDays"></div>

                <div class="calendar-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background:linear-gradient(135deg,#667eea,#764ba2);"></div>
                        <span>Acara terjadwal</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background:linear-gradient(135deg,#1baf7a,#2a78d6);"></div>
                        <span>Apel</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background:#eef0ff; border:2px solid #667eea;"></div>
                        <span>Hari ini</span>
                    </div>
                </div>
            </div>
        </div>{{-- end #calendarView --}}

    </div>{{-- end .main-content --}}
</div>{{-- end .app-layout --}}

{{-- ── Delete Modal (hanya dirender untuk non-taruna) ── --}}
@unless($isTaruna)
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3>Hapus Acara?</h3>
        <p id="modalAcaraName" style="font-weight:600; color:#333; margin-bottom:6px;"></p>
        <p>Tindakan ini tidak dapat dibatalkan. Acara akan dihapus secara permanen.</p>
        <div class="modal-actions">
            <button class="modal-cancel" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="modal-confirm" onclick="submitDeleteForm()">
                <i class="fas fa-trash"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>
@endunless

{{-- ── Calendar Popover ── --}}
<div class="cal-popover" id="calPopover">
    <h4 id="popTitle"></h4>
    <div class="cal-popover-row"><i class="fas fa-calendar"></i><span id="popDate"></span></div>
    <div class="cal-popover-row"><i class="fas fa-clock"></i><span id="popTime"></span></div>
    <div class="cal-popover-row" id="popPembinaRow" style="display:none;"><i class="fas fa-user-tie"></i><span id="popPembina"></span></div>
    <div class="cal-popover-row" id="popLokasiRow" style="display:none;"><i class="fas fa-location-dot"></i><span id="popLokasi"></span></div>
    <div class="cal-popover-desc" id="popDesc" style="display:none;"></div>
    {{-- Tombol edit/hapus acara di popover hanya untuk pengasuh & admin. Apel dikelola di tab Apel. --}}
    @unless($isTaruna)
    <div class="cal-popover-actions" id="popActions">
        <a href="#" id="popEditBtn" class="pop-btn-edit"><i class="fas fa-edit"></i> Edit</a>
        <button onclick="popoverDelete()" class="pop-btn-del"><i class="fas fa-trash"></i> Hapus</button>
    </div>
    @endunless
</div>

@php
$acaraJson = $acara->map(function($a) use ($isTaruna) {
    $item = [
        'type'       => 'acara',
        'id'         => $a->id,
        'judul'      => $a->nama_acara,
        'tanggal'    => $a->tanggal->format('Y-m-d'),
        'jam'        => \Carbon\Carbon::parse($a->jam)->format('H:i'),
        'keterangan' => $a->keterangan,
    ];
    if (!$isTaruna) {
        $item['edit_url']    = route('acara.edit', $a->id);
        $item['delete_form'] = 'delete-acara-' . $a->id;
    }
    return $item;
})->toJson();

// Taruna tidak melihat informasi apel — hanya jadwal, pembina, lokasi
$apelJson = $apel->map(function($p) use ($isTaruna) {
    $item = [
        'type'    => 'apel',
        'id'      => $p->id,
        'judul'   => $p->judul,
        'tanggal' => $p->tanggal->format('Y-m-d'),
        'jam'     => $p->jam ? \Carbon\Carbon::parse($p->jam)->format('H:i') : '',
        'pembina' => $p->pembina,
        'lokasi'  => $p->lokasi,
    ];
    if (!$isTaruna) {
        $item['keterangan'] = $p->informasi;
    }
    return $item;
})->toJson();
@endphp

<script>
// ── Config ─────────────────────────────────────────────
const IS_TARUNA   = @json($isTaruna);
const ACARA_DATA  = @json(json_decode($acaraJson));
const APEL_DATA   = @json(json_decode($apelJson));
const ALL_EVENTS  = ACARA_DATA.concat(APEL_DATA);

const eventMap = {};
ALL_EVENTS.forEach(ev => {
    if (!eventMap[ev.tanggal]) eventMap[ev.tanggal] = [];
    eventMap[ev.tanggal].push(ev);
});

// ── Calendar State ──────────────────────────────────────
const today        = new Date();
let currentYear    = today.getFullYear();
let currentMonth   = today.getMonth();

const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni',
                   'Juli','Agustus','September','Oktober','November','Desember'];

// ── View Toggle (non-taruna only) ───────────────────────
function switchView(view) {
    const tvEl = document.getElementById('tableView');
    const cvEl = document.getElementById('calendarView');
    if (tvEl) tvEl.style.display    = view === 'table'    ? 'block' : 'none';
    if (cvEl) cvEl.style.display    = view === 'calendar' ? 'block' : 'none';

    const btnT = document.getElementById('btnTableView');
    const btnC = document.getElementById('btnCalendarView');
    if (btnT) btnT.classList.toggle('active', view === 'table');
    if (btnC) btnC.classList.toggle('active', view === 'calendar');

    if (view === 'calendar') renderCalendar();
    closePopover();
    sessionStorage.setItem('acaraView', view);
}

// ── Calendar Render ─────────────────────────────────────
function renderCalendar() {
    document.getElementById('calendarTitle').textContent =
        MONTHS_ID[currentMonth] + ' ' + currentYear;

    const grid      = document.getElementById('calendarDays');
    grid.innerHTML  = '';

    const firstDay    = new Date(currentYear, currentMonth, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const daysInPrev  = new Date(currentYear, currentMonth, 0).getDate();
    const todayStr    = fmtDate(today);

    // Leading days from prev month
    for (let i = firstDay - 1; i >= 0; i--) {
        const mo = currentMonth === 0 ? 11 : currentMonth - 1;
        const yr = currentMonth === 0 ? currentYear - 1 : currentYear;
        grid.appendChild(buildCell(daysInPrev - i, yr, mo, true, todayStr));
    }

    // Current month
    for (let d = 1; d <= daysInMonth; d++) {
        grid.appendChild(buildCell(d, currentYear, currentMonth, false, todayStr));
    }

    // Trailing days from next month
    const rem = grid.children.length % 7;
    if (rem !== 0) {
        for (let d = 1; d <= 7 - rem; d++) {
            const mo = currentMonth === 11 ? 0  : currentMonth + 1;
            const yr = currentMonth === 11 ? currentYear + 1 : currentYear;
            grid.appendChild(buildCell(d, yr, mo, true, todayStr));
        }
    }
}

function fmtDate(d, y, m, day) {
    if (d instanceof Date) {
        return d.getFullYear() + '-' +
               String(d.getMonth() + 1).padStart(2,'0') + '-' +
               String(d.getDate()).padStart(2,'0');
    }
    return y + '-' + String(m + 1).padStart(2,'0') + '-' + String(day).padStart(2,'0');
}

function buildCell(day, yr, mo, otherMonth, todayStr) {
    const dateStr = fmtDate(null, yr, mo, day);
    const events  = eventMap[dateStr] || [];
    const isToday = dateStr === todayStr;

    const cell = document.createElement('div');
    cell.className = 'cal-cell' +
        (otherMonth        ? ' other-month' : '') +
        (isToday           ? ' today'       : '') +
        (events.length > 0 ? ' has-event'   : '');

    const dateDiv = document.createElement('div');
    dateDiv.className   = 'cal-date';
    dateDiv.textContent = day;
    cell.appendChild(dateDiv);

    const maxShow = 2;
    events.slice(0, maxShow).forEach(ev => {
        const evEl = document.createElement('div');
        evEl.className = 'cal-event' + (ev.type === 'apel' ? ' cal-event-apel' : '');
        const icon = ev.type === 'apel' ? 'fa-flag' : 'fa-circle';
        evEl.innerHTML = `<i class="fas ${icon}" style="font-size:${ev.type === 'apel' ? '8' : '5'}px;flex-shrink:0;"></i>${esc(ev.judul)}`;
        evEl.title     = ev.judul;
        evEl.onclick   = e => { e.stopPropagation(); showPopover(ev, e); };
        cell.appendChild(evEl);
    });

    if (events.length > maxShow) {
        const more = document.createElement('div');
        more.className   = 'cal-event-more';
        more.textContent = `+${events.length - maxShow} lainnya`;
        more.onclick     = e => { e.stopPropagation(); showPopover(events[maxShow], e); };
        cell.appendChild(more);
    }

    return cell;
}

function changeMonth(dir) {
    currentMonth += dir;
    if (currentMonth > 11) { currentMonth = 0;  currentYear++; }
    if (currentMonth <  0) { currentMonth = 11; currentYear--; }
    renderCalendar();
    closePopover();
}

// ── Popover ─────────────────────────────────────────────
let popoverDeleteFormId = null;

function showPopover(ev, mouseEvent) {
    const pop = document.getElementById('calPopover');
    document.getElementById('popTitle').textContent = ev.judul;

    const [yr, mo, dy] = ev.tanggal.split('-');
    const d0 = new Date(yr, mo - 1, dy);
    const DAYS  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const MONS  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    document.getElementById('popDate').textContent =
        DAYS[d0.getDay()] + ', ' + parseInt(dy) + ' ' + MONS[parseInt(mo)-1] + ' ' + yr;
    document.getElementById('popTime').textContent = (ev.jam || '-') + ' WIB';

    const pembinaRow = document.getElementById('popPembinaRow');
    const lokasiRow  = document.getElementById('popLokasiRow');
    if (ev.type === 'apel') {
        document.getElementById('popPembina').textContent = ev.pembina;
        document.getElementById('popLokasi').textContent  = ev.lokasi;
        pembinaRow.style.display = 'flex';
        lokasiRow.style.display  = 'flex';
    } else {
        pembinaRow.style.display = 'none';
        lokasiRow.style.display  = 'none';
    }

    const descEl = document.getElementById('popDesc');
    if (ev.keterangan) { descEl.textContent = ev.keterangan; descEl.style.display = 'block'; }
    else               { descEl.style.display = 'none'; }

    // Actions (edit/hapus) hanya untuk acara milik non-taruna — apel dikelola di tab Apel
    const actionsEl = document.getElementById('popActions');
    if (actionsEl) {
        if (ev.type === 'acara') {
            actionsEl.style.display = 'flex';
            document.getElementById('popEditBtn').href = ev.edit_url;
            popoverDeleteFormId = ev.delete_form;
        } else {
            actionsEl.style.display = 'none';
            popoverDeleteFormId = null;
        }
    }

    // Position
    pop.style.visibility = 'hidden';
    pop.style.display    = 'block';
    const popW = pop.offsetWidth, popH = pop.offsetHeight;
    pop.style.display    = '';
    pop.style.visibility = '';

    const rect = mouseEvent.target.getBoundingClientRect();
    let left = rect.right + 8, top = rect.top;
    if (left + popW > window.innerWidth  - 10) left = rect.left - popW - 8;
    if (top  + popH > window.innerHeight - 10) top  = window.innerHeight - popH - 10;
    if (top < 10) top = 10;

    pop.style.left = left + 'px';
    pop.style.top  = top  + 'px';
    pop.classList.add('show');
}

function closePopover() {
    document.getElementById('calPopover').classList.remove('show');
    popoverDeleteFormId = null;
}

function popoverDelete() {
    if (popoverDeleteFormId) {
        const nama = document.getElementById('popTitle').textContent;
        closePopover();
        showDeleteModal(popoverDeleteFormId, nama);
    }
}

document.addEventListener('click', e => {
    const pop = document.getElementById('calPopover');
    if (pop.classList.contains('show') && !pop.contains(e.target)) closePopover();
});

// ── Delete Modal (non-taruna) ───────────────────────────
let targetFormId = null;

function showDeleteModal(formId, nama) {
    targetFormId = formId;
    const el = document.getElementById('modalAcaraName');
    if (el) el.textContent = nama;
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.add('open');
}
function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.remove('open');
    targetFormId = null;
}
function submitDeleteForm() {
    if (targetFormId) document.getElementById(targetFormId).submit();
}

const deleteModal = document.getElementById('deleteModal');
if (deleteModal) {
    deleteModal.addEventListener('click', e => { if (e.target === deleteModal) closeDeleteModal(); });
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeDeleteModal(); closePopover(); }
});

// ── Init ────────────────────────────────────────────────
function esc(str) {
    return (str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

(function init() {
    if (IS_TARUNA) {
        // Taruna: selalu tampilkan kalender, langsung render
        renderCalendar();
    } else {
        // Pengasuh / admin: restore preferensi tersimpan
        const saved = sessionStorage.getItem('acaraView');
        if (saved === 'calendar') {
            switchView('calendar');
        } else {
            // default = table, tapi kalender sudah di-hide via inline style
            // Render dulu supaya siap saat di-toggle
        }
    }
})();
</script>
</x-app-layout>
