<x-app-layout>
{{-- Form memakai gaya yang sama dengan form Log Gerbang, Keluhan Barak & Surat --}}
<x-form-glass-style />
<style>
    .reward-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .reward-kembali:hover { color: var(--accent-ink); }
    .form-control[readonly] { color: var(--ink-600); cursor: not-allowed; }
    .form-group .ds-error { font-size: 11px; }
    .form-label .opt { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    textarea.form-control { resize: vertical; min-height: 96px; }

    /* Pilihan jenis pengajuan — kartu kaca seperti pilihan kategori Log Gerbang */
    .jenis-toggle { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3); }
    .jenis-toggle input { position: absolute; opacity: 0; pointer-events: none; }
    .jenis-toggle label {
        display: flex; align-items: center; justify-content: center; gap: var(--space-2);
        padding: var(--space-3-5) var(--space-3); border-radius: var(--radius-md);
        background: var(--glass-card); border: 1.5px solid var(--border-glass-glow);
        font-size: 13px; font-weight: 700; color: var(--ink-700); cursor: pointer;
        transition: background-color .15s, border-color .15s, box-shadow .15s, color .15s;
    }
    .jenis-toggle label i { font-size: 15px; color: var(--ink-500); }
    .jenis-toggle label:hover { background: var(--glass-solid); }
    .jenis-toggle input:checked + label { background: var(--glass-solid); border-color: var(--accent); color: var(--ink-900); box-shadow: 0 0 0 3px var(--focus-ring-glow), var(--shadow-glass-sm); }
    .jenis-toggle input:checked + label i { color: var(--accent); }
    .jenis-toggle input:focus-visible + label { box-shadow: var(--shadow-focus); }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Ajukan Reward Prestasi" icon="fa-award"
            subtitle="Ajukan reward atas prestasi Anda (individu) atau kelompok kepada satuan pengasuhan" />

        <a href="{{ route('reward.index') }}" class="ds-btn ds-btn--pill reward-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Reward
        </a>

        @if(!$mahasiswa)
        <x-glass-alert type="danger" title="Akun Anda belum terhubung ke data mahasiswa">
            Hubungi pengasuh atau admin agar akun Anda ditautkan ke database mahasiswa sebelum mengajukan reward.
        </x-glass-alert>
        @else

        @if($errors->any())
        <x-glass-alert type="danger" title="Pengajuan reward belum terkirim">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        <div class="form-card">
            <form method="POST" action="{{ route('reward.store') }}" enctype="multipart/form-data" id="rewardForm">
                @csrf

                <div class="form-section-title">
                    <span><i class="fas fa-award me-2" style="color:var(--accent)"></i> Isi Form Pengajuan Reward</span>
                    <span class="ds-badge ds-badge--accent">
                        <i class="far fa-clock"></i> Waktu: {{ now()->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="namaTaruna">Nama Taruna</label>
                        <input type="text" id="namaTaruna" class="form-control" value="{{ $mahasiswa->nama }}" readonly>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="emailTaruna">Email</label>
                        <input type="text" id="emailTaruna" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="npmTaruna">NPM</label>
                        <input type="text" id="npmTaruna" class="form-control" value="{{ $mahasiswa->npm ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="prodiTaruna">Program Studi</label>
                        <input type="text" id="prodiTaruna" class="form-control" value="{{ $mahasiswa->prodi ?? '-' }} — {{ \App\Models\Mahasiswa::PRODI[$mahasiswa->prodi]['nama'] ?? '' }}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <span class="form-label">Jenis Pengajuan <span class="req">*</span></span>
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
                    @error('jenis')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" id="grupJumlahAnggota" style="display:none;">
                    <label class="form-label" for="jumlahAnggota">Jumlah Anggota Kelompok <span class="req">*</span></label>
                    <input type="number" id="jumlahAnggota" name="jumlah_anggota" class="form-control" min="2" max="200"
                           placeholder="Contoh: 5" value="{{ old('jumlah_anggota') }}">
                    <small class="form-help">Termasuk Anda sebagai pengaju.</small>
                    @error('jumlah_anggota')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="kategori">Kategori Prestasi <span class="req">*</span></label>
                        <select id="kategori" name="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k }}" {{ old('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kategori')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="tanggalPrestasi">Tanggal Prestasi <span class="req">*</span></label>
                        <input type="date" id="tanggalPrestasi" name="tanggal_prestasi" class="form-control" max="{{ now()->toDateString() }}"
                               value="{{ old('tanggal_prestasi', now()->toDateString()) }}" required>
                        @error('tanggal_prestasi')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan Prestasi <span class="req">*</span></label>
                    <textarea id="keterangan" name="keterangan" class="form-control" rows="3" required
                              placeholder="Jelaskan prestasi yang diraih, misalnya nama lomba/kegiatan, tingkat, dan capaian...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="dokumen">Dokumentasi / Dokumen Pendukung <span class="req">*</span></label>
                    <input type="file" id="dokumen" name="dokumen[]" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" required>
                    <small class="form-help"><i class="fas fa-paperclip"></i> Wajib · maks. 5 file · 5MB per file · JPG, PNG, PDF, DOC, DOCX. Pengajuan akan diproses pengasuhan dan Anda mendapat notifikasi saat statusnya berubah.</small>
                    @error('dokumen')<div class="ds-error">{{ $message }}</div>@enderror
                    @error('dokumen.*')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-submit-log">
                    <i class="fas fa-paper-plane"></i> KIRIM PENGAJUAN
                </button>
            </form>
        </div>
        @endif

    </div>
</main>

<script>
function onJenisChange() {
    const kelompok = document.getElementById('jenis_kelompok').checked;
    document.getElementById('grupJumlahAnggota').style.display = kelompok ? 'block' : 'none';
    document.getElementById('jumlahAnggota').required = kelompok;
}
if (document.getElementById('rewardForm')) onJenisChange();
</script>
</x-app-layout>
