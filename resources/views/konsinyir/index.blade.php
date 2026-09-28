<x-app-layout>
{{-- Form memakai gaya yang sama dengan form Surat, Reward & Apel --}}
<x-form-glass-style />

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

                    /* Form tambah */
                    .konsinyir-form { margin-bottom: var(--space-4); }
                    .konsinyir-form .ds-error { font-size: 11px; }
                    .konsinyir-form .form-control.is-invalid { border-color: var(--danger); }
                    .konsinyir-form textarea.form-control { resize: vertical; min-height: 84px; }
                    .konsinyir-info { display: none; gap: var(--space-1-5); margin-top: var(--space-2); }
                    .konsinyir-simpan { width: auto; padding-left: var(--space-8, 32px); padding-right: var(--space-8, 32px); }
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
                <div class="form-card konsinyir-form">
                    <div class="form-section-title">
                        <span><i class="fa-solid fa-user-plus me-2" style="color:var(--accent)"></i> Tambah Data Konsinyir Baru</span>
                        <span class="ds-badge ds-badge--accent"><i class="fa-regular fa-clock"></i> Waktu: {{ now()->format('d/m/Y H:i') }}</span>
                    </div>

                    <form method="POST" action="{{ route('konsinyir.store') }}" id="konsinyirForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <label class="form-label" for="namaTaruna">Nama Taruna <span class="req">*</span></label>
                                <input type="text" id="namaTaruna" list="daftarTaruna"
                                       class="form-control @error('mahasiswa_id') is-invalid @enderror"
                                       placeholder="Ketik nama lalu pilih dari saran" value="{{ $daftarTaruna->firstWhere('id', old('mahasiswa_id'))?->nama }}" autocomplete="off" required>
                                <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                                @error('mahasiswa_id')<div class="ds-error">{{ $message }}</div>@enderror
                                <div class="ds-error" id="namaTarunaError" role="alert" hidden><i class="fa-solid fa-circle-exclamation"></i> Pilih nama taruna yang cocok dari daftar saran.</div>
                                <div class="konsinyir-info" id="infoTaruna">
                                    <span class="ds-badge ds-badge--info" id="infoProdi"></span>
                                    <span class="ds-badge ds-badge--success" id="infoTingkat"></span>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="form-label" for="tanggalMulai">Tanggal Mulai <span class="req">*</span></label>
                                <input type="date" name="tanggal_mulai" id="tanggalMulai"
                                       class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                       value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                                @error('tanggal_mulai')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-label" for="lamaHari">Lama (Hari) <span class="req">*</span></label>
                                <input type="number" name="lama_hari" id="lamaHari"
                                       class="form-control @error('lama_hari') is-invalid @enderror"
                                       min="1" max="365" placeholder="Contoh: 3" value="{{ old('lama_hari') }}" required>
                                @error('lama_hari')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="keterangan">Keterangan / Alasan Konsinyir</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                      class="form-control @error('keterangan') is-invalid @enderror"
                                      placeholder="Tuliskan rincian alasan konsinyir...">{{ old('keterangan') }}</textarea>
                            <small class="form-help"><i class="fa-solid fa-circle-info"></i> Program studi &amp; tingkat terisi otomatis dari database mahasiswa setelah nama dipilih.</small>
                            @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
                        </div>

                        <datalist id="daftarTaruna">
                            @foreach($daftarTaruna as $t)
                            <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                            @endforeach
                        </datalist>

                        <button type="submit" class="btn-submit-log konsinyir-simpan">
                            <i class="fa-solid fa-floppy-disk"></i> SIMPAN KONSINYIR
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
<x-konfirmasi-modal />

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

// Nama harus cocok dengan database — tampilkan pesan di bawah kolom (bukan alert bawaan browser)
const namaError = document.getElementById('namaTarunaError');
namaEl.addEventListener('input', () => { namaError.hidden = true; namaEl.removeAttribute('aria-invalid'); });
document.getElementById('konsinyirForm').addEventListener('submit', function(e) {
    if (!document.getElementById('mahasiswaId').value) {
        e.preventDefault();
        namaError.hidden = false;
        namaEl.setAttribute('aria-invalid', 'true');
        namaEl.focus();
    }
});
</script>
@endunless

</x-app-layout>
