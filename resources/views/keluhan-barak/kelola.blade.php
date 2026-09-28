<x-app-layout>
<x-form-glass-style />
<style>
    /* Filter — pola filter tab Log Gerbang */
    .kb-filter { display: grid; grid-template-columns: minmax(0, 4fr) minmax(0, 2fr) minmax(0, 2fr) auto; gap: var(--space-2-5); align-items: end; }
    @media (max-width: 1023px) { .kb-filter { grid-template-columns: 1fr 1fr; } .kb-filter__cari, .kb-filter__aksi { grid-column: 1 / -1; } }
    .kb-filter .form-group { margin: 0; }
    .kb-filter__cari { position: relative; }
    .kb-filter__cari i { position: absolute; left: var(--space-3); bottom: 12px; font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .kb-filter__cari .form-control { padding-left: 34px; }
    .kb-filter__aksi { display: flex; gap: var(--space-2); }
    .kb-filter__aksi .ds-btn { height: 38px; }
    .kb-filter__aksi .ds-btn--primary { flex: 1; justify-content: center; }
    .kb-pdf i { color: var(--danger); }

    .kb-table td { vertical-align: top; }
    .kb-table td:first-child { min-width: 200px; }
    .kb-pagination { margin-top: var(--space-4); }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php $adaFilter = request()->hasAny(['search', 'asrama', 'status']); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab lain --}}
        <x-page-banner title="Kelola Keluhan Barak" icon="fa-door-open"
            subtitle="Disposisi, proses perbaikan, dan verifikasi keluhan sarana barak taruna" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif

        {{-- Statistik — klik untuk menyaring status --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-4">
            <x-stat-card title="Total Keluhan" :value="$stats['total']" icon="fa-solid fa-door-open"
                varian="accent" badge="Semua" badgeType="accent" :href="route('keluhan-barak.kelola')" description="Seluruh keluhan barak" />
            <x-stat-card title="Diajukan" :value="$stats['diajukan']" icon="fa-solid fa-hourglass-half"
                varian="warning" badge="Baru" badgeType="warning" :href="route('keluhan-barak.kelola', ['status' => 'Diajukan'])" description="Menunggu ditinjau" />
            <x-stat-card title="Diproses" :value="$stats['diproses']" icon="fa-solid fa-screwdriver-wrench"
                varian="info" badge="Ditangani" badgeType="info" :href="route('keluhan-barak.kelola', ['status' => 'Diproses'])" description="Sedang diperbaiki" />
            <x-stat-card title="Selesai" :value="$stats['selesai']" icon="fa-solid fa-circle-check"
                varian="success" badge="Tuntas" badgeType="success" :href="route('keluhan-barak.kelola', ['status' => 'Selesai'])" description="Perbaikan selesai" />
            <x-stat-card title="Ditolak" :value="$stats['ditolak']" icon="fa-solid fa-circle-xmark"
                varian="danger" badge="Ditolak" badgeType="danger" :href="route('keluhan-barak.kelola', ['status' => 'Ditolak'])" description="Tidak dapat diproses" />
        </div>

        {{-- Filter --}}
        <div class="ds-card mb-4">
            <form method="GET" action="{{ route('keluhan-barak.kelola') }}" class="kb-filter" role="search">
                <div class="form-group kb-filter__cari">
                    <label class="form-label" for="kbCari">Cari</label>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="kbCari" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nama taruna, email, nomor barak...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="kbAsrama">Asrama</label>
                    <select id="kbAsrama" name="asrama" class="form-select">
                        <option value="">Semua asrama</option>
                        @foreach($asramaList as $a)
                        <option value="{{ $a }}" @selected(request('asrama') === $a)>{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="kbStatus">Status</label>
                    <select id="kbStatus" name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach($statusList as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="kb-filter__aksi">
                    <button type="submit" class="ds-btn ds-btn--primary"><i class="fa-solid fa-filter"></i> Terapkan</button>
                    <a href="{{ route('keluhan-barak.exportPdf', request()->only(['search', 'asrama', 'status'])) }}" class="ds-btn kb-pdf" title="Ekspor PDF sesuai filter"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                    @if($adaFilter)
                    <a href="{{ route('keluhan-barak.kelola') }}" class="ds-btn" title="Reset filter" aria-label="Reset filter"><i class="fa-solid fa-xmark"></i></a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel keluhan --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-clipboard-list ds-icon"></i> Daftar Keluhan Barak</h3>
                    <p class="ds-card__desc">{{ $adaFilter ? 'Hasil sesuai filter' : 'Keluhan terbaru tampil paling atas' }} — klik baris untuk melihat detail &amp; menindaklanjuti</p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ $daftarKeluhan->total() }} keluhan</span>
            </div>

            @if($daftarKeluhan->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-door-open ds-icon"></i>
                Tidak ada keluhan barak yang cocok dengan filter yang dipilih.
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table data-server-sort class="ds-table tbl-table kb-table">
                        <thead>
                            <tr>
                                <th data-sort="pengaju">Pengaju</th>
                                <th data-sort="lokasi">Lokasi Barak</th>
                                <th>Keterangan</th>
                                <th data-sort="tanggal">Tanggal</th>
                                <th data-sort="status">Status</th>
                                <th class="ds-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarKeluhan as $k)
                            <tr onclick="window.location='{{ route('keluhan-barak.detail', $k->id) }}'" style="cursor:pointer;">
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($k->nama, 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $k->nama }}</div>
                                            <div class="tbl-sub">{{ $k->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar ds-avatar--sq"><i class="fa-solid fa-door-open"></i></span>
                                        <div>
                                            <div class="tbl-title">{{ $k->lorong }} · No. {{ $k->nomor_barak }}</div>
                                            <div class="tbl-sub">Asrama {{ $k->asrama }} · {{ $k->prodi }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="tbl-sub" style="margin:0; max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $k->keterangan }}">{{ $k->keterangan }}</div></td>
                                <td class="tbl-date">{{ $k->tanggal_pengajuan->locale('id')->isoFormat('D MMM Y') }}</td>
                                <td><span class="ds-badge ds-badge--{{ $k->status_varian }}">{{ $k->status }}</span></td>
                                <td class="ds-center">
                                    <a href="{{ route('keluhan-barak.detail', $k->id) }}" class="ds-btn ds-btn--sm ds-btn--pill">Detail <i class="fa-solid fa-arrow-right"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($daftarKeluhan->hasPages())
            <div class="kb-pagination">{{ $daftarKeluhan->links() }}</div>
            @endif
            @endif
        </div>

    </div>
</main>

</x-app-layout>
