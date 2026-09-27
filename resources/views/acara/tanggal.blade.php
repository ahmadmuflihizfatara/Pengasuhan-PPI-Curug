<x-app-layout>
@php
    $isTaruna   = Auth::user()->hasTarunaAccess();
    $sebelumnya = $tanggal->copy()->subDay();
    $berikutnya = $tanggal->copy()->addDay();
    $jam        = fn ($j) => $j ? \Carbon\Carbon::parse($j)->format('H:i') : null;
    $label      = $tanggal->isToday() ? 'Hari ini' : ($tanggal->isTomorrow() ? 'Besok' : ($tanggal->isYesterday() ? 'Kemarin' : null));
@endphp

<style>
    .hr-nav { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .hr-nav__hari { display: flex; align-items: center; gap: var(--space-2); flex-wrap: wrap; }
    .hr-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .hr-kembali:hover { color: var(--accent-ink); }
    .hr-tanggal { font-size: 14px; line-height: 20px; font-weight: 800; color: var(--ink-900); }
    .hr-tanggal small { margin-left: var(--space-1-5); }

    .hr-list { display: flex; flex-direction: column; gap: var(--space-2-5); }
    .hr-item { display: flex; align-items: flex-start; gap: var(--space-3); padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .hr-jam { flex-shrink: 0; min-width: 58px; padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); text-align: center; background: var(--accent-tint); color: var(--accent-ink); font-family: var(--font-mono); font-size: 13px; line-height: 18px; font-weight: 800; }
    .hr-jam small { display: block; font-family: var(--font-sans); font-size: 9px; line-height: 12px; font-weight: 700; letter-spacing: .06em; }
    .hr-item--apel .hr-jam { background: var(--success-tint); color: var(--success-ink); }
    .hr-body { min-width: 0; flex: 1; }
    .hr-judul { font-size: 14px; line-height: 20px; font-weight: 800; color: var(--ink-900); }
    .hr-meta { display: flex; flex-wrap: wrap; gap: var(--space-1) var(--space-3); margin-top: var(--space-1); font-size: 12px; line-height: 16px; font-weight: 600; color: var(--ink-700); }
    .hr-meta i { color: var(--accent); margin-right: var(--space-1); }
    .hr-item--apel .hr-meta i { color: var(--success-ink); }
    .hr-ket { margin: var(--space-2) 0 0; font-size: 12px; line-height: 18px; font-weight: 500; color: var(--ink-700); white-space: pre-line; overflow-wrap: anywhere; }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Agenda Harian" icon="fa-calendar-day"
            :subtitle="$tanggal->locale('id')->isoFormat('dddd, D MMMM Y') . ' — acara dan apel yang terjadwal pada tanggal ini'" />

        {{-- Navigasi: kembali ke kalender & pindah hari --}}
        <div class="ds-card hr-nav mb-4">
            <a href="{{ route('acara.index', ['bulan' => $tanggal->format('Y-m')]) }}" class="ds-btn ds-btn--pill hr-kembali">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Kalender
            </a>
            <div class="hr-nav__hari">
                <a href="{{ route('acara.tanggal', $sebelumnya->format('Y-m-d')) }}" class="ds-btn ds-btn--icon" aria-label="Hari sebelumnya, {{ $sebelumnya->locale('id')->isoFormat('D MMMM Y') }}">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <span class="hr-tanggal">
                    {{ $tanggal->locale('id')->isoFormat('ddd, D MMM Y') }}
                    @if($label)<small class="ds-badge ds-badge--accent">{{ $label }}</small>@endif
                </span>
                <a href="{{ route('acara.tanggal', $berikutnya->format('Y-m-d')) }}" class="ds-btn ds-btn--icon" aria-label="Hari berikutnya, {{ $berikutnya->locale('id')->isoFormat('D MMMM Y') }}">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
                @unless($tanggal->isToday())
                <a href="{{ route('acara.tanggal', today()->format('Y-m-d')) }}" class="ds-btn ds-btn--sm ds-btn--pill">Hari ini</a>
                @endunless
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {{-- Acara --}}
            <div class="ds-card">
                <div class="ds-card__head tbl-head">
                    <div>
                        <h3 class="ds-card__title"><i class="fa-solid fa-calendar-check ds-icon"></i> Acara Terjadwal</h3>
                        <p class="ds-card__desc">Kegiatan pengasuhan pada tanggal ini</p>
                    </div>
                    <span class="ds-badge ds-badge--accent">{{ $acara->count() }} acara</span>
                </div>
                @if($acara->isEmpty())
                <div class="ds-empty">
                    <i class="fa-solid fa-calendar-xmark ds-icon"></i>
                    Tidak ada acara pada tanggal ini.
                </div>
                @else
                <div class="hr-list">
                    @foreach($acara as $a)
                    <div class="hr-item">
                        <span class="hr-jam">{{ $jam($a->jam) ?? '—' }}<small>WIB</small></span>
                        <div class="hr-body">
                            <div class="hr-judul">{{ $a->nama_acara }}</div>
                            @if($a->keterangan)<p class="hr-ket">{{ $a->keterangan }}</p>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Apel — taruna hanya melihat jam, pembina & lokasi (sama dengan tab jadwal apel) --}}
            <div class="ds-card">
                <div class="ds-card__head tbl-head">
                    <div>
                        <h3 class="ds-card__title"><i class="fa-solid fa-flag ds-icon"></i> Apel Taruna</h3>
                        <p class="ds-card__desc">Sesi apel pada tanggal ini</p>
                    </div>
                    <span class="ds-badge ds-badge--success">{{ $apel->count() }} apel</span>
                </div>
                @if($apel->isEmpty())
                <div class="ds-empty">
                    <i class="fa-solid fa-flag ds-icon"></i>
                    Tidak ada apel pada tanggal ini.
                </div>
                @else
                <div class="hr-list">
                    @foreach($apel as $p)
                    <div class="hr-item hr-item--apel">
                        <span class="hr-jam">{{ $jam($p->jam) ?? '—' }}<small>WIB</small></span>
                        <div class="hr-body">
                            <div class="hr-judul">{{ $p->judul }}</div>
                            <div class="hr-meta">
                                @if($p->pembina)<span><i class="fa-solid fa-user-tie"></i>{{ $p->pembina }}{{ $p->pembinaUser?->jabatan ? ' · '.$p->pembinaUser->jabatan : '' }}</span>@endif
                                @if($p->lokasi)<span><i class="fa-solid fa-location-dot"></i>{{ $p->lokasi }}</span>@endif
                            </div>
                            @if(!$isTaruna && $p->informasi)<p class="hr-ket">{{ $p->informasi }}</p>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

    </div>
</main>
</x-app-layout>
