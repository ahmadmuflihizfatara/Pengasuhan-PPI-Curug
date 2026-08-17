<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

.page-header {
    background: linear-gradient(135deg, #4a3aa7 0%, #2a78d6 100%);
    border-radius: 18px; padding: 28px 32px; color: white; margin-bottom: 22px;
    position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:220px; height:220px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:70px; bottom:-80px; width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.88; font-size:13px; position:relative; z-index:1; }

.flash-success { background:#f0fff4; border:1px solid #c6f6d5; color:#276749; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:8px; }
.flash-error { background:#fff5f5; border:1px solid #feb2b2; color:#c53030; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; gap:8px; align-items:flex-start; }
.flash-error ul { margin:0; padding-left:16px; }
.flash-locked { background:#fff8ec; border:1px solid #fbd38d; color:#a06a0a; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:8px; }

/* Sub-tab */
.subtab-row { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
.subtab {
    padding:10px 18px; border-radius:11px; font-size:13px; font-weight:700;
    text-decoration:none; background:white; color:#666; border:2px solid #e8ebf5;
    display:inline-flex; align-items:center; gap:8px; transition:all .15s;
}
.subtab:hover { border-color:#1baf7a; color:#1baf7a; }
.subtab.active { background:linear-gradient(135deg,#4a3aa7,#2a78d6); color:white; border-color:transparent; }

/* Selector minggu */
.week-bar { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:20px; }
.week-select-wrap { position:relative; min-width:280px; flex:1; }
.week-select-wrap select {
    width:100%; appearance:none; padding:12px 40px 12px 15px;
    border:2px solid #e8ebf5; border-radius:11px; background:white;
    font-size:14px; font-family:'Inter',sans-serif; color:#333; font-weight:700;
    cursor:pointer; outline:none;
}
.week-select-wrap select:focus { border-color:#1baf7a; }
.week-select-wrap i { position:absolute; right:15px; top:50%; transform:translateY(-50%); color:#98a0b3; pointer-events:none; font-size:13px; }
.badge-minggu-ini { background:#f0fff4; color:#276749; border:1px solid #c6f6d5; border-radius:20px; padding:7px 15px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px; }

/* Card daftar duty */
.card { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; margin-bottom:20px; }
.card-head { padding:16px 22px; border-bottom:1px solid #f0f2f7; display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
.card-head h2 { font-size:15px; font-weight:700; color:#333; margin:0; display:flex; align-items:center; gap:8px; }
.count-badge { background:#e8f8f2; color:#128a5f; font-size:12px; font-weight:700; padding:3px 12px; border-radius:20px; }
.count-badge.kurang { background:#fff8ec; color:#a06a0a; }

table { width:100%; border-collapse:collapse; }
thead tr { background:linear-gradient(135deg,#4a3aa7,#2a78d6); }
th { padding:12px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:white; }
td { padding:12px 16px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr:hover { background:#fafbff; }
.duty-avatar { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#4a3aa7,#2a78d6); color:white; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; flex-shrink:0; }
.duty-name { font-weight:700; color:#2b2b33; }
.npm-badge { font-family:monospace; font-size:12px; color:#777; }
.pill { background:#eef0ff; color:#5a67d8; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:700; }
.pill-tingkat { background:#f0fff4; color:#38a169; }

.empty { text-align:center; padding:48px 20px; color:#aab; }
.empty i { font-size:40px; color:#e2e5ee; display:block; margin-bottom:12px; }
.empty p { margin:0; font-size:14px; font-weight:600; color:#98a0b3; }

/* Form isi duty */
.form-card { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; }
.form-head { padding:18px 22px; border-bottom:1px solid #f0f2f7; }
.form-head h2 { font-size:15px; font-weight:700; color:#333; margin:0 0 3px; display:flex; align-items:center; gap:8px; }
.form-head p { font-size:12px; color:#98a0b3; margin:0; }
.form-body { padding:18px 22px 22px; }

.duty-row { display:grid; grid-template-columns:34px 1.6fr 1fr 90px; gap:10px; align-items:center; margin-bottom:9px; }
.duty-no { font-size:12px; font-weight:800; color:#98a0b3; text-align:center; }
.duty-row input {
    padding:10px 12px; border:2px solid #e8ebf5; border-radius:10px;
    font-size:13px; font-family:'Inter',sans-serif; color:#333; outline:none; background:#fafbff; width:100%;
}
.duty-row input:focus { border-color:#1baf7a; background:white; }
.duty-row input[readonly] { background:#f3f4f8; color:#777; }
.duty-row input.cocok { border-color:#9ae6b4; background:#f6fffb; }
.duty-row input.gagal { border-color:#feb2b2; background:#fff8f8; }
.row-header { display:grid; grid-template-columns:34px 1.6fr 1fr 90px; gap:10px; margin-bottom:8px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; }

.form-foot { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-top:18px; padding-top:16px; border-top:1px solid #f0f2f7; }
.status-isi { font-size:12.5px; font-weight:700; color:#8a93b0; }
.status-isi.lengkap { color:#276749; }
.btn-simpan {
    background:linear-gradient(135deg,#4a3aa7,#2a78d6); color:white; border:none;
    padding:12px 26px; border-radius:11px; font-size:13.5px; font-weight:700;
    cursor:pointer; display:inline-flex; align-items:center; gap:8px; font-family:'Inter',sans-serif; transition:opacity .15s;
}
.btn-simpan:hover:not(:disabled) { opacity:.9; }
.btn-simpan:disabled { opacity:.45; cursor:not-allowed; }
</style>

<div class="app-layout">
    <x-sidebar active="jadwal" />

    <div class="main-content">

        <div class="page-header">
            <h1><i class="fas fa-user-group" style="margin-right:10px;"></i>Duty Taruna</h1>
            <p>Daftar {{ $jumlahWajib }} taruna yang bertugas piket setiap minggunya</p>
        </div>

        @include('jadwal._tabs', ['aktif' => 'duty'])

        @if(session('success'))
        <div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="flash-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
        <div class="flash-error">
            <i class="fas fa-exclamation-circle" style="margin-top:2px;"></i>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        @unless($bolehIsi)
        <div class="flash-locked">
            <i class="fas fa-lock"></i>
            Akses pengisian duty taruna sedang ditutup admin — data tetap dapat dilihat, tetapi tidak dapat diubah.
        </div>
        @endunless

        {{-- Pilih minggu --}}
        <div class="week-bar">
            <div class="week-select-wrap">
                <select id="mingguSelect" onchange="window.location='{{ route('duty.index') }}?minggu=' + this.value">
                    <option value="{{ $mingguIni->format('Y-m-d') }}" @selected($dipilih->eq($mingguIni))>
                        Minggu Ini — {{ \App\Models\DutyTaruna::labelPeriode($mingguIni) }}
                    </option>
                    @foreach($riwayat as $r)
                        @unless($r['minggu']->eq($mingguIni))
                        <option value="{{ $r['minggu']->format('Y-m-d') }}" @selected($dipilih->eq($r['minggu']))>
                            {{ \App\Models\DutyTaruna::labelPeriode($r['minggu']) }} ({{ $r['jumlah'] }} taruna)
                        </option>
                        @endunless
                    @endforeach
                </select>
                <i class="fas fa-chevron-down"></i>
            </div>
            @if($dipilih->eq($mingguIni))
            <span class="badge-minggu-ini"><i class="fas fa-circle-dot"></i> Sedang berjalan</span>
            @endif
        </div>

        {{-- Daftar duty minggu terpilih --}}
        <div class="card">
            <div class="card-head">
                <h2><i class="fas fa-clipboard-list" style="color:#1baf7a;"></i>
                    Duty {{ \App\Models\DutyTaruna::labelPeriode($dipilih) }}
                </h2>
                <span class="count-badge {{ $duty->count() < $jumlahWajib ? 'kurang' : '' }}">
                    {{ $duty->count() }} / {{ $jumlahWajib }} taruna
                </span>
            </div>

            @if($duty->isEmpty())
            <div class="empty">
                <i class="fas fa-clipboard-list"></i>
                <p>Belum ada duty taruna untuk minggu ini.</p>
            </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAMA TARUNA</th>
                        <th>NPM</th>
                        <th>PRODI</th>
                        <th>TINGKAT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($duty as $i => $d)
                    <tr>
                        <td style="color:#bbb; font-size:12px;">{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="duty-avatar">{{ strtoupper(substr($d->mahasiswa->nama ?? '?', 0, 2)) }}</div>
                                <span class="duty-name">{{ $d->mahasiswa->nama ?? '—' }}</span>
                            </div>
                        </td>
                        <td><span class="npm-badge">{{ $d->mahasiswa->npm ?? '-' }}</span></td>
                        <td><span class="pill">{{ $d->mahasiswa->prodi ?? '-' }}</span></td>
                        <td><span class="pill pill-tingkat">{{ $d->mahasiswa->tingkat ?? '-' }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Form isi duty (hanya jika akses dibuka) --}}
        @if($bolehIsi)
        <div class="form-card">
            <div class="form-head">
                <h2><i class="fas fa-pen-to-square" style="color:#1baf7a;"></i>
                    {{ $duty->isEmpty() ? 'Isi' : 'Perbarui' }} Duty — {{ \App\Models\DutyTaruna::labelPeriode($dipilih) }}
                </h2>
                <p>Ketik nama taruna, prodi dan tingkat terisi otomatis dari database mahasiswa. Wajib {{ $jumlahWajib }} orang.</p>
            </div>
            <div class="form-body">
                <form method="POST" action="{{ route('duty.store') }}" id="dutyForm">
                    @csrf
                    <input type="hidden" name="minggu_mulai" value="{{ $dipilih->format('Y-m-d') }}">

                    <div class="row-header">
                        <span></span>
                        <span>Nama Taruna</span>
                        <span>Prodi</span>
                        <span>Tingkat</span>
                    </div>

                    @for($i = 0; $i < $jumlahWajib; $i++)
                    @php $terisi = $duty[$i] ?? null; @endphp
                    <div class="duty-row">
                        <span class="duty-no">{{ $i + 1 }}</span>
                        <input type="text" list="daftarTaruna" class="input-nama"
                               placeholder="Ketik nama taruna..."
                               value="{{ old('nama.'.$i, $terisi->mahasiswa->nama ?? '') }}"
                               data-index="{{ $i }}" autocomplete="off">
                        <input type="hidden" name="mahasiswa_id[]" class="input-id"
                               value="{{ old('mahasiswa_id.'.$i, $terisi->mahasiswa_id ?? '') }}">
                        <input type="text" class="input-prodi" readonly placeholder="—"
                               value="{{ $terisi->mahasiswa->prodi ?? '' }}">
                        <input type="text" class="input-tingkat" readonly placeholder="—"
                               value="{{ $terisi->mahasiswa->tingkat ?? '' }}">
                    </div>
                    @endfor

                    <datalist id="daftarTaruna">
                        @foreach($daftarTaruna as $t)
                        <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                        @endforeach
                    </datalist>

                    <div class="form-foot">
                        <span class="status-isi" id="statusIsi">0 / {{ $jumlahWajib }} terisi</span>
                        <button type="submit" class="btn-simpan" id="btnSimpan" disabled>
                            <i class="fas fa-save"></i> Simpan Duty Minggu Ini
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
// Data mahasiswa untuk pencocokan nama → prodi & tingkat
const TARUNA = @json($daftarTaruna->mapWithKeys(fn($t) => [strtolower($t->nama) => ['id' => $t->id, 'prodi' => $t->prodi, 'tingkat' => $t->tingkat]]));
const JUMLAH_WAJIB = {{ $jumlahWajib }};

function cocokkanBaris(inputNama) {
    const row     = inputNama.closest('.duty-row');
    const idEl    = row.querySelector('.input-id');
    const prodiEl = row.querySelector('.input-prodi');
    const tkEl    = row.querySelector('.input-tingkat');
    const cocok   = TARUNA[inputNama.value.trim().toLowerCase()];

    if (cocok) {
        idEl.value    = cocok.id;
        prodiEl.value = cocok.prodi || '';
        tkEl.value    = cocok.tingkat || '';
        inputNama.classList.add('cocok');
        inputNama.classList.remove('gagal');
    } else {
        idEl.value    = '';
        prodiEl.value = '';
        tkEl.value    = '';
        inputNama.classList.remove('cocok');
        inputNama.classList.toggle('gagal', inputNama.value.trim() !== '');
    }

    perbaruiStatus();
}

function perbaruiStatus() {
    const terisi = [...document.querySelectorAll('.input-id')].filter(el => el.value).length;
    const status = document.getElementById('statusIsi');
    const btn    = document.getElementById('btnSimpan');
    if (!status) return;

    status.textContent = terisi + ' / ' + JUMLAH_WAJIB + ' terisi';
    status.classList.toggle('lengkap', terisi === JUMLAH_WAJIB);
    btn.disabled = terisi !== JUMLAH_WAJIB;
}

document.querySelectorAll('.input-nama').forEach(el => {
    el.addEventListener('input',  () => cocokkanBaris(el));
    el.addEventListener('change', () => cocokkanBaris(el));
});

// Tandai baris yang sudah terisi dari server saat halaman dibuka
document.querySelectorAll('.input-nama').forEach(el => { if (el.value.trim()) cocokkanBaris(el); });
perbaruiStatus();
</script>
</x-app-layout>
