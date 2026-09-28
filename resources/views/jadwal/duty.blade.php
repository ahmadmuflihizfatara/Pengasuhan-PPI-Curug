<x-app-layout>
<x-form-glass-style />
<style>
    /* Pilih minggu */
    .dy-minggu { display: flex; align-items: flex-end; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .dy-minggu .form-group { flex: 1 1 320px; margin: 0; }

    /* Form isi duty */
    .row-header, .duty-row { display: grid; grid-template-columns: 28px minmax(0, 1.6fr) minmax(0, 1fr) 90px; gap: var(--space-2-5); align-items: center; }
    .row-header { margin-bottom: var(--space-2); font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .duty-row { margin-bottom: var(--space-2); }
    .duty-no { width: 24px; height: 24px; border-radius: var(--radius-pill); display: grid; place-items: center; font-size: 10px; font-weight: 800; background: var(--accent-tint); color: var(--accent-ink); }
    .duty-row .form-control[readonly] { color: var(--ink-700); background-color: var(--glass-subtle); cursor: default; }
    .duty-row .form-control.cocok { border-color: var(--success-border); background-color: var(--success-tint); }
    .duty-row .form-control.gagal { border-color: var(--danger-border); background-color: var(--danger-tint); }
    @media (max-width: 640px) {
        .row-header { display: none; }
        .duty-row { grid-template-columns: 24px 1fr 1fr; }
        .duty-row .input-nama { grid-column: 2 / -1; }
        .duty-row .input-prodi { grid-column: 2; }
    }
    .form-foot { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border-glass-subtle); }
    .status-isi { font-size: 12px; font-weight: 800; color: var(--ink-600); }
    .status-isi.lengkap { color: var(--success-ink); }
    .form-foot .btn-submit-log { width: auto; padding-left: var(--space-6); padding-right: var(--space-6); }
    .form-foot .btn-submit-log:disabled { opacity: .45; cursor: not-allowed; }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php $bolehEdit = auth()->user()->isKasiInternal() || auth()->user()->canManageSystem(); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Duty Taruna" icon="fa-user-group" :subtitle="'Daftar ' . $jumlahWajib . ' taruna yang bertugas piket setiap minggunya'" />

        @include('jadwal._tabs', ['aktif' => 'duty'])

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Duty belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        @unless($bolehIsi)
        <div class="ds-alert ds-alert--warning" role="status">
            <i class="fa-solid fa-lock ds-icon"></i>
            <span>Akses pengisian duty taruna sedang ditutup admin — data tetap dapat dilihat, tetapi tidak dapat diubah.</span>
        </div>
        @elseif(!$bolehEdit)
        <div class="ds-alert ds-alert--info" role="status">
            <i class="fa-solid fa-eye ds-icon"></i>
            <span>Duty taruna hanya dapat diisi oleh Kepala Seksi Internal. Anda dapat melihat jadwal, tetapi tidak mengubahnya.</span>
        </div>
        @endunless

        {{-- Pilih minggu --}}
        <div class="ds-card dy-minggu mb-4">
            <div class="form-group">
                <label class="form-label" for="mingguSelect">Periode Minggu</label>
                <select id="mingguSelect" class="form-select" onchange="window.location='{{ route('duty.index') }}?minggu=' + this.value">
                    <option value="{{ $mingguIni->format('Y-m-d') }}" @selected($dipilih->eq($mingguIni))>
                        Minggu ini — {{ \App\Models\DutyTaruna::labelPeriode($mingguIni) }}
                    </option>
                    @foreach($riwayat as $r)
                        @unless($r['minggu']->eq($mingguIni))
                        <option value="{{ $r['minggu']->format('Y-m-d') }}" @selected($dipilih->eq($r['minggu']))>
                            {{ \App\Models\DutyTaruna::labelPeriode($r['minggu']) }} ({{ $r['jumlah'] }} taruna)
                        </option>
                        @endunless
                    @endforeach
                </select>
            </div>
            @if($dipilih->eq($mingguIni))
            <span class="ds-badge ds-badge--success"><i class="fa-solid fa-circle-dot"></i> Sedang berjalan</span>
            @endif
        </div>

        {{-- Daftar duty minggu terpilih --}}
        <div class="ds-card mb-4">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-clipboard-list ds-icon"></i> Duty {{ \App\Models\DutyTaruna::labelPeriode($dipilih) }}</h3>
                    <p class="ds-card__desc">Taruna yang bertugas piket pada periode ini</p>
                </div>
                <span class="ds-badge ds-badge--{{ $duty->count() < $jumlahWajib ? 'warning' : 'success' }}">{{ $duty->count() }} / {{ $jumlahWajib }} taruna</span>
            </div>

            @if($duty->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-clipboard-list ds-icon"></i>
                Belum ada duty taruna untuk minggu ini.
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table">
                        <thead>
                            <tr>
                                <th>Nama Taruna</th>
                                <th>NPM</th>
                                <th data-filter>Prodi</th>
                                <th class="ds-right" data-filter>Tingkat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($duty as $d)
                            <tr>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($d->mahasiswa->nama ?? '?', 0, 2)) }}</span>
                                        <div class="tbl-title">{{ $d->mahasiswa->nama ?? '—' }}</div>
                                    </div>
                                </td>
                                <td class="tbl-muted" style="font-family:var(--font-mono)">{{ $d->mahasiswa->npm ?? '-' }}</td>
                                <td><span class="ds-badge ds-badge--info">{{ $d->mahasiswa->prodi ?? '-' }}</span></td>
                                <td class="ds-right"><span class="ds-badge ds-badge--success">Tk. {{ $d->mahasiswa->tingkat ?? '-' }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- Form isi duty (akses dibuka & role berwenang: Kasi Internal / Admin) --}}
        @if($bolehIsi && $bolehEdit)
        <div class="form-card">
            <div class="form-section-title">
                <span><i class="fa-solid fa-pen-to-square me-2" style="color:var(--accent)"></i> {{ $duty->isEmpty() ? 'Isi' : 'Perbarui' }} Duty — {{ \App\Models\DutyTaruna::labelPeriode($dipilih) }}</span>
                <span class="ds-badge ds-badge--accent">Wajib {{ $jumlahWajib }} taruna</span>
            </div>
            <small class="form-help mb-3 d-block"><i class="fa-solid fa-circle-info"></i> Ketik nama taruna lalu pilih dari saran — prodi dan tingkat terisi otomatis dari database mahasiswa.</small>

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
                    <input type="text" list="daftarTaruna" class="form-control input-nama" placeholder="Ketik nama taruna..."
                           value="{{ old('nama.'.$i, $terisi->mahasiswa->nama ?? '') }}" data-index="{{ $i }}" autocomplete="off"
                           aria-label="Nama taruna ke-{{ $i + 1 }}">
                    <input type="hidden" name="mahasiswa_id[]" class="input-id" value="{{ old('mahasiswa_id.'.$i, $terisi->mahasiswa_id ?? '') }}">
                    <input type="text" class="form-control input-prodi" readonly placeholder="—" value="{{ $terisi->mahasiswa->prodi ?? '' }}" aria-label="Prodi taruna ke-{{ $i + 1 }}">
                    <input type="text" class="form-control input-tingkat" readonly placeholder="—" value="{{ $terisi->mahasiswa->tingkat ?? '' }}" aria-label="Tingkat taruna ke-{{ $i + 1 }}">
                </div>
                @endfor

                <datalist id="daftarTaruna">
                    @foreach($daftarTaruna as $t)
                    <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                    @endforeach
                </datalist>

                <div class="form-foot">
                    <span class="status-isi" id="statusIsi">0 / {{ $jumlahWajib }} terisi</span>
                    <button type="submit" class="btn-submit-log" id="btnSimpan" disabled>
                        <i class="fa-solid fa-floppy-disk"></i> SIMPAN DUTY MINGGU INI
                    </button>
                </div>
            </form>
        </div>
        @endif

    </div>
</main>

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
