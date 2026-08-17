<x-app-layout>
<style>
    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #f0f3f8; }

    .poin-layout { display: flex; min-height: 100vh; }
    .main-content { flex: 1; padding: 24px 28px; min-width: 0; }

    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 20px;
        padding: 24px 30px;
        color: white;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.25);
    }
    .page-header::after {
        content: ''; position: absolute; right: -40px; top: -40px; width: 180px; height: 180px;
        background: rgba(255,255,255,.08); border-radius: 50%;
    }
    .header-title { font-size: 22px; font-weight: 800; margin: 0 0 4px 0; }
    .header-sub   { font-size: 13px; opacity: 0.9; margin: 0; }

    /* Dual Cards */
    .dual-summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    .summary-card {
        border-radius: 16px;
        padding: 20px;
        background: white;
        border: 1.5px solid #e2e8f0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    }
    .summary-card.card-pelanggaran {
        background: #fff5f5;
        border-color: #fecaca;
    }
    .summary-card.card-penghargaan {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .summary-num { font-size: 34px; font-weight: 900; line-height: 1; margin-bottom: 6px; }
    .summary-lbl { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }

    /* Sanksi Card */
    .sanksi-banner {
        border-radius: 16px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        border: 2px solid;
    }
    .sanksi-icon { font-size: 36px; }
    .sanksi-title { font-size: 17px; font-weight: 900; margin-bottom: 2px; }
    .sanksi-desc  { font-size: 12.5px; margin: 0; line-height: 1.4; }

    /* Threshold Bar */
    .threshold-bar-container {
        background: white;
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
    }
    .threshold-bar {
        height: 12px; border-radius: 20px; background: #e2e8f0; display: flex; overflow: hidden; margin-top: 8px;
    }
    .t-step { height: 100%; }
    .t-aman  { width: 50%; background: #22c55e; }
    .t-sp1   { width: 25%; background: #eab308; }
    .t-sp2   { width: 25%; background: #f97316; }
    .t-sp3   { width: 25%; background: #ef4444; }

    /* Card Panels */
    .card-panel {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.03);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .card-panel-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-panel-title { font-size: 15px; font-weight: 800; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px; }

    .table-custom th {
        background: #f8fafc; font-size: 11px; font-weight: 800; text-transform: uppercase;
        color: #64748b; padding: 12px 14px; border-bottom: 2px solid #e2e8f0;
    }
    .table-custom td {
        padding: 12px 14px; font-size: 13px; color: #334155; vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
</style>

<div class="poin-layout">
    <x-sidebar active="poin" />

    <main class="main-content">

        {{-- Header Banner --}}
        <div class="page-header">
            <div>
                <h1 class="header-title"><i class="fas fa-star text-warning me-2"></i> Raport Poin &amp; Disiplin Taruna</h1>
                <p class="header-sub">Pantau akumulasi Poin Pelanggaran (-) dan Poin Penghargaan (+) secara mandiri</p>
            </div>
            @if($selectedStudent)
            <div>
                <span class="badge bg-white text-dark px-3 py-2 fw-bold">
                    {{ $selectedStudent->nama }} &bull; {{ $selectedStudent->npm }}
                </span>
            </div>
            @endif
        </div>

        @if(!$selectedStudent)
        <div class="card p-5 text-center text-muted rounded-4">
            <i class="fas fa-user-graduate fs-1 mb-3 text-muted"></i>
            <h5 class="fw-bold">Akun Taruna Tidak Terhubung ke Database Mahasiswa</h5>
            <p class="small">Silakan hubungi Pengasuh atau Administrator untuk memeriksa data akun Anda.</p>
        </div>
        @else

        {{-- STATUS SANKSI TARUNA (THRESHOLD PELANGGARAN) --}}
        <div class="sanksi-banner" style="background:{{ $statusSanksi['bg'] }}; border-color:{{ $statusSanksi['border'] }}; color:{{ $statusSanksi['color'] }};">
            <div class="sanksi-icon"><i class="{{ $statusSanksi['icon'] }}"></i></div>
            <div>
                <div class="sanksi-title">Status Kedisiplinan: {{ $statusSanksi['status'] }}</div>
                <p class="sanksi-desc">{{ $statusSanksi['desc'] }}</p>
            </div>
        </div>

        {{-- DUAL SUMMARY GRID (Penghargaan TIDAK mengurangi Pelanggaran) --}}
        <div class="dual-summary-grid">
            {{-- Pelanggaran --}}
            <div class="summary-card card-pelanggaran">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="summary-lbl text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Akumulasi Pelanggaran (-)</span>
                    <span class="badge bg-danger">{{ $riwayatPelanggaran->count() }} Temuan</span>
                </div>
                <div class="summary-num text-danger">{{ $totalPelanggaran }} Poin</div>
                <div class="small text-muted">Poin pelanggaran diakumulasikan untuk menentukan Surat Peringatan (SP).</div>
            </div>

            {{-- Penghargaan --}}
            <div class="summary-card card-penghargaan">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="summary-lbl text-success"><i class="fas fa-trophy me-1"></i> Akumulasi Penghargaan (+)</span>
                    <span class="badge bg-success">{{ $riwayatPenghargaan->count() }} Prestasi</span>
                </div>
                <div class="summary-num text-success">+{{ $totalPenghargaan }} Poin</div>
                <div class="small text-muted">Poin reward prestasi mandiri (tidak mengurangi poin pelanggaran).</div>
            </div>
        </div>

        {{-- Threshold Progress Bar --}}
        <div class="threshold-bar-container">
            <div class="d-flex justify-content-between text-muted" style="font-size:11px; font-weight:800;">
                <span>🟢 Status Aman (&lt; 50 Poin)</span>
                <span>🟡 SP 1 (50 - 74 Poin)</span>
                <span>🟠 SP 2 (75 - 99 Poin)</span>
                <span>🔴 SP 3 &amp; Sidang (≥ 100 Poin)</span>
            </div>
            <div class="threshold-bar">
                <div class="t-step t-aman" title="Aman (<50)"></div>
                <div class="t-step t-sp1" title="SP 1 (50-74)"></div>
                <div class="t-step t-sp2" title="SP 2 (75-99)"></div>
                <div class="t-step t-sp3" title="SP 3 (≥100)"></div>
            </div>
        </div>

        {{-- NAV TABS DETAIL RIWAYAT --}}
        <div class="card-panel">
            <div class="card-panel-header">
                <ul class="nav nav-pills" id="tarunaPoinTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-danger" id="tab-pelanggaran-btn" data-bs-toggle="pill" data-bs-target="#panePelanggaran" type="button" role="tab">
                            <i class="fas fa-ban me-1"></i> Riwayat Pelanggaran ({{ $riwayatPelanggaran->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-success ms-2" id="tab-penghargaan-btn" data-bs-toggle="pill" data-bs-target="#panePenghargaan" type="button" role="tab">
                            <i class="fas fa-trophy me-1"></i> Riwayat Penghargaan / Prestasi ({{ $riwayatPenghargaan->count() }})
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content p-3" id="tarunaPoinTabContent">
                {{-- TAB PELANGGARAN --}}
                <div class="tab-pane fade show active" id="panePelanggaran" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tingkat</th>
                                    <th>Deskripsi Pelanggaran PTTT</th>
                                    <th>Poin</th>
                                    <th>Pengasuh / Pemeriksa</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatPelanggaran as $p)
                                <tr>
                                    <td>{{ $p->tanggal ? $p->tanggal->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-bold">
                                            {{ ucfirst($p->tingkat ?? 'Pelanggaran') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $p->kegiatan }}</div>
                                        @if($p->keterangan)<div class="small text-muted">{{ $p->keterangan }}</div>@endif
                                    </td>
                                    <td class="fw-bold text-danger">-{{ $p->nilai }} Poin</td>
                                    <td>{{ $p->pengasuh }}</td>
                                    <td>
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Tervalidasi</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-shield-alt fs-2 text-success mb-2 d-block"></i>
                                        Tidak ada catatan pelanggaran. Pertahankan kedisiplinan dan tata tertib!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAB PENGHARGAAN --}}
                <div class="tab-pane fade" id="panePenghargaan" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tingkat</th>
                                    <th>Prestasi / Penghargaan</th>
                                    <th>Poin</th>
                                    <th>Pemberi Rekomendasi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatPenghargaan as $r)
                                <tr>
                                    <td>{{ $r->tanggal ? $r->tanggal->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold">
                                            {{ ucfirst($r->tingkat ?? 'Prestasi') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $r->kegiatan }}</div>
                                        @if($r->keterangan)<div class="small text-muted">{{ $r->keterangan }}</div>@endif
                                    </td>
                                    <td class="fw-bold text-success">+{{ $r->nilai }} Poin</td>
                                    <td>{{ $r->pengasuh }}</td>
                                    <td>
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Tervalidasi</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-award fs-2 text-muted mb-2 d-block"></i>
                                        Belum ada catatan penghargaan atau prestasi.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @endif

    </main>
</div>
</x-app-layout>
