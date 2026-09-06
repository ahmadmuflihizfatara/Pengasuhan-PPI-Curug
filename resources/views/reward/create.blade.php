<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }
.app-layout { display: block; min-height: 100vh; }
.main-content { padding: 28px 30px; min-width: 0; max-width: 820px; margin: 0 auto; width: 100%; }

.back-link { display:inline-flex; align-items:center; gap:7px; color:#b45309; text-decoration:none; font-size:13px; font-weight:600; margin-bottom:20px; }
.back-link:hover { text-decoration:underline; }

.page-header {
    background: linear-gradient(135deg, #f7b733 0%, #fc4a1a 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.85; font-size:13px; position:relative; z-index:1; }

.card { background:white; border-radius:16px; padding:32px; box-shadow:0 2px 16px rgba(0,0,0,.06); }

.info-banner { background:linear-gradient(135deg,#fffaf0,#fff7ed); border:1.5px solid #fbd38d; border-radius:12px; padding:16px 20px; margin-bottom:24px; display:flex; align-items:flex-start; gap:12px; }
.info-banner i { color:#b45309; font-size:18px; margin-top:2px; flex-shrink:0; }
.info-banner-text .title { font-weight:700; color:#92400e; font-size:13px; margin-bottom:4px; }
.info-banner-text p { font-size:12px; color:#4a5568; margin:0; line-height:1.6; }

.section-divider { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#aab; padding-bottom:10px; border-bottom:1px solid #f0f2f7; margin:0 0 20px; }

.form-group { margin-bottom:20px; }
.form-label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:7px; text-transform:uppercase; letter-spacing:.04em; }
.req { color:#e53e3e; }
.opt { color:#aab; font-weight:400; text-transform:none; letter-spacing:0; }
.form-control { width:100%; padding:11px 14px; border:2px solid #edf0f7; border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; color:#333; background:#fafbff; outline:none; transition:border .15s; }
.form-control:focus { border-color:#f5b301; background:white; }
.form-control[readonly] { background:#f3f4f6; color:#4b5563; cursor:not-allowed; }
select.form-control { cursor:pointer; }
textarea.form-control { resize:vertical; min-height:110px; }
.file-input { width:100%; padding:10px 14px; border:2px dashed #c5c8e0; border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; background:#fafbff; cursor:pointer; outline:none; }

/* Toggle jenis pengajuan */
.jenis-toggle { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.jenis-toggle input { position:absolute; opacity:0; pointer-events:none; }
.jenis-toggle label {
    display:flex; flex-direction:column; align-items:center; gap:5px;
    padding:16px 10px; border:2px solid #e8ebf5; border-radius:12px;
    background:#fafbff; cursor:pointer; transition:all .15s; text-align:center;
    font-size:12.5px; font-weight:700; color:#666;
}
.jenis-toggle label i { font-size:18px; }
.jenis-toggle input:checked + label { border-color:#f5b301; background:#fffaf0; color:#b45309; }

.btn-row { display:flex; gap:12px; justify-content:flex-end; margin-top:28px; padding-top:20px; border-top:1px solid #f0f2f7; }
.btn-submit { background:linear-gradient(135deg,#f7b733,#fc4a1a); color:white; border:none; padding:12px 32px; border-radius:25px; font-size:13px; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 15px rgba(252,74,26,.35); transition:opacity .15s; }
.btn-submit:hover { opacity:.9; }
.btn-cancel { background:#f4f5f9; color:#666; padding:12px 24px; border-radius:25px; text-decoration:none; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:8px; border:2px solid #edf0f7; transition:border .15s; }
.btn-cancel:hover { border-color:#f5b301; color:#b45309; }

.error-box { background:#fff0f0; border:1px solid #fc8181; border-radius:10px; padding:14px 18px; margin-bottom:22px; }
.error-box p  { margin:0 0 8px; color:#e53e3e; font-weight:700; font-size:13px; }
.error-box ul { margin:0; padding-left:18px; color:#e53e3e; font-size:13px; }
</style>

<div class="app-layout">
    <x-island-navbar />

    <div class="main-content">
        <a href="{{ route('reward.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Reward
        </a>

        <div class="page-header">
            <h1><i class="fas fa-award" style="margin-right:10px;"></i>Ajukan Reward</h1>
            <p>Ajukan reward atas prestasi Anda (individu) atau kelompok kepada satuan pengasuhan</p>
        </div>

        @if(!$mahasiswa)
        <div class="error-box">
            <p><i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Akun Anda belum terhubung ke data mahasiswa.</p>
            <ul><li>Hubungi pengasuh atau admin agar akun Anda ditautkan ke database mahasiswa sebelum mengajukan reward.</li></ul>
        </div>
        @else

        <div class="info-banner">
            <i class="fas fa-info-circle"></i>
            <div class="info-banner-text">
                <div class="title">Cara Mengajukan Reward</div>
                <p>Data identitas Anda terisi otomatis dari database mahasiswa. Lengkapi kategori, tanggal, dan keterangan prestasi, lalu lampirkan dokumentasi/dokumen pendukung (wajib). Pengajuan akan diproses dan disetujui oleh pengasuhan.</p>
            </div>
        </div>

        <div class="card">
            @if($errors->any())
            <div class="error-box">
                <p><i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Terdapat kesalahan:</p>
                <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('reward.store') }}" enctype="multipart/form-data" id="rewardForm">
                @csrf

                <div class="section-divider">Identitas Pengaju</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:24px;">
                    <div class="form-group">
                        <label class="form-label">Nama Taruna</label>
                        <input type="text" class="form-control" value="{{ $mahasiswa->nama }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NPM</label>
                        <input type="text" class="form-control" value="{{ $mahasiswa->npm ?? '-' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Program Studi</label>
                        <input type="text" class="form-control" value="{{ $mahasiswa->prodi ?? '-' }} — {{ \App\Models\Mahasiswa::PRODI[$mahasiswa->prodi]['nama'] ?? '' }}" readonly>
                    </div>
                </div>

                <div class="section-divider">Jenis Pengajuan</div>
                <div class="form-group">
                    <div class="jenis-toggle">
                        <div>
                            <input type="radio" name="jenis" id="jenis_individu" value="individu"
                                   {{ old('jenis', 'individu') === 'individu' ? 'checked' : '' }} onchange="onJenisChange()">
                            <label for="jenis_individu"><i class="fas fa-user"></i> Individu</label>
                        </div>
                        <div>
                            <input type="radio" name="jenis" id="jenis_kelompok" value="kelompok"
                                   {{ old('jenis') === 'kelompok' ? 'checked' : '' }} onchange="onJenisChange()">
                            <label for="jenis_kelompok"><i class="fas fa-users"></i> Kelompok</label>
                        </div>
                    </div>
                    @error('jenis')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" id="grupJumlahAnggota" style="display:none;">
                    <label class="form-label">Jumlah Anggota Kelompok <span class="req">*</span></label>
                    <input type="number" name="jumlah_anggota" class="form-control" min="2" max="200"
                           placeholder="Contoh: 5" value="{{ old('jumlah_anggota') }}">
                    <span style="font-size:11px; color:#a8afbd;">Termasuk Anda sebagai pengaju.</span>
                    @error('jumlah_anggota')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                </div>

                <div class="section-divider">Detail Prestasi</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:24px;">
                    <div class="form-group">
                        <label class="form-label">Kategori Prestasi <span class="req">*</span></label>
                        <select name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k }}" {{ old('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kategori')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Prestasi <span class="req">*</span></label>
                        <input type="date" name="tanggal_prestasi" class="form-control" max="{{ now()->toDateString() }}"
                               value="{{ old('tanggal_prestasi', now()->toDateString()) }}" required>
                        @error('tanggal_prestasi')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="grid-column:span 2;">
                        <label class="form-label">Keterangan Prestasi <span class="req">*</span></label>
                        <textarea name="keterangan" class="form-control" required
                                  placeholder="Jelaskan prestasi yang diraih, misalnya nama lomba/kegiatan, tingkat, dan capaian...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="grid-column:span 2;">
                        <label class="form-label">Dokumentasi / Dokumen Pendukung <span class="req">*</span> <span class="opt">(wajib, maks. 5 file · 5MB/file · JPG/PNG/PDF/DOC/DOCX)</span></label>
                        <input type="file" name="dokumen[]" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" class="file-input" required>
                        @error('dokumen')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                        @error('dokumen.*')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('reward.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Kirim Pengajuan</button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

<script>
function onJenisChange() {
    const kelompok = document.getElementById('jenis_kelompok').checked;
    const grup = document.getElementById('grupJumlahAnggota');
    grup.style.display = kelompok ? 'block' : 'none';
    document.querySelector('input[name="jumlah_anggota"]').required = kelompok;
}
onJenisChange();
</script>
</x-app-layout>
