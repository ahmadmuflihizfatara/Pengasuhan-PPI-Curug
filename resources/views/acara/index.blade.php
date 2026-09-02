<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php $isTaruna = Auth::user()->isTaruna(); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Page Header Glass Banner --}}
                <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-sky-200 mb-2">
                            <span>✦</span>
                            <span>Agenda &amp; Kegiatan Kampus</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-days text-sky-400"></i>
                            <span>{{ $isTaruna ? 'Kalender Kegiatan Taruna' : 'Kelola Acara &amp; Agenda' }}</span>
                        </h1>
                        <p class="text-xs text-sky-100/80">{{ $isTaruna ? 'Pantau jadwal acara harian, kegiatan asrama, dan sesi apel' : 'Daftar acara pengasuhan terintegrasi kalender dan presensi apel' }}</p>
                    </div>

                    <div class="relative z-10 flex items-center gap-2">
                        @unless($isTaruna)
                        <div class="flex items-center bg-white/20 backdrop-blur-md rounded-xl p-1 border border-white/30">
                            <button class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-900 bg-white shadow-sm transition toggle-btn active" id="btnTableView" onclick="switchView('table')">
                                <i class="fa-solid fa-list mr-1"></i> Tabel
                            </button>
                            <button class="px-3 py-1.5 rounded-lg text-xs font-bold text-white hover:text-sky-200 transition toggle-btn" id="btnCalendarView" onclick="switchView('calendar')">
                                <i class="fa-solid fa-calendar mr-1"></i> Kalender
                            </button>
                        </div>
                        <a href="{{ route('acara.create') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-xs shadow-md transition flex items-center gap-2 no-underline">
                            <i class="fa-solid fa-plus text-indigo-600"></i>
                            <span>Tambah Acara</span>
                        </a>
                        @else
                        <div class="px-3 py-1.5 rounded-xl bg-white/15 border border-white/20 text-white font-bold text-xs backdrop-blur-md flex items-center gap-1.5">
                            <i class="fa-solid fa-eye text-sky-300 text-xs"></i>
                            <span>Mode Kalender</span>
                        </div>
                        @endunless
                    </div>

                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
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
                                            {!! $a->keterangan ? Str::limit($a->keterangan, 70) : '<span class="text-slate-300">—</span>' !!}
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="inline-flex flex-col items-stretch gap-1">
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
                <div id="calendarView" @if($isTaruna) style="display:block;" @else style="display:none;" @endif>
                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 shadow-lg overflow-hidden">
                        
                        {{-- Calendar Navigation --}}
                        <div class="p-4 sm:p-5 bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 text-white flex items-center justify-between">
                            <button class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center text-xs transition" onclick="changeMonth(-1)">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <h2 class="text-base font-extrabold tracking-tight" id="calendarTitle"></h2>
                            <button class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center text-xs transition" onclick="changeMonth(1)">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>

                        {{-- Day Headers --}}
                        <div class="grid grid-cols-7 border-b border-white/40 bg-white/60 text-[10px] font-extrabold uppercase tracking-wider text-slate-700 text-center py-2">
                            <div class="text-rose-600">MIN</div>
                            <div>SEN</div>
                            <div>SEL</div>
                            <div>RAB</div>
                            <div>KAM</div>
                            <div>JUM</div>
                            <div class="text-rose-600">SAB</div>
                        </div>

                        {{-- Calendar Grid Days --}}
                        <div class="grid grid-cols-7" id="calendarDays"></div>

                        {{-- Legend --}}
                        <div class="p-4 bg-white/40 border-t border-white/40 flex items-center gap-4 text-xs font-semibold text-slate-700 flex-wrap">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                                <span>Acara Terjadwal</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                                <span>Apel Taruna</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-100 border border-indigo-600"></span>
                                <span>Hari Ini</span>
                            </div>
                        </div>
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

{{-- Calendar Popover --}}
<div class="cal-popover" id="calPopover">
    <h4 id="popTitle" class="font-extrabold text-slate-900 text-xs mb-2"></h4>
    <div class="cal-popover-row text-[11px] text-slate-600 flex items-center gap-1.5 mb-1"><i class="fa-solid fa-calendar text-indigo-600 w-4 text-center"></i><span id="popDate"></span></div>
    <div class="cal-popover-row text-[11px] text-slate-600 flex items-center gap-1.5 mb-1"><i class="fa-solid fa-clock text-indigo-600 w-4 text-center"></i><span id="popTime"></span></div>
    <div class="cal-popover-row text-[11px] text-slate-600 flex items-center gap-1.5 mb-1" id="popPembinaRow" style="display:none;"><i class="fa-solid fa-user-tie text-indigo-600 w-4 text-center"></i><span id="popPembina"></span></div>
    <div class="cal-popover-row text-[11px] text-slate-600 flex items-center gap-1.5 mb-1" id="popLokasiRow" style="display:none;"><i class="fa-solid fa-location-dot text-indigo-600 w-4 text-center"></i><span id="popLokasi"></span></div>
    <div class="cal-popover-desc text-[11px] text-slate-500 mt-2 pt-2 border-t border-slate-100 leading-relaxed" id="popDesc" style="display:none;"></div>
    @unless($isTaruna)
    <div class="flex items-center gap-2 mt-3 pt-2 border-t border-slate-100" id="popActions">
        <a href="#" id="popEditBtn" class="flex-1 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-center text-xs no-underline"><i class="fa-solid fa-pen text-[10px] mr-1"></i> Edit</a>
        <button onclick="popoverDelete()" class="flex-1 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-center text-xs"><i class="fa-solid fa-trash text-[10px] mr-1"></i> Hapus</button>
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
const IS_TARUNA   = @json($isTaruna);
const ACARA_DATA  = @json(json_decode($acaraJson));
const APEL_DATA   = @json(json_decode($apelJson));
const ALL_EVENTS  = ACARA_DATA.concat(APEL_DATA);

const BULAN_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
const HARI_ID  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

let viewDate = new Date();

function switchView(mode) {
    const tbl = document.getElementById('tableView');
    const cal = document.getElementById('calendarView');
    const btnTbl = document.getElementById('btnTableView');
    const btnCal = document.getElementById('btnCalendarView');

    if (mode === 'calendar') {
        if (tbl) tbl.style.display = 'none';
        if (cal) cal.style.display = 'block';
        if (btnCal) { btnCal.classList.add('active', 'bg-white', 'text-slate-900'); btnCal.classList.remove('text-white'); }
        if (btnTbl) { btnTbl.classList.remove('active', 'bg-white', 'text-slate-900'); btnTbl.classList.add('text-white'); }
        renderCalendar();
        sessionStorage.setItem('acaraView', 'calendar');
    } else {
        if (tbl) tbl.style.display = 'block';
        if (cal) cal.style.display = 'none';
        if (btnTbl) { btnTbl.classList.add('active', 'bg-white', 'text-slate-900'); btnTbl.classList.remove('text-white'); }
        if (btnCal) { btnCal.classList.remove('active', 'bg-white', 'text-slate-900'); btnCal.classList.add('text-white'); }
        sessionStorage.setItem('acaraView', 'table');
    }
}

function changeMonth(delta) {
    viewDate.setMonth(viewDate.getMonth() + delta);
    renderCalendar();
    closePopover();
}

function renderCalendar() {
    const year  = viewDate.getFullYear();
    const month = viewDate.getMonth();

    document.getElementById('calendarTitle').textContent = BULAN_ID[month] + ' ' + year;

    const firstDay = new Date(year, month, 1).getDay();
    const totalDays = new Date(year, month + 1, 0).getDate();
    const prevTotalDays = new Date(year, month, 0).getDate();

    const today = new Date();
    const isThisMonth = today.getFullYear() === year && today.getMonth() === month;

    const grid = document.getElementById('calendarDays');
    grid.innerHTML = '';

    // Days from previous month
    for (let i = firstDay - 1; i >= 0; i--) {
        const d = prevTotalDays - i;
        const cell = createCell(d, true, false, []);
        grid.appendChild(cell);
    }

    // Days in current month
    for (let d = 1; d <= totalDays; d++) {
        const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const events = ALL_EVENTS.filter(e => e.tanggal === dateStr);
        const isToday = isThisMonth && today.getDate() === d;
        const cell = createCell(d, false, isToday, events, dateStr);
        grid.appendChild(cell);
    }

    // Days in next month
    const totalRendered = firstDay + totalDays;
    const remaining = totalRendered % 7 === 0 ? 0 : 7 - (totalRendered % 7);
    for (let d = 1; d <= remaining; d++) {
        const cell = createCell(d, true, false, []);
        grid.appendChild(cell);
    }
}

function createCell(dayNum, isOtherMonth, isToday, events, dateStr) {
    const cell = document.createElement('div');
    cell.className = 'cal-cell min-h-[90px] p-2 border-r border-b border-white/30 transition hover:bg-white/40' +
        (isOtherMonth ? ' opacity-40' : '') +
        (isToday ? ' bg-indigo-50/70' : '') +
        (events.length > 0 ? ' has-event cursor-pointer' : '');

    const dateEl = document.createElement('div');
    dateEl.className = 'cal-date text-xs font-bold text-slate-700 mb-1 w-6 h-6 rounded-full flex items-center justify-center' +
        (isToday ? ' bg-indigo-600 text-white' : '');
    dateEl.textContent = dayNum;
    cell.appendChild(dateEl);

    const maxDisplay = 2;
    events.slice(0, maxDisplay).forEach(e => {
        const ev = document.createElement('div');
        ev.className = 'cal-event text-[9px] font-bold px-1.5 py-0.5 rounded text-white truncate mb-1 ' +
            (e.type === 'apel' ? 'bg-emerald-600' : 'bg-indigo-600');
        ev.textContent = (e.jam ? e.jam + ' ' : '') + e.judul;
        ev.onclick = function(evClick) {
            evClick.stopPropagation();
            openPopover(e, ev);
        };
        cell.appendChild(ev);
    });

    if (events.length > maxDisplay) {
        const more = document.createElement('div');
        more.className = 'text-[9px] font-bold text-indigo-700 text-center';
        more.textContent = `+${events.length - maxDisplay} lainnya`;
        cell.appendChild(more);
    }

    if (events.length > 0) {
        cell.onclick = function() {
            openPopover(events[0], cell);
        };
    }

    return cell;
}

let activePopoverEvent = null;

function openPopover(eventData, targetEl) {
    activePopoverEvent = eventData;
    const pop = document.getElementById('calPopover');

    document.getElementById('popTitle').textContent = eventData.judul;
    document.getElementById('popDate').textContent = formatTglIndo(eventData.tanggal);
    document.getElementById('popTime').textContent = eventData.jam ? eventData.jam + ' WIB' : 'Waktu belum diatur';

    const pRow = document.getElementById('popPembinaRow');
    const lRow = document.getElementById('popLokasiRow');
    const dRow = document.getElementById('popDesc');
    const aRow = document.getElementById('popActions');

    if (eventData.type === 'apel') {
        pRow.style.display = eventData.pembina ? 'flex' : 'none';
        document.getElementById('popPembina').textContent = eventData.pembina || '';
        lRow.style.display = eventData.lokasi ? 'flex' : 'none';
        document.getElementById('popLokasi').textContent = eventData.lokasi || '';
        if (aRow) aRow.style.display = 'none';
    } else {
        pRow.style.display = 'none';
        lRow.style.display = 'none';
        if (aRow) aRow.style.display = 'flex';
        const editBtn = document.getElementById('popEditBtn');
        if (editBtn) editBtn.href = eventData.edit_url || '#';
    }

    if (eventData.keterangan) {
        dRow.style.display = 'block';
        dRow.textContent = eventData.keterangan;
    } else {
        dRow.style.display = 'none';
    }

    const rect = targetEl.getBoundingClientRect();
    let top = rect.bottom + 8;
    let left = rect.left;

    if (left + 260 > window.innerWidth) left = window.innerWidth - 270;
    if (top + 220 > window.innerHeight) top = rect.top - 230;

    pop.style.top = Math.max(10, top) + 'px';
    pop.style.left = Math.max(10, left) + 'px';
    pop.classList.add('show');
}

function closePopover() {
    const pop = document.getElementById('calPopover');
    if (pop) pop.classList.remove('show');
    activePopoverEvent = null;
}

function popoverDelete() {
    if (activePopoverEvent && activePopoverEvent.delete_form) {
        closePopover();
        showDeleteModal(activePopoverEvent.delete_form, activePopoverEvent.judul);
    }
}

function formatTglIndo(tglStr) {
    const [y, m, d] = tglStr.split('-').map(Number);
    const date = new Date(y, m - 1, d);
    return `${HARI_ID[date.getDay()]}, ${d} ${BULAN_ID[m - 1]} ${y}`;
}

document.addEventListener('click', function(e) {
    const pop = document.getElementById('calPopover');
    if (pop && pop.classList.contains('show') && !pop.contains(e.target) && !e.target.closest('.cal-cell')) {
        closePopover();
    }
});

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
    if (IS_TARUNA) {
        renderCalendar();
    } else {
        const saved = sessionStorage.getItem('acaraView');
        if (saved === 'calendar') {
            switchView('calendar');
        } else {
            renderCalendar();
        }
    }
})();
</script>

</x-app-layout>
