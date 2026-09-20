<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }
.app-layout { display: block; min-height: 100vh; }
.main-content { padding: 28px 28px 28px 24px; min-width: 0; max-width: 860px; margin: 0 auto; width: 100%; }

.back-link { display: inline-flex; align-items: center; gap: 7px; color: #667eea; text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
.back-link:hover { text-decoration: underline; }

.page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 18px; padding: 28px 32px; color: white; margin-bottom: 24px; position: relative; overflow: hidden; }
.page-header::before { content: ''; position: absolute; right: -50px; top: -50px; width: 180px; height: 180px; background: rgba(255,255,255,.08); border-radius: 50%; }
.page-header h1 { margin: 0 0 4px 0; font-size: 22px; font-weight: 800; position: relative; z-index: 1; }
.page-header p { margin: 0; opacity: .85; font-size: 13px; position: relative; z-index: 1; }

.card { background: white; border-radius: 16px; padding: 28px 32px; box-shadow: 0 2px 16px rgba(0,0,0,.06); }

.error-box { background: #fff0f0; border: 1px solid #fc8181; border-radius: 10px; padding: 14px 18px; margin-bottom: 22px; }
.error-box p { margin: 0 0 8px 0; color: #e53e3e; font-weight: 700; font-size: 13px; }
.error-box ul { margin: 0; padding-left: 18px; color: #e53e3e; font-size: 13px; }

.section-divider { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #aab; padding-bottom: 10px; border-bottom: 1px solid #f0f2f7; margin: 0 0 20px 0; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.form-group { margin-bottom: 0; }
.form-group.full { grid-column: span 2; }
.form-label { display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 7px; text-transform: uppercase; letter-spacing: .04em; }
.req { color: #e53e3e; }
.opt { color: #aab; font-weight: 400; text-transform: none; letter-spacing: 0; }
.form-control { width: 100%; padding: 11px 14px; border: 2px solid #edf0f7; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; color: #333; background: #fafbff; outline: none; transition: border .15s; }
.form-control:focus { border-color: #667eea; background: white; }
select.form-control { cursor: pointer; }
textarea.form-control { resize: vertical; min-height: 90px; }
.file-input { width: 100%; padding: 9px 14px; border: 2px dashed #c5c8e0; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; background: #fafbff; cursor: pointer; outline: none; }
.file-info { background: #eef0ff; border-radius: 8px; padding: 9px 14px; margin-bottom: 8px; font-size: 12px; color: #667eea; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.file-info a { color: #764ba2; margin-left: auto; }

.btn-row { display: flex; gap: 12px; justify-content: flex-end; margin-top: 28px; padding-top: 20px; border-top: 1px solid #f0f2f7; }
.btn-submit { background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; padding: 12px 30px; border-radius: 25px; font-size: 13px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(102,126,234,.4); transition: opacity .15s; }
.btn-submit:hover { opacity: .9; }
.btn-cancel { background: #f4f5f9; color: #666; padding: 12px 24px; border-radius: 25px; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; border: 2px solid #edf0f7; transition: border .15s; }
.btn-cancel:hover { border-color: #667eea; color: #667eea; }
</style>

<div class="app-layout">
    <x-island-navbar />

    <div class="main-content">
        <a href="{{ route('surat.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Surat
        </a>

        <div class="page-header">
            <h1><i class="fas fa-plus-circle" style="margin-right:10px;"></i>Tambah Surat Baru</h1>
            <p>Isi formulir berikut untuk mencatat surat baru ke dalam sistem</p>
        </div>

        <div class="card">
            @if($errors->any())
            <div class="error-box">
                <p><i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Terdapat kesalahan:</p>
                <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('surat.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="section-divider">Informasi Surat</div>
                <div class="form-grid" style="margin-bottom:18px;">
                    <div class="form-group">
                        <label class="form-label">Nomor Surat <span class="opt">(opsional)</span></label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                               placeholder="Contoh: 001/PPI/III/2026" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Surat <span class="req">*</span></label>
                        <select name="jenis_surat" required class="form-control">
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($jenisList as $j)
                                <option value="{{ $j }}" {{ old('jenis_surat') === $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Perihal <span class="req">*</span></label>
                        <input type="text" name="perihal" value="{{ old('perihal') }}" required
                               placeholder="Tuliskan perihal surat..." class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pengirim <span class="req">*</span></label>
                        <input type="text" name="pengirim" value="{{ old('pengirim') }}" required
                               placeholder="Nama pengirim / instansi..." class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Penerima <span class="req">*</span></label>
                        <input type="text" name="penerima" value="{{ old('penerima') }}" required
                               placeholder="Nama penerima / instansi..." class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Surat <span class="req">*</span></label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Diterima <span class="opt">(opsional)</span></label>
                        <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima') }}" class="form-control">
                    </div>
                </div>

                <div class="section-divider">Status & Lampiran</div>
                <div class="form-grid" style="margin-bottom:18px;">
                    <div class="form-group">
                        <label class="form-label">Status <span class="req">*</span></label>
                        <select name="status" required class="form-control">
                            @foreach($statusList as $st)
                                <option value="{{ $st }}" {{ old('status', 'Diproses') === $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Upload Dokumen <span class="opt">(PDF/Word/Gambar, maks. 5MB)</span></label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Keterangan <span class="opt">(opsional)</span></label>
                        <textarea name="keterangan" placeholder="Catatan tambahan atau keterangan surat..." class="form-control">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('surat.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
