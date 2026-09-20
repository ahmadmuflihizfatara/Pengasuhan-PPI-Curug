<x-app-layout>

<x-island-navbar />

@php $isTaruna = auth()->user()->isTaruna(); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Page Header --}}
        <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-amber-300 mb-2">
                    <span>✦</span>
                    <span>Duty Taruna</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-notes-medical text-rose-400"></i>
                    <span>Laporan Duty Taruna</span>
                </h1>
                <p class="text-xs text-rose-100/80">
                    @if($isTaruna)
                    Anda duty minggu ini ({{ \App\Models\DutyTaruna::labelPeriode(\App\Models\DutyTaruna::awalMinggu()) }}) — laporkan taruna sakit hari ini ke pengasuh.
                    @else
                    Laporan taruna sakit yang masuk dari taruna duty.
                    @endif
                </p>
            </div>
            <div class="relative z-10 text-right">
                <div class="text-[10px] font-bold uppercase tracking-widest text-white/60">Tanggal</div>
                <div class="text-lg font-black">{{ $tanggal->locale('id')->isoFormat('dddd, D MMM Y') }}</div>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if($errors->any())
        <div class="rounded-2xl bg-rose-100/90 border border-rose-300 p-4 text-rose-800 text-xs font-bold mb-5 shadow-sm backdrop-blur-md">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        @if($isTaruna)
        {{-- Form lapor (taruna duty) --}}
        <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-5 sm:p-6 mb-6 shadow-lg">
            <div class="pb-3.5 mb-4 border-b border-white/30">
                <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-user-injured text-rose-500"></i>
                    <span>Laporkan Taruna Sakit Hari Ini</span>
                </h2>
                <p class="text-[11px] text-slate-500 mt-0.5">Ketik nama taruna yang sakit. Lapor ulang nama yang sama akan memperbarui keterangan.</p>
            </div>

            <form method="POST" action="{{ route('laporan-duty.store') }}" id="laporForm">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="namaTaruna" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Nama Taruna Sakit</label>
                        <input type="text" id="namaTaruna" list="daftarTaruna" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none"
                               placeholder="Ketik nama taruna..." autocomplete="off" required>
                        <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                        <div class="flex items-center gap-2 mt-2" id="infoTaruna" style="display:none;">
                            <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 font-bold text-[10px]" id="infoProdi"></span>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[10px]" id="infoTingkat"></span>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="keterangan" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Keterangan / Keluhan</label>
                        <textarea name="keterangan" id="keterangan" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-medium text-slate-800 outline-none"
                                  placeholder="Contoh: demam sejak pagi, istirahat di barak...">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <datalist id="daftarTaruna">
                    @foreach($daftarTaruna as $t)
                    <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                    @endforeach
                </datalist>

                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-orange-500 hover:from-rose-700 hover:to-orange-600 text-white font-extrabold text-xs shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Laporan</span>
                </button>
            </form>
        </div>
        @else
        {{-- Pilih tanggal (pengasuh/admin) --}}
        <form method="GET" action="{{ route('laporan-duty.index') }}" class="flex items-center gap-2 mb-4">
            <input type="date" name="tanggal" value="{{ $tanggal->toDateString() }}" max="{{ now()->toDateString() }}"
                   class="px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none"
                   onchange="this.form.submit()">
            @unless($tanggal->isToday())
            <a href="{{ route('laporan-duty.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 no-underline">Hari ini</a>
            @endunless
        </form>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Laporan masuk --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-notes-medical text-rose-500 text-sm"></i>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800">Taruna Sakit {{ $tanggal->isToday() ? 'Hari Ini' : $tanggal->locale('id')->isoFormat('D MMM') }} ({{ $laporan->count() }})</h3>
                </div>
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg overflow-x-auto">
                    @if($laporan->isEmpty())
                    <div class="text-center py-8 text-slate-500">
                        <i class="fa-solid fa-circle-check text-3xl text-emerald-500 mb-2 block"></i>
                        <span class="font-semibold text-xs">Belum ada laporan taruna sakit.</span>
                    </div>
                    @else
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200/70">
                                <th class="text-left py-2 pr-3">Taruna</th>
                                <th class="text-left py-2 px-3">Prodi / Tk</th>
                                <th class="text-left py-2 px-3">Keterangan</th>
                                <th class="text-left py-2 px-3">Pelapor</th>
                                <th class="py-2 pl-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $l)
                            @php $bolehHapus = !$isTaruna || ($l->dilaporkan_oleh === auth()->id() && $l->tanggal->isToday()); @endphp
                            <tr class="border-b border-slate-100/70 hover:bg-white/40">
                                <td class="py-2.5 pr-3 font-bold text-slate-800">{{ $l->mahasiswa->nama }}<div class="text-[10px] font-medium text-slate-400">{{ $l->mahasiswa->npm }}</div></td>
                                <td class="py-2.5 px-3 text-slate-600">{{ $l->mahasiswa->prodi }} / {{ $l->mahasiswa->tingkat }}</td>
                                <td class="py-2.5 px-3 text-slate-600">{{ $l->keterangan ?: '-' }}</td>
                                <td class="py-2.5 px-3 text-slate-500">{{ $l->pelapor->name ?? '-' }}<div class="text-[10px] text-slate-400">{{ $l->updated_at->format('H:i') }}</div></td>
                                <td class="py-2.5 pl-3 text-right">
                                    @if($bolehHapus)
                                    <form method="POST" action="{{ route('laporan-duty.destroy', $l) }}" onsubmit="return confirm('Hapus laporan {{ $l->mahasiswa->nama }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold text-[10px] transition"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

            {{-- Duty minggu ini --}}
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-users-rectangle text-emerald-500 text-sm"></i>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800">Duty Minggu Ini ({{ $dutyMinggu->count() }})</h3>
                </div>
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 shadow-lg">
                    @forelse($dutyMinggu->sortBy(fn ($d) => $d->mahasiswa->nama ?? '') as $d)
                    <div class="flex items-center gap-2 py-1.5 border-b border-slate-100/70 last:border-0 text-xs">
                        <i class="fa-solid fa-user-check text-emerald-500 text-[10px]"></i>
                        <span class="font-semibold text-slate-800">{{ $d->mahasiswa->nama ?? '-' }}</span>
                        <span class="text-[10px] text-slate-400 ml-auto">{{ $d->mahasiswa->prodi ?? '' }}</span>
                    </div>
                    @empty
                    <div class="text-center py-4 text-slate-400 text-xs font-semibold">Duty minggu ini belum diisi.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</main>

@if($isTaruna)
<script>
const TARUNA = @json($daftarTaruna->mapWithKeys(fn($t) => [strtolower($t->nama) => ['id' => $t->id, 'prodi' => $t->prodi, 'tingkat' => $t->tingkat]]));

const namaEl = document.getElementById('namaTaruna');
function cocokkanTaruna() {
    const idEl   = document.getElementById('mahasiswaId');
    const infoEl = document.getElementById('infoTaruna');
    const cocok  = TARUNA[namaEl.value.trim().toLowerCase()];

    if (cocok) {
        idEl.value = cocok.id;
        document.getElementById('infoProdi').textContent = cocok.prodi || '-';
        document.getElementById('infoTingkat').textContent = 'Tingkat ' + (cocok.tingkat || '-');
        infoEl.style.display = 'flex';
    } else {
        idEl.value = '';
        infoEl.style.display = 'none';
    }
}
namaEl.addEventListener('input', cocokkanTaruna);
namaEl.addEventListener('change', cocokkanTaruna);

document.getElementById('laporForm').addEventListener('submit', function(e) {
    if (!document.getElementById('mahasiswaId').value) {
        e.preventDefault();
        namaEl.focus();
        alert('Pilih nama taruna yang cocok dari daftar (ketik lalu pilih dari saran).');
    }
});
</script>
@endif

</x-app-layout>
