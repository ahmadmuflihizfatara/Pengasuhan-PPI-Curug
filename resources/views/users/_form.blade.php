{{-- Form akun (tambah & ubah). $user = null untuk tambah. Gaya dari <x-form-glass-style /> --}}
@php
    $isEdit = (bool) $user;
    $peran  = [
        'taruna'   => ['Taruna', 'fa-user-graduate', 'Hanya dapat melihat dashboard, raport poin, dan fitur pengajuan miliknya.'],
        'pengasuh' => ['Pengasuh', 'fa-chalkboard-user', 'Mengelola kegiatan, poin, acara, dan administrasi surat. Tidak dapat mengakses manajemen akun & setting sistem.'],
        'admin'    => ['Admin', 'fa-crown', 'Akses penuh termasuk manajemen akun, hak akses, dan konfigurasi sistem.'],
    ];
    $peranDipilih = old('role', $user?->role);
@endphp
<style>
    .us-opt { color: var(--ink-500); font-weight: 600; text-transform: none; letter-spacing: 0; }
    .form-group .ds-error { font-size: 11px; }
    .us-sub { display: flex; align-items: center; gap: var(--space-2); margin: var(--space-2) 0 var(--space-3); padding-top: var(--space-4); border-top: 1px solid var(--border-glass-subtle); font-size: 12px; line-height: 16px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: var(--ink-700); }
    .us-sub i { color: var(--accent); }

    /* Pilihan role — radio bergaya kartu */
    .us-peran { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-2-5); }
    @media (max-width: 720px) { .us-peran { grid-template-columns: 1fr; } }
    .us-peran input { position: absolute; opacity: 0; pointer-events: none; }
    .us-peran label { display: flex; flex-direction: column; gap: var(--space-1); height: 100%; padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1.5px solid var(--border-glass-glow); cursor: pointer; transition: background-color .15s, border-color .15s, box-shadow .15s; }
    .us-peran label:hover { background: var(--glass-solid); }
    .us-peran b { display: flex; align-items: center; gap: var(--space-2); font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
    .us-peran b i { color: var(--accent); }
    .us-peran small { font-size: 11px; line-height: 15px; font-weight: 500; color: var(--ink-600); }
    .us-peran input:checked + label { border-color: var(--accent); background: var(--accent-tint); box-shadow: 0 0 0 3px var(--focus-ring-glow); }
    .us-peran input:focus-visible + label { box-shadow: var(--shadow-focus); }

    .us-tombol { display: flex; gap: var(--space-2-5); margin-top: var(--space-2); }
    .us-tombol .btn-submit-log { flex: 1; }
    .us-tombol .ds-btn { padding-left: var(--space-5); padding-right: var(--space-5); }
</style>

<div class="form-card">
    <form method="POST" action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="form-section-title">
            <span><i class="fa-solid {{ $isEdit ? 'fa-user-pen' : 'fa-user-plus' }} me-2" style="color:var(--accent)"></i> {{ $isEdit ? 'Ubah Data Akun' : 'Data Akun Baru' }}</span>
            @if($isEdit)
            <span class="ds-badge ds-badge--accent"><i class="fa-regular fa-clock"></i> Dibuat {{ $user->created_at?->locale('id')->isoFormat('D MMM Y') ?? '—' }}</span>
            @endif
        </div>

        <h3 class="us-sub" style="margin-top:0; padding-top:0; border-top:0"><i class="fa-solid fa-id-card"></i> Identitas</h3>
        <div class="form-group">
            <label class="form-label" for="usNama">Nama Lengkap <span class="req">*</span></label>
            <input type="text" id="usNama" name="name" class="form-control" value="{{ old('name', $user?->name) }}" placeholder="Masukkan nama lengkap" maxlength="255" required>
            @error('name')<div class="ds-error">{{ $message }}</div>@enderror
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="form-label" for="usEmail">Email <span class="req">*</span></label>
                <input type="email" id="usEmail" name="email" class="form-control" value="{{ old('email', $user?->email) }}" placeholder="email@poltekssn.ac.id" maxlength="255" required>
                @error('email')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="usUsername">Username <span class="us-opt">(opsional)</span></label>
                <input type="text" id="usUsername" name="username" class="form-control" value="{{ old('username', $user?->username) }}" placeholder="username" maxlength="100">
                @error('username')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="form-label" for="usJabatan">Jabatan <span class="us-opt">(opsional)</span></label>
                <input type="text" id="usJabatan" name="jabatan" class="form-control" value="{{ old('jabatan', $user?->jabatan) }}" placeholder="Contoh: Pengasuh Jaga" maxlength="100">
                @error('jabatan')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="usProdi">Prodi <span class="us-opt">(opsional)</span></label>
                <input type="text" id="usProdi" name="prodi" class="form-control" value="{{ old('prodi', $user?->prodi) }}" placeholder="Program studi" maxlength="100">
                @error('prodi')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <h3 class="us-sub"><i class="fa-solid fa-user-shield"></i> Role <span class="req">*</span></h3>
        <div class="form-group">
            <div class="us-peran" role="radiogroup" aria-label="Role akun">
                @foreach($peran as $kode => [$label, $ikon, $ket])
                <div>
                    <input type="radio" name="role" id="peran-{{ $kode }}" value="{{ $kode }}" @checked($peranDipilih === $kode) required>
                    <label for="peran-{{ $kode }}"><b><i class="fa-solid {{ $ikon }}"></i> {{ $label }}</b><small>{{ $ket }}</small></label>
                </div>
                @endforeach
            </div>
            @error('role')<div class="ds-error">{{ $message }}</div>@enderror
        </div>

        <h3 class="us-sub"><i class="fa-solid fa-lock"></i> {{ $isEdit ? 'Ganti Password' : 'Password' }}</h3>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="form-label" for="usPassword">{{ $isEdit ? 'Password Baru' : 'Password' }} @if(!$isEdit)<span class="req">*</span>@else<span class="us-opt">(opsional)</span>@endif</label>
                <input type="password" id="usPassword" name="password" class="form-control" autocomplete="new-password"
                       placeholder="{{ $isEdit ? 'Kosongkan jika tidak diubah' : 'Min. 8 karakter' }}" @unless($isEdit) required @endunless>
                @error('password')<div class="ds-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label" for="usPassword2">Konfirmasi Password @unless($isEdit)<span class="req">*</span>@endunless</label>
                <input type="password" id="usPassword2" name="password_confirmation" class="form-control" autocomplete="new-password"
                       placeholder="Ulangi password" @unless($isEdit) required @endunless>
            </div>
        </div>
        @if($isEdit)
        <small class="form-help" style="margin:-8px 0 var(--space-4)"><i class="fa-solid fa-circle-info"></i> Kosongkan kedua kolom password bila tidak ingin mengubahnya.</small>
        @endif

        <div class="us-tombol">
            <a href="{{ route('users.index') }}" class="ds-btn"><i class="fa-solid fa-xmark"></i> Batal</a>
            <button type="submit" class="btn-submit-log"><i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'SIMPAN PERUBAHAN' : 'SIMPAN AKUN' }}</button>
        </div>
    </form>
</div>
