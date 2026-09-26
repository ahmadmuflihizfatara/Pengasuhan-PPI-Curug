<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }

/* Pengasuh hari ini */
.hero-card {
    background:linear-gradient(135deg,#4a3aa7,#2a78d6); border-radius:18px; padding:24px 28px;
    color:white; margin-bottom:22px; display:flex; align-items:center; gap:20px; flex-wrap:wrap;
    box-shadow:0 6px 20px rgba(74,58,167,.25);
}
.hero-petugas { display:flex; gap:10px; flex-wrap:wrap; margin-top:10px; }
.hero-orang { display:flex; align-items:center; gap:8px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2); border-radius:12px; padding:6px 12px 6px 6px; }
.hero-orang small { display:block; font-size:11px; opacity:.8; font-weight:500; }
.hero-avatar { width:32px; height:32px; border-radius:50%; background:rgba(255,255,255,.22); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; flex-shrink:0; }
.hero-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; opacity:.8; margin-bottom:3px; }
.hero-name { font-size:13px; font-weight:700; }
.hero-sub { font-size:12.5px; opacity:.85; }

.hero-kosong { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); padding:34px 24px; text-align:center; margin-bottom:22px; }
.hero-kosong i { font-size:40px; color:#e2e5ee; display:block; margin-bottom:12px; }
.hero-kosong p { margin:0; font-size:14px; color:#98a0b3; font-weight:600; }

/* Duty — tabel kartu (tbl-* di app.css, sama dengan dashboard & poin) */
.ds-table tbody tr.duty-saya { background: var(--accent-tint); }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Jadwal" icon="fa-clock" subtitle="Pengasuh yang bertugas hari ini dan daftar duty taruna minggu ini" />

        {{-- Pengasuh bertugas hari ini --}}
        @if($petugas->isNotEmpty())
        <div class="hero-card">
            <div>
                <div class="hero-label">Pengasuh Bertugas Hari Ini</div>
                <div class="hero-sub">{{ $hariIni->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                <div class="hero-petugas">
                    @foreach($petugas as $x)
                    <div class="hero-orang">
                        <div class="hero-avatar">{{ strtoupper(substr($x['pengasuh']->nama, 0, 2)) }}</div>
                        <div>
                            <span class="hero-name">{{ $x['pengasuh']->nama }}</span>
                            @if($x['catatan'])<small><i class="fas fa-note-sticky"></i> {{ $x['catatan'] }}</small>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="hero-kosong">
            <i class="fas fa-user-clock"></i>
            <p>Belum ada pengasuh yang dijadwalkan untuk hari ini.</p>
        </div>
        @endif

        {{-- Duty taruna minggu ini --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-user-group ds-icon"></i> Duty Taruna Minggu Ini</h3>
                    <p class="ds-card__desc">Periode {{ \App\Models\DutyTaruna::labelPeriode($mingguIni) }}</p>
                </div>
                <span class="ds-badge ds-badge--success">{{ $duty->count() }} taruna</span>
            </div>

            @if($duty->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-clipboard-list ds-icon"></i>
                Belum ada duty taruna yang ditetapkan untuk minggu ini.
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table">
                        <thead>
                            <tr>
                                <th>Nama Taruna</th>
                                <th data-filter>Prodi</th>
                                <th class="ds-right" data-filter>Tingkat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $mahasiswaSaya = Auth::user()->mahasiswa?->id; @endphp
                            @foreach($duty as $d)
                            @php $saya = $mahasiswaSaya && $d->mahasiswa_id === $mahasiswaSaya; @endphp
                            <tr class="{{ $saya ? 'duty-saya' : '' }}">
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($d->mahasiswa->nama ?? '?', 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $d->mahasiswa->nama ?? '—' }} @if($saya)<span class="ds-badge ds-badge--accent">Saya</span>@endif</div>
                                            <div class="tbl-sub">NPM {{ $d->mahasiswa->npm ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ds-badge ds-badge--info">{{ $d->mahasiswa->prodi ?? '-' }}</span></td>
                                <td class="ds-right"><span class="ds-badge ds-badge--success">Tk. {{ $d->mahasiswa->tingkat ?? '-' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

    </div>
</main>
</x-app-layout>
