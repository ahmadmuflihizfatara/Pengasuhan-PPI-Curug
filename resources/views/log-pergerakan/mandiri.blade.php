<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }

.app-layout { display: block; min-height: 100vh; }
.main-content { padding: 28px 30px; min-width: 0; max-width: 900px; margin: 0 auto; width: 100%; }

/* === HEADER BANNER === */
.tablet-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 18px;
    padding: 24px 30px;
    color: white;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.tablet-banner::after {
    content: ''; position: absolute; right: -40px; top: -40px; width: 180px; height: 180px;
    background: rgba(255,255,255,.08); border-radius: 50%;
}
.banner-title { font-size: 21px; font-weight: 800; margin: 0 0 4px 0; display: flex; align-items: center; gap: 10px; }
.banner-sub { font-size: 13px; opacity: 0.9; margin: 0; position: relative; z-index: 1; }

/* === STATUS AKTIF CARD (SEDANG IZIN KELUAR) === */
.status-active-card {
    background: white;
    border-radius: 18px;
    padding: 26px 28px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    border: 2px solid #fecaca;
}
.status-active-badge {
    background: #dc2626; color: white; padding: 6px 14px; border-radius: 20px;
    font-size: 12px; font-weight: 800; letter-spacing: 0.5px;
    display: inline-flex; align-items: center; gap: 6px; margin-bottom: 14px;
    animation: pulseRed 2s infinite;
}
@keyframes pulseRed {
    0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
    50% { box-shadow: 0 0 0 8px rgba(220, 38, 38, 0); }
}
.active-detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f2f7; font-size: 13.5px; }
.active-detail-row:last-of-type { border-bottom: none; }
.active-detail-row .lbl { color: #888; font-weight: 600; }
.active-detail-row .val { color: #333; font-weight: 700; text-align: right; }

.validasi-pill { display: inline-flex; align-items: center; gap: 6px; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 20px; margin-top: 10px; }
.validasi-pill.pending { background: #fef3c7; color: #92400e; }
.validasi-pill.ok { background: #dcfce7; color: #15803d; }

.btn-kembali-mandiri {
    background: #10b981; color: white; border: none; border-radius: 25px;
    padding: 15px 28px; font-size: 15px; font-weight: 800; width: 100%; cursor: pointer;
    margin-top: 20px; transition: transform 0.2s, box-shadow 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 10px;
}
.btn-kembali-mandiri:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16,185,129,.35); }

/* === IDENTITAS LOCKED BOX === */
.identitas-box {
    background: #f0f4ff; border: 1.5px dashed #a5b0f0; border-radius: 14px;
    padding: 14px 18px; margin-bottom: 22px; display: flex; align-items: center; gap: 14px;
}
.identitas-avatar {
    width: 42px; height: 42px; border-radius: 50%; background: #667eea; color: white;
    display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 16px; flex-shrink: 0;
}
.identitas-name { font-weight: 800; color: #333; font-size: 14.5px; }
.identitas-meta { font-size: 12px; color: #777; font-family: monospace; }

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
    background: #dc2626; color: white; padding: 6px 14px; border-radius: 20px;
    font-size: 12px; font-weight: 800; letter-spacing: 0.5px;
    display: inline-flex; align-items: center; gap: 6px; animation: pulseRed 2s infinite;
}

.btn-submit-log {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white; border: none; border-radius: 25px; padding: 14px 28px;
    font-size: 14px; font-weight: 700; width: 100%; cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 10px;
}
.btn-submit-log:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, .4); }

/* Riwayat */
.riwayat-item {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 16px; border-radius: 12px; background: #fafbff; border: 1px solid #edf0f7; margin-bottom: 8px;
}
.riwayat-item .riwayat-info { font-size: 12.5px; }
.riwayat-item .riwayat-info .cat { font-weight: 700; color: #333; }
.riwayat-item .riwayat-info .waktu { color: #888; }

@media (max-width: 768px) {
    .category-grid { grid-template-columns: 1fr; }
}
</style>

<x-island-navbar />

    <main class="main-content">

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
        <div class="tablet-banner">
            <h1 class="banner-title">
                <i class="fas fa-right-from-bracket"></i> Izin Keluar & Kembali Mandiri
            </h1>
            <p class="banner-sub">
                Catat sendiri keberangkatan &amp; kepulangan Anda. Data langsung tersinkron ke TV Monitoring Pos Jaga, dan akan diperiksa (divalidasi) oleh pengasuh.
            </p>
        </div>

        @if($activeLog)
        {{-- ======================================================== --}}
        {{-- SEDANG IZIN KELUAR: TAMPILKAN STATUS + TOMBOL KEMBALI --}}
        {{-- ======================================================== --}}
        <div class="status-active-card">
            <span class="status-active-badge"><i class="fas fa-dot-circle"></i> ANDA SEDANG DI LUAR ASRAMA</span>

            <div class="active-detail-row">
                <span class="lbl">Kategori</span>
                <span class="val">{!! $activeLog->getKategoriBadgeHtml() !!} {{ $activeLog->subkategori }}</span>
            </div>
            <div class="active-detail-row">
                <span class="lbl">Waktu Berangkat</span>
                <span class="val">{{ $activeLog->waktu_berangkat->format('d/m/Y H:i') }} ({{ $activeLog->getDurasiFormatted() }} lalu)</span>
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

            <div>
                @if($activeLog->is_validated)
                <span class="validasi-pill ok"><i class="fas fa-user-check"></i> Sudah divalidasi pengasuh</span>
                @else
                <span class="validasi-pill pending"><i class="fas fa-hourglass-half"></i> Menunggu validasi pengasuh</span>
                @endif
            </div>

            <form action="{{ route('log-pergerakan.kembali', $activeLog->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Konfirmasi bahwa Anda SUDAH KEMBALI ke asrama?')">
                @csrf
                @method('PATCH')
                <div class="form-group mt-3">
                    <label class="form-label">Catatan Kepulangan (Opsional)</label>
                    <textarea class="form-control" name="catatan_kembali" rows="2" placeholder="Contoh: Sudah selesai kontrol kesehatan di klinik..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Bukti Kembali (Opsional)</label>
                    <input type="file" class="form-control" name="foto_kembali" accept="image/*">
                </div>
                <button type="submit" class="btn-kembali-mandiri">
                    <i class="fas fa-check-circle"></i> SAYA SUDAH KEMBALI KE ASRAMA
                </button>
            </form>
        </div>

        @else
        {{-- ======================================================== --}}
        {{-- BELUM ADA IZIN AKTIF: TAMPILKAN FORM PENGAJUAN KELUAR --}}
        {{-- ======================================================== --}}

        <div class="identitas-box">
            <div class="identitas-avatar">{{ strtoupper(substr($identitas['nama'], 0, 1)) }}</div>
            <div>
                <div class="identitas-name">{{ $identitas['nama'] }}</div>
                <div class="identitas-meta">{{ $identitas['npm'] ?? 'NPM -' }} &bull; {{ $identitas['prodi'] ?? 'Prodi -' }}</div>
            </div>
        </div>

        <div class="category-selection-title">
            <i class="fas fa-code-branch text-primary"></i> PILIH KATEGORI IZIN KELUAR:
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

        <div class="form-card">
            <form action="{{ route('log-pergerakan.store') }}" method="POST" enctype="multipart/form-data" id="formLogMandiri">
                @csrf
                <input type="hidden" name="kategori" id="inputKategori" value="perizinan">
                <input type="hidden" name="subkategori" id="inputSubkategori" value="Kesehatan">

                <div class="form-section-title">
                    <span id="formTitleText"><i class="fas fa-notes-medical text-danger me-2"></i> Isi Form Izin & Dokumentasi</span>
                    <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">
                        <i class="far fa-clock me-1"></i> Waktu: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
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
                    <small class="text-muted"><i class="fas fa-camera"></i> Anda dapat langsung mengambil foto melalui kamera HP atau upload file gambar.</small>
                </div>

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

                <button type="submit" class="btn-submit-log">
                    <i class="fas fa-save fs-5"></i> AJUKAN IZIN KELUAR
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
            @foreach($riwayat as $item)
            <div class="riwayat-item">
                <div class="riwayat-info">
                    <div class="cat">{!! $item->getKategoriBadgeHtml() !!} {{ $item->subkategori }}</div>
                    <div class="waktu">{{ $item->waktu_berangkat->format('d/m/Y H:i') }} &rarr; {{ $item->waktu_kembali ? $item->waktu_kembali->format('d/m/Y H:i') : 'Masih di luar' }}</div>
                </div>
                <div>{!! $item->getStatusBadgeHtml() !!}</div>
            </div>
            @endforeach
        </div>
        @endif

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
