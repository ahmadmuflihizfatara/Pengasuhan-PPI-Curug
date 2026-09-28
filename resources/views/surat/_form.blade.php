{{-- Form surat pengasuh (tambah & ubah). $surat = null untuk tambah. Gaya dari <x-form-glass-style /> --}}
@php $isEdit = (bool) $surat; @endphp
<style>
    .sr-opt { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    .sr-subjudul { display: flex; align-items: center; gap: var(--space-2); margin: var(--space-2) 0 var(--space-3); padding-top: var(--space-4); border-top: 1px solid var(--border-glass-subtle); font-size: 12px; line-height: 16px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: var(--ink-700); }
    .sr-subjudul i { color: var(--accent); }
    .form-group .ds-error { font-size: 11px; }
    textarea.form-control { resize: vertical; min-height: 90px; }
    .sr-file-lama { display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-2); padding: var(--space-2) var(--space-3); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); font-size: 12px; font-weight: 700; color: var(--ink-800); }
    .sr-file-lama i { color: var(--accent); }
    .sr-file-lama span { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sr-tombol { display: flex; gap: var(--space-2-5); margin-top: var(--space-2); }
    .sr-tombol .btn-submit-log { flex: 1; }
    .sr-tombol .ds-btn { padding-left: var(--space-5); padding-right: var(--space-5); }
</style>

<div class="form-card">
    <form method="POST" action="{{ $isEdit ? route('surat.update', $surat->id) : route('surat.store') }}" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="form-section-title">
            <span><i class="fa-solid {{ $isEdit ? 'fa-pen-to-square' : 'fa-envelope-open-text' }} me-2" style="color:var(--accent)"></i> {{ $isEdit ? 'Ubah Data Surat' : 'Isi Form Surat Baru' }}</span>
            <span class="ds-badge ds-badge--accent"><i class="fa-regular fa-clock"></i> Waktu: {{ now()->format('d/m/Y H:i') }}</span>
        </div>

        {{-- Informasi surat --}}
        <div class="row">
            <div class="col-md-5 form-group">
                <label class="form-label" for="nomorSurat">Nomor Surat <span class="sr-opt">(opsional)</span></label>
                <input type="text" id="nomorSurat" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $surat?->nomor_surat) }}" placeholder="Contoh: 001/PPI/III/2026">
                @error('nomor_surat')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-7 form-group">
                <label class="form-label" for="jenisSurat">Jenis Surat <span class="req">*</span></label>
                <select id="jenisSurat" name="jenis_surat" class="form-select" required>
                    @unless($isEdit)<option value="">-- Pilih Jenis Surat --</option>@endunless
                    @foreach($jenisList as $j)
                    <option value="{{ $j }}" @selected(old('jenis_surat', $surat?->jenis_surat) === $j)>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jenis_surat')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="perihal">Perihal <span class="req">*</span></label>
            <input type="text" id="perihal" name="perihal" class="form-control" value="{{ old('perihal', $surat?->perihal) }}" placeholder="Tuliskan perihal surat..." required>
            @error('perihal')<div class="ds-error">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="form-label" for="pengirim">Pengirim <span class="req">*</span></label>
                <input type="text" id="pengirim" name="pengirim" class="form-control" value="{{ old('pengirim', $surat?->pengirim) }}" placeholder="Nama pengirim / instansi..." required>
                @error('pengirim')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="penerima">Penerima <span class="req">*</span></label>
                <input type="text" id="penerima" name="penerima" class="form-control" value="{{ old('penerima', $surat?->penerima) }}" placeholder="Nama penerima / instansi..." required>
                @error('penerima')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="form-label" for="tanggalSurat">Tanggal Surat <span class="req">*</span></label>
                <input type="date" id="tanggalSurat" name="tanggal_surat" class="form-control" value="{{ old('tanggal_surat', $surat?->tanggal_surat?->format('Y-m-d') ?? date('Y-m-d')) }}" required>
                @error('tanggal_surat')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="tanggalTerima">Tanggal Diterima <span class="sr-opt">(opsional)</span></label>
                <input type="date" id="tanggalTerima" name="tanggal_terima" class="form-control" value="{{ old('tanggal_terima', $surat?->tanggal_terima?->format('Y-m-d')) }}">
                @error('tanggal_terima')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Status & lampiran --}}
        <div class="sr-subjudul"><i class="fa-solid fa-paperclip"></i> Status &amp; Lampiran</div>

        <div class="row">
            <div class="col-md-5 form-group">
                <label class="form-label" for="statusSurat">Status <span class="req">*</span></label>
                <select id="statusSurat" name="status" class="form-select" required>
                    @foreach($statusList as $st)
                    <option value="{{ $st }}" @selected(old('status', $surat?->status ?? 'Diproses') === $st)>{{ $st }}</option>
                    @endforeach
                </select>
                @error('status')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-7 form-group">
                <label class="form-label" for="fileSurat">{{ $isEdit ? 'Ganti Dokumen' : 'Upload Dokumen' }} <span class="sr-opt">(opsional)</span></label>
                @if($isEdit && $surat->file_path)
                <div class="sr-file-lama">
                    <i class="fa-solid fa-file"></i>
                    <span>{{ basename($surat->file_path) }}</span>
                    <a href="{{ Storage::url($surat->file_path) }}" target="_blank" rel="noopener" class="ds-btn ds-btn--xs">Lihat</a>
                </div>
                @endif
                <input type="file" id="fileSurat" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <small class="form-help"><i class="fa-solid fa-circle-info"></i> PDF, Word, atau gambar · maks. 5MB{{ $isEdit ? ' · biarkan kosong jika dokumen tidak diganti' : '' }}.</small>
                @error('file')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="keteranganSurat">Keterangan <span class="sr-opt">(opsional)</span></label>
            <textarea id="keteranganSurat" name="keterangan" class="form-control" placeholder="Catatan tambahan atau keterangan surat...">{{ old('keterangan', $surat?->keterangan) }}</textarea>
            @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
        </div>

        <div class="sr-tombol">
            <a href="{{ $isEdit ? route('surat.show', $surat->id) : route('surat.index') }}" class="ds-btn"><i class="fa-solid fa-xmark"></i> Batal</a>
            <button type="submit" class="btn-submit-log"><i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'SIMPAN PERUBAHAN' : 'SIMPAN SURAT' }}</button>
        </div>
    </form>
</div>
