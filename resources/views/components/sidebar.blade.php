{{--
    Komponen Sidebar Reusable
    Penggunaan: <x-sidebar active="dashboard" />
    Nilai $active: 'dashboard' | 'berita' | 'surat' | 'acara' | 'poin' | 'mahasiswa' | 'activity-log' | 'profile' | 'users' | 'setting'
--}}
@php
    $user         = Auth::user();
    $avatarColors = ['#667eea','#764ba2','#f093fb','#f5576c','#38a169','#e07020','#3182ce','#d53f8c'];
@endphp

<style>
/* ============================================================
   SIDEBAR — reset semua konflik Bootstrap & py-4
   ============================================================ */
.sidebar {
    width: 240px;
    min-width: 240px;
    background: #fff;
    border-right: 1px solid #edf0f7;
    min-height: 100vh;
    padding: 24px 14px 32px;
    flex-shrink: 0;
    position: sticky;
    top: 0;
    align-self: flex-start;
    max-height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
}
.sidebar::-webkit-scrollbar       { width: 3px; }
.sidebar::-webkit-scrollbar-thumb { background: #c5c8e0; border-radius: 4px; }

/* Logo */
.sb-logo {
    font-size: 17px; font-weight: 700; color: #5a67d8;
    text-decoration: none; display: flex; align-items: center;
    gap: 9px; margin-bottom: 28px; padding: 0 4px;
}
.sb-logo-icon {
    width: 32px; height: 32px; border-radius: 9px;
    background: linear-gradient(135deg,#667eea,#764ba2);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 14px; flex-shrink: 0;
}

/* Section label */
.sb-label {
    font-size: 9px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .1em; color: #b0b4c8;
    margin: 0 0 6px 4px; display: block;
}

/* Nav */
.sb-nav { list-style: none; padding: 0; margin: 0 0 4px 0; }
.sb-nav li { margin-bottom: 1px; }
.sb-nav a {
    display: flex; align-items: center; gap: 9px;
    padding: 9px 11px; border-radius: 9px;
    text-decoration: none; font-size: 13px; font-weight: 500;
    color: #4a5068; transition: background .12s, color .12s;
    white-space: nowrap;
}
.sb-nav a .nav-icon {
    width: 18px; text-align: center; font-size: 13px;
    color: #9aa0bc; flex-shrink: 0; transition: color .12s;
}
.sb-nav a:hover              { background: #f0f1fb; color: #5a67d8; }
.sb-nav a:hover .nav-icon    { color: #5a67d8; }
.sb-nav a.active             { background: linear-gradient(135deg,#667eea,#764ba2); color: #fff; font-weight: 600; }
.sb-nav a.active .nav-icon   { color: #fff; }

/* Divider */
.sb-divider { border: none; border-top: 1px solid #edf0f7; margin: 12px 0; }

/* Logout */
.sb-nav a.logout-link             { color: #e05252; }
.sb-nav a.logout-link .nav-icon   { color: #e05252; }
.sb-nav a.logout-link:hover       { background: #fff0f0; color: #c53030; }

/* Mahasiswa quick-list */
.mhs-search            { position: relative; margin-bottom: 8px; }
.mhs-search .fa-search { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 11px; pointer-events: none; }
.mhs-search input {
    width: 100%; padding: 7px 10px 7px 28px;
    border: 1.5px solid #edf0f7; border-radius: 8px;
    font-size: 12px; font-family: 'Inter',sans-serif;
    outline: none; color: #444; background: #fafbff;
    transition: border-color .15s;
}
.mhs-search input:focus { border-color: #667eea; }

.mhs-list { list-style: none; padding: 0; margin: 0; max-height: 200px; overflow-y: auto; }
.mhs-list::-webkit-scrollbar       { width: 3px; }
.mhs-list::-webkit-scrollbar-thumb { background: #c5c8e0; border-radius: 4px; }

.mhs-item {
    display: flex; align-items: center; gap: 8px;
    padding: 5px 4px; border-radius: 8px;
    cursor: pointer; transition: background .1s;
    text-decoration: none;
}
.mhs-item:hover { background: #f4f5fb; }

.mhs-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; color: white; font-size: 10px; font-weight: 700;
}
.mhs-name  { font-weight: 600; color: #333; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.mhs-kelas { font-size: 10px; color: #9aa0bc; }

.view-all-link {
    display: block; text-align: center;
    font-size: 11px; color: #667eea; font-weight: 600;
    text-decoration: none; margin-top: 8px; padding: 4px;
}
.view-all-link:hover { text-decoration: underline; }
</style>

<aside class="sidebar">

    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="sb-logo">
        <div class="sb-logo-icon"><i class="fas fa-graduation-cap"></i></div>
        Pengasuhan
    </a>

    {{-- ── MENU ── --}}
    <span class="sb-label">Menu</span>
    <ul class="sb-nav">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ $active==='dashboard'?'active':'' }}">
                <i class="fas fa-th-large nav-icon"></i> Dashboard
            </a>
        </li>

        {{-- Berita Taruna — semua role bisa akses --}}
        <li>
            <a href="{{ route('berita.index') }}" class="{{ $active==='berita'?'active':'' }}">
                <i class="fas fa-newspaper nav-icon"></i> Berita Taruna
            </a>
        </li>

        @if($user->isTaruna())
            <li>
                <a href="{{ route('acara.index') }}" class="{{ $active==='acara'?'active':'' }}">
                    <i class="fas fa-calendar-alt nav-icon"></i> Acara
                </a>
            </li>
            <li>
                <a href="{{ route('poin.index') }}" class="{{ $active==='poin'?'active':'' }}">
                    <i class="fas fa-star nav-icon"></i> Raport Poin
                </a>
            </li>
            <li>
                <a href="{{ route('surat-taruna.index') }}" class="{{ $active==='surat-taruna'?'active':'' }}">
                    <i class="fas fa-file-signature nav-icon"></i> Pengajuan Surat
                    @php
                        $unreadSurat = \App\Models\Surat::where('user_id', auth()->id())
                            ->where('taruna_baca', false)
                            ->whereIn('status', ['Disetujui', 'Ditolak'])
                            ->count();
                    @endphp
                    @if($unreadSurat > 0)
                    <span style="background:#e53e3e; color:white; border-radius:50%; width:17px; height:17px; font-size:10px; font-weight:800; display:inline-flex; align-items:center; justify-content:center; margin-left:auto;">{{ $unreadSurat }}</span>
                    @endif
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('surat.index') }}" class="{{ $active==='surat'?'active':'' }}">
                    <i class="fas fa-envelope-open-text nav-icon"></i> Administrasi Surat
                </a>
            </li>
            <li>
                <a href="{{ route('acara.index') }}" class="{{ $active==='acara'?'active':'' }}">
                    <i class="fas fa-calendar-alt nav-icon"></i> Acara
                </a>
            </li>
            <li>
                <a href="{{ route('poin.index') }}" class="{{ $active==='poin'?'active':'' }}">
                    <i class="fas fa-star nav-icon"></i> POIN
                </a>
            </li>
            @if($user->canManageSystem())
            <li>
                <a href="{{ route('mahasiswa.index') }}" class="{{ $active==='mahasiswa'?'active':'' }}">
                    <i class="fas fa-users nav-icon"></i> Database Mahasiswa
                </a>
            </li>
            @endif
        @endif
    </ul>

    {{-- ── PENYELENGGARA (Log Aktivitas) — hanya muncul jika canManageSystem ── --}}
    @if($user->canManageSystem())
    <hr class="sb-divider">
    <span class="sb-label">Penyelenggara</span>
    <ul class="sb-nav">
        <li>
            <a href="{{ route('activity-log.index') }}" class="{{ $active==='activity-log'?'active':'' }}">
                <i class="fas fa-history nav-icon"></i> Log Aktivitas
            </a>
        </li>
    </ul>
    @endif

    {{-- ── MAHASISWA QUICK LIST — hanya pengasuh & penyelenggara ── --}}
    @if(!$user->isTaruna())
    <hr class="sb-divider">
    <span class="sb-label">Mahasiswa</span>
    <div class="mhs-search">
        <i class="fas fa-search"></i>
        <input type="text" id="sbSearchInput" placeholder="Cari nama..." oninput="sbFilter()">
    </div>
    <ul class="mhs-list" id="sbMhsList">
        @php
            $allMhs  = \App\Http\Controllers\MahasiswaController::getAllMahasiswa();
            $flatMhs = [];
            foreach ($allMhs as $kls => $arr) {
                foreach ($arr as $m) { $flatMhs[] = array_merge($m, ['kelas' => $kls]); }
            }
            $ci = 0;
        @endphp
        @foreach($flatMhs as $mhs)
        <li class="mhs-item sb-mhs-item"
            data-search="{{ strtolower($mhs['nama']).' '.strtolower($mhs['nickname'] ?? '') }}">
            <div class="mhs-avatar" style="background:{{ $avatarColors[$ci % count($avatarColors)] }};">
                {{ strtoupper(substr($mhs['nickname'] ?? $mhs['nama'], 0, 2)) }}
            </div>
            <div style="flex:1;min-width:0;">
                <div class="mhs-name">{{ $mhs['nickname'] ?? $mhs['nama'] }}</div>
                <div class="mhs-kelas">{{ $mhs['kelas'] }}</div>
            </div>
        </li>
        @php $ci++; @endphp
        @endforeach
    </ul>
    <a href="{{ route('mahasiswa.index') }}" class="view-all-link">
        Lihat semua {{ count($flatMhs) }} mahasiswa →
    </a>
    @endif

    {{-- ── PENGATURAN ── --}}
    <hr class="sb-divider">
    <span class="sb-label">Pengaturan</span>
    <ul class="sb-nav">
        @if(!$user->isTaruna())
        <li>
            <a href="{{ route('profile.edit') }}" class="{{ $active==='profile'?'active':'' }}">
                <i class="fas fa-user-circle nav-icon"></i> Profil Saya
            </a>
        </li>
        @endif
        @if($user->canManageSystem())
        <li>
            <a href="{{ route('users.index') }}" class="{{ $active==='users'?'active':'' }}">
                <i class="fas fa-user-shield nav-icon"></i> Manajemen Akun
            </a>
        </li>
        <li>
            <a href="{{ route('setting.index') }}" class="{{ $active==='setting'?'active':'' }}">
                <i class="fas fa-cog nav-icon"></i> Setting
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('logout') }}" class="logout-link"
               onclick="event.preventDefault();document.getElementById('sb-logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i> Logout
            </a>
            <form id="sb-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </li>
    </ul>

</aside>
<script>
function sbFilter() {
    const q = document.getElementById('sbSearchInput').value.toLowerCase().trim();
    document.querySelectorAll('.sb-mhs-item').forEach(function(li) {
        li.style.display = (li.dataset.search || '').includes(q) ? 'flex' : 'none';
    });
}
</script>
