@props([
    'title' => '',
    'value' => 0,
    'icon' => 'fa-solid fa-chart-simple',
    'badge' => null,
    'badgeType' => 'success',
    'description' => null,
    'href' => null,
    'gradient' => 'from-blue-600 to-indigo-600'
])

@php
    $badgeClasses = [
        'success' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'danger'  => 'bg-rose-100 text-rose-800 border-rose-200',
        'warning' => 'bg-amber-100 text-amber-800 border-amber-200',
        'info'    => 'bg-sky-100 text-sky-800 border-sky-200',
        'neutral' => 'bg-slate-100 text-slate-700 border-slate-200',
    ][$badgeType ?? 'success'] ?? 'bg-slate-100 text-slate-700 border-slate-200';
@endphp

<{{ $href ? 'a href="'.$href.'"' : 'div' }} class="stat-glass-card block rounded-2xl bg-white/50 hover:bg-white/70 backdrop-blur-xl border border-white/60 p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl group no-underline text-inherit">
    <div class="flex items-center justify-between mb-3">
        <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">{{ $title }}</span>
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $gradient }} flex items-center justify-center text-white text-sm shadow-md group-hover:scale-105 transition-transform">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
    <div class="flex items-baseline gap-2">
        <span class="text-2xl sm:text-3xl font-black text-slate-900 font-mono tracking-tight">{{ $value }}</span>
        @if($badge)
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $badgeClasses }}">
                {{ $badge }}
            </span>
        @endif
    </div>
    @if($description)
        <div class="mt-2.5 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium truncate">
            <i class="fa-solid fa-circle-info text-[9px] text-indigo-500"></i>
            <span>{{ $description }}</span>
        </div>
    @endif
</{{ $href ? 'a' : 'div' }}>
