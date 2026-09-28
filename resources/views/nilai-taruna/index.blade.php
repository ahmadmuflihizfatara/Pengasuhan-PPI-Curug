<x-app-layout>
{{-- Form memakai gaya yang sama dengan form Konsinyir, Surat & Apel --}}
<x-form-glass-style />
<style>
    .nl-form { margin-bottom: var(--space-4); }
    .nl-form .ds-error { font-size: 11px; }
    .nl-form textarea.form-control { resize: vertical; min-height: 64px; }
    .nl-form .nl-angka { font-family: var(--font-mono); font-size: 14px; font-weight: 800; }
    .nl-info { display: none; gap: var(--space-1-5); margin-top: var(--space-2); }
    .nl-simpan { width: auto; padding-left: var(--space-8, 32px); padding-right: var(--space-8, 32px); }

    .nl-head-kanan { display: flex; align-items: center; gap: var(--space-2); flex-wrap: wrap; }
    .nl-head-kanan form { margin: 0; }
    .nl-head-kanan .form-select { min-width: 220px; padding-top: var(--space-2); padding-bottom: var(--space-2); }
    .ds-table td.nl-skor { font-family: var(--font-mono); font-size: 14px; font-weight: 800; text-align: center; white-space: nowrap; }
    .nl-ket { max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
</style>

<x-island-navbar />

@php
    // Warna skor: hijau baik, kuning cukup, merah kurang (IPS skala 4, lainnya skala 100)
    $varianSkor = fn ($n, $maks) => $n / $maks >= .8 ? 'success' : ($n / $maks >= .6 ? 'warning' : 'danger');
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab lain --}}
        <x-page-banner title="Pengisian Nilai Taruna" icon="fa-chart-line"
            subtitle="Input IPS, Samapta & Pengasuhan per semester — taruna melihat rekapitulasinya di dashboard" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Nilai belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        {{-- Form input nilai --}}
        <div class="form-card nl-form">
            <div class="form-section-title">
                <span><i class="fa-solid fa-pen-to-square me-2" style="color:var(--accent)"></i> Input / Perbarui Nilai Semester</span>
                <span class="ds-badge ds-badge--accent"><i class="fa-regular fa-clock"></i> Waktu: {{ now()->format('d/m/Y H:i') }}</span>
            </div>

            <form method="POST" action="{{ route('nilai-taruna.store') }}" id="nilaiForm">
                @csrf
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label class="form-label" for="namaTaruna">Nama Taruna <span class="req">*</span></label>
                        <input type="text" id="namaTaruna" list="daftarTaruna" class="form-control"
                               placeholder="Ketik nama lalu pilih dari saran" value="{{ $daftarTaruna->firstWhere('id', old('mahasiswa_id'))?->nama }}" autocomplete="off" required>
                        <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                        @error('mahasiswa_id')<div class="ds-error">{{ $message }}</div>@enderror
                        <div class="ds-error" id="namaTarunaError" role="alert" hidden><i class="fa-solid fa-circle-exclamation"></i> Pilih nama taruna yang cocok dari daftar saran.</div>
                        <div class="nl-info" id="infoTaruna">
                            <span class="ds-badge ds-badge--info" id="infoProdi"></span>
                            <span class="ds-badge ds-badge--success" id="infoTingkat"></span>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="semester">Semester <span class="req">*</span></label>
                        <select name="semester" id="semester" class="form-select" required>
                            @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" @selected(old('semester') == $i)>Semester {{ $i }}</option>
                            @endfor
                        </select>
                        @error('semester')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="ips">IPS (0–4) <span class="req">*</span></label>
                        <input type="number" name="ips" id="ips" step="0.01" min="0" max="4" class="form-control nl-angka" placeholder="3.45" value="{{ old('ips') }}" required>
                        @error('ips')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="samapta">Samapta (0–100) <span class="req">*</span></label>
                        <input type="number" name="samapta" id="samapta" step="0.01" min="0" max="100" class="form-control nl-angka" placeholder="85" value="{{ old('samapta') }}" required>
                        @error('samapta')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="pengasuhan">Pengasuhan (0–100) <span class="req">*</span></label>
                        <input type="number" name="pengasuhan" id="pengasuhan" step="0.01" min="0" max="100" class="form-control nl-angka" placeholder="90" value="{{ old('pengasuhan') }}" required>
                        @error('pengasuhan')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan <span style="text-transform:none; letter-spacing:0; color:var(--ink-500);">(opsional)</span></label>
                    <textarea name="keterangan" id="keterangan" rows="2" class="form-control" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                    <small class="form-help"><i class="fa-solid fa-circle-info"></i> Jika nilai semester tersebut sudah ada untuk taruna yang sama, nilainya akan diperbarui.</small>
                </div>

                <datalist id="daftarTaruna">
                    @foreach($daftarTaruna as $t)
                    <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                    @endforeach
                </datalist>

                <button type="submit" class="btn-submit-log nl-simpan"><i class="fa-solid fa-floppy-disk"></i> SIMPAN NILAI</button>
            </form>
        </div>

        {{-- Daftar nilai --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-table-list ds-icon"></i> Daftar Nilai Terinput</h3>
                    <p class="ds-card__desc">{{ $filterId ? 'Nilai untuk ' . ($daftarTaruna->firstWhere('id', $filterId)?->nama ?? 'taruna terpilih') : 'Nilai yang diperbarui terakhir tampil paling atas' }}</p>
                </div>
                <div class="nl-head-kanan">
                    <form method="GET" action="{{ route('nilai-taruna.index') }}">
                        <select name="mahasiswa_id" class="form-select" onchange="this.form.submit()" aria-label="Filter taruna">
                            <option value="">Semua taruna</option>
                            @foreach($daftarTaruna as $t)
                            <option value="{{ $t->id }}" @selected($filterId == $t->id)>{{ $t->nama }}</option>
                            @endforeach
                        </select>
                    </form>
                    @if($filterId)
                    <a href="{{ route('nilai-taruna.index') }}" class="ds-btn ds-btn--icon" title="Reset filter" aria-label="Reset filter"><i class="fa-solid fa-xmark"></i></a>
                    @endif
                    <span class="ds-badge ds-badge--accent">{{ $daftarNilai->count() }} nilai</span>
                </div>
            </div>

            @if($daftarNilai->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-inbox ds-icon"></i>
                Belum ada nilai yang diinput.
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table">
                        <thead>
                            <tr>
                                <th>Taruna</th>
                                <th data-filter>Prodi</th>
                                <th class="ds-center" data-filter>Semester</th>
                                <th class="ds-center">IPS</th>
                                <th class="ds-center">Samapta</th>
                                <th class="ds-center">Pengasuhan</th>
                                <th>Keterangan</th>
                                <th data-filter>Diinput Oleh</th>
                                <th class="ds-center" data-no-sort data-no-filter>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarNilai as $n)
                            <tr>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($n->mahasiswa->nama, 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $n->mahasiswa->nama }}</div>
                                            <div class="tbl-sub">NPM {{ $n->mahasiswa->npm }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ds-badge ds-badge--info">{{ $n->mahasiswa->prodi }}</span> <span class="ds-badge ds-badge--success">Tk. {{ $n->mahasiswa->tingkat }}</span></td>
                                <td class="ds-center"><span class="ds-badge">Smt {{ $n->semester }}</span></td>
                                <td class="nl-skor" style="color:var(--{{ $varianSkor($n->ips, 4) }}-ink)" data-sort="{{ $n->ips }}">{{ number_format($n->ips, 2) }}</td>
                                <td class="nl-skor" style="color:var(--{{ $varianSkor($n->samapta, 100) }}-ink)" data-sort="{{ $n->samapta }}">{{ number_format($n->samapta, 2) }}</td>
                                <td class="nl-skor" style="color:var(--{{ $varianSkor($n->pengasuhan, 100) }}-ink)" data-sort="{{ $n->pengasuhan }}">{{ number_format($n->pengasuhan, 2) }}</td>
                                <td><div class="tbl-sub nl-ket" style="margin:0" title="{{ $n->keterangan }}">{{ $n->keterangan ?: '—' }}</div></td>
                                <td>
                                    <div class="tbl-title">{{ $n->penginput->name ?? '—' }}</div>
                                    <div class="tbl-sub">{{ $n->updated_at->locale('id')->isoFormat('D MMM Y') }}</div>
                                </td>
                                <td class="ds-center">
                                    <form method="POST" action="{{ route('nilai-taruna.destroy', $n) }}" style="margin:0;"
                                          data-konfirmasi="Nilai {{ $n->mahasiswa->nama }} semester {{ $n->semester }} akan dihapus permanen." data-konfirmasi-judul="Hapus Nilai?" data-konfirmasi-tombol="Ya, Hapus">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ds-btn ds-btn--icon ds-btn--danger" title="Hapus" aria-label="Hapus nilai {{ $n->mahasiswa->nama }} semester {{ $n->semester }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

    </div>
</main>

{{-- Modal konfirmasi hapus (di luar panel kaca agar position:fixed tidak terkurung backdrop-filter) --}}
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
document.getElementById('nilaiForm').addEventListener('submit', function (e) {
    if (!document.getElementById('mahasiswaId').value) {
        e.preventDefault();
        namaError.hidden = false;
        namaEl.setAttribute('aria-invalid', 'true');
        namaEl.focus();
    }
});
</script>

</x-app-layout>
