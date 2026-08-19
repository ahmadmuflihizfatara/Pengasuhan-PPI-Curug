<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Page Header --}}
                <div class="rounded-2xl bg-gradient-to-r from-rose-900/90 via-orange-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-amber-300 mb-2">
                            <span>✦</span>
                            <span>Manajemen Disiplin &amp; Asrama</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-user-lock text-rose-400"></i>
                            <span>Data Konsinyir Taruna</span>
                        </h1>
                        <p class="text-xs text-rose-100/80">Pencatatan taruna yang menjalani masa konsinyir kampus — sinkron otomatis ke database mahasiswa</p>
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
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                        <span>Terdapat kendala validasi:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs font-normal">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                {{-- Form Tambah Konsinyir --}}
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-5 sm:p-6 mb-6 shadow-lg">
                    <div class="pb-3.5 mb-4 border-b border-white/30">
                        <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-user-plus text-rose-500"></i>
                            <span>Tambah Data Konsinyir Baru</span>
                        </h2>
                        <p class="text-[11px] text-slate-500 mt-0.5">Ketik nama taruna — program studi &amp; tingkat akan terisi otomatis.</p>
                    </div>

                    <form method="POST" action="{{ route('konsinyir.store') }}" id="konsinyirForm">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                            <div class="sm:col-span-1">
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
                                <label for="tanggalMulai" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggalMulai" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none"
                                       value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                            </div>
                            <div>
                                <label for="lamaHari" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Lama Konsinyir (Hari)</label>
                                <input type="number" name="lama_hari" id="lamaHari" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none"
                                       min="1" max="365" placeholder="Contoh: 3" value="{{ old('lama_hari') }}" required>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="keterangan" class="text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5 block">Keterangan / Alasan Konsinyir</label>
                                <textarea name="keterangan" id="keterangan" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-medium text-slate-800 outline-none"
                                          placeholder="Tuliskan rincian alasan konsinyir...">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>

                        <datalist id="daftarTaruna">
                            @foreach($daftarTaruna as $t)
                            <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                            @endforeach
                        </datalist>

                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-orange-500 hover:from-rose-700 hover:to-orange-600 text-white font-extrabold text-xs shadow-md transition flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Konsinyir</span>
                        </button>
                    </form>
                </div>

                {{-- Sedang Konsinyir Section --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-user-clock text-rose-500 text-sm"></i>
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-800">Sedang Menjalani Konsinyir ({{ $aktif->count() }})</h3>
                    </div>
                    <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg overflow-hidden">
                        @if($aktif->isEmpty())
                        <div class="text-center py-8 text-slate-500">
                            <i class="fa-solid fa-circle-check text-3xl text-emerald-500 mb-2 block"></i>
                            <span class="font-semibold text-xs">Tidak ada taruna yang sedang menjalani konsinyir saat ini.</span>
                        </div>
                        @else
                        @include('konsinyir._tabel', ['daftar' => $aktif])
                        @endif
                    </div>
                </div>

                {{-- Riwayat Konsinyir Section --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-clock-rotate-left text-slate-500 text-sm"></i>
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-700">Riwayat Konsinyir Selesai ({{ $riwayat->count() }})</h3>
                    </div>
                    <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg overflow-hidden">
                        @if($riwayat->isEmpty())
                        <div class="text-center py-8 text-slate-400">
                            <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                            <span class="font-semibold text-xs">Belum ada riwayat konsinyir terdahulu.</span>
                        </div>
                        @else
                        @include('konsinyir._tabel', ['daftar' => $riwayat])
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

document.getElementById('konsinyirForm').addEventListener('submit', function(e) {
    if (!document.getElementById('mahasiswaId').value) {
        e.preventDefault();
        namaEl.focus();
        alert('Pilih nama taruna yang cocok dari daftar (ketik lalu pilih dari saran).');
    }
});

let hapusFormId = null;
function bukaHapusModal(formId, nama) {
    hapusFormId = formId;
    document.getElementById('hapusModalNama').textContent = 'Hapus data konsinyir ' + nama + '?';
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
