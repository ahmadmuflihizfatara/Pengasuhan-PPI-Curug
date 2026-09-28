<x-app-layout>
<x-form-glass-style />
<style>
    /* Filter — pola filter Barak & Surat */
    .rw-filter { display: grid; grid-template-columns: minmax(0, 4fr) minmax(0, 2fr) minmax(0, 2fr) auto; gap: var(--space-2-5); align-items: end; }
    @media (max-width: 1023px) { .rw-filter { grid-template-columns: 1fr 1fr; } .rw-filter__cari, .rw-filter__aksi { grid-column: 1 / -1; } }
    .rw-filter .form-group { margin: 0; }
    .rw-filter__cari { position: relative; }
    .rw-filter__cari i { position: absolute; left: var(--space-3); bottom: 12px; font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .rw-filter__cari .form-control { padding-left: 34px; }
    .rw-filter__aksi { display: flex; gap: var(--space-2); }
    .rw-filter__aksi .ds-btn { height: 38px; }
    .rw-filter__aksi .ds-btn--primary { flex: 1; justify-content: center; }

    .rw-table td { vertical-align: top; }
    .rw-table td:first-child { min-width: 200px; }
    .rw-ket { max-width: 240px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .rw-pagination { margin-top: var(--space-4); }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php $adaFilter = request()->hasAny(['search', 'kategori', 'status']); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab lain --}}
        <x-page-banner title="Kelola Reward Taruna" icon="fa-award"
            subtitle="Tinjau, proses, dan setujui pengajuan reward prestasi dari taruna" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif

        {{-- Statistik — klik untuk menyaring status --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-4">
            <x-stat-card title="Total Reward" :value="$stats['total']" icon="fa-solid fa-award"
                varian="accent" badge="Semua" badgeType="accent" :href="route('reward.kelola')" description="Seluruh pengajuan reward" />
            <x-stat-card title="Diajukan" :value="$stats['diajukan']" icon="fa-solid fa-hourglass-half"
                varian="warning" badge="Baru" badgeType="warning" :href="route('reward.kelola', ['status' => 'Diajukan'])" description="Menunggu ditinjau" />
            <x-stat-card title="Diproses" :value="$stats['diproses']" icon="fa-solid fa-spinner"
                varian="info" badge="Ditinjau" badgeType="info" :href="route('reward.kelola', ['status' => 'Diproses'])" description="Sedang dinilai" />
            <x-stat-card title="Disetujui" :value="$stats['disetujui']" icon="fa-solid fa-circle-check"
                varian="success" badge="Disetujui" badgeType="success" :href="route('reward.kelola', ['status' => 'Disetujui'])" description="Reward diberikan" />
            <x-stat-card title="Ditolak" :value="$stats['ditolak']" icon="fa-solid fa-circle-xmark"
                varian="danger" badge="Ditolak" badgeType="danger" :href="route('reward.kelola', ['status' => 'Ditolak'])" description="Tidak memenuhi syarat" />
        </div>

        {{-- Filter --}}
        <div class="ds-card mb-4">
            <form method="GET" action="{{ route('reward.kelola') }}" class="rw-filter" role="search">
                <div class="form-group rw-filter__cari">
                    <label class="form-label" for="rwCari">Cari</label>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="rwCari" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nama, email, NPM, keterangan...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="rwKategori">Kategori</label>
                    <select id="rwKategori" name="kategori" class="form-select">
                        <option value="">Semua kategori</option>
                        @foreach($kategoriList as $k)
                        <option value="{{ $k }}" @selected(request('kategori') === $k)>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="rwStatus">Status</label>
                    <select id="rwStatus" name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach($statusList as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="rw-filter__aksi">
                    <button type="submit" class="ds-btn ds-btn--primary"><i class="fa-solid fa-filter"></i> Terapkan</button>
                    @if($adaFilter)
                    <a href="{{ route('reward.kelola') }}" class="ds-btn" title="Reset filter" aria-label="Reset filter"><i class="fa-solid fa-xmark"></i></a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel reward --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-trophy ds-icon"></i> Daftar Pengajuan Reward</h3>
                    <p class="ds-card__desc">{{ $adaFilter ? 'Hasil sesuai filter' : 'Prestasi terbaru tampil paling atas' }} — klik baris untuk melihat detail &amp; memutuskan</p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ $daftarReward->total() }} pengajuan</span>
            </div>

            @if($daftarReward->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-award ds-icon"></i>
                {{ $adaFilter ? 'Tidak ada pengajuan reward yang cocok dengan filter.' : 'Belum ada pengajuan reward.' }}
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table data-server-sort class="ds-table tbl-table rw-table">
                        <thead>
                            <tr>
                                <th data-sort="pengaju">Pengaju</th>
                                <th data-sort="kategori">Kategori</th>
                                <th data-sort="jenis">Jenis</th>
                                <th>Keterangan</th>
                                <th data-sort="tanggal">Tanggal</th>
                                <th data-sort="status">Status</th>
                                <th class="ds-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarReward as $r)
                            <tr onclick="window.location='{{ route('reward.detail', $r->id) }}'" style="cursor:pointer;">
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($r->nama, 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $r->nama }}</div>
                                            <div class="tbl-sub">{{ $r->npm }} · {{ $r->prodi }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar ds-avatar--sq"><i class="fa-solid {{ $r->kategori === 'Akademik' ? 'fa-graduation-cap' : 'fa-medal' }}"></i></span>
                                        <div class="tbl-title">{{ $r->kategori }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="ds-badge ds-badge--info">
                                        <i class="fa-solid {{ $r->jenis === 'kelompok' ? 'fa-users' : 'fa-user' }}"></i>
                                        {{ ucfirst($r->jenis) }}{{ $r->jenis === 'kelompok' ? ' (' . $r->jumlah_anggota . ' org)' : '' }}
                                    </span>
                                </td>
                                <td><div class="tbl-sub rw-ket" style="margin:0" title="{{ $r->keterangan }}">{{ $r->keterangan }}</div></td>
                                <td class="tbl-date">{{ $r->tanggal_prestasi->locale('id')->isoFormat('D MMM Y') }}</td>
                                <td><span class="ds-badge ds-badge--{{ $r->status_varian }}">{{ $r->status }}</span></td>
                                <td class="ds-center">
                                    <a href="{{ route('reward.detail', $r->id) }}" class="ds-btn ds-btn--sm ds-btn--pill">Detail <i class="fa-solid fa-arrow-right"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($daftarReward->hasPages())
            <div class="rw-pagination">{{ $daftarReward->links() }}</div>
            @endif
            @endif
        </div>

    </div>
</main>

</x-app-layout>
