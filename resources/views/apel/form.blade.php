@php
    $isEdit = $apel->exists;
@endphp

<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }

.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

.breadcrumb { display:flex; align-items:center; gap:8px; font-size:13px; color:#888; margin-bottom:18px; }
.breadcrumb a { color:#1baf7a; text-decoration:none; font-weight:600; }
.breadcrumb a:hover { text-decoration:underline; }

.form-card { background:white; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,.06); max-width:780px; overflow:hidden; }
.form-card-head { background:linear-gradient(135deg,#1baf7a,#2a78d6); padding:24px 30px; color:white; }
.form-card-head h1 { margin:0 0 4px; font-size:20px; font-weight:800; }
.form-card-head p { margin:0; font-size:13px; opacity:.88; }
.form-body { padding:28px 30px; }

.section-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; margin:0 0 14px; padding-bottom:8px; border-bottom:1px solid #f0f2f7; display:flex; align-items:center; gap:7px; }
.section-title:not(:first-child) { margin-top:28px; }

.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.form-group { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
.form-group.full { grid-column:1/-1; }
label { font-size:12px; font-weight:700; color:#555; }
label .opsional { font-weight:500; color:#b9bfcc; }

.form-control {
    padding:11px 14px; border:2px solid #e8ebf5; border-radius:10px;
    font-size:14px; font-family:'Inter',sans-serif; color:#333;
    outline:none; background:#fafbff; transition:border-color .15s;
    width:100%;
}
.form-control:focus { border-color:#1baf7a; background:white; }
.form-control.is-invalid { border-color:#e34948; }
textarea.form-control { resize:vertical; min-height:96px; line-height:1.6; }
select.form-control { appearance:none; cursor:pointer;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 13px center; background-size:16px; padding-right:38px; }
.hint { font-size:11px; color:#a8afbd; }
.invalid-feedback { font-size:11.5px; color:#e34948; font-weight:600; }

/* Pilihan sesi */
.sesi-options { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
.sesi-option { position:relative; }
.sesi-option input { position:absolute; opacity:0; pointer-events:none; }
.sesi-option label {
    display:flex; flex-direction:column; align-items:center; gap:5px;
    padding:14px 10px; border:2px solid #e8ebf5; border-radius:12px;
    background:#fafbff; cursor:pointer; transition:all .15s; text-align:center;
    font-size:12.5px; font-weight:700; color:#666;
}
.sesi-option label i { font-size:17px; }
.sesi-option label small { font-weight:500; font-size:10px; color:#a8afbd; }
.sesi-option input:checked + label { border-color:#1baf7a; background:#f0fdf8; color:#128a5f; }
.sesi-option input:focus-visible + label { outline:2px solid #1baf7a; outline-offset:2px; }

.alert-error { background:#fff5f5; border:1px solid #feb2b2; color:#c53030; padding:13px 17px; border-radius:11px; margin-bottom:20px; font-size:13px; display:flex; gap:10px; align-items:flex-start; }
.alert-error ul { margin:0; padding-left:18px; }

.btn-row { display:flex; gap:11px; justify-content:flex-end; padding-top:20px; margin-top:22px; border-top:1px solid #f0f2f7; }
.btn-primary {
    background:linear-gradient(135deg,#1baf7a,#2a78d6); color:white; border:none;
    padding:12px 26px; border-radius:11px; font-size:13.5px; font-weight:700;
    cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:opacity .15s;
    font-family:'Inter',sans-serif;
}
.btn-primary:hover { opacity:.9; }
.btn-secondary {
    background:white; color:#555; border:2px solid #e8ebf5;
    padding:12px 24px; border-radius:11px; font-size:13.5px; font-weight:700;
    cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:border-color .15s;
}
.btn-secondary:hover { border-color:#1baf7a; color:#1baf7a; }
</style>

<div class="app-layout">
    <x-sidebar active="apel" />

    <div class="main-content">
        <div class="breadcrumb">
            <a href="{{ route('apel.index') }}"><i class="fas fa-flag"></i> Apel</a>
            <i class="fas fa-chevron-right" style="font-size:10px;"></i>
            <span>{{ $isEdit ? 'Ubah Data Apel' : 'Isi Data Apel' }}</span>
        </div>

        @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-circle" style="margin-top:2px;"></i>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-card">
            <div class="form-card-head">
                <h1><i class="fas {{ $isEdit ? 'fa-pen-to-square' : 'fa-flag' }}" style="margin-right:9px;"></i>{{ $isEdit ? 'Ubah Data Apel' : 'Isi Data Apel' }}</h1>
                <p>Catat pembina, lokasi, dan informasi apel. Pilih Apel Khusus untuk apel di luar jadwal pagi/malam.</p>
            </div>

            <div class="form-body">
                <form method="POST" action="{{ $isEdit ? route('apel.update', $apel) : route('apel.store') }}">
                    @csrf
                    @if($isEdit) @method('PUT') @endif

                    <div class="section-title"><i class="fas fa-calendar-day"></i> Jadwal Apel</div>

                    <div class="form-group">
                        <label>Jenis Apel</label>
                        <div class="sesi-options">
                            @php
                                $sesiTerpilih = old('sesi', $apel->sesi ?: 'pagi');
                                $pilihan = [
                                    'pagi'   => ['Apel Pagi',   'fa-sun',  '06:30', 'Rutin'],
                                    'malam'  => ['Apel Malam',  'fa-moon', '19:00', 'Rutin'],
                                    'khusus' => ['Apel Khusus', 'fa-flag', '',      'Di luar jadwal'],
                                ];
                            @endphp
                            @foreach($pilihan as $nilai => [$label, $ikon, $jamDefault, $ket])
                            <div class="sesi-option">
                                <input type="radio" name="sesi" id="sesi_{{ $nilai }}" value="{{ $nilai }}"
                                       data-jam="{{ $jamDefault }}"
                                       @checked($sesiTerpilih === $nilai)
                                       onchange="onSesiChange()">
                                <label for="sesi_{{ $nilai }}">
                                    <i class="fas {{ $ikon }}"></i>
                                    {{ $label }}
                                    <small>{{ $ket }}</small>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', optional($apel->tanggal)->format('Y-m-d') ?: date('Y-m-d')) }}" required>
                            @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="jam">Jam <span class="opsional">(opsional)</span></label>
                            <input type="time" name="jam" id="jam"
                                   class="form-control @error('jam') is-invalid @enderror"
                                   value="{{ old('jam', $apel->jam ? \Carbon\Carbon::parse($apel->jam)->format('H:i') : '') }}">
                            @error('jam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group" id="grupNamaApel">
                        <label for="nama_apel">Nama Apel Khusus</label>
                        <input type="text" name="nama_apel" id="nama_apel"
                               class="form-control @error('nama_apel') is-invalid @enderror"
                               value="{{ old('nama_apel', $apel->nama_apel) }}"
                               placeholder="Contoh: Apel Gabungan HUT Kemerdekaan">
                        <span class="hint">Wajib diisi untuk apel di luar jadwal pagi/malam.</span>
                        @error('nama_apel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="section-title"><i class="fas fa-circle-info"></i> Informasi Apel</div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pembina_user_id">Pembina Apel <span class="opsional">— pilih dari pengasuh</span></label>
                            <select name="pembina_user_id" id="pembina_user_id" class="form-control" onchange="onPembinaChange()">
                                <option value="">— Ketik manual di bawah —</option>
                                @foreach($daftarPembina as $p)
                                <option value="{{ $p->id }}" data-nama="{{ $p->name }}"
                                        @selected(old('pembina_user_id', $apel->pembina_user_id) == $p->id)>
                                    {{ $p->name }}@if($p->jabatan) — {{ $p->jabatan }}@endif
                                </option>
                                @endforeach
                            </select>
                            <span class="hint">Kosongkan jika pembina bukan pengguna sistem.</span>
                        </div>
                        <div class="form-group">
                            <label for="pembina">Nama Pembina <span class="opsional">— ketik bebas</span></label>
                            <input type="text" name="pembina" id="pembina"
                                   class="form-control @error('pembina') is-invalid @enderror"
                                   value="{{ old('pembina', $apel->pembina) }}"
                                   placeholder="Contoh: Letkol Pnb Budi Santoso">
                            @error('pembina')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi Apel</label>
                        <input type="text" name="lokasi" id="lokasi"
                               class="form-control @error('lokasi') is-invalid @enderror"
                               value="{{ old('lokasi', $apel->lokasi) }}"
                               placeholder="Contoh: Lapangan Utama PPI Curug" required>
                        @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="informasi">Informasi Apel</label>
                        <textarea name="informasi" id="informasi"
                                  class="form-control @error('informasi') is-invalid @enderror"
                                  placeholder="Amanat pembina, pengumuman, arahan, agenda...">{{ old('informasi', $apel->informasi) }}</textarea>
                        @error('informasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan Tambahan <span class="opsional">(opsional)</span></label>
                        <textarea name="keterangan" id="keterangan"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  placeholder="Catatan lain, misal taruna tidak hadir, kondisi cuaca...">{{ old('keterangan', $apel->keterangan) }}</textarea>
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="btn-row">
                        <a href="{{ route('apel.index') }}" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Data Apel' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Nama apel hanya relevan untuk sesi khusus; jam terisi default untuk sesi rutin
function onSesiChange() {
    const dipilih = document.querySelector('input[name="sesi"]:checked');
    const khusus  = dipilih.value === 'khusus';
    const grup    = document.getElementById('grupNamaApel');
    const jam     = document.getElementById('jam');

    grup.style.display = khusus ? 'flex' : 'none';
    document.getElementById('nama_apel').required = khusus;

    if (!khusus && !jam.value && dipilih.dataset.jam) {
        jam.value = dipilih.dataset.jam;
    }
}

// Memilih pengasuh mengisi nama pembina otomatis; field teks jadi read-only agar tidak bentrok
function onPembinaChange() {
    const select  = document.getElementById('pembina_user_id');
    const pembina = document.getElementById('pembina');
    const opsi    = select.selectedOptions[0];

    if (select.value) {
        pembina.value = opsi.dataset.nama;
        pembina.readOnly = true;
        pembina.style.background = '#f0f2f7';
    } else {
        pembina.readOnly = false;
        pembina.style.background = '';
    }
}

onSesiChange();
onPembinaChange();
</script>
</x-app-layout>
