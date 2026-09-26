<x-app-layout>

<x-island-navbar />

@php $isTaruna = auth()->user()->isTaruna(); @endphp

<style>
/* Tabel memakai pola tbl-* (app.css) — sama dengan dashboard & poin */
.ds-table tr.duty-saya { background: var(--accent-tint); }
.laporan-duty .ds-label { font-size: 11px; color: var(--ink-900); }
.laporan-duty .ds-input { font-size: 13px; }
</style>

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="laporan-duty spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab poin & log gerbang --}}
        <x-page-banner title="Laporan Duty Taruna" icon="fa-notes-medical"
            :subtitle="$isTaruna ? 'Laporkan taruna yang sakit hari ini kepada pengasuh.' : 'Laporan taruna sakit yang masuk dari taruna duty.'" />

        {{-- Kartu tanggal (dipindah dari header) --}}
        <div class="tanggal-card mb-6">
            <div class="tanggal-card__item">
                <span class="tanggal-card__ikon"><i class="fa-solid fa-calendar-day"></i></span>
                <div>
                    <div class="tanggal-card__label">Tanggal Laporan</div>
                    <div class="tanggal-card__value">{{ $tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                </div>
            </div>
            <div class="tanggal-card__item">
                <span class="tanggal-card__ikon"><i class="fa-solid fa-calendar-week"></i></span>
                <div>
                    <div class="tanggal-card__label">{{ $isTaruna ? 'Periode Duty Anda' : 'Periode Duty' }}</div>
                    <div class="tanggal-card__value">{{ \App\Models\DutyTaruna::labelPeriode(\App\Models\DutyTaruna::awalMinggu()) }}</div>
                </div>
            </div>
        </div>
        <style>
            .tanggal-card {
                display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                border-radius: var(--radius-lg); overflow: hidden; color: var(--ink-on-dark);
                background: linear-gradient(135deg, #e11d48, #f97316);
                border: 1px solid rgba(255,255,255,.35); box-shadow: var(--shadow-glass);
            }
            .tanggal-card__item { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-4) var(--space-5); }
            .tanggal-card__item + .tanggal-card__item { border-left: 1px solid rgba(255,255,255,.25); }
            .tanggal-card__ikon {
                width: 40px; height: 40px; border-radius: var(--radius-md); flex-shrink: 0;
                display: grid; place-items: center; font-size: 16px;
                background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3);
            }
            .tanggal-card__label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; opacity: .85; }
            .tanggal-card__value { font-size: 15px; font-weight: 800; margin-top: 2px; }
            @media (max-width: 540px) { .tanggal-card__item + .tanggal-card__item { border-left: 0; border-top: 1px solid rgba(255,255,255,.25); } }
        </style>

        {{-- Alerts --}}
        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Laporan belum terkirim">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        @if($isTaruna)
        {{-- Form lapor (taruna duty) --}}
        <div class="ds-card lapor-card mb-6">
            <div class="ds-card__head">
                <h2 class="ds-card__title"><i class="fa-solid fa-user-injured ds-icon"></i> Laporkan Taruna Sakit Hari Ini</h2>
                <p class="ds-card__desc">Ketik nama taruna yang sakit lalu pilih dari saran. Lapor ulang nama yang sama akan memperbarui keterangan.</p>
            </div>

            <form method="POST" action="{{ route('laporan-duty.store') }}" id="laporForm">
                @csrf
                <div class="ds-form-grid ds-form-grid--2 mb-4">
                    <div>
                        <label for="namaTaruna" class="ds-label">Nama Taruna Sakit <span style="color:var(--danger-ink)">*</span></label>
                        <input type="text" id="namaTaruna" list="daftarTaruna"
                               class="ds-input @error('mahasiswa_id') ds-input--invalid @enderror"
                               placeholder="Ketik nama taruna..." autocomplete="off" required>
                        <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                        @error('mahasiswa_id')<div class="ds-error">{{ $message }}</div>@enderror
                        <div class="flex items-center gap-2 mt-2" id="infoTaruna" style="display:none;">
                            <span class="ds-badge ds-badge--info" id="infoProdi"></span>
                            <span class="ds-badge ds-badge--success" id="infoTingkat"></span>
                        </div>
                    </div>
                    <div>
                        <label for="keterangan" class="ds-label">Keterangan / Keluhan</label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                                  class="ds-textarea @error('keterangan') ds-input--invalid @enderror"
                                  placeholder="Contoh: demam sejak pagi, istirahat di barak...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <datalist id="daftarTaruna">
                    @foreach($daftarTaruna as $t)
                    <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                    @endforeach
                </datalist>

                <button type="submit" class="ds-btn ds-btn--primary">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Laporan
                </button>
            </form>
        </div>
        <style>
            /* ponytail: ukuran teks sedikit dinaikkan dari default ds agar form lapor lebih terbaca */
            .lapor-card { background: var(--glass-card); }
            .lapor-card .ds-card__desc { font-size: 12px; line-height: 16px; }
            .lapor-card .ds-input, .lapor-card .ds-textarea { font-size: 13px; line-height: 18px; background: var(--glass-solid); resize: vertical; }
        </style>
        @else
        {{-- Pilih tanggal (pengasuh/admin) --}}
        <form method="GET" action="{{ route('laporan-duty.index') }}" class="ds-card mb-6" style="display:flex; align-items:flex-end; gap:var(--space-3); flex-wrap:wrap;">
            <div style="flex:0 1 260px; min-width:200px;">
                <label for="tanggalLaporan" class="ds-label">Tanggal Laporan</label>
                <input type="date" id="tanggalLaporan" name="tanggal" value="{{ $tanggal->toDateString() }}" max="{{ now()->toDateString() }}"
                       class="ds-input" onchange="this.form.submit()">
            </div>
            @unless($tanggal->isToday())
            <a href="{{ route('laporan-duty.index') }}" class="ds-btn ds-btn--ghost"><i class="fa-solid fa-rotate-left"></i> Hari ini</a>
            @endunless
        </form>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Laporan masuk --}}
            <div class="lg:col-span-2">
                <div class="ds-card">
                    <div class="ds-card__head tbl-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-notes-medical ds-icon"></i> Taruna Sakit {{ $tanggal->isToday() ? 'Hari Ini' : $tanggal->locale('id')->isoFormat('D MMMM Y') }}</h3>
                            <p class="ds-card__desc">{{ $tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }} · dilaporkan oleh taruna duty</p>
                        </div>
                        <span class="ds-badge {{ $laporan->isEmpty() ? 'ds-badge--success' : 'ds-badge--danger' }}">{{ $laporan->count() }} taruna</span>
                    </div>

                    @if($laporan->isEmpty())
                    <div class="ds-empty">
                        <i class="fa-solid fa-circle-check ds-icon"></i>
                        Belum ada laporan taruna sakit.
                    </div>
                    @else
                    <div class="ds-table-wrap">
                        <div class="ds-scroll">
                            <table class="ds-table tbl-table">
                                <thead>
                                    <tr>
                                        <th>Taruna</th>
                                        <th data-filter>Prodi</th>
                                        <th>Keterangan</th>
                                        <th data-filter>Pelapor</th>
                                        <th class="ds-right" data-no-sort>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($laporan as $l)
                                    @php $bolehHapus = !$isTaruna || ($l->dilaporkan_oleh === auth()->id() && $l->tanggal->isToday()); @endphp
                                    <tr>
                                        <td>
                                            <div class="ds-cell-person">
                                                <span class="ds-avatar">{{ strtoupper(substr($l->mahasiswa->nama, 0, 2)) }}</span>
                                                <div>
                                                    <div class="tbl-title">{{ $l->mahasiswa->nama }}</div>
                                                    <div class="tbl-sub">NPM {{ $l->mahasiswa->npm }} · Tk. {{ $l->mahasiswa->tingkat ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="ds-badge ds-badge--info">{{ $l->mahasiswa->prodi ?? '-' }}</span></td>
                                        <td style="min-width:180px;"><div class="tbl-sub" style="margin:0; font-size:12px; color:var(--ink-700);">{{ $l->keterangan ?: '—' }}</div></td>
                                        <td class="tbl-muted">
                                            {{ $l->pelapor->name ?? '-' }}
                                            <div class="tbl-sub"><i class="fa-regular fa-clock"></i> {{ $l->updated_at->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="ds-right">
                                            @if($bolehHapus)
                                            <form method="POST" action="{{ route('laporan-duty.destroy', $l) }}" onsubmit="return confirm('Hapus laporan {{ $l->mahasiswa->nama }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="ds-btn ds-btn--icon ds-btn--danger" title="Hapus laporan" aria-label="Hapus laporan {{ $l->mahasiswa->nama }}"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                            @endif
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

            {{-- Duty minggu ini --}}
            <div>
                <div class="ds-card">
                    <div class="ds-card__head tbl-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-user-group ds-icon"></i> Duty Minggu Ini</h3>
                            <p class="ds-card__desc">{{ \App\Models\DutyTaruna::labelPeriode(\App\Models\DutyTaruna::awalMinggu()) }}</p>
                        </div>
                        <span class="ds-badge ds-badge--success">{{ $dutyMinggu->count() }} taruna</span>
                    </div>

                    @if($dutyMinggu->isEmpty())
                    <div class="ds-empty">
                        <i class="fa-solid fa-clipboard-list ds-icon"></i>
                        Duty minggu ini belum diisi.
                    </div>
                    @else
                    @php $mahasiswaSaya = auth()->user()->mahasiswa?->id; @endphp
                    <div class="ds-table-wrap">
                        <div class="ds-scroll">
                            <table class="ds-table tbl-table" data-no-tools>
                                <thead>
                                    <tr>
                                        <th>Nama Taruna</th>
                                        <th class="ds-right">Prodi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dutyMinggu->sortBy(fn ($d) => $d->mahasiswa->nama ?? '') as $d)
                                    @php $saya = $mahasiswaSaya && $d->mahasiswa_id === $mahasiswaSaya; @endphp
                                    <tr class="{{ $saya ? 'duty-saya' : '' }}">
                                        <td>
                                            <div class="ds-cell-person">
                                                <span class="ds-avatar">{{ strtoupper(substr($d->mahasiswa->nama ?? '?', 0, 2)) }}</span>
                                                <div>
                                                    <div class="tbl-title">{{ $d->mahasiswa->nama ?? '-' }} @if($saya)<span class="ds-badge ds-badge--accent">Saya</span>@endif</div>
                                                    <div class="tbl-sub">NPM {{ $d->mahasiswa->npm ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="ds-right"><span class="ds-badge ds-badge--info">{{ $d->mahasiswa->prodi ?? '-' }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>

@if($isTaruna)
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

document.getElementById('laporForm').addEventListener('submit', function(e) {
    if (!document.getElementById('mahasiswaId').value) {
        e.preventDefault();
        namaEl.focus();
        alert('Pilih nama taruna yang cocok dari daftar (ketik lalu pilih dari saran).');
    }
});
</script>
@endif

</x-app-layout>
