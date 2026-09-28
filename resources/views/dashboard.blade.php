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
                    $isTaruna = Auth::user()->hasTarunaAccess();
                @endphp
                {{-- Header — warna mengikuti tab (x-page-banner) --}}
                <x-page-banner :title="$isTaruna ? Auth::user()->name : $greeting . ', ' . Auth::user()->name" icon="fa-house-chimney"
                    :subtitle="$isTaruna ? 'Selamat datang di sistem informasi pengasuhan' : 'Pusat Komando Pengasuhan & Karakter Taruna PPI Curug — data disiplin, apel, dan perizinan dalam satu tempat'" />

                {{-- ── 1b. PEMBERITAHUAN TUGAS TARUNA (duty / kasi internal / polisi taruna) ── --}}
                @php
                    $u = Auth::user();
                    $tugasSaya = [];
                    if ($u->isDutyTaruna()) {
                        $tugasSaya[] = [
                            'label' => 'Duty Taruna', 'ikon' => 'fa-user-clock', 'warna' => '#059669',
                            'ket'   => 'Bertugas duty minggu ini (' . \App\Models\DutyTaruna::labelPeriode(\App\Models\DutyTaruna::awalMinggu()) . '). Laporkan taruna sakit melalui laporan duty.',
                            'url'   => route('laporan-duty.index'), 'aksi' => 'Buka Laporan Duty',
                        ];
                    }
                    if ($u->isKasiInternal()) {
                        $tugasSaya[] = \App\Models\User::DAFTAR_AKSES[\App\Models\User::AKSES_KASI_INTERNAL] + ['url' => route('duty.index'), 'aksi' => 'Atur Jadwal Duty'];
                    }
                    if ($u->isPolisiTaruna()) {
                        $tugasSaya[] = \App\Models\User::DAFTAR_AKSES[\App\Models\User::AKSES_POLISI_TARUNA] + ['url' => route('poin.index'), 'aksi' => 'Beri Pelanggaran'];
                    }
                @endphp
                @if($tugasSaya)
                <div class="ds-card mb-6">
                    <div class="ds-card__head">
                        <h3 class="ds-card__title"><i class="fa-solid fa-bell ds-icon"></i> Pemberitahuan Tugas</h3>
                        <p class="ds-card__desc">Anda sedang mengemban {{ count($tugasSaya) }} tugas khusus</p>
                    </div>
                    <div class="tugas-grid">
                        @foreach($tugasSaya as $t)
                        <a href="{{ $t['url'] }}" class="tugas-item">
                            <span class="tugas-item__ikon" style="background:linear-gradient(135deg,{{ $t['warna'] }},var(--accent));"><i class="fa-solid {{ $t['ikon'] }}"></i></span>
                            <span class="tugas-item__isi">
                                <span class="tugas-item__label">Anda bertugas sebagai {{ $t['label'] }}</span>
                                <span class="tugas-item__ket">{{ $t['ket'] }}</span>
                                <span class="tugas-item__aksi">{{ $t['aksi'] }} <i class="fa-solid fa-arrow-right"></i></span>
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>
                <style>
                    .tugas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-3); }
                    .tugas-item {
                        display: flex; align-items: flex-start; gap: var(--space-3); text-decoration: none;
                        background: var(--glass-card); border: 1px solid var(--border-glass-glow);
                        border-radius: var(--radius-md); padding: var(--space-3-5) var(--space-4);
                        transition: background-color .15s, transform .15s;
                    }
                    .tugas-item:hover { background: var(--glass-solid); transform: translateY(-2px); }
                    .tugas-item__ikon {
                        width: 40px; height: 40px; border-radius: var(--radius-md); flex-shrink: 0;
                        display: grid; place-items: center; font-size: 16px; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm);
                    }
                    .tugas-item__isi { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
                    .tugas-item__label { font-size: 13px; font-weight: 800; color: var(--ink-900); }
                    .tugas-item__ket { font-size: 11px; line-height: 15px; font-weight: 500; color: var(--ink-600); }
                    .tugas-item__aksi { margin-top: var(--space-1); font-size: 11px; font-weight: 700; color: var(--accent-ink); display: inline-flex; align-items: center; gap: var(--space-1-5); }
                </style>
                @endif

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
                    {{-- Pengasuh & Admin KPI Grid — kartu .ds-stat --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-4">
                        <x-stat-card title="Total Taruna" :value="$totalMahasiswa" icon="fa-solid fa-user-graduate"
                            varian="accent" badge="Aktif" badgeType="info" :href="$adminStats ? route('mahasiswa.index') : null" description="Semua angkatan" />
                        <x-stat-card title="Total Acara" :value="$semuaAcara->count()" icon="fa-solid fa-calendar-days"
                            varian="success" :badge="$acaraMendatang->count() . ' mendatang'" badgeType="success" :href="route('acara.index')" description="Agenda pengasuhan" />
                        <x-stat-card title="Total Surat" :value="$suratStats['total']" icon="fa-solid fa-envelope-open-text"
                            varian="info" :badge="$suratStats['diproses'] . ' diproses'" badgeType="warning" :href="route('surat.index')" description="Pengajuan izin" />
                        <x-stat-card title="Surat Selesai" :value="$suratStats['selesai']" icon="fa-solid fa-circle-check"
                            varian="success" badge="Selesai" badgeType="success" :href="route('surat.index')" description="Surat yang sudah tuntas" />
                        <x-stat-card title="Keluhan Barak" :value="$keluhanStats['total']" icon="fa-solid fa-door-open"
                            varian="danger" :badge="$keluhanStats['diajukan'] . ' baru'" badgeType="danger" :href="route('keluhan-barak.kelola')" description="Fasilitas barak" />
                    </div>
                @endif

                {{-- ── 2b. PANEL ADMINISTRASI (hanya admin) ── --}}
                @if($adminStats)
                <div class="ds-card mb-4">
                    <div class="ds-card__head tbl-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-user-shield ds-icon"></i> Panel Administrasi</h3>
                            <p class="ds-card__desc">Validasi, pengguna, hak akses, dan pengaturan sistem — khusus Admin Pusbangkar</p>
                        </div>
                        <span class="ds-badge ds-badge--dark"><i class="fa-solid fa-lock"></i> Admin</span>
                    </div>

                    {{-- Poin menunggu validasi --}}
                    <a href="{{ route('poin.index') }}" class="dsh-validasi {{ $adminStats['poinMenunggu'] ? 'dsh-validasi--ada' : '' }}">
                        <span class="ds-stat__icon {{ $adminStats['poinMenunggu'] ? 'ds-stat__icon--warning' : 'ds-stat__icon--success' }}"><i class="fa-solid {{ $adminStats['poinMenunggu'] ? 'fa-clipboard-check' : 'fa-circle-check' }}"></i></span>
                        <span class="dsh-validasi__isi">
                            <span class="ds-stat__label">Usulan Poin Menunggu Validasi</span>
                            <span class="dsh-validasi__nilai">{{ $adminStats['poinMenunggu'] }} <small>{{ $adminStats['poinMenunggu'] ? 'usulan perlu ditinjau' : 'semua usulan sudah divalidasi' }}</small></span>
                        </span>
                        <span class="ds-btn ds-btn--sm ds-btn--pill {{ $adminStats['poinMenunggu'] ? 'ds-btn--primary' : '' }}">{{ $adminStats['poinMenunggu'] ? 'Validasi Sekarang' : 'Buka Poin' }} <i class="fa-solid fa-arrow-right"></i></span>
                    </a>

                    <div class="dsh-aksi dsh-aksi--admin">
                        @foreach([
                            [route('users.index'),         'fa-users-gear',    'accent',  'Kelola',   'Pengguna',          $adminStats['totalAkun'] . ' akun'],
                            [route('akses.index'),         'fa-key',           'warning', 'Atur',     'Akses Fitur',       null],
                            [route('akses-khusus.index'),  'fa-id-card-clip',  'info',    'Beri',     'Akses Khusus',      null],
                            [route('jadwal.alokasi'),      'fa-calendar-week', 'success', 'Atur',     'Alokasi Pengasuh',  null],
                            [route('activity-log.index'),  'fa-clock-rotate-left', 'danger', 'Pantau', 'Log Aktivitas',   $adminStats['aktivitasHariIni'] . ' hari ini'],
                            [route('setting.index'),       'fa-gear',          'accent',  'Atur',     'Setting Sistem',    null],
                        ] as [$url, $ikon, $varian, $kecil, $label, $info])
                        <a href="{{ $url }}" class="dsh-aksi__item">
                            <span class="ds-stat__icon {{ $varian !== 'accent' ? 'ds-stat__icon--'.$varian : '' }}"><i class="fa-solid {{ $ikon }}"></i></span>
                            <span>
                                <span class="dsh-aksi__kecil">{{ $kecil }}{{ $info ? ' · '.$info : '' }}</span>
                                <span class="dsh-aksi__label">{{ $label }}</span>
                            </span>
                            <i class="fa-solid fa-chevron-right dsh-aksi__panah"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
                <style>
                    .dsh-validasi { display: flex; align-items: center; gap: var(--space-3-5); margin-bottom: var(--space-3); padding: var(--space-3-5) var(--space-4); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); color: inherit; text-decoration: none; transition: background-color .15s, box-shadow .15s; }
                    .dsh-validasi:hover { background: var(--glass-solid); box-shadow: var(--shadow-glass-sm); color: inherit; }
                    .dsh-validasi:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
                    .dsh-validasi--ada { border-color: var(--warning-border); background: var(--warning-tint); }
                    .dsh-validasi .ds-stat__icon { flex-shrink: 0; width: 44px; height: 44px; font-size: 17px; }
                    .dsh-validasi__isi { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
                    .dsh-validasi__nilai { font-family: var(--font-mono); font-size: 22px; line-height: 26px; font-weight: 900; color: var(--ink-900); }
                    .dsh-validasi__nilai small { font-family: var(--font-sans); font-size: 12px; font-weight: 600; color: var(--ink-700); margin-left: var(--space-1); }
                    .dsh-validasi .ds-btn { flex-shrink: 0; }
                    /* 6 pintasan: 3 kolom rata (2 baris) agar tidak ada ubin menggantung */
                    .dsh-aksi.dsh-aksi--admin { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                    @media (max-width: 900px) { .dsh-aksi.dsh-aksi--admin { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
                    @media (max-width: 480px) { .dsh-aksi.dsh-aksi--admin { grid-template-columns: 1fr; } }
                    @media (max-width: 640px) { .dsh-validasi { flex-wrap: wrap; } .dsh-validasi .ds-btn { width: 100%; justify-content: center; } }
                </style>
                @endif

                {{-- ── 3. MONITORING TV ── --}}
                @unless(Auth::user()->hasTarunaAccess())
                <a href="{{ route('monitoring-tv.index') }}" target="_blank" rel="noopener" class="ds-card ds-card--interactive dsh-tv mb-4">
                    <span class="ds-stat__icon"><i class="fa-solid fa-tv"></i></span>
                    <span class="dsh-tv__isi">
                        <span class="ds-stat__label">Monitoring TV</span>
                        <span class="dsh-tv__judul">Dinas &amp; Izin Keluar · Taruna Sakit · Log Book · Galeri Dokumentasi</span>
                    </span>
                    <span class="ds-btn ds-btn--sm ds-btn--pill dsh-tv__aksi">Buka Layar <i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                </a>
                @endunless

                {{-- ── 4. ACARA PENGASUHAN MENDATANG ── --}}
                @if(!Auth::user()->hasTarunaAccess())
                <div class="ds-card mb-4">
                    <div class="ds-card__head tbl-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-calendar-check ds-icon"></i> Acara Pengasuhan Mendatang</h3>
                            <p class="ds-card__desc">Agenda mulai hari ini, urut dari yang terdekat — klik untuk melihat agenda hari itu</p>
                        </div>
                        <a href="{{ route('acara.index') }}" class="ds-btn ds-btn--sm ds-btn--pill">Kelola Acara <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    @if($acaraMendatang->isEmpty())
                    <div class="ds-empty">
                        <i class="fa-solid fa-calendar-xmark ds-icon"></i>
                        Belum ada agenda acara pengasuhan mendatang.
                        <div class="mt-3"><a href="{{ route('acara.create') }}" class="ds-btn ds-btn--primary ds-btn--sm"><i class="fa-solid fa-plus"></i> Tambah Acara Baru</a></div>
                    </div>
                    @else
                    <div class="dsh-acara">
                        @foreach($acaraMendatang->take(6) as $event)
                        @php $tglEvent = \Carbon\Carbon::parse($event->tanggal); @endphp
                        <a href="{{ route('acara.tanggal', $tglEvent->format('Y-m-d')) }}" class="dsh-acara__item">
                            <span class="dsh-acara__tgl {{ $tglEvent->isToday() ? 'dsh-acara__tgl--hariini' : '' }}">
                                <b>{{ $tglEvent->format('d') }}</b>
                                <small>{{ $tglEvent->locale('id')->isoFormat('MMM') }}</small>
                            </span>
                            <span class="dsh-acara__isi">
                                <span class="dsh-acara__nama">{{ $event->nama_acara }}</span>
                                <span class="dsh-acara__meta">{{ $tglEvent->isToday() ? 'Hari ini' : $tglEvent->locale('id')->isoFormat('dddd') }}{{ $event->jam ? ' · ' . \Carbon\Carbon::parse($event->jam)->format('H:i') . ' WIB' : '' }}</span>
                                @if($event->keterangan)<span class="dsh-acara__ket">{{ $event->keterangan }}</span>@endif
                            </span>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

                {{-- ── 5. TWO COLUMN GLASS TABLES: SURAT TERBARU & JADWAL ── --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                    
                    {{-- Surat Terbaru Table --}}
                    @php
                        $isTarunaDash = Auth::user()->hasTarunaAccess();
                        $suratShow = $isTarunaDash ? 'surat-taruna.show' : 'surat.show';
                    @endphp
                    <div class="ds-card">
                        <div class="ds-card__head tbl-head">
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
                        <div class="ds-card__head tbl-head">
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

                {{-- ── 6. AKSI CEPAT ── --}}
                @if(!Auth::user()->hasTarunaAccess())
                <div class="ds-card">
                    <div class="ds-card__head">
                        <h3 class="ds-card__title"><i class="fa-solid fa-bolt ds-icon"></i> Aksi Cepat Pengasuhan</h3>
                        <p class="ds-card__desc">Pintasan ke tugas yang paling sering dipakai</p>
                    </div>
                    <div class="dsh-aksi">
                        @foreach([
                            [route('surat.create'),    'fa-file-circle-plus', 'danger',  'Buat',     'Surat Baru'],
                            [route('acara.create'),    'fa-calendar-plus',    '',        'Tambah',   'Agenda Acara'],
                            [route('poin.index'),      'fa-star',             'success', 'Kelola',   'Poin Taruna'],
                            // Database taruna hanya bisa dibuka admin (route role:admin)
                            $adminStats
                                ? [route('mahasiswa.index'), 'fa-users', 'info', 'Database', 'Taruna']
                                : [route('keluhan-barak.kelola'), 'fa-door-open', 'info', 'Kelola', 'Keluhan Barak'],
                        ] as [$url, $ikon, $varian, $kecil, $label])
                        <a href="{{ $url }}" class="dsh-aksi__item">
                            <span class="ds-stat__icon {{ $varian ? 'ds-stat__icon--'.$varian : '' }}"><i class="fa-solid {{ $ikon }}"></i></span>
                            <span>
                                <span class="dsh-aksi__kecil">{{ $kecil }}</span>
                                <span class="dsh-aksi__label">{{ $label }}</span>
                            </span>
                            <i class="fa-solid fa-chevron-right dsh-aksi__panah"></i>
                        </a>
                        @endforeach
                    </div>
                </div>

                <style>
                    /* Monitoring TV */
                    .dsh-tv { display: flex; align-items: center; gap: var(--space-3-5); text-decoration: none; color: inherit; }
                    .dsh-tv:hover { color: inherit; }
                    .dsh-tv .ds-stat__icon { flex-shrink: 0; width: 44px; height: 44px; font-size: 17px; }
                    .dsh-tv__isi { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
                    .dsh-tv__judul { font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
                    .dsh-tv__aksi { flex-shrink: 0; }
                    @media (max-width: 640px) { .dsh-tv { flex-wrap: wrap; } .dsh-tv__aksi { width: 100%; justify-content: center; } }

                    /* Acara mendatang */
                    .dsh-acara { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: var(--space-3); }
                    .dsh-acara__item { display: flex; align-items: flex-start; gap: var(--space-3); padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); color: inherit; text-decoration: none; transition: background-color .15s, box-shadow .15s, transform .15s; }
                    .dsh-acara__item:hover { background: var(--glass-solid); box-shadow: var(--shadow-glass-sm); transform: translateY(-2px); color: inherit; }
                    .dsh-acara__item:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
                    .dsh-acara__tgl { width: 46px; flex-shrink: 0; padding: var(--space-1-5) 0; border-radius: var(--radius-sm); text-align: center; background: var(--accent-tint); color: var(--accent-ink); }
                    .dsh-acara__tgl--hariini { background: var(--accent); color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
                    .dsh-acara__tgl b { display: block; font-family: var(--font-mono); font-size: 18px; line-height: 22px; font-weight: 900; }
                    .dsh-acara__tgl small { display: block; font-size: 9px; line-height: 12px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; }
                    .dsh-acara__isi { min-width: 0; display: flex; flex-direction: column; gap: 2px; }
                    .dsh-acara__nama { font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
                    .dsh-acara__meta { font-size: 11px; line-height: 16px; font-weight: 700; color: var(--accent-ink); }
                    .dsh-acara__ket { font-size: 11px; line-height: 16px; font-weight: 500; color: var(--ink-600); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

                    /* Aksi cepat */
                    .dsh-aksi { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: var(--space-3); }
                    .dsh-aksi__item { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); color: inherit; text-decoration: none; transition: background-color .15s, box-shadow .15s, transform .15s; }
                    .dsh-aksi__item:hover { background: var(--glass-solid); box-shadow: var(--shadow-glass-sm); transform: translateY(-2px); color: inherit; }
                    .dsh-aksi__item:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
                    .dsh-aksi__item .ds-stat__icon { flex-shrink: 0; }
                    .dsh-aksi__kecil { display: block; font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
                    .dsh-aksi__label { display: block; font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
                    .dsh-aksi__panah { margin-left: auto; font-size: 11px; color: var(--ink-400); transition: transform .15s; }
                    .dsh-aksi__item:hover .dsh-aksi__panah { transform: translateX(3px); color: var(--accent-ink); }
                </style>
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
