{{--
    Komponen Sidebar Reusable — PPI Curug Navy/Gold Theme
    Palette: Navy #12283a | Gold #fdbb11 | Light #eef3f9
--}}
@php
    $user         = Auth::user();
    $avatarColors = ['#12283a','#1a3550','#244263','#fdbb11','#e5a800','#3b5998','#4a6fa5','#2d5986'];
@endphp

<style>
.sidebar {
    width: 260px;
    min-width: 260px;
    background: #12283a;
    min-height: 100vh;
    padding: 28px 16px 32px;
    flex-shrink: 0;
    position: sticky;
    top: 0;
    align-self: flex-start;
    max-height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    border-right: 1px solid rgba(255,255,255,.06);
}
.sidebar::-webkit-scrollbar       { width: 3px; }
.sidebar::-webkit-scrollbar-thumb { background: rgba(253,187,17,.3); border-radius: 4px; }

/* Logo */
.sb-logo {
    font-size: 17px; font-weight: 700; color: #fff;
    text-decoration: none; display: flex; align-items: center;
    gap: 12px; margin-bottom: 32px; padding: 0 6px;
}
.sb-logo-icon {
    width: 38px; height: 38px; border-radius: 12px;
    background: #fdbb11;
    display: flex; align-items: center; justify-content: center;
    color: #12283a; font-size: 16px; flex-shrink: 0;
    font-weight: 800;
}
.sb-logo span { color: #fdbb11; }

/* Section label */
.sb-label {
    font-size: 9px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .12em; color: rgba(255,255,255,.3);
    margin: 0 0 8px 8px; display: block;
}

/* Nav */
.sb-nav { list-style: none; padding: 0; margin: 0 0 6px 0; }
.sb-nav li { margin-bottom: 2px; }
.sb-nav a {
    display: flex; align-items: center; gap: 11px;
    padding: 10px 13px; border-radius: 10px;
    text-decoration: none; font-size: 13px; font-weight: 500;
    color: rgba(255,255,255,.55); transition: all .15s;
    white-space: nowrap;
}
.sb-nav a .nav-icon {
    width: 18px; text-align: center; font-size: 13px;
    color: rgba(255,255,255,.3); flex-shrink: 0; transition: color .15s;
}
.sb-nav a:hover              { background: rgba(253,187,17,.08); color: rgba(255,255,255,.85); }
.sb-nav a:hover .nav-icon    { color: #fdbb11; }
.sb-nav a.active             { background: #fdbb11; color: #12283a; font-weight: 700; }
.sb-nav a.active .nav-icon   { color: #12283a; }

/* Divider */
.sb-divider { border: none; border-top: 1px solid rgba(255,255,255,.07); margin: 14px 0; }

/* Notification badge */
.sb-badge {
    background: #dc2626; color: white; border-radius: 10px;
    padding: 2px 7px; font-size: 10px; font-weight: 800;
    margin-left: auto; display: inline-flex; align-items: center;
    justify-content: center; min-width: 18px; height: 18px;
}

/* Live badge */
.sb-badge-live {
    background: rgba(16,185,129,.2); color: #34d399; border-radius: 6px;
    padding: 1px 6px; font-size: 9px; font-weight: 800;
    margin-left: auto; letter-spacing: .5px;
}

/* TV Monitoring */
.sb-nav a.tv-link             { color: #38bdf8; }
.sb-nav a.tv-link:hover       { background: rgba(56,189,248,.1); }
.sb-nav a.tv-link .nav-icon   { color: #38bdf8; }

/* Logout */
.sb-nav a.logout-link             { color: rgba(255,255,255,.35); }
.sb-nav a.logout-link .nav-icon   { color: rgba(255,255,255,.35); }
.sb-nav a.logout-link:hover       { background: rgba(220,38,38,.1); color: #f87171; }

/* Mahasiswa quick-list */
.mhs-search            { position: relative; margin-bottom: 10px; }
.mhs-search .fa-search { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,.25); font-size: 11px; pointer-events: none; }
.mhs-search input {
    width: 100%; padding: 8px 12px 8px 32px;
    border: 1px solid rgba(255,255,255,.1); border-radius: 8px;
    font-size: 12px; font-family: 'Inter',sans-serif;
    outline: none; color: #fff; background: rgba(255,255,255,.05);
    transition: border-color .15s;
}
.mhs-search input::placeholder { color: rgba(255,255,255,.25); }
.mhs-search input:focus { border-color: #fdbb11; }

.mhs-list { list-style: none; padding: 0; margin: 0; max-height: 200px; overflow-y: auto; }
.mhs-list::-webkit-scrollbar       { width: 3px; }
.mhs-list::-webkit-scrollbar-thumb { background: rgba(253,187,17,.3); border-radius: 4px; }

.mhs-item {
    display: flex; align-items: center; gap: 10px;
    padding: 6px 6px; border-radius: 8px;
    cursor: pointer; transition: background .1s;
    text-decoration: none;
}
.mhs-item:hover { background: rgba(255,255,255,.06); }

.mhs-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; color: white; font-size: 10px; font-weight: 700;
}
.mhs-name  { font-weight: 600; color: rgba(255,255,255,.85); font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.mhs-kelas { font-size: 10px; color: rgba(255,255,255,.3); }

.view-all-link {
    display: block; text-align: center;
    font-size: 11px; color: #fdbb11; font-weight: 600;
    text-decoration: none; margin-top: 10px; padding: 4px;
}
.view-all-link:hover { text-decoration: underline; }
</style>

<aside class="sidebar">

    {{-- Logo --}}
    <a href="{{ route('dashboard') }}" class="sb-logo">
        <div class="sb-logo-icon"><i class="fas fa-graduation-cap"></i></div>
        PPI <span>Curug</span>
    </a>

    {{-- ── MENU ── --}}
    <span class="sb-label">Menu</span>
    <ul class="sb-nav">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ $active==='dashboard'?'active':'' }}">
                <i class="fas fa-th-large nav-icon"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('berita.index') }}" class="{{ $active==='berita'?'active':'' }}">
                <i class="fas fa-newspaper nav-icon"></i> Berita Taruna
            </a>
        </li>

        @if($user->isTaruna())
            <li>
                <a href="{{ route('log-pergerakan.tablet') }}" class="{{ $active==='log-pergerakan'?'active':'' }}">
                    <i class="fas fa-walking nav-icon"></i> Log Pergerakan
                </a>
            </li>
            <li>
                <a href="{{ route('acara.index') }}" class="{{ $active==='acara'?'active':'' }}">
                    <i class="fas fa-calendar-alt nav-icon"></i> Kalender
                </a>
            </li>
            <li>
                <a href="{{ route('poin.index') }}" class="{{ $active==='poin'?'active':'' }}">
                    <i class="fas fa-star nav-icon"></i> Raport Poin
                </a>
            </li>
            <li>
                <a href="{{ route('apel.jadwal') }}" class="{{ $active==='apel'?'active':'' }}">
                    <i class="fas fa-flag nav-icon"></i> Apel
                </a>
            </li>
            <li>
                <a href="{{ route('jadwal.taruna') }}" class="{{ $active==='jadwal'?'active':'' }}">
                    <i class="fas fa-user-clock nav-icon"></i> Jadwal
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
                    <span class="sb-badge">{{ $unreadSurat }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('keluhan-barak.index') }}" class="{{ $active==='keluhan-barak'?'active':'' }}">
                    <i class="fas fa-door-open nav-icon"></i> Keluhan Barak
                    @php
                        $unreadKeluhan = \App\Models\KeluhanBarak::where('user_id', auth()->id())
                            ->where('taruna_baca', false)
                            ->whereIn('status', ['Diproses', 'Selesai', 'Ditolak'])
                            ->count();
                    @endphp
                    @if($unreadKeluhan > 0)
                    <span class="sb-badge">{{ $unreadKeluhan }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('reward.index') }}" class="{{ $active==='reward'?'active':'' }}">
                    <i class="fas fa-award nav-icon"></i> Reward
                    @php
                        $unreadReward = \App\Models\Reward::where('user_id', auth()->id())
                            ->where('taruna_baca', false)
                            ->whereIn('status', ['Diproses', 'Disetujui', 'Ditolak'])
                            ->count();
                    @endphp
                    @if($unreadReward > 0)
                    <span class="sb-badge">{{ $unreadReward }}</span>
                    @endif
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('log-pergerakan.index') }}" class="{{ $active==='log-pergerakan'?'active':'' }}">
                    <i class="fas fa-walking nav-icon"></i> Log Pergerakan
                    @php
                        $activeCount = \App\Models\LogPergerakan::where('status', 'berangkat')->count();
                    @endphp
                    @if($activeCount > 0)
                    <span class="sb-badge">{{ $activeCount }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('log-pergerakan.tv') }}" target="_blank" class="tv-link">
                    <i class="fas fa-tv nav-icon"></i> TV Monitoring
                    <span class="sb-badge-live">LIVE</span>
                </a>
            </li>
            <li>
                <a href="{{ route('surat.index') }}" class="{{ $active==='surat'?'active':'' }}">
                    <i class="fas fa-envelope-open-text nav-icon"></i> Administrasi Surat
                </a>
            </li>
            <li>
                <a href="{{ route('keluhan-barak.kelola') }}" class="{{ $active==='keluhan-barak'?'active':'' }}">
                    <i class="fas fa-door-open nav-icon"></i> Kelola Keluhan Barak
                </a>
            </li>
            <li>
                <a href="{{ route('reward.kelola') }}" class="{{ $active==='reward'?'active':'' }}">
                    <i class="fas fa-award nav-icon"></i> Kelola Reward
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
            @if($user->isPengasuh())
            <li>
                <a href="{{ route('apel.index') }}" class="{{ $active==='apel'?'active':'' }}">
                    <i class="fas fa-flag nav-icon"></i> Apel
                </a>
            </li>
            <li>
                <a href="{{ route('jadwal.index') }}" class="{{ $active==='jadwal'?'active':'' }}">
                    <i class="fas fa-user-clock nav-icon"></i> Jadwal
                </a>
            </li>
            <li>
                <a href="{{ route('konsinyir.index') }}" class="{{ $active==='konsinyir'?'active':'' }}">
                    <i class="fas fa-user-lock nav-icon"></i> Konsinyir
                </a>
            </li>
            @endif
            @if($user->canManageSystem())
            <li>
                <a href="{{ route('mahasiswa.index') }}" class="{{ $active==='mahasiswa'?'active':'' }}">
                    <i class="fas fa-users nav-icon"></i> Database Mahasiswa
                </a>
            </li>
            @endif
        @endif
    </ul>

    {{-- ── ADMIN ── --}}
    @if($user->canManageSystem())
    <hr class="sb-divider">
    <span class="sb-label">Admin</span>
    <ul class="sb-nav">
        <li>
            <a href="{{ route('akses.index') }}" class="{{ $active==='akses'?'active':'' }}">
                <i class="fas fa-shield-alt nav-icon"></i> Akses
            </a>
        </li>
        <li>
            <a href="{{ route('activity-log.index') }}" class="{{ $active==='activity-log'?'active':'' }}">
                <i class="fas fa-history nav-icon"></i> Log Aktivitas
            </a>
        </li>
    </ul>
    @endif

    {{-- ── MAHASISWA QUICK LIST ── --}}
    @if(!$user->isTaruna())
    <hr class="sb-divider">
    <span class="sb-label">Mahasiswa</span>
    <div class="mhs-search">
        <i class="fas fa-search"></i>
        <input type="text" id="sbSearchInput" placeholder="Cari nama..." oninput="sbFilter()">
    </div>
    <ul class="mhs-list" id="sbMhsList">
        @php
            $flatMhs = \App\Models\Mahasiswa::orderBy('kelas')->orderBy('nama')->get();
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
        Lihat semua {{ count($flatMhs) }} mahasiswa &rarr;
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
