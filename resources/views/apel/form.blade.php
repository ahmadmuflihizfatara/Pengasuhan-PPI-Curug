@php
    $isEdit = $apel->exists;
@endphp

<x-app-layout>
{{-- Form memakai gaya yang sama dengan form Log Gerbang, Surat & Reward --}}
<x-form-glass-style />
<style>
    .ap-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .ap-kembali:hover { color: var(--accent-ink); }
    .form-group .ds-error { font-size: 11px; }
    .form-label .opt { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    textarea.form-control { resize: vertical; min-height: 96px; line-height: 1.6; }
    .form-control.is-invalid, .form-select.is-invalid { border-color: var(--danger); }
    .form-control[readonly] { color: var(--ink-600); background-color: var(--glass-subtle); cursor: not-allowed; }
    .ap-subjudul { display: flex; align-items: center; gap: var(--space-2); margin: var(--space-5) 0 var(--space-3); padding-top: var(--space-4); border-top: 1px solid var(--border-glass-subtle); font-size: 12px; line-height: 16px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: var(--ink-700); }
    .ap-subjudul i { color: var(--accent); }

    /* Pilihan jenis apel — kartu kaca seperti pilihan jenis pengajuan reward */
    .sesi-options { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-3); }
    .sesi-option input { position: absolute; opacity: 0; pointer-events: none; }
    .sesi-option label {
        display: flex; flex-direction: column; align-items: center; gap: var(--space-1); height: 100%;
        padding: var(--space-3-5) var(--space-2); border-radius: var(--radius-md); text-align: center; cursor: pointer;
        background: var(--glass-card); border: 1.5px solid var(--border-glass-glow);
        font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-700);
        transition: background-color .15s, border-color .15s, box-shadow .15s, color .15s;
    }
    .sesi-option label i { font-size: 18px; color: var(--ink-500); margin-bottom: var(--space-1); }
    .sesi-option label small { font-size: 10px; line-height: 14px; font-weight: 600; color: var(--ink-600); }
    .sesi-option label:hover { background: var(--glass-solid); }
    .sesi-option input:checked + label { background: var(--accent-tint); border-color: var(--accent); color: var(--ink-900); box-shadow: 0 0 0 3px var(--focus-ring-glow), var(--shadow-glass-sm); }
    .sesi-option input:checked + label i { color: var(--accent); }
    .sesi-option input:focus-visible + label { box-shadow: var(--shadow-focus); }
    .ap-tombol { display: flex; gap: var(--space-2-5); margin-top: var(--space-2); }
    .ap-tombol .btn-submit-log { flex: 1; }
    .ap-tombol .ds-btn { padding-left: var(--space-5); padding-right: var(--space-5); }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner :title="$isEdit ? 'Ubah Data Apel' : 'Isi Data Apel'" icon="fa-clipboard-check"
            subtitle="Catat pembina, lokasi, dan informasi apel. Pilih Apel Khusus untuk apel di luar jadwal pagi/malam" />

        <a href="{{ route('apel.index') }}" class="ds-btn ds-btn--pill ap-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Apel
        </a>

        @if($errors->any())
        <x-glass-alert type="danger" title="Data apel belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        <div class="form-card">
            <form method="POST" action="{{ $isEdit ? route('apel.update', $apel) : route('apel.store') }}">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div class="form-section-title">
                    <span><i class="fa-solid {{ $isEdit ? 'fa-pen-to-square' : 'fa-flag' }} me-2" style="color:var(--accent)"></i> {{ $isEdit ? 'Ubah Data Apel' : 'Isi Form Data Apel' }}</span>
                    <span class="ds-badge ds-badge--accent"><i class="fa-regular fa-clock"></i> Waktu: {{ now()->format('d/m/Y H:i') }}</span>
                </div>

                {{-- Jadwal --}}
                <div class="form-group">
                    <span class="form-label">Jenis Apel <span class="req">*</span></span>
                    <div class="sesi-options">
                        @php
                            $sesiTerpilih = old('sesi', $apel->sesi ?: 'pagi');
                            $pilihan = [
                                'pagi'   => ['Apel Pagi',   'fa-sun',  '06:30', 'Rutin · 06:30'],
                                'malam'  => ['Apel Malam',  'fa-moon', '19:00', 'Rutin · 19:00'],
                                'khusus' => ['Apel Khusus', 'fa-flag', '',      'Di luar jadwal'],
                            ];
                        @endphp
                        @foreach($pilihan as $nilai => [$label, $ikon, $jamDefault, $ket])
                        <div class="sesi-option">
                            <input type="radio" name="sesi" id="sesi_{{ $nilai }}" value="{{ $nilai }}" data-jam="{{ $jamDefault }}"
                                   @checked($sesiTerpilih === $nilai) onchange="onSesiChange()">
                            <label for="sesi_{{ $nilai }}">
                                <i class="fa-solid {{ $ikon }}"></i>
                                {{ $label }}
                                <small>{{ $ket }}</small>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('sesi')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="tanggal">Tanggal <span class="req">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                               value="{{ old('tanggal', optional($apel->tanggal)->format('Y-m-d') ?: date('Y-m-d')) }}" required>
                        @error('tanggal')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="jam">Jam <span class="opt">(opsional)</span></label>
                        <input type="time" name="jam" id="jam" class="form-control @error('jam') is-invalid @enderror"
                               value="{{ old('jam', $apel->jam ? \Carbon\Carbon::parse($apel->jam)->format('H:i') : '') }}">
                        @error('jam')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group" id="grupNamaApel">
                    <label class="form-label" for="nama_apel">Nama Apel Khusus <span class="req">*</span></label>
                    <input type="text" name="nama_apel" id="nama_apel" class="form-control @error('nama_apel') is-invalid @enderror"
                           value="{{ old('nama_apel', $apel->nama_apel) }}" placeholder="Contoh: Apel Gabungan HUT Kemerdekaan">
                    <small class="form-help">Wajib diisi untuk apel di luar jadwal pagi/malam.</small>
                    @error('nama_apel')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                {{-- Informasi --}}
                <div class="ap-subjudul"><i class="fa-solid fa-circle-info"></i> Informasi Apel</div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="pembina_user_id">Pembina Apel <span class="opt">(pilih dari pengasuh)</span></label>
                        <select name="pembina_user_id" id="pembina_user_id" class="form-select" onchange="onPembinaChange()">
                            <option value="">Ketik manual di kolom sebelah</option>
                            @foreach($daftarPembina as $p)
                            <option value="{{ $p->id }}" data-nama="{{ $p->name }}" @selected(old('pembina_user_id', $apel->pembina_user_id) == $p->id)>
                                {{ $p->name }}@if($p->jabatan) — {{ $p->jabatan }}@endif
                            </option>
                            @endforeach
                        </select>
                        <small class="form-help">Kosongkan jika pembina bukan pengguna sistem.</small>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="pembina">Nama Pembina <span class="req">*</span></label>
                        <input type="text" name="pembina" id="pembina" class="form-control @error('pembina') is-invalid @enderror"
                               value="{{ old('pembina', $apel->pembina) }}" placeholder="Contoh: Letkol Pnb Budi Santoso">
                        @error('pembina')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="lokasi">Lokasi Apel <span class="req">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                           value="{{ old('lokasi', $apel->lokasi) }}" placeholder="Contoh: Lapangan Utama PPI Curug" required>
                    @error('lokasi')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="informasi">Informasi Apel</label>
                    <textarea name="informasi" id="informasi" class="form-control @error('informasi') is-invalid @enderror"
                              placeholder="Amanat pembina, pengumuman, arahan, agenda...">{{ old('informasi', $apel->informasi) }}</textarea>
                    <small class="form-help"><i class="fa-solid fa-eye-slash"></i> Informasi apel hanya terlihat oleh pengasuh &amp; admin, tidak ditampilkan ke taruna.</small>
                    @error('informasi')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan Tambahan <span class="opt">(opsional)</span></label>
                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                              placeholder="Catatan lain, misal taruna tidak hadir, kondisi cuaca...">{{ old('keterangan', $apel->keterangan) }}</textarea>
                    @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="ap-tombol">
                    <a href="{{ route('apel.index') }}" class="ds-btn"><i class="fa-solid fa-xmark"></i> Batal</a>
                    <button type="submit" class="btn-submit-log">
                        <i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'SIMPAN PERUBAHAN' : 'SIMPAN DATA APEL' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</main>

<script>
// Nama apel hanya relevan untuk sesi khusus; jam terisi default untuk sesi rutin
function onSesiChange() {
    const dipilih = document.querySelector('input[name="sesi"]:checked');
    const khusus  = dipilih.value === 'khusus';
    const jam     = document.getElementById('jam');

    document.getElementById('grupNamaApel').style.display = khusus ? '' : 'none';
    document.getElementById('nama_apel').required = khusus;

    if (!khusus && !jam.value && dipilih.dataset.jam) {
        jam.value = dipilih.dataset.jam;
    }
}

// Memilih pengasuh mengisi nama pembina otomatis; kolom teks jadi read-only agar tidak bentrok
function onPembinaChange() {
    const select  = document.getElementById('pembina_user_id');
    const pembina = document.getElementById('pembina');

    if (select.value) {
        pembina.value = select.selectedOptions[0].dataset.nama;
        pembina.readOnly = true;
    } else {
        pembina.readOnly = false;
    }
}

onSesiChange();
onPembinaChange();
</script>
</x-app-layout>
