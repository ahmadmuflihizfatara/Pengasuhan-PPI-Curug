<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Page Header Glass Banner --}}
                <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-sky-200 mb-2">
                            <span>✦</span>
                            <span>Administrasi &amp; Perizinan</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-envelope-open-text text-sky-400"></i>
                            <span>Administrasi Surat Pengasuhan</span>
                        </h1>
                        <p class="text-xs text-sky-100/80">Kelola dan pantau seluruh permohonan surat izin, surat keterangan, dan disposisi pengasuhan</p>
                    </div>

                    <div class="relative z-10">
                        <a href="{{ route('surat.create') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-xs shadow-md transition flex items-center gap-2 no-underline">
                            <i class="fa-solid fa-plus text-indigo-600"></i>
                            <span>Tambah Surat Baru</span>
                        </a>
                    </div>

                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                {{-- 5 KPI Stat Cards Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-5">
                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="text-2xl font-black text-slate-900 font-mono">{{ $stats['total'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Total Surat</div>
                    </div>

                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                        <div class="text-2xl font-black text-amber-600 font-mono">{{ $stats['diproses'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Diproses</div>
                    </div>

                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="text-2xl font-black text-emerald-600 font-mono">{{ $stats['disetujui'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Disetujui</div>
                    </div>

                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <div class="text-2xl font-black text-rose-600 font-mono">{{ $stats['ditolak'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Ditolak</div>
                    </div>

                    <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow-md text-center">
                        <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center mx-auto mb-2 text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-flag-checkered"></i>
                        </div>
                        <div class="text-2xl font-black text-sky-600 font-mono">{{ $stats['selesai'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Selesai</div>
                    </div>
                </div>

                {{-- Filter Bar --}}
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 mb-5 shadow-sm">
                    <form method="GET" action="{{ route('surat.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-2.5 items-center">
                        <div class="lg:col-span-5">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari perihal, pengirim, nomor surat..." 
                                   class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-medium text-slate-800 placeholder-slate-400 outline-none">
                        </div>
                        <div class="lg:col-span-3">
                            <select name="jenis" class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-700 outline-none">
                                <option value="">Semua Jenis Surat</option>
                                @foreach(\App\Models\Surat::jenisSuratList() as $j)
                                    <option value="{{ $j }}" {{ request('jenis') === $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <select name="status" class="w-full px-3.5 py-2 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-700 outline-none">
                                <option value="">Semua Status</option>
                                @foreach(\App\Models\Surat::statusList() as $s)
                                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-2 flex gap-1.5">
                            <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-filter text-[10px]"></i>
                                <span>Filter</span>
                            </button>
                            @if(request()->hasAny(['search','jenis','status']))
                            <a href="{{ route('surat.index') }}" class="py-2 px-3 rounded-xl bg-white/80 hover:bg-white text-indigo-600 font-bold text-xs border border-white shadow-sm flex items-center justify-center transition">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Table Card / Empty State --}}
                @if($surat->isEmpty())
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-10 text-center shadow-lg">
                    <i class="fa-solid fa-inbox text-4xl text-slate-300 mb-2 block"></i>
                    <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Data Surat</h4>
                    <p class="text-xs text-slate-500 mb-3">Klik tombol di bawah untuk membuat dan mengajukan surat baru.</p>
                    <a href="{{ route('surat.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-md transition no-underline">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Surat Pertama</span>
                    </a>
                </div>
                @else
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                    <th class="py-3 px-3">#</th>
                                    <th class="py-3 px-3">No. Surat</th>
                                    <th class="py-3 px-3">Jenis</th>
                                    <th class="py-3 px-3">Perihal</th>
                                    <th class="py-3 px-3">Pengirim / Penerima</th>
                                    <th class="py-3 px-3">Tanggal</th>
                                    <th class="py-3 px-3 text-center">Status</th>
                                    <th class="py-3 px-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/30">
                                @foreach($surat as $i => $s)
                                <tr class="hover:bg-white/60 transition">
                                    <td class="py-3 px-3 text-slate-400 font-bold">{{ ($surat->currentPage()-1)*$surat->perPage()+$i+1 }}</td>
                                    <td class="py-3 px-3 font-mono font-bold text-indigo-700 whitespace-nowrap">{{ $s->nomor_surat ?: '—' }}</td>
                                    <td class="py-3 px-3">
                                        <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 font-bold text-[10px] border border-indigo-200">
                                            {{ $s->jenis_surat }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 max-w-[200px]">
                                        <a href="{{ route('surat.show', $s->id) }}" class="no-underline">
                                            <div class="font-bold text-slate-900 truncate">{{ $s->perihal }}</div>
                                        </a>
                                        @if($s->keterangan)
                                            <div class="text-[10px] text-slate-500 truncate mt-0.5">{{ $s->keterangan }}</div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-800">{{ $s->pengirim }}</div>
                                        <div class="text-[10px] text-slate-500 flex items-center gap-1 mt-0.5">
                                            <i class="fa-solid fa-arrow-right text-[8px]"></i>
                                            <span>{{ $s->penerima }}</span>
                                        </div>
                                        @if($s->isDiajukanTaruna())
                                        <span class="px-2 py-0.2 rounded-md bg-amber-100 text-amber-800 text-[9px] font-bold inline-flex items-center gap-1 mt-1">
                                            <i class="fa-solid fa-user-graduate text-[8px]"></i> Taruna
                                        </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 whitespace-nowrap text-slate-600">
                                        <div class="font-medium">
                                            <i class="fa-solid fa-calendar text-indigo-500 mr-1 text-[10px]"></i>
                                            {{ \Carbon\Carbon::parse($s->tanggal_surat)->locale('id')->isoFormat('D MMM Y') }}
                                        </div>
                                        @if($s->tanggal_terima)
                                        <div class="text-[10px] text-slate-400 mt-0.5">
                                            Terima: {{ \Carbon\Carbon::parse($s->tanggal_terima)->locale('id')->isoFormat('D MMM Y') }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px]" style="background:{{ $s->status_bg_color }}; color:{{ $s->status_badge_color }};">
                                            {{ $s->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            @if($s->status === 'Diproses')
                                                <form method="POST" action="{{ route('surat.updateStatus', $s->id) }}" class="inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="Disetujui">
                                                    <button type="submit" class="p-1.5 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-800 transition" title="Setujui" onclick="return confirm('Setujui surat: {{ addslashes($s->perihal) }}?')">
                                                        <i class="fa-solid fa-check text-xs"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('surat.updateStatus', $s->id) }}" class="inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit" class="p-1.5 rounded-lg bg-rose-100 hover:bg-rose-200 text-rose-800 transition" title="Tolak" onclick="return confirm('Tolak surat: {{ addslashes($s->perihal) }}?')">
                                                        <i class="fa-solid fa-xmark text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('surat.show', $s->id) }}" class="p-1.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-200 shadow-sm transition" title="Detail"><i class="fa-solid fa-eye text-xs"></i></a>
                                            <a href="{{ route('surat.edit', $s->id) }}" class="p-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 shadow-sm transition" title="Edit"><i class="fa-solid fa-pen text-xs"></i></a>
                                            <button type="button" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 shadow-sm transition" title="Hapus" onclick="showSuratDeleteModal('del-surat-{{ $s->id }}', '{{ addslashes(Str::limit($s->perihal, 50)) }}')">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($surat->hasPages())
                    <div class="mt-4">
                        {{ $surat->links() }}
                    </div>
                    @endif
                </div>
                @endif

    </div>
</main>

{{-- Hidden DELETE forms --}}
@foreach($surat as $s)
<form id="del-surat-{{ $s->id }}" method="POST" action="{{ route('surat.destroy', $s->id) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endforeach

{{-- Modal Konfirmasi Hapus --}}
<div class="modal-overlay" id="suratDeleteModal">
    <div class="modal-box">
        <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-xl mx-auto mb-3">
            <i class="fa-solid fa-trash"></i>
        </div>
        <h3 class="text-sm font-bold text-slate-800 mb-1">Hapus Surat?</h3>
        <p class="text-xs font-semibold text-slate-700 mb-1" id="suratModalPerihal"></p>
        <p class="text-[11px] text-slate-400 mb-4">Surat ini akan dihapus secara permanen dari sistem.</p>
        <div class="flex items-center justify-center gap-2">
            <button class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition" onclick="closeSuratDeleteModal()">
                Batal
            </button>
            <button class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md transition" onclick="submitSuratDeleteForm()">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
let suratTargetFormId = null;
function showSuratDeleteModal(formId, perihal) {
    suratTargetFormId = formId;
    document.getElementById('suratModalPerihal').textContent = perihal;
    document.getElementById('suratDeleteModal').classList.add('open');
}
function closeSuratDeleteModal() {
    document.getElementById('suratDeleteModal').classList.remove('open');
    suratTargetFormId = null;
}
function submitSuratDeleteForm() {
    if (suratTargetFormId) document.getElementById(suratTargetFormId).submit();
}
document.getElementById('suratDeleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeSuratDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeSuratDeleteModal();
});
</script>

</x-app-layout>
