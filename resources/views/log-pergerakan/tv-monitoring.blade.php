<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD MONITORING TV POS JAGA - PPI CURUG</title>
    
    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            background-color: #0b0f19;
            color: #f1f5f9;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* === TV HEADER === */
        .tv-header {
            background: linear-gradient(180deg, #111827 0%, #0b0f19 100%);
            border-bottom: 2px solid #1e293b;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .tv-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .tv-logo-badge {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }
        .tv-title {
            font-size: 20px;
            font-weight: 900;
            letter-spacing: 0.5px;
            margin: 0;
            color: #ffffff;
            text-transform: uppercase;
        }
        .tv-subtitle {
            font-size: 11.5px;
            color: #94a3b8;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Live Clock & Indicator */
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .live-status-pill {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid #10b981;
            color: #34d399;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .live-pulse-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 8px #10b981;
            animation: pulseGreen 1.5s infinite;
        }
        @keyframes pulseGreen {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.3); }
        }

        .digital-clock {
            font-family: 'Orbitron', monospace;
            font-size: 24px;
            font-weight: 700;
            color: #38bdf8;
            letter-spacing: 1.5px;
            background: #030712;
            padding: 6px 16px;
            border-radius: 10px;
            border: 1px solid #1e293b;
        }
        .btn-fullscreen {
            background: #1e293b;
            color: #cbd5e1;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-fullscreen:hover { background: #334155; color: white; }

        /* === TV BODY CONTAINER === */
        .tv-container {
            padding: 24px 28px;
        }

        /* === KPI STATS BAR (BIG METRICS) === */
        .tv-stats-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        .tv-stat-card {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 16px;
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .tv-stat-card.alert-card {
            background: linear-gradient(135deg, #450a0a 0%, #1f2937 80%);
            border: 2px solid #ef4444;
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.25);
        }
        .tv-stat-card.success-card {
            background: linear-gradient(135deg, #064e3b 0%, #1f2937 80%);
            border: 1.5px solid #10b981;
        }
        .stat-card-title {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-card .stat-card-title { color: #fca5a5; }
        .success-card .stat-card-title { color: #6ee7b7; }
        
        .stat-card-number {
            font-family: 'Orbitron', sans-serif;
            font-size: 40px;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 4px;
            color: #ffffff;
        }
        .alert-card .stat-card-number {
            color: #ef4444;
            text-shadow: 0 0 15px rgba(239, 68, 68, 0.6);
        }
        .success-card .stat-card-number {
            color: #10b981;
            text-shadow: 0 0 15px rgba(16, 185, 129, 0.4);
        }
        .stat-card-desc {
            font-size: 11px;
            color: #64748b;
        }

        /* === 2 COLUMNS: ACTIVE (BELUM KEMBALI) & HISTORY === */
        .tv-main-grid {
            display: grid;
            grid-template-columns: 2.2fr 1fr;
            gap: 20px;
        }

        /* Section Card */
        .tv-section {
            background: #111827;
            border: 1px solid #1e293b;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.35);
        }
        .section-hdr {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #1f2937;
        }
        .section-hdr h3 {
            font-size: 16px;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .badge-live-count {
            background: #dc2626;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 800;
            font-family: 'Orbitron', monospace;
        }

        /* Active Logs Table / Grid */
        .active-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        .active-table th {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            padding: 8px 14px;
            border-bottom: 1px solid #1e293b;
        }
        .active-table tbody tr {
            background: #1e293b;
            transition: transform 0.2s, background 0.2s;
            border-radius: 12px;
        }
        .active-table tbody tr:hover {
            background: #253349;
            transform: scale(1.005);
        }
        .active-table td {
            padding: 14px 14px;
            font-size: 13.5px;
            vertical-align: middle;
        }
        .active-table td:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        .active-table td:last-child  { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }

        .taruna-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .taruna-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #334155;
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
        }
        .taruna-name { font-weight: 800; color: #f8fafc; margin-bottom: 2px; }
        .taruna-npm { font-size: 11px; color: #94a3b8; }

        /* Status Badge TV */
        .tv-badge-belum {
            background: #dc2626;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 0 10px rgba(220, 38, 38, 0.5);
            animation: pulseRed 2s infinite;
        }
        .tv-badge-sudah {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid #10b981;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Category Badges */
        .cat-tag {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }
        .cat-tag-perizinan { background: #fee2e2; color: #991b1b; }
        .cat-tag-ekskul    { background: #e0e7ff; color: #3730a3; }
        .cat-tag-olahraga  { background: #dcfce7; color: #166534; }

        /* Right Side: Returned Feed */
        .feed-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 520px;
            overflow-y: auto;
        }
        .feed-item {
            background: #1e293b;
            border-radius: 12px;
            padding: 12px 14px;
            border-left: 4px solid #10b981;
        }
        .feed-title { font-size: 13px; font-weight: 800; color: #f1f5f9; }
        .feed-sub   { font-size: 11px; color: #94a3b8; margin-top: 2px; }

        /* Empty State */
        .tv-empty {
            text-align: center;
            padding: 48px 16px;
            color: #64748b;
        }

        /* Back button */
        .btn-back-tablet {
            background: #3b82f6;
            color: white;
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-back-tablet:hover { background: #2563eb; color: white; }
    </style>
</head>
<body>

    {{-- TV HEADER --}}
    <header class="tv-header">
        <div class="tv-brand">
            <div class="tv-logo-badge"><i class="fas fa-satellite-dish"></i></div>
            <div>
                <h1 class="tv-title">DASHBOARD MONITORING TV POS JAGA</h1>
                <p class="tv-subtitle">POLITEKNIK PENERBANGAN INDONESIA CURUG &bull; LOG PERGERAKAN TARUNA REALTIME</p>
            </div>
        </div>

        <div class="header-right">
            <div class="live-status-pill">
                <span class="live-pulse-dot"></span> SINKRONISASI LIVE AKTIF
            </div>
            <div class="digital-clock" id="liveClock">00:00:00</div>
            <button type="button" class="btn-fullscreen" onclick="toggleFullscreen()" title="Fullscreen TV Mode">
                <i class="fas fa-expand"></i> Fullscreen
            </button>
            <a href="{{ route('log-pergerakan.tablet') }}" class="btn-back-tablet">
                <i class="fas fa-tablet-alt"></i> Tablet Input
            </a>
        </div>
    </header>

    {{-- TV BODY CONTENT --}}
    <main class="tv-container">

        {{-- 5 KPI STATS CARDS --}}
        <div class="tv-stats-grid">
            {{-- 1. BELUM KEMBALI (MAIN HIGHLIGHT) --}}
            <div class="tv-stat-card alert-card">
                <div class="stat-card-title">
                    <i class="fas fa-exclamation-triangle"></i> DI LUAR / BELUM KEMBALI
                </div>
                <div class="stat-card-number" id="statBelumKembali">{{ $stats['total_belum_kembali'] }}</div>
                <div class="stat-card-desc">Taruna yang sedang aktif di luar asrama saat ini</div>
            </div>

            {{-- 2. SUDAH KEMBALI --}}
            <div class="tv-stat-card success-card">
                <div class="stat-card-title">
                    <i class="fas fa-check-circle"></i> SUDAH KEMBALI
                </div>
                <div class="stat-card-number" id="statSudahKembali">{{ $stats['total_sudah_kembali'] }}</div>
                <div class="stat-card-desc">Taruna kembali hari ini</div>
            </div>

            {{-- 3. PERIZINAN --}}
            <div class="tv-stat-card">
                <div class="stat-card-title"><i class="fas fa-notes-medical text-danger"></i> Perizinan</div>
                <div class="stat-card-number text-danger" id="statPerizinan">{{ $stats['total_perizinan'] }}</div>
                <div class="stat-card-desc">Kesehatan / Berduka</div>
            </div>

            {{-- 4. EKSTRAKURIKULER --}}
            <div class="tv-stat-card">
                <div class="stat-card-title"><i class="fas fa-cogs text-primary"></i> Ekskul</div>
                <div class="stat-card-number text-primary" id="statEkskul">{{ $stats['total_ekskul'] }}</div>
                <div class="stat-card-desc">Kegiatan Ekskul</div>
            </div>

            {{-- 5. OLAHRAGA --}}
            <div class="tv-stat-card">
                <div class="stat-card-title"><i class="fas fa-running text-success"></i> Olahraga</div>
                <div class="stat-card-number text-success" id="statOlahraga">{{ $stats['total_olahraga'] }}</div>
                <div class="stat-card-desc">Mandiri / Terpimpin</div>
            </div>
        </div>

        {{-- MAIN CONTENT: ACTIVE (BELUM KEMBALI) & HISTORY FEED --}}
        <div class="tv-main-grid">

            {{-- KOLOM KIRI: LIVE LIST TARUNA BELUM KEMBALI --}}
            <div class="tv-section">
                <div class="section-hdr">
                    <h3>
                        <i class="fas fa-user-clock text-danger"></i> DAFTAR TARUNA DI LUAR ASRAMA
                        <span class="badge-live-count" id="badgeActiveCount">{{ $activeLogs->count() }} TARUNA</span>
                    </h3>
                    <div class="small text-muted">
                        <i class="fas fa-sync-alt fa-spin me-1 text-info"></i> Auto-update setiap 5 detik
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="active-table">
                        <thead>
                            <tr>
                                <th>Taruna / Koordinator</th>
                                <th>Kategori</th>
                                <th>Keterangan / Ekskul / Rute</th>
                                <th>Jam Keluar</th>
                                <th>Durasi di Luar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="activeLogsTableBody">
                            @forelse($activeLogs as $log)
                            <tr>
                                <td>
                                    <div class="taruna-cell">
                                        <div class="taruna-avatar">
                                            {{ strtoupper(substr($log->nama, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="taruna-name">{{ $log->nama }}</div>
                                            <div class="taruna-npm">{{ $log->npm ?? '-' }} &bull; {{ $log->prodi ?? 'PPI Curug' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($log->kategori === 'perizinan')
                                        <span class="cat-tag cat-tag-perizinan">Perizinan</span>
                                    @elseif($log->kategori === 'ekstrakurikuler')
                                        <span class="cat-tag cat-tag-ekskul">Ekskul</span>
                                    @else
                                        <span class="cat-tag cat-tag-olahraga">Olahraga</span>
                                    @endif
                                    <div class="small text-muted mt-1">{{ $log->subkategori }}</div>
                                </td>
                                <td>
                                    @if($log->kategori === 'perizinan')
                                        <div class="fw-semibold">{{ Str::limit($log->keterangan_keluhan, 40) }}</div>
                                    @elseif($log->kategori === 'ekstrakurikuler')
                                        <div class="fw-bold">{{ $log->nama_ekskul }} <span class="badge bg-secondary">{{ $log->jumlah_anggota }} org</span></div>
                                        <div class="small text-muted">{{ $log->lokasi_kegiatan ?? '-' }}</div>
                                    @else
                                        <div class="fw-bold">{{ $log->rute ?? 'Olahraga' }}</div>
                                        <div class="small text-muted">{{ $log->pengikut ? Str::limit($log->pengikut, 30) : '-' }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-info"><i class="far fa-clock me-1"></i> {{ $log->waktu_berangkat ? $log->waktu_berangkat->format('H:i') : '-' }}</div>
                                    <div class="small text-muted">{{ $log->waktu_berangkat ? $log->waktu_berangkat->format('d/m/Y') : '' }}</div>
                                </td>
                                <td>
                                    <span class="text-warning fw-bold font-monospace">{{ $log->getDurasiFormatted() }}</span>
                                </td>
                                <td>
                                    <span class="tv-badge-belum">
                                        <i class="fas fa-dot-circle"></i> BELUM KEMBALI
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr id="rowEmptyActive">
                                <td colspan="6" class="tv-empty">
                                    <i class="fas fa-check-circle fs-1 text-success mb-2 d-block"></i>
                                    <div class="fw-bold text-light">Semua Taruna Berada di Dalam Asrama</div>
                                    <div class="small text-muted">Tidak ada taruna yang sedang di luar saat ini.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- KOLOM KANAN: FEED TARUNA YANG BARU KEMBALI --}}
            <div class="tv-section">
                <div class="section-hdr">
                    <h3>
                        <i class="fas fa-history text-success"></i> KEPULANGAN HARI INI
                    </h3>
                    <span class="badge bg-success font-monospace" id="badgeReturnedCount">{{ $returnedToday->count() }}</span>
                </div>

                <div class="feed-list" id="returnedFeedContainer">
                    @forelse($returnedToday as $item)
                    <div class="feed-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="feed-title">{{ $item->nama }}</div>
                            <span class="tv-badge-sudah"><i class="fas fa-check"></i> KEMBALI</span>
                        </div>
                        <div class="feed-sub">
                            <span class="text-info">{{ ucfirst($item->kategori) }}</span> ({{ $item->subkategori }}) &bull; Kembali: <strong>{{ $item->waktu_kembali ? $item->waktu_kembali->format('H:i') : '-' }}</strong>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted small">
                        Belum ada data kepulangan tercatat hari ini.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

    </main>

    {{-- Script Realtime TV Jaga --}}
    <script>
        // Digital Clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('liveClock').textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Fullscreen Toggle
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    alert(`Gagal masuk mode fullscreen: ${err.message}`);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Live Polling Data from API every 5 seconds
        async function fetchLiveTVData() {
            try {
                const response = await fetch("{{ route('log-pergerakan.api') }}");
                if (!response.ok) return;
                const json = await response.json();

                if (json.success) {
                    // Update Counters
                    document.getElementById('statBelumKembali').textContent = json.stats.total_belum_kembali;
                    document.getElementById('statSudahKembali').textContent = json.stats.total_sudah_kembali;
                    document.getElementById('statPerizinan').textContent = json.stats.total_perizinan;
                    document.getElementById('statEkskul').textContent = json.stats.total_ekskul;
                    document.getElementById('statOlahraga').textContent = json.stats.total_olahraga;
                    document.getElementById('badgeActiveCount').textContent = json.stats.total_belum_kembali + ' TARUNA';

                    // Update Active Table
                    const tbody = document.getElementById('activeLogsTableBody');
                    if (json.active_logs.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="6" class="tv-empty">
                                    <i class="fas fa-check-circle fs-1 text-success mb-2 d-block"></i>
                                    <div class="fw-bold text-light">Semua Taruna Berada di Dalam Asrama</div>
                                    <div class="small text-muted">Tidak ada taruna yang sedang di luar saat ini.</div>
                                </td>
                            </tr>
                        `;
                    } else {
                        let html = '';
                        json.active_logs.forEach(log => {
                            let catBadge = '';
                            if (log.kategori === 'perizinan') catBadge = '<span class="cat-tag cat-tag-perizinan">Perizinan</span>';
                            else if (log.kategori === 'ekstrakurikuler') catBadge = '<span class="cat-tag cat-tag-ekskul">Ekskul</span>';
                            else catBadge = '<span class="cat-tag cat-tag-olahraga">Olahraga</span>';

                            const initials = (log.nama || 'TR').substring(0, 2).toUpperCase();

                            html += `
                                <tr>
                                    <td>
                                        <div class="taruna-cell">
                                            <div class="taruna-avatar">${initials}</div>
                                            <div>
                                                <div class="taruna-name">${log.nama}</div>
                                                <div class="taruna-npm">${log.npm || '-'} &bull; ${log.prodi || 'PPI Curug'}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        ${catBadge}
                                        <div class="small text-muted mt-1">${log.subkategori}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">${log.detail_kegiatan || '-'}</div>
                                        <div class="small text-muted">${log.lokasi_rute || '-'}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-info"><i class="far fa-clock me-1"></i> ${log.waktu_berangkat}</div>
                                        <div class="small text-muted">${log.tanggal_berangkat}</div>
                                    </td>
                                    <td>
                                        <span class="text-warning fw-bold font-monospace">${log.durasi}</span>
                                    </td>
                                    <td>
                                        <span class="tv-badge-belum">
                                            <i class="fas fa-dot-circle"></i> BELUM KEMBALI
                                        </span>
                                    </td>
                                </tr>
                            `;
                        });
                        tbody.innerHTML = html;
                    }

                    // Update Feed Kepulangan
                    const feedContainer = document.getElementById('returnedFeedContainer');
                    if (json.returned_today && json.returned_today.length > 0) {
                        let feedHtml = '';
                        json.returned_today.forEach(item => {
                            feedHtml += `
                                <div class="feed-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="feed-title">${item.nama}</div>
                                        <span class="tv-badge-sudah"><i class="fas fa-check"></i> KEMBALI</span>
                                    </div>
                                    <div class="feed-sub">
                                        <span class="text-info">${item.kategori}</span> (${item.subkategori}) &bull; Kembali: <strong>${item.waktu_kembali}</strong> (${item.durasi})
                                    </div>
                                </div>
                            `;
                        });
                        feedContainer.innerHTML = feedHtml;
                    }
                }
            } catch (err) {
                console.error("Gagal sinkronisasi data TV:", err);
            }
        }

        // Start Auto-Polling every 5 seconds
        setInterval(fetchLiveTVData, 5000);
    </script>
</body>
</html>
