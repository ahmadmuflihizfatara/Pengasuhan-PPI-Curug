<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px; display: flex; align-items: center; justify-content: center; }

.form-card { background: white; border-radius: 20px; padding: 36px; box-shadow: 0 4px 24px rgba(0,0,0,.08); width: 100%; max-width: 520px; }
.form-title { font-size: 20px; font-weight: 800; color: #333; margin: 0 0 6px 0; }
.form-subtitle { font-size: 13px; color: #888; margin: 0 0 28px 0; }

.form-group { margin-bottom: 18px; }
.form-label { display: block; font-size: 12px; font-weight: 700; color: #555; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .05em; }
.form-control { width: 100%; padding: 11px 14px; border: 1.5px solid #e8eaf0; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; color: #333; outline: none; transition: border-color .15s; }
.form-control:focus { border-color: #667eea; }
.form-control.is-invalid { border-color: #e05252; }
.invalid-feedback { font-size: 11px; color: #e05252; margin-top: 4px; }

.role-select { position: relative; }
.role-select select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; padding-right: 36px; cursor: pointer; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.btn-group { display: flex; gap: 12px; margin-top: 24px; }
.btn-primary { background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; padding: 12px 24px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all .15s; flex: 1; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102,126,234,.35); }
.btn-secondary { background: #f0f2f5; color: #555; border: none; padding: 12px 24px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: flex; align-items: center; justify-content: center; transition: all .15s; }
.btn-secondary:hover { background: #e2e5ee; color: #333; }

/* Role color indicators */
.role-taruna        { background: #f0fff4; border-left: 4px solid #38a169; }
.role-pengasuh      { background: #ebf4ff; border-left: 4px solid #3182ce; }
.role-admin { background: #f3eeff; border-left: 4px solid #764ba2; }
.role-desc { font-size: 11px; color: #666; padding: 10px 14px; border-radius: 8px; margin-top: 8px; line-height: 1.5; }
</style>

<div class="app-layout">
    <x-sidebar active="users" />

    <div class="main-content">
        <div class="form-card">
            <h1 class="form-title"><i class="fas fa-user-plus" style="color:#764ba2; margin-right:10px;"></i>Tambah Akun</h1>
            <p class="form-subtitle">Buat akun baru untuk Taruna, Pengasuh, atau Admin</p>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama lengkap" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                               class="form-control @error('username') is-invalid @enderror"
                               placeholder="username">
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                               class="form-control @error('jabatan') is-invalid @enderror"
                               placeholder="Jabatan (opsional)">
                        @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Prodi</label>
                    <input type="text" name="prodi" value="{{ old('prodi') }}"
                           class="form-control @error('prodi') is-invalid @enderror"
                           placeholder="Program studi (opsional)">
                    @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="email@poltekssn.ac.id" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role</label>
                    <div class="role-select">
                        <select name="role" id="roleSelect"
                                class="form-control @error('role') is-invalid @enderror"
                                onchange="updateRoleDesc(this.value)" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="taruna" {{ old('role') == 'taruna' ? 'selected' : '' }}>Taruna</option>
                            <option value="pengasuh" {{ old('role') == 'pengasuh' ? 'selected' : '' }}>Pengasuh</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div id="roleDesc" class="role-desc" style="display:none;"></div>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 8 karakter" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('users.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left" style="margin-right:6px;"></i>Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save" style="margin-right:6px;"></i>Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const roleDescs = {
    taruna: { cls: 'role-taruna', text: '👤 Taruna hanya dapat melihat dashboard dan raport poin pengasuhan miliknya.' },
    pengasuh: { cls: 'role-pengasuh', text: '📋 Pengasuh dapat mengelola kegiatan, poin pengasuhan, acara, dan administrasi surat. Tidak dapat mengakses manajemen akun dan setting sistem.' },
    admin: { cls: 'role-admin', text: '👑 Admin memiliki akses penuh termasuk manajemen akun taruna dan konfigurasi sistem.' },
};
function updateRoleDesc(role) {
    const el = document.getElementById('roleDesc');
    if (!role || !roleDescs[role]) { el.style.display = 'none'; return; }
    el.className = 'role-desc ' + roleDescs[role].cls;
    el.textContent = roleDescs[role].text;
    el.style.display = 'block';
}
// Trigger on page load if old value
const sel = document.getElementById('roleSelect');
if (sel && sel.value) updateRoleDesc(sel.value);
</script>
</x-app-layout>
