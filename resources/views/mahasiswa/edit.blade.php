<x-app-layout>
<x-form-glass-style />
<style>
    .mh-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .mh-kembali:hover { color: var(--accent-ink); }

    /* Kartu profil — pola kartu status halaman detail */
    .mh-profil { display: flex; align-items: center; gap: var(--space-3-5); margin-bottom: var(--space-4); }
    .mh-profil__ava { width: 56px; height: 56px; flex-shrink: 0; border-radius: var(--radius-lg); display: grid; place-items: center; font-size: 19px; font-weight: 900; color: var(--ink-on-dark); background: linear-gradient(135deg, #6366f1, var(--accent)); box-shadow: var(--shadow-glass); }
    .mh-profil__nama { font-size: 17px; line-height: 22px; font-weight: 900; color: var(--ink-900); }
    .mh-profil__meta { display: flex; flex-wrap: wrap; gap: var(--space-1-5); margin-top: var(--space-1-5); }

    .mh-sub { display: flex; align-items: center; gap: var(--space-2); margin: var(--space-2) 0 var(--space-3); padding-top: var(--space-4); border-top: 1px solid var(--border-glass-subtle); font-size: 12px; line-height: 16px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: var(--ink-700); }
    .mh-sub:first-of-type { margin-top: 0; padding-top: 0; border-top: 0; }
    .mh-sub i { color: var(--accent); }
    .form-control[readonly] { background-color: var(--glass-subtle) !important; color: var(--ink-600); cursor: not-allowed; }
    .mh-kunci { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    .mh-ikon-input { position: relative; }
    .mh-ikon-input i { position: absolute; left: var(--space-3); top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .mh-ikon-input .form-control { padding-left: 34px; }
    .form-group .ds-error { font-size: 11px; }
    .mh-tombol { display: flex; gap: var(--space-2-5); margin-top: var(--space-2); }
    .mh-tombol .btn-submit-log { flex: 1; }
    .mh-tombol .ds-btn { padding-left: var(--space-5); padding-right: var(--space-5); }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Ubah Biodata Taruna" icon="fa-user-pen"
            :subtitle="'Perbarui biodata, program studi, tingkat, dan email akun ' . $student->nama" />

        <a href="{{ route('mahasiswa.index') }}" class="ds-btn ds-btn--pill mh-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Database Taruna
        </a>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Biodata belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        <div class="form-card">
            <div class="mh-profil">
                <span class="mh-profil__ava">{{ strtoupper(substr($student->nickname ?: $student->nama, 0, 2)) }}</span>
                <div>
                    <div class="mh-profil__nama">{{ $student->nama }}</div>
                    <div class="mh-profil__meta">
                        <span class="ds-badge ds-badge--accent"><i class="fa-solid fa-id-card"></i> NPM {{ $student->npm ?? '—' }}</span>
                        <span class="ds-badge ds-badge--success">{{ $student->kelas ?? '—' }}</span>
                        <span class="ds-badge">{{ $student->prodi_nama }}</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('mahasiswa.update', $student) }}">
                @csrf
                @method('PATCH')

                <h3 class="mh-sub"><i class="fa-solid fa-id-card"></i> Biodata Taruna</h3>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="mhNpm">NPM <span class="mh-kunci"><i class="fa-solid fa-lock"></i> tidak dapat diubah</span></label>
                        <input type="text" id="mhNpm" class="form-control" value="{{ $student->npm ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="mhKelas">Kelas <span class="mh-kunci"><i class="fa-solid fa-rotate"></i> otomatis dari tingkat & prodi</span></label>
                        <input type="text" id="mhKelas" class="form-control" value="{{ $student->kelas ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="mhNama">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" id="mhNama" name="nama" class="form-control" value="{{ old('nama', $student->nama) }}" maxlength="255" required>
                    @error('nama')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="mhNickname">Nickname / Panggilan</label>
                        <input type="text" id="mhNickname" name="nickname" class="form-control" value="{{ old('nickname', $student->nickname) }}" maxlength="100">
                        @error('nickname')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="form-label" for="mhJk">Jenis Kelamin</label>
                        <select id="mhJk" name="jenis_kelamin" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="L" @selected(old('jenis_kelamin', $student->jenis_kelamin) === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin', $student->jenis_kelamin) === 'P')>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 form-group">
                        <label class="form-label" for="mhProdi">Program Studi <span class="req">*</span></label>
                        <select id="mhProdi" name="prodi" class="form-select" required>
                            @foreach(\App\Models\Mahasiswa::PRODI as $kode => $info)
                            <option value="{{ $kode }}" data-maks="{{ $info['tingkat'] }}" @selected(old('prodi', $student->prodi) === $kode)>
                                {{ $kode }} — {{ $info['nama'] }} ({{ $info['jenjang'] }})
                            </option>
                            @endforeach
                        </select>
                        @error('prodi')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="form-label" for="mhTingkat">Tingkat <span class="req">*</span></label>
                        <select id="mhTingkat" name="tingkat" class="form-select" required>
                            @for($t = 1; $t <= 4; $t++)
                            <option value="{{ $t }}" @selected((string) old('tingkat', $student->tingkat) === (string) $t)>Tingkat {{ $t }}</option>
                            @endfor
                        </select>
                        <small class="form-help" id="mhTingkatBantuan"><i class="fa-solid fa-circle-info"></i> D-3 hanya sampai tingkat 3.</small>
                        @error('tingkat')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <h3 class="mh-sub"><i class="fa-solid fa-circle-user"></i> Informasi Akun</h3>
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label class="form-label" for="mhUsername">Username <span class="mh-kunci"><i class="fa-solid fa-lock"></i> tidak dapat diubah</span></label>
                        <div class="mh-ikon-input">
                            <i class="fa-solid fa-at"></i>
                            <input type="text" id="mhUsername" class="form-control" value="{{ $student->user->username ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-7 form-group">
                        <label class="form-label" for="mhEmail">Email Akun</label>
                        <div class="mh-ikon-input">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" id="mhEmail" name="email" class="form-control" value="{{ old('email', $student->user->email ?? '') }}" maxlength="255" @unless($student->user) disabled placeholder="Taruna belum punya akun" @endunless>
                        </div>
                        @error('email')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mh-tombol">
                    <a href="{{ route('mahasiswa.index') }}" class="ds-btn"><i class="fa-solid fa-xmark"></i> Batal</a>
                    <button type="submit" class="btn-submit-log"><i class="fa-solid fa-floppy-disk"></i> SIMPAN PERUBAHAN</button>
                </div>
            </form>
        </div>

    </div>
</main>

<script>
// Batasi pilihan tingkat sesuai prodi (D-3 = maks. tingkat 3); server tetap memvalidasi
(function () {
    const prodi = document.getElementById('mhProdi');
    const tingkat = document.getElementById('mhTingkat');
    function batasi() {
        const maks = Number(prodi.selectedOptions[0].dataset.maks) || 4;
        [...tingkat.options].forEach(o => o.disabled = Number(o.value) > maks);
        if (Number(tingkat.value) > maks) tingkat.value = String(maks);
        document.getElementById('mhTingkatBantuan').lastChild.textContent = ' Prodi ini sampai tingkat ' + maks + '.';
    }
    prodi.addEventListener('change', batasi);
    batasi();
})();
</script>
</x-app-layout>
