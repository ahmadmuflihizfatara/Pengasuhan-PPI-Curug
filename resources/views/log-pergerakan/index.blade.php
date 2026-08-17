<x-app-layout>
<x-administration-table-style />
<style>
    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

    .app-layout { display: flex; min-height: 100vh; }
    .main-content { flex: 1; padding: 28px 30px; min-width: 0; }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 18px;
        padding: 28px 32px;
        color: white;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
    .page-header::after  { content:''; position:absolute; right:80px; bottom:-60px; width:140px; height:140px; background:rgba(255,255,255,.06); border-radius:50%; }
    .page-header-text { position: relative; z-index: 1; }
    .page-header-actions { position: relative; z-index: 1; display: flex; gap: 10px; }
    .page-title { font-size: 22px; font-weight: 800; color: white; margin: 0 0 4px 0; }
    .page-sub { font-size: 13px; color: rgba(255,255,255,.85); margin: 0; }

    /* Stats Grid */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .stat-card-custom {
        background: white;
        border-radius: 16px;
        padding: 16px 20px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }
    .stat-card-custom .num { font-size: 26px; font-weight: 800; line-height: 1; margin-bottom: 4px; }
    .stat-card-custom .lbl { font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: .06em; }

    /* Filter Bar */
    .filter-card {
        background: white;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }

    /* Table */
    .custom-table-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }
    .table-responsive { overflow-x: auto; }
    .table-pergerakan { width: 100%; border-collapse: collapse; }
    .table-pergerakan thead tr { background: linear-gradient(135deg, #667eea, #764ba2); }
    .table-pergerakan th {
        background: transparent;
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: white;
        border-bottom: none;
    }
    .table-pergerakan td {
        padding: 14px 18px;
        font-size: 13px;
        color: #444;
        border-top: 1px solid #f0f2f7;
        vertical-align: middle;
    }
    .table-pergerakan tbody tr:hover td { background: #f8f9ff; }

    /* Badges */
    .badge-status-belum {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5;
        padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .badge-status-sudah {
        background: #dcfce7; color: #15803d; border: 1px solid #86efac;
        padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 800;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .pulse-dot {
        width: 7px; height: 7px; background: #dc2626; border-radius: 50%; display: inline-block;
        animation: blink 1.2s infinite;
    }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

    .badge-kat-perizinan { background: #fee2e2; color: #991b1b; padding: 4px 9px; border-radius: 8px; font-size: 11px; font-weight: 700; }
    .badge-kat-ekskul    { background: #e0e7ff; color: #3730a3; padding: 4px 9px; border-radius: 8px; font-size: 11px; font-weight: 700; }
    .badge-kat-olahraga  { background: #dcfce7; color: #166534; padding: 4px 9px; border-radius: 8px; font-size: 11px; font-weight: 700; }

    /* Tombol aksi di dalam banner — gaya pill putih seperti tab Acara */
    .btn-brand {
        background: white; color: #667eea; border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,.15);
        transition: transform .15s, box-shadow .15s;
    }
    .btn-brand:hover { color: #667eea; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.2); }
    .btn-tv-monitor {
        background: rgba(255,255,255,.18); color: white; border: 1px solid rgba(255,255,255,.3);
        backdrop-filter: blur(4px); transition: background .15s;
    }
    .btn-tv-monitor:hover { color: white; background: rgba(255,255,255,.28); }

    /* Form filter — standar aplikasi */
    .filter-card .form-control,
    .filter-card .form-select {
        padding: 11px 14px; border: 2px solid #edf0f7; border-radius: 10px;
        font-size: 13px; color: #333; background: #fafbff; outline: none; transition: border .15s;
    }
    .filter-card .form-control:focus,
    .filter-card .form-select:focus { border-color: #667eea; background: white; box-shadow: none; }

    @media (max-width: 992px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="app-layout">
    <x-sidebar active="log-pergerakan" />

    <main class="main-content">

        {{-- Alerts --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-check-circle fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title"><i class="fas fa-walking me-2"></i> Log Pergerakan Taruna</h1>
                <p class="page-sub">Manajemen &amp; Rekapitulasi Data Keberangkatan, Perizinan, Ekstrakurikuler, dan Olahraga</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('log-pergerakan.tablet') }}" class="btn btn-brand fw-bold px-3 py-2 rounded-pill">
                    <i class="fas fa-tablet-alt me-1"></i> Mode Tablet Pos Jaga
                </a>
                <a href="{{ route('log-pergerakan.tv') }}" target="_blank" class="btn btn-tv-monitor fw-bold px-3 py-2 rounded-pill">
                    <i class="fas fa-tv me-1"></i> Buka TV Monitoring
                </a>
            </div>
        </div>

        {{-- Top Stats --}}
        <div class="stats-row">
            <div class="stat-card-custom border-danger border-start border-4">
                <div class="num text-danger">{{ $stats['belum_kembali'] }}</div>
                <div class="lbl">🔴 Belum Kembali (Di Luar)</div>
            </div>
            <div class="stat-card-custom border-success border-start border-4">
                <div class="num text-success">{{ $stats['sudah_kembali'] }}</div>
                <div class="lbl">🟢 Sudah Kembali Hari Ini</div>
            </div>
            <div class="stat-card-custom border-primary border-start border-4">
                <div class="num text-primary">{{ $stats['total_today'] }}</div>
                <div class="lbl">Total Log Hari Ini</div>
            </div>
            <div class="stat-card-custom border-info border-start border-4">
                <div class="num text-info">{{ $stats['ekskul'] + $stats['olahraga'] }}</div>
                <div class="lbl">Ekskul & Olahraga Hari Ini</div>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="filter-card admin-list-filter">
            <form action="{{ route('log-pergerakan.index') }}" method="GET" class="admin-log-filter-form">
                <div>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama, NPM, rute...">
                </div>
                <div>
                    <select class="form-select" name="kategori">
                        <option value="">-- Semua Kategori --</option>
                        <option value="perizinan" {{ request('kategori')==='perizinan'?'selected':'' }}>Perizinan</option>
                        <option value="ekstrakurikuler" {{ request('kategori')==='ekstrakurikuler'?'selected':'' }}>Ekstrakurikuler</option>
                        <option value="olahraga" {{ request('kategori')==='olahraga'?'selected':'' }}>Olahraga</option>
                    </select>
                </div>
                <div>
                    <select class="form-select" name="status">
                        <option value="">-- Semua Status --</option>
                        <option value="berangkat" {{ request('status')==='berangkat'?'selected':'' }}>🔴 Belum Kembali</option>
                        <option value="kembali" {{ request('status')==='kembali'?'selected':'' }}>🟢 Sudah Kembali</option>
                    </select>
                </div>
                <div>
                    <input type="date" class="form-control" name="tanggal" value="{{ request('tanggal') }}">
                </div>
                <div class="admin-log-actions">
                    <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
                    @if(request()->hasAny(['search', 'kategori', 'status', 'tanggal']))
                    <a href="{{ route('log-pergerakan.index') }}" class="btn-reset"><i class="fas fa-times"></i> Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Main Table --}}
        <div class="custom-table-card admin-list-table">
            <div class="table-responsive">
                <table class="table-pergerakan">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Taruna / Koordinator</th>
                            <th>Kategori & Sub</th>
                            <th>Detail Kegiatan</th>
                            <th>Waktu Berangkat</th>
                            <th>Waktu Kembali</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $item)
                        <tr>
                            <td class="text-muted fw-bold">{{ $logs->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                <div class="small text-muted">{{ $item->npm ?? '-' }} &bull; {{ $item->prodi ?? 'PPI Curug' }}</div>
                            </td>
                            <td>
                                {!! $item->getKategoriBadgeHtml() !!}
                                <div class="small text-muted mt-1 font-monospace">{{ $item->subkategori }}</div>
                            </td>
                            <td>
                                @if($item->kategori === 'perizinan')
                                    <div>{{ Str::limit($item->keterangan_keluhan, 40) }}</div>
                                @elseif($item->kategori === 'ekstrakurikuler')
                                    <div class="fw-bold text-primary">{{ $item->nama_ekskul }} <span class="badge bg-secondary">{{ $item->jumlah_anggota }} org</span></div>
                                    <div class="small text-muted">{{ $item->lokasi_kegiatan ?? '-' }}</div>
                                @else
                                    <div class="fw-bold text-success">{{ $item->rute ?? 'Olahraga' }}</div>
                                    <div class="small text-muted">{{ $item->pengikut ? Str::limit($item->pengikut, 30) : '-' }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->waktu_berangkat ? $item->waktu_berangkat->format('d/m/Y H:i') : '-' }}</div>
                                @if($item->isBelumKembali())
                                <div class="small text-danger fw-semibold">{{ $item->getDurasiFormatted() }} lalu</div>
                                @endif
                            </td>
                            <td>
                                @if($item->isSudahKembali())
                                    <div class="fw-bold text-success">{{ $item->waktu_kembali ? $item->waktu_kembali->format('d/m/Y H:i') : '-' }}</div>
                                    <div class="small text-muted">Durasi: {{ $item->getDurasiFormatted() }}</div>
                                @else
                                    <span class="text-muted small fst-italic">Masih di luar</span>
                                @endif
                            </td>
                            <td>
                                {!! $item->getStatusBadgeHtml() !!}
                            </td>
                            <td class="text-center">
                                <div class="table-actions">
                                    <a href="{{ route('log-pergerakan.show', $item->id) }}" class="btn-view" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($item->isBelumKembali())
                                    <form action="{{ route('log-pergerakan.kembali', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai {{ $item->nama }} SUDAH KEMBALI?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-approve-ico" title="Tandai Kembali">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @if(auth()->user()->canManageSystem() || auth()->user()->isPengasuh())
                                    <form action="{{ route('log-pergerakan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data log ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox mb-2 d-block" style="font-size:38px; color:#e2e5ee;"></i>
                                Belum ada catatan log pergerakan taruna yang sesuai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        </div>

    </main>
</div>
</x-app-layout>
