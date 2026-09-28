<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }

/* Kartu — PPI Curug Glass (ds-card, ds-label, ds-select, ds-btn--pill) */
.selector-row { display: flex; gap: var(--space-3); flex-wrap: wrap; align-items: center; }
.selector-row { align-items: flex-end; }
.date-wrap { flex: 0 1 260px; min-width: 200px; }
.date-wrap .ds-input { cursor: pointer; }
.filter-chips { display: flex; gap: var(--space-2); flex-wrap: wrap; }
.chip {
    display: inline-flex; align-items: center; text-decoration: none;
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
        <x-page-banner title="Jadwal Apel" icon="fa-clipboard-check"
            subtitle="Lihat waktu pelaksanaan, pembina, dan lokasi apel" />

        @php
            $jenisApel = ['' => 'Semua', 'pagi' => 'Pagi', 'malam' => 'Malam', 'khusus' => 'Khusus'];
            $tanggalLabel = $tanggal->locale('id')->isoFormat('dddd, D MMMM Y');
        @endphp

        {{-- Pilih tanggal + filter jenis apel --}}
        <div class="ds-card mb-4">
            <form method="GET" action="{{ route('apel.jadwal') }}" class="selector-row">
                <div class="date-wrap">
                    <label class="ds-label" for="tanggalApel">Tanggal Apel</label>
                    <input type="date" id="tanggalApel" name="tanggal" class="ds-input"
                           value="{{ $tanggal->format('Y-m-d') }}" onchange="this.form.submit()">
                    @if($sesi)<input type="hidden" name="sesi" value="{{ $sesi }}">@endif
                </div>
                <div>
                    <span class="ds-label">Jenis Apel</span>
                    <div class="filter-chips">
                        @foreach($jenisApel as $nilai => $label)
                        <a href="{{ route('apel.jadwal', array_filter(['tanggal' => $tanggal->format('Y-m-d'), 'sesi' => $nilai])) }}"
                           class="chip {{ ($sesi ?? '') === $nilai ? 'active' : '' }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        @forelse($daftarApel as $apel)
        {{-- Detail apel — hanya jadwal, pembina, lokasi --}}
        <div class="ds-card mb-4">
            <div class="ds-card__head detail-head">
                <div class="ikon" style="background:linear-gradient(135deg,{{ $apel->warna }},var(--accent));"><i class="fas {{ $apel->ikon }}"></i></div>
                <div>
                    <h2>{{ $apel->judul }}</h2>
                    <div class="meta">
                        <span><i class="fas fa-calendar-day"></i> {{ $tanggalLabel }}</span>
                        @if($apel->jam)
                        <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($apel->jam)->format('H:i') }} WIB</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="label"><i class="fas fa-user-tie"></i> Pembina Apel</div>
                    <div class="value">
                        {{ $apel->pembina }}
                        @if($apel->pembinaUser?->jabatan)
                        <small>{{ $apel->pembinaUser->jabatan }}</small>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="label"><i class="fas fa-location-dot"></i> Lokasi Apel</div>
                    <div class="value">{{ $apel->lokasi }}</div>
                </div>
                <div class="info-item">
                    <div class="label"><i class="fas fa-flag"></i> Jenis</div>
                    <div class="value">{{ $apel->judul }}
                        <small>{{ ucfirst($apel->sesi) }}</small>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="ds-card">
            <div class="ds-empty">
                <i class="fas fa-flag ds-icon"></i>
                Tidak ada apel{{ $sesi ? ' ' . strtolower($jenisApel[$sesi]) : '' }} pada {{ $tanggalLabel }}.
            </div>
        </div>
        @endforelse
    </div>
</main>
</x-app-layout>
