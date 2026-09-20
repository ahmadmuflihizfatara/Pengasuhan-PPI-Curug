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
                    <div class="relative z-10 max-w-xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-sky-200 mb-2">
                            <span>✦</span>
                            <span>{{ $greeting }}, {{ Auth::user()->role_label ?? 'User' }}</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-1.5 flex items-center gap-2">
                            <span>{{ Auth::user()->name }}</span>
                            <span class="text-xl">👋</span>
                        </h1>
                        <p class="text-xs sm:text-sm text-sky-100/80 leading-relaxed">
                            Pusat Komando Pengasuhan & Karakter Taruna PPI Curug — Semua data disiplin, apel, dan perizinan tersaji secara presisi.
                        </p>
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
                @if(Auth::user()->isTaruna())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="rounded-2xl bg-white/60 backdrop-blur-xl border border-white/70 p-5 shadow-lg flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-xl shadow-md flex-shrink-0">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Akun Taruna</div>
                                <div class="text-lg font-black text-slate-900 truncate">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-indigo-700 font-bold mt-0.5"><i class="fa-solid fa-id-badge mr-1"></i> {{ Auth::user()->jabatan ?? 'Taruna PPI Curug' }}</div>
                            </div>
                        </div>

                        <a href="{{ route('poin.index') }}" class="rounded-2xl bg-white/60 hover:bg-white/80 backdrop-blur-xl border border-white/70 p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 flex items-center justify-between gap-4 group no-underline">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-rose-500 text-white flex items-center justify-center text-xl shadow-md flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Raport Poin Saya</div>
                                    <div class="text-2xl font-black text-slate-900 font-mono tracking-tight" id="taruna-total-poin">
                                        {{ $totalPoin >= 0 ? '+' : '' }}{{ $totalPoin }}
                                    </div>
                                    <div class="text-xs text-emerald-600 font-bold mt-0.5">Buka Rincian Poin &rarr;</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-400 group-hover:text-slate-700 transition"></i>
                        </a>
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

                {{-- ── 3. WIDGET MONITORING POS JAGA (FLOW STATUS NODE) ── --}}
                @php
                    $activePergerakan = \App\Models\LogPergerakan::where('status', 'berangkat')->count();
                    $kembaliHariIni   = \App\Models\LogPergerakan::whereDate('waktu_berangkat', \Carbon\Carbon::today())->where('status', 'kembali')->count();
                @endphp
                @unless(Auth::user()->isTaruna())
                <div class="rounded-2xl bg-gradient-to-r from-slate-900/85 via-slate-800/85 to-indigo-950/85 backdrop-blur-xl border border-white/30 p-5 text-white mb-6 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 border border-blue-400/40 flex items-center justify-center text-xl text-blue-400 flex-shrink-0 shadow-inner">
                            <i class="fa-solid fa-person-walking"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Sistem Monitoring Pos Jaga Gerbang</div>
                            <div class="text-base sm:text-lg font-black text-white mt-0.5 flex flex-wrap items-center gap-2">
                                <span class="text-rose-400 font-extrabold flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                                    <span>{{ $activePergerakan }} Taruna</span>
                                </span>
                                <span class="text-xs font-semibold text-slate-300">di luar asrama</span>
                                <span class="text-xs font-bold text-emerald-400 bg-emerald-950/80 px-2.5 py-0.5 rounded-full border border-emerald-500/30">
                                    🟢 {{ $kembaliHariIni }} kembali hari ini
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
                        <a href="{{ route('log-pergerakan.tablet') }}" class="flex-1 md:flex-initial px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-2 no-underline">
                            <i class="fa-solid fa-tablet-screen-button"></i>
                            <span>Mode Tablet Pos Jaga</span>
                        </a>
                        <a href="{{ route('log-pergerakan.tv') }}" target="_blank" class="flex-1 md:flex-initial px-4 py-2 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-400/40 text-emerald-300 font-bold text-xs backdrop-blur-md transition flex items-center justify-center gap-2 no-underline">
                            <i class="fa-solid fa-tv"></i>
                            <span>TV Monitoring Jaga</span>
                        </a>
                    </div>
                </div>
                @endunless

                {{-- ── 4. ACARA PENGASUHAN MENDATANG ── --}}
                @if(!Auth::user()->isTaruna())
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
                    <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                        <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/30">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-envelope-open-text text-rose-500"></i>
                                <span>Surat Izin Terbaru</span>
                            </h3>
                            <a href="{{ route('surat.index') }}" class="text-xs font-bold text-indigo-700 hover:underline">Semua &rarr;</a>
                        </div>

                        @if($suratTerbaru->isEmpty())
                            <div class="text-center py-8 text-slate-400">
                                <i class="fa-solid fa-inbox text-2xl mb-1.5"></i>
                                <p class="text-xs font-medium">Belum ada riwayat surat diajukan.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-white/30">
                                            <th class="pb-2">Perihal</th>
                                            <th class="pb-2">Jenis</th>
                                            <th class="pb-2 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/30">
                                        @foreach($suratTerbaru as $s)
                                        <tr onclick="window.location='{{ route('surat.show', $s->id) }}'" class="hover:bg-white/60 cursor-pointer transition">
                                            <td class="py-2.5">
                                                <div class="font-bold text-slate-900 truncate max-w-[160px]">{{ $s->perihal }}</div>
                                                <div class="text-[10px] text-slate-500 truncate">{{ $s->pengirim }}</div>
                                            </td>
                                            <td class="py-2.5">
                                                <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-bold text-[10px] border border-indigo-100">
                                                    {{ Str::limit($s->jenis_surat, 14) }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 text-right">
                                                <span class="px-2 py-0.5 rounded-full font-bold text-[10px]" style="background:{{ $s->status_bg_color }};color:{{ $s->status_badge_color }};">
                                                    {{ $s->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    {{-- Jadwal Acara Table --}}
                    <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                        <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/30">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-days text-indigo-600"></i>
                                <span>Jadwal Pengasuhan</span>
                            </h3>
                            @unless(Auth::user()->isTaruna())
                            <a href="{{ route('acara.create') }}" class="text-xs font-bold text-indigo-700 hover:underline">+ Tambah</a>
                            @endunless
                        </div>

                        @if($semuaAcara->isEmpty())
                            <div class="text-center py-8 text-slate-400">
                                <i class="fa-solid fa-calendar-xmark text-2xl mb-1.5"></i>
                                <p class="text-xs font-medium">Belum ada agenda jadwal.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-white/30">
                                            <th class="pb-2">Nama Acara</th>
                                            <th class="pb-2">Tanggal</th>
                                            <th class="pb-2 text-right">Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/30">
                                        @foreach($semuaAcara->take(5) as $a)
                                        <tr class="hover:bg-white/60 transition">
                                            <td class="py-2.5">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0">
                                                        <i class="fa-solid fa-calendar-check"></i>
                                                    </div>
                                                    <span class="font-bold text-slate-900 truncate max-w-[150px]">{{ $a->nama_acara }}</span>
                                                </div>
                                            </td>
                                            <td class="py-2.5 text-slate-600 whitespace-nowrap text-[11px]">
                                                {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                                            </td>
                                            <td class="py-2.5 text-right">
                                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-800 font-mono font-bold text-[10px]">
                                                    {{ \Carbon\Carbon::parse($a->jam)->format('H:i') }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- ── 6. QUICK ACTION TILES ── --}}
                @if(!Auth::user()->isTaruna())
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

@if(Auth::user()->isTaruna())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const totalPoinEl = document.getElementById('taruna-total-poin');
        
        function pollPoints() {
            fetch("{{ route('api.myPoints') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const total = data.totalPoin;
                        if (totalPoinEl) {
                            totalPoinEl.textContent = (total >= 0 ? '+' : '') + total;
                        }
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
