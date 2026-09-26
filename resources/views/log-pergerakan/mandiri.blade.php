<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }

/* === STATUS AKTIF (SEDANG IZIN KELUAR) — ds-card + ds-alert/ds-badge === */
.status-active-card { border-color: var(--danger-border); }
.status-active-card .ds-card__head { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
.status-active-card .ds-card__title .ds-icon { color: var(--danger); }
.active-detail-list {
    border-radius: var(--radius-md); background: var(--glass-card);
    border: 1px solid var(--border-glass-glow); padding: 0 var(--space-4); margin-bottom: var(--space-5);
}
.active-detail-row { display: flex; justify-content: space-between; gap: var(--space-4); padding: var(--space-3) 0; border-bottom: 1px solid var(--border-glass-subtle); font-size: 12px; line-height: 16px; }
.active-detail-row:last-child { border-bottom: none; }
.active-detail-row .lbl { font-size: 10px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: var(--ink-600); }
.active-detail-row .val { color: var(--ink-900); font-weight: 700; text-align: right; }

.btn-kembali-mandiri {
    display: flex; align-items: center; justify-content: center; gap: var(--space-2); width: 100%;
    padding: var(--space-3-5) var(--space-6); border-radius: var(--radius-md);
    background: var(--success); border: 1px solid transparent; color: var(--ink-on-dark);
    box-shadow: var(--shadow-glass-sm);
    font-family: inherit; font-size: 13px; line-height: 16px; font-weight: 800; letter-spacing: 0.03em;
    cursor: pointer; transition: background-color .15s, transform .1s, box-shadow .15s;
}
.btn-kembali-mandiri:hover { background: var(--success-ink); box-shadow: var(--shadow-glass); }
.btn-kembali-mandiri:active { transform: scale(.98); }
.btn-kembali-mandiri:focus-visible { outline: none; box-shadow: var(--shadow-focus); }

/* === FLOW CARDS: PILIH KATEGORI (3 CABANG) === */
.category-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-4);
}
.cat-card {
    background: var(--glass-card);
    border: 1px solid var(--border-glass-glow);
    border-radius: var(--radius-lg);
    padding: var(--space-5);
    cursor: pointer;
    transition: transform .25s cubic-bezier(.16,1,.3,1), box-shadow .25s, background-color .25s, border-color .25s;
    position: relative;
    overflow: hidden;
}
.cat-card:hover {
    background: var(--glass-solid);
    transform: translateY(-3px);
    box-shadow: var(--shadow-card-hover);
}
.cat-card.active {
    border-color: var(--accent);
    background: var(--glass-solid);
    box-shadow: 0 0 0 3px var(--focus-ring-glow), var(--shadow-glass-sm);
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
    background: var(--accent);
    color: var(--ink-on-dark);
    border-radius: var(--radius-pill);
    font-size: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cat-icon-wrapper {
    width: 48px; height: 48px; border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; margin-bottom: var(--space-3-5);
    color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm);
}
.cat-1 .cat-icon-wrapper { background: linear-gradient(135deg, #f43f5e, var(--danger)); }
.cat-2 .cat-icon-wrapper { background: linear-gradient(135deg, #2563eb, var(--accent)); }
.cat-3 .cat-icon-wrapper { background: linear-gradient(135deg, #10b981, var(--success)); }
.cat-num { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--ink-500); margin-bottom: 2px; }
.cat-name { font-size: 16px; font-weight: 800; color: var(--ink-900); margin-bottom: var(--space-1); }
.cat-desc { font-size: 12px; color: var(--ink-600); line-height: 1.45; }

/* === FORM CONTAINER — PPI Curug Glass (ds-card / ds-label / ds-input / ds-btn) === */
.form-card {
    background: var(--glass-panel);
    backdrop-filter: blur(var(--blur-standard)) saturate(180%); -webkit-backdrop-filter: blur(var(--blur-standard)) saturate(180%);
    border: 1px solid var(--border-glass);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-glass);
    padding: var(--space-6);
    color: var(--ink-900);
}
.form-section-title {
    font-size: 14px; line-height: 20px; font-weight: 800; color: var(--ink-900);
    margin-bottom: var(--space-5); padding-bottom: var(--space-3-5);
    border-bottom: 1px solid var(--border-glass-subtle);
    display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap;
}
.form-group { margin-bottom: var(--space-4); }
.form-label {
    display: block; margin-bottom: var(--space-1-5);
    font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;
    color: var(--ink-700);
}
.form-label .req { color: var(--danger); }
.form-control, .form-select {
    display: block; width: 100%;
    padding: var(--space-2-5) var(--space-3-5);
    border-radius: var(--radius-md);
    background-color: var(--glass-card);
    backdrop-filter: blur(var(--blur-subtle)); -webkit-backdrop-filter: blur(var(--blur-subtle));
    border: 1.5px solid var(--border-glass-glow);
    font-family: inherit; font-size: 12px; line-height: 16px; font-weight: 600; color: var(--ink-900);
    outline: none; transition: background-color .15s, border-color .15s, box-shadow .15s;
}
.form-control::placeholder { color: var(--ink-500); font-weight: 500; }
.form-control:hover, .form-select:hover { background-color: rgba(255,255,255,0.85); }
.form-control:focus, .form-select:focus {
    background-color: var(--glass-solid); border-color: var(--focus-ring); box-shadow: var(--shadow-focus); outline: none;
}
/* Input file — tombol pilih file bergaya ds-btn--primary */
.form-control[type="file"] { padding: var(--space-1-5); cursor: pointer; color: var(--ink-600); font-weight: 500; }
.form-control[type="file"]::file-selector-button {
    margin: 0 var(--space-3) 0 0; padding: var(--space-2) var(--space-4);
    border: 1px solid transparent; border-radius: var(--radius-sm);
    background: var(--accent); color: var(--ink-on-dark);
    box-shadow: var(--shadow-glass-sm);
    font-family: inherit; font-size: 12px; line-height: 16px; font-weight: 700;
    cursor: pointer; transition: background-color .15s, transform .1s;
}
.form-control[type="file"]:hover:not(:disabled):not([readonly])::file-selector-button { background: var(--accent-hover); }
.form-control[type="file"]:active::file-selector-button { transform: scale(.97); }
.form-help { display: block; margin-top: var(--space-1-5); font-size: 11px; line-height: 14px; color: var(--ink-600); }

/* Subcategory Pill Selectors — ds-btn--pill */
.subcat-pills { display: flex; gap: var(--space-2); flex-wrap: wrap; margin-bottom: var(--space-1); }
.subcat-pill {
    display: inline-flex; align-items: center; gap: var(--space-1-5);
    padding: var(--space-2) var(--space-4); border-radius: var(--radius-pill);
    background: var(--glass-card); border: 1px solid var(--border-glass-glow);
    backdrop-filter: blur(var(--blur-subtle)); -webkit-backdrop-filter: blur(var(--blur-subtle));
    box-shadow: var(--shadow-glass-sm);
    font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); cursor: pointer;
    transition: background-color .15s, color .15s, transform .1s, box-shadow .15s;
}
.subcat-pill:hover { background: var(--glass-solid); color: var(--ink-900); }
.subcat-pill:active { transform: scale(.97); }
.subcat-pill:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
.subcat-pill.active { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); }

/* Status awal — komponen ds-alert--danger; di sini hanya layout */
.status-awal-box { align-items: center; flex-wrap: wrap; margin: var(--space-5) 0 var(--space-6); }
.status-awal-box__body { flex: 1; min-width: 180px; }
.status-awal-box__title { font-weight: 800; }
.status-awal-box__desc { font-size: 11px; font-weight: 500; color: var(--ink-600); margin-top: 2px; }

/* Submit — ds-btn--primary ukuran penuh */
.btn-submit-log {
    display: flex; align-items: center; justify-content: center; gap: var(--space-2); width: 100%;
    padding: var(--space-3-5) var(--space-6);
    border-radius: var(--radius-md);
    background: var(--accent); border: 1px solid transparent; color: var(--ink-on-dark);
    box-shadow: var(--shadow-glass-sm);
    font-family: inherit; font-size: 13px; line-height: 16px; font-weight: 800; letter-spacing: 0.03em;
    cursor: pointer; transition: background-color .15s, transform .1s, box-shadow .15s;
}
.btn-submit-log:hover { background: var(--accent-hover); box-shadow: var(--shadow-glass); }
.btn-submit-log:active { transform: scale(.98); }
.btn-submit-log:focus-visible { outline: none; box-shadow: var(--shadow-focus); }

@media (max-width: 768px) {
    .category-grid { grid-template-columns: 1fr; }
}
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Top Notification --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-check-circle fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-triangle-exclamation fs-5 me-2"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Header Banner --}}
        {{-- Header Banner — sama dengan header tab poin --}}
        <div class="greeting-banner rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 sm:p-8 text-white mb-4 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="relative z-10 max-w-xl">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-0">Izin Keluar &amp; Kembali Mandiri</h1>
                <p class="text-xs sm:text-sm text-sky-100/80 leading-relaxed mt-1.5">Catat sendiri keberangkatan &amp; kepulangan Anda. Data langsung tersimpan dan akan diperiksa (divalidasi) oleh pengasuh.</p>
            </div>

            {{-- Kartu nama taruna — sama dengan header tab poin --}}
            <div class="relative z-10 flex-shrink-0 flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3 sm:px-5 sm:py-3.5 shadow-inner">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black text-lg shadow-md">
                    {{ strtoupper(substr($identitas['nama'], 0, 1)) }}
                </div>
                <div>
                    <div class="text-xs font-bold text-white max-w-[140px] truncate">{{ $identitas['nama'] }}</div>
                    <div class="text-[10px] font-semibold text-amber-300">Taruna</div>
                    <div class="text-[9px] text-slate-300 font-mono mt-0.5">NIT: {{ $identitas['npm'] ?? '-' }}</div>
                </div>
            </div>

            <div class="absolute -right-16 -top-16 w-56 h-56 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute right-32 -bottom-20 w-48 h-48 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        @if($activeLog)
        {{-- ======================================================== --}}
        {{-- SEDANG IZIN KELUAR: TAMPILKAN STATUS + TOMBOL KEMBALI --}}
        {{-- ======================================================== --}}
        <div class="ds-card status-active-card mb-4">
            <div class="ds-card__head">
                <div>
                    <h2 class="ds-card__title"><i class="fas fa-person-walking-arrow-right ds-icon"></i> Anda sedang di luar asrama</h2>
                    <p class="ds-card__desc">Tandai kembali setelah Anda tiba di asrama agar izin ditutup.</p>
                </div>
                @if($activeLog->is_validated)
                <span class="ds-badge ds-badge--success"><i class="fas fa-user-check"></i> Sudah divalidasi pengasuh</span>
                @else
                <span class="ds-badge ds-badge--warning"><i class="fas fa-hourglass-half"></i> Menunggu validasi pengasuh</span>
                @endif
            </div>

            <div class="active-detail-list">
            <div class="active-detail-row">
                <span class="lbl">Kategori</span>
                <span class="val">{!! $activeLog->getKategoriBadgeHtml() !!} &middot; {{ $activeLog->subkategori }}</span>
            </div>
            <div class="active-detail-row">
                <span class="lbl">Waktu Berangkat</span>
                <span class="val">{{ $activeLog->waktu_berangkat->format('d/m/Y H:i') }} <span class="ds-mono">({{ $activeLog->getDurasiFormatted() }} lalu)</span></span>
            </div>
            @if($activeLog->kategori === 'perizinan')
            <div class="active-detail-row">
                <span class="lbl">Keterangan</span>
                <span class="val">{{ Str::limit($activeLog->keterangan_keluhan, 60) }}</span>
            </div>
            @elseif($activeLog->kategori === 'ekstrakurikuler')
            <div class="active-detail-row">
                <span class="lbl">Ekskul</span>
                <span class="val">{{ $activeLog->nama_ekskul }} ({{ $activeLog->jumlah_anggota }} orang)</span>
            </div>
            @else
            <div class="active-detail-row">
                <span class="lbl">Rute</span>
                <span class="val">{{ $activeLog->rute }}</span>
            </div>
            @endif
            </div>

            <form action="{{ route('log-pergerakan.kembali', $activeLog->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Konfirmasi bahwa Anda SUDAH KEMBALI ke asrama?')">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label class="form-label">Catatan Kepulangan (Opsional)</label>
                    <textarea class="form-control" name="catatan_kembali" rows="2" placeholder="Contoh: Sudah selesai kontrol kesehatan di klinik..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Bukti Kembali (Opsional)</label>
                    <input type="file" class="form-control" name="foto_kembali" accept="image/*">
                </div>
                <button type="submit" class="btn-kembali-mandiri">
                    <i class="fas fa-house-circle-check"></i> SAYA SUDAH KEMBALI KE ASRAMA
                </button>
            </form>
        </div>

        @else
        {{-- ======================================================== --}}
        {{-- BELUM ADA IZIN AKTIF: TAMPILKAN FORM PENGAJUAN KELUAR --}}
        {{-- ======================================================== --}}

        <div class="ds-card mb-4">
            <div class="ds-card__head">
                <h2 class="ds-card__title"><i class="fa-solid fa-code-branch ds-icon"></i> Pilih Kategori Izin Keluar</h2>
                <p class="ds-card__desc">Pilih salah satu kategori sesuai tujuan Anda keluar asrama, lalu lengkapi formulir di bawah.</p>
            </div>

        <div class="category-grid">
            <div class="cat-card cat-1 active" id="cardKatPerizinan" onclick="selectCategory('perizinan')">
                <div class="cat-icon-wrapper"><i class="fas fa-notes-medical"></i></div>
                <div class="cat-num">Cabang 1</div>
                <div class="cat-name">1. Perizinan</div>
                <div class="cat-desc">Kesehatan, Berduka, Keperluan Keluarga / Dinas Luar</div>
            </div>

            <div class="cat-card cat-2" id="cardKatEkskul" onclick="selectCategory('ekstrakurikuler')">
                <div class="cat-icon-wrapper"><i class="fas fa-cogs"></i></div>
                <div class="cat-num">Cabang 2</div>
                <div class="cat-name">2. Ekstrakurikuler</div>
                <div class="cat-desc">Kegiatan Ekskul Wajib, Olahraga, Seni, atau Akademik</div>
            </div>

            <div class="cat-card cat-3" id="cardKatOlahraga" onclick="selectCategory('olahraga')">
                <div class="cat-icon-wrapper"><i class="fas fa-running"></i></div>
                <div class="cat-num">Cabang 3</div>
                <div class="cat-name">3. Olahraga</div>
                <div class="cat-desc">Lari Luar Kampus, Gym, Olahraga Mandiri atau Terpimpin</div>
            </div>
        </div>
        </div>

        <div class="form-card">
            <form action="{{ route('log-pergerakan.store') }}" method="POST" enctype="multipart/form-data" id="formLogMandiri">
                @csrf
                <input type="hidden" name="kategori" id="inputKategori" value="perizinan">
                <input type="hidden" name="subkategori" id="inputSubkategori" value="Kesehatan">

                <div class="form-section-title">
                    <span id="formTitleText"><i class="fas fa-notes-medical text-danger me-2"></i> Isi Form Izin & Dokumentasi</span>
                    <span class="ds-badge ds-badge--accent">
                        <i class="far fa-clock"></i> Waktu: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="form-group">
                    <label class="form-label">Sub-Kategori <span class="req">*</span></label>

                    <div class="subcat-pills" id="subcatPerizinan">
                        <button type="button" class="subcat-pill active" onclick="setSubcat('Kesehatan', this)"><i class="fas fa-heartbeat me-1"></i> Kesehatan</button>
                        <button type="button" class="subcat-pill" onclick="setSubcat('Berduka', this)"><i class="fas fa-hands-praying me-1"></i> Berduka</button>
                        <button type="button" class="subcat-pill" onclick="setSubcat('Lainnya', this)"><i class="fas fa-ellipsis-h me-1"></i> Lainnya</button>
                    </div>

                    <div class="subcat-pills d-none" id="subcatEkskul">
                        <button type="button" class="subcat-pill" onclick="setSubcat('Wajib', this)"><i class="fas fa-award me-1"></i> Wajib</button>
                        <button type="button" class="subcat-pill" onclick="setSubcat('Olahraga', this)"><i class="fas fa-futbol me-1"></i> Olahraga</button>
                        <button type="button" class="subcat-pill" onclick="setSubcat('Seni', this)"><i class="fas fa-palette me-1"></i> Seni</button>
                        <button type="button" class="subcat-pill" onclick="setSubcat('Akademik', this)"><i class="fas fa-graduation-cap me-1"></i> Akademik</button>
                    </div>

                    <div class="subcat-pills d-none" id="subcatOlahraga">
                        <button type="button" class="subcat-pill" onclick="setSubcat('Mandiri', this)"><i class="fas fa-user me-1"></i> Mandiri</button>
                        <button type="button" class="subcat-pill" onclick="setSubcat('Terpimpin', this)"><i class="fas fa-users me-1"></i> Terpimpin</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label">Tanggal & Jam Keberangkatan <span class="req">*</span></label>
                        <input type="datetime-local" class="form-control" name="waktu_berangkat" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Estimasi Jam Kembali (Opsional)</label>
                        <input type="datetime-local" class="form-control" name="estimasi_kembali" value="{{ \Carbon\Carbon::now()->addHours(2)->format('Y-m-d\TH:i') }}">
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

                <div class="form-group">
                    <label class="form-label">Dokumentasi (Foto Surat Izin / Bukti / Foto Kegiatan)</label>
                    <input type="file" class="form-control" name="foto_keberangkatan" accept="image/*">
                    <small class="form-help"><i class="fas fa-camera"></i> Anda dapat langsung mengambil foto melalui kamera HP atau upload file gambar.</small>
                </div>

                <div class="ds-alert ds-alert--danger status-awal-box">
                    <i class="fas fa-shield-alt ds-icon"></i>
                    <div class="status-awal-box__body">
                        <div class="status-awal-box__title">Status Awal Keluar</div>
                        <div class="status-awal-box__desc">Data akan otomatis ditandai <strong>BELUM KEMBALI</strong>.</div>
                    </div>
                </div>

                <button type="submit" class="btn-submit-log">
                    <i class="fas fa-paper-plane"></i> AJUKAN IZIN KELUAR
                </button>
            </form>
        </div>
        @endif

        {{-- ======================================================== --}}
        {{-- RIWAYAT SINGKAT --}}
        {{-- ======================================================== --}}
        @if($riwayat->isNotEmpty())
        <div class="form-card mt-4">
            <div class="form-section-title">
                <span><i class="fas fa-clock-rotate-left text-secondary me-2"></i> Riwayat Izin Terakhir</span>
            </div>
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kategori</th>
                                <th>Waktu Berangkat</th>
                                <th>Waktu Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $item)
                            <tr>
                                <td class="ds-num">{{ $loop->iteration }}</td>
                                <td>{!! $item->getKategoriBadgeHtml() !!} <span class="ds-mono">{{ $item->subkategori }}</span></td>
                                <td class="ds-name">{{ $item->waktu_berangkat->format('d/m/Y H:i') }}</td>
                                <td>@if($item->waktu_kembali)<span class="ds-name">{{ $item->waktu_kembali->format('d/m/Y H:i') }}</span>@else<span class="ds-mono">Masih di luar</span>@endif</td>
                                <td>
                                    @if($item->isBelumKembali())
                                    <span class="ds-badge ds-badge--danger"><span class="ds-dot ds-dot--pulse" style="background:var(--danger)"></span> Belum Kembali</span>
                                    @else
                                    <span class="ds-badge ds-badge--success"><i class="fas fa-check-circle"></i> Sudah Kembali</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

    </div>
</main>

<script>
    function selectCategory(cat) {
        document.getElementById('inputKategori').value = cat;

        document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active'));

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
            setSubcat('Kesehatan', document.querySelector('#subcatPerizinan .subcat-pill'));
        } else if (cat === 'ekstrakurikuler') {
            document.getElementById('cardKatEkskul').classList.add('active');
            document.getElementById('subcatEkskul').classList.remove('d-none');
            document.getElementById('fieldEkskul').classList.remove('d-none');
            document.getElementById('formTitleText').innerHTML = '<i class="fas fa-cogs text-primary me-2"></i> Isi Form Ekskul & Dokumentasi';
            setSubcat('Wajib', document.querySelector('#subcatEkskul .subcat-pill'));
        } else if (cat === 'olahraga') {
            document.getElementById('cardKatOlahraga').classList.add('active');
            document.getElementById('subcatOlahraga').classList.remove('d-none');
            document.getElementById('fieldOlahraga').classList.remove('d-none');
            document.getElementById('formTitleText').innerHTML = '<i class="fas fa-running text-success me-2"></i> Isi Form Olahraga & Dokumentasi';
            setSubcat('Mandiri', document.querySelector('#subcatOlahraga .subcat-pill'));
        }
    }

    function setSubcat(sub, el) {
        document.getElementById('inputSubkategori').value = sub;
        if (el) {
            const parent = el.closest('.subcat-pills');
            parent.querySelectorAll('.subcat-pill').forEach(p => p.classList.remove('active'));
            el.classList.add('active');
        }
    }
</script>
</x-app-layout>
