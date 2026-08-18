<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; max-width: 760px; }

.page-header {
    background: #12283a;
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
}
.page-header::before { content: ''; position: absolute; right: -50px; top: -50px; width: 180px; height: 180px; background: rgba(255,255,255,.08); border-radius: 50%; }
.page-header h1 { margin: 0 0 4px 0; font-size: 22px; font-weight: 800; position: relative; z-index: 1; }
.page-header p { margin: 0; opacity: .85; font-size: 13px; position: relative; z-index: 1; }

.back-link { display: inline-flex; align-items: center; gap: 7px; color: #fdbb11; text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
.back-link:hover { text-decoration: underline; }

.card { background: white; border-radius: 16px; padding: 32px; border: 1px solid #d4dbe5; }

.form-group { margin-bottom: 20px; }
.form-label { display: block; font-size: 13px; font-weight: 700; color: #12283a; margin-bottom: 8px; }
.form-label i { color: #fdbb11; margin-right: 6px; }
.form-control {
    width: 100%; padding: 11px 14px;
    border: 2px solid #d4dbe5; border-radius: 10px;
    font-size: 14px; font-family: 'Inter', sans-serif;
    color: #12283a; background: #eef3f9; outline: none;
    transition: border .15s;
}
.form-control:focus { border-color: #fdbb11; background: white; }
.form-control.error { border-color: #fc8181; }
textarea.form-control { resize: vertical; min-height: 100px; }
.form-hint { font-size: 12px; color: #e53e3e; margin-top: 5px; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.btn-row { display: flex; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid #d4dbe5; }
.btn-submit {
    flex: 1; background: #12283a;
    color: white; border: none; padding: 13px; border-radius: 12px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    border: 1px solid #d4dbe5; transition: opacity .15s;
}
.btn-submit:hover { opacity: .9; }
.btn-cancel {
    background: #eef3f9; color: #555; padding: 13px 24px; border-radius: 12px;
    font-size: 14px; font-weight: 700; text-decoration: none;
    display: flex; align-items: center; gap: 8px; border: 2px solid #d4dbe5;
    transition: border .15s;
}
.btn-cancel:hover { border-color: #fdbb11; color: #fdbb11; }
</style>

<div class="app-layout">
    <x-sidebar active="acara" />

    <div class="main-content">
        <a href="{{ route('acara.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Acara
        </a>

        <div class="page-header">
            <h1><i class="fas fa-plus-circle" style="margin-right:10px;"></i>Tambah Acara Baru</h1>
            <p>Isi formulir berikut untuk menambahkan acara pengasuhan</p>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('acara.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-tag"></i>Nama Acara</label>
                    <input type="text" name="nama_acara" value="{{ old('nama_acara') }}"
                           placeholder="Contoh: Kuliah Umum Build With AI"
                           class="form-control {{ $errors->has('nama_acara') ? 'error' : '' }}">
                    @error('nama_acara')<p class="form-hint">{{ $message }}</p>@enderror
                </div>

                <div class="form-grid form-group">
                    <div>
                        <label class="form-label"><i class="fas fa-calendar"></i>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                               class="form-control {{ $errors->has('tanggal') ? 'error' : '' }}">
                        @error('tanggal')<p class="form-hint">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label"><i class="fas fa-clock"></i>Jam</label>
                        <input type="time" name="jam" value="{{ old('jam') }}"
                               class="form-control {{ $errors->has('jam') ? 'error' : '' }}">
                        @error('jam')<p class="form-hint">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><i class="fas fa-align-left"></i>Keterangan <span style="color:#aab; font-weight:400;">(opsional)</span></label>
                    <textarea name="keterangan" placeholder="Deskripsi singkat mengenai acara ini..."
                              class="form-control">{{ old('keterangan') }}</textarea>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Acara</button>
                    <a href="{{ route('acara.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
