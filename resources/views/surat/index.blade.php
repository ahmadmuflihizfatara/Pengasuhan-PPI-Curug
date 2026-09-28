<x-app-layout>
<x-form-glass-style />
<style>
    /* Kartu aksi */
    .sr-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .sr-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
    .sr-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }

    /* Filter — pola filter Log Gerbang & Barak */
    .sr-filter { display: grid; grid-template-columns: minmax(0, 4fr) minmax(0, 3fr) minmax(0, 2fr) auto; gap: var(--space-2-5); align-items: end; }
    @media (max-width: 1023px) { .sr-filter { grid-template-columns: 1fr 1fr; } .sr-filter__cari, .sr-filter__aksi { grid-column: 1 / -1; } }
    .sr-filter .form-group { margin: 0; }
    .sr-filter__cari { position: relative; }
    .sr-filter__cari i { position: absolute; left: var(--space-3); bottom: 12px; font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .sr-filter__cari .form-control { padding-left: 34px; }
    .sr-filter__aksi { display: flex; gap: var(--space-2); }
    .sr-filter__aksi .ds-btn { height: 38px; }
    .sr-filter__aksi .ds-btn--primary { flex: 1; justify-content: center; }

    .sr-table td { vertical-align: top; }
    .sr-table td:nth-child(2) { min-width: 180px; }
    .sr-perihal { max-width: 240px; }
    .sr-perihal .tbl-title, .sr-perihal .tbl-sub { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sr-link { color: inherit; text-decoration: none; }
    .sr-link:hover { color: var(--accent-ink); text-decoration: underline; }
    .sr-nomor { font-family: var(--font-mono); font-size: 12px; font-weight: 800; color: var(--accent-ink); white-space: nowrap; }
    .sr-aksi-sel { display: inline-flex; gap: var(--space-1); }
    .sr-aksi-sel form { margin: 0; }
    .sr-pagination { margin-top: var(--space-4); }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php $adaFilter = request()->hasAny(['search', 'jenis', 'status']); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab lain --}}
        <x-page-banner title="Administrasi Surat Pengasuhan" icon="fa-envelope-open-text"
            subtitle="Kelola dan pantau permohonan surat izin, surat keterangan, dan disposisi pengasuhan" />

        <div class="ds-card sr-aksi mb-4">
            <span class="sr-aksi__teks"><i class="fa-solid fa-file-circle-plus"></i>Catat surat masuk, surat keluar, atau disposisi baru</span>
            <a href="{{ route('surat.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Tambah Surat Baru</a>
        </div>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        {{-- Statistik — klik untuk menyaring status --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-4">
            <x-stat-card title="Total Surat" :value="$stats['total']" icon="fa-solid fa-envelope"
                varian="accent" badge="Semua" badgeType="accent" :href="route('surat.index')" description="Seluruh surat tercatat" />
            <x-stat-card title="Diproses" :value="$stats['diproses']" icon="fa-solid fa-hourglass-half"
                varian="warning" badge="Menunggu" badgeType="warning" :href="route('surat.index', ['status' => 'Diproses'])" description="Perlu ditinjau" />
            <x-stat-card title="Disetujui" :value="$stats['disetujui']" icon="fa-solid fa-circle-check"
                varian="success" badge="Disetujui" badgeType="success" :href="route('surat.index', ['status' => 'Disetujui'])" description="Permohonan disetujui" />
            <x-stat-card title="Ditolak" :value="$stats['ditolak']" icon="fa-solid fa-circle-xmark"
                varian="danger" badge="Ditolak" badgeType="danger" :href="route('surat.index', ['status' => 'Ditolak'])" description="Permohonan ditolak" />
            <x-stat-card title="Selesai" :value="$stats['selesai']" icon="fa-solid fa-flag-checkered"
                varian="info" badge="Tuntas" badgeType="accent" :href="route('surat.index', ['status' => 'Selesai'])" description="Surat selesai diproses" />
        </div>

        {{-- Filter --}}
        <div class="ds-card mb-4">
            <form method="GET" action="{{ route('surat.index') }}" class="sr-filter" role="search">
                <div class="form-group sr-filter__cari">
                    <label class="form-label" for="srCari">Cari</label>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="srCari" name="search" value="{{ request('search') }}" class="form-control" placeholder="Perihal, pengirim, nomor surat...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="srJenis">Jenis Surat</label>
                    <select id="srJenis" name="jenis" class="form-select">
                        <option value="">Semua jenis</option>
                        @foreach(\App\Models\Surat::jenisSuratList() as $j)
                        <option value="{{ $j }}" @selected(request('jenis') === $j)>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="srStatus">Status</label>
                    <select id="srStatus" name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach(\App\Models\Surat::statusList() as $st)
                        <option value="{{ $st }}" @selected(request('status') === $st)>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sr-filter__aksi">
                    <button type="submit" class="ds-btn ds-btn--primary"><i class="fa-solid fa-filter"></i> Terapkan</button>
                    @if($adaFilter)
                    <a href="{{ route('surat.index') }}" class="ds-btn" title="Reset filter" aria-label="Reset filter"><i class="fa-solid fa-xmark"></i></a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel surat --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-envelope-open-text ds-icon"></i> Daftar Surat</h3>
                    <p class="ds-card__desc">{{ $adaFilter ? 'Hasil sesuai filter' : 'Surat terbaru tampil paling atas' }} — setujui atau tolak surat yang masih diproses langsung dari tabel</p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ $surat->total() }} surat</span>
            </div>

            @if($surat->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-inbox ds-icon"></i>
                {{ $adaFilter ? 'Tidak ada surat yang cocok dengan filter.' : 'Belum ada data surat.' }}
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table data-server-sort class="ds-table tbl-table sr-table">
                        <thead>
                            <tr>
                                <th data-sort="nomor">No. Surat</th>
                                <th data-sort="perihal">Perihal</th>
                                <th data-sort="jenis">Jenis</th>
                                <th data-sort="pengirim">Pengirim / Penerima</th>
                                <th data-sort="tanggal">Tanggal</th>
                                <th data-sort="status">Status</th>
                                <th class="ds-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surat as $s)
                            <tr>
                                <td class="sr-nomor">{{ $s->nomor_surat ?: '—' }}</td>
                                <td class="sr-perihal">
                                    <div class="tbl-title"><a href="{{ route('surat.show', $s->id) }}" class="sr-link">{{ $s->perihal }}</a></div>
                                    @if($s->keterangan)<div class="tbl-sub">{{ $s->keterangan }}</div>@endif
                                </td>
                                <td><span class="ds-badge ds-badge--info">{{ $s->jenis_surat }}</span></td>
                                <td>
                                    <div class="tbl-title">{{ $s->pengirim }}</div>
                                    <div class="tbl-sub"><i class="fa-solid fa-arrow-right" style="font-size:9px"></i> {{ $s->penerima }}</div>
                                    @if($s->isDiajukanTaruna())
                                    <span class="ds-badge ds-badge--warning mt-1"><i class="fa-solid fa-user-graduate"></i> Taruna</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="tbl-title" style="white-space:nowrap">{{ $s->tanggal_surat->locale('id')->isoFormat('D MMM Y') }}</div>
                                    @if($s->tanggal_terima)<div class="tbl-sub" style="white-space:nowrap">Terima {{ $s->tanggal_terima->locale('id')->isoFormat('D MMM Y') }}</div>@endif
                                </td>
                                <td><span class="ds-badge ds-badge--{{ $s->status_varian }}">{{ $s->status }}</span></td>
                                <td class="ds-center">
                                    <div class="sr-aksi-sel">
                                        @if($s->status === 'Diproses')
                                        <form method="POST" action="{{ route('surat.updateStatus', $s->id) }}"
                                              data-konfirmasi="Surat &quot;{{ Str::limit($s->perihal, 60) }}&quot; akan disetujui." data-konfirmasi-judul="Setujui Surat?" data-konfirmasi-varian="success" data-konfirmasi-tombol="Ya, Setujui">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="Disetujui">
                                            <button type="submit" class="ds-btn ds-btn--icon ds-btn--success" title="Setujui" aria-label="Setujui surat {{ $s->perihal }}"><i class="fa-solid fa-check"></i></button>
                                        </form>
                                        <form method="POST" action="{{ route('surat.updateStatus', $s->id) }}"
                                              data-konfirmasi="Surat &quot;{{ Str::limit($s->perihal, 60) }}&quot; akan ditolak. Tambahkan catatan untuk taruna lewat halaman detail bila perlu." data-konfirmasi-judul="Tolak Surat?" data-konfirmasi-tombol="Ya, Tolak">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" class="ds-btn ds-btn--icon ds-btn--danger" title="Tolak" aria-label="Tolak surat {{ $s->perihal }}"><i class="fa-solid fa-xmark"></i></button>
                                        </form>
                                        @endif
                                        <a href="{{ route('surat.show', $s->id) }}" class="ds-btn ds-btn--icon" title="Detail" aria-label="Detail surat {{ $s->perihal }}"><i class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('surat.edit', $s->id) }}" class="ds-btn ds-btn--icon" title="Ubah" aria-label="Ubah surat {{ $s->perihal }}"><i class="fa-solid fa-pen"></i></a>
                                        <form method="POST" action="{{ route('surat.destroy', $s->id) }}"
                                              data-konfirmasi="Surat &quot;{{ Str::limit($s->perihal, 60) }}&quot; akan dihapus permanen dari sistem." data-konfirmasi-judul="Hapus Surat?" data-konfirmasi-tombol="Ya, Hapus">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="ds-btn ds-btn--icon ds-btn--danger" title="Hapus" aria-label="Hapus surat {{ $s->perihal }}"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($surat->hasPages())
            <div class="sr-pagination">{{ $surat->links() }}</div>
            @endif
            @endif
        </div>

    </div>
</main>

<x-konfirmasi-modal />

</x-app-layout>
