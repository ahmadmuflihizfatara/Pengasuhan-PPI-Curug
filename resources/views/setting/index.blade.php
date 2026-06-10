<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout { display: flex; min-height: 100vh; }

/* MAIN */
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; max-width: 800px; }

.page-header {
    background: linear-gradient(135deg, #3182ce 0%, #5a67d8 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
    display: flex; align-items: center; gap: 20px;
}
.page-header::before { content: ''; position: absolute; right: -50px; top: -50px; width: 180px; height: 180px; background: rgba(255,255,255,.08); border-radius: 50%; }
.page-header-avatar {
    width: 72px; height: 72px; border-radius: 50%;
    background: rgba(255,255,255,.2); border: 3px solid rgba(255,255,255,.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; font-weight: 800; color: white; flex-shrink: 0;
    overflow: hidden; position: relative; z-index: 1;
}
.page-header-avatar img { width: 100%; height: 100%; object-fit: cover; }
.page-header-text { position: relative; z-index: 1; }
.page-header-text h1 { margin: 0 0 4px 0; font-size: 20px; font-weight: 800; }
.page-header-text p { margin: 0; opacity: .85; font-size: 13px; }

.alert-success { background: linear-gradient(135deg,#43e97b,#38f9d7); color: white; padding: 13px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 13px; }
.alert-error { background: #fff0f0; border: 1px solid #fc8181; padding: 13px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; color: #e53e3e; }

/* Cards */
.section-card { background: white; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,.06); margin-bottom: 20px; overflow: hidden; }
.section-card-header { padding: 16px 24px; border-bottom: 1px solid #f0f2f7; display: flex; align-items: center; gap: 12px; }
.section-card-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px; color: white; flex-shrink: 0; }
.section-card-header h3 { margin: 0; font-size: 14px; font-weight: 700; color: #333; }
.section-card-body { padding: 24px; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { }
.form-group.full { grid-column: span 2; }
.form-label { display: block; font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 7px; }
.form-control { width: 100%; padding: 11px 14px; border: 2px solid #edf0f7; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; color: #333; background: #fafbff; outline: none; transition: border .15s; }
.form-control:focus { border-color: #667eea; background: white; }
select.form-control { cursor: pointer; }

/* Foto upload */
.foto-upload-area {
    border: 2px dashed #d0d5ed;
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    cursor: pointer;
    transition: all .15s;
    background: #fafbff;
    position: relative;
}
.foto-upload-area:hover { border-color: #667eea; background: #f0f0ff; }
.foto-upload-area input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.foto-preview-wrap { display: flex; align-items: center; gap: 20px; }
.foto-preview { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #edf0f7; background: #edf0f7; flex-shrink: 0; }
.foto-preview-placeholder { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 800; color: white; flex-shrink: 0; }
.foto-upload-info { text-align: left; }
.foto-upload-info strong { display: block; font-size: 13px; font-weight: 700; color: #333; margin-bottom: 3px; }
.foto-upload-info span { font-size: 12px; color: #999; }
.foto-upload-hint { margin-top: 12px; font-size: 11px; color: #bbb; }

/* Password section */
.pwd-toggle { font-size: 12px; font-weight: 600; color: #667eea; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; margin-bottom: 16px; background: #eef0ff; padding: 6px 14px; border-radius: 8px; border: none; }
.pwd-section { display: none; }
.pwd-section.open { display: block; }

/* Jabatan */
.jabatan-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
.jabatan-option { position: relative; }
.jabatan-option input { position: absolute; opacity: 0; width: 0; }
.jabatan-label {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 14px; border: 2px solid #edf0f7;
    border-radius: 10px; cursor: pointer; font-size: 13px;
    font-weight: 500; color: #555; transition: all .12s;
    background: #fafbff;
}
.jabatan-label:hover { border-color: #667eea; background: #f0f0ff; }
.jabatan-option input:checked + .jabatan-label {
    border-color: #667eea;
    background: linear-gradient(135deg, #eef0ff, #f0f0ff);
    color: #5a67d8;
    font-weight: 700;
}
.jabatan-dot { width: 10px; height: 10px; border-radius: 50%; background: #ddd; flex-shrink: 0; transition: background .12s; }
.jabatan-option input:checked + .jabatan-label .jabatan-dot { background: #667eea; }

/* Buttons */
.btn-row { display: flex; gap: 12px; justify-content: flex-end; margin-top: 4px; }
.btn-save { background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; padding: 12px 30px; border-radius: 25px; font-size: 13px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(102,126,234,.4); transition: opacity .15s; }
.btn-save:hover { opacity: .9; }
</style>

<div class="app-layout">
    <!-- SIDEBAR -->
    <x-sidebar active="setting" />

    <!-- MAIN -->
    <div class="main-content">

        <!-- Header -->
        <div class="page-header">
            <div class="page-header-avatar" id="headerAvatar">
                @if($user->foto)
                    <img src="{{ Storage::url($user->foto) }}" alt="Foto Profil" id="headerAvatarImg">
                @else
                    <span id="headerAvatarInitial">{{ strtoupper(substr($user->nama_panggilan ?: $user->name, 0, 2)) }}</span>
                @endif
            </div>
            <div class="page-header-text">
                <h1>{{ $user->name }}</h1>
                <p>
                    @if($user->jabatan) <strong>{{ $user->jabatan }}</strong> &bull; @endif
                    {{ $user->email }}
                </p>
            </div>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:17px;"></i> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-triangle" style="margin-right:8px;"></i>
            @foreach($errors->all() as $err) {{ $err }}<br> @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- PROFIL DASAR -->
            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-icon" style="background:linear-gradient(135deg,#667eea,#764ba2);">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3>Informasi Profil</h3>
                </div>
                <div class="section-card-body">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label class="form-label">Nama Lengkap <span style="color:#e53e3e;">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="form-control" placeholder="Nama lengkap pengasuh">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                   class="form-control" placeholder="username">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Panggilan</label>
                            <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan', $user->nama_panggilan) }}"
                                   class="form-control" placeholder="Nama yang biasa dipanggil">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email <span style="color:#e53e3e;">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}"
                                   class="form-control" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOTO PROFIL -->
            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-icon" style="background:linear-gradient(135deg,#38b2ac,#319795);">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h3>Foto Profil</h3>
                </div>
                <div class="section-card-body">
                    <div class="foto-upload-area" id="fotoUploadArea">
                        <input type="file" name="foto" accept="image/*" id="fotoInput" onchange="previewFoto(this)">
                        <div class="foto-preview-wrap">
                            @if($user->foto)
                            <img src="{{ Storage::url($user->foto) }}" alt="Foto" class="foto-preview" id="fotoPreview">
                            @else
                            <div class="foto-preview-placeholder" id="fotoPreviewPlaceholder">
                                {{ strtoupper(substr($user->nama_panggilan ?: $user->name, 0, 2)) }}
                            </div>
                            <img src="" alt="" class="foto-preview" id="fotoPreview" style="display:none;">
                            @endif
                            <div class="foto-upload-info">
                                <strong>Klik untuk upload foto</strong>
                                <span>atau drag & drop gambar ke sini</span>
                                <div style="margin-top:8px;">
                                    <span style="background:#eef0ff; color:#667eea; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; display:inline-block;">
                                        <i class="fas fa-image"></i> JPG, PNG, WEBP maks. 2MB
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="foto-upload-hint"><i class="fas fa-info-circle"></i> Foto akan ditampilkan di sidebar dan header profil</p>
                    </div>
                </div>
            </div>

            <!-- JABATAN -->
            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-icon" style="background:linear-gradient(135deg,#ed8936,#dd6b20);">
                        <i class="fas fa-id-badge"></i>
                    </div>
                    <h3>Jabatan</h3>
                </div>
                <div class="section-card-body">
                    <div class="jabatan-grid">
                        @php
                        $jabatanList = [
                            'Pengasuh Madya',
                            'Pengasuh Muda',
                            'Pengasuh Satria',
                            'Pengasuh Pratama',
                            'Pengasuh Operasi',
                            'Pengasuh Administrasi dan Logistik (MINLOG)',
                            'Pengasuh Pengamanan',
                        ];
                        @endphp
                        @foreach($jabatanList as $jab)
                        <div class="jabatan-option">
                            <input type="radio" name="jabatan" id="jab_{{ $loop->index }}"
                                   value="{{ $jab }}"
                                   {{ old('jabatan', $user->jabatan) === $jab ? 'checked' : '' }}>
                            <label class="jabatan-label" for="jab_{{ $loop->index }}">
                                <span class="jabatan-dot"></span>
                                {{ $jab }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="jabatan" id="jabatanHidden" value="{{ old('jabatan', $user->jabatan) }}">
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="section-card">
                <div class="section-card-header">
                    <div class="section-card-icon" style="background:linear-gradient(135deg,#e53e3e,#fc8181);">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Keamanan</h3>
                </div>
                <div class="section-card-body">
                    <button type="button" class="pwd-toggle" onclick="togglePwd()">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                    <div class="pwd-section" id="pwdSection">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="Minimal 8 karakter" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="Ulangi password baru" autocomplete="new-password">
                            </div>
                        </div>
                        <p style="font-size:12px; color:#aab; margin:8px 0 0 0;">
                            <i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengubah password
                        </p>
                    </div>
                </div>
            </div>

            <!-- SAVE -->
            <div class="btn-row">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
// Preview foto
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('fotoPreview');
            const placeholder = document.getElementById('fotoPreviewPlaceholder');
            if (placeholder) placeholder.style.display = 'none';
            preview.src = e.target.result;
            preview.style.display = 'block';

            // Update header avatar
            const headerImg = document.getElementById('headerAvatarImg');
            const headerInitial = document.getElementById('headerAvatarInitial');
            if (headerImg) {
                headerImg.src = e.target.result;
            } else if (headerInitial) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.id = 'headerAvatarImg';
                img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
                headerInitial.replaceWith(img);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Toggle password
function togglePwd() {
    const section = document.getElementById('pwdSection');
    section.classList.toggle('open');
}

// Jabatan radio harus override hidden input
document.querySelectorAll('input[type="radio"][name="jabatan"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('jabatanHidden').value = this.value;
        // remove hidden so radio takes over
        document.getElementById('jabatanHidden').disabled = true;
    });
});
// Kalau sudah ada jabatan, disable hidden
if (document.querySelector('input[type="radio"][name="jabatan"]:checked')) {
    document.getElementById('jabatanHidden').disabled = true;
}
</script>
</x-app-layout>
