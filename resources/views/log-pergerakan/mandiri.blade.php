<x-app-layout>
<x-form-glass-style />
@include('log-pergerakan._kategori-style')
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
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">



        
        {{-- Header Banner — sama dengan header tab poin --}}
        <x-page-banner title="Izin Keluar & Kembali Mandiri" icon="fa-person-walking"
            subtitle="Catat sendiri keberangkatan & kepulangan Anda. Data langsung tersimpan dan akan diperiksa (divalidasi) oleh pengasuh." />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Izin keluar belum terkirim">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

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
                <span class="val">{!! $activeLog->getKategoriBadgeHtml() !!} &middot; {{ $activeLog->subkategori_label }} <x-badge-urgensi :log="$activeLog" /></span>
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
                <div class="cat-desc">Izin Keluar Khusus, Unit Kesehatan, Izin Terstruktur, Berduka, Lainnya</div>
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
                <input type="hidden" name="subkategori" id="inputSubkategori" value="{{ array_key_first(\App\Models\LogPergerakan::SUBKAT_PERIZINAN) }}">

                <div class="form-section-title">
                    <span id="formTitleText"><i class="fas fa-notes-medical text-danger me-2"></i> Isi Form Izin & Dokumentasi</span>
                    <span class="ds-badge ds-badge--accent">
                        <i class="far fa-clock"></i> Waktu: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="form-group">
                    <label class="form-label">Sub-Kategori <span class="req">*</span></label>

                    @include('log-pergerakan._jenis-izin')

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
                        <input type="datetime-local" class="form-control" name="waktu_berangkat" value="{{ old('waktu_berangkat', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label">Estimasi Jam Kembali (Opsional)</label>
                        <input type="datetime-local" class="form-control" name="estimasi_kembali" value="{{ old('estimasi_kembali', \Carbon\Carbon::now()->addHours(2)->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>

                {{-- ================= FIELD KHUSUS CABANG 1: PERIZINAN ================= --}}
                <div id="fieldPerizinan">
                    <div class="form-group">
                        <label class="form-label" id="labelKeterangan" for="inputKeterangan">Keterangan / Keluhan <span class="req">*</span></label>
                        <textarea class="form-control" name="keterangan_keluhan" id="inputKeterangan" rows="3" placeholder="Jelaskan alasan izin / keluhan kesehatan / tujuan izin keluar...">{{ old('keterangan_keluhan') }}</textarea>
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

                <div class="form-group" id="fieldDokumentasi">
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
                                <td>{!! $item->getKategoriBadgeHtml() !!} <span class="ds-mono">{{ $item->subkategori_label }}</span> <x-badge-urgensi :log="$item" /></td>
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
            const pertama = document.querySelector('#subcatPerizinan .subcat-pill');
            setSubcat(pertama.dataset.sub, pertama);
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
        terapkanJenisIzin(sub);
        if (el) {
            const parent = el.closest('.subcat-pills');
            parent.querySelectorAll('.subcat-pill').forEach(p => p.classList.remove('active'));
            el.classList.add('active');
        }
    }

    // Setelah gagal validasi: pulihkan cabang & jenis izin yang tadi dipilih
    @if(old('kategori'))
    document.addEventListener('DOMContentLoaded', function () {
        selectCategory(@js(old('kategori')));
        const sub = @js(old('subkategori'));
        const pil = [...document.querySelectorAll('.subcat-pills:not(.d-none) .subcat-pill')]
            .find(p => (p.dataset.sub || p.textContent.trim()) === sub);
        if (pil) setSubcat(sub, pil);
    });
    @endif
</script>
</x-app-layout>
