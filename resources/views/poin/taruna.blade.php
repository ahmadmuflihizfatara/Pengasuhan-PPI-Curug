<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Header Banner — sama dengan header dashboard --}}
                <div class="greeting-banner rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 sm:p-8 text-white mb-4 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10 max-w-xl">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-0">Raport Poin &amp; Disiplin Taruna</h1>
                        <p class="text-xs sm:text-sm text-sky-100/80 leading-relaxed mt-1.5">Pantau akumulasi Poin Pelanggaran (-) dan Poin Penghargaan (+) secara mandiri</p>
                    </div>

                    @if($selectedStudent)
                    <div class="relative z-10 flex-shrink-0 flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3 sm:px-5 sm:py-3.5 shadow-inner">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black text-lg shadow-md">
                            {{ strtoupper(substr($selectedStudent->nama, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white max-w-[140px] truncate">{{ $selectedStudent->nama }}</div>
                            <div class="text-[10px] font-semibold text-amber-300">Taruna</div>
                            <div class="text-[9px] text-slate-300 font-mono mt-0.5">NIT: {{ $selectedStudent->npm }}</div>
                        </div>
                    </div>
                    @endif

                    {{-- Ambient circular light overlays --}}
                    <div class="absolute -right-16 -top-16 w-56 h-56 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute right-32 -bottom-20 w-48 h-48 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                @if(!$selectedStudent)
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-10 text-center shadow-lg">
                    <div class="w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-3xl mx-auto mb-3 shadow-inner">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">Akun Taruna Tidak Terhubung ke Database Mahasiswa</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">Silakan hubungi Pengasuh atau Administrator untuk memeriksa konfigurasi data akun Anda.</p>
                </div>
                @else

                {{-- STATUS SANKSI + AKUMULASI — satu pola kartu PPI Curug Glass --}}
                @php
                    // Status hanya dibawa ikon & badge; teks tetap ink agar jelas di atas kaca
                    $sanksiVarian = match ($statusSanksi['level']) {
                        'aman'       => 'success',
                        'sp1', 'sp2' => 'warning',
                        default      => 'danger',
                    };
                @endphp
                <div class="ds-card pn-card mb-4">
                    <span class="ds-stat__icon ds-stat__icon--{{ $sanksiVarian }}"><i class="{{ $statusSanksi['icon'] }}"></i></span>
                    <div class="pn-card__body">
                        <span class="pn-card__label">Status Kedisiplinan</span>
                        <div class="pn-card__top">
                            <span class="pn-card__value">{{ $statusSanksi['status'] }}</span>
                            <span class="ds-badge ds-badge--{{ $sanksiVarian }}">Poin total {{ (float) $poinTotal }}</span>
                        </div>
                        <p class="pn-card__desc">{{ $statusSanksi['desc'] }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="ds-card pn-card pn-card--tall">
                        <span class="ds-stat__icon"><i class="fa-solid fa-scale-balanced"></i></span>
                        <div class="pn-card__body">
                            <span class="pn-card__label">Total Poin</span>
                            <div class="pn-card__top">
                                <span class="pn-card__value pn-card__value--num">{{ (float) $poinTotal }} poin</span>
                                <span class="ds-badge ds-badge--{{ $sanksiVarian }}">{{ $statusSanksi['status'] }}</span>
                            </div>
                            <p class="pn-card__desc">Poin awal {{ \App\Models\PoinMahasiswa::POIN_AWAL }} + penghargaan − pelanggaran</p>
                        </div>
                    </div>

                    <div class="ds-card pn-card pn-card--tall">
                        <span class="ds-stat__icon ds-stat__icon--danger"><i class="fa-solid fa-triangle-exclamation"></i></span>
                        <div class="pn-card__body">
                            <span class="pn-card__label">Akumulasi Pelanggaran</span>
                            <div class="pn-card__top">
                                <span class="pn-card__value pn-card__value--num" style="color:var(--danger-ink)">{{ (float) $totalPelanggaran }} poin</span>
                                <span class="ds-badge ds-badge--danger">{{ $riwayatPelanggaran->count() }} temuan</span>
                            </div>
                            <p class="pn-card__desc">Mengurangi poin total</p>
                        </div>
                    </div>

                    <div class="ds-card pn-card pn-card--tall">
                        <span class="ds-stat__icon ds-stat__icon--success"><i class="fa-solid fa-trophy"></i></span>
                        <div class="pn-card__body">
                            <span class="pn-card__label">Akumulasi Penghargaan</span>
                            <div class="pn-card__top">
                                <span class="pn-card__value pn-card__value--num" style="color:var(--success-ink)">+{{ (float) $totalPenghargaan }} poin</span>
                                <span class="ds-badge ds-badge--success">{{ $riwayatPenghargaan->count() }} prestasi</span>
                            </div>
                            <p class="pn-card__desc">Menambah poin total</p>
                        </div>
                    </div>
                </div>

                <style>
                    .pn-card { display: flex; align-items: center; gap: var(--space-3-5); padding: var(--space-3-5) var(--space-5); }
                    .pn-card .ds-stat__icon { flex-shrink: 0; }
                    .pn-card__body { min-width: 0; flex: 1; }
                    .pn-card__top { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-1) var(--space-2-5); }
                    .pn-card__label { display: block; font-size: 11px; line-height: 16px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
                    .pn-card__value { font-size: 15px; line-height: 20px; font-weight: 800; color: var(--ink-900); }
                    .pn-card__value--num { font-family: var(--font-mono); font-size: 18px; letter-spacing: -0.02em; }
                    .pn-card__top { margin-top: 2px; }
                    .pn-card--tall { align-items: flex-start; padding: var(--space-5) var(--space-5) var(--space-6); }
                    .pn-card--tall .ds-stat__icon { width: 44px; height: 44px; font-size: 17px; }
                    .pn-card--tall .pn-card__top { margin: var(--space-1-5) 0 var(--space-1); }
                    .pn-card--tall .pn-card__value--num { font-size: 30px; line-height: 36px; font-weight: 900; }
                    .pn-card__desc { margin: 3px 0 0; font-size: 12px; line-height: 17px; font-weight: 500; color: var(--ink-700); }
                </style>

                {{-- Rentang status kedisiplinan pada garis poin total (−60 … 90), segmen & legenda bisa diklik --}}
                @php
                    $skalaMin = -60;
                    $skalaMaks = 90;
                    $skala = $skalaMaks - $skalaMin;
                    $angka = fn ($n) => str_replace('-', '−', (string) (float) $n);
                    $gaya = [
                        'sp3'  => ['var(--danger)',  'danger'],
                        'sp2'  => ['#ea580c',        'warning'],
                        'sp1'  => ['#f59e0b',        'warning'],
                        'aman' => ['var(--success)', 'success'],
                    ];
                    // Batas tiap tingkat & deskripsi dari model — sumber yang sama dengan kartu status
                    $rentang = [];
                    foreach (\App\Models\PoinMahasiswa::TINGKAT_SANKSI as $key => $t) {
                        $dari   = $t['bawah'] === null ? $skalaMin : $t['bawah'] - 1;
                        $sampai = $t['atas'] ?? $skalaMaks;
                        $info   = \App\Models\PoinMahasiswa::getStatusSanksi($t['atas'] ?? $t['bawah']);
                        $rentang[] = [
                            'key'    => $key,
                            'label'  => $t['label'],
                            'range'  => $t['bawah'] === null ? '≤ '.$angka($t['atas'])
                                      : ($t['atas'] === null ? '≥ '.$angka($t['bawah'])
                                      : $angka($t['bawah']).' – '.$angka($t['atas'])),
                            'lebar'  => ($sampai - $dari) / $skala * 100,
                            'warna'  => $gaya[$key][0],
                            'varian' => $gaya[$key][1],
                            'desc'   => $info['desc'],
                            'icon'   => $info['icon'],
                            // Jarak dari poin total sekarang ke tingkat ini
                            'jarak'  => ($t['atas'] !== null && $poinTotal > $t['atas'])
                                ? 'Berkurang '.$angka($poinTotal - $t['atas']).' poin lagi menuju tingkat ini'
                                : (($t['bawah'] !== null && $poinTotal < $t['bawah'])
                                    ? 'Perlu '.$angka($t['bawah'] - $poinTotal).' poin lagi menuju tingkat ini' : null),
                        ];
                    }
                    $posisi = (max($skalaMin, min($skalaMaks, $poinTotal)) - $skalaMin) / $skala * 100;
                @endphp
                <div class="ds-card rg-card mb-4" x-data="{ pilih: '{{ $statusSanksi['level'] }}' }">
                    <div class="ds-card__head">
                        <h3 class="ds-card__title"><i class="fa-solid fa-gauge-high ds-icon"></i> Rentang Status Kedisiplinan</h3>
                        <p class="ds-card__desc">Berdasarkan poin total. Klik bar atau tingkat di bawahnya untuk melihat ketentuan tiap tingkat</p>
                    </div>

                    <div class="rg-track-wrap">
                        <div class="rg-marker" style="left: clamp(32px, {{ $posisi }}%, calc(100% - 32px))">
                            <span class="rg-marker__pill">{{ $angka($poinTotal) }} poin</span>
                            <span class="rg-marker__tip"></span>
                        </div>
                        <div class="rg-track">
                            @foreach($rentang as $r)
                            <button type="button" class="rg-seg" style="flex-basis: {{ $r['lebar'] }}%; background: {{ $r['warna'] }};"
                                    :class="{ 'rg-seg--pilih': pilih === '{{ $r['key'] }}' }" @click="pilih = '{{ $r['key'] }}'"
                                    :aria-pressed="pilih === '{{ $r['key'] }}'" aria-label="{{ $r['label'] }}, {{ $r['range'] }} poin"></button>
                            @endforeach
                        </div>
                    </div>

                    <div class="rg-legend" role="group" aria-label="Tingkat status kedisiplinan">
                        @foreach($rentang as $r)
                        <button type="button" class="rg-item" style="--rg-lebar: {{ $r['lebar'] }}%"
                                :class="{ 'rg-item--pilih': pilih === '{{ $r['key'] }}' }" @click="pilih = '{{ $r['key'] }}'"
                                :aria-pressed="pilih === '{{ $r['key'] }}'">
                            <span class="rg-item__swatch" style="background: {{ $r['warna'] }}"></span>
                            <span>
                                <span class="rg-item__label">{{ $r['label'] }}</span>
                                <span class="rg-item__range">{{ $r['range'] }} poin</span>
                                @if($r['key'] === $statusSanksi['level'])<span class="ds-badge ds-badge--dark rg-item__now">Saat ini</span>@endif
                            </span>
                        </button>
                        @endforeach
                    </div>

                    {{-- Detail tingkat yang dipilih --}}
                    @foreach($rentang as $r)
                    <div class="rg-detail" x-show="pilih === '{{ $r['key'] }}'" x-cloak aria-live="polite">
                        <span class="ds-stat__icon ds-stat__icon--{{ $r['varian'] }}"><i class="{{ $r['icon'] }}"></i></span>
                        <div class="rg-detail__body">
                            <div class="rg-detail__top">
                                <span class="rg-detail__title">{{ $r['label'] }}</span>
                                <span class="ds-badge ds-badge--{{ $r['varian'] }}">{{ $r['range'] }} poin</span>
                                @if($r['key'] === $statusSanksi['level'])
                                <span class="ds-badge ds-badge--dark">Status saat ini</span>
                                @elseif($r['jarak'])
                                <span class="ds-badge">{{ $r['jarak'] }}</span>
                                @endif
                            </div>
                            <p class="rg-detail__desc">{{ $r['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <style>
                    [x-cloak] { display: none !important; }
                    .rg-track-wrap { position: relative; padding-top: 34px; }
                    .rg-track {
                        display: flex; gap: 3px; height: 20px; padding: 3px; border-radius: var(--radius-pill);
                        background: var(--glass-card); border: 1px solid var(--border-glass-glow);
                        box-shadow: inset 0 1px 3px rgba(15,23,42,.12);
                    }
                    .rg-seg {
                        height: 100%; padding: 0; border: 0; border-radius: var(--radius-pill); cursor: pointer;
                        opacity: .45; transition: opacity .15s, transform .15s, box-shadow .15s;
                    }
                    .rg-seg:hover { opacity: .8; }
                    .rg-seg:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
                    .rg-seg--pilih { opacity: 1; box-shadow: 0 0 0 2px #fff, 0 2px 8px rgba(15,23,42,.25); }
                    .rg-marker { position: absolute; top: 0; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; pointer-events: none; }
                    .rg-marker__pill {
                        padding: 3px 10px; border-radius: var(--radius-pill); white-space: nowrap;
                        background: var(--glass-dark); color: var(--ink-on-dark);
                        font-family: var(--font-mono); font-size: 11px; line-height: 16px; font-weight: 700;
                        box-shadow: var(--shadow-glass-sm);
                    }
                    .rg-marker__tip { width: 0; height: 0; border: 5px solid transparent; border-top-color: var(--glass-dark); border-bottom: 0; }
                    .rg-legend { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-2); margin-top: var(--space-3); }
                    @media (min-width: 640px) { .rg-legend { display: flex; gap: 3px; } .rg-item { flex: 0 0 calc(var(--rg-lebar) - 3px); } }
                    .rg-item {
                        display: flex; align-items: flex-start; gap: var(--space-2); min-width: 0; text-align: left;
                        padding: var(--space-2) var(--space-2-5); border-radius: var(--radius-md);
                        background: transparent; border: 1px solid transparent; cursor: pointer; font-family: inherit;
                        transition: background-color .15s, border-color .15s;
                    }
                    .rg-item:hover { background: var(--glass-subtle); }
                    .rg-item:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
                    .rg-item--pilih, .rg-item--pilih:hover { background: var(--glass-solid); border-color: var(--border-glass-glow); box-shadow: var(--shadow-glass-sm); }
                    .rg-item__swatch { width: 10px; height: 10px; border-radius: 3px; margin-top: 3px; flex-shrink: 0; }
                    .rg-item__label { display: block; font-size: 12px; line-height: 16px; font-weight: 800; color: var(--ink-900); }
                    .rg-item__range { display: block; font-family: var(--font-mono); font-size: 11px; line-height: 16px; font-weight: 600; color: var(--ink-600); }
                    .rg-item__now { margin-top: 4px; }
                    .rg-detail {
                        display: flex; align-items: flex-start; gap: var(--space-3); margin-top: var(--space-3);
                        padding: var(--space-3-5) var(--space-4); border-radius: var(--radius-md);
                        background: var(--glass-card); border: 1px solid var(--border-glass-glow);
                        animation: rg-in .2s cubic-bezier(.16,1,.3,1);
                    }
                    .rg-detail .ds-stat__icon { flex-shrink: 0; }
                    .rg-detail__top { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-1-5) var(--space-2); }
                    .rg-detail__title { font-size: 14px; line-height: 20px; font-weight: 800; color: var(--ink-900); }
                    .rg-detail__desc { margin: var(--space-1) 0 0; font-size: 12px; line-height: 18px; font-weight: 500; color: var(--ink-700); }
                    @keyframes rg-in { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: none; } }
                </style>

                {{-- RIWAYAT POIN: tab pelanggaran / penghargaan --}}
                @php
                    $angkaPoin = fn ($n) => rtrim(rtrim(number_format((float) $n, 2, ',', '.'), '0'), ',');
                    $varianTingkat = fn ($t) => match (strtolower((string) $t)) {
                        'berat'  => 'danger',
                        'sedang' => 'warning',
                        default  => '',
                    };
                @endphp
                <div class="ds-card" x-data="{ tab: 'pelanggaran' }">
                    <div class="ds-card__head rw-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-clock-rotate-left ds-icon"></i> Riwayat Poin</h3>
                            <p class="ds-card__desc">Catatan poin yang sudah divalidasi pengasuh</p>
                        </div>
                        <div class="rw-tabs" role="tablist" aria-label="Jenis riwayat poin">
                            <button type="button" role="tab" class="rw-tab" :class="{ 'rw-tab--aktif': tab === 'pelanggaran' }"
                                    :aria-selected="tab === 'pelanggaran'" @click="tab = 'pelanggaran'">
                                <i class="fa-solid fa-ban" style="color:var(--danger-ink)"></i> Pelanggaran
                                <span class="ds-badge ds-badge--danger">{{ $riwayatPelanggaran->count() }}</span>
                            </button>
                            <button type="button" role="tab" class="rw-tab" :class="{ 'rw-tab--aktif': tab === 'penghargaan' }"
                                    :aria-selected="tab === 'penghargaan'" @click="tab = 'penghargaan'">
                                <i class="fa-solid fa-trophy" style="color:var(--success-ink)"></i> Penghargaan
                                <span class="ds-badge ds-badge--success">{{ $riwayatPenghargaan->count() }}</span>
                            </button>
                        </div>
                    </div>

                    {{-- TAB PELANGGARAN --}}
                    <div x-show="tab === 'pelanggaran'" role="tabpanel">
                        @if($riwayatPelanggaran->isEmpty())
                        <div class="ds-empty">
                            <i class="fa-solid fa-shield-halved ds-icon"></i>
                            Tidak ada catatan pelanggaran.
                        </div>
                        @else
                        <div class="ds-table-wrap">
                            <div class="ds-scroll">
                                <table class="ds-table rw-table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th data-filter>Tingkat</th>
                                            <th>Pelanggaran PTTT</th>
                                            <th class="ds-right">Poin</th>
                                            <th data-filter>Pemeriksa</th>
                                            <th class="ds-right" data-no-filter>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayatPelanggaran as $p)
                                        <tr>
                                            <td class="rw-date" data-sort="{{ $p->tanggal?->format('Y-m-d') }}">{{ $p->tanggal ? $p->tanggal->locale('id')->isoFormat('D MMM Y') : '—' }}</td>
                                            <td><span class="ds-badge {{ $varianTingkat($p->tingkat) ? 'ds-badge--'.$varianTingkat($p->tingkat) : '' }}">{{ ucfirst($p->tingkat ?? 'Pelanggaran') }}</span></td>
                                            <td>
                                                <div class="rw-title">{{ $p->kegiatan }}</div>
                                                @if($p->keterangan)<div class="rw-sub">{{ $p->keterangan }}</div>@endif
                                            </td>
                                            <td class="ds-right rw-poin" style="color:var(--danger-ink)" data-sort="{{ (float) $p->nilai }}">−{{ $angkaPoin($p->nilai) }}</td>
                                            <td class="rw-by">{{ $p->pengasuh ?: '—' }}</td>
                                            <td class="ds-right"><span class="ds-badge ds-badge--success"><i class="fa-solid fa-circle-check"></i> Tervalidasi</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- TAB PENGHARGAAN --}}
                    <div x-show="tab === 'penghargaan'" x-cloak role="tabpanel">
                        @if($riwayatPenghargaan->isEmpty())
                        <div class="ds-empty">
                            <i class="fa-solid fa-award ds-icon"></i>
                            Belum ada catatan penghargaan.
                        </div>
                        @else
                        <div class="ds-table-wrap">
                            <div class="ds-scroll">
                                <table class="ds-table rw-table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th data-filter>Tingkat</th>
                                            <th>Prestasi / Penghargaan</th>
                                            <th class="ds-right">Poin</th>
                                            <th data-filter>Rekomendasi</th>
                                            <th class="ds-right" data-no-filter>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayatPenghargaan as $r)
                                        <tr>
                                            <td class="rw-date" data-sort="{{ $r->tanggal?->format('Y-m-d') }}">{{ $r->tanggal ? $r->tanggal->locale('id')->isoFormat('D MMM Y') : '—' }}</td>
                                            <td><span class="ds-badge ds-badge--success">{{ ucfirst($r->tingkat ?? 'Prestasi') }}</span></td>
                                            <td>
                                                <div class="rw-title">{{ $r->kegiatan }}</div>
                                                @if($r->keterangan)<div class="rw-sub">{{ $r->keterangan }}</div>@endif
                                            </td>
                                            <td class="ds-right rw-poin" style="color:var(--success-ink)" data-sort="{{ (float) $r->nilai }}">+{{ $angkaPoin($r->nilai) }}</td>
                                            <td class="rw-by">{{ $r->pengasuh ?: '—' }}</td>
                                            <td class="ds-right"><span class="ds-badge ds-badge--success"><i class="fa-solid fa-circle-check"></i> Tervalidasi</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <style>
                    .rw-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: var(--space-3); }
                    .rw-tabs { display: inline-flex; gap: var(--space-1); padding: var(--space-1); border-radius: var(--radius-pill); background: var(--glass-subtle); border: 1px solid var(--border-glass); }
                    .rw-tab {
                        display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-2) var(--space-3-5);
                        border: 1px solid transparent; border-radius: var(--radius-pill); background: transparent; cursor: pointer;
                        font-family: inherit; font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700);
                        transition: background-color .15s, color .15s;
                    }
                    .rw-tab:hover { background: var(--glass-card); color: var(--ink-900); }
                    .rw-tab:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
                    .rw-tab--aktif, .rw-tab--aktif:hover { background: var(--glass-solid); border-color: var(--border-glass-glow); color: var(--ink-900); box-shadow: var(--shadow-glass-sm); }
                    @media (max-width: 480px) { .rw-tabs { width: 100%; } .rw-tab { flex: 1; justify-content: center; padding: var(--space-2); } .rw-tab > i { display: none; } }
                    .rw-table td { vertical-align: top; }
                    .ds-table td.rw-date { white-space: nowrap; font-weight: 600; color: var(--ink-700) !important; }
                    .rw-title { font-size: 13px; line-height: 18px; font-weight: 700; color: var(--ink-900); }
                    .rw-sub { margin-top: 2px; font-size: 11px; line-height: 16px; font-weight: 500; color: var(--ink-600); }
                    .ds-table td.rw-poin { font-family: var(--font-mono); font-size: 14px; font-weight: 800; white-space: nowrap; }
                    .ds-table td.rw-by { font-weight: 600; color: var(--ink-700) !important; }
                    .rw-table .ds-badge { font-size: 11px; padding: 3px 10px; box-shadow: var(--shadow-glass-sm); }
                    .rw-table .ds-badge i { font-size: 10px; }
                </style>

                @endif

    </div>
</main>

</x-app-layout>
