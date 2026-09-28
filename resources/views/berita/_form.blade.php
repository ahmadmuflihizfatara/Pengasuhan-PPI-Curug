{{-- Form berita pengasuh (tulis & ubah). $beritum = null untuk tulis baru. Gaya dari <x-form-glass-style /> --}}
@php
    $isEdit      = (bool) $beritum;
    $katTerpilih = old('kategori', $beritum?->kategori ?? 'informasi');
    $terbit      = (bool) old('is_published', $beritum?->is_published ?? true);
    $dipin       = (bool) old('is_pinned', $beritum?->is_pinned ?? false);
@endphp
<style>
    .bf-grid { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: var(--space-4); align-items: start; }
    @media (max-width: 1023px) { .bf-grid { grid-template-columns: 1fr; } }
    .bf-samping { display: flex; flex-direction: column; gap: var(--space-4); }
    .bf-samping .form-card { padding: var(--space-5); }
    .bf-opt { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    .form-group .ds-error { font-size: 11px; }
    textarea.form-control { resize: vertical; line-height: 20px; }
    textarea.bf-ringkas { min-height: 80px; }
    textarea.bf-konten { min-height: 320px; }

    /* Kategori — radio bergaya chip, warna mengikuti varian badge kategori */
    .bf-kat { display: flex; flex-wrap: wrap; gap: var(--space-1-5); }
    .bf-kat input { position: absolute; opacity: 0; pointer-events: none; }
    .bf-kat label {
        display: inline-flex; align-items: center; gap: var(--space-1-5); padding: var(--space-1-5) var(--space-3);
        border-radius: var(--radius-pill); border: 1px solid var(--border-glass-glow); background: var(--glass-card);
        font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); cursor: pointer;
        transition: background-color .15s, color .15s, box-shadow .15s;
    }
    .bf-kat label i { color: var(--kat); }
    .bf-kat label:hover { background: var(--glass-solid); color: var(--ink-900); }
    .bf-kat input:focus-visible + label { box-shadow: var(--shadow-focus); }
    .bf-kat input:checked + label { background: var(--kat); border-color: transparent; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .bf-kat input:checked + label i { color: inherit; }

    /* Gambar sampul */
    .bf-sampul { display: block; width: 100%; max-height: 180px; object-fit: cover; margin-bottom: var(--space-2-5); border-radius: var(--radius-md); border: 1px solid var(--border-glass-glow); }
    .bf-sampul[hidden] { display: none; }

    /* Saklar — checkbox asli bergaya switch */
    .bf-saklar { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3); margin-bottom: var(--space-2-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); cursor: pointer; }
    .bf-saklar:last-child { margin-bottom: 0; }
    .bf-saklar input[type="checkbox"] {
        appearance: none; -webkit-appearance: none; flex-shrink: 0; position: relative; margin: 0; cursor: pointer;
        width: 38px; height: 22px; border-radius: var(--radius-pill); background: rgba(100,116,139,.3); border: 1px solid var(--border-glass-glow);
        transition: background-color .2s;
    }
    .bf-saklar input[type="checkbox"]::after { content: ''; position: absolute; top: 2px; left: 2px; width: 16px; height: 16px; border-radius: 50%; background: #fff; box-shadow: var(--shadow-glass-sm); transition: transform .2s; }
    .bf-saklar input[type="checkbox"]:checked { background: var(--accent); }
    .bf-saklar input[type="checkbox"]:checked::after { transform: translateX(16px); }
    .bf-saklar input[type="checkbox"]:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .bf-saklar b { display: block; font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
    .bf-saklar small { display: block; font-size: 11px; line-height: 15px; font-weight: 500; color: var(--ink-600); }

    .bf-tombol { display: flex; gap: var(--space-2-5); }
    .bf-tombol .btn-submit-log { flex: 1; }
    .bf-tombol .ds-btn { padding-left: var(--space-4); padding-right: var(--space-4); }
</style>

<form method="POST" action="{{ $isEdit ? route('berita.update', $beritum) : route('berita.store') }}" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="bf-grid">
        {{-- Konten --}}
        <div class="form-card">
            <div class="form-section-title">
                <span><i class="fa-solid {{ $isEdit ? 'fa-pen-to-square' : 'fa-pen-nib' }} me-2" style="color:var(--accent)"></i> {{ $isEdit ? 'Ubah Konten Berita' : 'Konten Berita' }}</span>
                @if($isEdit)
                <span class="ds-badge ds-badge--accent"><i class="fa-regular fa-clock"></i> Dibuat {{ $beritum->created_at->locale('id')->isoFormat('D MMM Y') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="judulBerita">Judul Berita <span class="req">*</span></label>
                <input type="text" id="judulBerita" name="judul" class="form-control" value="{{ old('judul', $beritum?->judul) }}" placeholder="Tulis judul yang menarik..." maxlength="255" required>
                @error('judul')<div class="ds-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="ringkasanBerita">Ringkasan <span class="bf-opt">(opsional)</span></label>
                <textarea id="ringkasanBerita" name="ringkasan" class="form-control bf-ringkas" maxlength="500" placeholder="Ringkasan singkat yang tampil di kartu berita...">{{ old('ringkasan', $beritum?->ringkasan) }}</textarea>
                <small class="form-help"><i class="fa-solid fa-circle-info"></i> Maks. 500 karakter · dikosongkan = diambil otomatis dari isi berita.</small>
                @error('ringkasan')<div class="ds-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group" style="margin-bottom:0">
                <label class="form-label" for="kontenBerita">Isi Berita <span class="req">*</span></label>
                <textarea id="kontenBerita" name="konten" class="form-control bf-konten" placeholder="Tulis isi berita lengkap di sini..." required>{{ old('konten', $beritum?->konten) }}</textarea>
                <small class="form-help"><i class="fa-solid fa-circle-info"></i> Teks biasa · tekan Enter untuk baris baru.</small>
                @error('konten')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="bf-samping">
            {{-- Kategori --}}
            <div class="form-card">
                <div class="form-section-title"><span><i class="fa-solid fa-tags me-2" style="color:var(--accent)"></i> Kategori</span></div>
                <div class="bf-kat" role="radiogroup" aria-label="Kategori berita">
                    @foreach($kategoriList as $kat)
                    @php $contoh = (new \App\Models\BeritaTaruna)->forceFill(['kategori' => $kat]); @endphp
                    <input type="radio" name="kategori" id="kat-{{ $kat }}" value="{{ $kat }}" @checked($katTerpilih === $kat)>
                    <label for="kat-{{ $kat }}" style="--kat: var(--{{ $contoh->kategori_varian }})"><i class="fa-solid {{ $contoh->kategori_icon }}"></i> {{ $contoh->kategori_label }}</label>
                    @endforeach
                </div>
                @error('kategori')<div class="ds-error">{{ $message }}</div>@enderror
            </div>

            {{-- Gambar sampul --}}
            <div class="form-card">
                <div class="form-section-title"><span><i class="fa-solid fa-image me-2" style="color:var(--accent)"></i> Gambar Sampul</span></div>
                <img id="bfPratinjau" class="bf-sampul" src="{{ $beritum?->gambar ? Storage::url($beritum->gambar) : '' }}" alt="Pratinjau gambar sampul" @unless($beritum?->gambar) hidden @endunless>
                <label class="form-label" for="gambarBerita">{{ $beritum?->gambar ? 'Ganti Gambar' : 'Upload Gambar' }} <span class="bf-opt">(opsional)</span></label>
                <input type="file" id="gambarBerita" name="gambar" class="form-control" accept="image/jpeg,image/png,image/webp">
                <small class="form-help"><i class="fa-solid fa-circle-info"></i> JPG, PNG, WEBP · maks. 3MB · dikosongkan = gradien warna kategori.</small>
                @error('gambar')<div class="ds-error">{{ $message }}</div>@enderror
            </div>

            {{-- Pengaturan --}}
            <div class="form-card">
                <div class="form-section-title"><span><i class="fa-solid fa-sliders me-2" style="color:var(--accent)"></i> Pengaturan</span></div>
                <label class="bf-saklar">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked($terbit)>
                    <span><b>Publikasikan</b><small>Aktif = langsung tampil untuk semua taruna</small></span>
                </label>
                <label class="bf-saklar">
                    <input type="hidden" name="is_pinned" value="0">
                    <input type="checkbox" name="is_pinned" value="1" @checked($dipin)>
                    <span><b>Pin Berita</b><small>Tampil di bagian atas halaman berita</small></span>
                </label>
            </div>

            <div class="bf-tombol">
                <a href="{{ $isEdit ? route('berita.show', $beritum) : route('berita.index') }}" class="ds-btn"><i class="fa-solid fa-xmark"></i> Batal</a>
                <button type="submit" class="btn-submit-log"><i class="fa-solid {{ $isEdit ? 'fa-floppy-disk' : 'fa-paper-plane' }}"></i> {{ $isEdit ? 'SIMPAN PERUBAHAN' : 'PUBLIKASIKAN' }}</button>
            </div>
        </div>
    </div>
</form>

<script>
// Pratinjau gambar sampul sebelum diunggah
document.getElementById('gambarBerita').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const img = document.getElementById('bfPratinjau');
    img.src = URL.createObjectURL(file);
    img.hidden = false;
});
</script>
