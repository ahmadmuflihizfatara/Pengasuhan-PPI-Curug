<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; max-width: 860px; }

.back-link { display: inline-flex; align-items: center; gap: 7px; color: #fdbb11; text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
.back-link:hover { text-decoration: underline; }

.page-header { background: #12283a; border-radius: 18px; padding: 28px 32px; color: white; margin-bottom: 24px; position: relative; overflow: hidden; }
.page-header::before { content: ''; position: absolute; right: -50px; top: -50px; width: 180px; height: 180px; background: rgba(255,255,255,.08); border-radius: 50%; }
.page-header h1 { margin: 0 0 4px 0; font-size: 22px; font-weight: 800; position: relative; z-index: 1; }
.page-header p { margin: 0; opacity: .85; font-size: 13px; position: relative; z-index: 1; }

.card { background: white; border-radius: 16px; padding: 28px 32px; border: 1px solid #d4dbe5; }

.error-box { background: #fff0f0; border: 1px solid #fc8181; border-radius: 10px; padding: 14px 18px; margin-bottom: 22px; }
.error-box p { margin: 0 0 8px 0; color: #e53e3e; font-weight: 700; font-size: 13px; }
.error-box ul { margin: 0; padding-left: 18px; color: #e53e3e; font-size: 13px; }

.section-divider { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #aab; padding-bottom: 10px; border-bottom: 1px solid #f0f2f7; margin: 0 0 20px 0; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.form-group.full { grid-column: span 2; }
.form-label { display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 7px; text-transform: uppercase; letter-spacing: .04em; }
.req { color: #e53e3e; }
.opt { color: #aab; font-weight: 400; text-transform: none; letter-spacing: 0; }
.form-control { width: 100%; padding: 11px 14px; border: 2px solid #d4dbe5; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; color: #333; background: #f9fafb; outline: none; transition: border .15s; }
.form-control:focus { border-color: #fdbb11; background: white; }
select.form-control { cursor: pointer; }
textarea.form-control { resize: vertical; min-height: 90px; }
.file-input { width: 100%; padding: 9px 14px; border: 2px dashed #c5c8e0; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; background: #f9fafb; cursor: pointer; outline: none; }
.file-info { background: #eef3f9; border-radius: 8px; padding: 9px 14px; margin-bottom: 8px; font-size: 12px; color: #12283a; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.file-info a { color: #fdbb11; margin-left: auto; font-weight: 700; text-decoration: none; }

.btn-row { display: flex; gap: 12px; justify-content: flex-end; margin-top: 28px; padding-top: 20px; border-top: 1px solid #f0f2f7; }
.btn-submit { background: #12283a; color: white; border: none; padding: 12px 30px; border-radius: 25px; font-size: 13px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; border: 1px solid #d4dbe5; transition: opacity .15s; }
.btn-submit:hover { opacity: .9; }
.btn-cancel { background: #f4f5f9; color: #666; padding: 12px 24px; border-radius: 25px; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; border: 1px solid #d4dbe5; transition: border .15s; }
.btn-cancel:hover { border-color: #fdbb11; color: #fdbb11; }
</style>

<div class="app-layout">
    <x-sidebar active="surat" />

    <div class="main-content">
        <a href="{{ route('surat.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Surat
        </a>

        <div class="page-header">
            <h1><i class="fas fa-edit" style="margin-right:10px;"></i>Edit Surat</h1>
            <p>Perbarui data surat: <strong>{{ Str::limit($surat->perihal, 60) }}</strong></p>
        </div>

        <div class="card">
            @if($errors->any())
            <div class="error-box">
                <p><i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Terdapat kesalahan:</p>
                <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('surat.update', $surat->id) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="section-divider">Informasi Surat</div>
                <div class="form-grid" style="margin-bottom:18px;">
                    <div class="form-group">
                        <label class="form-label">Nomor Surat <span class="opt">(opsional)</span></label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}"
                               placeholder="Contoh: 001/PPI/III/2026" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Surat <span class="req">*</span></label>
                        <select name="jenis_surat" required class="form-control">
                            @foreach($jenisList as $j)
                                <option value="{{ $j }}" {{ old('jenis_surat', $surat->jenis_surat) === $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Perihal <span class="req">*</span></label>
                        <input type="text" name="perihal" value="{{ old('perihal', $surat->perihal) }}" required
                               placeholder="Tuliskan perihal surat..." class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pengirim <span class="req">*</span></label>
                        <input type="text" name="pengirim" value="{{ old('pengirim', $surat->pengirim) }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Penerima <span class="req">*</span></label>
                        <input type="text" name="penerima" value="{{ old('penerima', $surat->penerima) }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Surat <span class="req">*</span></label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat->format('Y-m-d')) }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Diterima <span class="opt">(opsional)</span></label>
                        <input type="date" name="tanggal_terima" value="{{ old('tanggal_terima', $surat->tanggal_terima ? $surat->tanggal_terima->format('Y-m-d') : '') }}" class="form-control">
                    </div>
                </div>

                <div class="section-divider">Status & Lampiran</div>
                <div class="form-grid" style="margin-bottom:18px;">
                    <div class="form-group">
                        <label class="form-label">Status <span class="req">*</span></label>
                        <select name="status" required class="form-control">
                            @foreach($statusList as $st)
                                <option value="{{ $st }}" {{ old('status', $surat->status) === $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Upload Dokumen Baru <span class="opt">(biarkan kosong jika tidak diubah)</span></label>
                        @if($surat->file_path)
                        <div class="file-info">
                            <i class="fas fa-paperclip"></i>
                            <span>{{ basename($surat->file_path) }}</span>
                            <a href="{{ Storage::url($surat->file_path) }}" target="_blank">Lihat</a>
                        </div>
                        @endif
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Keterangan <span class="opt">(opsional)</span></label>
                        <textarea name="keterangan" class="form-control">{{ old('keterangan', $surat->keterangan) }}</textarea>
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('surat.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
