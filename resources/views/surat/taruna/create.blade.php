<x-app-layout>
{{-- Form memakai gaya yang sama dengan form Log Gerbang & Keluhan Barak --}}
<x-form-glass-style />
<style>
    .surat-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .surat-kembali:hover { color: var(--accent-ink); }
    .form-control[readonly] { color: var(--ink-600); cursor: not-allowed; }
    .form-group .ds-error { font-size: 11px; }
    .form-label .opt { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    textarea.form-control { resize: vertical; min-height: 96px; }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Ajukan Permohonan Surat" icon="fa-file-signature"
            subtitle="Isi formulir berikut untuk mengajukan permohonan surat kepada satuan pengasuhan" />

        <a href="{{ route('surat-taruna.index') }}" class="ds-btn ds-btn--pill surat-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengajuan
        </a>

        @if($errors->any())
        <x-glass-alert type="danger" title="Permohonan belum terkirim">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        <div class="form-card">
            <form method="POST" action="{{ route('surat-taruna.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-section-title">
                    <span><i class="fas fa-file-signature me-2" style="color:var(--accent)"></i> Isi Form Permohonan Surat</span>
                    <span class="ds-badge ds-badge--accent">
                        <i class="far fa-clock"></i> Waktu: {{ now()->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="namaPengaju">Nama Pengaju</label>
                        <input type="text" id="namaPengaju" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="ditujukan">Ditujukan Kepada</label>
                        <input type="text" id="ditujukan" class="form-control" value="Satuan Pengasuhan" readonly>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="tanggalPengajuan">Tanggal Pengajuan</label>
                        <input type="text" id="tanggalPengajuan" class="form-control" value="{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="jenisSurat">Jenis Surat <span class="req">*</span></label>
                        <select id="jenisSurat" name="jenis_surat" class="form-select" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($jenisList as $j)
                                <option value="{{ $j }}" {{ old('jenis_surat') === $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jenis_surat')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-8 form-group">
                        <label class="form-label" for="perihal">Perihal / Subjek Surat <span class="req">*</span></label>
                        <input type="text" id="perihal" name="perihal" value="{{ old('perihal') }}" required
                               placeholder="Contoh: Permohonan Izin Kegiatan Luar Komplek" class="form-control">
                        @error('perihal')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan / Alasan Pengajuan <span class="opt">(opsional)</span></label>
                    <textarea id="keterangan" name="keterangan" class="form-control" rows="3"
                              placeholder="Jelaskan keperluan dan alasan pengajuan surat secara singkat...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="file">Dokumen Pendukung <span class="opt">(opsional)</span></label>
                    <input type="file" id="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <small class="form-help"><i class="fas fa-paperclip"></i> Maks. 5MB · PDF, DOC, DOCX, JPG, PNG. Pengajuan akan diproses pengasuhan dan Anda mendapat notifikasi saat surat disetujui atau ditolak.</small>
                    @error('file')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-submit-log">
                    <i class="fas fa-paper-plane"></i> KIRIM PERMOHONAN
                </button>
            </form>
        </div>

    </div>
</main>
</x-app-layout>
