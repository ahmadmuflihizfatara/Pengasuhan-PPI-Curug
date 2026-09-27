<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php
    $isTaruna = Auth::user()->hasTarunaAccess();

    // Agenda mendatang (hari ini ke depan) — acara & apel digabung, 6 terdekat
    $agendaMendatang = $acara->map(fn ($a) => [
            'tipe' => 'acara', 'judul' => $a->nama_acara, 'tanggal' => $a->tanggal,
            'jam'  => $a->jam ? \Carbon\Carbon::parse($a->jam)->format('H:i') : '',
        ])
        ->concat($apel->map(fn ($p) => [
            'tipe' => 'apel', 'judul' => $p->judul, 'tanggal' => $p->tanggal,
            'jam'  => $p->jam ? \Carbon\Carbon::parse($p->jam)->format('H:i') : '',
        ]))
        ->filter(fn ($e) => $e['tanggal']->gte(today()))
        ->sortBy(fn ($e) => $e['tanggal']->format('Y-m-d') . ' ' . $e['jam'])
        ->take(6)
        ->values();

    // Data kalender cukup judul, tanggal & jam — detail (termasuk informasi apel) ada di halaman per tanggal
    $eventKalender = $acara->map(fn ($a) => [
            'type'    => 'acara',
            'judul'   => $a->nama_acara,
            'tanggal' => $a->tanggal->format('Y-m-d'),
            'jam'     => $a->jam ? \Carbon\Carbon::parse($a->jam)->format('H:i') : '',
        ])
        ->concat($apel->map(fn ($p) => [
            'type'    => 'apel',
            'judul'   => $p->judul,
            'tanggal' => $p->tanggal->format('Y-m-d'),
            'jam'     => $p->jam ? \Carbon\Carbon::parse($p->jam)->format('H:i') : '',
        ]))
        ->sortBy('jam')
        ->values();
@endphp

<style>
    /* Kartu aksi pengelola — pola kartu ajukan tab surat & barak */
    .acara-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .acara-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
    .acara-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }
    .acara-aksi__kanan { display: flex; align-items: center; gap: var(--space-2); flex-wrap: wrap; }
    .acara-toggle { display: inline-flex; gap: var(--space-1); padding: var(--space-1); border-radius: var(--radius-pill); background: var(--glass-subtle); border: 1px solid var(--border-glass); }
    .acara-toggle .toggle-btn { border: 1px solid transparent; border-radius: var(--radius-pill); background: transparent; padding: var(--space-1-5) var(--space-3); font-family: inherit; font-size: 12px; font-weight: 700; color: var(--ink-700); cursor: pointer; }
    .acara-toggle .toggle-btn.active { background: var(--glass-solid); border-color: var(--border-glass-glow); color: var(--ink-900); box-shadow: var(--shadow-glass-sm); }

    /* Kalender — bentuk kalender dinding klasik: satu bingkai kaca, garis tipis antar tanggal */
    .cal-head { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .cal-box { border-radius: var(--radius-lg); overflow: hidden; background: var(--glass-card); border: 1px solid var(--border-glass-glow); box-shadow: var(--shadow-glass-sm); }
    .cal-bar { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); padding: var(--space-3) var(--space-4); background: var(--glass-dark); color: var(--ink-on-dark); }
    .cal-bar__btn {
        width: 32px; height: 32px; flex-shrink: 0; display: grid; place-items: center; padding: 0;
        border-radius: var(--radius-pill); border: 1px solid var(--border-on-dark); background: rgba(255,255,255,.12);
        color: var(--ink-on-dark); font-size: 12px; cursor: pointer; transition: background-color .15s;
    }
    .cal-bar__btn:hover { background: rgba(255,255,255,.24); }
    .cal-bar__btn:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .cal-judul { margin: 0; text-align: center; font-size: 16px; line-height: 22px; font-weight: 800; letter-spacing: -0.01em; white-space: nowrap; color: var(--ink-on-dark); }
    .cal-hari { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); background: var(--glass-solid); border-bottom: 1px solid var(--border-glass-subtle); }
    .cal-hari span { padding: var(--space-2) 0; text-align: center; font-size: 11px; line-height: 14px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: var(--ink-700); }
    .cal-hari span.libur { color: var(--danger-ink); }
    .cal-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); }
    .cal-cell {
        display: flex; flex-direction: column; gap: 3px; min-width: 0; min-height: 96px; padding: var(--space-1-5) var(--space-2);
        border-right: 1px solid var(--border-glass-subtle); border-bottom: 1px solid var(--border-glass-subtle);
        color: inherit; text-decoration: none; transition: background-color .15s;
    }
    .cal-cell:nth-child(7n) { border-right: 0; }
    .cal-cell:nth-last-child(-n+7) { border-bottom: 0; }
    .cal-cell:hover { background: var(--glass-solid); color: inherit; }
    .cal-cell:hover .cal-tgl { background: var(--glass-subtle); }
    .cal-cell:focus-visible { outline: none; box-shadow: inset 0 0 0 2px var(--focus-ring); }
    .cal-cell--luar { background: rgba(255,255,255,.12); }
    .cal-cell--luar .cal-tgl { color: var(--ink-400); }
    .cal-cell--hariini { background: var(--accent-tint); }
    .cal-tgl { width: 26px; height: 26px; border-radius: var(--radius-pill); display: grid; place-items: center; flex-shrink: 0; font-size: 12px; font-weight: 800; color: var(--ink-800); transition: background-color .15s; }
    .cal-cell--libur:not(.cal-cell--luar):not(.cal-cell--hariini) .cal-tgl { color: var(--danger-ink); }
    /* Lingkaran hari ini: angka putih tebal di atas biru pekat — menang atas warna merah akhir pekan */
    .cal-cell--hariini .cal-tgl, .cal-cell--hariini:hover .cal-tgl { width: 28px; height: 28px; background: var(--accent); color: #fff; font-size: 13px; font-weight: 900; box-shadow: 0 0 0 3px var(--focus-ring-glow), var(--shadow-glass-sm); }
    .cal-chip {
        display: block; padding: 2px 6px; border-radius: 5px; background: var(--accent); color: var(--ink-on-dark);
        font-size: 10px; line-height: 14px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .cal-chip--apel { background: var(--success); }
    .cal-cell--luar .cal-chip { opacity: .55; }
    .cal-lagi { font-size: 10px; line-height: 14px; font-weight: 700; color: var(--accent-ink); padding-left: 2px; }
    .cal-titik { display: none; gap: 3px; flex-wrap: wrap; }
    .cal-titik i { width: 6px; height: 6px; border-radius: 50%; background: var(--accent); }
    .cal-titik i.apel { background: var(--success); }
    @media (max-width: 640px) {
        .cal-cell { min-height: 56px; align-items: center; padding: var(--space-1); }
        .cal-chip, .cal-lagi { display: none; }
        .cal-titik { display: flex; justify-content: center; }
        .cal-hari span { font-size: 10px; letter-spacing: .02em; }
    }
    .cal-legend { display: flex; flex-wrap: wrap; gap: var(--space-2) var(--space-4); margin-top: var(--space-4); padding-top: var(--space-3); border-top: 1px solid var(--border-glass-subtle); font-size: 11px; font-weight: 600; color: var(--ink-700); }
    .cal-legend span { display: inline-flex; align-items: center; gap: var(--space-1-5); }
    .cal-legend i { width: 10px; height: 10px; border-radius: 3px; background: var(--accent); }
    .cal-legend i.apel { background: var(--success); }
    .cal-legend i.hariini { border-radius: 50%; }

    /* Agenda mendatang */
    .ag-list { display: flex; flex-direction: column; gap: var(--space-2); }
    .ag-item {
        display: flex; align-items: center; gap: var(--space-3); padding: var(--space-2-5) var(--space-3);
        border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow);
        color: inherit; text-decoration: none; transition: background-color .15s, box-shadow .15s;
    }
    .ag-item:hover { background: var(--glass-solid); box-shadow: var(--shadow-glass-sm); color: inherit; }
    .ag-item:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .ag-tgl { width: 42px; flex-shrink: 0; padding: var(--space-1) 0; border-radius: var(--radius-sm); text-align: center; background: var(--accent-tint); color: var(--accent-ink); }
    .ag-tgl--apel { background: var(--success-tint); color: var(--success-ink); }
    .ag-tgl b { display: block; font-family: var(--font-mono); font-size: 16px; line-height: 20px; font-weight: 900; }
    .ag-tgl small { display: block; font-size: 9px; line-height: 12px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; }
    .ag-body { display: block; min-width: 0; flex: 1; }
    .ag-body .tbl-title, .ag-body .tbl-sub { display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ag-panah { color: var(--ink-400); font-size: 11px; }
</style>

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

                {{-- Header — sama dengan header tab poin, surat & barak --}}
                <x-page-banner :title="$isTaruna ? 'Kalender Kegiatan Taruna' : 'Kelola Acara & Agenda'" icon="fa-calendar-days"
                    :subtitle="$isTaruna ? 'Pantau jadwal acara harian, kegiatan asrama, dan sesi apel. Klik tanggal untuk melihat agenda hari itu' : 'Daftar acara pengasuhan terintegrasi kalender dan presensi apel'" />

                @unless($isTaruna)
                {{-- Aksi pengelola — di bawah header --}}
                <div class="ds-card acara-aksi mb-4">
                    <span class="acara-aksi__teks"><i class="fa-solid fa-calendar-plus"></i>Jadwalkan acara baru atau lihat semua agenda di kalender</span>
                    <div class="acara-aksi__kanan">
                        <div class="acara-toggle">
                            <button type="button" class="toggle-btn active" id="btnTableView" onclick="switchView('table')"><i class="fa-solid fa-list"></i> Tabel</button>
                            <button type="button" class="toggle-btn" id="btnCalendarView" onclick="switchView('calendar')"><i class="fa-solid fa-calendar"></i> Kalender</button>
                        </div>
                        <a href="{{ route('acara.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Tambah Acara</a>
                    </div>
                </div>
                @endunless

                @if(session('success'))
                <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
                @endif

                {{-- TABLE VIEW (Non-Taruna) --}}
                @unless($isTaruna)
                <div id="tableView">
                    @if($acara->isEmpty())
                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-10 text-center shadow-lg">
                        <i class="fa-solid fa-calendar-xmark text-4xl text-slate-300 mb-2 block"></i>
                        <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Acara Terjadwal</h4>
                        <p class="text-xs text-slate-500 mb-4">Klik tombol di bawah untuk membuat jadwal kegiatan acara baru.</p>
                        <a href="{{ route('acara.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-md transition no-underline">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Tambah Acara Pertama</span>
                        </a>
                    </div>
                    @else
                    <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                        <th class="py-3 px-3">#</th>
                                        <th class="py-3 px-3">Nama Acara</th>
                                        <th class="py-3 px-3">Tanggal</th>
                                        <th class="py-3 px-3">Waktu</th>
                                        <th class="py-3 px-3">Keterangan</th>
                                        <th class="py-3 px-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/30">
                                    @foreach($acara as $i => $a)
                                    <tr class="hover:bg-white/60 transition">
                                        <td class="py-3 px-3 text-slate-400 font-bold">{{ $i + 1 }}</td>
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs shadow-sm flex-shrink-0">
                                                    <i class="fa-solid fa-calendar-check"></i>
                                                </div>
                                                <span class="font-bold text-slate-900">{{ $a->nama_acara }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-slate-700 font-medium whitespace-nowrap">
                                            <i class="fa-solid fa-calendar text-indigo-500 mr-1 text-[10px]"></i>
                                            {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                        </td>
                                        <td class="py-3 px-3">
                                            <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 font-bold text-[10px] border border-indigo-200">
                                                <i class="fa-solid fa-clock text-[9px] mr-1"></i>
                                                {{ \Carbon\Carbon::parse($a->jam)->format('H:i') }} WIB
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 max-w-[220px] text-slate-600">
                                            {!! $a->keterangan ? e(Str::limit($a->keterangan, 70)) : '<span class="text-slate-300">—</span>' !!}
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="inline-flex items-center gap-1">
                                                <a href="{{ route('acara.edit', $a->id) }}" class="p-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 shadow-sm transition" title="Edit">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                                </a>
                                                <button type="button" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 shadow-sm transition" title="Hapus"
                                                        onclick="showDeleteModal('delete-acara-{{ $a->id }}', '{{ addslashes($a->nama_acara) }}')">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @foreach($acara as $a)
                    <form id="delete-acara-{{ $a->id }}" method="POST" action="{{ route('acara.destroy', $a->id) }}" style="display:none;">
                        @csrf @method('DELETE')
                    </form>
                    @endforeach
                    @endif
                </div>
                @endunless

                {{-- CALENDAR VIEW --}}
                <div id="calendarView" class="grid grid-cols-1 lg:grid-cols-3 gap-4" @unless($isTaruna) style="display:none;" @endunless>
                    <div class="ds-card lg:col-span-2">
                        <div class="ds-card__head cal-head">
                            <div>
                                <h3 class="ds-card__title"><i class="fa-solid fa-calendar-days ds-icon"></i> Kalender Kegiatan</h3>
                                <p class="ds-card__desc">Klik tanggal untuk membuka agenda hari itu</p>
                            </div>
                            <button type="button" class="ds-btn ds-btn--sm ds-btn--pill" onclick="goToday()"><i class="fa-solid fa-calendar-day"></i> Hari ini</button>
                        </div>

                        {{-- Kalender bulanan klasik: bar bulan, baris nama hari, lalu kisi tanggal bergaris --}}
                        <div class="cal-box">
                            <div class="cal-bar">
                                <button type="button" class="cal-bar__btn" onclick="changeMonth(-1)" aria-label="Bulan sebelumnya"><i class="fa-solid fa-chevron-left"></i></button>
                                <h4 class="cal-judul" id="calendarTitle" aria-live="polite"></h4>
                                <button type="button" class="cal-bar__btn" onclick="changeMonth(1)" aria-label="Bulan berikutnya"><i class="fa-solid fa-chevron-right"></i></button>
                            </div>
                            <div class="cal-hari" aria-hidden="true">
                                <span class="libur">Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span class="libur">Sab</span>
                            </div>
                            <div class="cal-grid" id="calendarDays"></div>
                        </div>

                        <div class="cal-legend">
                            <span><i></i> Acara Terjadwal</span>
                            <span><i class="apel"></i> Apel Taruna</span>
                            <span><i class="hariini"></i> Hari Ini</span>
                        </div>
                    </div>

                    {{-- Agenda mendatang --}}
                    <div class="ds-card">
                        <div class="ds-card__head">
                            <h3 class="ds-card__title"><i class="fa-solid fa-clock ds-icon"></i> Agenda Mendatang</h3>
                            <p class="ds-card__desc">Acara &amp; apel terdekat mulai hari ini</p>
                        </div>
                        @if($agendaMendatang->isEmpty())
                        <div class="ds-empty">
                            <i class="fa-solid fa-calendar-check ds-icon"></i>
                            Belum ada agenda mendatang.
                        </div>
                        @else
                        <div class="ag-list">
                            @foreach($agendaMendatang as $e)
                            <a href="{{ route('acara.tanggal', $e['tanggal']->format('Y-m-d')) }}" class="ag-item">
                                <span class="ag-tgl {{ $e['tipe'] === 'apel' ? 'ag-tgl--apel' : '' }}">
                                    <b>{{ $e['tanggal']->format('d') }}</b>
                                    <small>{{ $e['tanggal']->locale('id')->isoFormat('MMM') }}</small>
                                </span>
                                <span class="ag-body">
                                    <span class="tbl-title">{{ $e['judul'] }}</span>
                                    <span class="tbl-sub">{{ $e['tanggal']->locale('id')->isoFormat('dddd') }}{{ $e['jam'] ? ' · '.$e['jam'].' WIB' : '' }} · {{ $e['tipe'] === 'apel' ? 'Apel' : 'Acara' }}</span>
                                </span>
                                <i class="fa-solid fa-chevron-right ag-panah"></i>
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

    </div>
</main>

{{-- Delete Modal --}}
@unless($isTaruna)
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-xl mx-auto mb-3">
            <i class="fa-solid fa-trash"></i>
        </div>
        <h3 class="text-sm font-bold text-slate-800 mb-1">Hapus Acara?</h3>
        <p id="modalAcaraName" class="text-xs font-semibold text-slate-700 mb-1"></p>
        <p class="text-[11px] text-slate-400 mb-4">Tindakan ini tidak dapat dibatalkan. Acara akan dihapus secara permanen.</p>
        <div class="flex items-center justify-center gap-2">
            <button class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition" onclick="closeDeleteModal()">
                Batal
            </button>
            <button class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md transition" onclick="submitDeleteForm()">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>
@endunless

<script>
const IS_TARUNA   = @json($isTaruna);
const ALL_EVENTS  = @json($eventKalender);
const URL_TANGGAL = @json(url('acara/tanggal'));

const BULAN_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

// Bulan awal bisa dari ?bulan=YYYY-MM (tombol kembali dari halaman per tanggal)
const bulanParam = new URLSearchParams(location.search).get('bulan');
let viewDate = /^\d{4}-\d{2}$/.test(bulanParam || '') ? new Date(bulanParam + '-01T00:00:00') : new Date();
viewDate.setDate(1);

function switchView(mode) {
    const kalender = mode === 'calendar';
    const tbl = document.getElementById('tableView');
    const cal = document.getElementById('calendarView');
    if (tbl) tbl.style.display = kalender ? 'none' : '';
    if (cal) cal.style.display = kalender ? '' : 'none';
    document.getElementById('btnCalendarView')?.classList.toggle('active', kalender);
    document.getElementById('btnTableView')?.classList.toggle('active', !kalender);
    if (kalender) renderCalendar();
    try { sessionStorage.setItem('acaraView', mode); } catch (e) {}
}

function changeMonth(delta) {
    viewDate.setMonth(viewDate.getMonth() + delta);
    renderCalendar();
}

function goToday() {
    viewDate = new Date();
    viewDate.setDate(1);
    renderCalendar();
}

const pad = n => String(n).padStart(2, '0');
const isoTgl = d => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;

function renderCalendar() {
    const year  = viewDate.getFullYear();
    const month = viewDate.getMonth();
    document.getElementById('calendarTitle').textContent = BULAN_ID[month] + ' ' + year;

    // Mulai hari Minggu pada minggu yang memuat tanggal 1, sampai akhir minggu terakhir bulan ini
    const hariPertama = new Date(year, month, 1).getDay();
    const totalSel = Math.ceil((hariPertama + new Date(year, month + 1, 0).getDate()) / 7) * 7;
    const hariIni = isoTgl(new Date());

    const grid = document.getElementById('calendarDays');
    grid.innerHTML = '';
    for (let i = 0; i < totalSel; i++) {
        const d = new Date(year, month, 1 - hariPertama + i);
        grid.appendChild(createCell(d, d.getMonth() !== month, isoTgl(d) === hariIni));
    }
}

function createCell(date, isOtherMonth, isToday) {
    const tgl = isoTgl(date);
    const events = ALL_EVENTS.filter(e => e.tanggal === tgl);

    // Tiap tanggal = link ke halaman agenda hari itu
    const cell = document.createElement('a');
    cell.href = `${URL_TANGGAL}/${tgl}`;
    cell.className = 'cal-cell' + (isOtherMonth ? ' cal-cell--luar' : '') + (isToday ? ' cal-cell--hariini' : '')
        + (events.length ? ' cal-cell--ada' : '') + ([0, 6].includes(date.getDay()) ? ' cal-cell--libur' : '');
    cell.setAttribute('aria-label', `${date.getDate()} ${BULAN_ID[date.getMonth()]} ${date.getFullYear()}, `
        + (events.length ? `${events.length} agenda` : 'tidak ada agenda'));
    if (isToday) cell.setAttribute('aria-current', 'date');

    const dateEl = document.createElement('span');
    dateEl.className = 'cal-tgl';
    dateEl.textContent = date.getDate();
    cell.appendChild(dateEl);

    const maks = 2;
    events.slice(0, maks).forEach(e => {
        const chip = document.createElement('span');
        chip.className = 'cal-chip' + (e.type === 'apel' ? ' cal-chip--apel' : '');
        chip.textContent = (e.jam ? e.jam + ' ' : '') + e.judul;
        chip.title = chip.textContent;
        cell.appendChild(chip);
    });
    if (events.length > maks) {
        const lagi = document.createElement('span');
        lagi.className = 'cal-lagi';
        lagi.textContent = `+${events.length - maks} lainnya`;
        cell.appendChild(lagi);
    }

    // Layar kecil: titik warna menggantikan chip
    if (events.length) {
        const titik = document.createElement('span');
        titik.className = 'cal-titik';
        events.slice(0, 4).forEach(e => {
            const i = document.createElement('i');
            if (e.type === 'apel') i.className = 'apel';
            titik.appendChild(i);
        });
        cell.appendChild(titik);
    }
    return cell;
}

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

(function init() {
    let tersimpan = null;
    try { tersimpan = sessionStorage.getItem('acaraView'); } catch (e) {}
    // Pengelola yang kembali dari halaman per tanggal langsung ke tampilan kalender
    if (!IS_TARUNA && (tersimpan === 'calendar' || bulanParam)) switchView('calendar');
    else renderCalendar();
})();
</script>

</x-app-layout>
