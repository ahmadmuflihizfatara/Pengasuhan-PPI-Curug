{{-- Header halaman — judul, subjudul, kartu nama akun di kanan.
     Warna gradien unik per tab, dipilih otomatis dari nama route (lihat $tema). Override: <x-page-banner tema="berita" ... /> --}}
@props(['title', 'subtitle' => null, 'icon' => null, 'tema' => null])
@php
    $akun     = auth()->user();
    $isTaruna = $akun?->hasTarunaAccess();

    // Prefiks nama route tab → [warna terang, warna gelap]. Satu rona per tab, tidak ada yang sama.
    // Urutan penting: prefiks yang lebih panjang (akses-khusus) sebelum yang lebih pendek (akses).
    $palet = [
        'dashboard'      => ['#3730a3', '#1e1b4b'], // indigo
        'poin'           => ['#991b1b', '#450a0a'], // merah
        'acara'          => ['#065f46', '#022c22'], // zamrud
        'berita'         => ['#075985', '#082f49'], // biru langit
        'log-pergerakan' => ['#9a3412', '#431407'], // oranye
        'apel'           => ['#115e59', '#042f2e'], // teal
        'jadwal'         => ['#6b21a8', '#3b0764'], // ungu
        'duty'           => ['#6b21a8', '#3b0764'], // ungu — sub-tab Jadwal, sengaja sama
        'laporan-duty'   => ['#9f1239', '#4c0519'], // mawar
        'konsinyir'      => ['#57534e', '#1c1917'], // batu
        'nilai-taruna'   => ['#166534', '#052e16'], // hijau
        'keluhan-barak'  => ['#9d174d', '#500724'], // merah muda
        'surat'          => ['#92400e', '#451a03'], // amber (juga surat-taruna)
        'reward'         => ['#854d0e', '#422006'], // emas
        'bmi'            => ['#86198f', '#4a044e'], // fuchsia
        'profile'        => ['#155e75', '#083344'], // sian
        'mahasiswa'      => ['#3f6212', '#1a2e05'], // lime
        'users'          => ['#1e40af', '#172554'], // biru
        'akses-khusus'   => ['#6d3b1f', '#241208'], // kopi
        'akses'          => ['#5b21b6', '#2e1065'], // violet
        'activity-log'   => ['#334155', '#020617'], // slate
        'setting'        => ['#3f3f46', '#09090b'], // seng
    ];
    $route = request()->route()?->getName() ?? '';
    $kunci = $tema ?? collect(array_keys($palet))->first(fn ($p) => str_starts_with($route, $p));
    [$terang, $gelap] = $palet[$kunci] ?? $palet['dashboard'];
    // Glass: warna tab di kiri memudar ke gelap di kanan, tetap semi-transparan
    $latar = "linear-gradient(100deg, {$terang}e6 0%, {$gelap}d9 55%, rgba(15,23,42,.9) 100%)";
@endphp
<div class="greeting-banner rounded-2xl backdrop-blur-xl border border-white/30 p-6 sm:p-8 text-white mb-4 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
     style="--banner-bg: {{ $latar }}; --banner-sorot: {{ $terang }}" data-tema="{{ $kunci ?? 'dashboard' }}">
    <div class="relative z-10 max-w-xl flex items-center gap-4">
        @if($icon)<x-header-icon :icon="$icon" />@endif
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-0">{{ $title }}</h1>
            @if($subtitle)
            <p class="text-xs sm:text-sm text-white/80 leading-relaxed mt-1.5">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if($akun)
    <div class="relative z-10 flex-shrink-0 flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3 sm:px-5 sm:py-3.5 shadow-inner">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center font-black text-lg shadow-md">
            {{ strtoupper(substr($akun->name, 0, 1)) }}
        </div>
        <div>
            <div class="text-xs font-bold text-white max-w-[140px] truncate">{{ $akun->name }}</div>
            <div class="text-[10px] font-semibold text-amber-300">{{ $isTaruna ? 'Taruna' : $akun->role_label }}</div>
            <div class="text-[9px] text-slate-300 font-mono mt-0.5">{{ $isTaruna ? 'NIT: ' . ($akun->mahasiswa?->npm ?? '-') : 'ID: #' . $akun->id }}</div>
        </div>
    </div>
    @endif

    {{-- Sorotan cahaya ambient mengikuti warna tab --}}
    <div class="absolute -right-16 -top-16 w-56 h-56 rounded-full blur-3xl pointer-events-none" style="background: {{ $terang }}; opacity: .35"></div>
    <div class="absolute right-32 -bottom-20 w-48 h-48 rounded-full blur-3xl pointer-events-none" style="background: rgba(255,255,255,.12)"></div>
</div>
