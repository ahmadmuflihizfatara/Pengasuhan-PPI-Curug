@php
    $user = Auth::user();
    $currentRoute = Route::currentRouteName() ?? '';
    
    // Helper to check active state
    $isActive = function($prefix) use ($currentRoute) {
        if (is_array($prefix)) {
            foreach ($prefix as $p) {
                if (str_starts_with($currentRoute, $p)) return true;
            }
            return false;
        }
        return str_starts_with($currentRoute, $prefix);
    };

    $apelUrl = $user && $user->isTaruna() ? route('apel.jadwal') : route('apel.index');
    $jadwalUrl = $user && $user->isTaruna() ? route('jadwal.taruna') : route('jadwal.index');
    $barakUrl = $user && $user->isTaruna() ? route('keluhan-barak.index') : route('keluhan-barak.kelola');
    $suratUrl = $user && $user->isTaruna() ? route('surat-taruna.index') : route('surat.index');
    $rewardUrl = $user && $user->isTaruna() ? route('reward.index') : route('reward.kelola');
@endphp

<div x-data="{ mobileMenuOpen: false }">

    <!-- ============================================================
         DESKTOP ONLY: FLOATING TOP ISLAND NAVBAR (lg: and above)
         ============================================================ -->
    <header class="hidden lg:flex w-full pt-4 pb-3 px-8 sticky top-0 z-50 items-center justify-between pointer-events-auto transition-all">
        
        <!-- Brand Logo Left -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-2xl bg-white/40 hover:bg-white/60 backdrop-blur-xl border border-white/50 transition-all duration-300 shadow-md group no-underline flex-shrink-0">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-700 via-indigo-600 to-sky-500 flex items-center justify-center text-white font-black text-sm shadow-inner group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-plane-departure text-xs"></i>
            </div>
            <div class="text-left">
                <div class="font-extrabold text-slate-900 tracking-tight text-xs uppercase leading-none">PPI CURUG</div>
                <div class="text-[9px] font-semibold text-slate-500 tracking-widest uppercase">Pengasuhan</div>
            </div>
        </a>

        <!-- Center Floating Capsule Navigation Dock (Top Black-Bordered Island Bar) -->
        <nav class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-slate-950/85 backdrop-blur-2xl border-2 border-slate-900 shadow-2xl">
            
            {{-- 1. Dashboard --}}
            <a href="{{ route('dashboard') }}" 
               class="{{ $isActive('dashboard') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Dashboard Utama">
                <i class="fa-solid fa-house-chimney text-xs"></i>
                @if($isActive('dashboard'))
                <span class="text-xs font-bold">Dashboard</span>
                @endif
            </a>

            {{-- 2. Poin & Sanksi --}}
            <a href="{{ route('poin.index') }}" 
               class="{{ $isActive('poin') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Catatan Poin & Sanksi Disiplin">
                <i class="fa-solid fa-shield-halved text-xs"></i>
                @if($isActive('poin'))
                <span class="text-xs font-bold">Poin</span>
                @endif
            </a>

            {{-- 3. Log Pergerakan (Pos Jaga) --}}
            <a href="{{ route('log-pergerakan.index') }}" 
               class="{{ $isActive('log-pergerakan') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Pos Jaga Gerbang & Log Pergerakan">
                <i class="fa-solid fa-person-walking text-xs"></i>
                @if($isActive('log-pergerakan'))
                <span class="text-xs font-bold">Log Gerbang</span>
                @endif
            </a>

            {{-- 4. Apel & Presensi --}}
            <a href="{{ $apelUrl }}" 
               class="{{ $isActive('apel') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Apel & Presensi Taruna">
                <i class="fa-solid fa-clipboard-check text-xs"></i>
                @if($isActive('apel'))
                <span class="text-xs font-bold">Apel</span>
                @endif
            </a>

            {{-- 5. Jadwal Pengasuhan --}}
            <a href="{{ $jadwalUrl }}" 
               class="{{ $isActive('jadwal') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Jadwal Pengasuh & Duty Taruna">
                <i class="fa-solid fa-clock text-xs"></i>
                @if($isActive('jadwal'))
                <span class="text-xs font-bold">Jadwal</span>
                @endif
            </a>

            {{-- 6. Konsinyir (Pengasuh & Admin) --}}
            @if($user && !$user->isTaruna())
            <a href="{{ route('konsinyir.index') }}" 
               class="{{ $isActive('konsinyir') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Data Konsinyir Taruna">
                <i class="fa-solid fa-user-lock text-xs"></i>
                @if($isActive('konsinyir'))
                <span class="text-xs font-bold">Konsinyir</span>
                @endif
            </a>
            @endif

            {{-- 7. Keluhan Barak --}}
            <a href="{{ $barakUrl }}" 
               class="{{ $isActive('keluhan-barak') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Fasilitas & Keluhan Barak">
                <i class="fa-solid fa-door-open text-xs"></i>
                @if($isActive('keluhan-barak'))
                <span class="text-xs font-bold">Barak</span>
                @endif
            </a>

            {{-- 8. Administrasi Surat --}}
            <a href="{{ $suratUrl }}" 
               class="{{ $isActive(['surat', 'surat-taruna']) ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Administrasi Persuratan">
                <i class="fa-solid fa-envelope-open-text text-xs"></i>
                @if($isActive(['surat', 'surat-taruna']))
                <span class="text-xs font-bold">Surat</span>
                @endif
            </a>

            {{-- 9. Reward & Prestasi --}}
            <a href="{{ $rewardUrl }}" 
               class="{{ $isActive('reward') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Reward & Prestasi Taruna">
                <i class="fa-solid fa-award text-xs"></i>
                @if($isActive('reward'))
                <span class="text-xs font-bold">Reward</span>
                @endif
            </a>

            {{-- 10. Kalender & Acara --}}
            <a href="{{ route('acara.index') }}" 
               class="{{ $isActive('acara') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Agenda & Kalender Kegiatan">
                <i class="fa-solid fa-calendar-days text-xs"></i>
                @if($isActive('acara'))
                <span class="text-xs font-bold">Acara</span>
                @endif
            </a>

            {{-- 11. Database Taruna (Admin) --}}
            @if($user && $user->canManageSystem())
            <a href="{{ route('mahasiswa.index') }}" 
               class="{{ $isActive('mahasiswa') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Master Database Mahasiswa & Taruna">
                <i class="fa-solid fa-user-graduate text-xs"></i>
                @if($isActive('mahasiswa'))
                <span class="text-xs font-bold">Taruna</span>
                @endif
            </a>
            @endif

            <div class="w-px h-4 bg-white/20 my-auto mx-1 flex-shrink-0"></div>

            {{-- 12. Berita & Pengumuman --}}
            <a href="{{ route('berita.index') }}" 
               class="{{ $isActive('berita') ? 'bg-white text-slate-950 font-bold px-3.5 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-2 no-underline text-xs flex-shrink-0" 
               title="Berita & Pengumuman Taruna">
                <i class="fa-solid fa-bullhorn text-xs"></i>
                @if($isActive('berita'))
                <span class="text-xs font-bold">Berita</span>
                @endif
            </a>

            {{-- 13. Menu Admin Dropdown --}}
            @if($user && $user->canManageSystem())
            <div class="relative flex-shrink-0" x-data="{ openAdmin: false }">
                <button @click="openAdmin = !openAdmin" 
                        @click.outside="openAdmin = false"
                        class="{{ $isActive(['akses', 'activity-log', 'users', 'setting']) ? 'bg-white text-slate-950 font-bold px-3 py-2 shadow-md' : 'text-white/70 hover:text-white hover:bg-white/10 p-2.5' }} rounded-full transition-all duration-200 flex items-center gap-1.5 text-xs" 
                        title="Menu Admin & Pengaturan">
                    <i class="fa-solid fa-gear text-xs"></i>
                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                </button>

                <div x-show="openAdmin" 
                     x-transition 
                     style="display: none;" 
                     class="absolute right-0 mt-3 w-48 rounded-2xl bg-slate-900/95 backdrop-blur-2xl border border-white/20 shadow-2xl p-2 z-50 text-white text-xs">
                    <a href="{{ route('akses.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-white/10 transition no-underline text-white font-semibold">
                        <i class="fa-solid fa-shield-halved text-sky-400 w-4"></i>
                        <span>Hak Akses</span>
                    </a>
                    <a href="{{ route('activity-log.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-white/10 transition no-underline text-white font-semibold">
                        <i class="fa-solid fa-clock-rotate-left text-amber-400 w-4"></i>
                        <span>Log Aktivitas</span>
                    </a>
                    <a href="{{ route('users.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-white/10 transition no-underline text-white font-semibold">
                        <i class="fa-solid fa-user-shield text-indigo-400 w-4"></i>
                        <span>Manajemen Akun</span>
                    </a>
                    <a href="{{ route('setting.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-white/10 transition no-underline text-white font-semibold">
                        <i class="fa-solid fa-sliders text-emerald-400 w-4"></i>
                        <span>Setting Sistem</span>
                    </a>
                </div>
            </div>
            @endif

        </nav>

        <!-- Right Profile / Quick Action Pill -->
        <div class="flex items-center gap-2 flex-shrink-0">
            @auth
                <div class="relative group" x-data="{ openProfile: false }">
                    <button @click="openProfile = !openProfile" @click.outside="openProfile = false" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/70 hover:bg-white backdrop-blur-xl border border-white/60 text-slate-800 text-xs font-semibold shadow-md transition-all duration-200">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-[10px] shadow-sm">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="max-w-[120px] truncate">{{ $user->name }}</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    </button>

                    <div x-show="openProfile" x-transition style="display: none;" class="absolute right-0 mt-2 w-44 rounded-2xl bg-white/95 backdrop-blur-2xl border border-white/60 shadow-xl p-2 z-50 text-slate-800 text-xs font-semibold">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 transition no-underline text-slate-700">
                            <i class="fa-solid fa-circle-user text-indigo-600"></i>
                            <span>Profil Saya</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block m-0">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-rose-600 hover:bg-rose-50 transition text-left font-semibold">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Keluar Sistem</span>
                            </button>
                        </form>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                    @csrf
                    <button type="submit" class="p-2 rounded-full bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 border border-rose-200/60 backdrop-blur-md transition-all duration-200" title="Keluar">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-lg transition-all duration-200 no-underline">
                    Masuk
                </a>
            @endauth
        </div>
    </header>


    <!-- ============================================================
         MOBILE ONLY: INTEGRATED TOP HEADER (FLOW IN PAGE, NO OVERLAP)
         ============================================================ -->
    <header class="flex lg:hidden w-full pt-3 pb-2 px-4 items-center justify-between pointer-events-auto">
        
        <!-- Left: Open Sidebar Button -->
        <button @click="mobileMenuOpen = true" 
                type="button"
                class="flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-slate-950/85 hover:bg-slate-900 text-white border border-white/20 shadow-lg backdrop-blur-xl active:scale-95 transition-all group">
            <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white text-[11px] shadow-sm group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-bars-staggered"></i>
            </div>
            <div class="text-left">
                <div class="font-extrabold text-[10px] uppercase tracking-wider text-white leading-none">Menu</div>
                <div class="text-[8px] font-semibold text-sky-300 uppercase tracking-widest leading-none mt-0.5">Sidebar</div>
            </div>
        </button>

        <!-- Center: Brand Label -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-white/40 border border-white/50 backdrop-blur-xl no-underline shadow-sm">
            <div class="w-5 h-5 rounded-lg bg-gradient-to-tr from-blue-700 to-indigo-600 flex items-center justify-center text-white text-[9px]">
                <i class="fa-solid fa-plane-departure"></i>
            </div>
            <div class="text-left">
                <div class="font-extrabold text-slate-900 text-[10px] uppercase leading-none">PPI CURUG</div>
            </div>
        </a>

        <!-- Right: Profile Avatar Pill -->
        @auth
        <div class="relative" x-data="{ openMobProf: false }">
            <button @click="openMobProf = !openMobProf" @click.outside="openMobProf = false" class="flex items-center p-1 rounded-2xl bg-white/60 hover:bg-white border border-white/60 shadow-md backdrop-blur-xl transition active:scale-95">
                <div class="w-7 h-7 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-inner">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
            </button>

            <div x-show="openMobProf" x-transition style="display: none;" class="absolute right-0 mt-2 w-44 rounded-2xl bg-white/95 backdrop-blur-2xl border border-white/60 shadow-xl p-2 z-50 text-slate-800 text-xs font-semibold">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 transition no-underline text-slate-700">
                    <i class="fa-solid fa-circle-user text-indigo-600"></i>
                    <span>Profil Saya</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block m-0">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-rose-600 hover:bg-rose-50 transition text-left font-semibold">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </div>
        @else
        <a href="{{ route('login') }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900 text-white font-bold text-xs shadow-md no-underline">
            Masuk
        </a>
        @endauth
    </header>


    <!-- ============================================================
         MOBILE SLIDING SPATIAL SIDEBAR (Drawer)
         ============================================================ -->
    <div class="lg:hidden">
        
        <!-- Backdrop Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;" 
             class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[9990]"
             @click="mobileMenuOpen = false">
        </div>

        <!-- Left Side Sliding Spatial Sidebar (Full Mobile Menu) -->
        <aside x-show="mobileMenuOpen"
               x-transition:enter="transition ease-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               style="display: none;" 
               class="fixed inset-y-0 left-0 w-[84vw] max-w-[320px] bg-slate-950/95 backdrop-blur-2xl border-r border-white/20 shadow-2xl z-[9995] flex flex-col justify-between p-5 overflow-y-auto">
            
            <div>
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-blue-700 via-indigo-600 to-sky-500 flex items-center justify-center text-white font-black text-sm shadow-inner">
                            <i class="fa-solid fa-plane-departure"></i>
                        </div>
                        <div>
                            <div class="font-extrabold text-white tracking-tight text-xs uppercase leading-none">PPI CURUG</div>
                            <div class="text-[9px] font-semibold text-sky-400 tracking-wider uppercase mt-1">Pengasuhan Taruna</div>
                        </div>
                    </div>

                    <button @click="mobileMenuOpen = false" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-xs transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- User Mini Card -->
                @auth
                <div class="mb-5 p-3 rounded-2xl bg-white/5 border border-white/10 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-md flex-shrink-0">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs font-bold text-white truncate">{{ $user->name }}</div>
                        <div class="text-[10px] text-sky-300 font-semibold flex items-center gap-1.5 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>{{ $user->role_label ?? 'Taruna' }}</span>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Menu Item List with Spatial Styling -->
                <nav class="space-y-1 text-xs">
                    
                    <div class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 px-3 py-1 mt-2">Menu Utama</div>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('dashboard') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-house-chimney w-4 text-center {{ $isActive('dashboard') ? 'text-indigo-600' : 'text-sky-400' }}"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('poin.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('poin') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-shield-halved w-4 text-center {{ $isActive('poin') ? 'text-indigo-600' : 'text-indigo-400' }}"></i>
                        <span>Catatan Poin Disiplin</span>
                    </a>

                    <a href="{{ route('log-pergerakan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('log-pergerakan') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-person-walking w-4 text-center {{ $isActive('log-pergerakan') ? 'text-indigo-600' : 'text-teal-400' }}"></i>
                        <span>Log Pos Jaga Gerbang</span>
                    </a>

                    <a href="{{ $apelUrl }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('apel') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-clipboard-check w-4 text-center {{ $isActive('apel') ? 'text-indigo-600' : 'text-emerald-400' }}"></i>
                        <span>Apel & Presensi</span>
                    </a>

                    <a href="{{ $jadwalUrl }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('jadwal') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-clock w-4 text-center {{ $isActive('jadwal') ? 'text-indigo-600' : 'text-amber-400' }}"></i>
                        <span>Jadwal & Duty</span>
                    </a>

                    @if($user && !$user->isTaruna())
                    <a href="{{ route('konsinyir.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('konsinyir') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-user-lock w-4 text-center {{ $isActive('konsinyir') ? 'text-indigo-600' : 'text-rose-400' }}"></i>
                        <span>Data Konsinyir</span>
                    </a>
                    @endif

                    <div class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 px-3 py-1 mt-4">Fasilitas & Layanan</div>

                    <a href="{{ $barakUrl }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('keluhan-barak') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-door-open w-4 text-center {{ $isActive('keluhan-barak') ? 'text-indigo-600' : 'text-pink-400' }}"></i>
                        <span>Keluhan Barak</span>
                    </a>

                    <a href="{{ $suratUrl }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive(['surat', 'surat-taruna']) ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-envelope-open-text w-4 text-center {{ $isActive(['surat', 'surat-taruna']) ? 'text-indigo-600' : 'text-blue-400' }}"></i>
                        <span>Administrasi Surat</span>
                    </a>

                    <a href="{{ $rewardUrl }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('reward') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-award w-4 text-center {{ $isActive('reward') ? 'text-indigo-600' : 'text-amber-400' }}"></i>
                        <span>Reward & Prestasi</span>
                    </a>

                    <a href="{{ route('acara.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('acara') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-calendar-days w-4 text-center {{ $isActive('acara') ? 'text-indigo-600' : 'text-sky-400' }}"></i>
                        <span>Agenda Acara</span>
                    </a>

                    <a href="{{ route('berita.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('berita') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-bullhorn w-4 text-center {{ $isActive('berita') ? 'text-indigo-600' : 'text-purple-400' }}"></i>
                        <span>Berita Taruna</span>
                    </a>

                    @if($user && $user->canManageSystem())
                    <div class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400 px-3 py-1 mt-4">Admin Sistem</div>

                    <a href="{{ route('mahasiswa.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('mahasiswa') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-user-graduate w-4 text-center {{ $isActive('mahasiswa') ? 'text-indigo-600' : 'text-cyan-400' }}"></i>
                        <span>Database Taruna</span>
                    </a>

                    <a href="{{ route('akses.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('akses') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-shield-halved w-4 text-center {{ $isActive('akses') ? 'text-indigo-600' : 'text-sky-400' }}"></i>
                        <span>Hak Akses</span>
                    </a>

                    <a href="{{ route('activity-log.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('activity-log') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-clock-rotate-left w-4 text-center {{ $isActive('activity-log') ? 'text-indigo-600' : 'text-amber-400' }}"></i>
                        <span>Log Aktivitas</span>
                    </a>

                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('users') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-user-shield w-4 text-center {{ $isActive('users') ? 'text-indigo-600' : 'text-indigo-400' }}"></i>
                        <span>Manajemen Akun</span>
                    </a>

                    <a href="{{ route('setting.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition no-underline {{ $isActive('setting') ? 'bg-white text-slate-950 font-bold shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-sliders w-4 text-center {{ $isActive('setting') ? 'text-indigo-600' : 'text-emerald-400' }}"></i>
                        <span>Setting Sistem</span>
                    </a>
                    @endif

                </nav>
            </div>

            <!-- Sidebar Footer (Profile & Logout) -->
            <div class="pt-4 mt-6 border-t border-white/10 space-y-2">
                @auth
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition no-underline">
                    <i class="fa-solid fa-circle-user text-indigo-400"></i>
                    <span>Profil Akun Saya</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="block m-0">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 font-semibold text-xs transition text-left border border-rose-500/30">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="block text-center py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition no-underline">
                    Masuk Sistem
                </a>
                @endauth
            </div>

        </aside>

    </div>

</div>
