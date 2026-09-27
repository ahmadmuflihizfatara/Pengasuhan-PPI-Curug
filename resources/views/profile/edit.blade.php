<x-app-layout>
{{-- Form memakai gaya yang sama dengan form Log Gerbang, Surat & Reward --}}
<x-form-glass-style />
@php
    $isTaruna  = $user->hasTarunaAccess();
    $mahasiswa = $isTaruna ? $user->mahasiswa : null;
@endphp
<style>
    [x-cloak] { display: none !important; }
    .form-group .ds-error { font-size: 11px; }
    .form-card + .form-card { margin-top: var(--space-4); }
    .pf-simpan { width: auto; padding-left: var(--space-8, 32px); padding-right: var(--space-8, 32px); }
    .pf-aksi { display: flex; align-items: center; gap: var(--space-3); flex-wrap: wrap; }
    .pf-tersimpan { font-size: 12px; font-weight: 700; color: var(--success-ink); }

    /* Kartu identitas */
    .pf-id { text-align: center; }
    .pf-avatar {
        width: 84px; height: 84px; margin: var(--space-1) auto var(--space-3); border-radius: var(--radius-lg);
        display: grid; place-items: center; font-size: 34px; font-weight: 900; color: #0f172a;
        background: linear-gradient(135deg, #fbbf24, #d97706); box-shadow: var(--shadow-glass);
    }
    .pf-nama { margin: 0; font-size: 17px; line-height: 24px; font-weight: 900; color: var(--ink-900); overflow-wrap: anywhere; }
    .pf-email { margin: 2px 0 var(--space-2-5); font-size: 12px; line-height: 16px; font-weight: 600; color: var(--ink-600); overflow-wrap: anywhere; }
    .pf-data { margin: var(--space-4) 0 0; padding-top: var(--space-4); border-top: 1px solid var(--border-glass-subtle); display: flex; flex-direction: column; gap: var(--space-2); text-align: left; }
    .pf-data div { display: flex; justify-content: space-between; gap: var(--space-3); padding: var(--space-2-5) var(--space-3); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .pf-data dt { font-size: 10px; line-height: 16px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .pf-data dt i { width: 14px; margin-right: var(--space-1); color: var(--accent); }
    .pf-data dd { margin: 0; font-size: 12px; line-height: 16px; font-weight: 800; color: var(--ink-900); text-align: right; overflow-wrap: anywhere; }
    .pf-catatan { margin: var(--space-3) 0 0; font-size: 11px; line-height: 16px; font-weight: 500; color: var(--ink-600); text-align: left; }

    /* Zona bahaya */
    .pf-bahaya { border-color: var(--danger-border); }
    .pf-bahaya .form-section-title i { color: var(--danger); }
    .pf-bahaya__teks { margin: 0 0 var(--space-4); font-size: 12px; line-height: 18px; font-weight: 500; color: var(--ink-700); }
    .pf-btn-hapus { background: var(--danger); border-color: transparent; color: var(--ink-on-dark); }
    .pf-btn-hapus:hover { background: var(--danger-ink); }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2"
      x-data="{ hapus: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }" @keydown.escape.window="hapus = false">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Profil Saya" icon="fa-user-circle"
            subtitle="Kelola informasi akun, alamat email, dan kata sandi Anda" />

        @if(session('status') === 'profile-updated')
        <x-glass-alert type="success" title="Profil tersimpan">Informasi profil Anda berhasil diperbarui.</x-glass-alert>
        @elseif(session('status') === 'password-updated')
        <x-glass-alert type="success" title="Kata sandi diperbarui">Gunakan kata sandi baru saat masuk berikutnya.</x-glass-alert>
        @elseif(session('status') === 'verification-link-sent')
        <x-glass-alert type="success" title="Tautan verifikasi terkirim">Tautan verifikasi baru telah dikirim ke alamat email Anda.</x-glass-alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
            {{-- Kartu identitas akun --}}
            <aside class="ds-card pf-id">
                <div class="pf-avatar" aria-hidden="true">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <h2 class="pf-nama">{{ $user->name }}</h2>
                <p class="pf-email">{{ $user->email }}</p>
                <span class="ds-badge ds-badge--accent"><i class="fa-solid {{ $isTaruna ? 'fa-user-graduate' : 'fa-user-shield' }}"></i> {{ $user->role_label }}</span>

                <dl class="pf-data">
                    @if($isTaruna)
                        <div><dt><i class="fa-solid fa-id-card"></i>NIT / NPM</dt><dd>{{ $mahasiswa?->npm ?? '—' }}</dd></div>
                        <div><dt><i class="fa-solid fa-graduation-cap"></i>Program Studi</dt><dd>{{ $mahasiswa?->prodi ? $mahasiswa->prodi.' — '.(\App\Models\Mahasiswa::PRODI[$mahasiswa->prodi]['nama'] ?? '') : '—' }}</dd></div>
                        <div><dt><i class="fa-solid fa-layer-group"></i>Tingkat</dt><dd>{{ $mahasiswa?->tingkat ? 'Tingkat '.$mahasiswa->tingkat : '—' }}</dd></div>
                        @if($mahasiswa?->kelas)
                        <div><dt><i class="fa-solid fa-users"></i>Kelas</dt><dd>{{ $mahasiswa->kelas }}</dd></div>
                        @endif
                    @else
                        <div><dt><i class="fa-solid fa-user-shield"></i>Peran</dt><dd>{{ $user->role_label }}</dd></div>
                        @if($user->jabatan)
                        <div><dt><i class="fa-solid fa-briefcase"></i>Jabatan</dt><dd>{{ $user->jabatan }}</dd></div>
                        @endif
                    @endif
                    <div><dt><i class="fa-solid fa-user"></i>Nama Pengguna</dt><dd>{{ $user->username ?? '—' }}</dd></div>
                    <div><dt><i class="fa-solid fa-calendar-plus"></i>Terdaftar</dt><dd>{{ $user->created_at?->locale('id')->isoFormat('D MMMM Y') ?? '—' }}</dd></div>
                </dl>
                @if($isTaruna)
                <p class="pf-catatan"><i class="fa-solid fa-circle-info"></i> Data taruna diambil dari database mahasiswa. Hubungi pengasuh atau admin jika ada yang keliru.</p>
                @endif
            </aside>

            <div class="lg:col-span-2">
                {{-- Informasi profil --}}
                <section class="form-card">
                    <div class="form-section-title">
                        <span><i class="fa-solid fa-id-badge me-2" style="color:var(--accent)"></i> Informasi Profil</span>
                        <span class="ds-badge">Nama &amp; email</span>
                    </div>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="name">Nama Lengkap <span class="req">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autocomplete="name">
                                @error('name')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="email">Alamat Email <span class="req">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')<div class="ds-error">{{ $message }}</div>@enderror

                                @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <small class="form-help">
                                    Email Anda belum terverifikasi.
                                    <button form="send-verification" class="btn btn-link p-0 align-baseline" style="font-size:11px;">Kirim ulang email verifikasi</button>
                                </small>
                                @endif
                            </div>
                        </div>

                        <div class="pf-aksi">
                            <button type="submit" class="btn-submit-log pf-simpan"><i class="fa-solid fa-floppy-disk"></i> SIMPAN PROFIL</button>
                        </div>
                    </form>
                </section>

                {{-- Ubah kata sandi --}}
                <section class="form-card">
                    <div class="form-section-title">
                        <span><i class="fa-solid fa-key me-2" style="color:var(--accent)"></i> Ubah Kata Sandi</span>
                        <span class="ds-badge">Minimal 8 karakter</span>
                    </div>

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label class="form-label" for="current_password">Kata Sandi Saat Ini <span class="req">*</span></label>
                            <input type="password" id="current_password" name="current_password" class="form-control" autocomplete="current-password">
                            @error('current_password', 'updatePassword')<div class="ds-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="password">Kata Sandi Baru <span class="req">*</span></label>
                                <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                                @error('password', 'updatePassword')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="password_confirmation">Ulangi Kata Sandi Baru <span class="req">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                                @error('password_confirmation', 'updatePassword')<div class="ds-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <small class="form-help mb-3 d-block"><i class="fa-solid fa-shield-halved"></i> Gunakan kata sandi yang panjang dan acak agar akun Anda tetap aman.</small>

                        <div class="pf-aksi">
                            <button type="submit" class="btn-submit-log pf-simpan"><i class="fa-solid fa-key"></i> SIMPAN KATA SANDI</button>
                        </div>
                    </form>
                </section>

                {{-- Hapus akun --}}
                <section class="form-card pf-bahaya">
                    <div class="form-section-title">
                        <span><i class="fa-solid fa-triangle-exclamation me-2"></i> Hapus Akun</span>
                        <span class="ds-badge ds-badge--danger">Permanen</span>
                    </div>
                    <p class="pf-bahaya__teks">Setelah akun dihapus, seluruh data dan informasi di dalamnya akan terhapus permanen dan tidak dapat dikembalikan. Simpan terlebih dahulu data yang ingin Anda pertahankan.</p>
                    <button type="button" class="ds-btn pf-btn-hapus" @click="hapus = true"><i class="fa-solid fa-trash"></i> Hapus Akun</button>
                </section>
            </div>
        </div>

    </div>

    {{-- Modal konfirmasi hapus akun — di luar panel kaca agar position:fixed tidak terkurung backdrop-filter --}}
        <div class="ds-modal-overlay" x-show="hapus" x-cloak role="dialog" aria-modal="true" aria-labelledby="hapusAkunJudul" @click.self="hapus = false">
            <form method="post" action="{{ route('profile.destroy') }}" class="ds-modal" style="text-align:left;">
                @csrf
                @method('delete')
                <div class="ds-modal__icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <h3 class="ds-modal__title" id="hapusAkunJudul" style="text-align:center;">Yakin ingin menghapus akun?</h3>
                <p class="ds-modal__body" style="text-align:center;">Seluruh data akun akan terhapus permanen. Masukkan kata sandi Anda untuk mengonfirmasi.</p>

                <div class="form-group">
                    <label class="form-label" for="hapus_password">Kata Sandi <span class="req">*</span></label>
                    <input type="password" id="hapus_password" name="password" class="form-control" placeholder="Masukkan kata sandi" autocomplete="current-password" x-init="$watch('hapus', v => v && $nextTick(() => $el.focus()))">
                    @error('password', 'userDeletion')<div class="ds-error">{{ $message }}</div>@enderror
                </div>

                <div class="ds-modal__actions">
                    <button type="button" class="ds-btn" @click="hapus = false">Batal</button>
                    <button type="submit" class="ds-btn pf-btn-hapus"><i class="fa-solid fa-trash"></i> Ya, Hapus Akun</button>
                </div>
            </form>
    </div>
</main>
</x-app-layout>
