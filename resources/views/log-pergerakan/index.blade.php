<x-app-layout>
<x-form-glass-style />
<style>
    /* Filter */
    .lg-filter { display: grid; grid-template-columns: minmax(0, 3fr) repeat(3, minmax(0, 2fr)) minmax(0, 2fr) auto; gap: var(--space-2-5); align-items: end; }
    @media (max-width: 1023px) { .lg-filter { grid-template-columns: 1fr 1fr; } .lg-filter__cari, .lg-filter__aksi { grid-column: 1 / -1; } }
    .lg-filter .form-group { margin: 0; }
    .lg-filter__cari { position: relative; }
    .lg-filter__cari i { position: absolute; left: var(--space-3); bottom: 12px; font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .lg-filter__cari .form-control { padding-left: 34px; }
    .lg-filter__aksi { display: flex; gap: var(--space-2); }
    .lg-filter__aksi .ds-btn { height: 38px; }
    .lg-filter__aksi .ds-btn--primary { flex: 1; justify-content: center; }

    /* Kartu aksi admin */
    .lg-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .lg-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
    .lg-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }

    /* Tabel */
    .lg-table td { vertical-align: top; }
    .lg-table td:first-child { min-width: 175px; }
    .lg-table td:first-child .tbl-title, .lg-table td:first-child .tbl-sub { white-space: nowrap; }
    .lg-table td:nth-child(3) { min-width: 150px; }
    .lg-mono { font-family: var(--font-mono); font-size: 12px; font-weight: 800; color: var(--ink-900); white-space: nowrap; }
    .lg-keluar { display: inline-flex; align-items: center; gap: var(--space-1-5); }
    .lg-keluar::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--danger); animation: lg-kedip 1.2s infinite; }
    @keyframes lg-kedip { 50% { opacity: .3; } }
    .lg-validasi { margin: 0; }
    .lg-validasi .ds-badge { cursor: pointer; border: 1px solid transparent; font-family: inherit; }
    .lg-validasi .ds-badge:hover { border-color: currentColor; }
    .lg-validasi .ds-badge:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .lg-aksi-sel { display: inline-flex; gap: var(--space-1); }
    .lg-aksi-sel form { margin: 0; }
    .lg-pagination { margin-top: var(--space-4); }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php $adaFilter = request()->hasAny(['search', 'kategori', 'status', 'validasi', 'tanggal']); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab lain --}}
        <x-page-banner title="Log Pergerakan Taruna" icon="fa-person-walking"
            subtitle="Rekapitulasi keberangkatan, perizinan, ekstrakurikuler, dan olahraga dari pos jaga gerbang" />

        @if(auth()->user()->isAdmin())
        <div class="ds-card lg-aksi mb-4">
            <span class="lg-aksi__teks"><i class="fa-solid fa-tablet-screen-button"></i>Catat pergerakan taruna langsung dari tablet pos jaga</span>
            <a href="{{ route('log-pergerakan.tablet') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-tablet-screen-button"></i> Mode Tablet Pos Jaga</a>
        </div>
        @endif

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        {{-- Statistik --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 mb-4">
            <x-stat-card title="Belum Kembali" :value="$stats['belum_kembali']" icon="fa-solid fa-person-walking-arrow-right"
                varian="danger" badge="Di luar" badgeType="danger" :href="route('log-pergerakan.index', ['status' => 'berangkat'])" description="Taruna aktif di luar kampus" />
            <x-stat-card title="Kembali Hari Ini" :value="$stats['sudah_kembali']" icon="fa-solid fa-house-circle-check"
                varian="success" badge="Check-in" badgeType="success" description="Sudah lapor di pos jaga" />
            <x-stat-card title="Total Log Hari Ini" :value="$stats['total_today']" icon="fa-solid fa-clipboard-list"
                varian="accent" :badge="$stats['perizinan'] . ' izin'" badgeType="accent" :href="route('log-pergerakan.index', ['tanggal' => today()->format('Y-m-d')])" description="Aktivitas gerbang tercatat" />
            <x-stat-card title="Ekskul & Olahraga" :value="$stats['ekskul'] + $stats['olahraga']" icon="fa-solid fa-person-running"
                varian="info" :badge="$stats['ekskul'] . ' ekskul'" badgeType="info" description="Kegiatan luar asrama hari ini" />
            <x-stat-card title="Menunggu Validasi" :value="$stats['belum_validasi']" icon="fa-solid fa-hourglass-half"
                varian="warning" badge="Belum diaudit" badgeType="warning" :href="route('log-pergerakan.index', ['validasi' => 'pending'])" description="Log taruna belum diperiksa" />
        </div>

        {{-- Filter --}}
        <div class="ds-card mb-4">
            <form action="{{ route('log-pergerakan.index') }}" method="GET" class="lg-filter" role="search">
                <div class="form-group lg-filter__cari">
                    <label class="form-label" for="lgCari">Cari</label>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="lgCari" class="form-control" name="search" value="{{ request('search') }}" placeholder="Nama, NPM, rute...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="lgKategori">Kategori</label>
                    <select id="lgKategori" class="form-select" name="kategori">
                        <option value="">Semua kategori</option>
                        <option value="perizinan" @selected(request('kategori') === 'perizinan')>Perizinan</option>
                        <option value="ekstrakurikuler" @selected(request('kategori') === 'ekstrakurikuler')>Ekstrakurikuler</option>
                        <option value="olahraga" @selected(request('kategori') === 'olahraga')>Olahraga</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="lgStatus">Status</label>
                    <select id="lgStatus" class="form-select" name="status">
                        <option value="">Semua status</option>
                        <option value="berangkat" @selected(request('status') === 'berangkat')>Belum kembali</option>
                        <option value="kembali" @selected(request('status') === 'kembali')>Sudah kembali</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="lgValidasi">Validasi</label>
                    <select id="lgValidasi" class="form-select" name="validasi">
                        <option value="">Semua validasi</option>
                        <option value="tervalidasi" @selected(request('validasi') === 'tervalidasi')>Tervalidasi</option>
                        <option value="pending" @selected(request('validasi') === 'pending')>Menunggu validasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="lgTanggal">Tanggal</label>
                    <input type="date" id="lgTanggal" class="form-control" name="tanggal" value="{{ request('tanggal') }}">
                </div>
                <div class="lg-filter__aksi">
                    <button type="submit" class="ds-btn ds-btn--primary"><i class="fa-solid fa-filter"></i> Terapkan</button>
                    @if($adaFilter)
                    <a href="{{ route('log-pergerakan.index') }}" class="ds-btn" title="Reset filter" aria-label="Reset filter"><i class="fa-solid fa-xmark"></i></a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel log --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-list-check ds-icon"></i> Rekap Log Pergerakan</h3>
                    <p class="ds-card__desc">{{ $adaFilter ? 'Hasil sesuai filter' : 'Keberangkatan terbaru tampil paling atas' }} — klik status validasi untuk mengubahnya</p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ $logs->total() }} log</span>
            </div>

            @if($logs->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-inbox ds-icon"></i>
                Belum ada catatan log pergerakan taruna yang sesuai.
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table data-server-sort class="ds-table tbl-table lg-table">
                        <thead>
                            <tr>
                                <th data-sort="nama">Taruna</th>
                                <th data-sort="kategori">Kategori</th>
                                <th>Detail Kegiatan</th>
                                <th data-sort="berangkat">Berangkat</th>
                                <th data-sort="kembali">Kembali</th>
                                <th data-sort="status">Status</th>
                                <th data-sort="validasi">Validasi</th>
                                <th class="ds-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $item)
                            @php [$katLabel, $katIkon, $katVarian] = $item->kategoriMeta(); @endphp
                            <tr>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($item->nama, 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $item->nama }}</div>
                                            <div class="tbl-sub">{{ $item->npm ?? '-' }} · {{ $item->prodi ?? 'PPI Curug' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="ds-badge ds-badge--{{ $katVarian }}"><i class="fa-solid {{ $katIkon }}"></i> {{ $katLabel }}</span>
                                    @if($item->subkategori)<div class="tbl-sub mt-1">{{ $item->subkategori_label }}</div>@endif
                                    <x-badge-urgensi :log="$item" class="mt-1" />
                                </td>
                                <td>
                                    @if($item->kategori === 'perizinan')
                                        <div class="tbl-title">{{ Str::limit($item->keterangan_keluhan, 40) ?: '—' }}</div>
                                    @elseif($item->kategori === 'ekstrakurikuler')
                                        <div class="tbl-title">{{ $item->nama_ekskul }} <span class="ds-badge">{{ $item->jumlah_anggota }} org</span></div>
                                        <div class="tbl-sub">{{ $item->lokasi_kegiatan ?? '-' }}</div>
                                    @else
                                        <div class="tbl-title">{{ $item->rute ?? 'Olahraga' }}</div>
                                        <div class="tbl-sub">{{ $item->pengikut ? Str::limit($item->pengikut, 30) : '-' }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="lg-mono">{{ $item->waktu_berangkat ? $item->waktu_berangkat->format('d/m/Y H:i') : '—' }}</div>
                                    @if($item->isBelumKembali())
                                    <div class="tbl-sub" style="color:var(--danger-ink)">{{ $item->getDurasiFormatted() }} lalu</div>
                                    @endif
                                </td>
                                <td>
                                    @if($item->isSudahKembali())
                                    <div class="lg-mono" style="color:var(--success-ink)">{{ $item->waktu_kembali ? $item->waktu_kembali->format('d/m/Y H:i') : '—' }}</div>
                                    <div class="tbl-sub">Durasi {{ $item->getDurasiFormatted() }}</div>
                                    @else
                                    <span class="tbl-sub">Masih di luar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->isBelumKembali())
                                    <span class="ds-badge ds-badge--danger lg-keluar">Belum kembali</span>
                                    @else
                                    <span class="ds-badge ds-badge--success"><i class="fa-solid fa-circle-check"></i> Sudah kembali</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('log-pergerakan.validasi', $item->id) }}" method="POST" class="lg-validasi"
                                          data-konfirmasi="{{ $item->is_validated ? 'Validasi log '.$item->nama.' akan dibatalkan dan kembali berstatus menunggu.' : 'Log '.$item->nama.' akan ditandai tervalidasi. Pastikan data sudah sesuai fakta di lapangan.' }}"
                                          data-konfirmasi-judul="{{ $item->is_validated ? 'Batalkan Validasi?' : 'Validasi Log?' }}"
                                          data-konfirmasi-varian="{{ $item->is_validated ? 'warning' : 'success' }}"
                                          data-konfirmasi-tombol="{{ $item->is_validated ? 'Ya, Batalkan' : 'Ya, Validasi' }}">
                                        @csrf @method('PATCH')
                                        @if($item->is_validated)
                                        <button type="submit" class="ds-badge ds-badge--success" title="Klik untuk membatalkan validasi"><i class="fa-solid fa-user-check"></i> Tervalidasi</button>
                                        @else
                                        <button type="submit" class="ds-badge ds-badge--warning" title="Klik untuk memvalidasi"><i class="fa-solid fa-hourglass-half"></i> Menunggu</button>
                                        @endif
                                    </form>
                                </td>
                                <td class="ds-center">
                                    <div class="lg-aksi-sel">
                                        <a href="{{ route('log-pergerakan.show', $item->id) }}" class="ds-btn ds-btn--icon" title="Lihat detail" aria-label="Lihat detail log {{ $item->nama }}"><i class="fa-solid fa-eye"></i></a>
                                        {{-- Tandai kembali hanya admin (route role:taruna,admin — pengasuh sebatas validator) --}}
                                        @if($item->isBelumKembali() && auth()->user()->isAdmin())
                                        <form action="{{ route('log-pergerakan.kembali', $item->id) }}" method="POST"
                                              data-konfirmasi="{{ $item->nama }} akan ditandai sudah kembali ke asrama sekarang." data-konfirmasi-judul="Tandai Sudah Kembali?" data-konfirmasi-varian="success" data-konfirmasi-tombol="Ya, Sudah Kembali">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="ds-btn ds-btn--icon ds-btn--success" title="Tandai kembali" aria-label="Tandai {{ $item->nama }} kembali"><i class="fa-solid fa-check"></i></button>
                                        </form>
                                        @endif
                                        @if(auth()->user()->canManageSystem() || auth()->user()->isPengasuh())
                                        <form action="{{ route('log-pergerakan.destroy', $item->id) }}" method="POST"
                                              data-konfirmasi="Log pergerakan {{ $item->nama }} akan dihapus permanen." data-konfirmasi-judul="Hapus Log?" data-konfirmasi-tombol="Ya, Hapus">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="ds-btn ds-btn--icon ds-btn--danger" title="Hapus" aria-label="Hapus log {{ $item->nama }}"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($logs->hasPages())
            <div class="lg-pagination">{{ $logs->links() }}</div>
            @endif
            @endif
        </div>

    </div>
</main>

<x-konfirmasi-modal />
</x-app-layout>
