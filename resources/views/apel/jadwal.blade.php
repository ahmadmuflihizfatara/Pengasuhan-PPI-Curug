<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }

/* Kartu — PPI Curug Glass (ds-card, ds-label, ds-select, ds-btn--pill) */
.selector-row { display: flex; gap: var(--space-3); flex-wrap: wrap; align-items: center; }
.select-wrap { position: relative; flex: 1; min-width: 260px; }
.select-wrap .ds-select { appearance: none; padding-right: 40px; cursor: pointer; }
.select-wrap i { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--ink-500); pointer-events: none; font-size: 12px; }
.filter-chips { display: flex; gap: var(--space-2); flex-wrap: wrap; }
.chip {
    display: inline-flex; align-items: center;
    padding: var(--space-2) var(--space-4); border-radius: var(--radius-pill);
    background: var(--glass-card); border: 1px solid var(--border-glass-glow);
    backdrop-filter: blur(var(--blur-subtle)); -webkit-backdrop-filter: blur(var(--blur-subtle));
    box-shadow: var(--shadow-glass-sm);
    font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); cursor: pointer;
    transition: background-color .15s, color .15s, transform .1s;
}
.chip:hover { background: var(--glass-solid); color: var(--ink-900); }
.chip:active { transform: scale(.97); }
.chip.active { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); }

.detail-head { display: flex; align-items: center; gap: var(--space-4); flex-wrap: wrap; }
.detail-head .ikon {
    width: 48px; height: 48px; border-radius: var(--radius-md); flex-shrink: 0;
    display: grid; place-items: center; font-size: 20px; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm);
}
.detail-head h2 { margin: 0 0 2px; font-size: 16px; line-height: 22px; font-weight: 800; color: var(--ink-900); }
.detail-head .meta { font-size: 12px; font-weight: 600; color: var(--ink-600); display: flex; gap: var(--space-3-5); flex-wrap: wrap; }
.detail-head .meta i { color: var(--accent); margin-right: 2px; }

.info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: var(--space-4); }
.info-item {
    background: var(--glass-card); border: 1px solid var(--border-glass-glow);
    border-radius: var(--radius-md); padding: var(--space-3-5) var(--space-4);
}
.info-item .label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-600); margin-bottom: var(--space-1-5); display: flex; align-items: center; gap: var(--space-1-5); }
.info-item .label i { color: var(--accent); }
.info-item .value { font-size: 14px; font-weight: 700; color: var(--ink-900); }
.info-item .value small { display: block; font-size: 11px; font-weight: 500; color: var(--ink-500); margin-top: 2px; }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header Banner — sama dengan header tab poin --}}
        <div class="greeting-banner rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 sm:p-8 text-white mb-4 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="relative z-10 max-w-xl">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-0">Jadwal Apel</h1>
                <p class="text-xs sm:text-sm text-sky-100/80 leading-relaxed mt-1.5">Lihat waktu pelaksanaan, pembina, dan lokasi apel</p>
            </div>

            @php $user = auth()->user(); @endphp
            <div class="relative z-10 flex-shrink-0 flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3 sm:px-5 sm:py-3.5 shadow-inner">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black text-lg shadow-md">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-xs font-bold text-white max-w-[140px] truncate">{{ $user->name }}</div>
                    <div class="text-[10px] font-semibold text-amber-300">Taruna</div>
                    <div class="text-[9px] text-slate-300 font-mono mt-0.5">NIT: {{ $user->mahasiswa?->npm ?? '-' }}</div>
                </div>
            </div>

            <div class="absolute -right-16 -top-16 w-56 h-56 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-32 -bottom-20 w-48 h-48 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        @if($daftarApel->isEmpty())
        <div class="ds-card">
            <div class="ds-empty">
                <i class="fas fa-flag ds-icon"></i>
                Belum ada jadwal apel yang tercatat.
            </div>
        </div>
        @else

        {{-- Dropdown pemilih apel --}}
        <div class="ds-card mb-4">
            <label class="ds-label" for="apelSelect">Pilih Apel</label>
            <div class="selector-row">
                <div class="select-wrap">
                    <select id="apelSelect" class="ds-select" onchange="bukaApel(this.value)">
                        @foreach($daftarApel as $item)
                        <option value="{{ $item->id }}"
                                data-sesi="{{ $item->sesi }}"
                                @selected($terpilih && $terpilih->id === $item->id)>
                            {{ $item->label_dropdown }}@if($item->jam) · {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}@endif
                        </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="filter-chips">
                    <div class="chip active" data-filter="all" onclick="filterSesi('all', this)">Semua</div>
                    <div class="chip" data-filter="pagi" onclick="filterSesi('pagi', this)">Pagi</div>
                    <div class="chip" data-filter="malam" onclick="filterSesi('malam', this)">Malam</div>
                    <div class="chip" data-filter="khusus" onclick="filterSesi('khusus', this)">Khusus</div>
                </div>
            </div>
        </div>

        {{-- Detail apel terpilih — hanya jadwal, pembina, lokasi --}}
        @if($terpilih)
        <div class="ds-card">
            <div class="ds-card__head detail-head">
                <div class="ikon" style="background:linear-gradient(135deg,{{ $terpilih->warna }},var(--accent));"><i class="fas {{ $terpilih->ikon }}"></i></div>
                <div>
                    <h2>{{ $terpilih->judul }}</h2>
                    <div class="meta">
                        <span><i class="fas fa-calendar-day"></i>
                            {{ $terpilih->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                        @if($terpilih->jam)
                        <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($terpilih->jam)->format('H:i') }} WIB</span>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="label"><i class="fas fa-user-tie"></i> Pembina Apel</div>
                        <div class="value">
                            {{ $terpilih->pembina }}
                            @if($terpilih->pembinaUser?->jabatan)
                            <small>{{ $terpilih->pembinaUser->jabatan }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="label"><i class="fas fa-location-dot"></i> Lokasi Apel</div>
                        <div class="value">{{ $terpilih->lokasi }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label"><i class="fas fa-flag"></i> Sesi</div>
                        <div class="value">{{ $terpilih->judul }}
                            <small>{{ ucfirst($terpilih->sesi) }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @endif
    </div>
</main>

<script>
function bukaApel(id) {
    window.location = '{{ route('apel.jadwal') }}?apel=' + id;
}

function filterSesi(sesi, chipEl) {
    document.querySelectorAll('.chip').forEach(c => c.classList.toggle('active', c === chipEl));

    const select = document.getElementById('apelSelect');
    let pertamaCocok = null;

    [...select.options].forEach(opt => {
        const cocok = sesi === 'all' || opt.dataset.sesi === sesi;
        opt.hidden = !cocok;
        if (cocok && pertamaCocok === null) pertamaCocok = opt;
    });

    if (pertamaCocok && select.selectedOptions[0].hidden) {
        bukaApel(pertamaCocok.value);
    }
}
</script>
</x-app-layout>
