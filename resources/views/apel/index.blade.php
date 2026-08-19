<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Page Header --}}
                <div class="rounded-2xl bg-gradient-to-r from-emerald-900/90 via-teal-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-emerald-300 mb-2">
                            <span>✦</span>
                            <span>Presensi &amp; Agenda Taruna</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-flag text-emerald-400"></i>
                            <span>Apel &amp; Presensi Taruna</span>
                        </h1>
                        <p class="text-xs text-emerald-100/80">Pilih apel berdasarkan tanggal dan sesi untuk melihat pembina, informasi instruksi, dan lokasi</p>
                    </div>

                    @if($bolehIsi)
                    <div class="relative z-10">
                        <a href="{{ route('apel.create') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-xs shadow-md transition flex items-center gap-2 no-underline">
                            <i class="fa-solid fa-plus text-emerald-600"></i>
                            <span>Isi Data Apel Baru</span>
                        </a>
                    </div>
                    @endif

                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
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

                @unless($bolehIsi)
                <div class="rounded-2xl bg-amber-50/90 border border-amber-200 p-4 text-amber-900 text-xs font-semibold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-lock text-amber-600"></i>
                    <span>Akses pengisian data apel sedang ditutup admin — data tetap dapat dilihat, tetapi tidak dapat diubah.</span>
                </div>
                @endunless

                @if($daftarApel->isEmpty())
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-10 text-center shadow-lg">
                    <i class="fa-solid fa-flag text-4xl text-slate-300 mb-3 block"></i>
                    <p class="text-xs font-bold text-slate-600 mb-3">Belum ada data apel yang tercatat di sistem.</p>
                    @if($bolehIsi)
                    <a href="{{ route('apel.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md transition no-underline">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Isi Data Apel Pertama</span>
                    </a>
                    @endif
                </div>
                @else

                {{-- Selector Card --}}
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 mb-5 shadow-sm">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 block" for="apelSelect">Pilih Sesi Apel</label>
                    <div class="flex flex-col sm:flex-row gap-3 items-center">
                        <div class="relative flex-1 w-full">
                            <select id="apelSelect" onchange="bukaApel(this.value)" class="w-full px-4 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-bold text-slate-800 outline-none cursor-pointer">
                                @foreach($daftarApel as $item)
                                <option value="{{ $item->id }}"
                                        data-sesi="{{ $item->sesi }}"
                                        @selected($terpilih && $terpilih->id === $item->id)>
                                    {{ $item->label_dropdown }}@if($item->jam) · {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}@endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-1.5 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0">
                            <button type="button" class="px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-sm border border-emerald-600 transition chip active" data-filter="all" onclick="filterSesi('all', this)">Semua</button>
                            <button type="button" class="px-3 py-1.5 rounded-full text-xs font-bold bg-white/60 hover:bg-white text-slate-700 border border-white transition chip" data-filter="pagi" onclick="filterSesi('pagi', this)">Pagi</button>
                            <button type="button" class="px-3 py-1.5 rounded-full text-xs font-bold bg-white/60 hover:bg-white text-slate-700 border border-white transition chip" data-filter="malam" onclick="filterSesi('malam', this)">Malam</button>
                            <button type="button" class="px-3 py-1.5 rounded-full text-xs font-bold bg-white/60 hover:bg-white text-slate-700 border border-white transition chip" data-filter="khusus" onclick="filterSesi('khusus', this)">Khusus</button>
                        </div>
                    </div>
                </div>

                {{-- Detail Apel Terpilih --}}
                @if($terpilih)
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 overflow-hidden shadow-lg">
                    <div class="p-5 sm:p-6 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4" style="background:linear-gradient(135deg,{{ $terpilih->warna ?? '#059669' }},#1e3a8a);">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-xl flex-shrink-0 shadow-inner">
                                <i class="fa-solid {{ $terpilih->ikon ?? 'fa-flag' }}"></i>
                            </div>
                            <div>
                                <h2 class="text-base sm:text-lg font-extrabold text-white mb-0.5">{{ $terpilih->judul }}</h2>
                                <div class="text-[11px] text-white/90 flex flex-wrap items-center gap-3 font-medium">
                                    <span><i class="fa-solid fa-calendar-day mr-1"></i> {{ $terpilih->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                                    @if($terpilih->jam)
                                    <span><i class="fa-solid fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($terpilih->jam)->format('H:i') }} WIB</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($bolehIsi)
                        <div class="flex items-center gap-2">
                            <a href="{{ route('apel.edit', $terpilih) }}" class="px-3 py-1.5 rounded-xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs backdrop-blur-md transition flex items-center gap-1.5 no-underline">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                                <span>Ubah</span>
                            </a>
                            <button type="button" class="px-3 py-1.5 rounded-xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-200 border border-rose-400/40 font-bold text-xs backdrop-blur-md transition flex items-center gap-1.5" onclick="konfirmasiHapus()">
                                <i class="fa-solid fa-trash text-[10px]"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="p-5 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-5">
                            <div class="rounded-xl bg-white/60 border border-white/80 p-3.5 shadow-sm">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-tie text-indigo-600"></i>
                                    <span>Pembina Apel</span>
                                </div>
                                <div class="text-xs font-black text-slate-900">{{ $terpilih->pembina }}</div>
                                @if($terpilih->pembinaUser?->jabatan)
                                <div class="text-[10px] text-slate-500 font-medium mt-0.5">{{ $terpilih->pembinaUser->jabatan }}</div>
                                @endif
                            </div>

                            <div class="rounded-xl bg-white/60 border border-white/80 p-3.5 shadow-sm">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-rose-500"></i>
                                    <span>Lokasi Apel</span>
                                </div>
                                <div class="text-xs font-black text-slate-900">{{ $terpilih->lokasi }}</div>
                            </div>

                            <div class="rounded-xl bg-white/60 border border-white/80 p-3.5 shadow-sm">
                                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-flag text-emerald-600"></i>
                                    <span>Sesi Apel</span>
                                </div>
                                <div class="text-xs font-black text-slate-900">{{ $terpilih->judul }}</div>
                                <div class="text-[10px] text-slate-500 font-medium mt-0.5">{{ ucfirst($terpilih->sesi) }}</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-info text-indigo-600"></i>
                                <span>Informasi Apel</span>
                            </h3>
                            <div class="p-3.5 rounded-xl bg-white/60 border-l-4 border-emerald-500 text-xs text-slate-800 leading-relaxed whitespace-pre-line shadow-sm">
                                {{ $terpilih->informasi ?: 'Belum ada informasi instruksi apel yang dicantumkan.' }}
                            </div>
                        </div>

                        @if($terpilih->keterangan)
                        <div class="mb-4">
                            <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-note-sticky text-amber-500"></i>
                                <span>Keterangan Tambahan</span>
                            </h3>
                            <div class="p-3.5 rounded-xl bg-white/60 border-l-4 border-amber-400 text-xs text-slate-800 leading-relaxed shadow-sm">
                                {{ $terpilih->keterangan }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="px-6 py-3 bg-white/30 border-t border-white/40 text-[11px] text-slate-500 flex flex-wrap justify-between items-center gap-2">
                        <span><i class="fa-solid fa-user-pen mr-1"></i> Diisi oleh: {{ $terpilih->pembuat?->name ?? '—' }}</span>
                        <span>Terakhir diperbarui: {{ $terpilih->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    </div>
                </div>

                <form id="formHapus" method="POST" action="{{ route('apel.destroy', $terpilih) }}" style="display:none;">
                    @csrf @method('DELETE')
                </form>
                @endif

                @endif

    </div>
</main>

<script>
function bukaApel(id) {
    window.location = '{{ route('apel.index') }}?apel=' + id;
}

function filterSesi(sesi, chipEl) {
    document.querySelectorAll('.chip').forEach(c => {
        c.classList.remove('bg-emerald-600', 'text-white');
        c.classList.add('bg-white/60', 'text-slate-700');
    });
    chipEl.classList.remove('bg-white/60', 'text-slate-700');
    chipEl.classList.add('bg-emerald-600', 'text-white');

    const select = document.getElementById('apelSelect');
    let pertamaCocok = null;

    [...select.options].forEach(opt => {
        const cocok = sesi === 'all' || opt.dataset.sesi === sesi;
        opt.hidden = !cocok;
        if (cocok && pertamaCocok === null) pertamaCocok = opt;
    });

    if (pertamaCocok && select.selectedOptions[0].hidden) {
        bukaApel(pertamaCocok.value);
    }
}

function konfirmasiHapus() {
    if (confirm('Hapus data apel ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('formHapus').submit();
    }
}
</script>

</x-app-layout>
