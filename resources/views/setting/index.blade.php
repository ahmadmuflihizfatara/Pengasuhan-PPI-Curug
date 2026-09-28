<x-app-layout>
<x-form-glass-style />
<style>
    .st-grid { display: grid; grid-template-columns: 300px minmax(0, 1fr); gap: var(--space-4); align-items: start; }
    @media (max-width: 1023px) { .st-grid { grid-template-columns: 1fr; } }
    .st-kolom { display: flex; flex-direction: column; gap: var(--space-4); min-width: 0; }
    .st-opt { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    .form-group .ds-error { font-size: 11px; }

    /* Kartu profil & foto */
    .st-profil { text-align: center; }
    .st-foto { width: 96px; height: 96px; margin: 0 auto var(--space-3); border-radius: 50%; overflow: hidden; display: grid; place-items: center; font-size: 30px; font-weight: 900; color: var(--ink-on-dark); background: linear-gradient(135deg, #6366f1, var(--accent)); box-shadow: 0 0 0 4px var(--glass-solid), var(--shadow-glass); }
    .st-foto img { width: 100%; height: 100%; object-fit: cover; }
    .st-profil__nama { font-size: 16px; line-height: 22px; font-weight: 900; color: var(--ink-900); overflow-wrap: anywhere; }
    .st-profil__meta { margin-top: 2px; font-size: 12px; line-height: 17px; font-weight: 600; color: var(--ink-600); overflow-wrap: anywhere; }
    .st-profil__badge { display: flex; justify-content: center; flex-wrap: wrap; gap: var(--space-1-5); margin: var(--space-2-5) 0 var(--space-4); }
    .st-profil .form-group { text-align: left; margin-bottom: 0; }

    /* Jabatan — radio bergaya kartu */
    .st-jabatan { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-2); }
    @media (max-width: 640px) { .st-jabatan { grid-template-columns: 1fr; } }
    .st-jabatan input { position: absolute; opacity: 0; pointer-events: none; }
    .st-jabatan label { display: flex; align-items: center; gap: var(--space-2-5); height: 100%; padding: var(--space-2-5) var(--space-3); border-radius: var(--radius-md); background: var(--glass-card); border: 1.5px solid var(--border-glass-glow); cursor: pointer; font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); transition: background-color .15s, border-color .15s, box-shadow .15s; }
    .st-jabatan label::before { content: ''; width: 14px; height: 14px; flex-shrink: 0; border-radius: 50%; border: 2px solid var(--ink-400); background: var(--glass-solid); transition: border-color .15s, box-shadow .15s; }
    .st-jabatan label:hover { background: var(--glass-solid); color: var(--ink-900); }
    .st-jabatan input:checked + label { border-color: var(--accent); background: var(--accent-tint); color: var(--accent-ink); }
    .st-jabatan input:checked + label::before { border-color: var(--accent); box-shadow: inset 0 0 0 3px var(--glass-solid); background: var(--accent); }
    .st-jabatan input:focus-visible + label { box-shadow: var(--shadow-focus); }

    /* Keamanan */
    .st-pwd summary { display: inline-flex; align-items: center; gap: var(--space-2); cursor: pointer; list-style: none; }
    .st-pwd summary::-webkit-details-marker { display: none; }
    .st-pwd[open] summary { margin-bottom: var(--space-4); }
</style>

<x-island-navbar />

@php
    $inisial = strtoupper(substr($user->nama_panggilan ?: $user->name, 0, 2));
    $jabatanList = [
        'Pengasuh Madya', 'Pengasuh Muda', 'Pengasuh Satria', 'Pengasuh Pratama', 'Pengasuh Operasi',
        'Pengasuh Administrasi dan Logistik (MINLOG)', 'Pengasuh Pengamanan',
    ];
    $jabatanSekarang = old('jabatan', $user->jabatan);
    // Jabatan di luar daftar (mis. diisi dari Manajemen Akun) tetap ditampilkan agar tidak terhapus saat menyimpan
    if ($jabatanSekarang && !in_array($jabatanSekarang, $jabatanList)) {
        $jabatanList[] = $jabatanSekarang;
    }
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Setting Sistem" icon="fa-sliders"
            subtitle="Profil, foto, jabatan, dan keamanan akun Anda" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Perubahan belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="st-grid">
                {{-- Kiri: kartu profil + foto --}}
                <div class="form-card st-profil">
                    <div class="st-foto" id="stFoto">
                        @if($user->foto)
                        <img src="{{ Storage::url($user->foto) }}" alt="Foto profil {{ $user->name }}">
                        @else
                        <span>{{ $inisial }}</span>
                        @endif
                    </div>
                    <div class="st-profil__nama">{{ $user->name }}</div>
                    <div class="st-profil__meta">{{ $user->email }}</div>
                    <div class="st-profil__badge">
                        <span class="ds-badge ds-badge--accent"><i class="fa-solid fa-crown"></i> {{ $user->role_label }}</span>
                        @if($user->jabatan)<span class="ds-badge">{{ $user->jabatan }}</span>@endif
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="stFotoInput">{{ $user->foto ? 'Ganti Foto' : 'Upload Foto' }} <span class="st-opt">(opsional)</span></label>
                        <input type="file" id="stFotoInput" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <small class="form-help"><i class="fa-solid fa-circle-info"></i> JPG, PNG, WEBP · maks. 2MB · tampil di navbar & header.</small>
                        @error('foto')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Kanan: data profil, jabatan, keamanan --}}
                <div class="st-kolom">
                    <div class="form-card">
                        <div class="form-section-title"><span><i class="fa-solid fa-user me-2" style="color:var(--accent)"></i> Informasi Profil</span></div>
                        <div class="form-group">
                            <label class="form-label" for="stNama">Nama Lengkap <span class="req">*</span></label>
                            <input type="text" id="stNama" name="name" class="form-control" value="{{ old('name', $user->name) }}" maxlength="255" required>
                            @error('name')<div class="ds-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="stUsername">Username <span class="st-opt">(opsional)</span></label>
                                <input type="text" id="stUsername" name="username" class="form-control" value="{{ old('username', $user->username) }}" placeholder="username" maxlength="100">
                                @error('username')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="stPanggilan">Nama Panggilan <span class="st-opt">(opsional)</span></label>
                                <input type="text" id="stPanggilan" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', $user->nama_panggilan) }}" placeholder="Nama yang biasa dipanggil" maxlength="100">
                                @error('nama_panggilan')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group" style="margin-bottom:0">
                                <label class="form-label" for="stEmail">Email <span class="req">*</span></label>
                                <input type="email" id="stEmail" name="email" class="form-control" value="{{ old('email', $user->email) }}" maxlength="255" required>
                                @error('email')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 form-group" style="margin-bottom:0">
                                <label class="form-label" for="stTelepon">Nomor Telepon <span class="st-opt">(opsional)</span></label>
                                <input type="tel" id="stTelepon" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="08xxxxxxxxxx" maxlength="20">
                                @error('no_telepon')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="form-section-title"><span><i class="fa-solid fa-id-badge me-2" style="color:var(--accent)"></i> Jabatan</span></div>
                        <div class="st-jabatan" role="radiogroup" aria-label="Jabatan">
                            @foreach($jabatanList as $jab)
                            <div>
                                <input type="radio" name="jabatan" id="jab-{{ $loop->index }}" value="{{ $jab }}" @checked($jabatanSekarang === $jab)>
                                <label for="jab-{{ $loop->index }}">{{ $jab }}</label>
                            </div>
                            @endforeach
                        </div>
                        @error('jabatan')<div class="ds-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-card">
                        <details class="st-pwd" @if($errors->has('password')) open @endif>
                            <summary class="ds-btn ds-btn--sm ds-btn--pill"><i class="fa-solid fa-key"></i> Ubah Password</summary>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label" for="stPwd">Password Baru</label>
                                    <input type="password" id="stPwd" name="password" class="form-control" placeholder="Minimal 8 karakter" autocomplete="new-password">
                                    @error('password')<div class="ds-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label" for="stPwd2">Konfirmasi Password</label>
                                    <input type="password" id="stPwd2" name="password_confirmation" class="form-control" placeholder="Ulangi password baru" autocomplete="new-password">
                                </div>
                            </div>
                            <small class="form-help" style="margin-top:-8px"><i class="fa-solid fa-circle-info"></i> Biarkan kosong jika tidak ingin mengubah password.</small>
                        </details>
                    </div>

                    <button type="submit" class="btn-submit-log"><i class="fa-solid fa-floppy-disk"></i> SIMPAN PERUBAHAN</button>
                </div>
            </div>
        </form>

    </div>
</main>

<script>
// Pratinjau foto profil sebelum diunggah
document.getElementById('stFotoInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const img = Object.assign(document.createElement('img'), { src: URL.createObjectURL(file), alt: 'Pratinjau foto profil' });
    document.getElementById('stFoto').replaceChildren(img);
});
</script>
</x-app-layout>
