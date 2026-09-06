<x-app-layout>
<style>
    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: transparent; }

    .app-layout { display: flex; min-height: 100vh; }
    .main-content { flex: 1; padding: 28px 30px; min-width: 0; }

    /* === HEADER === */
    .poin-header-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 18px;
        padding: 24px 30px;
        color: white;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 8px 20px -6px rgba(102, 126, 234, 0.28);
    }
    .poin-header-banner::after {
        content: ''; position: absolute; right: -40px; top: -40px; width: 180px; height: 180px;
        background: rgba(255,255,255,.08); border-radius: 50%;
    }
    .banner-title { font-size: 22px; font-weight: 800; margin: 0 0 4px 0; }
    .banner-sub { font-size: 13px; opacity: 0.9; margin: 0; }

    /* === WORKFLOW MINI MAP === */
    .flow-bar {
        background: white;
        border-radius: 14px;
        padding: 14px 20px;
        margin-bottom: 24px;
        border: 1px solid #edf0f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 600;
        color: #888;
        flex-wrap: wrap;
        gap: 10px;
    }
    .flow-step { display: flex; align-items: center; gap: 8px; }
    .flow-num {
        width: 22px; height: 22px; border-radius: 50%; background: #eef0f7; color: #888;
        display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;
    }
    .flow-step.active .flow-num { background: #667eea; color: white; }
    .flow-step.active { color: #555; }
    .flow-arrow { color: #edf0f7; font-size: 14px; }

    /* === LAYOUT GRID === */
    .poin-grid {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 24px;
        align-items: flex-start;
    }

    /* === CARDS === */
    .card-panel {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .card-panel-header {
        padding: 16px 20px;
        background: #fafbff;
        border-bottom: 1px solid #edf0f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-panel-title { font-size: 15px; font-weight: 700; color: #333; margin: 0; display: flex; align-items: center; gap: 8px; }
    .card-panel-body { padding: 20px; }

    /* Student Search & List */
    .mhs-search-box {
        position: relative;
        margin-bottom: 12px;
    }
    .mhs-search-box input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border-radius: 10px;
        border: 1.5px solid #edf0f7;
        font-size: 13px;
    }
    .mhs-search-box i {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aab;
    }
    .mhs-list-dropdown {
        max-height: 280px;
        overflow-y: auto;
        border: 1px solid #edf0f7;
        border-radius: 10px;
    }
    .mhs-item-opt {
        padding: 7px 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        border-bottom: 1px solid #f0f2f7;
        transition: background 0.15s;
    }
    .mhs-item-opt:hover { background: #fafbff; }
    .mhs-item-opt.selected { background: #eef0ff; border-left: 3px solid #667eea; }
    .mhs-opt-ava {
        width: 26px; height: 26px; border-radius: 7px; background: linear-gradient(135deg, #667eea, #764ba2); color: white;
        display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 600; flex-shrink: 0;
    }
    .mhs-opt-name { font-size: 12.5px; font-weight: 600; color: #444; }
    .mhs-opt-meta { font-size: 11px; color: #aab; }

    /* Selected Student Info Card */
    .student-profile-box {
        text-align: center;
        padding: 18px;
        background: #fafbff;
        border-radius: 14px;
        margin-bottom: 18px;
        border: 1px solid #edf0f7;
    }
    .student-profile-ava {
        width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); color: white;
        display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 600;
        margin: 0 auto 10px;
    }
    .student-profile-name { font-size: 16px; font-weight: 600; color: #444; margin-bottom: 2px; }
    .student-profile-meta { font-size: 12px; color: #aab; font-weight: 500; }

    /* === SANKSI & POIN DUAL SCORE BOX === */
    .dual-score-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 20px;
    }
    .score-card {
        border-radius: 14px;
        padding: 16px;
        text-align: center;
        border: 1.5px solid;
    }
    .score-card.pelanggaran-card {
        background: #fff5f5;
        border-color: #fecaca;
    }
    .score-card.penghargaan-card {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .score-card-lbl { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .pelanggaran-card .score-card-lbl { color: #dc6a6a; }
    .penghargaan-card .score-card-lbl { color: #4ca86b; }
    .score-card-val { font-size: 26px; font-weight: 700; line-height: 1; margin-bottom: 4px; }
    .pelanggaran-card .score-card-val { color: #c05656; }
    .penghargaan-card .score-card-val { color: #3f9663; }
    .score-card-sub { font-size: 11px; color: #aab; }

    /* Sanksi Status Alert Box */
    .sanksi-status-alert {
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
        border: 1.5px solid;
    }
    .sanksi-icon { font-size: 26px; opacity: .85; }
    .sanksi-title { font-size: 15px; font-weight: 700; margin-bottom: 2px; }
    .sanksi-desc  { font-size: 12px; margin: 0; line-height: 1.4; opacity: .9; }

    /* Progress threshold */
    .threshold-bar-wrapper { margin-top: 8px; margin-bottom: 24px; }
    .threshold-bar {
        height: 10px; border-radius: 20px; background: #edf0f7; display: flex; overflow: hidden;
    }
    .t-step { height: 100%; }
    .t-aman  { width: 50%; background: #22c55e; }
    .t-sp1   { width: 25%; background: #eab308; }
    .t-sp2   { width: 25%; background: #f97316; }
    .t-sp3   { width: 25%; background: #ef4444; }

    /* === FORM USULAN DUAL TOGGLE (A vs B) === */
    .usulan-toggle {
        display: flex;
        background: #f0f2f7;
        border-radius: 12px;
        padding: 4px;
        margin-bottom: 20px;
        gap: 4px;
    }
    .toggle-btn {
        flex: 1;
        padding: 11px;
        font-size: 12.5px;
        font-weight: 600;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #aab;
        background: transparent;
    }
    .toggle-btn.active-penghargaan {
        background: linear-gradient(135deg, #4ca86b, #2f855a); color: white;
    }
    .toggle-btn.active-pelanggaran {
        background: linear-gradient(135deg, #d96b6b, #c53030); color: white;
    }

    /* Tingkat Pelanggaran Pills (Ringan 5, Sedang 20, Berat 50) */
    .tingkat-pelanggaran-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 16px;
    }
    .tingkat-card {
        border: none;
        border-radius: 12px;
        padding: 10px 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #edf0f7;
        opacity: .55;
    }
    .tingkat-card:hover { opacity: .8; }
    .tingkat-card.tier-ringan { background: #eab308; }
    .tingkat-card.tier-sedang { background: #f97316; }
    .tingkat-card.tier-berat  { background: #dc2626; }
    .tingkat-card.active-ringan,
    .tingkat-card.active-sedang,
    .tingkat-card.active-berat { opacity: 1; }
    .tingkat-name { font-size: 10.5px; font-weight: 500; color: rgba(0,0,0,.85); margin-bottom: 2px; }
    .tingkat-poin { font-size: 13.5px; font-weight: 700; color: #111; }

    /* Riwayat Tabs (custom, replace default bootstrap nav-tabs) */
    .riwayat-tabs {
        display: flex;
        gap: 6px;
        border-bottom: none;
        list-style: none;
        margin: 0;
    }
    .riwayat-tabs .nav-link {
        border: none;
        border-radius: 10px 10px 0 0;
        padding: 12px 18px;
        background: #f0f2f7;
        color: #888;
    }
    .riwayat-tabs .nav-link:hover { background: #edf0f7; }
    .riwayat-tabs .nav-link { font-weight: 600; }
    .riwayat-tabs .nav-link.active.text-danger { background: #fdf0f0; color: #c53030 !important; box-shadow: inset 0 -2.5px 0 #e08a8a; }
    .riwayat-tabs .nav-link.active.text-success { background: #eafaf0; color: #2f855a !important; box-shadow: inset 0 -2.5px 0 #85c9a0; }

    /* Kotak Judul Riwayat — gaya header Acara (gradient + toggle pill) */
    .riwayat-title-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 18px;
        padding: 22px 26px;
        margin-bottom: 10px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 18px -8px rgba(102,126,234,.35);
    }
    .riwayat-title-box::before {
        content: ''; position: absolute; right: -40px; top: -40px; width: 160px; height: 160px;
        background: rgba(255,255,255,.08); border-radius: 50%;
    }
    .riwayat-title-box::after {
        content: ''; position: absolute; right: 70px; bottom: -60px; width: 120px; height: 120px;
        background: rgba(255,255,255,.06); border-radius: 50%;
    }
    .riwayat-title-inner {
        position: relative; z-index: 1;
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;
    }
    .riwayat-title-text h2 { font-size: 16px; font-weight: 700; color: white; margin: 0 0 3px; display: flex; align-items: center; }
    .riwayat-title-text p { font-size: 12px; color: rgba(255,255,255,.85); margin: 0; }

    .riwayat-title-box .riwayat-tabs {
        background: rgba(255,255,255,.18);
        border-radius: 25px;
        padding: 4px;
        gap: 2px;
        border: 1px solid rgba(255,255,255,.25);
    }
    .riwayat-title-box .riwayat-tabs .nav-link {
        background: transparent; color: rgba(255,255,255,.8);
        border-radius: 20px; padding: 8px 16px; font-size: 12px;
    }
    .riwayat-title-box .riwayat-tabs .nav-link:hover { background: rgba(255,255,255,.12); color: white; }
    .riwayat-title-box .riwayat-tabs .nav-link.active.text-danger  { background: white; color: #c53030 !important; box-shadow: 0 2px 8px rgba(0,0,0,.15); }
    .riwayat-title-box .riwayat-tabs .nav-link.active.text-success { background: white; color: #2f855a !important; box-shadow: 0 2px 8px rgba(0,0,0,.15); }

    @media (max-width: 576px) {
        .riwayat-title-inner { flex-direction: column; align-items: flex-start; }
    }

    /* Tables */
    .table-custom th {
        background: #fafbff; font-size: 11px; font-weight: 600; text-transform: uppercase;
        letter-spacing: .03em; color: #aab; padding: 10px 14px; border-bottom: 1px solid #edf0f7;
    }
    .table-custom td {
        padding: 12px 14px; font-size: 13px; color: #444; vertical-align: middle;
        border-top: 1px solid #f0f2f7;
    }
    .table-custom tbody tr:hover td { background: #f8f9ff; }

    /* Tabel Riwayat Poin — gaya samakan seperti tabel Acara */
    .table-riwayat thead tr { background: linear-gradient(135deg, #667eea, #764ba2); }
    .table-riwayat th {
        background: transparent; color: white; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; border-bottom: none; padding: 14px 18px;
    }
    .table-riwayat td { padding: 14px 18px; }
    .riwayat-row-num { color: #bbb; font-weight: 600; }
    .riwayat-date-icon { color: #764ba2; margin-right: 6px; }
    .riwayat-icon-box {
        width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; color: white; font-size: 14px;
    }
    .riwayat-icon-box.tone-pelanggaran { background: linear-gradient(135deg, #e08a8a, #c53030); }
    .riwayat-icon-box.tone-penghargaan { background: linear-gradient(135deg, #4ca86b, #2f855a); }
    .riwayat-tier-pill {
        padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;
        display: inline-flex; align-items: center;
    }
    .riwayat-tier-pill.tier-ringan    { background: #fef9e7; color: #92702a; }
    .riwayat-tier-pill.tier-sedang    { background: #fff4e6; color: #9c5a2e; }
    .riwayat-tier-pill.tier-berat     { background: #fdecea; color: #a34848; }
    .riwayat-tier-pill.tier-prestasi  { background: #eafaf0; color: #2f855a; }
    .riwayat-btn-delete {
        background: #fff0f0; color: #e53e3e; border: none; padding: 6px 14px; border-radius: 20px;
        font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center;
        gap: 5px; transition: background .15s;
    }
    .riwayat-btn-delete:hover { background: #ffe0e0; }

    @media (max-width: 992px) {
        .poin-grid { grid-template-columns: 1fr; }
        .poin-header-banner { flex-direction: column; align-items: flex-start; gap: 14px; }
    }

    /* === SAMAKAN GAYA DENGAN TAB LAIN (btn/badge/form pill style app) === */
    .poin-header-banner::before {
        content: ''; position: absolute; right: 80px; bottom: -60px; width: 140px; height: 140px;
        background: rgba(255,255,255,.06); border-radius: 50%;
    }
    .main-content .badge { border-radius: 20px; font-weight: 600; }
    .main-content .fw-bold { font-weight: 600 !important; }

    /* Empty state — standar aplikasi */
    .empty-state   { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 54px; color: #e2e5ee; display: block; margin-bottom: 14px; }
    .empty-state h4 { color: #aab; margin: 0 0 6px; font-size: 15px; }
    .empty-state p  { color: #ccc; margin: 0; font-size: 13px; }
    .main-content .form-select,
    .main-content .form-control {
        width: 100%; padding: 11px 14px; border: 2px solid #edf0f7; border-radius: 10px;
        font-size: 13px; color: #333; background: #fafbff; outline: none; transition: border .15s;
    }
    .main-content input[type="file"].form-control {
        padding: 6px 10px; font-size: 12.5px; color: #888;
    }
    .main-content input[type="file"].form-control::file-selector-button {
        margin-right: 10px; padding: 6px 12px; font-size: 12px; font-weight: 600;
        color: #4a5068; background: #eef0ff; border: none; border-radius: 8px;
        cursor: pointer; transition: background .15s;
    }
    .main-content input[type="file"].form-control::file-selector-button:hover { background: #e2e4f5; }
    .main-content .form-select:focus,
    .main-content .form-control:focus {
        border-color: #667eea; background: white; box-shadow: none;
    }
    .main-content .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2); border: none;
        border-radius: 25px !important; box-shadow: 0 4px 15px rgba(102,126,234,.4);
        padding: 11px 28px; font-size: 13px; font-weight: 700;
    }
    .main-content .btn-primary:hover { opacity: .92; }
    .main-content .btn-sm.btn-success {
        background: #e6fff5; color: #38a169; border: none; border-radius: 20px; font-weight: 700; font-size: 11px;
    }
    .main-content .btn-sm.btn-success:hover { background: #d3f3e0; }
    .main-content .btn-outline-danger,
    .main-content .btn-outline-primary {
        border-radius: 20px;
    }
    .main-content .btn-sm.btn-outline-danger {
        background: #fff0f0; color: #e53e3e; border: none; font-weight: 700; font-size: 11px;
    }
    .main-content .btn-sm.btn-outline-danger:hover { background: #ffe0e0; color: #e53e3e; }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        


                {{-- Top Success Alert --}}
                @if(session('success'))
                <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <div>{{ session('success') }}</div>
                </div>
                @endif

                {{-- Header Banner --}}
                <div class="poin-header-banner">
                    <div>
                        <h1 class="banner-title"><i class="fas fa-balance-scale"></i> Sistem Pengusulan Poin & Sanksi Taruna</h1>
                <p class="banner-sub">Sesuai Peraturan Tata Tertib Taruna (PTTT) PPI Curug &bull; Validasi Admin Pusbangkar</p>
            </div>
            <div>
                <span class="badge bg-white text-dark px-3 py-2 fw-bold shadow-sm">
                    <i class="fas fa-user-shield text-primary me-1"></i> Mode: {{ auth()->user()->canManageSystem() ? 'Admin Pusbangkar (Validator)' : 'Pengasuh (Pengusul)' }}
                </span>
            </div>
        </div>

        {{-- Workflow Diagram Mini-Map --}}
        <div class="flow-bar">
            <div class="flow-step {{ $selectedStudent ? 'active' : '' }}">
                <span class="flow-num">1</span>
                <span>Pilih Nama Taruna</span>
            </div>
            <i class="fas fa-chevron-right flow-arrow"></i>
            <div class="flow-step {{ $selectedStudent ? 'active' : '' }}">
                <span class="flow-num">2</span>
                <span>Pilih Usulan (Penghargaan / Pelanggaran PTTT)</span>
            </div>
            <i class="fas fa-chevron-right flow-arrow"></i>
            <div class="flow-step">
                <span class="flow-num">3</span>
                <span>Sistem Menyesuaikan Nilai (Otomatis)</span>
            </div>
            <i class="fas fa-chevron-right flow-arrow"></i>
            <div class="flow-step">
                <span class="flow-num">4</span>
                <span>Validasi Admin &bull; Akumulasi &amp; Tindakan (SP 1 / SP 2 / SP 3)</span>
            </div>
        </div>

        {{-- ========================================================== --}}
        {{-- SECTION USULAN MENUNGGU VALIDASI (JIKA ADA USULAN PENDING) --}}
        {{-- ========================================================== --}}
        @if($allPendingValidation->count() > 0)
        <div class="card-panel border-warning border-2 mb-4">
            <div class="card-panel-header bg-warning bg-opacity-10">
                <div class="card-panel-title text-dark">
                    <i class="fas fa-clipboard-check text-warning"></i>
                    Usulan Temuan Poin Menunggu Validasi Admin Pusbangkar
                    <span class="badge bg-danger ms-2">{{ $allPendingValidation->count() }} Usulan</span>
                </div>
                <div class="small text-muted">Perlu validasi untuk masuk ke akumulasi taruna</div>
            </div>
            <div class="card-panel-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Taruna</th>
                                <th>Jenis</th>
                                <th>Kegiatan / Temuan</th>
                                <th>Poin</th>
                                <th>Diajukan Oleh</th>
                                <th>Tanggal</th>
                                @if(auth()->user()->canManageSystem())
                                <th class="text-center">Aksi Validasi</th>
                                @else
                                <th>Status</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allPendingValidation as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->nama_mahasiswa }}</strong>
                                    <div class="small text-muted">{{ $item->npm }} &bull; {{ $item->kelas }}</div>
                                </td>
                                <td>
                                    @if($item->kategori === 'pelanggaran')
                                        <span class="badge bg-danger">Pelanggaran ({{ ucfirst($item->tingkat ?? 'PTTT') }})</span>
                                    @else
                                        <span class="badge bg-success">Penghargaan ({{ ucfirst($item->tingkat ?? 'Prestasi') }})</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $item->kegiatan }}</div>
                                    @if($item->keterangan)
                                    <div class="small text-muted">{{ Str::limit($item->keterangan, 50) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold {{ $item->kategori === 'pelanggaran' ? 'text-danger' : 'text-success' }}">
                                        {{ $item->kategori === 'pelanggaran' ? '-' : '+' }}{{ $item->nilai }} Poin
                                    </span>
                                </td>
                                <td>
                                    <div class="small fw-bold text-dark">{{ $item->pengasuh }}</div>
                                    <div class="text-muted" style="font-size:10px;">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                                
                                @if(auth()->user()->canManageSystem())
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        {{-- Approve --}}
                                        <form action="{{ route('poin.validasi', $item->id) }}" method="POST" onsubmit="return confirm('Validasi & setujui usulan poin ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="aksi" value="setujui">
                                            <button type="submit" class="btn btn-sm btn-success fw-bold">
                                                <i class="fas fa-check me-1"></i> Validasi
                                            </button>
                                        </form>

                                        {{-- Reject --}}
                                        <form action="{{ route('poin.validasi', $item->id) }}" method="POST" onsubmit="return confirm('Tolak usulan poin ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="aksi" value="tolak">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @else
                                <td>
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Menunggu Admin</span>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        {{-- ========================================================== --}}
        {{-- MAIN 2-COLUMN POIN LAYOUT --}}
        {{-- ========================================================== --}}
        <div class="poin-grid">

            {{-- ── KOLOM KIRI: PILIH TARUNA & STATUS PROFILE ── --}}
            <div>
                {{-- Card Pilih Taruna --}}
                <div class="card-panel">
                    <div class="card-panel-header">
                        <div class="card-panel-title">
                            <i class="fas fa-user-graduate text-primary"></i> 1. Pilih Nama Taruna
                        </div>
                    </div>
                    <div class="card-panel-body">
                        <div class="mhs-search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="mhsSearchInput" placeholder="Ketik nama atau NPM..." oninput="filterMhsList()"
                                   value="{{ $selectedStudent ? $selectedStudent->nama : '' }}">
                        </div>

                        <div class="mhs-list-dropdown" id="mhsDropdownList">
                            @foreach($flatMahasiswa as $mhs)
                            <a href="{{ route('poin.index', ['npm' => $mhs->npm]) }}" 
                               class="text-decoration-none mhs-item-opt {{ $selectedNpm === $mhs->npm ? 'selected' : '' }}"
                               data-search="{{ strtolower($mhs->nama . ' ' . $mhs->npm . ' ' . $mhs->kelas) }}">
                                <div class="mhs-opt-ava">{{ strtoupper(substr($mhs->nickname ?? $mhs->nama, 0, 2)) }}</div>
                                <div style="flex:1; min-width:0;">
                                    <div class="mhs-opt-name text-truncate">{{ $mhs->nama }}</div>
                                    <div class="mhs-opt-meta">{{ $mhs->npm }} &bull; {{ $mhs->kelas }}</div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Status Sanksi & Profil Taruna (Jika Dipilih) --}}
                @if($selectedStudent)
                <div class="card-panel">
                    <div class="card-panel-body">
                        <div class="student-profile-box">
                            <div class="student-profile-ava">{{ strtoupper(substr($selectedStudent->nickname ?? $selectedStudent->nama, 0, 2)) }}</div>
                            <div class="student-profile-name">{{ $selectedStudent->nama }}</div>
                            <div class="student-profile-meta">NPM: {{ $selectedStudent->npm }} &bull; Kelas: {{ $selectedStudent->kelas }}</div>
                        </div>

                        {{-- DUAL SCORE BOX (Penghargaan TIDAK mengurangi Pelanggaran) --}}
                        <div class="dual-score-grid">
                            {{-- Akumulasi Pelanggaran (-) --}}
                            <div class="score-card pelanggaran-card">
                                <div class="score-card-lbl"><i class="fas fa-exclamation-circle me-1"></i> Pelanggaran (-)</div>
                                <div class="score-card-val">{{ $totalPelanggaran }}</div>
                                <div class="score-card-sub">Akumulasi Poin</div>
                            </div>

                            {{-- Akumulasi Penghargaan (+) --}}
                            <div class="score-card penghargaan-card">
                                <div class="score-card-lbl"><i class="fas fa-trophy me-1"></i> Penghargaan (+)</div>
                                <div class="score-card-val">+{{ $totalPenghargaan }}</div>
                                <div class="score-card-sub">Poin Prestasi Mandiri</div>
                            </div>
                        </div>

                        {{-- STATUS SANKSI TARUNA (Threshold Pelanggaran) --}}
                        <div class="sanksi-status-alert" style="background:{{ $statusSanksi['bg'] }}; border-color:{{ $statusSanksi['border'] }}; color:{{ $statusSanksi['color'] }};">
                            <div class="sanksi-icon"><i class="{{ $statusSanksi['icon'] }}"></i></div>
                            <div>
                                <div class="sanksi-title">{{ $statusSanksi['status'] }}</div>
                                <p class="sanksi-desc">{{ $statusSanksi['desc'] }}</p>
                            </div>
                        </div>

                        {{-- Progress Threshold Bar --}}
                        <div class="threshold-bar-wrapper">
                            <div class="d-flex justify-content-between text-muted" style="font-size:10px; font-weight:800; margin-bottom:4px;">
                                <span>Aman (&lt;50)</span>
                                <span>SP 1 (50-74)</span>
                                <span>SP 2 (75-99)</span>
                                <span>SP 3 (≥100)</span>
                            </div>
                            <div class="threshold-bar">
                                <div class="t-step t-aman" title="Status Aman (<50)"></div>
                                <div class="t-step t-sp1" title="SP 1 (50-74)"></div>
                                <div class="t-step t-sp2" title="SP 2 (75-99)"></div>
                                <div class="t-step t-sp3" title="SP 3 (≥100)"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- ── KOLOM KANAN: FORM USULAN & RIWAYAT POIN ── --}}
            <div>
                @if($selectedStudent)
                {{-- CARD FORM PENGUSULAN POIN --}}
                <div class="card-panel">
                    <div class="card-panel-header">
                        <div class="card-panel-title">
                            <i class="fas fa-plus-circle text-primary"></i> 2. Form Pengusulan Poin &amp; Tindakan
                        </div>
                        <span class="badge bg-light text-dark border">Taruna: {{ $selectedStudent->nama }}</span>
                    </div>
                    <div class="card-panel-body">
                        <form action="{{ route('poin.store') }}" method="POST" enctype="multipart/form-data" id="formUsulPoin">
                            @csrf
                            <input type="hidden" name="npm" value="{{ $selectedStudent->npm }}">
                            <input type="hidden" name="kategori" id="inputKategoriPoin" value="pelanggaran">
                            <input type="hidden" name="tingkat" id="inputTingkatPoin" value="ringan">
                            <input type="hidden" name="nilai" id="inputNilaiPoin" value="5">

                            {{-- TOGGLE CABANG USULAN (A. Penghargaan vs B. Pelanggaran) --}}
                            <div class="usulan-toggle">
                                <button type="button" class="toggle-btn active-pelanggaran" id="btnPilihPelanggaran" onclick="switchKategori('pelanggaran')">
                                    <i class="fas fa-ban"></i> B. Pelanggaran (Indisipliner -)
                                </button>
                                <button type="button" class="toggle-btn" id="btnPilihPenghargaan" onclick="switchKategori('prestasi')">
                                    <i class="fas fa-trophy"></i> A. Penghargaan (Prestasi +)
                                </button>
                            </div>

                            {{-- ================= FORM CABANG B: PELANGGARAN PTTT ================= --}}
                            <div id="sectionFormPelanggaran">
                                <label class="form-label fw-bold text-dark mb-2">Tingkat Pelanggaran PTTT (Sistem Menyesuaikan Nilai Otomatis):</label>
                                
                                <div class="tingkat-pelanggaran-grid">
                                    <div class="tingkat-card tier-ringan active-ringan" id="cardRingan" onclick="selectTingkatPelanggaran('ringan', 5)">
                                        <div class="tingkat-name">Ringan</div>
                                        <div class="tingkat-poin">5 Poin</div>
                                    </div>
                                    <div class="tingkat-card tier-sedang" id="cardSedang" onclick="selectTingkatPelanggaran('sedang', 20)">
                                        <div class="tingkat-name">Sedang</div>
                                        <div class="tingkat-poin">20 Poin</div>
                                    </div>
                                    <div class="tingkat-card tier-berat" id="cardBerat" onclick="selectTingkatPelanggaran('berat', 50)">
                                        <div class="tingkat-name">Berat</div>
                                        <div class="tingkat-poin">50 Poin</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Pilih Jenis Pelanggaran Sesuai PTTT *</label>
                                    <select class="form-select" id="selectJenisPelanggaran" onchange="setKegiatanFromSelect(this)">
                                        <option value="">-- Pilih Jenis Pelanggaran PTTT --</option>
                                        @foreach($masterPelanggaran['ringan']['items'] as $item)
                                        <option value="{{ $item }}" data-tingkat="ringan">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- ================= FORM CABANG A: PENGHARGAAN / PRESTASI ================= --}}
                            <div id="sectionFormPenghargaan" class="d-none">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Kategori / Tingkat Penghargaan *</label>
                                        <select class="form-select" id="selectKategoriPenghargaan" onchange="updatePenghargaanDropdown(this.value)">
                                            <option value="internasional" data-poin="50">Internasional (+50 Poin)</option>
                                            <option value="nasional" data-poin="30">Nasional (+30 Poin)</option>
                                            <option value="provinsi" data-poin="20">Provinsi / Daerah (+20 Poin)</option>
                                            <option value="internal" data-poin="10">Internal Kampus (+10 Poin)</option>
                                            <option value="keteladanan" data-poin="15">Keteladanan &amp; Kepemimpinan (+15 Poin)</option>
                                            <option value="khusus" data-poin="10">Penugasan / Petugas Khusus (+10 Poin)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark">Bobot Poin Diberikan</label>
                                        <input type="number" class="form-control fw-bold text-success" id="displayNilaiPenghargaan" value="50" min="1" onchange="document.getElementById('inputNilaiPoin').value = this.value">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Pilih Jenis Prestasi / Penghargaan *</label>
                                    <select class="form-select" id="selectJenisPenghargaan" onchange="setKegiatanFromSelect(this)">
                                        <option value="">-- Pilih Jenis Prestasi --</option>
                                        @foreach($masterPenghargaan['internasional']['items'] as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Judul Kegiatan / Keterangan Manual --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Detail Deskripsi Kegiatan / Temuan *</label>
                                <input type="text" class="form-control" name="kegiatan" id="inputNamaKegiatan" placeholder="Ketik atau pilih dari dropdown di atas..." required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Tanggal Kejadian / Prestasi *</label>
                                    <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Dokumentasi / Bukti (BAP / Sertifikat / Foto)</label>
                                    <input type="file" class="form-control" name="foto_bukti" accept="image/*">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Catatan Tambahan (Opsional)</label>
                                <textarea class="form-control" name="keterangan" rows="2" placeholder="Catatan kronologi / saksi / tindak lanjut..."></textarea>
                            </div>

                            {{-- Workflow Note --}}
                            <div class="p-3 bg-light border rounded-3 mb-3 small text-muted">
                                @if(auth()->user()->canManageSystem())
                                <i class="fas fa-info-circle text-primary me-1"></i>
                                <strong>Mode Admin Pusbangkar:</strong> Poin yang disimpan akan <strong>langsung tervalidasi</strong> dan otomatis terakumulasi ke profil taruna.
                                @else
                                <i class="fas fa-info-circle text-warning me-1"></i>
                                <strong>Mode Pengasuh:</strong> Poin yang disimpan akan dikirim sebagai <strong>Usulan Temuan</strong> dan diproses validasi oleh Admin Pusbangkar.
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary fw-bold w-100 py-2 rounded-3 shadow-sm" id="btnSubmitPoin">
                                <i class="fas fa-paper-plane me-1"></i> Simpan &amp; Proses Poin Taruna
                            </button>
                        </form>
                    </div>
                </div>

                {{-- RIWAYAT POIN TERPISAH (TABEL PELANGGARAN & PENGHARGAAN) --}}
                {{-- Kotak Judul + Tombol Switch (gaya header Acara) --}}
                <div class="riwayat-title-box">
                    <div class="riwayat-title-inner">
                        <div class="riwayat-title-text">
                            <h2><i class="fas fa-history me-2"></i> Rekapitulasi Riwayat Poin Taruna</h2>
                            <p>Riwayat pelanggaran &amp; penghargaan taruna yang tervalidasi</p>
                        </div>
                        <ul class="nav riwayat-tabs" id="riwayatTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold text-danger" id="pelanggaran-tab" data-bs-toggle="tab" data-bs-target="#tabPelanggaran" type="button" role="tab">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Pelanggaran ({{ $riwayatPelanggaran->count() }}) &bull; Total: {{ $totalPelanggaran }} Poin
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold text-success" id="penghargaan-tab" data-bs-toggle="tab" data-bs-target="#tabPenghargaan" type="button" role="tab">
                                    <i class="fas fa-trophy me-1"></i> Penghargaan ({{ $riwayatPenghargaan->count() }}) &bull; Total: +{{ $totalPenghargaan }} Poin
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Kotak Tabel --}}
                <div class="card-panel">
                    <div class="card-panel-body p-0">
                        <div class="tab-content p-3" id="riwayatTabContent">
                            {{-- Tab 1: Pelanggaran --}}
                            <div class="tab-pane fade show active" id="tabPelanggaran" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-custom table-riwayat mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Jenis Pelanggaran</th>
                                                <th>Tanggal</th>
                                                <th>Tingkat</th>
                                                <th>Poin</th>
                                                <th>Pengusul / Validator</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($riwayatPelanggaran as $p)
                                            <tr>
                                                <td class="riwayat-row-num">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="riwayat-icon-box tone-pelanggaran">
                                                            <i class="fas fa-ban"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $p->kegiatan }}</div>
                                                            @if($p->keterangan)<div class="small text-muted">{{ $p->keterangan }}</div>@endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar riwayat-date-icon"></i>
                                                    {{ $p->tanggal ? $p->tanggal->format('d/m/Y') : '-' }}
                                                </td>
                                                <td>
                                                    <span class="riwayat-tier-pill tier-{{ $p->tingkat ?? 'ringan' }}">
                                                        {{ ucfirst($p->tingkat ?? 'Pelanggaran') }}
                                                    </span>
                                                </td>
                                                <td class="fw-bold text-danger">-{{ $p->nilai }} Poin</td>
                                                <td>
                                                    <div class="small fw-semibold">{{ $p->pengasuh }}</div>
                                                    <div style="font-size:10px;" class="text-success"><i class="fas fa-check-circle"></i> Tervalidasi</div>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('poin.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus poin ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="riwayat-btn-delete" title="Hapus">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    <i class="fas fa-shield-alt mb-2 d-block" style="font-size:38px; color:#e2e5ee;"></i>
                                                    Tidak ada catatan pelanggaran tervalidasi. Status Disiplin: <strong>Aman</strong>.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Tab 2: Penghargaan --}}
                            <div class="tab-pane fade" id="tabPenghargaan" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-custom table-riwayat mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Prestasi / Penghargaan</th>
                                                <th>Tanggal</th>
                                                <th>Tingkat</th>
                                                <th>Poin</th>
                                                <th>Pemberi Rekomendasi</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($riwayatPenghargaan as $r)
                                            <tr>
                                                <td class="riwayat-row-num">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="riwayat-icon-box tone-penghargaan">
                                                            <i class="fas fa-trophy"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $r->kegiatan }}</div>
                                                            @if($r->keterangan)<div class="small text-muted">{{ $r->keterangan }}</div>@endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar riwayat-date-icon"></i>
                                                    {{ $r->tanggal ? $r->tanggal->format('d/m/Y') : '-' }}
                                                </td>
                                                <td>
                                                    <span class="riwayat-tier-pill tier-prestasi">
                                                        {{ ucfirst($r->tingkat ?? 'Prestasi') }}
                                                    </span>
                                                </td>
                                                <td class="fw-bold text-success">+{{ $r->nilai }} Poin</td>
                                                <td>
                                                    <div class="small fw-semibold">{{ $r->pengasuh }}</div>
                                                    <div style="font-size:10px;" class="text-success"><i class="fas fa-check-circle"></i> Tervalidasi</div>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('poin.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus poin ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="riwayat-btn-delete" title="Hapus">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    <i class="fas fa-award mb-2 d-block" style="font-size:38px; color:#e2e5ee;"></i>
                                                    Belum ada catatan penghargaan/prestasi tervalidasi.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card-panel">
                    <div class="empty-state">
                        <i class="fas fa-user-check"></i>
                        <h4>Pilih Taruna Terlebih Dahulu</h4>
                        <p>Silakan pilih salah satu taruna di kolom kiri untuk melihat raport poin, sanksi PTTT, dan mengusulkan poin baru.</p>
                    </div>
                </div>
                @endif
            </div>

        </div>

    </div>
</main>

{{-- Master Data JSON JS --}}
<script>
    const masterPelanggaran = @json($masterPelanggaran);
    const masterPenghargaan = @json($masterPenghargaan);

    function filterMhsList() {
        const q = document.getElementById('mhsSearchInput').value.toLowerCase().trim();
        const items = document.querySelectorAll('.mhs-item-opt');
        items.forEach(item => {
            const data = item.dataset.search || '';
            item.style.display = data.includes(q) ? 'flex' : 'none';
        });
    }

    function switchKategori(kat) {
        document.getElementById('inputKategoriPoin').value = kat;
        const btnPelanggaran = document.getElementById('btnPilihPelanggaran');
        const btnPenghargaan = document.getElementById('btnPilihPenghargaan');
        const secPelanggaran = document.getElementById('sectionFormPelanggaran');
        const secPenghargaan = document.getElementById('sectionFormPenghargaan');

        if (kat === 'pelanggaran') {
            btnPelanggaran.className = 'toggle-btn active-pelanggaran';
            btnPenghargaan.className = 'toggle-btn';
            secPelanggaran.classList.remove('d-none');
            secPenghargaan.classList.add('d-none');
            selectTingkatPelanggaran('ringan', 5);
        } else {
            btnPelanggaran.className = 'toggle-btn';
            btnPenghargaan.className = 'toggle-btn active-penghargaan';
            secPelanggaran.classList.add('d-none');
            secPenghargaan.classList.remove('d-none');
            updatePenghargaanDropdown('internasional');
        }
    }

    function selectTingkatPelanggaran(tingkat, poin) {
        document.getElementById('inputTingkatPoin').value = tingkat;
        document.getElementById('inputNilaiPoin').value = poin;

        // Reset visual card classes (tetap pertahankan warna tier permanen)
        document.getElementById('cardRingan').className = 'tingkat-card tier-ringan' + (tingkat === 'ringan' ? ' active-ringan' : '');
        document.getElementById('cardSedang').className = 'tingkat-card tier-sedang' + (tingkat === 'sedang' ? ' active-sedang' : '');
        document.getElementById('cardBerat').className  = 'tingkat-card tier-berat'  + (tingkat === 'berat'  ? ' active-berat'  : '');

        // Populate dropdown options
        const select = document.getElementById('selectJenisPelanggaran');
        select.innerHTML = '<option value="">-- Pilih Jenis Pelanggaran ' + tingkat.toUpperCase() + ' PTTT --</option>';
        if (masterPelanggaran[tingkat] && masterPelanggaran[tingkat].items) {
            masterPelanggaran[tingkat].items.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item;
                opt.textContent = item + ' (' + poin + ' Poin)';
                select.appendChild(opt);
            });
        }
    }

    function updatePenghargaanDropdown(kategori) {
        document.getElementById('inputTingkatPoin').value = kategori;
        const select = document.getElementById('selectJenisPenghargaan');
        const poin = masterPenghargaan[kategori] ? masterPenghargaan[kategori].bobot : 10;
        
        document.getElementById('inputNilaiPoin').value = poin;
        document.getElementById('displayNilaiPenghargaan').value = poin;

        select.innerHTML = '<option value="">-- Pilih Jenis Prestasi --</option>';
        if (masterPenghargaan[kategori] && masterPenghargaan[kategori].items) {
            masterPenghargaan[kategori].items.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item;
                opt.textContent = item;
                select.appendChild(opt);
            });
        }
    }

    function setKegiatanFromSelect(select) {
        if (select.value) {
            document.getElementById('inputNamaKegiatan').value = select.value;
        }
    }
</script>
</x-app-layout>
