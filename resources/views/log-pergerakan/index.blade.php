<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Alerts --}}
                @if(session('success'))
                <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center justify-between shadow-sm backdrop-blur-md">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-base text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                {{-- Page Header Glass Banner --}}
                <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-sky-200 mb-2">
                            <span>✦</span>
                            <span>Sistem Pos Jaga &amp; Pergerakan</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-person-walking text-sky-400"></i>
                            <span>Log Pergerakan Taruna</span>
                        </h1>
                        <p class="text-xs text-sky-100/80">Manajemen &amp; Rekapitulasi Data Keberangkatan, Perizinan, Ekstrakurikuler, dan Olahraga</p>
                    </div>

                    <div class="relative z-10 flex flex-wrap items-center gap-2">
                        <a href="{{ route('log-pergerakan.tablet') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-xs shadow-md transition flex items-center gap-2 no-underline">
                            <i class="fa-solid fa-tablet-screen-button text-indigo-600"></i>
                            <span>Mode Tablet Pos Jaga</span>
                        </a>
                        <a href="{{ route('log-pergerakan.tv') }}" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-400/40 text-emerald-300 font-bold text-xs backdrop-blur-md transition flex items-center gap-2 no-underline">
                            <i class="fa-solid fa-tv"></i>
                            <span>TV Monitoring</span>
                        </a>
                    </div>

                    {{-- Ambient glow --}}
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                {{-- Top Stats Row --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 mb-5">
                    
                    <div class="rounded-2xl bg-rose-50/70 backdrop-blur-xl border border-rose-200/80 p-4 shadow-md">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-rose-800 flex items-center gap-1.5 mb-1">
                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                            <span>Belum Kembali (Di Luar)</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-rose-700 font-mono tracking-tight">{{ $stats['belum_kembali'] }}</div>
                        <div class="text-[10px] text-rose-900/70 font-semibold mt-1">Taruna aktif di luar kampus</div>
                    </div>

                    <div class="rounded-2xl bg-emerald-50/70 backdrop-blur-xl border border-emerald-200/80 p-4 shadow-md">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 mb-1">
                            <span>🟢 Sudah Kembali Hari Ini</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-emerald-700 font-mono tracking-tight">{{ $stats['sudah_kembali'] }}</div>
                        <div class="text-[10px] text-emerald-900/70 font-semibold mt-1">Check-in sukses di pos jaga</div>
                    </div>

                    <div class="rounded-2xl bg-indigo-50/70 backdrop-blur-xl border border-indigo-200/80 p-4 shadow-md">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-indigo-800 mb-1">
                            <span>Total Log Hari Ini</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-indigo-700 font-mono tracking-tight">{{ $stats['total_today'] }}</div>
                        <div class="text-[10px] text-indigo-900/70 font-semibold mt-1">Aktivitas gerbang tercatat</div>
                    </div>

                    <div class="rounded-2xl bg-sky-50/70 backdrop-blur-xl border border-sky-200/80 p-4 shadow-md">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-sky-800 mb-1">
                            <span>Ekskul &amp; Olahraga</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-sky-700 font-mono tracking-tight">{{ $stats['ekskul'] + $stats['olahraga'] }}</div>
                        <div class="text-[10px] text-sky-900/70 font-semibold mt-1">Kegiatan luar asrama</div>
                    </div>

                </div>

                {{-- Filter Bar --}}
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 mb-5 shadow-sm">
                    <form action="{{ route('log-pergerakan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-2.5 items-center">
                        <div class="lg:col-span-4">
                            <input type="text" class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-medium text-slate-800 placeholder-slate-400 outline-none" name="search" value="{{ request('search') }}" placeholder="Cari nama, NPM, rute...">
                        </div>
                        <div class="lg:col-span-2">
                            <select class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-700 outline-none" name="kategori">
                                <option value="">Semua Kategori</option>
                                <option value="perizinan" {{ request('kategori')==='perizinan'?'selected':'' }}>Perizinan</option>
                                <option value="ekstrakurikuler" {{ request('kategori')==='ekstrakurikuler'?'selected':'' }}>Ekstrakurikuler</option>
                                <option value="olahraga" {{ request('kategori')==='olahraga'?'selected':'' }}>Olahraga</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <select class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-700 outline-none" name="status">
                                <option value="">Semua Status</option>
                                <option value="berangkat" {{ request('status')==='berangkat'?'selected':'' }}>🔴 Belum Kembali</option>
                                <option value="kembali" {{ request('status')==='kembali'?'selected':'' }}>🟢 Sudah Kembali</option>
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <input type="date" class="w-full px-3 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-medium text-slate-800 outline-none" name="tanggal" value="{{ request('tanggal') }}">
                        </div>
                        <div class="lg:col-span-2 flex gap-1.5">
                            <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-filter text-[10px]"></i>
                                <span>Filter</span>
                            </button>
                            @if(request()->hasAny(['search', 'kategori', 'status', 'tanggal']))
                            <a href="{{ route('log-pergerakan.index') }}" class="py-2 px-3 rounded-xl bg-white/80 hover:bg-white text-slate-600 font-bold text-xs border border-white shadow-sm flex items-center justify-center transition">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Main Data Table --}}
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                    <th class="py-3 px-3">#</th>
                                    <th class="py-3 px-3">Taruna / Koordinator</th>
                                    <th class="py-3 px-3">Kategori</th>
                                    <th class="py-3 px-3">Detail Kegiatan</th>
                                    <th class="py-3 px-3">Waktu Berangkat</th>
                                    <th class="py-3 px-3">Waktu Kembali</th>
                                    <th class="py-3 px-3">Status</th>
                                    <th class="py-3 px-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/30">
                                @forelse($logs as $index => $item)
                                <tr class="hover:bg-white/60 transition">
                                    <td class="py-3 px-3 text-slate-400 font-bold">{{ $logs->firstItem() + $index }}</td>
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-900">{{ $item->nama }}</div>
                                        <div class="text-[10px] text-slate-500 font-mono">{{ $item->npm ?? '-' }} &bull; {{ $item->prodi ?? 'PPI Curug' }}</div>
                                    </td>
                                    <td class="py-3 px-3">
                                        {!! $item->getKategoriBadgeHtml() !!}
                                        <div class="text-[10px] text-slate-500 font-mono mt-0.5">{{ $item->subkategori }}</div>
                                    </td>
                                    <td class="py-3 px-3">
                                        @if($item->kategori === 'perizinan')
                                            <div class="text-slate-800 font-medium">{{ Str::limit($item->keterangan_keluhan, 35) }}</div>
                                        @elseif($item->kategori === 'ekstrakurikuler')
                                            <div class="font-bold text-indigo-700">{{ $item->nama_ekskul }} <span class="px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 text-[9px] font-bold">{{ $item->jumlah_anggota }} org</span></div>
                                            <div class="text-[10px] text-slate-500">{{ $item->lokasi_kegiatan ?? '-' }}</div>
                                        @else
                                            <div class="font-bold text-emerald-700">{{ $item->rute ?? 'Olahraga' }}</div>
                                            <div class="text-[10px] text-slate-500">{{ $item->pengikut ? Str::limit($item->pengikut, 25) : '-' }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-900 font-mono">{{ $item->waktu_berangkat ? $item->waktu_berangkat->format('d/m/Y H:i') : '-' }}</div>
                                        @if($item->isBelumKembali())
                                            <div class="text-[10px] text-rose-600 font-bold mt-0.5">{{ $item->getDurasiFormatted() }} lalu</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        @if($item->isSudahKembali())
                                            <div class="font-bold text-emerald-700 font-mono">{{ $item->waktu_kembali ? $item->waktu_kembali->format('d/m/Y H:i') : '-' }}</div>
                                            <div class="text-[10px] text-slate-500">Durasi: {{ $item->getDurasiFormatted() }}</div>
                                        @else
                                            <span class="text-[10px] text-slate-400 italic font-medium">Masih di luar</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        {!! $item->getStatusBadgeHtml() !!}
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            <a href="{{ route('log-pergerakan.show', $item->id) }}" class="p-1.5 rounded-lg bg-white/80 hover:bg-white text-indigo-700 border border-white/90 shadow-sm transition" title="Lihat Detail">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </a>
                                            @if($item->isBelumKembali())
                                            <form action="{{ route('log-pergerakan.kembali', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Tandai {{ $item->nama }} SUDAH KEMBALI?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition" title="Tandai Kembali">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @if(auth()->user()->canManageSystem() || auth()->user()->isPengasuh())
                                            <form action="{{ route('log-pergerakan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data log ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 shadow-sm transition" title="Hapus">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-10 text-slate-400">
                                        <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                        <span class="font-semibold text-xs">Belum ada catatan log pergerakan taruna yang sesuai.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>

    </div>
</main>

</x-app-layout>
