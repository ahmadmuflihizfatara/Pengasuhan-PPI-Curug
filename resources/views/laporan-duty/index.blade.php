<x-app-layout>

<x-island-navbar />

@php $isTaruna = auth()->user()->isTaruna(); @endphp

<style>
/* Kepala panel (tabel taruna sakit & duty minggu ini) */
.sakit-head {
    padding: var(--space-4) var(--space-5); border-bottom: 1px solid var(--border-glass);
    display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap;
}
.sakit-head__judul { margin: 0; font-size: 16px; line-height: 22px; font-weight: 800; color: var(--ink-900); display: flex; align-items: center; gap: var(--space-2); }
.sakit-head__judul i { color: var(--danger-ink); }
.sakit-head__desc { margin: 2px 0 0; font-size: 12px; font-weight: 500; color: var(--ink-600); }
.sakit-head__jumlah { font-size: 12px; padding: var(--space-1) var(--space-3); }

/* Daftar duty minggu ini */
.duty-row { display: flex; align-items: center; gap: var(--space-2-5); padding: var(--space-2-5) var(--space-5); border-top: 1px solid var(--border-glass-subtle); transition: background-color .15s; }
.sakit-head + .duty-row { border-top: 0; }
.duty-row:hover { background: rgba(255,255,255,0.60); }
.duty-row--saya { background: var(--accent-tint); }
.duty-row__isi { flex: 1; min-width: 0; }
.duty-row .ds-name { font-weight: 700; color: var(--ink-900); display: flex; align-items: center; gap: var(--space-1-5); }

/* ponytail: keterbacaan — ukuran & kontras teks ds dinaikkan hanya di halaman ini */
.laporan-duty .ds-table { font-size: 13px; line-height: 18px; }
.laporan-duty .ds-table thead th { font-size: 11px; color: var(--ink-900); }
.laporan-duty .ds-table .ds-num { color: var(--ink-600); }
.laporan-duty .ds-table tbody td .ds-badge + .ds-badge { margin-left: var(--space-1); }
.laporan-duty .ds-name { font-size: 13px; }
.laporan-duty .ds-mono { font-size: 11px; color: var(--ink-600); }
.laporan-duty .ds-badge { font-size: 11px; }
.laporan-duty .ds-empty { font-size: 13px; color: var(--ink-600); }
.laporan-duty .ds-label { font-size: 11px; color: var(--ink-900); }
.laporan-duty .ds-input { font-size: 13px; }
</style>

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="laporan-duty spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab poin & log gerbang --}}
        <x-page-banner title="Laporan Duty Taruna"
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
        <div class="ds-alert ds-alert--success lapor-alert" role="status">
            <span class="lapor-alert__ikon"><i class="fa-solid fa-circle-check"></i></span>
            <div>
                <div class="lapor-alert__judul">Berhasil</div>
                <div class="lapor-alert__pesan">{{ session('success') }}</div>
            </div>
        </div>
        @endif
        @if($errors->any())
        <div class="ds-alert ds-alert--danger lapor-alert" role="alert">
            <span class="lapor-alert__ikon"><i class="fa-solid fa-circle-exclamation"></i></span>
            <div>
                <div class="lapor-alert__judul">Laporan belum terkirim</div>
                @foreach($errors->all() as $e)<div class="lapor-alert__pesan">{{ $e }}</div>@endforeach
            </div>
        </div>
        @endif
        <style>
            .lapor-alert { align-items: center; gap: var(--space-3); }
            .ds-alert--success.lapor-alert { border-color: var(--success-border); }
            .lapor-alert__ikon {
                width: 36px; height: 36px; border-radius: var(--radius-pill); flex-shrink: 0;
                display: grid; place-items: center; font-size: 16px;
            }
            .ds-alert--success .lapor-alert__ikon { background: var(--success-tint); color: var(--success-ink); }
            .ds-alert--danger  .lapor-alert__ikon { background: var(--danger-tint);  color: var(--danger-ink); }
            .lapor-alert__judul { font-size: 13px; font-weight: 800; color: var(--ink-900); }
            .lapor-alert__pesan { font-size: 12px; font-weight: 500; color: var(--ink-700); margin-top: 1px; }
        </style>

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
                <div class="ds-table-wrap">
                    <div class="sakit-head">
                        <div>
                            <h3 class="sakit-head__judul"><i class="fa-solid fa-notes-medical"></i> Taruna Sakit {{ $tanggal->isToday() ? 'Hari Ini' : $tanggal->locale('id')->isoFormat('D MMMM Y') }}</h3>
                            <p class="sakit-head__desc">{{ $tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }} · dilaporkan oleh taruna duty</p>
                        </div>
                        <span class="ds-badge {{ $laporan->isEmpty() ? 'ds-badge--success' : 'ds-badge--danger' }} sakit-head__jumlah">{{ $laporan->count() }} taruna</span>
                    </div>

                    @if($laporan->isEmpty())
                    <div class="ds-empty">
                        <i class="fa-solid fa-circle-check ds-icon" style="color:var(--success)"></i>
                        Belum ada laporan taruna sakit.
                    </div>
                    @else
                    <div class="ds-scroll">
                    <table class="ds-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Taruna</th>
                                <th>Prodi / Tingkat</th>
                                <th>Keterangan</th>
                                <th>Pelapor</th>
                                <th class="ds-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $l)
                            @php $bolehHapus = !$isTaruna || ($l->dilaporkan_oleh === auth()->id() && $l->tanggal->isToday()); @endphp
                            <tr>
                                <td class="ds-num">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($l->mahasiswa->nama, 0, 2)) }}</span>
                                        <div>
                                            <div class="ds-name">{{ $l->mahasiswa->nama }}</div>
                                            <div class="ds-mono">{{ $l->mahasiswa->npm }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="ds-badge ds-badge--info">{{ $l->mahasiswa->prodi ?? '-' }}</span>
                                    <span class="ds-badge ds-badge--success">Tk {{ $l->mahasiswa->tingkat ?? '-' }}</span>
                                </td>
                                <td style="color:var(--ink-700); min-width:180px;">{{ $l->keterangan ?: '-' }}</td>
                                <td>
                                    <div style="font-weight:600;">{{ $l->pelapor->name ?? '-' }}</div>
                                    <div class="ds-mono"><i class="fa-regular fa-clock"></i> {{ $l->updated_at->format('H:i') }}</div>
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
                    @endif
                </div>
            </div>

            {{-- Duty minggu ini --}}
            <div>
                <div class="ds-table-wrap">
                    <div class="sakit-head">
                        <div>
                            <h3 class="sakit-head__judul"><i class="fa-solid fa-users-rectangle" style="color:var(--success-ink)"></i> Duty Minggu Ini</h3>
                            <p class="sakit-head__desc">{{ \App\Models\DutyTaruna::labelPeriode(\App\Models\DutyTaruna::awalMinggu()) }}</p>
                        </div>
                        <span class="ds-badge ds-badge--success sakit-head__jumlah">{{ $dutyMinggu->count() }} taruna</span>
                    </div>

                    @php $mahasiswaSaya = auth()->user()->mahasiswa?->id; @endphp
                    @forelse($dutyMinggu->sortBy(fn ($d) => $d->mahasiswa->nama ?? '') as $d)
                    <div class="duty-row {{ $mahasiswaSaya && $d->mahasiswa_id === $mahasiswaSaya ? 'duty-row--saya' : '' }}">
                        <span class="ds-avatar">{{ strtoupper(substr($d->mahasiswa->nama ?? '?', 0, 2)) }}</span>
                        <div class="duty-row__isi">
                            <div class="ds-name">
                                {{ $d->mahasiswa->nama ?? '-' }}
                                @if($mahasiswaSaya && $d->mahasiswa_id === $mahasiswaSaya)<span class="ds-badge ds-badge--accent">Saya</span>@endif
                            </div>
                            <div class="ds-mono">{{ $d->mahasiswa->npm ?? '-' }}</div>
                        </div>
                        <span class="ds-badge ds-badge--info">{{ $d->mahasiswa->prodi ?? '-' }}</span>
                    </div>
                    @empty
                    <div class="ds-empty">
                        <i class="fa-solid fa-clipboard-list ds-icon"></i>
                        Duty minggu ini belum diisi.
                    </div>
                    @endforelse
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
