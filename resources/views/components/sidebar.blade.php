{{--
    Komponen Sidebar Reusable Spatial Glassmorphism 2.0
    Penggunaan: <x-sidebar active="dashboard" />
    Nilai $active: 'dashboard' | 'berita' | 'surat' | 'acara' | 'poin' | 'mahasiswa' | 'activity-log' | 'profile' | 'users' | 'setting' | dsb.
--}}
@php
    $user         = Auth::user();
    $avatarColors = ['#4f46e5','#7c3aed','#0284c7','#059669','#d97706','#dc2626','#db2777','#475569'];
@endphp

<style>
/* ============================================================
   SPATIAL MINIMALIST FROSTED GLASS SIDEBAR
   ============================================================ */
.spatial-sidebar {
    width: 250px;
    min-width: 250px;
    background: rgba(255, 255, 255, 0.45) !important;
    backdrop-filter: blur(24px) saturate(190%) !important;
    -webkit-backdrop-filter: blur(24px) saturate(190%) !important;
    border: 1px solid rgba(255, 255, 255, 0.55) !important;
    border-radius: 24px;
    box-shadow: 0 16px 36px -8px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.4) inset !important;
    padding: 20px 14px 28px;
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
    overflow-x: hidden;
    transition: all 0.3s ease;
}

.spatial-sidebar::-webkit-scrollbar { width: 4px; }
.spatial-sidebar::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.4); border-radius: 9999px; }

/* Sidebar Brand Header */
.sb-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 4px 6px 18px 6px;
    margin-bottom: 12px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.35);
    text-decoration: none;
}
.sb-logo-box {
    width: 34px;
    height: 34px;
    border-radius: 11px;
    background: linear-gradient(135deg, #1e3a8a, #4f46e5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
    flex-shrink: 0;
}
.sb-title-wrap h3 {
    font-size: 13px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0;
    line-height: 1.2;
}
.sb-title-wrap p {
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #64748b;
    margin: 0;
}

/* Category Label */
.sb-group-label {
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #64748b;
    margin: 14px 0 6px 8px;
    display: block;
}

/* Nav Link Items */
.sb-nav-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 3px; }
.sb-nav-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    color: #334155;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    white-space: nowrap;
}
.sb-nav-link i.nav-icon {
    width: 18px;
    text-align: center;
    font-size: 12px;
    color: #64748b;
    flex-shrink: 0;
    transition: color 0.2s;
}

/* Inactive Hover */
.sb-nav-link:hover {
    background: rgba(255, 255, 255, 0.65);
    color: #0f172a;
    transform: translateX(2px);
}
.sb-nav-link:hover i.nav-icon {
    color: #4f46e5;
}

/* Active State: Solid White Pill with Deep Ambient Shadow (Inspired by design.mp4) */
.sb-nav-link.active {
    background: #ffffff !important;
    color: #0f172a !important;
    font-weight: 800 !important;
    box-shadow: 0 6px 18px -2px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.9) inset !important;
    transform: scale(1.01);
}
.sb-nav-link.active i.nav-icon {
    color: #4f46e5 !important;
}

/* Notification / Counter Badges */
.sb-badge {
    background: #e11d48;
    color: white;
    font-size: 10px;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 9999px;
    box-shadow: 0 2px 8px rgba(225, 29, 72, 0.35);
    margin-left: auto;
}
.sb-badge-live {
    background: #10b981;
    color: white;
    font-size: 9px;
    font-weight: 800;
    padding: 1px 6px;
    border-radius: 6px;
    letter-spacing: 0.05em;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
    margin-left: auto;
}

/* Quick Taruna Search Box */
.sb-search-box {
    position: relative;
    margin: 8px 4px 10px;
}
.sb-search-box i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 11px;
    pointer-events: none;
}
.sb-search-box input {
    width: 100%;
    padding: 7px 10px 7px 28px;
    background: rgba(255, 255, 255, 0.7);
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    font-size: 11px;
    font-family: inherit;
    font-weight: 500;
    color: #0f172a;
    outline: none;
    transition: all 0.2s;
}
.sb-search-box input:focus {
    background: #ffffff;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
}

/* Taruna Quick List */
.sb-taruna-list {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 180px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.sb-taruna-list::-webkit-scrollbar { width: 3px; }
.sb-taruna-list::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.4); border-radius: 4px; }

.sb-taruna-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 8px;
    border-radius: 9px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.15s;
}
.sb-taruna-item:hover {
    background: rgba(255, 255, 255, 0.75);
}
.sb-avatar-mini {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: white;
    font-size: 9px;
    font-weight: 800;
}
.sb-taruna-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 11px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sb-taruna-sub {
    font-size: 9px;
    color: #64748b;
}

/* Divider */
.sb-line-divider {
    border: none;
    border-top: 1px solid rgba(255, 255, 255, 0.35);
    margin: 12px 6px;
}
</style>

<aside class="spatial-sidebar">

    {{-- Header Logo --}}
    <a href="{{ route('dashboard') }}" class="sb-header">
        <div class="sb-logo-box">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div class="sb-title-wrap">
            <h3>Pengasuhan</h3>
            <p>PPI Curug Portal</p>
        </div>
    </a>

    {{-- ── MENU UTAMA ── --}}
    <span class="sb-group-label">Menu Utama</span>
    <ul class="sb-nav-list">
        <li>
            <a href="{{ route('dashboard') }}" class="sb-nav-link {{ $active==='dashboard'?'active':'' }}">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-house-chimney nav-icon"></i>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>

        {{-- Berita Taruna --}}
        <li>
            <a href="{{ route('berita.index') }}" class="sb-nav-link {{ $active==='berita'?'active':'' }}">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-newspaper nav-icon"></i>
                    <span>Berita Taruna</span>
                </div>
            </a>
        </li>

        @if($user->isTaruna())
            <li>
                <a href="{{ route('log-pergerakan.tablet') }}" class="sb-nav-link {{ $active==='log-pergerakan'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-person-walking nav-icon"></i>
                        <span>Log Pergerakan</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('acara.index') }}" class="sb-nav-link {{ $active==='acara'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-calendar-days nav-icon"></i>
                        <span>Kalender Acara</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('poin.index') }}" class="sb-nav-link {{ $active==='poin'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-star nav-icon"></i>
                        <span>Raport Poin</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('apel.jadwal') }}" class="sb-nav-link {{ $active==='apel'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-flag nav-icon"></i>
                        <span>Apel</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('jadwal.taruna') }}" class="sb-nav-link {{ $active==='jadwal'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-user-clock nav-icon"></i>
                        <span>Jadwal Harian</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('surat-taruna.index') }}" class="sb-nav-link {{ $active==='surat-taruna'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-file-signature nav-icon"></i>
                        <span>Pengajuan Surat</span>
                    </div>
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
                <a href="{{ route('keluhan-barak.index') }}" class="sb-nav-link {{ $active==='keluhan-barak'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-door-open nav-icon"></i>
                        <span>Keluhan Barak</span>
                    </div>
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
                <a href="{{ route('reward.index') }}" class="sb-nav-link {{ $active==='reward'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-award nav-icon"></i>
                        <span>Reward Taruna</span>
                    </div>
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
            {{-- Modul Pengasuh & Admin --}}
            <li>
                <a href="{{ route('log-pergerakan.index') }}" class="sb-nav-link {{ $active==='log-pergerakan'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-person-walking nav-icon"></i>
                        <span>Log Pergerakan</span>
                    </div>
                    @php
                        $activeCount = \App\Models\LogPergerakan::where('status', 'berangkat')->count();
                    @endphp
                    @if($activeCount > 0)
                        <span class="sb-badge">{{ $activeCount }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('log-pergerakan.tv') }}" target="_blank" class="sb-nav-link" style="color: #0284c7;">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-tv nav-icon" style="color: #0284c7;"></i>
                        <span>TV Pos Jaga</span>
                    </div>
                    <span class="sb-badge-live">LIVE</span>
                </a>
            </li>
            <li>
                <a href="{{ route('surat.index') }}" class="sb-nav-link {{ $active==='surat'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-envelope-open-text nav-icon"></i>
                        <span>Administrasi Surat</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('keluhan-barak.kelola') }}" class="sb-nav-link {{ $active==='keluhan-barak'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-door-open nav-icon"></i>
                        <span>Kelola Barak</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('reward.kelola') }}" class="sb-nav-link {{ $active==='reward'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-award nav-icon"></i>
                        <span>Kelola Reward</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('acara.index') }}" class="sb-nav-link {{ $active==='acara'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-calendar-days nav-icon"></i>
                        <span>Agenda Acara</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('poin.index') }}" class="sb-nav-link {{ $active==='poin'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-shield-halved nav-icon"></i>
                        <span>Catatan POIN</span>
                    </div>
                </a>
            </li>
            @if($user->isPengasuh())
            <li>
                <a href="{{ route('apel.index') }}" class="sb-nav-link {{ $active==='apel'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-flag nav-icon"></i>
                        <span>Rekap Apel</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('jadwal.index') }}" class="sb-nav-link {{ $active==='jadwal'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-user-clock nav-icon"></i>
                        <span>Jadwal Pengasuhan</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('konsinyir.index') }}" class="sb-nav-link {{ $active==='konsinyir'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-user-lock nav-icon"></i>
                        <span>Konsinyir</span>
                    </div>
                </a>
            </li>
            @endif
            @if($user->canManageSystem())
            <li>
                <a href="{{ route('mahasiswa.index') }}" class="sb-nav-link {{ $active==='mahasiswa'?'active':'' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-users nav-icon"></i>
                        <span>Database Taruna</span>
                    </div>
                </a>
            </li>
            @endif
        @endif
    </ul>

    {{-- ── ADMIN SISTEM ── --}}
    @if($user->canManageSystem())
    <hr class="sb-line-divider">
    <span class="sb-group-label">Admin Sistem</span>
    <ul class="sb-nav-list">
        <li>
            <a href="{{ route('akses.index') }}" class="sb-nav-link {{ $active==='akses'?'active':'' }}">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-shield-halved nav-icon"></i>
                    <span>Hak Akses</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('activity-log.index') }}" class="sb-nav-link {{ $active==='activity-log'?'active':'' }}">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-clock-rotate-left nav-icon"></i>
                    <span>Log Aktivitas</span>
                </div>
            </a>
        </li>
    </ul>
    @endif

    {{-- ── PENCARIAN CEPAT TARUNA ── --}}
    @if(!$user->isTaruna())
    <hr class="sb-line-divider">
    <span class="sb-group-label">Pencarian Taruna</span>
    <div class="sb-search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="sbSearchInput" placeholder="Cari nama taruna..." oninput="sbFilter()">
    </div>
    <ul class="sb-taruna-list" id="sbMhsList">
        @php
            $flatMhs = \App\Models\Mahasiswa::orderBy('kelas')->orderBy('nama')->take(20)->get();
            $ci = 0;
        @endphp
        @foreach($flatMhs as $mhs)
        <li>
            <a href="{{ route('poin.index', ['npm' => $mhs->npm]) }}" class="sb-taruna-item sb-mhs-item"
               data-search="{{ strtolower($mhs->nama).' '.strtolower($mhs->nickname ?? '') }}">
                <div class="sb-avatar-mini" style="background:{{ $avatarColors[$ci % count($avatarColors)] }};">
                    {{ strtoupper(substr($mhs->nickname ?? $mhs->nama, 0, 2)) }}
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="sb-taruna-name">{{ $mhs->nickname ?? $mhs->nama }}</div>
                    <div class="sb-taruna-sub">{{ $mhs->kelas }}</div>
                </div>
            </a>
        </li>
        @php $ci++; @endphp
        @endforeach
    </ul>
    <a href="{{ $user->canManageSystem() ? route('mahasiswa.index') : route('poin.index') }}" class="block text-center text-[10px] text-indigo-700 font-bold hover:underline py-1.5 mt-1">
        Lihat Seluruh Taruna →
    </a>
    @endif

    {{-- ── PENGATURAN & AKUN ── --}}
    <hr class="sb-line-divider">
    <span class="sb-group-label">Pengaturan</span>
    <ul class="sb-nav-list">
        @if(!$user->isTaruna())
        <li>
            <a href="{{ route('profile.edit') }}" class="sb-nav-link {{ $active==='profile'?'active':'' }}">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-user nav-icon"></i>
                    <span>Profil Saya</span>
                </div>
            </a>
        </li>
        @endif
        @if($user->canManageSystem())
        <li>
            <a href="{{ route('users.index') }}" class="sb-nav-link {{ $active==='users'?'active':'' }}">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-user-shield nav-icon"></i>
                    <span>Manajemen Akun</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('setting.index') }}" class="sb-nav-link {{ $active==='setting'?'active':'' }}">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-gear nav-icon"></i>
                    <span>Setting Sistem</span>
                </div>
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('logout') }}" class="sb-nav-link text-rose-600 hover:text-rose-700 hover:bg-rose-50/60"
               onclick="event.preventDefault();document.getElementById('sb-logout-form').submit();">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-arrow-right-from-bracket nav-icon text-rose-500"></i>
                    <span>Keluar Sistem</span>
                </div>
            </a>
            <form id="sb-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </li>
    </ul>

</aside>

<script>
function sbFilter() {
    const q = document.getElementById('sbSearchInput').value.toLowerCase().trim();
    document.querySelectorAll('.sb-mhs-item').forEach(function(el) {
        el.style.display = (el.dataset.search || '').includes(q) ? 'flex' : 'none';
    });
}
</script>
