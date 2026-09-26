{{-- Header halaman — sama dengan header tab poin: judul, subjudul, kartu nama akun di kanan --}}
@props(['title', 'subtitle' => null])
@php
    $akun     = auth()->user();
    $isTaruna = $akun?->hasTarunaAccess();
@endphp
<div class="greeting-banner rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 sm:p-8 text-white mb-4 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div class="relative z-10 max-w-xl">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mb-0">{{ $title }}</h1>
        @if($subtitle)
        <p class="text-xs sm:text-sm text-sky-100/80 leading-relaxed mt-1.5">{{ $subtitle }}</p>
        @endif
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

    <div class="absolute -right-16 -top-16 w-56 h-56 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute right-32 -bottom-20 w-48 h-48 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
</div>
