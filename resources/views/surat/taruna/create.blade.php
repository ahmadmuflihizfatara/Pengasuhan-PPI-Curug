<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }
.main-content { margin: 0 auto; padding: 8px 30px 28px; min-width: 0; max-width: 820px; }

.back-link { display:inline-flex; align-items:center; gap:7px; color:#667eea; text-decoration:none; font-size:13px; font-weight:600; margin-bottom:20px; }
.back-link:hover { text-decoration:underline; }

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.85; font-size:13px; position:relative; z-index:1; }

.card { background:white; border-radius:16px; padding:32px; box-shadow:0 2px 16px rgba(0,0,0,.06); }

/* Info Banner */
.info-banner { background:linear-gradient(135deg,#ebf4ff,#f0f4ff); border:1.5px solid #bee3f8; border-radius:12px; padding:16px 20px; margin-bottom:24px; display:flex; align-items:flex-start; gap:12px; }
.info-banner i { color:#3182ce; font-size:18px; margin-top:2px; flex-shrink:0; }
.info-banner-text .title { font-weight:700; color:#2b6cb0; font-size:13px; margin-bottom:4px; }
.info-banner-text p { font-size:12px; color:#4a5568; margin:0; line-height:1.6; }

.section-divider { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#aab; padding-bottom:10px; border-bottom:1px solid #f0f2f7; margin:0 0 20px; }

.form-group { margin-bottom:20px; }
.form-label { display:block; font-size:12px; font-weight:700; color:#555; margin-bottom:7px; text-transform:uppercase; letter-spacing:.04em; }
.req { color:#e53e3e; }
.opt { color:#aab; font-weight:400; text-transform:none; letter-spacing:0; }
.form-control { width:100%; padding:11px 14px; border:2px solid #edf0f7; border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; color:#333; background:#fafbff; outline:none; transition:border .15s; }
.form-control:focus { border-color:#667eea; background:white; }
.form-control[readonly] { background:#f3f4f6; color:#4b5563; cursor:not-allowed; }
select.form-control { cursor:pointer; }
textarea.form-control { resize:vertical; min-height:110px; }
.file-input { width:100%; padding:10px 14px; border:2px dashed #c5c8e0; border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; background:#fafbff; cursor:pointer; outline:none; }

.btn-row { display:flex; gap:12px; justify-content:flex-end; margin-top:28px; padding-top:20px; border-top:1px solid #f0f2f7; }
.btn-submit { background:linear-gradient(135deg,#667eea,#764ba2); color:white; border:none; padding:12px 32px; border-radius:25px; font-size:13px; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; gap:8px; box-shadow:0 4px 15px rgba(102,126,234,.4); transition:opacity .15s; }
.btn-submit:hover { opacity:.9; }
.btn-cancel { background:#f4f5f9; color:#666; padding:12px 24px; border-radius:25px; text-decoration:none; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:8px; border:2px solid #edf0f7; transition:border .15s; }
.btn-cancel:hover { border-color:#667eea; color:#667eea; }

.error-box { background:#fff0f0; border:1px solid #fc8181; border-radius:10px; padding:14px 18px; margin-bottom:22px; }
.error-box p  { margin:0 0 8px; color:#e53e3e; font-weight:700; font-size:13px; }
.error-box ul { margin:0; padding-left:18px; color:#e53e3e; font-size:13px; }
</style>

<x-island-navbar />

    <div class="main-content">
        <a href="{{ route('surat-taruna.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengajuan
        </a>

        <div class="page-header">
            <h1><i class="fas fa-file-signature" style="margin-right:10px;"></i>Ajukan Permohonan Surat</h1>
            <p>Isi formulir berikut untuk mengajukan permohonan surat kepada satuan pengasuhan</p>
        </div>

        <div class="info-banner">
            <i class="fas fa-info-circle"></i>
            <div class="info-banner-text">
                <div class="title">Cara Pengajuan Surat</div>
                <p>Lengkapi formulir di bawah ini. Pengajuan Anda akan diproses oleh satuan pengasuhan dan Anda akan menerima notifikasi ketika surat disetujui atau ditolak.</p>
            </div>
        </div>

        <div class="card">
            @if($errors->any())
            <div class="error-box">
                <p><i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Terdapat kesalahan:</p>
                <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('surat-taruna.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="section-divider">Identitas Pengaju</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:24px;">
                    <div class="form-group">
                        <label class="form-label">Nama Pengaju</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ditujukan Kepada</label>
                        <input type="text" class="form-control" value="Satuan Pengasuhan" readonly>
                    </div>
                </div>

                <div class="section-divider">Detail Permohonan Surat</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:24px;">
                    <div class="form-group" style="grid-column:span 1;">
                        <label class="form-label">Jenis Surat <span class="req">*</span></label>
                        <select name="jenis_surat" required class="form-control">
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($jenisList as $j)
                                <option value="{{ $j }}" {{ old('jenis_surat') === $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                        @error('jenis_surat')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Pengajuan</label>
                        <input type="text" class="form-control" value="{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}" readonly>
                    </div>
                    <div class="form-group" style="grid-column:span 2;">
                        <label class="form-label">Perihal / Subjek Surat <span class="req">*</span></label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}" required
                               placeholder="Contoh: Permohonan Izin Kegiatan Luar Komplek" class="form-control">
                        @error('perihal')<div style="color:#e53e3e; font-size:11px; margin-top:5px;">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="grid-column:span 2;">
                        <label class="form-label">Keterangan / Alasan Pengajuan <span class="opt">(opsional)</span></label>
                        <textarea name="keterangan" class="form-control"
                                  placeholder="Jelaskan keperluan dan alasan pengajuan surat secara singkat...">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class="form-group" style="grid-column:span 2;">
                        <label class="form-label">Dokumen Pendukung <span class="opt">(PDF/Word/Gambar, maks. 5MB, opsional)</span></label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input">
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('surat-taruna.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Kirim Permohonan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
