<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Header — sama dengan header tab poin & log gerbang --}}
                <x-page-banner title="Data Konsinyir Taruna" icon="fa-user-lock"
                    :subtitle="auth()->user()->hasTarunaAccess()
                        ? 'Daftar taruna yang sedang menjalani masa konsinyir kampus.'
                        : 'Pencatatan taruna yang menjalani masa konsinyir kampus — sinkron otomatis ke database mahasiswa.'" />
                <style>
                    .ds-table tr.konsinyir-saya { background: var(--accent-tint); }

                    /* Form tambah — teks sedikit dinaikkan agar mudah dibaca */
                    .konsinyir-form { background: var(--glass-card); }
                    .konsinyir-form .ds-card__desc { font-size: 12px; line-height: 16px; }
                    .konsinyir-form .ds-label { font-size: 11px; color: var(--ink-900); }
                    .konsinyir-form .ds-input, .konsinyir-form .ds-textarea { font-size: 13px; line-height: 18px; background: var(--glass-solid); }
                    .konsinyir-form .ds-textarea { resize: vertical; }
                </style>

                {{-- Alerts --}}
                @if(session('success'))
                <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
                @endif
                @if($errors->any())
                <x-glass-alert type="danger" title="Data konsinyir belum tersimpan">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </x-glass-alert>
                @endif

                @unless(auth()->user()->hasTarunaAccess())
                {{-- Form Tambah Konsinyir --}}
                <div class="ds-card konsinyir-form mb-6">
                    <div class="ds-card__head">
                        <h2 class="ds-card__title"><i class="fa-solid fa-user-plus ds-icon"></i> Tambah Data Konsinyir Baru</h2>
                        <p class="ds-card__desc">Ketik nama taruna lalu pilih dari saran — program studi &amp; tingkat akan terisi otomatis.</p>
                    </div>

                    <form method="POST" action="{{ route('konsinyir.store') }}" id="konsinyirForm">
                        @csrf
                        <div class="ds-form-grid ds-form-grid--3 mb-4">
                            <div>
                                <label for="namaTaruna" class="ds-label">Nama Taruna <span style="color:var(--danger-ink)">*</span></label>
                                <input type="text" id="namaTaruna" list="daftarTaruna"
                                       class="ds-input @error('mahasiswa_id') ds-input--invalid @enderror"
                                       placeholder="Ketik nama taruna..." value="{{ $daftarTaruna->firstWhere('id', old('mahasiswa_id'))?->nama }}" autocomplete="off" required>
                                <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                                @error('mahasiswa_id')<div class="ds-error">{{ $message }}</div>@enderror
                                <div class="flex items-center gap-2 mt-2" id="infoTaruna" style="display:none;">
                                    <span class="ds-badge ds-badge--info" id="infoProdi"></span>
                                    <span class="ds-badge ds-badge--success" id="infoTingkat"></span>
                                </div>
                            </div>
                            <div>
                                <label for="tanggalMulai" class="ds-label">Tanggal Mulai <span style="color:var(--danger-ink)">*</span></label>
                                <input type="date" name="tanggal_mulai" id="tanggalMulai"
                                       class="ds-input @error('tanggal_mulai') ds-input--invalid @enderror"
                                       value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                                @error('tanggal_mulai')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="lamaHari" class="ds-label">Lama Konsinyir (Hari) <span style="color:var(--danger-ink)">*</span></label>
                                <input type="number" name="lama_hari" id="lamaHari"
                                       class="ds-input @error('lama_hari') ds-input--invalid @enderror"
                                       min="1" max="365" placeholder="Contoh: 3" value="{{ old('lama_hari') }}" required>
                                @error('lama_hari')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="ds-span-all">
                                <label for="keterangan" class="ds-label">Keterangan / Alasan Konsinyir</label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                          class="ds-textarea @error('keterangan') ds-input--invalid @enderror"
                                          placeholder="Tuliskan rincian alasan konsinyir...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <datalist id="daftarTaruna">
                            @foreach($daftarTaruna as $t)
                            <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                            @endforeach
                        </datalist>

                        <button type="submit" class="ds-btn ds-btn--primary">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Konsinyir
                        </button>
                    </form>
                </div>
                @endunless

                {{-- Sedang Konsinyir Section --}}
                <div class="ds-card mb-6">
                    <div class="ds-card__head tbl-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-user-lock ds-icon"></i> Sedang Menjalani Konsinyir</h3>
                            <p class="ds-card__desc">Per {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                        </div>
                        <span class="ds-badge {{ $aktif->isEmpty() ? 'ds-badge--success' : 'ds-badge--danger' }}">{{ $aktif->count() }} taruna</span>
                    </div>
                    @if($aktif->isEmpty())
                    <div class="ds-empty">
                        <i class="fa-solid fa-circle-check ds-icon"></i>
                        Tidak ada taruna yang sedang menjalani konsinyir saat ini.
                    </div>
                    @else
                    @include('konsinyir._tabel', ['daftar' => $aktif])
                    @endif
                </div>

                {{-- Riwayat Konsinyir Section — taruna hanya lihat yang sedang aktif --}}
                @unless(auth()->user()->hasTarunaAccess())
                <div class="ds-card">
                    <div class="ds-card__head tbl-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-clock-rotate-left ds-icon"></i> Riwayat Konsinyir Selesai</h3>
                            <p class="ds-card__desc">Konsinyir yang masa berlakunya sudah berakhir</p>
                        </div>
                        <span class="ds-badge">{{ $riwayat->count() }} data</span>
                    </div>
                    @if($riwayat->isEmpty())
                    <div class="ds-empty">
                        <i class="fa-solid fa-inbox ds-icon"></i>
                        Belum ada riwayat konsinyir terdahulu.
                    </div>
                    @else
                    @include('konsinyir._tabel', ['daftar' => $riwayat])
                    @endif
                </div>
                @endunless

    </div>
</main>

@unless(auth()->user()->hasTarunaAccess())
{{-- Modal Konfirmasi Hapus --}}
<div class="ds-modal-overlay" id="hapusModal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="hapusModalJudul">
    <div class="ds-modal">
        <div class="ds-modal__icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h3 class="ds-modal__title" id="hapusModalJudul">Hapus Data Konsinyir?</h3>
        <p class="ds-modal__body" id="hapusModalNama"></p>
        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" onclick="tutupHapusModal()">Batal</button>
            <button type="button" class="ds-btn ds-btn--primary" style="background:var(--danger);" onclick="submitHapus()"><i class="fa-solid fa-trash"></i> Ya, Hapus</button>
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
    document.getElementById('hapusModalNama').textContent = 'Data konsinyir ' + nama + ' akan dihapus permanen.';
    document.getElementById('hapusModal').style.display = 'flex';
}
function tutupHapusModal() {
    document.getElementById('hapusModal').style.display = 'none';
    hapusFormId = null;
}
function submitHapus() {
    if (hapusFormId) document.getElementById(hapusFormId).submit();
}
document.getElementById('hapusModal').addEventListener('click', function(e) {
    if (e.target === this) tutupHapusModal();
});
</script>
@endunless

</x-app-layout>
