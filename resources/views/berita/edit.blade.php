<x-app-layout>
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }
.app-layout   { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

.breadcrumb { display:flex; align-items:center; gap:7px; margin-bottom:20px; font-size:12px; color:#888; }
.breadcrumb a { color:#fdbb11; text-decoration:none; font-weight:600; }
.breadcrumb a:hover { text-decoration:underline; }
.breadcrumb i { font-size:10px; }

.page-header {
    background: #12283a;
    border-radius: 18px; padding: 24px 28px; color: white; margin-bottom: 24px;
    display:flex; align-items:center; gap:14px; position:relative; overflow:hidden;
}
.page-header::before { content:''; position:absolute; right:-40px; top:-40px; width:160px; height:160px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header .ph-icon { width:48px; height:48px; border-radius:14px; background:rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; position:relative; z-index:1; }
.page-header-text { position:relative; z-index:1; }
.page-header-text h1 { font-size:18px; font-weight:800; margin:0 0 3px; }
.page-header-text p  { font-size:12px; opacity:.8; margin:0; }

.form-grid { display:grid; grid-template-columns:1fr 320px; gap:22px; align-items:start; }

.form-card { background:white; border-radius:16px; border:1px solid #d4dbe5; overflow:hidden; }
.form-card-header { padding:16px 22px; border-bottom:1px solid #d4dbe5; display:flex; align-items:center; gap:9px; }
.form-card-header h3 { font-size:14px; font-weight:700; color:#333; margin:0; }
.form-card-header i  { color:#fdbb11; font-size:14px; }
.form-card-body { padding:22px; }

.form-group { margin-bottom:18px; }
.form-label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:6px; text-transform:uppercase; letter-spacing:.04em; }
.form-label .req { color:#e53e3e; margin-left:2px; }
.form-control {
    width:100%; padding:10px 14px; border:1.5px solid #d4dbe5;
    border-radius:10px; font-size:13px; font-family:'Inter',sans-serif;
    color:#333; outline:none; transition:border-color .15s, box-shadow .15s;
    background:#f9fafb;
}
.form-control:focus { border-color:#fdbb11; box-shadow:0 0 0 3px rgba(253,187,17,.12); }
.form-control.is-invalid { border-color:#e53e3e; }
textarea.form-control { resize:vertical; min-height:320px; line-height:1.7; }
textarea.summary-area { min-height:80px; }
select.form-control { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23999' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:34px; cursor:pointer; }
.invalid-feedback { font-size:11px; color:#e53e3e; margin-top:4px; font-weight:600; }
.form-hint { font-size:11px; color:#aab; margin-top:4px; }

.toggle-wrap { display:flex; align-items:center; gap:10px; padding:13px 14px; border:1.5px solid #d4dbe5; border-radius:10px; cursor:pointer; background:#f9fafb; transition:border-color .15s; margin-bottom:12px; }
.toggle-wrap:hover { border-color:#fdbb11; }
.toggle-wrap input[type=checkbox] { display:none; }
.toggle-slider { width:38px; height:20px; background:#d4dbe5; border-radius:20px; position:relative; flex-shrink:0; transition:background .2s; }
.toggle-slider::after { content:''; position:absolute; left:3px; top:50%; transform:translateY(-50%); width:14px; height:14px; background:white; border-radius:50%; transition:left .2s; box-shadow:0 1px 3px rgba(0,0,0,.2); }
.toggle-wrap.on .toggle-slider { background:#12283a; }
.toggle-wrap.on .toggle-slider::after { left:21px; }
.toggle-label { font-size:13px; font-weight:600; color:#333; }
.toggle-sub   { font-size:11px; color:#aab; }

.img-upload-area { border:2px dashed #d4dbe5; border-radius:12px; padding:20px; text-align:center; cursor:pointer; transition:border-color .15s, background .15s; position:relative; }
.img-upload-area:hover { border-color:#fdbb11; background:#f5f7fa; }
.img-upload-area input { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.img-upload-area i { font-size:22px; color:#d4dbe5; margin-bottom:6px; display:block; }
.img-upload-area p { font-size:12px; color:#6b7c93; margin:0; }

.current-img { border-radius:10px; margin-bottom:12px; overflow:hidden; }
.current-img img { width:100%; max-height:150px; object-fit:cover; border-radius:10px; }
.current-img-label { font-size:11px; color:#6b7c93; display:flex; align-items:center; gap:5px; margin-bottom:6px; font-weight:600; }

.kat-pills { display:flex; flex-wrap:wrap; gap:8px; }
.kat-pill  { padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; border:1.5px solid #d4dbe5; cursor:pointer; transition:all .15s; display:inline-flex; align-items:center; gap:5px; background:#fff; }
.kat-pill:hover    { border-color:#fdbb11; color:#fdbb11; }
.kat-pill.selected { border-color:transparent; color:white; }
.kat-pill input    { display:none; }

.btn { padding:11px 22px; border-radius:10px; font-size:13px; font-weight:700; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:8px; text-decoration:none; transition:opacity .15s, transform .1s; }
.btn:hover     { opacity:.9; transform:translateY(-1px); }
.btn-primary   { background:#12283a; color:white; }
.btn-secondary { background:#eef3f9; color:#fdbb11; }
.btn-group     { display:flex; gap:10px; flex-wrap:wrap; }

.alert { padding:12px 18px; border-radius:10px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:9px; }
.alert-success { background:#e6fff5; color:#276749; border:1px solid #b2f5ea; }
</style>

<div class="app-layout">
    <x-sidebar active="berita" />

    <div class="main-content">

        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('berita.index') }}">Berita Taruna</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('berita.show', $beritum) }}">{{ Str::limit($beritum->judul, 30) }}</a>
            <i class="fas fa-chevron-right"></i>
            <span style="color:#333;font-weight:600;">Edit</span>
        </div>

        {{-- Page Header --}}
        <div class="page-header">
            <div class="ph-icon"><i class="fas fa-edit"></i></div>
            <div class="page-header-text">
                <h1>Edit Berita</h1>
                <p>Perbarui konten dan pengaturan artikel</p>
            </div>
        </div>

        <form method="POST" action="{{ route('berita.update', $beritum) }}" enctype="multipart/form-data" id="berita-form">
            @csrf
            @method('PUT')

            <div class="form-grid">

                {{-- Left --}}
                <div>
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-align-left"></i>
                            <h3>Konten Berita</h3>
                        </div>
                        <div class="form-card-body">

                            <div class="form-group">
                                <label class="form-label">Judul Berita <span class="req">*</span></label>
                                <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}"
                                    value="{{ old('judul', $beritum->judul) }}" required>
                                @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Ringkasan</label>
                                <textarea name="ringkasan" class="form-control summary-area {{ $errors->has('ringkasan') ? 'is-invalid' : '' }}">{{ old('ringkasan', $beritum->ringkasan) }}</textarea>
                                <div class="form-hint">Maks 500 karakter. Kosong = diambil otomatis dari isi.</div>
                                @error('ringkasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Isi Berita <span class="req">*</span></label>
                                <textarea name="konten" class="form-control {{ $errors->has('konten') ? 'is-invalid' : '' }}" required>{{ old('konten', $beritum->konten) }}</textarea>
                                @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Right --}}
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Kategori --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-tags"></i>
                            <h3>Kategori</h3>
                        </div>
                        <div class="form-card-body">
                            <input type="hidden" name="kategori" id="kategori-val" value="{{ old('kategori', $beritum->kategori) }}">
                            <div class="kat-pills" id="kat-pills">
                                @php
                                    $katConfig = [
                                        'pengumuman' => ['label'=>'Pengumuman', 'icon'=>'fa-bullhorn',    'bg'=>'#e53e3e'],
                                        'prestasi'   => ['label'=>'Prestasi',   'icon'=>'fa-trophy',      'bg'=>'#d69e2e'],
                                        'kegiatan'   => ['label'=>'Kegiatan',   'icon'=>'fa-flag',        'bg'=>'#38a169'],
                                        'informasi'  => ['label'=>'Informasi',  'icon'=>'fa-info-circle', 'bg'=>'#12283a'],
                                        'lainnya'    => ['label'=>'Lainnya',    'icon'=>'fa-newspaper',   'bg'=>'#12283a'],
                                    ];
                                    $selectedKat = old('kategori', $beritum->kategori);
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
                        </div>
                    </div>

                    {{-- Gambar --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-image"></i>
                            <h3>Gambar Sampul</h3>
                        </div>
                        <div class="form-card-body">
                            @if($beritum->gambar)
                            <div class="current-img">
                                <div class="current-img-label"><i class="fas fa-image"></i> Gambar saat ini:</div>
                                <img src="{{ Storage::url($beritum->gambar) }}" alt="{{ $beritum->judul }}" id="img-preview" style="display:block;">
                            </div>
                            @else
                            <img id="img-preview" src="" alt="Preview" style="display:none;width:100%;border-radius:10px;margin-bottom:12px;max-height:150px;object-fit:cover;">
                            @endif
                            <div class="img-upload-area">
                                <input type="file" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp" id="gambar-input">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>{{ $beritum->gambar ? 'Klik untuk ganti gambar' : 'Klik untuk upload gambar' }}</p>
                            </div>
                            @error('gambar')<div class="invalid-feedback" style="display:block;margin-top:6px;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Pengaturan --}}
                    <div class="form-card">
                        <div class="form-card-header">
                            <i class="fas fa-sliders-h"></i>
                            <h3>Pengaturan</h3>
                        </div>
                        <div class="form-card-body">
                            <label class="toggle-wrap {{ old('is_published', $beritum->is_published ? '1' : '0') == '1' ? 'on' : '' }}" id="pub-toggle">
                                <input type="hidden" name="is_published" value="{{ old('is_published', $beritum->is_published ? '1' : '0') }}">
                                <div class="toggle-slider"></div>
                                <div>
                                    <div class="toggle-label">Publikasikan</div>
                                    <div class="toggle-sub">Aktif = tampil untuk semua</div>
                                </div>
                            </label>
                            <label class="toggle-wrap {{ old('is_pinned', $beritum->is_pinned ? '1' : '0') == '1' ? 'on' : '' }}" id="pin-toggle">
                                <input type="hidden" name="is_pinned" value="{{ old('is_pinned', $beritum->is_pinned ? '1' : '0') }}">
                                <div class="toggle-slider"></div>
                                <div>
                                    <div class="toggle-label">Pin Berita</div>
                                    <div class="toggle-sub">Pin = tampil di bagian atas</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                        <a href="{{ route('berita.show', $beritum) }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>

<script>
document.querySelectorAll('.kat-pill').forEach(function(pill) {
    pill.addEventListener('click', function() {
        const kat = this.dataset.kat;
        const bg  = this.dataset.bg;
        document.getElementById('kategori-val').value = kat;
        document.querySelectorAll('.kat-pill').forEach(function(p) {
            p.classList.remove('selected');
            p.style.background  = '';
            p.style.borderColor = '';
            p.style.color       = '';
        });
        this.classList.add('selected');
        this.style.background  = bg;
        this.style.borderColor = bg;
        this.style.color       = 'white';
    });
});

document.getElementById('gambar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const preview = document.getElementById('img-preview');
        preview.src          = ev.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

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
