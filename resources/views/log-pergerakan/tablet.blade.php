<x-app-layout>
<x-form-glass-style />
@include('log-pergerakan._kategori-style')
<style>
    .tb-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .tb-kembali:hover { color: var(--accent-ink); }

    /* Pemilih mode — pola tab riwayat poin */
    .tb-mode { display: flex; gap: var(--space-1); padding: var(--space-1); border-radius: var(--radius-lg); background: var(--glass-subtle); border: 1px solid var(--border-glass); }
    .tb-mode__btn {
        flex: 1; display: flex; align-items: center; justify-content: center; gap: var(--space-2-5);
        padding: var(--space-3) var(--space-4); border: 1px solid transparent; border-radius: var(--radius-md); background: transparent;
        font-family: inherit; font-size: 14px; line-height: 20px; font-weight: 800; color: var(--ink-600); cursor: pointer;
        transition: background-color .15s, color .15s, box-shadow .15s;
    }
    .tb-mode__btn:hover { background: var(--glass-card); color: var(--ink-900); }
    .tb-mode__btn:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .tb-mode__btn.active { background: var(--glass-solid); border-color: var(--border-glass-glow); color: var(--ink-900); box-shadow: var(--shadow-glass-sm); }
    .tb-mode__btn.active > i { color: var(--accent); }
    .tb-mode__btn small { font-size: 11px; font-weight: 600; color: var(--ink-600); }
    @media (max-width: 640px) { .tb-mode__btn { flex-direction: column; gap: var(--space-1); font-size: 13px; } .tb-mode__btn small { display: none; } }

    /* Kepulangan */
    .tb-cari { position: relative; margin-bottom: var(--space-4); }
    .tb-cari i { position: absolute; left: var(--space-3-5); top: 50%; transform: translateY(-50%); font-size: 14px; color: var(--ink-500); pointer-events: none; }
    .tb-cari .form-control { padding: var(--space-3) var(--space-4) var(--space-3) 40px; font-size: 14px; line-height: 20px; }
    .tb-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-3-5); }
    @media (max-width: 900px) { .tb-grid { grid-template-columns: 1fr; } }
    .tb-kartu { display: flex; flex-direction: column; gap: var(--space-3); padding: var(--space-4); border-radius: var(--radius-lg); background: var(--glass-card); border: 1px solid var(--border-glass-glow); transition: background-color .15s, box-shadow .15s; }
    .tb-kartu:hover { background: var(--glass-solid); box-shadow: var(--shadow-glass-sm); }
    .tb-kartu__atas { display: flex; align-items: flex-start; justify-content: space-between; gap: var(--space-3); }
    .tb-kartu__nama { font-size: 15px; line-height: 20px; font-weight: 900; color: var(--ink-900); }
    .tb-kartu__meta { margin-top: 2px; font-size: 11px; line-height: 16px; font-weight: 600; color: var(--ink-600); }
    .tb-kartu__kat { display: flex; flex-wrap: wrap; gap: var(--space-1-5); }
    .tb-rinci { display: flex; flex-direction: column; gap: var(--space-1-5); padding: var(--space-2-5) var(--space-3); border-radius: var(--radius-md); background: var(--glass-subtle); border: 1px solid var(--border-glass-subtle); font-size: 12px; line-height: 17px; font-weight: 500; color: var(--ink-700); }
    .tb-rinci i { width: 14px; margin-right: var(--space-1-5); color: var(--ink-500); text-align: center; }
    .tb-rinci strong { color: var(--ink-900); }
    .tb-durasi { font-family: var(--font-mono); font-weight: 800; color: var(--danger-ink); }
    .tb-keluar { display: inline-flex; align-items: center; gap: var(--space-1-5); flex-shrink: 0; }
    .tb-keluar::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--danger); animation: tb-kedip 1.2s infinite; }
    @keyframes tb-kedip { 50% { opacity: .3; } }
    .tb-kartu form { margin: 0; margin-top: auto; }
    .tb-btn-kembali { width: 100%; justify-content: center; padding-top: var(--space-2-5); padding-bottom: var(--space-2-5); font-weight: 800; background: var(--success); color: var(--ink-on-dark); border-color: transparent; }
    .tb-btn-kembali:hover { background: var(--success-ink); color: var(--ink-on-dark); }
</style>

<x-island-navbar />

@php $mode = request('mode') === 'kepulangan' ? 'kepulangan' : 'keberangkatan'; @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Mode Tablet Pos Jaga" icon="fa-tablet-screen-button"
            subtitle="Catat keberangkatan & kepulangan taruna langsung di gerbang — tersimpan real-time ke log pergerakan" />

        <a href="{{ route('log-pergerakan.index') }}" class="ds-btn ds-btn--pill tb-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Log Pergerakan
        </a>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Data keberangkatan belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-4">
            <x-stat-card title="Di Luar Asrama" :value="$stats['belum_kembali']" icon="fa-solid fa-person-walking-arrow-right"
                varian="danger" badge="Belum kembali" badgeType="danger" description="Menunggu konfirmasi kepulangan" />
            <x-stat-card title="Kembali Hari Ini" :value="$stats['sudah_kembali']" icon="fa-solid fa-house-circle-check"
                varian="success" badge="Selesai" badgeType="success" description="Berangkat & kembali hari ini" />
            <x-stat-card title="Total Log Hari Ini" :value="$stats['total_today']" icon="fa-solid fa-clipboard-list"
                varian="accent" badge="Hari ini" badgeType="accent" :href="route('log-pergerakan.index')" description="Seluruh keberangkatan hari ini" />
        </div>

        {{-- Pemilih mode --}}
        <div class="tb-mode mb-4" role="tablist" aria-label="Mode pencatatan">
            <button type="button" role="tab" class="tb-mode__btn {{ $mode === 'keberangkatan' ? 'active' : '' }}" id="tabBtnKeberangkatan"
                    aria-selected="{{ $mode === 'keberangkatan' ? 'true' : 'false' }}" onclick="switchMode('keberangkatan')">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Catat Keberangkatan <small>· status awal</small></span>
            </button>
            <button type="button" role="tab" class="tb-mode__btn {{ $mode === 'kepulangan' ? 'active' : '' }}" id="tabBtnKepulangan"
                    aria-selected="{{ $mode === 'kepulangan' ? 'true' : 'false' }}" onclick="switchMode('kepulangan')">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Konfirmasi Kepulangan <small>· status akhir</small></span>
                @if($stats['belum_kembali'] > 0)<span class="ds-badge ds-badge--danger">{{ $stats['belum_kembali'] }}</span>@endif
            </button>
        </div>

        {{-- ======================================================== --}}
        {{-- MODE 1: KEBERANGKATAN (START -> 3 CABANG -> BERANGKAT)   --}}
        {{-- ======================================================== --}}
        <div id="sectionKeberangkatan" @if($mode !== 'keberangkatan') class="d-none" @endif>
            <div class="ds-card mb-4">
                <div class="ds-card__head">
                    <h2 class="ds-card__title"><i class="fa-solid fa-code-branch ds-icon"></i> Pilih Kategori Pergerakan</h2>
                    <p class="ds-card__desc">Pilih salah satu dari 3 cabang sesuai tujuan taruna keluar asrama, lalu lengkapi formulir di bawah.</p>
                </div>
                <div class="category-grid">
                    <div class="cat-card cat-1 active" id="cardKatPerizinan" role="button" tabindex="0" onclick="selectCategory('perizinan')" onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.click(); }">
                        <div class="cat-icon-wrapper"><i class="fa-solid fa-notes-medical"></i></div>
                        <div class="cat-num">Cabang 1</div>
                        <div class="cat-name">1. Perizinan</div>
                        <div class="cat-desc">Izin Keluar Khusus, Unit Kesehatan, Izin Terstruktur, Berduka, Lainnya</div>
                    </div>
                    <div class="cat-card cat-2" id="cardKatEkskul" role="button" tabindex="0" onclick="selectCategory('ekstrakurikuler')" onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.click(); }">
                        <div class="cat-icon-wrapper"><i class="fa-solid fa-people-group"></i></div>
                        <div class="cat-num">Cabang 2</div>
                        <div class="cat-name">2. Ekstrakurikuler</div>
                        <div class="cat-desc">Kegiatan Ekskul Wajib, Olahraga, Seni, atau Akademik</div>
                    </div>
                    <div class="cat-card cat-3" id="cardKatOlahraga" role="button" tabindex="0" onclick="selectCategory('olahraga')" onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.click(); }">
                        <div class="cat-icon-wrapper"><i class="fa-solid fa-person-running"></i></div>
                        <div class="cat-num">Cabang 3</div>
                        <div class="cat-name">3. Olahraga</div>
                        <div class="cat-desc">Lari Luar Kampus, Gym, Olahraga Mandiri atau Terpimpin</div>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <form action="{{ route('log-pergerakan.store') }}" method="POST" enctype="multipart/form-data" id="formLogPergerakan">
                    @csrf
                    <input type="hidden" name="kategori" id="inputKategori" value="perizinan">
                    <input type="hidden" name="subkategori" id="inputSubkategori" value="{{ array_key_first(\App\Models\LogPergerakan::SUBKAT_PERIZINAN) }}">

                    <div class="form-section-title">
                        <span id="formTitleText"><i class="fa-solid fa-notes-medical me-2" style="color:var(--danger)"></i> Isi Form Izin &amp; Dokumentasi</span>
                        <span class="ds-badge ds-badge--accent"><i class="fa-regular fa-clock"></i> Waktu: {{ now()->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="form-group">
                        <span class="form-label">Sub-Kategori <span class="req">*</span></span>
                        @include('log-pergerakan._jenis-izin')
                        <div class="subcat-pills d-none" id="subcatEkskul">
                            <button type="button" class="subcat-pill" onclick="setSubcat('Wajib', this)"><i class="fa-solid fa-award"></i> Wajib</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Olahraga', this)"><i class="fa-solid fa-futbol"></i> Olahraga</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Seni', this)"><i class="fa-solid fa-palette"></i> Seni</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Akademik', this)"><i class="fa-solid fa-graduation-cap"></i> Akademik</button>
                        </div>
                        <div class="subcat-pills d-none" id="subcatOlahraga">
                            <button type="button" class="subcat-pill" onclick="setSubcat('Mandiri', this)"><i class="fa-solid fa-user"></i> Mandiri</button>
                            <button type="button" class="subcat-pill" onclick="setSubcat('Terpimpin', this)"><i class="fa-solid fa-users"></i> Terpimpin</button>
                        </div>
                    </div>

                    {{-- Identitas — admin mengisi untuk taruna mana pun; NPM & kelas terisi otomatis dari daftar --}}
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label" for="inputNama" id="labelNama">Nama Taruna <span class="req">*</span></label>
                            <input type="text" class="form-control" name="nama" id="inputNama" list="mhsList" value="{{ old('nama') }}" placeholder="Ketik atau pilih nama taruna..." required autocomplete="off">
                            <datalist id="mhsList">
                                @foreach($mahasiswas as $mhs)
                                <option value="{{ $mhs->nama }}" data-npm="{{ $mhs->npm }}" data-kelas="{{ $mhs->kelas }}">{{ $mhs->npm }} · {{ $mhs->kelas }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <label class="form-label" for="inputNpm">NPM</label>
                            <input type="text" class="form-control" name="npm" id="inputNpm" value="{{ old('npm') }}" placeholder="Otomatis">
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <label class="form-label" for="inputProdi">Prodi / Kelas</label>
                            <input type="text" class="form-control" name="prodi" id="inputProdi" value="{{ old('prodi') }}" placeholder="Otomatis">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label" for="inputBerangkat">Tanggal &amp; Jam Keberangkatan <span class="req">*</span></label>
                            <input type="datetime-local" class="form-control" id="inputBerangkat" name="waktu_berangkat" value="{{ old('waktu_berangkat', now()->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label" for="inputEstimasi">Estimasi Jam Kembali <span style="color:var(--ink-500); text-transform:none; letter-spacing:0">(opsional)</span></label>
                            <input type="datetime-local" class="form-control" id="inputEstimasi" name="estimasi_kembali" value="{{ old('estimasi_kembali', now()->addHours(2)->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>

                    {{-- Cabang 1: Perizinan --}}
                    <div id="fieldPerizinan">
                        <div class="form-group">
                            <label class="form-label" id="labelKeterangan" for="inputKeterangan">Keterangan / Keluhan <span class="req">*</span></label>
                            <textarea class="form-control" name="keterangan_keluhan" id="inputKeterangan" rows="3" placeholder="Jelaskan alasan izin / keluhan kesehatan / tujuan izin keluar...">{{ old('keterangan_keluhan') }}</textarea>
                        </div>
                    </div>

                    {{-- Cabang 2: Ekstrakurikuler --}}
                    <div id="fieldEkskul" class="d-none">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="selectEkskul">Jenis Ekskul <span class="req">*</span></label>
                                <select class="form-select" name="nama_ekskul" id="selectEkskul">
                                    <option value="">-- Pilih Jenis Ekskul --</option>
                                    @foreach(['Marching Band', 'Band Musik', 'Paduan Suara', 'Tari Tradisional & Modern', 'Futsal / Sepakbola', 'Bola Basket', 'Bola Voli', 'Badminton', 'Bela Diri (Karate / Silat / Taekwondo)', 'Robotika & Aeromodelling', 'English Debate Club', 'Pramuka / Menwa', 'Rohis / Pelayanan Rohani', 'Lainnya'] as $ekskul)
                                    <option value="{{ $ekskul }}" @selected(old('nama_ekskul') === $ekskul)>{{ $ekskul }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="inputJumlahAnggota">Jumlah Anggota Ikut <span class="req">*</span></label>
                                <input type="number" class="form-control" name="jumlah_anggota" id="inputJumlahAnggota" value="{{ old('jumlah_anggota', 1) }}" min="1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="inputLokasi">Lokasi Kegiatan <span class="req">*</span></label>
                                <input type="text" class="form-control" name="lokasi_kegiatan" id="inputLokasi" value="{{ old('lokasi_kegiatan') }}" placeholder="Contoh: GOR Tangerang, Kampus Utama, Lapangan Terbang">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="inputAnggota">Daftar Nama Anggota <span style="color:var(--ink-500); text-transform:none; letter-spacing:0">(opsional)</span></label>
                                <input type="text" class="form-control" name="daftar_anggota" id="inputAnggota" value="{{ old('daftar_anggota') }}" placeholder="Contoh: Fatih, Muflih, Joke, Jiro...">
                            </div>
                        </div>
                    </div>

                    {{-- Cabang 3: Olahraga --}}
                    <div id="fieldOlahraga" class="d-none">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="inputRute">Rute / Lokasi Olahraga <span class="req">*</span></label>
                                <input type="text" class="form-control" name="rute" id="inputRute" value="{{ old('rute') }}" placeholder="Contoh: Rute lari luar kampus Curug, Jogging track, Gym">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="inputPengikut">Pengikut / Teman Olahraga</label>
                                <input type="text" class="form-control" name="pengikut" id="inputPengikut" value="{{ old('pengikut') }}" placeholder="Contoh: 3 orang (Fatih, Joke, Edya)">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="fieldDokumentasi">
                        <label class="form-label" for="inputFoto">Dokumentasi (Foto Surat Izin / Bukti / Foto Kegiatan)</label>
                        <input type="file" class="form-control" id="inputFoto" name="foto_keberangkatan" accept="image/*" capture="environment">
                        <small class="form-help"><i class="fa-solid fa-camera"></i> Ambil foto langsung dari kamera tablet atau unggah file gambar · maks. 5MB.</small>
                    </div>

                    <div class="ds-alert ds-alert--danger status-awal-box">
                        <i class="fa-solid fa-shield-halved ds-icon"></i>
                        <div class="status-awal-box__body">
                            <div class="status-awal-box__title">Status Awal Keluar</div>
                            <div class="status-awal-box__desc">Data otomatis ditandai <strong>BELUM KEMBALI</strong> sampai kepulangan dikonfirmasi.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit-log"><i class="fa-solid fa-floppy-disk"></i> SIMPAN DATA KEBERANGKATAN</button>
                </form>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- MODE 2: KEPULANGAN (STATUS AKHIR)                        --}}
        {{-- ======================================================== --}}
        <div id="sectionKepulangan" @if($mode !== 'kepulangan') class="d-none" @endif>
            <div class="ds-card">
                <div class="ds-card__head tbl-head">
                    <div>
                        <h2 class="ds-card__title"><i class="fa-solid fa-user-check ds-icon"></i> Konfirmasi Kepulangan Taruna</h2>
                        <p class="ds-card__desc">Cari taruna yang masih di luar asrama, lalu ubah status akhirnya menjadi kembali</p>
                    </div>
                    <span class="ds-badge ds-badge--danger">{{ $belumKembali->count() }} di luar</span>
                </div>

                @if($belumKembali->isEmpty())
                <div class="ds-empty">
                    <i class="fa-solid fa-clipboard-check ds-icon"></i>
                    Semua taruna sudah kembali — tidak ada yang berada di luar asrama saat ini.
                </div>
                @else
                <div class="tb-cari">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="inputSearchReturn" class="form-control" placeholder="Cari nama taruna / NPM / ekskul / rute..." oninput="filterReturnList()" aria-label="Cari taruna di luar asrama">
                </div>

                <div class="tb-grid" id="returnGridContainer">
                    @foreach($belumKembali as $item)
                    @php [$katLabel, $katIkon, $katVarian] = $item->kategoriMeta(); @endphp
                    <div class="tb-kartu return-item-card"
                         data-search="{{ strtolower($item->nama . ' ' . $item->npm . ' ' . $item->kategori . ' ' . $item->subkategori . ' ' . $item->nama_ekskul . ' ' . $item->rute . ' ' . $item->keterangan_keluhan) }}">
                        <div class="tb-kartu__atas">
                            <div>
                                <div class="tb-kartu__nama">{{ $item->nama }}</div>
                                <div class="tb-kartu__meta">{{ $item->npm ?: 'NPM —' }} · {{ $item->prodi ?: 'Prodi —' }}</div>
                            </div>
                            <span class="ds-badge ds-badge--danger tb-keluar">Belum kembali</span>
                        </div>

                        <div class="tb-kartu__kat">
                            <span class="ds-badge ds-badge--{{ $katVarian }}"><i class="fa-solid {{ $katIkon }}"></i> {{ $katLabel }}</span>
                            <span class="ds-badge">{{ $item->subkategori_label }}</span>
                            <x-badge-urgensi :log="$item" />
                        </div>

                        <div class="tb-rinci">
                            <div><i class="fa-regular fa-clock"></i>Berangkat <strong>{{ $item->waktu_berangkat?->format('d/m/Y H:i') ?? '—' }}</strong> · <span class="tb-durasi">{{ $item->getDurasiFormatted() }} lalu</span></div>
                            @if($item->kategori === 'perizinan' && $item->keterangan_keluhan)
                            <div><i class="fa-solid fa-circle-info"></i>{{ Str::limit($item->keterangan_keluhan, 80) }}</div>
                            @elseif($item->kategori === 'ekstrakurikuler')
                            <div><i class="fa-solid fa-people-group"></i><strong>{{ $item->nama_ekskul }}</strong> · {{ $item->jumlah_anggota }} orang</div>
                            @if($item->lokasi_kegiatan)<div><i class="fa-solid fa-location-dot"></i>{{ $item->lokasi_kegiatan }}</div>@endif
                            @elseif($item->kategori === 'olahraga')
                            <div><i class="fa-solid fa-route"></i><strong>{{ $item->rute }}</strong></div>
                            @if($item->pengikut)<div><i class="fa-solid fa-users"></i>{{ $item->pengikut }}</div>@endif
                            @endif
                        </div>

                        <form action="{{ route('log-pergerakan.kembali', $item->id) }}" method="POST"
                              data-konfirmasi="{{ $item->nama }} akan ditandai sudah kembali ke asrama sekarang." data-konfirmasi-judul="Konfirmasi Kepulangan?" data-konfirmasi-varian="success" data-konfirmasi-tombol="Ya, Sudah Kembali">
                            @csrf @method('PATCH')
                            <button type="submit" class="ds-btn tb-btn-kembali"><i class="fa-solid fa-house-circle-check"></i> Tandai Sudah Kembali</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                <div class="ds-empty d-none" id="returnKosong">
                    <i class="fa-solid fa-magnifying-glass ds-icon"></i>
                    Tidak ada taruna yang cocok dengan pencarian.
                </div>
                @endif
            </div>
        </div>

    </div>
</main>

<x-konfirmasi-modal />

<script>
    // Mode aktif disimpan di URL (?mode=) agar redirect()->back() setelah konfirmasi kembali tetap di tab kepulangan
    function switchMode(mode) {
        const kembali = mode === 'kepulangan';
        document.getElementById('sectionKeberangkatan').classList.toggle('d-none', kembali);
        document.getElementById('sectionKepulangan').classList.toggle('d-none', !kembali);
        [['tabBtnKeberangkatan', !kembali], ['tabBtnKepulangan', kembali]].forEach(([id, aktif]) => {
            const btn = document.getElementById(id);
            btn.classList.toggle('active', aktif);
            btn.setAttribute('aria-selected', aktif);
        });
        const url = new URL(location.href);
        kembali ? url.searchParams.set('mode', 'kepulangan') : url.searchParams.delete('mode');
        history.replaceState(null, '', url);
    }

    const KATEGORI = {
        perizinan:       { kartu: 'cardKatPerizinan', sub: 'subcatPerizinan', field: 'fieldPerizinan', awal: null, judul: '<i class="fa-solid fa-notes-medical me-2" style="color:var(--danger)"></i> Isi Form Izin &amp; Dokumentasi', nama: 'Nama Taruna' },
        ekstrakurikuler: { kartu: 'cardKatEkskul',    sub: 'subcatEkskul',    field: 'fieldEkskul',    awal: 'Wajib',     judul: '<i class="fa-solid fa-people-group me-2" style="color:var(--accent)"></i> Isi Form Ekskul &amp; Dokumentasi', nama: 'Nama Koordinator / PJ' },
        olahraga:        { kartu: 'cardKatOlahraga',  sub: 'subcatOlahraga',  field: 'fieldOlahraga',  awal: 'Mandiri',   judul: '<i class="fa-solid fa-person-running me-2" style="color:var(--success)"></i> Isi Form Olahraga &amp; Dokumentasi', nama: 'Nama Taruna / PJ' },
    };

    function selectCategory(cat, sub) {
        if (!KATEGORI[cat]) cat = 'perizinan';
        document.getElementById('inputKategori').value = cat;
        Object.entries(KATEGORI).forEach(([k, c]) => {
            document.getElementById(c.kartu).classList.toggle('active', k === cat);
            document.getElementById(c.sub).classList.toggle('d-none', k !== cat);
            document.getElementById(c.field).classList.toggle('d-none', k !== cat);
        });
        const c = KATEGORI[cat];
        document.getElementById('formTitleText').innerHTML = c.judul;
        document.getElementById('labelNama').innerHTML = c.nama + ' <span class="req">*</span>';
        const pil = [...document.querySelectorAll('#' + c.sub + ' .subcat-pill')];
        // Nilai pil: data-sub (jenis izin) atau teksnya (ekskul/olahraga)
        const nilai = p => p.dataset.sub || p.textContent.trim();
        const pilih = pil.find(p => nilai(p) === (sub || c.awal)) || pil[0];
        setSubcat(nilai(pilih), pilih);
    }

    function setSubcat(sub, el) {
        document.getElementById('inputSubkategori').value = sub;
        terapkanJenisIzin(sub);
        el.closest('.subcat-pills').querySelectorAll('.subcat-pill').forEach(p => p.classList.toggle('active', p === el));
    }

    // Isi NPM & kelas otomatis saat nama dipilih dari daftar
    document.getElementById('inputNama').addEventListener('input', function () {
        const opt = [...document.querySelectorAll('#mhsList option')].find(o => o.value.toLowerCase() === this.value.toLowerCase());
        if (!opt) return;
        document.getElementById('inputNpm').value = opt.dataset.npm || '';
        document.getElementById('inputProdi').value = opt.dataset.kelas || '';
    });

    function filterReturnList() {
        const q = document.getElementById('inputSearchReturn').value.toLowerCase().trim();
        let tampil = 0;
        document.querySelectorAll('.return-item-card').forEach(card => {
            const cocok = (card.dataset.search || '').includes(q);
            card.style.display = cocok ? '' : 'none';
            tampil += cocok;
        });
        document.getElementById('returnKosong').classList.toggle('d-none', tampil > 0);
    }

    // Setelah gagal validasi, pulihkan kategori & sub-kategori yang tadi dipilih
    selectCategory(@js(old('kategori', 'perizinan')), @js(old('subkategori')));
</script>
</x-app-layout>
