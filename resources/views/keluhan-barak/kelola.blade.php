<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Page Header Glass Banner --}}
                <div class="rounded-2xl bg-gradient-to-r from-purple-900/90 via-pink-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-pink-200 mb-2">
                            <span>✦</span>
                            <span>Manajemen Pengasuh &amp; Logistik</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-door-open text-pink-400"></i>
                            <span>Kelola Keluhan Barak</span>
                        </h1>
                        <p class="text-xs text-pink-100/80">Disposisi, proses perbaikan teknis, dan verifikasi keluhan sarana barak taruna</p>
                    </div>

                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif
                @if(session('error'))
                <div class="rounded-2xl bg-rose-100/90 border border-rose-300 p-4 text-rose-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                {{-- 5 KPI Stat Cards Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-5">
                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                        <div class="text-2xl font-black text-slate-900 font-mono">{{ $stats['total'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Total Keluhan</div>
                    </div>

                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div class="text-2xl font-black text-amber-600 font-mono">{{ $stats['diajukan'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Diajukan</div>
                    </div>

                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                        <div class="text-2xl font-black text-sky-600 font-mono">{{ $stats['diproses'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Diproses</div>
                    </div>

                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="text-2xl font-black text-emerald-600 font-mono">{{ $stats['selesai'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Selesai</div>
                    </div>

                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <div class="text-2xl font-black text-rose-600 font-mono">{{ $stats['ditolak'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Ditolak</div>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 mb-5 shadow-sm">
                    <form method="GET" action="{{ route('keluhan-barak.kelola') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-2.5 items-center">
                        <div class="lg:col-span-5">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari nama taruna, email, nomor barak..." 
                                   class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-medium text-slate-800 placeholder-slate-400 outline-none">
                        </div>
                        <div class="lg:col-span-3">
                            <select name="asrama" class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-700 outline-none">
                                <option value="">Semua Asrama</option>
                                @foreach($asramaList as $a)
                                    <option value="{{ $a }}" {{ request('asrama') === $a ? 'selected' : '' }}>{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <select name="status" class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-700 outline-none">
                                <option value="">Semua Status</option>
                                @foreach($statusList as $s)
                                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-2 flex gap-1.5">
                            <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-filter text-[10px]"></i>
                                <span>Filter</span>
                            </button>
                            @if(request()->hasAny(['search','asrama','status']))
                            <a href="{{ route('keluhan-barak.kelola') }}" class="py-2 px-3 rounded-xl bg-white/80 hover:bg-white text-rose-600 font-bold text-xs border border-white shadow-sm flex items-center justify-center transition">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Table Card --}}
                @if($daftarKeluhan->isEmpty())
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-10 text-center shadow-lg">
                    <i class="fa-solid fa-door-open text-4xl text-slate-300 mb-2 block"></i>
                    <h4 class="text-sm font-bold text-slate-800 mb-1">Tidak Ada Data Keluhan Ditemukan</h4>
                    <p class="text-xs text-slate-500">Tidak ada pengajuan keluhan barak yang cocok dengan filter yang dipilih.</p>
                </div>
                @else
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                    <th class="py-3 px-3">#</th>
                                    <th class="py-3 px-3">Pengaju</th>
                                    <th class="py-3 px-3">Lokasi Barak</th>
                                    <th class="py-3 px-3">Tanggal</th>
                                    <th class="py-3 px-3 text-center">Status</th>
                                    <th class="py-3 px-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/30">
                                @foreach($daftarKeluhan as $i => $k)
                                <tr class="hover:bg-white/60 transition">
                                    <td class="py-3 px-3 text-slate-400 font-bold">{{ $daftarKeluhan->firstItem() + $i }}</td>
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-900">{{ $k->nama }}</div>
                                        <div class="text-[10px] text-slate-500 font-mono">{{ $k->email }}</div>
                                        <div class="text-[10px] text-slate-500 font-semibold">{{ $k->prodi }}</div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <span class="px-2 py-0.5 rounded-full bg-pink-100 text-pink-800 font-bold text-[10px] border border-pink-200">
                                            {{ $k->asrama }}
                                        </span>
                                        <div class="font-bold text-slate-900 mt-1">
                                            {{ $k->lorong }} &bull; No. {{ $k->nomor_barak }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-slate-600 font-medium whitespace-nowrap">
                                        <i class="fa-solid fa-calendar text-pink-500 mr-1"></i>
                                        {{ $k->tanggal_pengajuan->locale('id')->isoFormat('D MMM Y') }}
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px]" style="background:{{ $k->status_bg_color }}; color:{{ $k->status_badge_color }};">
                                            {{ $k->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <a href="{{ route('keluhan-barak.detail', $k->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-pink-50 hover:bg-pink-100 text-pink-700 font-bold text-xs border border-pink-200 shadow-sm transition no-underline">
                                            <i class="fa-solid fa-eye text-[10px]"></i>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $daftarKeluhan->links() }}
                    </div>
                </div>
                @endif

    </div>
</main>

</x-app-layout>
