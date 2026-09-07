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
            background-image: url('{{ asset('assets/img/auth-bg.jpg') }}');
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
            background: radial-gradient(circle at 50% 35%, rgba(15, 23, 42, 0.45) 0%, rgba(15, 23, 42, 0.82) 100%);
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

    {{-- Hero Section with Editorial Display Typography --}}
    <main class="flex-1 max-w-7xl mx-auto px-4 py-12 sm:py-16 w-full flex flex-col items-center justify-center">
        
        <div class="max-w-4xl text-center flex flex-col items-center mb-12">
            
            <!-- Brand Badge Top -->
            <div class="flex items-center gap-3 px-4 py-2 rounded-2xl bg-white/20 hover:bg-white/30 backdrop-blur-xl border border-white/30 transition-all duration-300 shadow-xl mb-6">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-700 via-indigo-600 to-sky-500 flex items-center justify-center text-white font-black text-sm shadow-inner">
                    <i class="fa-solid fa-plane-departure text-xs"></i>
                </div>
                <div class="text-left">
                    <div class="font-extrabold text-white tracking-tight text-xs uppercase leading-none">PPI CURUG</div>
                    <div class="text-[9px] font-semibold text-sky-200 tracking-widest uppercase">Pengasuhan Taruna</div>
                </div>
            </div>

            <!-- Top Floating Pill Tag -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-900/80 backdrop-blur-xl border border-white/20 shadow-lg text-xs font-bold text-sky-300 mb-5 animate-fade-in">
                <span class="text-amber-400 font-black">✦</span>
                <span>Sistem Informasi Pengasuhan &amp; Karakter Taruna</span>
            </div>

            <!-- Large Editorial Serif Display Headline (High Contrast White) -->
            <h1 class="hero-title-serif text-4xl sm:text-6xl md:text-7xl font-normal tracking-tight text-white drop-shadow-[0_4px_24px_rgba(0,0,0,0.9)] leading-[1.08] mb-5">
                Keunggulan Disiplin untuk Pemimpin Masa Depan
            </h1>

            <!-- Subtitle Sans-serif (High Contrast Slate-200) -->
            <p class="text-sm sm:text-base md:text-lg text-slate-100/90 max-w-2xl mx-auto leading-relaxed mb-9 font-medium drop-shadow-[0_2px_10px_rgba(0,0,0,0.8)]">
                Platform terpadu Politeknik Penerbangan Indonesia Curug untuk manajemen kedisiplinan, pemantauan pos jaga real-time, raport poin, perizinan asrama, dan pembinaan karakter taruna kelas dunia.
            </p>

            <!-- CTA Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-3.5">
                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="px-8 py-3.5 rounded-full bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-500 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs sm:text-sm shadow-2xl transition-all duration-200 active:scale-95 flex items-center gap-2.5 no-underline group">
                    <span>Masuk ke Sistem Pengasuhan</span>
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
                @endif
                <a href="#fitur" class="px-7 py-3.5 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-xl border border-white/30 text-white font-bold text-xs sm:text-sm shadow-lg transition-all duration-200 no-underline">
                    <span>Pelajari 4 Pilar</span>
                </a>
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