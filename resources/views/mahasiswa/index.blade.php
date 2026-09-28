<x-app-layout>
<x-form-glass-style />
<style>
    /* Filter — pola chip kategori tab Berita */
    .mh-filter { display: flex; flex-direction: column; gap: var(--space-3); }
    .mh-cari { position: relative; }
    .mh-cari i { position: absolute; left: var(--space-3); top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .mh-cari .form-control { padding-left: 34px; }
    .mh-baris { display: flex; align-items: center; gap: var(--space-2); flex-wrap: wrap; }
    .mh-baris__label { min-width: 58px; font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .mh-chip {
        display: inline-flex; align-items: center; gap: var(--space-1-5); padding: var(--space-1-5) var(--space-3);
        border-radius: var(--radius-pill); border: 1px solid var(--border-glass-glow); background: var(--glass-card);
        font-family: inherit; font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); cursor: pointer;
        transition: background-color .15s, color .15s, box-shadow .15s;
    }
    .mh-chip:hover { background: var(--glass-solid); color: var(--ink-900); }
    .mh-chip:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .mh-chip.active, .mh-chip.active:hover { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .mh-chip__jml { font-family: var(--font-mono); font-size: 11px; opacity: .75; }

    /* Tabel dikelompokkan per prodi */
    .mh-table td { vertical-align: middle; }
    .mh-table tr.mh-grup td { padding-top: var(--space-2); padding-bottom: var(--space-2); background: var(--accent-tint) !important; color: var(--accent-ink) !important; font-size: 12px; font-weight: 800; }
    .mh-grup__isi { display: flex; align-items: center; gap: var(--space-2); flex-wrap: wrap; }
    .mh-grup .ds-badge { font-size: 10px; padding: 1px 8px; }
    .mh-akun .tbl-title { font-weight: 600; }
    .mh-no { color: var(--ink-500) !important; font-weight: 700; }
    .mh-table tr[hidden] { display: none; }
</style>

<x-island-navbar />

@php
    $prodiList  = \App\Models\Mahasiswa::PRODI;
    $totalSemua = $mahasiswaData->flatten(1)->count();
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Database Taruna" icon="fa-users"
            subtitle="Biodata, program studi, tingkat, dan akun seluruh taruna aktif PPI Curug" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        <div class="mb-4">
            <x-prodi-tingkat-chart :chart-data="$chartData" />
        </div>

        {{-- Cari + filter prodi & tingkat --}}
        <div class="ds-card mh-filter mb-4">
            <div class="mh-cari">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" id="searchInput" class="form-control" placeholder="Cari nama lengkap, NPM, atau nickname taruna..." oninput="applyFilters()" aria-label="Cari taruna">
            </div>
            <div class="mh-baris" role="group" aria-label="Filter program studi">
                <span class="mh-baris__label">Prodi</span>
                <button type="button" class="mh-chip active" data-prodi="all" onclick="setProdi('all')">Semua <span class="mh-chip__jml">{{ $totalSemua }}</span></button>
                @foreach($prodiList as $kode => $info)
                <button type="button" class="mh-chip" data-prodi="{{ $kode }}" onclick="setProdi('{{ $kode }}')" title="{{ $info['jenjang'] }} · {{ $info['nama'] }}">
                    {{ $kode }} <span class="mh-chip__jml">{{ ($mahasiswaData[$kode] ?? collect())->count() }}</span>
                </button>
                @endforeach
            </div>
            <div class="mh-baris" role="group" aria-label="Filter tingkat">
                <span class="mh-baris__label">Tingkat</span>
                <button type="button" class="mh-chip active" data-tingkat="all" onclick="setTingkat('all')">Semua</button>
                @for($t = 1; $t <= 4; $t++)
                <button type="button" class="mh-chip" data-tingkat="{{ $t }}" onclick="setTingkat('{{ $t }}')">Tingkat {{ $t }}</button>
                @endfor
            </div>
        </div>

        {{-- Tabel taruna --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-address-book ds-icon"></i> <span id="tableTitle">Semua Taruna</span></h3>
                    <p class="ds-card__desc">Dikelompokkan per program studi, urut tingkat lalu nama</p>
                </div>
                <span class="ds-badge ds-badge--accent" id="tableCount">{{ $totalSemua }} taruna</span>
            </div>

            @if($totalSemua === 0)
            <div class="ds-empty"><i class="fa-solid fa-users-slash ds-icon"></i> Belum ada data taruna.</div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    {{-- data-no-tools: filter & kelompok prodi ditangani skrip halaman ini --}}
                    <table class="ds-table tbl-table mh-table" data-no-tools>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Taruna</th>
                                <th>L/P</th>
                                <th>Tingkat</th>
                                <th>Akun</th>
                                <th class="ds-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($mahasiswaData as $kode => $students)
                            @php $info = $prodiList[$kode] ?? ['nama' => $kode, 'jenjang' => '-']; @endphp
                            <tr class="mh-grup" data-prodi="{{ $kode }}">
                                <td colspan="6">
                                    <span class="mh-grup__isi">
                                        <i class="fa-solid fa-graduation-cap"></i> {{ $kode }} — {{ $info['nama'] }}
                                        <span class="ds-badge ds-badge--accent">{{ $info['jenjang'] }}</span>
                                        <span class="ds-badge">{{ count($students) }} taruna</span>
                                    </span>
                                </td>
                            </tr>
                            @foreach($students as $student)
                            <tr class="mh-baris-taruna"
                                data-prodi="{{ $kode }}"
                                data-tingkat="{{ $student->tingkat }}"
                                data-search="{{ strtolower($student->nama . ' ' . $student->npm . ' ' . $student->nickname) }}">
                                <td class="mh-no">{{ $no++ }}</td>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($student->nickname ?: $student->nama, 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $student->nama }}</div>
                                            <div class="tbl-sub">NPM {{ $student->npm ?? '—' }}{{ $student->nickname ? ' · ' . $student->nickname : '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($student->jenis_kelamin)
                                    <span class="ds-badge {{ $student->jenis_kelamin === 'L' ? 'ds-badge--info' : 'ds-badge--danger' }}">{{ $student->jenis_kelamin }}</span>
                                    @else
                                    <span class="tbl-sub">—</span>
                                    @endif
                                </td>
                                <td><span class="ds-badge ds-badge--success">Tk. {{ $student->tingkat }}</span></td>
                                <td class="mh-akun">
                                    <div class="tbl-title">{{ $student->user->email ?? '—' }}</div>
                                    @if($student->user?->username)<div class="tbl-sub">{{ '@' . $student->user->username }}</div>@endif
                                </td>
                                <td class="ds-center">
                                    <a href="{{ route('mahasiswa.edit', $student) }}" class="ds-btn ds-btn--sm ds-btn--pill" aria-label="Ubah biodata {{ $student->nama }}"><i class="fa-solid fa-pen"></i> Ubah</a>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="ds-empty" id="emptySearch" hidden>
                <i class="fa-solid fa-magnifying-glass ds-icon"></i> Tidak ada taruna yang cocok dengan filter atau pencarian.
            </div>
            @endif
        </div>

    </div>
</main>

<script>
const PRODI_NAMA = @json(collect($prodiList)->map(fn ($i) => $i['nama']));
let currentProdi = 'all';
let currentTingkat = 'all';

function tandaiChip(attr, nilai) {
    document.querySelectorAll('.mh-chip[data-' + attr + ']').forEach(c => c.classList.toggle('active', c.dataset[attr] === nilai));
}
function setProdi(kode) { currentProdi = kode; tandaiChip('prodi', kode); applyFilters(); }
function setTingkat(t) { currentTingkat = t; tandaiChip('tingkat', t); applyFilters(); }

function applyFilters() {
    const q = document.getElementById('searchInput').value.toLowerCase().trim();
    const perProdi = {};
    let tampil = 0;

    document.querySelectorAll('.mh-baris-taruna').forEach(row => {
        const cocok = (currentProdi === 'all' || row.dataset.prodi === currentProdi)
            && (currentTingkat === 'all' || row.dataset.tingkat === currentTingkat)
            && (!q || row.dataset.search.includes(q));
        row.hidden = !cocok;
        if (cocok) { tampil++; perProdi[row.dataset.prodi] = true; }
    });
    // Baris judul prodi hanya tampil bila ada taruna yang lolos filter
    document.querySelectorAll('.mh-grup').forEach(h => h.hidden = !perProdi[h.dataset.prodi]);

    document.getElementById('tableCount').textContent = tampil + ' taruna';
    const kosong = document.getElementById('emptySearch');
    if (kosong) kosong.hidden = tampil > 0;

    let judul = currentProdi === 'all' ? 'Semua Taruna' : currentProdi + ' — ' + (PRODI_NAMA[currentProdi] || currentProdi);
    if (currentTingkat !== 'all') judul += ' · Tingkat ' + currentTingkat;
    document.getElementById('tableTitle').textContent = judul;
}
</script>

</x-app-layout>
