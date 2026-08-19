<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PPI Curug — Sistem Pengasuhan & Karakter Taruna</title>

    @auth
    {{-- Redirect langsung ke dashboard jika sudah login --}}
    <meta http-equiv="refresh" content="0;url={{ url('/dashboard') }}">
    @endauth

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
            background: transparent !important;
            color: #0f172a;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Fixed blurred cockpit background container */
        #global-cockpit-bg-layer {
            position: fixed;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            background-image: url('{{ asset('images/BG.png') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            filter: blur(4px) brightness(0.92);
            transform: scale(1.04);
            z-index: -10;
            pointer-events: none;
        }

        #global-cockpit-overlay-layer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 30%, rgba(15, 23, 42, 0.12) 0%, rgba(15, 23, 42, 0.45) 100%);
            z-index: -9;
            pointer-events: none;
        }

        .hero-title-serif {
            font-family: 'Instrument Serif', 'Playfair Display', serif;
            letter-spacing: -0.02em;
        }
    </style>
</head>
<body class="antialiased min-h-screen relative flex flex-col justify-between">

    {{-- Global Background Cockpit --}}
    <div id="global-cockpit-bg-layer"></div>
    <div id="global-cockpit-overlay-layer"></div>

    {{-- Top Floating Island Capsule Navbar --}}
    <header class="w-full pt-5 pb-3 px-4 sm:px-8 sticky top-0 z-50 flex items-center justify-between pointer-events-auto">
        <!-- Brand Logo Left -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-2xl bg-white/40 hover:bg-white/60 backdrop-blur-xl border border-white/50 transition-all duration-300 shadow-md group">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-700 via-indigo-600 to-sky-500 flex items-center justify-center text-white font-black text-sm shadow-inner group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-plane-departure text-xs"></i>
            </div>
            <div class="text-left">
                <div class="font-extrabold text-slate-900 tracking-tight text-xs uppercase leading-none">PPI CURUG</div>
                <div class="text-[9px] font-semibold text-slate-600 tracking-widest uppercase">Pengasuhan</div>
            </div>
        </a>

        <!-- Center Floating Capsule Navigation Dock -->
        <nav class="hidden md:flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900/75 backdrop-blur-2xl border border-white/15 shadow-2xl">
            <a href="#fitur" class="text-xs font-semibold text-white/80 hover:text-white px-3 py-1 rounded-full hover:bg-white/10 transition">Pilar Pengasuhan</a>
            <a href="#stats" class="text-xs font-semibold text-white/80 hover:text-white px-3 py-1 rounded-full hover:bg-white/10 transition">Statistik</a>
            <a href="#tentang" class="text-xs font-semibold text-white/80 hover:text-white px-3 py-1 rounded-full hover:bg-white/10 transition">Tentang</a>
        </nav>

        <!-- Right Quick Action Pill / Auth Button -->
        <div class="flex items-center gap-2">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full bg-white hover:bg-slate-50 text-slate-950 font-extrabold text-xs shadow-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                    <span>Masuk ke Kokpit</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            @endif
        </div>
    </header>

    {{-- Hero Section with Editorial Display Typography & Omnibar --}}
    <main class="flex-1 max-w-7xl mx-auto px-4 py-8 sm:py-12 w-full flex flex-col items-center justify-center">
        
        <div class="max-w-4xl text-center flex flex-col items-center mb-10">
            <!-- Top Floating Pill Tag -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/30 backdrop-blur-xl border border-white/40 shadow-sm text-xs font-bold text-slate-900 mb-5 animate-fade-in">
                <span class="text-amber-500 font-black">✦</span>
                <span>Sistem Informasi Pengasuhan & Karakter Taruna</span>
            </div>

            <!-- Large Editorial Serif Display Headline -->
            <h1 class="hero-title-serif text-4xl sm:text-6xl md:text-7xl font-normal tracking-tight text-slate-900 drop-shadow-sm leading-[1.08] mb-4">
                Keunggulan Disiplin untuk Pemimpin Masa Depan
            </h1>

            <!-- Subtitle Sans-serif -->
            <p class="text-xs sm:text-base text-slate-700 max-w-2xl mx-auto leading-relaxed mb-8 font-medium">
                Platform terpadu Politeknik Penerbangan Indonesia Curug untuk manajemen kedisiplinan, pemantauan pos jaga real-time, raport poin, perizinan asrama, dan pembinaan karakter taruna kelas dunia.
            </p>

            <!-- Floating Omnibar Search Pill with Action Button (Inspired by design.mp4) -->
            <div class="w-full max-w-xl relative group">
                <div class="flex items-center bg-white/40 hover:bg-white/60 focus-within:bg-white/80 backdrop-blur-2xl border border-white/60 focus-within:border-indigo-400 rounded-full px-5 py-3 shadow-2xl transition-all duration-300">
                    <i class="fa-solid fa-magnifying-glass text-slate-500 text-sm ml-1 mr-3"></i>
                    <input type="text" 
                           id="globalSearchInput"
                           placeholder="Cek status perizinan, info kedisiplinan, pos jaga..." 
                           class="w-full bg-transparent border-none outline-none text-xs sm:text-sm text-slate-900 placeholder-slate-500 font-semibold focus:ring-0">
                    <a href="{{ route('login') }}" class="w-9 h-9 rounded-full bg-slate-950 hover:bg-slate-800 text-white flex items-center justify-center transition-transform duration-200 active:scale-95 shadow-md flex-shrink-0" title="Cari / Akses">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Floating Spatial Master Workspace Canvas Preview (rounded-3xl) --}}
        <div id="fitur" class="spatial-workspace-window w-full rounded-3xl p-6 sm:p-8 mt-4 shadow-2xl relative">
            
            <!-- Control Header Bar Inside Workspace -->
            <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-6 border-b border-white/30">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-bold shadow-sm">
                        <i class="fa-solid fa-cubes"></i>
                    </div>
                    <span class="text-xs font-black uppercase tracking-wider text-slate-800">4 Pilar Utama Pengasuhan</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-emerald-100/90 text-emerald-800 font-bold text-[11px] border border-emerald-200 flex items-center gap-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <span>Sistem Aktif & Terintegrasi</span>
                    </span>
                </div>
            </div>

            <!-- 4 Pillar Glass Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- Pillar 1: Raport Poin & Kedisiplinan -->
                <div class="rounded-2xl bg-white/55 hover:bg-white/75 backdrop-blur-xl border border-white/70 p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-base mb-4 shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1.5">Raport Poin Disiplin</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Pencatatan transparan poin pelanggaran dan penghargaan taruna berbasis tingkatan sanksi resmi pengasuhan.
                    </p>
                    <div class="flex items-center text-[11px] font-bold text-indigo-700 group-hover:underline">
                        <span>Pelajari Disiplin</span>
                        <i class="fa-solid fa-arrow-right text-[9px] ml-1.5"></i>
                    </div>
                </div>

                <!-- Pillar 2: Pos Jaga & Log Pergerakan -->
                <div class="rounded-2xl bg-white/55 hover:bg-white/75 backdrop-blur-xl border border-white/70 p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 text-white flex items-center justify-center text-base mb-4 shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1.5">Pos Jaga & Log Pergerakan</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Pemantauan arus keluar masuk taruna di gerbang utama secara real-time via tablet dan monitor TV live.
                    </p>
                    <div class="flex items-center text-[11px] font-bold text-sky-700 group-hover:underline">
                        <span>Monitoring Gerbang</span>
                        <i class="fa-solid fa-arrow-right text-[9px] ml-1.5"></i>
                    </div>
                </div>

                <!-- Pillar 3: Apel & Presensi -->
                <div class="rounded-2xl bg-white/55 hover:bg-white/75 backdrop-blur-xl border border-white/70 p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center text-base mb-4 shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1.5">Apel & Presensi Harian</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Perekaman kehadiran apel pagi, siang, dan malam per barak dengan rekap otomatis dan berita acara digital.
                    </p>
                    <div class="flex items-center text-[11px] font-bold text-emerald-700 group-hover:underline">
                        <span>Jadwal & Presensi</span>
                        <i class="fa-solid fa-arrow-right text-[9px] ml-1.5"></i>
                    </div>
                </div>

                <!-- Pillar 4: Keluhan Barak & Perizinan -->
                <div class="rounded-2xl bg-white/55 hover:bg-white/75 backdrop-blur-xl border border-white/70 p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center text-base mb-4 shadow-md group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mb-1.5">Surat Izin & Barak</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Pengajuan izin bermalam digital, pelaporan fasilitas keluhan barak, dan approval bertingkat pengasuh.
                    </p>
                    <div class="flex items-center text-[11px] font-bold text-amber-700 group-hover:underline">
                        <span>Layanan Taruna</span>
                        <i class="fa-solid fa-arrow-right text-[9px] ml-1.5"></i>
                    </div>
                </div>

            </div>

            <!-- Stats Bar Inside Workspace -->
            <div id="stats" class="mt-8 pt-6 border-t border-white/30 grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div class="p-3">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 font-mono">50+</div>
                    <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wider mt-0.5">Tahun Pengalaman</div>
                </div>
                <div class="p-3">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 font-mono">100%</div>
                    <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wider mt-0.5">Terakreditasi Unggul</div>
                </div>
                <div class="p-3">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 font-mono">24/7</div>
                    <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wider mt-0.5">Pengawasan Pos Jaga</div>
                </div>
                <div class="p-3">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900 font-mono">Ribuan</div>
                    <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wider mt-0.5">Alumni Berprestasi</div>
                </div>
            </div>

        </div>

    </main>

    {{-- Footer --}}
    <footer class="w-full py-6 px-4 text-center text-xs font-medium text-slate-600 border-t border-white/20 backdrop-blur-md">
        <p>&copy; {{ date('Y') }} Politeknik Penerbangan Indonesia Curug. Hak cipta dilindungi undang-undang.</p>
    </footer>

</body>
</html>
