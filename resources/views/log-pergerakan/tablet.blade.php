<x-app-layout>
<style>
    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: transparent; }

    .app-layout { display: flex; min-height: 100vh; }
    .main-content { flex: 1; padding: 24px 28px; min-width: 0; }

    /* === HEADER BANNER === */
    .tablet-banner {
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
        box-shadow: 0 8px 20px -6px rgba(102, 126, 234, 0.35);
    }
    .tablet-banner::after {
        content: ''; position: absolute; right: -40px; top: -40px; width: 180px; height: 180px;
        background: rgba(255,255,255,.08); border-radius: 50%;
    }
    .banner-title { font-size: 22px; font-weight: 800; margin: 0 0 4px 0; display: flex; align-items: center; gap: 10px; }
    .banner-sub { font-size: 13px; opacity: 0.9; margin: 0; }
    
    .quick-stats-badge {
        display: flex; gap: 12px; z-index: 1;
    }
    .stat-pill {
        background: rgba(255,255,255,0.18);
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        padding: 10px 16px;
        text-align: center;
    }
    .stat-pill-num { font-size: 20px; font-weight: 800; line-height: 1; }
    .stat-pill-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85; margin-top: 3px; }

    /* === TAB SWITCHER (START vs KEMBALI) === */
    .mode-switcher {
        display: flex;
        background: #edf0f7;
        border-radius: 14px;
        padding: 4px;
        margin-bottom: 24px;
        gap: 4px;
    }
    .mode-tab {
        flex: 1;
        text-align: center;
        padding: 14px 20px;
        font-size: 15px;
        font-weight: 700;
        color: #888;
        background: transparent;
        border: none;
        border-radius: 11px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .mode-tab:hover { color: #333; }
    .mode-tab.active {
        background: white;
        color: #667eea;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .tab-badge {
        background: #ef4444;
        color: white;
        border-radius: 20px;
        padding: 2px 8px;
        font-size: 11px;
        font-weight: 800;
    }

    /* === FLOW CARDS: PILIH KATEGORI (3 CABANG) === */
    .category-selection-title {
        font-size: 15px; font-weight: 700; color: #444; margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .cat-card {
        background: white;
        border: 2px solid #edf0f7;
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .cat-card:hover {
        border-color: #a5b0f0;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.1);
    }
    .cat-card.active {
        border-color: #667eea;
        background: #f8f9ff;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
    }
    .cat-card.active::after {
        content: '\f00c';
        font-family: 'Font Awesome 5 Free', 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 12px;
        right: 14px;
        width: 24px;
        height: 24px;
        background: #667eea;
        color: white;
        border-radius: 50%;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cat-icon-wrapper {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; margin-bottom: 14px;
    }
    .cat-1 .cat-icon-wrapper { background: #fee2e2; color: #dc2626; }
    .cat-2 .cat-icon-wrapper { background: #e0e7ff; color: #4338ca; }
    .cat-3 .cat-icon-wrapper { background: #dcfce7; color: #15803d; }
    .cat-num { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.7; margin-bottom: 2px; }
    .cat-name { font-size: 17px; font-weight: 800; color: #333; margin-bottom: 4px; }
    .cat-desc { font-size: 12px; color: #888; line-height: 1.4; }

    /* === FORM CONTAINER === */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }
    .form-section-title {
        font-size: 16px; font-weight: 800; color: #333; margin-bottom: 18px;
        padding-bottom: 10px; border-bottom: 1px solid #f0f2f7;
        display: flex; align-items: center; justify-content: space-between;
    }
    .form-group { margin-bottom: 18px; }
    .form-label { font-size: 13px; font-weight: 700; color: #444; margin-bottom: 6px; display: block; }
    .form-label .req { color: #ef4444; }
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #edf0f7;
        padding: 11px 14px;
        font-size: 13px;
        color: #333;
        background: #fafbff;
        width: 100%;
        transition: border .15s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        background: white;
        box-shadow: none;
        outline: none;
    }

    /* Subcategory Pill Selectors */
    .subcat-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
    .subcat-pill {
        padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700;
        border: 1.5px solid #edf0f7; background: white; color: #555; cursor: pointer;
        transition: all 0.15s;
    }
    .subcat-pill:hover { border-color: #aab; background: #fafbff; }
    .subcat-pill.active {
        background: #667eea; border-color: #667eea; color: white;
    }

    /* Status Awal Box */
    .status-awal-box {
        background: #fef2f2;
        border: 1.5px dashed #f87171;
        border-radius: 12px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 20px;
        margin-bottom: 24px;
    }
    .status-badge-berangkat {
        background: #dc2626;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        animation: pulseRed 2s infinite;
    }
    @keyframes pulseRed {
        0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(220, 38, 38, 0); }
    }

    .btn-submit-log {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 14px 28px;
        font-size: 14px;
        font-weight: 700;
        width: 100%;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-submit-log:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, .4);
    }

    /* === MODE 2: KEPULANGAN / TARUNA KEMBALI === */
    .search-return-bar {
        position: relative;
        margin-bottom: 20px;
    }
    .search-return-bar input {
        width: 100%;
        padding: 14px 18px 14px 46px;
        border-radius: 14px;
        border: 2px solid #edf0f7;
        font-size: 15px;
        font-weight: 600;
        background: white;
    }
    .search-return-bar i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #aab;
        font-size: 17px;
    }

    .return-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .return-card {
        background: white;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1.5px solid #edf0f7;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s;
    }
    .return-card:hover {
        transform: translateY(-2px);
        border-color: #edf0f7;
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }
    .return-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    .return-name { font-size: 16px; font-weight: 800; color: #333; margin-bottom: 2px; }
    .return-meta { font-size: 12px; color: #888; }
    .badge-belum-kembali {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-belum-kembali .dot {
        width: 7px; height: 7px; background: #dc2626; border-radius: 50%; display: inline-block;
    }
    .return-detail {
        background: #fafbff;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 12.5px;
        color: #444;
        margin-bottom: 14px;
    }
    .btn-action-kembali {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.15s;
    }
    .btn-action-kembali:hover { background: #059669; }

    @media (max-width: 992px) {
        .category-grid { grid-template-columns: 1fr; }
        .return-grid { grid-template-columns: 1fr; }
        .tablet-banner { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
</style>

<div class="app-layout">
    <x-sidebar active="log-pergerakan" />

    <main class="main-content">

        {{-- Top Notification --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-check-circle fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Header Banner --}}
        <div class="tablet-banner">
            <div>
                <h1 class="banner-title">
                    <i class="fas fa-tablet-alt"></i> Sistem Pengisian Tablet Log Pergerakan Taruna
                </h1>
                <p class="banner-sub">
                    Pencatatan Keberangkatan & Kepulangan Taruna Terintegrasi Real-Time ke Dashboard TV Monitoring Jaga
                </p>
            </div>
            <div class="quick-stats-badge">
                <div class="stat-pill">
                    <div class="stat-pill-num text-warning">{{ $stats['belum_kembali'] }}</div>
                    <div class="stat-pill-label">Di Luar (Belum Kembali)</div>
                </div>
                <div class="stat-pill">
                    <div class="stat-pill-num text-light">{{ $stats['sudah_kembali'] }}</div>
                    <div class="stat-pill-label">Kembali Hari Ini</div>
                </div>
                <a href="{{ route('log-pergerakan.tv') }}" target="_blank" class="btn btn-outline-light d-flex align-items-center gap-2 fw-bold rounded-3 px-3">
                    <i class="fas fa-tv"></i> Buka Layar TV Jaga
                </a>
            </div>
        </div>

        {{-- Switcher Tab Mode --}}
        <div class="mode-switcher">
            <button type="button" class="mode-tab active" id="tabBtnKeberangkatan" onclick="switchMode('keberangkatan')">
                <i class="fas fa-sign-out-alt"></i> 1. Form Log Keberangkatan (START)
            </button>
            <button type="button" class="mode-tab" id="tabBtnKepulangan" onclick="switchMode('kepulangan')">
                <i class="fas fa-sign-in-alt"></i> 2. Taruna Kembali ke Asrama (STATUS AKHIR)
                @if($stats['belum_kembali'] > 0)
                <span class="tab-badge" id="badgeBelumKembaliCount">{{ $stats['belum_kembali'] }}</span>
                @endif
            </button>
        </div>

        {{-- ======================================================== --}}
        {{-- MODE 1: FORM KEBERANGKATAN (START -> 3 CABANG -> BERANGKAT) --}}
        {{-- ======================================================== --}}
        <div id="sectionKeberangkatan">
            
            {{-- PILIH KATEGORI PERGERAKAN --}}
            <div class="category-selection-title">
                <i class="fas fa-code-branch text-primary"></i> PILIH KATEGORI PERGERAKAN (3 CABANG):
            </div>
            
            <div class="category-grid">
                {{-- Cabang 1: Perizinan --}}
                <div class="cat-card cat-1 active" id="cardKatPerizinan" onclick="selectCategory('perizinan')">
                    <div class="cat-icon-wrapper"><i class="fas fa-notes-medical"></i></div>
                    <div class="cat-num">Cabang 1</div>
                    <div class="cat-name">1. Perizinan</div>
                    <div class="cat-desc">Kesehatan, Berduka, Keperluan Keluarga / Dinas Luar</div>
                </div>

                {{-- Cabang 2: Ekstrakurikuler --}}
                <div class="cat-card cat-2" id="cardKatEkskul" onclick="selectCategory('ekstrakurikuler')">
                    <div class="cat-icon-wrapper"><i class="fas fa-cogs"></i></div>
                    <div class="cat-num">Cabang 2</div>
                    <div class="cat-name">2. Ekstrakurikuler</div>
                    <div class="cat-desc">Kegiatan Ekskul Wajib, Olahraga, Seni, atau Akademik</div>
                </div>

                {{-- Cabang 3: Olahraga --}}
                <div class="cat-card cat-3" id="cardKatOlahraga" onclick="selectCategory('olahraga')">
                    <div class="cat-icon-wrapper"><i class="fas fa-running"></i></div>
                    <div class="cat-num">Cabang 3</div>
                    <div class="cat-name">3. Olahraga</div>
                    <div class="cat-desc">Lari Luar Kampus, Gym, Olahraga Mandiri atau Terpimpin</div>
                </div>
            </div>

            {{-- FORM CARD --}}
            <div class="form-card">
                <form action="{{ route('log-pergerakan.store') }}" method="POST" enctype="multipart/form-data" id="formLogPergerakan">
                    @csrf
                    <input type="hidden" name="kategori" id="inputKategori" value="perizinan">
                    <input type="hidden" name="subkategori" id="inputSubkategori" value="Kesehatan">

                    {{-- Form Header Dinamis --}}
                    <div class="form-section-title">
                        <span id="formTitleText"><i class="fas fa-notes-medical text-danger me-2"></i> Isi Form Izin & Dokumentasi</span>
                        <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">
                            <i class="far fa-clock me-1"></i> Waktu: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    {{-- ================= SUBKATEGORI SELECTOR ================= --}}
                    <div class="form-group">
                        <label class="form-label">Sub-Kategori <span class="req">*</span></label>
                        
                        {{-- Subkategori Perizinan --}}
                        <div class="subcat-pills" id="subcatPerizinan">
                            <button type="button" class="subcat-pill active" onclick="setSubcat('Kesehatan', this)"><i class="fas fa-heartbeat me-1"></i> Kesehatan</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Berduka', this)"><i class="fas fa-hands-praying me-1"></i> Berduka</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Lainnya', this)"><i class="fas fa-ellipsis-h me-1"></i> Lainnya</button>
                        </div>

                        {{-- Subkategori Ekstrakurikuler --}}
                        <div class="subcat-pills d-none" id="subcatEkskul">
                            <button type="button" class="subcat-pill" onclick="setSubcat('Wajib', this)"><i class="fas fa-award me-1"></i> Wajib</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Olahraga', this)"><i class="fas fa-futbol me-1"></i> Olahraga</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Seni', this)"><i class="fas fa-palette me-1"></i> Seni</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Akademik', this)"><i class="fas fa-graduation-cap me-1"></i> Akademik</button>
                        </div>

                        {{-- Subkategori Olahraga --}}
                        <div class="subcat-pills d-none" id="subcatOlahraga">
                            <button type="button" class="subcat-pill" onclick="setSubcat('Mandiri', this)"><i class="fas fa-user me-1"></i> Mandiri</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Terpimpin', this)"><i class="fas fa-users me-1"></i> Terpimpin</button>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Tanggal & Waktu Berangkat --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label">Tanggal & Jam Keberangkatan <span class="req">*</span></label>
                            <input type="datetime-local" class="form-control" name="waktu_berangkat" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                        {{-- Estimasi Kembali --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label">Estimasi Jam Kembali (Opsional)</label>
                            <input type="datetime-local" class="form-control" name="estimasi_kembali" value="{{ \Carbon\Carbon::now()->addHours(2)->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>

                    <div class="row">
                        {{-- Nama Taruna / Koordinator --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label" id="labelNama">Nama Taruna <span class="req">*</span></label>
                            <input type="text" class="form-control" name="nama" id="inputNama" list="mhsList" placeholder="Ketik atau pilih nama taruna..." required autocomplete="off">
                            <datalist id="mhsList">
                                @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->nama }}" data-npm="{{ $mhs->npm }}" data-kelas="{{ $mhs->kelas }}">{{ $mhs->npm }} - {{ $mhs->kelas }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        {{-- NPM / Prodi --}}
                        <div class="col-md-3 form-group">
                            <label class="form-label">NPM</label>
                            <input type="text" class="form-control" name="npm" id="inputNpm" placeholder="Contoh: 2423101994">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="form-label">Prodi / Kelas</label>
                            <input type="text" class="form-control" name="prodi" id="inputProdi" placeholder="Contoh: RPLK / RKS A">
                        </div>
                    </div>

                    {{-- ================= FIELD KHUSUS CABANG 1: PERIZINAN ================= --}}
                    <div id="fieldPerizinan">
                        <div class="form-group">
                            <label class="form-label">Keterangan / Keluhan <span class="req">*</span></label>
                            <textarea class="form-control" name="keterangan_keluhan" id="inputKeterangan" rows="3" placeholder="Jelaskan alasan izin / keluhan kesehatan / tujuan izin keluar..."></textarea>
                        </div>
                    </div>

                    {{-- ================= FIELD KHUSUS CABANG 2: EKSTRAKURIKULER ================= --}}
                    <div id="fieldEkskul" class="d-none">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Dropdown Ekskul <span class="req">*</span></label>
                                <select class="form-select" name="nama_ekskul" id="selectEkskul">
                                    <option value="">-- Pilih Jenis Ekskul --</option>
                                    <option value="Marching Band">Marching Band</option>
                                    <option value="Band Musik">Band Musik</option>
                                    <option value="Paduan Suara">Paduan Suara</option>
                                    <option value="Tari Tradisional & Modern">Tari Tradisional & Modern</option>
                                    <option value="Futsal / Sepakbola">Futsal / Sepakbola</option>
                                    <option value="Bola Basket">Bola Basket</option>
                                    <option value="Bola Voli">Bola Voli</option>
                                    <option value="Badminton">Badminton</option>
                                    <option value="Bela Diri (Karate / Silat / Taekwondo)">Bela Diri (Karate / Silat / Taekwondo)</option>
                                    <option value="Robotika & Aeromodelling">Robotika & Aeromodelling</option>
                                    <option value="English Debate Club">English Debate Club</option>
                                    <option value="Pramuka / Menwa">Pramuka / Menwa</option>
                                    <option value="Rohis / Pelayanan Rohani">Rohis / Pelayanan Rohani</option>
                                    <option value="Lainnya">Lainnya...</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Jumlah Anggota Ikut <span class="req">*</span></label>
                                <input type="number" class="form-control" name="jumlah_anggota" id="inputJumlahAnggota" value="1" min="1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Lokasi Kegiatan <span class="req">*</span></label>
                                <input type="text" class="form-control" name="lokasi_kegiatan" placeholder="Contoh: GOR Tangerang, Kampus Utama, Lapangan Terbang">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Daftar Nama Anggota (Opsional)</label>
                                <input type="text" class="form-control" name="daftar_anggota" placeholder="Contoh: Fatih, Muflih, Joke, Jiro...">
                            </div>
                        </div>
                    </div>

                    {{-- ================= FIELD KHUSUS CABANG 3: OLAHRAGA ================= --}}
                    <div id="fieldOlahraga" class="d-none">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Rute / Lokasi Olahraga <span class="req">*</span></label>
                                <input type="text" class="form-control" name="rute" id="inputRute" placeholder="Contoh: Rute Lari Luar Kampus Curug, Jogging Track Bandara, Lapangan Kompas, Gym">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Pengikut / Teman Olahraga</label>
                                <input type="text" class="form-control" name="pengikut" placeholder="Contoh: 3 orang (Fatih, Joke, Edya)">
                            </div>
                        </div>
                    </div>

                    {{-- ================= DOKUMENTASI ================= --}}
                    <div class="form-group">
                        <label class="form-label">Dokumentasi (Foto Surat Izin / Bukti / Foto Kegiatan)</label>
                        <input type="file" class="form-control" name="foto_keberangkatan" accept="image/*">
                        <small class="text-muted"><i class="fas fa-camera"></i> Anda dapat langsung mengambil foto melalui kamera tablet atau upload file gambar.</small>
                    </div>

                    {{-- Status Awal Card (Sesuai Flowchart: SET STATUS AWAL BERANGKAT) --}}
                    <div class="status-awal-box">
                        <div>
                            <div class="fw-bold text-dark"><i class="fas fa-shield-alt text-danger me-1"></i> STATUS AWAL KELUAR:</div>
                            <div class="small text-muted">Data akan otomatis ditandai <strong>BELUM KEMBALI</strong> dan disinkronkan ke TV Jaga.</div>
                        </div>
                        <div>
                            <span class="status-badge-berangkat">
                                <i class="fas fa-dot-circle"></i> BERANGKAT (BELUM KEMBALI)
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <button type="submit" class="btn-submit-log">
                        <i class="fas fa-save fs-5"></i> SIMPAN DATA KEBERANGKATAN & SINKRONKAN KE TV JAGA
                    </button>
                </form>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- MODE 2: KEPULANGAN / TARUNA KEMBALI (STATUS AKHIR) --}}
        {{-- ======================================================== --}}
        <div id="sectionKepulangan" class="d-none">
            <div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-user-check text-success me-2"></i> Konfirmasi Kepulangan Taruna ke Asrama</h4>
                        <p class="text-muted small mb-0">Cari nama taruna yang statusnya masih 🔴 <strong>Belum Kembali</strong> dan ubah status akhir menjadi 🟢 <strong>Kembali</strong>.</p>
                    </div>
                </div>

                {{-- Live Search Input --}}
                <div class="search-return-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="inputSearchReturn" placeholder="Cari nama taruna / NPM / ekskul / rute..." oninput="filterReturnList()">
                </div>

                {{-- Return Grid List --}}
                <div class="return-grid" id="returnGridContainer">
                    @forelse($belumKembali as $item)
                    <div class="return-card return-item-card" 
                         data-search="{{ strtolower($item->nama . ' ' . $item->npm . ' ' . $item->kategori . ' ' . $item->subkategori . ' ' . $item->nama_ekskul . ' ' . $item->rute . ' ' . $item->keterangan_keluhan) }}">
                        <div>
                            <div class="return-header">
                                <div>
                                    <div class="return-name">{{ $item->nama }}</div>
                                    <div class="return-meta">
                                        {{ $item->npm ?? 'NPM -' }} &bull; {{ $item->prodi ?? 'Prodi -' }}
                                    </div>
                                </div>
                                <div>
                                    <span class="badge-belum-kembali">
                                        <span class="dot"></span> BELUM KEMBALI
                                    </span>
                                </div>
                            </div>

                            <div class="mb-2">
                                {!! $item->getKategoriBadgeHtml() !!}
                                <span class="badge bg-light text-dark border ms-1 fw-bold">{{ $item->subkategori }}</span>
                            </div>

                            <div class="return-detail">
                                <div class="mb-1">
                                    <i class="far fa-clock text-primary me-1"></i> Berangkat: <strong>{{ $item->waktu_berangkat ? $item->waktu_berangkat->format('d/m/Y H:i') : '-' }}</strong>
                                    <span class="text-danger fw-bold ms-2">({{ $item->getDurasiFormatted() }} lalu)</span>
                                </div>
                                @if($item->kategori === 'perizinan' && $item->keterangan_keluhan)
                                <div><i class="fas fa-info-circle text-muted me-1"></i> Izin: {{ Str::limit($item->keterangan_keluhan, 70) }}</div>
                                @elseif($item->kategori === 'ekstrakurikuler')
                                <div><i class="fas fa-cogs text-muted me-1"></i> Ekskul: <strong>{{ $item->nama_ekskul }}</strong> ({{ $item->jumlah_anggota }} orang)</div>
                                @if($item->lokasi_kegiatan)
                                <div><i class="fas fa-map-marker-alt text-muted me-1"></i> Lokasi: {{ $item->lokasi_kegiatan }}</div>
                                @endif
                                @elseif($item->kategori === 'olahraga')
                                <div><i class="fas fa-route text-muted me-1"></i> Rute: <strong>{{ $item->rute }}</strong></div>
                                @if($item->pengikut)
                                <div><i class="fas fa-users text-muted me-1"></i> Pengikut: {{ $item->pengikut }}</div>
                                @endif
                                @endif
                            </div>
                        </div>

                        {{-- Action Button Kembali --}}
                        <form action="{{ route('log-pergerakan.kembali', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa {{ $item->nama }} SUDAH KEMBALI ke asrama?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-action-kembali">
                                <i class="fas fa-check-circle"></i> UBAH STATUS AKHIR: KEMBALI
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5 text-muted" id="emptyReturnMessage">
                        <i class="fas fa-clipboard-check fs-1 text-success mb-3 d-block"></i>
                        <h5 class="fw-bold">Semua Taruna Sudah Kembali</h5>
                        <p class="small">Tidak ada data taruna yang sedang berada di luar asrama saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </main>
</div>

<script>
    // Switcher Tab Mode (Keberangkatan vs Kepulangan)
    function switchMode(mode) {
        const secBerangkat = document.getElementById('sectionKeberangkatan');
        const secKembali = document.getElementById('sectionKepulangan');
        const btnBerangkat = document.getElementById('tabBtnKeberangkatan');
        const btnKembali = document.getElementById('tabBtnKepulangan');

        if (mode === 'keberangkatan') {
            secBerangkat.classList.remove('d-none');
            secKembali.classList.add('d-none');
            btnBerangkat.classList.add('active');
            btnKembali.classList.remove('active');
        } else {
            secBerangkat.classList.add('d-none');
            secKembali.classList.remove('d-none');
            btnBerangkat.classList.remove('active');
            btnKembali.classList.add('active');
        }
    }

    // Category Selector
    function selectCategory(cat) {
        document.getElementById('inputKategori').value = cat;

        // Visual cards active state
        document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active'));
        
        // Hide all subcategories & fields
        document.getElementById('subcatPerizinan').classList.add('d-none');
        document.getElementById('subcatEkskul').classList.add('d-none');
        document.getElementById('subcatOlahraga').classList.add('d-none');

        document.getElementById('fieldPerizinan').classList.add('d-none');
        document.getElementById('fieldEkskul').classList.add('d-none');
        document.getElementById('fieldOlahraga').classList.add('d-none');

        if (cat === 'perizinan') {
            document.getElementById('cardKatPerizinan').classList.add('active');
            document.getElementById('subcatPerizinan').classList.remove('d-none');
            document.getElementById('fieldPerizinan').classList.remove('d-none');
            document.getElementById('formTitleText').innerHTML = '<i class="fas fa-notes-medical text-danger me-2"></i> Isi Form Izin & Dokumentasi';
            document.getElementById('labelNama').innerText = 'Nama Taruna *';
            setSubcat('Kesehatan', document.querySelector('#subcatPerizinan .subcat-pill'));
        } else if (cat === 'ekstrakurikuler') {
            document.getElementById('cardKatEkskul').classList.add('active');
            document.getElementById('subcatEkskul').classList.remove('d-none');
            document.getElementById('fieldEkskul').classList.remove('d-none');
            document.getElementById('formTitleText').innerHTML = '<i class="fas fa-cogs text-primary me-2"></i> Isi Form Ekskul & Dokumentasi';
            document.getElementById('labelNama').innerText = 'Nama Koordinator / PJ *';
            setSubcat('Wajib', document.querySelector('#subcatEkskul .subcat-pill'));
        } else if (cat === 'olahraga') {
            document.getElementById('cardKatOlahraga').classList.add('active');
            document.getElementById('subcatOlahraga').classList.remove('d-none');
            document.getElementById('fieldOlahraga').classList.remove('d-none');
            document.getElementById('formTitleText').innerHTML = '<i class="fas fa-running text-success me-2"></i> Isi Form Olahraga & Dokumentasi';
            document.getElementById('labelNama').innerText = 'Nama Taruna / PJ *';
            setSubcat('Mandiri', document.querySelector('#subcatOlahraga .subcat-pill'));
        }
    }

    // Set Subcategory Pill
    function setSubcat(sub, el) {
        document.getElementById('inputSubkategori').value = sub;
        if (el) {
            const parent = el.closest('.subcat-pills');
            parent.querySelectorAll('.subcat-pill').forEach(p => p.classList.remove('active'));
            el.classList.add('active');
        }
    }

    // Autocomplete student NPM & Kelas when picking from datalist
    document.getElementById('inputNama').addEventListener('input', function(e) {
        const val = this.value;
        const options = document.querySelectorAll('#mhsList option');
        options.forEach(opt => {
            if (opt.value.toLowerCase() === val.toLowerCase()) {
                if (opt.dataset.npm) document.getElementById('inputNpm').value = opt.dataset.npm;
                if (opt.dataset.kelas) document.getElementById('inputProdi').value = opt.dataset.kelas;
            }
        });
    });

    // Filter Taruna Kembali List
    function filterReturnList() {
        const q = document.getElementById('inputSearchReturn').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.return-item-card');
        let visibleCount = 0;
        cards.forEach(card => {
            const searchData = card.dataset.search || '';
            if (searchData.includes(q)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
</x-app-layout>
