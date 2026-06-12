<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout   { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

/* ── Breadcrumb ── */
.breadcrumb { display:flex; align-items:center; gap:7px; margin-bottom:20px; font-size:12px; color:#888; }
.breadcrumb a { color:#667eea; text-decoration:none; font-weight:600; }
.breadcrumb a:hover { text-decoration:underline; }
.breadcrumb i { font-size:10px; }

/* ── Page Header ── */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 18px; padding: 24px 28px; color: white; margin-bottom: 24px;
    display:flex; align-items:center; gap:14px; position:relative; overflow:hidden;
}
.page-header::before { content:''; position:absolute; right:-40px; top:-40px; width:160px; height:160px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header .ph-icon { width:48px; height:48px; border-radius:14px; background:rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; position:relative; z-index:1; }
.page-header-text { position:relative; z-index:1; }
.page-header-text h1 { font-size:18px; font-weight:800; margin:0 0 3px; }
.page-header-text p  { font-size:12px; opacity:.8; margin:0; }

/* ── Form Layout ── */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 22px; align-items: start;
}

/* ── Card ── */
.form-card {
    background: white; border-radius: 16px;
    box-shadow: 0 2px 14px rgba(0,0,0,.06);
    overflow: hidden;
}
.form-card-header {
    padding: 16px 22px; border-bottom: 1px solid #f0f2f7;
    display:flex; align-items:center; gap:9px;
}
.form-card-header h3 { font-size: 14px; font-weight: 700; color: #333; margin: 0; }
.form-card-header i  { color: #667eea; font-size: 14px; }
.form-card-body { padding: 22px; }

/* ── Form Elements ── */
.form-group { margin-bottom: 18px; }
.form-label {
    display: block; font-size: 12px; font-weight: 700;
    color: #555; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .04em;
}
.form-label .req { color: #e53e3e; margin-left: 2px; }
.form-control {
    width: 100%; padding: 10px 14px; border: 1.5px solid #e2e8f0;
    border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif;
    color: #333; outline: none; transition: border-color .15s, box-shadow .15s;
    background: #fafbff;
}
.form-control:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,.12); }
.form-control.is-invalid { border-color: #e53e3e; }
textarea.form-control { resize: vertical; min-height: 320px; line-height: 1.7; }
textarea.summary-area { min-height: 80px; }
select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23999' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:34px; cursor:pointer; }
.invalid-feedback { font-size: 11px; color: #e53e3e; margin-top: 4px; font-weight: 600; }
.form-hint { font-size: 11px; color: #aab; margin-top: 4px; }

/* ── Checkbox Toggle ── */
.toggle-wrap {
    display:flex; align-items:center; gap:10px;
    padding:13px 14px; border:1.5px solid #e2e8f0; border-radius:10px;
    cursor:pointer; background:#fafbff; transition:border-color .15s;
    margin-bottom:12px;
}
.toggle-wrap:hover { border-color:#667eea; }
.toggle-wrap input[type=checkbox] { display:none; }
.toggle-slider {
    width:38px; height:20px; background:#e2e8f0; border-radius:20px;
    position:relative; flex-shrink:0; transition:background .2s;
}
.toggle-slider::after {
    content:''; position:absolute; left:3px; top:50%; transform:translateY(-50%);
    width:14px; height:14px; background:white; border-radius:50%;
    transition:left .2s; box-shadow:0 1px 3px rgba(0,0,0,.2);
}
.toggle-wrap.on .toggle-slider { background: linear-gradient(135deg,#667eea,#764ba2); }
.toggle-wrap.on .toggle-slider::after { left:21px; }
.toggle-label { font-size:13px; font-weight:600; color:#333; }
.toggle-sub   { font-size:11px; color:#aab; }

/* ── Image Upload ── */
.img-upload-area {
    border: 2px dashed #c5cae0; border-radius: 12px;
    padding: 24px; text-align: center; cursor: pointer;
    transition: border-color .15s, background .15s; position: relative;
}
.img-upload-area:hover { border-color: #667eea; background: #f8f9ff; }
.img-upload-area input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.img-upload-area i   { font-size:28px; color:#c5cae0; margin-bottom:8px; display:block; }
.img-upload-area p   { font-size:12px; color:#aab; margin:0; }
.img-upload-area .upload-hint { font-size:10px; color:#bbc; margin-top:4px; }
#img-preview { display:none; width:100%; border-radius:10px; margin-top:12px; max-height:180px; object-fit:cover; }

/* ── Category Pills ── */
.kat-pills { display:flex; flex-wrap:wrap; gap:8px; }
.kat-pill  {
    padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600;
    border:1.5px solid #e2e8f0; cursor:pointer; transition:all .15s;
    display:inline-flex; align-items:center; gap:5px; background:#fff;
}
.kat-pill:hover     { border-color:#667eea; color:#667eea; }
.kat-pill.selected  { border-color:transparent; color:white; }
.kat-pill input     { display:none; }

/* ── Btn ── */
.btn {
    padding:11px 22px; border-radius:10px; font-size:13px; font-weight:700;
    border:none; cursor:pointer; display:inline-flex; align-items:center; gap:8px;
    text-decoration:none; transition:opacity .15s, transform .1s;
}
.btn:hover    { opacity:.9; transform:translateY(-1px); }
.btn-primary  { background:linear-gradient(135deg,#667eea,#764ba2); color:white; }
.btn-secondary{ background:#f0f1fb; color:#667eea; }
.btn-group    { display:flex; gap:10px; flex-wrap:wrap; }
</style>

<div class="app-layout">
    <x-sidebar active="berita" />

    <div class="main-content">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('berita.index') }}">Berita Taruna</a>
            <i class="fas fa-chevron-right"></i>
            <span style="color:#333;font-weight:600;">Tulis Berita Baru</span>
        </div>

        {{-- Page Header --}}
        <div class="page-header">
            <div class="ph-icon"><i class="fas fa-pen-nib"></i></div>
            <div class="page-header-text">
                <h1>Tulis Berita Baru</h1>
                <p>Buat artikel, pengumuman, atau informasi untuk taruna</p>
            </div>
        </div>

        <form method="POST" action="{{ route('berita.store') }}" enctype="multipart/form-data" id="berita-form">
            @csrf

            <div class="form-grid">

                {{-- Left: Main Content --}}
                <div>
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-align-left"></i>
                            <h3>Konten Berita</h3>
                        </div>
                        <div class="form-card-body">

                            {{-- Judul --}}
                            <div class="form-group">
                                <label class="form-label">Judul Berita <span class="req">*</span></label>
                                <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                                    placeholder="Tulis judul yang menarik..." value="{{ old('judul') }}" required>
                                @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Ringkasan --}}
                            <div class="form-group">
                                <label class="form-label">Ringkasan / Deskripsi Singkat</label>
                                <textarea name="ringkasan" class="form-control summary-area {{ $errors->has('ringkasan') ? 'is-invalid' : '' }}"
                                    placeholder="Ringkasan singkat (tampil di kartu berita)...">{{ old('ringkasan') }}</textarea>
                                <div class="form-hint">Maks 500 karakter. Dikosongkan = diambil otomatis dari isi.</div>
                                @error('ringkasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Konten --}}
                            <div class="form-group">
                                <label class="form-label">Isi Berita <span class="req">*</span></label>
                                <textarea name="konten" class="form-control {{ $errors->has('konten') ? 'is-invalid' : '' }}"
                                    placeholder="Tulis isi berita lengkap di sini..." required>{{ old('konten') }}</textarea>
                                <div class="form-hint">Gunakan Enter untuk baris baru. Mendukung teks biasa.</div>
                                @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Right: Settings --}}
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Kategori --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-tags"></i>
                            <h3>Kategori</h3>
                        </div>
                        <div class="form-card-body">
                            <input type="hidden" name="kategori" id="kategori-val" value="{{ old('kategori', 'informasi') }}">
                            <div class="kat-pills" id="kat-pills">
                                @php
                                    $katConfig = [
                                        'pengumuman' => ['label'=>'Pengumuman', 'icon'=>'fa-bullhorn',    'bg'=>'#e53e3e', 'color'=>'#e53e3e'],
                                        'prestasi'   => ['label'=>'Prestasi',   'icon'=>'fa-trophy',      'bg'=>'#d69e2e', 'color'=>'#d69e2e'],
                                        'kegiatan'   => ['label'=>'Kegiatan',   'icon'=>'fa-flag',        'bg'=>'#38a169', 'color'=>'#38a169'],
                                        'informasi'  => ['label'=>'Informasi',  'icon'=>'fa-info-circle', 'bg'=>'#3182ce', 'color'=>'#3182ce'],
                                        'lainnya'    => ['label'=>'Lainnya',    'icon'=>'fa-newspaper',   'bg'=>'#667eea', 'color'=>'#667eea'],
                                    ];
                                    $selectedKat = old('kategori', 'informasi');
                                @endphp
                                @foreach($kategoriList as $kat)
                                <label class="kat-pill {{ $selectedKat === $kat ? 'selected' : '' }}"
                                    data-kat="{{ $kat }}"
                                    data-bg="{{ $katConfig[$kat]['bg'] }}"
                                    style="{{ $selectedKat === $kat ? 'background:'.$katConfig[$kat]['bg'].';border-color:'.$katConfig[$kat]['bg'].';' : '' }}">
                                    <i class="fas {{ $katConfig[$kat]['icon'] }}"></i>
                                    {{ $katConfig[$kat]['label'] }}
                                </label>
                                @endforeach
                            </div>
                            @error('kategori')<div class="invalid-feedback" style="display:block;margin-top:8px;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Gambar Sampul --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-image"></i>
                            <h3>Gambar Sampul</h3>
                        </div>
                        <div class="form-card-body">
                            <div class="img-upload-area" id="upload-area">
                                <input type="file" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp" id="gambar-input">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Klik atau drag gambar ke sini</p>
                                <div class="upload-hint">JPG, PNG, WEBP — maks 3MB</div>
                            </div>
                            <img id="img-preview" src="" alt="Preview">
                            @error('gambar')<div class="invalid-feedback" style="display:block;margin-top:6px;">{{ $message }}</div>@enderror
                            <div class="form-hint" style="margin-top:8px;">Dikosongkan = warna gradien otomatis sesuai kategori</div>
                        </div>
                    </div>

                    {{-- Pengaturan --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-sliders-h"></i>
                            <h3>Pengaturan</h3>
                        </div>
                        <div class="form-card-body">
                            <label class="toggle-wrap {{ old('is_published', '1') == '1' ? 'on' : '' }}" id="pub-toggle">
                                <input type="hidden" name="is_published" value="{{ old('is_published', '1') }}">
                                <div class="toggle-slider"></div>
                                <div>
                                    <div class="toggle-label">Publikasikan</div>
                                    <div class="toggle-sub">Aktif = langsung tampil untuk semua</div>
                                </div>
                            </label>
                            <label class="toggle-wrap {{ old('is_pinned') == '1' ? 'on' : '' }}" id="pin-toggle">
                                <input type="hidden" name="is_pinned" value="{{ old('is_pinned', '0') }}">
                                <div class="toggle-slider"></div>
                                <div>
                                    <div class="toggle-label">Pin Berita</div>
                                    <div class="toggle-sub">Pin = tampil di bagian atas halaman</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Publikasikan</button>
                        <a href="{{ route('berita.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

<script>
// ── Kategori pill selector ──
document.querySelectorAll('.kat-pill').forEach(function(pill) {
    pill.addEventListener('click', function() {
        const kat = this.dataset.kat;
        const bg  = this.dataset.bg;
        document.getElementById('kategori-val').value = kat;
        document.querySelectorAll('.kat-pill').forEach(function(p) {
            p.classList.remove('selected');
            p.style.background   = '';
            p.style.borderColor  = '';
            p.style.color        = '';
        });
        this.classList.add('selected');
        this.style.background  = bg;
        this.style.borderColor = bg;
        this.style.color       = 'white';
    });
});

// ── Image preview ──
document.getElementById('gambar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const preview = document.getElementById('img-preview');
        preview.src     = ev.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

// ── Toggle helpers ──
function setupToggle(toggleId, inputSelector) {
    const wrap  = document.getElementById(toggleId);
    const input = wrap.querySelector(inputSelector);
    wrap.addEventListener('click', function() {
        const isOn = input.value === '1';
        input.value = isOn ? '0' : '1';
        wrap.classList.toggle('on', !isOn);
    });
}
setupToggle('pub-toggle', 'input[name=is_published]');
setupToggle('pin-toggle', 'input[name=is_pinned]');
</script>
</x-app-layout>
