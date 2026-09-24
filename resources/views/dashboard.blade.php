<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

{{-- Master Floating Spatial Workspace Canvas Window (rounded-3xl, backdrop-blur-2xl) --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- ── 1. GREETING BANNER GLASS COCKPIT ── --}}
                @php
                    $hour     = (int) now()->setTimezone('Asia/Jakarta')->format('H');
                    $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
                @endphp
                <div class="greeting-banner rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 sm:p-8 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    @php $isTaruna = Auth::user()->hasTarunaAccess(); @endphp
                    <div class="relative z-10 max-w-xl">
                        @unless($isTaruna)
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-sky-200 mb-2">
                            <span>✦</span>
                            <span>{{ $greeting }}, {{ Auth::user()->role_label ?? 'User' }}</span>
                        </div>
                        @endunless
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white {{ $isTaruna ? 'mb-0' : 'mb-1.5' }} flex items-center gap-2">
                            <span>{{ Auth::user()->name }}</span>
                            @unless($isTaruna)<span class="text-xl">👋</span>@endunless
                        </h1>
                        @if($isTaruna)
                        <p class="text-xs sm:text-sm text-sky-100/80 leading-relaxed mt-1.5">Selamat datang di sistem informasi pengasuhan</p>
                        @else
                        <p class="text-xs sm:text-sm text-sky-100/80 leading-relaxed">
                            Pusat Komando Pengasuhan & Karakter Taruna PPI Curug — Semua data disiplin, apel, dan perizinan tersaji secara presisi.
                        </p>
                        @endif
                    </div>

                    <div class="relative z-10 flex-shrink-0 flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3 sm:px-5 sm:py-3.5 shadow-inner">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black text-lg shadow-md">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white max-w-[140px] truncate">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] font-semibold text-amber-300">{{ Auth::user()->role_label }}</div>
                            <div class="text-[9px] text-slate-300 font-mono mt-0.5">ID: #{{ Auth::user()->id }}</div>
                        </div>
                    </div>

                    {{-- Ambient circular light overlays --}}
                    <div class="absolute -right-16 -top-16 w-56 h-56 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute right-32 -bottom-20 w-48 h-48 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                {{-- ── 2. STAT KPI CARDS ── --}}
                @if(Auth::user()->hasTarunaAccess())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="rounded-2xl bg-white/60 backdrop-blur-xl border border-white/70 p-5 shadow-lg flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-xl shadow-md flex-shrink-0">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Akun Taruna</div>
                                <div class="text-lg font-black text-slate-900 truncate">{{ Auth::user()->name }}</div>
                                @if($student)
                                <div class="text-xs text-indigo-700 font-bold mt-0.5"><i class="fa-solid fa-id-badge mr-1"></i> Taruna Program Studi {{ $student->prodi_nama }}</div>
                                <div class="flex flex-wrap gap-1.5 mt-1.5">
                                    <span class="ds-badge ds-badge--accent">Tingkat {{ $student->tingkat }}</span>
                                    @if($student->jenjang !== '-')<span class="ds-badge">{{ $student->jenjang }}</span>@endif
                                </div>
                                @else
                                <div class="text-xs text-indigo-700 font-bold mt-0.5"><i class="fa-solid fa-id-badge mr-1"></i> {{ Auth::user()->jabatan ?? 'Taruna PPI Curug' }}</div>
                                @endif
                            </div>
                        </div>

                        @if(Auth::user()->isPolisiTaruna())
                        <a href="{{ route('poin.index') }}" class="rounded-2xl bg-white/60 hover:bg-white/80 backdrop-blur-xl border border-white/70 p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 flex items-center justify-between gap-4 group no-underline">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-rose-500 text-white flex items-center justify-center text-xl shadow-md flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kelola Poin Taruna</div>
                                    <div class="text-sm font-bold text-slate-800 mt-1">Beri Pelanggaran</div>
                                    <div class="text-xs text-rose-600 font-bold mt-0.5">Cari &amp; Usulkan &rarr;</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-400 group-hover:text-slate-700 transition"></i>
                        </a>
                        @else
                        {{-- Raport poin: kiri pelanggaran, kanan penghargaan --}}
                        <a href="{{ route('poin.index') }}" class="ds-card ds-card--interactive poin-split" aria-label="Raport poin saya — buka rincian">
                            <div class="poin-split__half">
                                <span class="ds-stat__icon ds-stat__icon--danger"><i class="fa-solid fa-triangle-exclamation"></i></span>
                                <div>
                                    <div class="ds-stat__label">Poin Pelanggaran</div>
                                    <div class="poin-split__value" style="color:var(--danger-ink)" id="taruna-poin-pelanggaran">{{ (float) $poinTaruna['pelanggaran'] }}</div>
                                </div>
                            </div>
                            <div class="poin-split__half">
                                <span class="ds-stat__icon ds-stat__icon--success"><i class="fa-solid fa-trophy"></i></span>
                                <div>
                                    <div class="ds-stat__label">Poin Penghargaan</div>
                                    <div class="poin-split__value" style="color:var(--success-ink)" id="taruna-poin-penghargaan">+{{ (float) $poinTaruna['penghargaan'] }}</div>
                                </div>
                            </div>
                            <div class="poin-split__foot">Raport Poin Saya · Buka rincian <i class="fa-solid fa-arrow-right"></i></div>
                        </a>
                        <style>
                            .poin-split { display: grid; grid-template-columns: 1fr 1fr; padding: 0; overflow: hidden; text-decoration: none; }
                            .poin-split__half { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-5); min-width: 0; }
                            .poin-split__half + .poin-split__half { border-left: 1px solid var(--border-glass-glow); }
                            .poin-split__value { font-family: var(--font-mono); font-size: 28px; line-height: 32px; font-weight: 900; letter-spacing: -0.025em; margin-top: 2px; }
                            .poin-split__foot { grid-column: 1 / -1; padding: var(--space-2-5) var(--space-5); border-top: 1px solid var(--border-glass-glow); font-size: 11px; font-weight: 700; color: var(--accent-ink); display: flex; align-items: center; gap: var(--space-1-5); }
                            .poin-split .ds-stat__icon { flex-shrink: 0; }
                            @media (max-width: 480px) { .poin-split__half { flex-direction: column; align-items: flex-start; gap: var(--space-2); padding: var(--space-4); } }
                        </style>
                        @endif
                    </div>

                    @if($konsinyirAktif)
                    <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-rose-400/40 p-5 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl bg-rose-500/20 border border-rose-400/40 flex items-center justify-center text-xl text-rose-300 flex-shrink-0 shadow-inner">
                                <i class="fa-solid fa-user-lock"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-extrabold uppercase tracking-widest text-rose-200">Anda Sedang Menjalani Konsinyir</div>
                                <div class="text-sm sm:text-base font-black text-white mt-0.5">
                                    {{ $konsinyirAktif->tanggal_mulai->locale('id')->isoFormat('D MMM Y') }} &rarr; {{ $konsinyirAktif->tanggal_selesai->locale('id')->isoFormat('D MMM Y') }}
                                    <span class="text-xs font-bold text-amber-300 bg-amber-950/60 px-2 py-0.5 rounded-full border border-amber-500/30 ml-1">{{ $konsinyirAktif->lama_hari }} hari</span>
                                </div>
                                @if($konsinyirAktif->keterangan)
                                <div class="text-xs text-rose-100/80 mt-1">{{ $konsinyirAktif->keterangan }}</div>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('konsinyir.index') }}" class="relative z-10 flex-shrink-0 px-4 py-2 rounded-xl bg-white/90 hover:bg-white text-slate-900 font-extrabold text-xs shadow-md transition flex items-center gap-2 no-underline">
                            <i class="fa-solid fa-list-check"></i>
                            <span>Lihat Detail</span>
                        </a>
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    </div>
                    @endif

                    <div class="mb-6">
                        <x-rekap-nilai-taruna :nilai="$nilaiSemester" />
                    </div>

                    <div class="mb-6">
                        <x-prodi-tingkat-chart :chart-data="$chartData" />
                    </div>

                @else
                    {{-- Pengasuh & Admin KPI Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-6">
                        
                        <x-stat-card 
                            title="Total Taruna"
                            :value="$totalMahasiswa"
                            icon="fa-solid fa-user-graduate"
                            gradient="from-blue-600 to-indigo-600"
                            badge="Aktif"
                            badgeType="info"
                            description="Semua angkatan" />

                        <x-stat-card 
                            title="Total Acara"
                            :value="$semuaAcara->count()"
                            icon="fa-solid fa-calendar-days"
                            gradient="from-emerald-500 to-teal-600"
                            :badge="$acaraMendatang->count() . ' Mendatang'"
                            badgeType="success"
                            :href="route('acara.index')"
                            description="Agenda pengasuhan" />

                        <x-stat-card 
                            title="Total Surat"
                            :value="$suratStats['total']"
                            icon="fa-solid fa-envelope-open-text"
                            gradient="from-purple-500 to-indigo-600"
                            :badge="$suratStats['diproses'] . ' Diproses'"
                            badgeType="warning"
                            :href="route('surat.index')"
                            description="Pengajuan izin" />

                        <x-stat-card 
                            title="Surat Selesai"
                            :value="$suratStats['selesai']"
                            icon="fa-solid fa-circle-check"
                            gradient="from-sky-500 to-blue-600"
                            badge="Disetujui"
                            badgeType="success"
                            :href="route('surat.index')"
                            description="Surat disetujui" />

                        <x-stat-card 
                            title="Keluhan Barak"
                            :value="$keluhanStats['total']"
                            icon="fa-solid fa-door-open"
                            gradient="from-rose-500 to-pink-600"
                            :badge="$keluhanStats['diajukan'] . ' Baru'"
                            badgeType="danger"
                            :href="route('keluhan-barak.kelola')"
                            description="Fasilitas barak" />

                    </div>
                @endif

                {{-- ── 3. MONITORING TV ── --}}
                @unless(Auth::user()->hasTarunaAccess())
                <a href="{{ route('monitoring-tv.index') }}" target="_blank" class="rounded-2xl bg-white/70 hover:bg-white/90 backdrop-blur-xl border border-white/70 p-5 mb-6 shadow-lg transition-all duration-300 hover:-translate-y-1 flex items-center justify-between gap-4 group no-underline">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 text-white flex items-center justify-center text-xl shadow-md flex-shrink-0">
                            <i class="fa-solid fa-tv"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Monitoring TV</div>
                            <div class="text-sm font-bold text-slate-900">Dinas &amp; Izin Keluar · Taruna Sakit · Log Book · Galeri Dokumentasi</div>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-indigo-700 flex items-center gap-1.5 flex-shrink-0">Buka Layar <i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                </a>
                @endunless

                {{-- ── 4. ACARA PENGASUHAN MENDATANG ── --}}
                @if(!Auth::user()->hasTarunaAccess())
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3.5">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-star text-indigo-600"></i>
                            <span>Acara Pengasuhan Mendatang</span>
                        </h3>
                        <a href="{{ route('acara.index') }}" class="text-xs font-bold text-indigo-700 hover:underline">Kelola Acara &rarr;</a>
                    </div>

                    @if($acaraMendatang->isEmpty())
                        <div class="rounded-2xl bg-white/40 backdrop-blur-md border border-white/50 p-6 text-center shadow-sm">
                            <i class="fa-solid fa-calendar-xmark text-3xl text-slate-400 mb-2"></i>
                            <p class="text-xs font-semibold text-slate-600 mb-2">Belum ada agenda acara pengasuhan mendatang.</p>
                            <a href="{{ route('acara.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-sm hover:bg-indigo-700 transition">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                                <span>Tambah Acara Baru</span>
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $acara_colors = [
                                    ['from-indigo-600 to-purple-600', 'text-indigo-600'],
                                    ['from-rose-500 to-pink-600', 'text-rose-600'],
                                    ['from-emerald-500 to-teal-600', 'text-emerald-600'],
                                    ['from-sky-500 to-blue-600', 'text-sky-600'],
                                ];
                                $ci = 0;
                            @endphp
                            @foreach($acaraMendatang as $event)
                            @php 
                                $col = $acara_colors[$ci % count($acara_colors)]; 
                                $ci++; 
                            @endphp
                            <div class="rounded-2xl bg-white/55 hover:bg-white/75 backdrop-blur-xl border border-white/60 overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col">
                                <div class="h-20 bg-gradient-to-r {{ $col[0] }} p-3.5 relative flex items-center justify-between text-white">
                                    <i class="fa-solid fa-calendar-check text-2xl opacity-60"></i>
                                    <span class="px-2.5 py-0.5 rounded-full bg-black/30 backdrop-blur-md text-[10px] font-bold tracking-wider">
                                        <i class="fa-solid fa-clock text-[9px] mr-1"></i>
                                        {{ \Carbon\Carbon::parse($event->jam)->format('H:i') }} WIB
                                    </span>
                                </div>
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider {{ $col[1] }} mb-1">
                                            {{ \Carbon\Carbon::parse($event->tanggal)->locale('id')->isoFormat('D MMMM Y') }}
                                        </div>
                                        <h4 class="text-xs font-bold text-slate-900 leading-snug mb-1">{{ $event->nama_acara }}</h4>
                                        @if($event->keterangan)
                                            <p class="text-[11px] text-slate-600 line-clamp-2">{{ $event->keterangan }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endif

                {{-- ── 5. TWO COLUMN GLASS TABLES: SURAT TERBARU & JADWAL ── --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
                    
                    {{-- Surat Terbaru Table --}}
                    @php
                        $isTarunaDash = Auth::user()->hasTarunaAccess();
                        $suratShow = $isTarunaDash ? 'surat-taruna.show' : 'surat.show';
                    @endphp
                    <div class="ds-card">
                        <div class="ds-card__head" style="display:flex; align-items:center; justify-content:space-between; gap:var(--space-3);">
                            <div>
                                <h3 class="ds-card__title"><i class="fa-solid fa-envelope-open-text ds-icon"></i> Surat Izin Terbaru</h3>
                                <p class="ds-card__desc">{{ $isTarunaDash ? 'Surat yang diajukan akun ini beserta statusnya' : 'Lima pengajuan surat terakhir beserta statusnya' }}</p>
                            </div>
                            <a href="{{ route($isTarunaDash ? 'surat-taruna.index' : 'surat.index') }}" class="ds-btn ds-btn--sm ds-btn--pill">Semua <i class="fa-solid fa-arrow-right ds-icon"></i></a>
                        </div>

                        @if($suratTerbaru->isEmpty())
                            <div class="ds-empty">
                                <i class="fa-solid fa-inbox ds-icon"></i>
                                Belum ada riwayat surat diajukan.
                            </div>
                        @else
                            <div class="ds-table-wrap">
                                <div class="ds-scroll dsh-scroll">
                                    <table class="ds-table">
                                        <thead>
                                            <tr>
                                                <th>Perihal</th>
                                                <th data-filter>Jenis</th>
                                                <th class="ds-right" data-filter>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($suratTerbaru as $s)
                                            @php
                                                $statusVarian = match ($s->status) {
                                                    'Diproses' => 'warning', 'Disetujui' => 'success',
                                                    'Ditolak' => 'danger', 'Selesai' => 'accent', default => null,
                                                };
                                            @endphp
                                            <tr onclick="window.location='{{ route($suratShow, $s->id) }}'" style="cursor:pointer;">
                                                <td>
                                                    <a href="{{ route($suratShow, $s->id) }}" class="dsh-link">{{ $s->perihal }}</a>
                                                    <div class="dsh-sub">{{ $s->pengirim }}</div>
                                                </td>
                                                <td><span class="ds-badge ds-badge--accent">{{ $s->jenis_surat }}</span></td>
                                                <td class="ds-right"><span class="ds-badge {{ $statusVarian ? 'ds-badge--'.$statusVarian : '' }}">{{ $s->status }}</span></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Jadwal Acara Table --}}
                    <div class="ds-card">
                        <div class="ds-card__head" style="display:flex; align-items:center; justify-content:space-between; gap:var(--space-3);">
                            <div>
                                <h3 class="ds-card__title"><i class="fa-solid fa-calendar-days ds-icon"></i> Jadwal Pengasuhan</h3>
                                <p class="ds-card__desc">Seluruh agenda pengasuhan, urut berdasarkan tanggal</p>
                            </div>
                            @unless(Auth::user()->hasTarunaAccess())
                            <a href="{{ route('acara.create') }}" class="ds-btn ds-btn--sm ds-btn--pill"><i class="fa-solid fa-plus ds-icon"></i> Tambah</a>
                            @endunless
                        </div>

                        @if($semuaAcara->isEmpty())
                            <div class="ds-empty">
                                <i class="fa-solid fa-calendar-xmark ds-icon"></i>
                                Belum ada agenda jadwal.
                            </div>
                        @else
                            <div class="ds-table-wrap">
                                <div class="ds-scroll dsh-scroll">
                                    <table class="ds-table">
                                        <thead>
                                            <tr>
                                                <th>Nama Acara</th>
                                                <th>Tanggal</th>
                                                <th data-no-filter>Waktu</th>
                                                <th class="ds-right" data-filter>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($semuaAcara as $a)
                                            @php
                                                $tglAcara = \Carbon\Carbon::parse($a->tanggal);
                                                [$statusAcara, $varianAcara] = $tglAcara->isToday() ? ['Hari ini', 'success']
                                                    : ($tglAcara->isFuture() ? ['Mendatang', 'accent'] : ['Selesai', null]);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="ds-cell-person">
                                                        <span class="ds-avatar ds-avatar--sq"><i class="fa-solid fa-calendar-check"></i></span>
                                                        <span class="ds-name">{{ $a->nama_acara }}</span>
                                                    </div>
                                                </td>
                                                <td class="dsh-date" data-sort="{{ $tglAcara->format('Y-m-d') }}">{{ $tglAcara->locale('id')->isoFormat('D MMM Y') }}</td>
                                                <td><span class="ds-badge dsh-time">{{ \Carbon\Carbon::parse($a->jam)->format('H:i') }}</span></td>
                                                <td class="ds-right"><span class="ds-badge {{ $varianAcara ? 'ds-badge--'.$varianAcara : '' }}">{{ $statusAcara }}</span></td>
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
                    .dsh-link { font-size: 13px; font-weight: 700; color: var(--ink-900); text-decoration: none; }
                    .dsh-link:hover { color: var(--accent-ink); text-decoration: underline; }
                    .dsh-sub { margin-top: 2px; font-size: 11px; font-weight: 500; color: var(--ink-600); }
                    .ds-table td.dsh-date { white-space: nowrap; font-weight: 600; color: var(--ink-700) !important; }
                    .dsh-time { font-family: var(--font-mono); font-size: 11px; color: var(--ink-900); }
                    .ds-table .ds-name { font-size: 13px; }
                    .ds-table .ds-badge { font-size: 11px; padding: 3px 10px; box-shadow: var(--shadow-glass-sm); }
                    .dsh-scroll { max-height: 340px; overflow-y: auto; }
                    .dsh-scroll thead th { position: sticky; top: 0; z-index: 1; background: var(--glass-solid) !important; }
                </style>

                {{-- ── 6. QUICK ACTION TILES ── --}}
                @if(!Auth::user()->hasTarunaAccess())
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-amber-500"></i>
                        <span>Aksi Cepat Pengasuhan</span>
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
                        
                        <a href="{{ route('surat.create') }}" class="rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 p-4 text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl flex items-center gap-3 no-underline">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-file-circle-plus"></i>
                            </div>
                            <div>
                                <div class="text-[9px] uppercase tracking-wider opacity-80">Buat</div>
                                <div class="text-xs font-bold">Surat Baru</div>
                            </div>
                        </a>

                        <a href="{{ route('acara.create') }}" class="rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 p-4 text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl flex items-center gap-3 no-underline">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-calendar-plus"></i>
                            </div>
                            <div>
                                <div class="text-[9px] uppercase tracking-wider opacity-80">Tambah</div>
                                <div class="text-xs font-bold">Agenda Acara</div>
                            </div>
                        </a>

                        <a href="{{ route('poin.index') }}" class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-4 text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl flex items-center gap-3 no-underline">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <div class="text-[9px] uppercase tracking-wider opacity-80">Kelola</div>
                                <div class="text-xs font-bold">Poin Taruna</div>
                            </div>
                        </a>

                        <a href="{{ route('mahasiswa.index') }}" class="rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 p-4 text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl flex items-center gap-3 no-underline">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <div class="text-[9px] uppercase tracking-wider opacity-80">Database</div>
                                <div class="text-xs font-bold">Taruna</div>
                            </div>
                        </a>

                    </div>
                </div>
                @endif


    </div>
</main>

@if(Auth::user()->hasTarunaAccess())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const pelanggaranEl = document.getElementById('taruna-poin-pelanggaran');
        const penghargaanEl = document.getElementById('taruna-poin-penghargaan');
        if (!pelanggaranEl) return; // Polisi Taruna: kartu tanpa angka
        
        function pollPoints() {
            fetch("{{ route('api.myPoints') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        pelanggaranEl.textContent = Number(data.totalPelanggaran) || 0;
                        penghargaanEl.textContent = '+' + (Number(data.totalPenghargaan) || 0);
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
