<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }
.app-layout { display: block; min-height: 100vh; }
.main-content { padding: 28px 30px; min-width: 0; max-width: 820px; margin: 0 auto; width: 100%; }

.back-link { display:inline-flex; align-items:center; gap:7px; color:#d63384; text-decoration:none; font-size:13px; font-weight:600; margin-bottom:20px; }
.back-link:hover { text-decoration:underline; }

.page-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.85; font-size:13px; position:relative; z-index:1; }

.card { background:white; border-radius:16px; padding:32px; box-shadow:0 2px 16px rgba(0,0,0,.06); }

.info-banner { background:linear-gradient(135deg,#fff0f9,#fdf2ff); border:1.5px solid #fbb6ce; border-radius:12px; padding:16px 20px; margin-bottom:24px; display:flex; align-items:flex-start; gap:12px; }
.info-banner i { color:#d63384; font-size:18px; margin-top:2px; flex-shrink:0; }
.info-banner-text .title { font-weight:700; color:#b83280; font-size:13px; margin-bottom:4px; }
.info-banner-text p { font-size:12px; color:#4a5568; margin:0; line-height:1.6; }

.section-divider { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#aab; padding-bottom:10px; border-bottom:1px solid #f0f2f7; margin:0 0 20px; }

.form-group { margin-bottom:20px; }
.form-label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:7px; text-transform:uppercase; letter-spacing:.04em; }
.req { color:#e53e3e; }
.opt { color:#aab; font-weight:400; text-transform:none; letter-spacing:0; }
.form-control { width:100%; padding:11px 14px; border:2px solid #edf0f7; border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; color:#333; background:#fafbff; outline:none; transition:border .15s; }
.form-control:focus { border-color:#d63384; background:white; }
.form-control[readonly] { background:#f3f4f6; color:#4b5563; cursor:not-allowed; }
select.form-control { cursor:pointer; }
textarea.form-control { resize:vertical; min-height:110px; }
.file-input { width:100%; padding:10px 14px; border:2px dashed #c5c8e0; border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; background:#fafbff; cursor:pointer; outline:none; }

.btn-row { display:flex; gap:12px; justify-content:flex-end; margin-top:28px; padding-top:20px; border-top:1px solid #f0f2f7; }
.btn-submit { background:linear-gradient(135deg,#f093fb,#f5576c); color:white; border:none; padding:12px 32px; border-radius:25px; font-size:13px; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 15px rgba(245,87,108,.4); transition:opacity .15s; }
.btn-submit:hover { opacity:.9; }
.btn-cancel { background:#f4f5f9; color:#666; padding:12px 24px; border-radius:25px; text-decoration:none; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:8px; border:2px solid #edf0f7; transition:border .15s; }
.btn-cancel:hover { border-color:#d63384; color:#d63384; }

.error-box { background:#fff0f0; border:1px solid #fc8181; border-radius:10px; padding:14px 18px; margin-bottom:22px; }
.error-box p  { margin:0 0 8px; color:#e53e3e; font-weight:700; font-size:13px; }
.error-box ul { margin:0; padding-left:18px; color:#e53e3e; font-size:13px; }
</style>

<div class="app-layout">
    <x-island-navbar />

    <div class="main-content">
        <a href="{{ route('keluhan-barak.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Keluhan
        </a>

        <div class="page-header">
            <h1><i class="fas fa-door-open" style="margin-right:10px;"></i>Ajukan Keluhan Barak</h1>
            <p>Laporkan kerusakan atau kendala di barak Anda kepada satuan pengasuhan</p>
        </div>

        <div class="info-banner">
            <i class="fas fa-info-circle"></i>
            <div class="info-banner-text">
                <div class="title">Cara Mengajukan Keluhan</div>
                <p>Lengkapi formulir di bawah ini. Keluhan Anda akan diproses oleh pengasuhan dan Anda akan menerima notifikasi ketika statusnya berubah. Anda dapat melampirkan foto atau dokumen pendukung (maksimal 5 file, masing-masing 5MB).</p>
            </div>
        </div>

        <div class="card">
            @if($errors->any())
            <div class="error-box">
                <p><i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Terdapat kesalahan:</p>
                <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('keluhan-barak.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="section-divider">Identitas Pengaju</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:24px;">
                    <div class="form-group">
                        <label class="form-label">Nama Taruna</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                </div>

                <div class="section-divider">Detail Keluhan</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:24px;">
                    <div class="form-group">
                        <label class="form-label">Tanggal Pengajuan <span class="req">*</span></label>
                        <input type="date" name="tanggal_pengajuan" class="form-control"
                               value="{{ old('tanggal_pengajuan', now()->toDateString()) }}" required>
                        @error('tanggal_pengajuan')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Program Studi <span class="req">*</span></label>
                        <select name="prodi" class="form-control" required>
                            @foreach($prodiList as $kode => $info)
                                <option value="{{ $kode }}" {{ old('prodi', $user->prodi) === $kode ? 'selected' : '' }}>
                                    {{ $kode }} — {{ $info['nama'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Asrama <span class="req">*</span></label>
                        <select name="asrama" id="asramaSelect" class="form-control" required>
                            <option value="">-- Pilih Asrama --</option>
                            @foreach($asramaList as $a)
                                <option value="{{ $a }}" {{ old('asrama') === $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                        @error('asrama')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lorong <span class="req">*</span></label>
                        <select name="lorong" id="lorongSelect" class="form-control" data-current="{{ old('lorong') }}" required>
                            <option value="">-- Pilih Lorong --</option>
                        </select>
                        @error('lorong')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Barak <span class="req">*</span></label>
                        <input type="text" name="nomor_barak" value="{{ old('nomor_barak') }}" required
                               placeholder="Contoh: 12" class="form-control">
                        @error('nomor_barak')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="grid-column:span 2;">
                        <label class="form-label">Keterangan Keluhan <span class="req">*</span></label>
                        <textarea name="keterangan" class="form-control" required
                                  placeholder="Jelaskan keluhan secara singkat dan jelas, misalnya kerusakan lampu, kunci, plafon, atau fasilitas lainnya...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="grid-column:span 2;">
                        <label class="form-label">Lampiran Foto / Dokumen <span class="opt">(opsional, maks. 5 file · 5MB/file · JPG/PNG/PDF/DOC/DOCX)</span></label>
                        <input type="file" name="lampiran[]" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" class="file-input">
                        @error('lampiran.*')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('keluhan-barak.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Kirim Keluhan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const LORONG = @json(\App\Models\KeluhanBarak::LORONG);
const asramaSelect = document.getElementById('asramaSelect');
const lorongSelect = document.getElementById('lorongSelect');

function updateLorong() {
    const options = LORONG[asramaSelect.value] || [];
    const current = lorongSelect.dataset.current || '';
    lorongSelect.innerHTML = '<option value="">-- Pilih Lorong --</option>' +
        options.map(o => `<option value="${o}" ${current === o ? 'selected' : ''}>${o}</option>`).join('');
}

asramaSelect.addEventListener('change', updateLorong);
updateLorong();
</script>
</x-app-layout>
