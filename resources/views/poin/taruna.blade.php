<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Header Banner --}}
                <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-purple-950/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-amber-300 mb-2">
                            <span>✦</span>
                            <span>Raport Disiplin Taruna</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-star text-amber-400"></i>
                            <span>Raport Poin &amp; Disiplin Taruna</span>
                        </h1>
                        <p class="text-xs text-sky-100/80">Pantau akumulasi Poin Pelanggaran (-) dan Poin Penghargaan (+) secara mandiri</p>
                    </div>

                    @if($selectedStudent)
                    <div class="relative z-10 bg-white/15 backdrop-blur-md border border-white/25 rounded-2xl px-4 py-2.5 shadow-inner">
                        <div class="text-xs font-bold text-white">{{ $selectedStudent->nama }}</div>
                        <div class="text-[10px] text-sky-200 font-mono">NIT: {{ $selectedStudent->npm }} &bull; {{ $selectedStudent->kelas }}</div>
                    </div>
                    @endif

                    {{-- Ambient glow --}}
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
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

                {{-- STATUS SANKSI TARUNA (THRESHOLD PELANGGARAN) --}}
                <div class="rounded-2xl p-4 sm:p-5 mb-5 shadow-lg flex items-center gap-4 border backdrop-blur-xl" style="background:{{ $statusSanksi['bg'] }}; border-color:{{ $statusSanksi['border'] }}; color:{{ $statusSanksi['color'] }};">
                    <div class="w-12 h-12 rounded-xl bg-white/60 flex items-center justify-center text-2xl flex-shrink-0 shadow-sm">
                        <i class="{{ $statusSanksi['icon'] }}"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs sm:text-sm font-extrabold tracking-tight">Status Kedisiplinan: {{ $statusSanksi['status'] }}</div>
                        <p class="text-[11px] sm:text-xs opacity-90 leading-relaxed mt-0.5">{{ $statusSanksi['desc'] }}</p>
                    </div>
                </div>

                {{-- DUAL SUMMARY GRID --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    
                    {{-- Pelanggaran Card --}}
                    <div class="rounded-2xl bg-rose-50/70 hover:bg-rose-50/90 backdrop-blur-xl border border-rose-200/80 p-5 shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-rose-800 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Akumulasi Pelanggaran (-)</span>
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-200 text-rose-800 font-bold text-[10px]">
                                {{ $riwayatPelanggaran->count() }} Temuan
                            </span>
                        </div>
                        <div class="text-3xl font-black text-rose-700 font-mono tracking-tight my-1.5">
                            {{ $totalPelanggaran }} Poin
                        </div>
                        <div class="text-[11px] text-rose-900/70 font-medium leading-relaxed">
                            Poin pelanggaran diakumulasikan untuk menentukan batas toleransi &amp; Surat Peringatan (SP).
                        </div>
                    </div>

                    {{-- Penghargaan Card --}}
                    <div class="rounded-2xl bg-emerald-50/70 hover:bg-emerald-50/90 backdrop-blur-xl border border-emerald-200/80 p-5 shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-trophy"></i>
                                <span>Akumulasi Penghargaan (+)</span>
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-200 text-emerald-800 font-bold text-[10px]">
                                {{ $riwayatPenghargaan->count() }} Prestasi
                            </span>
                        </div>
                        <div class="text-3xl font-black text-emerald-700 font-mono tracking-tight my-1.5">
                            +{{ $totalPenghargaan }} Poin
                        </div>
                        <div class="text-[11px] text-emerald-900/70 font-medium leading-relaxed">
                            Poin reward prestasi mandiri taruna (tidak mengurangi poin pelanggaran).
                        </div>
                    </div>

                </div>

                {{-- Threshold Progress Bar --}}
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 mb-6 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between text-slate-600 text-[10px] font-bold uppercase tracking-wider mb-2 gap-2">
                        <span class="text-emerald-700">🟢 Aman (&lt; 50 Poin)</span>
                        <span class="text-amber-700">🟡 SP 1 (50 - 74)</span>
                        <span class="text-orange-700">🟠 SP 2 (75 - 99)</span>
                        <span class="text-rose-700">🔴 SP 3 &amp; Sidang (&ge; 100)</span>
                    </div>
                    <div class="h-3 w-full rounded-full bg-slate-200/80 overflow-hidden flex shadow-inner">
                        <div class="h-full bg-emerald-500 w-1/2" title="Aman (<50)"></div>
                        <div class="h-full bg-amber-400 w-1/6" title="SP 1 (50-74)"></div>
                        <div class="h-full bg-orange-500 w-1/6" title="SP 2 (75-99)"></div>
                        <div class="h-full bg-rose-500 w-1/6" title="SP 3 (>=100)"></div>
                    </div>
                </div>

                {{-- NAV TABS DETAIL RIWAYAT --}}
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                    
                    {{-- Nav Tabs Pills --}}
                    <div class="flex flex-wrap items-center gap-2 pb-4 mb-4 border-b border-white/30">
                        <button class="px-4 py-2 rounded-xl text-xs font-bold bg-white text-rose-700 shadow-md border border-white/80 transition flex items-center gap-2" id="tab-pelanggaran-btn" data-bs-toggle="pill" data-bs-target="#panePelanggaran" type="button" role="tab">
                            <i class="fa-solid fa-ban"></i>
                            <span>Riwayat Pelanggaran ({{ $riwayatPelanggaran->count() }})</span>
                        </button>
                        <button class="px-4 py-2 rounded-xl text-xs font-bold bg-white/40 hover:bg-white/70 text-emerald-700 transition flex items-center gap-2" id="tab-penghargaan-btn" data-bs-toggle="pill" data-bs-target="#panePenghargaan" type="button" role="tab">
                            <i class="fa-solid fa-trophy"></i>
                            <span>Riwayat Penghargaan ({{ $riwayatPenghargaan->count() }})</span>
                        </button>
                    </div>

                    <div class="tab-content" id="tarunaPoinTabContent">
                        
                        {{-- TAB PELANGGARAN --}}
                        <div class="tab-pane fade show active" id="panePelanggaran" role="tabpanel">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                            <th class="py-3 px-3.5">Tanggal</th>
                                            <th class="py-3 px-3.5">Tingkat</th>
                                            <th class="py-3 px-3.5">Deskripsi Pelanggaran PTTT</th>
                                            <th class="py-3 px-3.5">Poin</th>
                                            <th class="py-3 px-3.5">Pemeriksa</th>
                                            <th class="py-3 px-3.5 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/30">
                                        @forelse($riwayatPelanggaran as $p)
                                        <tr class="hover:bg-white/60 transition">
                                            <td class="py-3 px-3.5 text-slate-600 font-medium whitespace-nowrap">
                                                {{ $p->tanggal ? $p->tanggal->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="py-3 px-3.5">
                                                <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 font-bold text-[10px] border border-rose-200">
                                                    {{ ucfirst($p->tingkat ?? 'Pelanggaran') }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-3.5">
                                                <div class="font-bold text-slate-900">{{ $p->kegiatan }}</div>
                                                @if($p->keterangan)
                                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $p->keterangan }}</div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3.5 font-bold text-rose-600 font-mono whitespace-nowrap">
                                                -{{ $p->nilai }} Poin
                                            </td>
                                            <td class="py-3 px-3.5 text-slate-700 font-medium">
                                                {{ $p->pengasuh }}
                                            </td>
                                            <td class="py-3 px-3.5 text-right">
                                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] border border-emerald-200 inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-circle-check text-[9px]"></i> Tervalidasi
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-8 text-slate-500">
                                                <i class="fa-solid fa-shield-halved text-3xl text-emerald-500 mb-2 block"></i>
                                                <span class="font-semibold">Tidak ada catatan pelanggaran. Pertahankan kedisiplinan dan tata tertib!</span>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- TAB PENGHARGAAN --}}
                        <div class="tab-pane fade" id="panePenghargaan" role="tabpanel">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                            <th class="py-3 px-3.5">Tanggal</th>
                                            <th class="py-3 px-3.5">Tingkat</th>
                                            <th class="py-3 px-3.5">Prestasi / Penghargaan</th>
                                            <th class="py-3 px-3.5">Poin</th>
                                            <th class="py-3 px-3.5">Rekomendasi</th>
                                            <th class="py-3 px-3.5 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/30">
                                        @forelse($riwayatPenghargaan as $r)
                                        <tr class="hover:bg-white/60 transition">
                                            <td class="py-3 px-3.5 text-slate-600 font-medium whitespace-nowrap">
                                                {{ $r->tanggal ? $r->tanggal->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="py-3 px-3.5">
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] border border-emerald-200">
                                                    {{ ucfirst($r->tingkat ?? 'Prestasi') }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-3.5">
                                                <div class="font-bold text-slate-900">{{ $r->kegiatan }}</div>
                                                @if($r->keterangan)
                                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $r->keterangan }}</div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3.5 font-bold text-emerald-600 font-mono whitespace-nowrap">
                                                +{{ $r->nilai }} Poin
                                            </td>
                                            <td class="py-3 px-3.5 text-slate-700 font-medium">
                                                {{ $r->pengasuh }}
                                            </td>
                                            <td class="py-3 px-3.5 text-right">
                                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] border border-emerald-200 inline-flex items-center gap-1">
                                                    <i class="fa-solid fa-circle-check text-[9px]"></i> Tervalidasi
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-8 text-slate-500">
                                                <i class="fa-solid fa-award text-3xl text-slate-400 mb-2 block"></i>
                                                <span class="font-semibold">Belum ada catatan penghargaan atau prestasi.</span>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                @endif

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabPelanggaranBtn = document.getElementById('tab-pelanggaran-btn');
        const tabPenghargaanBtn = document.getElementById('tab-penghargaan-btn');

        if (tabPelanggaranBtn && tabPenghargaanBtn) {
            tabPelanggaranBtn.addEventListener('click', function() {
                tabPelanggaranBtn.classList.add('bg-white', 'shadow-md', 'border', 'border-white/80');
                tabPelanggaranBtn.classList.remove('bg-white/40');
                tabPenghargaanBtn.classList.remove('bg-white', 'shadow-md', 'border', 'border-white/80');
                tabPenghargaanBtn.classList.add('bg-white/40');
            });
            tabPenghargaanBtn.addEventListener('click', function() {
                tabPenghargaanBtn.classList.add('bg-white', 'shadow-md', 'border', 'border-white/80');
                tabPenghargaanBtn.classList.remove('bg-white/40');
                tabPelanggaranBtn.classList.remove('bg-white', 'shadow-md', 'border', 'border-white/80');
                tabPelanggaranBtn.classList.add('bg-white/40');
            });
        }
    });
</script>

</x-app-layout>
