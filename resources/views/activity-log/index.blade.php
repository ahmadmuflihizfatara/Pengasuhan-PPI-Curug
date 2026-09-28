<x-app-layout>
<x-form-glass-style />
<style>
    /* Filter — pola filter tab Surat & Log Gerbang */
    .al-filter { display: grid; grid-template-columns: minmax(0, 3fr) repeat(3, minmax(0, 2fr)) repeat(2, minmax(0, 1.6fr)) auto; gap: var(--space-2-5); align-items: end; }
    @media (max-width: 1100px) { .al-filter { grid-template-columns: 1fr 1fr 1fr; } .al-filter__cari { grid-column: 1 / -1; } .al-filter__aksi { grid-column: 1 / -1; } }
    @media (max-width: 640px) { .al-filter { grid-template-columns: 1fr 1fr; } }
    .al-filter .form-group { margin: 0; }
    .al-filter__cari { position: relative; }
    .al-filter__cari i { position: absolute; left: var(--space-3); bottom: 12px; font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .al-filter__cari .form-control { padding-left: 34px; }
    .al-filter__aksi { display: flex; gap: var(--space-2); }
    .al-filter__aksi .ds-btn { height: 38px; }
    .al-filter__aksi .ds-btn--primary { flex: 1; justify-content: center; }

    /* Tabel */
    .al-table td { vertical-align: top; }
    .al-table td.al-no { color: var(--ink-500) !important; font-weight: 700; }
    .al-desk { min-width: 260px; max-width: 420px; font-size: 12px; line-height: 18px; font-weight: 500; color: var(--ink-800); }
    .al-table .ds-badge { white-space: nowrap; }
    .al-detail-baris[hidden] { display: none; }
    .al-detail-baris td { background: var(--glass-subtle) !important; padding-top: 0 !important; }
    .al-detail { padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); border-left: 4px solid var(--al-garis, var(--accent)); }
    .al-detail__judul { display: flex; align-items: center; gap: var(--space-1-5); margin-bottom: var(--space-2-5); font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .al-detail__grid { display: flex; flex-wrap: wrap; gap: var(--space-2); }
    .al-chip { min-width: 120px; max-width: 100%; padding: var(--space-1-5) var(--space-2-5); border-radius: var(--radius-sm); background: var(--glass-solid); border: 1px solid var(--border-glass-subtle); }
    .al-chip dt { font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: var(--ink-500); }
    .al-chip dd { margin: 0; font-size: 12px; line-height: 17px; font-weight: 700; color: var(--ink-900); overflow-wrap: anywhere; }
    .al-pagination { margin-top: var(--space-4); }
</style>

<x-island-navbar />

@php $adaFilter = request()->hasAny(['search', 'modul', 'aksi', 'user_id', 'dari', 'sampai']); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Log Aktivitas" icon="fa-clock-rotate-left"
            subtitle="Rekam jejak seluruh aktivitas sistem — siapa melakukan apa, kapan, dan di modul mana" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 mb-4">
            <x-stat-card title="Total Log" :value="number_format($stats['total'], 0, ',', '.')" icon="fa-solid fa-list-check"
                varian="accent" badge="Semua" badgeType="accent" description="Sejak sistem berjalan" />
            <x-stat-card title="Hari Ini" :value="$stats['hari_ini']" icon="fa-solid fa-calendar-day"
                varian="success" badge="Hari ini" badgeType="success" :href="route('activity-log.index', ['dari' => today()->toDateString()])" description="Aktivitas tercatat hari ini" />
            <x-stat-card title="7 Hari Terakhir" :value="$stats['minggu_ini']" icon="fa-solid fa-calendar-week"
                varian="info" badge="Mingguan" badgeType="info" :href="route('activity-log.index', ['dari' => today()->subDays(6)->toDateString()])" description="Termasuk hari ini" />
            <x-stat-card title="Pelaku Hari Ini" :value="$stats['pelaku_hari']" icon="fa-solid fa-user-clock"
                varian="warning" badge="Akun" badgeType="warning" description="Akun berbeda yang beraktivitas" />
        </div>

        {{-- Filter --}}
        <div class="ds-card mb-4">
            <form method="GET" action="{{ route('activity-log.index') }}" class="al-filter" role="search">
                <div class="form-group al-filter__cari">
                    <label class="form-label" for="alCari">Cari Aktivitas</label>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="alCari" name="search" class="form-control" value="{{ request('search') }}" placeholder="Deskripsi atau nama pelaku...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="alModul">Modul</label>
                    <select id="alModul" name="modul" class="form-select">
                        <option value="semua">Semua modul</option>
                        @foreach($modulList as $m)
                        <option value="{{ $m }}" @selected(request('modul') === $m)>{{ \App\Models\ActivityLog::labelModul($m) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="alAksi">Aksi</label>
                    <select id="alAksi" name="aksi" class="form-select">
                        <option value="semua">Semua aksi</option>
                        @foreach($aksiList as $a)
                        <option value="{{ $a }}" @selected(request('aksi') === $a)>{{ \App\Models\ActivityLog::labelAksi($a) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="alPelaku">Pelaku</label>
                    <select id="alPelaku" name="user_id" class="form-select">
                        <option value="semua">Semua pelaku</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" @selected((string) request('user_id') === (string) $u->id)>{{ $u->name }} ({{ $u->role }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="alDari">Dari</label>
                    <input type="date" id="alDari" name="dari" class="form-control" value="{{ request('dari') }}" max="{{ today()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="alSampai">Sampai</label>
                    <input type="date" id="alSampai" name="sampai" class="form-control" value="{{ request('sampai') }}" max="{{ today()->toDateString() }}">
                </div>
                <div class="al-filter__aksi">
                    <button type="submit" class="ds-btn ds-btn--primary"><i class="fa-solid fa-filter"></i> Terapkan</button>
                    @if($adaFilter)
                    <a href="{{ route('activity-log.index') }}" class="ds-btn" title="Reset filter" aria-label="Reset filter"><i class="fa-solid fa-xmark"></i></a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Riwayat --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-clock-rotate-left ds-icon"></i> Riwayat Aktivitas</h3>
                    <p class="ds-card__desc">{{ $adaFilter ? 'Hasil sesuai filter' : 'Aktivitas terbaru tampil paling atas' }} — klik Detail untuk melihat data lengkap</p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ number_format($logs->total(), 0, ',', '.') }} entri</span>
            </div>

            @if($logs->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-clock-rotate-left ds-icon"></i>
                {{ $adaFilter ? 'Tidak ada aktivitas yang cocok dengan filter.' : 'Log akan muncul otomatis saat ada aktivitas pada sistem.' }}
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table data-server-sort data-no-tools class="ds-table tbl-table al-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th data-sort="waktu">Waktu</th>
                                <th data-sort="modul">Modul</th>
                                <th data-sort="aksi">Aksi</th>
                                <th>Deskripsi Aktivitas</th>
                                <th data-sort="pelaku">Pelaku</th>
                                <th class="ds-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $index => $log)
                            @php [$modLabel, $modIkon, $modVarian] = $log->modulMeta(); @endphp
                            <tr>
                                <td class="al-no">{{ $logs->firstItem() + $index }}</td>
                                <td class="tbl-date">
                                    <div class="tbl-title">{{ $log->created_at->locale('id')->isoFormat('D MMM Y') }}</div>
                                    <div class="tbl-sub">{{ $log->created_at->format('H:i:s') }} · {{ $log->created_at->locale('id')->diffForHumans() }}</div>
                                </td>
                                <td><span class="ds-badge ds-badge--{{ $modVarian }}"><i class="fa-solid {{ $modIkon }}"></i> {{ $modLabel }}</span></td>
                                <td><span class="ds-badge {{ $log->aksi_varian ? 'ds-badge--' . $log->aksi_varian : '' }}">{{ \App\Models\ActivityLog::labelAksi($log->aksi) }}</span></td>
                                <td class="al-desk">{{ $log->deskripsi }}</td>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($log->user_name, 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $log->user_name }}</div>
                                            <div class="tbl-sub">{{ ucfirst($log->user_role) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="ds-center">
                                    @if($log->detail)
                                    <button type="button" class="ds-btn ds-btn--xs ds-btn--pill" aria-expanded="false" aria-controls="detail-{{ $log->id }}" onclick="toggleDetail(this)">
                                        <i class="fa-solid fa-eye"></i> <span>Detail</span>
                                    </button>
                                    @else
                                    <span class="tbl-sub">—</span>
                                    @endif
                                </td>
                            </tr>
                            @if($log->detail)
                            <tr class="al-detail-baris" id="detail-{{ $log->id }}" hidden>
                                <td colspan="7">
                                    <div class="al-detail" style="--al-garis: var(--{{ $modVarian === 'dark' ? 'ink-800' : $modVarian }})">
                                        <div class="al-detail__judul"><i class="fa-solid fa-circle-info"></i> Detail lengkap</div>
                                        <dl class="al-detail__grid" style="margin:0">
                                            @foreach($log->detail as $key => $value)
                                            @continue($value === null || $value === '')
                                            <div class="al-chip">
                                                <dt>{{ str_replace('_', ' ', $key) }}</dt>
                                                <dd>{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : (is_bool($value) ? ($value ? 'Ya' : 'Tidak') : $value) }}</dd>
                                            </div>
                                            @endforeach
                                        </dl>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if($logs->hasPages())
            <div class="al-pagination">{{ $logs->links() }}</div>
            @endif
            @endif
        </div>

    </div>
</main>

<script>
function toggleDetail(btn) {
    const baris = document.getElementById(btn.getAttribute('aria-controls'));
    const buka = baris.hidden;
    baris.hidden = !buka;
    btn.setAttribute('aria-expanded', buka);
    btn.querySelector('i').className = 'fa-solid ' + (buka ? 'fa-eye-slash' : 'fa-eye');
    btn.querySelector('span').textContent = buka ? 'Tutup' : 'Detail';
}
</script>
</x-app-layout>
