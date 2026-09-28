{{-- Form acara pengasuh (tambah & ubah). $acara = null untuk tambah. Gaya dari <x-form-glass-style /> --}}
@php $isEdit = (bool) $acara; @endphp
<style>
    .ac-opt { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    .form-group .ds-error { font-size: 11px; }
    textarea.form-control { resize: vertical; min-height: 100px; }
    .ac-tombol { display: flex; gap: var(--space-2-5); margin-top: var(--space-2); }
    .ac-tombol .btn-submit-log { flex: 1; }
    .ac-tombol .ds-btn { padding-left: var(--space-5); padding-right: var(--space-5); }
</style>

<div class="form-card">
    <form method="POST" action="{{ $isEdit ? route('acara.update', $acara->id) : route('acara.store') }}">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="form-section-title">
            <span><i class="fa-solid {{ $isEdit ? 'fa-pen-to-square' : 'fa-calendar-plus' }} me-2" style="color:var(--accent)"></i> {{ $isEdit ? 'Ubah Data Acara' : 'Isi Form Acara Baru' }}</span>
            @if($isEdit)
            <span class="ds-badge ds-badge--accent"><i class="fa-regular fa-calendar"></i> {{ $acara->tanggal->locale('id')->isoFormat('D MMM Y') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="namaAcara">Nama Acara <span class="req">*</span></label>
            <input type="text" id="namaAcara" name="nama_acara" class="form-control" value="{{ old('nama_acara', $acara?->nama_acara) }}" placeholder="Contoh: Kuliah Umum Build With AI" required>
            @error('nama_acara')<div class="ds-error">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="form-label" for="tanggalAcara">Tanggal <span class="req">*</span></label>
                <input type="date" id="tanggalAcara" name="tanggal" class="form-control" value="{{ old('tanggal', $acara?->tanggal->format('Y-m-d')) }}" required>
                @error('tanggal')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="jamAcara">Jam <span class="req">*</span></label>
                <input type="time" id="jamAcara" name="jam" class="form-control" value="{{ old('jam', $acara ? \Carbon\Carbon::parse($acara->jam)->format('H:i') : null) }}" required>
                @error('jam')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="keteranganAcara">Keterangan <span class="ac-opt">(opsional)</span></label>
            <textarea id="keteranganAcara" name="keterangan" class="form-control" placeholder="Deskripsi singkat mengenai acara ini...">{{ old('keterangan', $acara?->keterangan) }}</textarea>
            @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
        </div>

        <div class="ac-tombol">
            <a href="{{ route('acara.index') }}" class="ds-btn"><i class="fa-solid fa-xmark"></i> Batal</a>
            <button type="submit" class="btn-submit-log"><i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'SIMPAN PERUBAHAN' : 'SIMPAN ACARA' }}</button>
        </div>
    </form>
</div>
