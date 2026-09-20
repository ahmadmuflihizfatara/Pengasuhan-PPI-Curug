<x-app-layout>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Page Header --}}
        <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-amber-300 mb-2">
                    <span>✦</span>
                    <span>Akademik &amp; Pembinaan</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-emerald-400"></i>
                    <span>Pengisian Nilai Taruna</span>
                </h1>
                <p class="text-xs text-emerald-100/80">Input IPS, Samapta &amp; Pengasuhan per semester — taruna melihat rekapitulasinya di dashboard</p>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
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
            <div class="flex items-center gap-2 mb-1">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                <span>Terdapat kendala validasi:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-normal">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        {{-- Form Input Nilai --}}
        <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-5 sm:p-6 mb-6 shadow-lg">
            <div class="pb-3.5 mb-4 border-b border-white/30">
                <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-emerald-500"></i>
                    <span>Input / Perbarui Nilai Semester</span>
                </h2>
                <p class="text-[11px] text-slate-500 mt-0.5">Ketik nama taruna, pilih semester. Jika nilai semester tersebut sudah ada, akan diperbarui.</p>
            </div>

            <form method="POST" action="{{ route('nilai-taruna.store') }}" id="nilaiForm">
                @csrf
                <div class="grid grid-cols-2 sm:grid-cols-6 gap-4 mb-4">
                    <div class="col-span-2">
                        <label for="namaTaruna" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Nama Taruna</label>
                        <input type="text" id="namaTaruna" list="daftarTaruna" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none"
                               placeholder="Ketik nama taruna..." value="{{ old('nama') }}" autocomplete="off" required>
                        <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                        <div class="flex items-center gap-2 mt-2" id="infoTaruna" style="display:none;">
                            <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 font-bold text-[10px]" id="infoProdi"></span>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[10px]" id="infoTingkat"></span>
                        </div>
                    </div>
                    <div>
                        <label for="semester" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Semester</label>
                        <select name="semester" id="semester" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none" required>
                            @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" @selected(old('semester') == $i)>Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="ips" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">IPS (0–4)</label>
                        <input type="number" name="ips" id="ips" step="0.01" min="0" max="4" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none"
                               placeholder="3.45" value="{{ old('ips') }}" required>
                    </div>
                    <div>
                        <label for="samapta" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Samapta (0–100)</label>
                        <input type="number" name="samapta" id="samapta" step="0.01" min="0" max="100" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none"
                               placeholder="85" value="{{ old('samapta') }}" required>
                    </div>
                    <div>
                        <label for="pengasuhan" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Pengasuhan (0–100)</label>
                        <input type="number" name="pengasuhan" id="pengasuhan" step="0.01" min="0" max="100" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none"
                               placeholder="90" value="{{ old('pengasuhan') }}" required>
                    </div>
                    <div class="col-span-2 sm:col-span-6">
                        <label for="keterangan" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Keterangan (opsional)</label>
                        <textarea name="keterangan" id="keterangan" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-medium text-slate-800 outline-none"
                                  placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <datalist id="daftarTaruna">
                    @foreach($daftarTaruna as $t)
                    <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                    @endforeach
                </datalist>

                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white font-extrabold text-xs shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Nilai</span>
                </button>
            </form>
        </div>

        {{-- Daftar Nilai --}}
        <div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-table-list text-emerald-500 text-sm"></i>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800">Daftar Nilai Terinput ({{ $daftarNilai->count() }})</h3>
                </div>
                <form method="GET" action="{{ route('nilai-taruna.index') }}" class="flex items-center gap-2">
                    <select name="mahasiswa_id" class="px-3 py-2 rounded-xl bg-white/70 border border-white/80 text-xs font-semibold text-slate-800 outline-none" onchange="this.form.submit()">
                        <option value="">Semua taruna</option>
                        @foreach($daftarTaruna as $t)
                        <option value="{{ $t->id }}" @selected($filterId == $t->id)>{{ $t->nama }}</option>
                        @endforeach
                    </select>
                    @if($filterId)
                    <a href="{{ route('nilai-taruna.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 no-underline">Reset</a>
                    @endif
                </form>
            </div>
            <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg overflow-x-auto">
                @if($daftarNilai->isEmpty())
                <div class="text-center py-8 text-slate-400">
                    <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                    <span class="font-semibold text-xs">Belum ada nilai yang diinput.</span>
                </div>
                @else
                <table class="w-full text-xs">
                    <thead>
                        <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200/70">
                            <th class="text-left py-2 pr-3">Taruna</th>
                            <th class="text-left py-2 pr-3">Prodi / Tk</th>
                            <th class="text-center py-2 px-3">Smt</th>
                            <th class="text-center py-2 px-3">IPS</th>
                            <th class="text-center py-2 px-3">Samapta</th>
                            <th class="text-center py-2 px-3">Pengasuhan</th>
                            <th class="text-left py-2 px-3">Keterangan</th>
                            <th class="text-left py-2 px-3">Diinput</th>
                            <th class="py-2 pl-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftarNilai as $n)
                        <tr class="border-b border-slate-100/70 hover:bg-white/40">
                            <td class="py-2.5 pr-3 font-bold text-slate-800">{{ $n->mahasiswa->nama }}<div class="text-[10px] font-medium text-slate-400">{{ $n->mahasiswa->npm }}</div></td>
                            <td class="py-2.5 pr-3 text-slate-600">{{ $n->mahasiswa->prodi }} / {{ $n->mahasiswa->tingkat }}</td>
                            <td class="py-2.5 px-3 text-center font-bold text-slate-700">{{ $n->semester }}</td>
                            <td class="py-2.5 px-3 text-center font-mono font-bold text-indigo-700">{{ number_format($n->ips, 2) }}</td>
                            <td class="py-2.5 px-3 text-center font-mono font-bold text-emerald-700">{{ number_format($n->samapta, 2) }}</td>
                            <td class="py-2.5 px-3 text-center font-mono font-bold text-amber-700">{{ number_format($n->pengasuhan, 2) }}</td>
                            <td class="py-2.5 px-3 text-slate-500 max-w-[220px] truncate">{{ $n->keterangan ?: '-' }}</td>
                            <td class="py-2.5 px-3 text-slate-500">{{ $n->penginput->name ?? '-' }}<div class="text-[10px] text-slate-400">{{ $n->updated_at->format('d/m/Y') }}</div></td>
                            <td class="py-2.5 pl-3 text-right">
                                <form method="POST" action="{{ route('nilai-taruna.destroy', $n) }}" id="hapus-{{ $n->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="px-2.5 py-1.5 rounded-lg bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold text-[10px] transition"
                                            onclick="bukaHapusModal('hapus-{{ $n->id }}', @js($n->mahasiswa->nama . ' semester ' . $n->semester))">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

    </div>
</main>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal-overlay" id="hapusModal">
    <div class="modal-box">
        <h3 class="text-rose-600 mb-2"><i class="fa-solid fa-triangle-exclamation text-2xl"></i></h3>
        <p id="hapusModalNama" class="text-xs font-bold text-slate-800 mb-4"></p>
        <div class="flex items-center justify-center gap-2">
            <button type="button" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition" onclick="tutupHapusModal()">Batal</button>
            <button type="button" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md transition" onclick="submitHapus()">Ya, Hapus</button>
        </div>
    </div>
</div>

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
if (namaEl.value.trim()) cocokkanTaruna();

document.getElementById('nilaiForm').addEventListener('submit', function(e) {
    if (!document.getElementById('mahasiswaId').value) {
        e.preventDefault();
        namaEl.focus();
        alert('Pilih nama taruna yang cocok dari daftar (ketik lalu pilih dari saran).');
    }
});

let hapusFormId = null;
function bukaHapusModal(formId, nama) {
    hapusFormId = formId;
    document.getElementById('hapusModalNama').textContent = 'Hapus nilai ' + nama + '?';
    document.getElementById('hapusModal').classList.add('open');
}
function tutupHapusModal() {
    document.getElementById('hapusModal').classList.remove('open');
    hapusFormId = null;
}
function submitHapus() {
    if (hapusFormId) document.getElementById(hapusFormId).submit();
}
document.getElementById('hapusModal').addEventListener('click', function(e) {
    if (e.target === this) tutupHapusModal();
});
</script>

</x-app-layout>
