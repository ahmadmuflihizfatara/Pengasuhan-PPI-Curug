<x-app-layout>
{{-- Form memakai gaya yang sama dengan form Log Gerbang --}}
<x-form-glass-style />
<style>
    .keluhan-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .keluhan-kembali:hover { color: var(--accent-ink); }
    .form-control[readonly] { color: var(--ink-600); cursor: not-allowed; }
    .form-group .ds-error { font-size: 11px; }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Ajukan Keluhan Barak" icon="fa-door-open"
            subtitle="Laporkan kerusakan atau kendala di barak Anda kepada satuan pengasuhan" />

        <a href="{{ route('keluhan-barak.index') }}" class="ds-btn ds-btn--pill keluhan-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Keluhan
        </a>

        @if($errors->any())
        <x-glass-alert type="danger" title="Keluhan belum terkirim">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        <div class="form-card">
            <form method="POST" action="{{ route('keluhan-barak.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-section-title">
                    <span><i class="fas fa-door-open text-danger me-2"></i> Isi Form Keluhan Barak</span>
                    <span class="ds-badge ds-badge--accent">
                        <i class="far fa-clock"></i> Waktu: {{ now()->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="namaPengaju">Nama Taruna</label>
                        <input type="text" id="namaPengaju" class="form-control" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="emailPengaju">Email</label>
                        <input type="text" id="emailPengaju" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="tanggalPengajuan">Tanggal Pengajuan <span class="req">*</span></label>
                        <input type="date" id="tanggalPengajuan" name="tanggal_pengajuan" class="form-control"
                               value="{{ old('tanggal_pengajuan', now()->toDateString()) }}" required>
                        @error('tanggal_pengajuan')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="prodiSelect">Program Studi <span class="req">*</span></label>
                        <select id="prodiSelect" name="prodi" class="form-select" required>
                            @foreach($prodiList as $kode => $info)
                                <option value="{{ $kode }}" {{ old('prodi', $user->prodi) === $kode ? 'selected' : '' }}>
                                    {{ $kode }} — {{ $info['nama'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="asramaSelect">Asrama <span class="req">*</span></label>
                        <select name="asrama" id="asramaSelect" class="form-select" required>
                            <option value="">-- Pilih Asrama --</option>
                            @foreach($asramaList as $a)
                                <option value="{{ $a }}" {{ old('asrama') === $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                        @error('asrama')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="lorongSelect">Lorong <span class="req">*</span></label>
                        <select name="lorong" id="lorongSelect" class="form-select" data-current="{{ old('lorong') }}" required>
                            <option value="">-- Pilih Lorong --</option>
                        </select>
                        @error('lorong')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="nomorBarak">Nomor Barak <span class="req">*</span></label>
                        <input type="text" id="nomorBarak" name="nomor_barak" value="{{ old('nomor_barak') }}" required
                               placeholder="Contoh: 12" class="form-control">
                        @error('nomor_barak')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="keteranganKeluhan">Keterangan Keluhan <span class="req">*</span></label>
                    <textarea id="keteranganKeluhan" name="keterangan" class="form-control" rows="3" required
                              placeholder="Jelaskan keluhan secara singkat dan jelas, misalnya kerusakan lampu, kunci, plafon, atau fasilitas lainnya...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="lampiran">Lampiran Foto / Dokumen (Opsional)</label>
                    <input type="file" id="lampiran" name="lampiran[]" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                    <small class="form-help"><i class="fas fa-paperclip"></i> Maks. 5 file · 5MB per file · JPG, PNG, PDF, DOC, DOCX. Keluhan akan diproses pengasuhan dan Anda mendapat notifikasi saat statusnya berubah.</small>
                    @error('lampiran.*')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-submit-log">
                    <i class="fas fa-paper-plane"></i> KIRIM KELUHAN
                </button>
            </form>
        </div>

    </div>
</main>

<script>
const LORONG = @json(\App\Models\KeluhanBarak::LORONG);
const asramaSelect = document.getElementById('asramaSelect');
const lorongSelect = document.getElementById('lorongSelect');

function updateLorong() {
    const options = LORONG[asramaSelect.value] || [];
    const current = lorongSelect.dataset.current || '';
    lorongSelect.innerHTML = '<option value="">-- Pilih Lorong --</option>' +
        options.map(o => `<option value="${o}" ${current === o ? 'selected' : ''}>${o}</option>`).join('');
}

asramaSelect.addEventListener('change', updateLorong);
updateLorong();
</script>
</x-app-layout>
