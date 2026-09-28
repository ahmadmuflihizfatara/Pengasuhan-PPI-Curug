{{-- Kartu KPI (PPI Curug Glass, pola .ds-stat). Pakai:
     <x-stat-card title="Total Taruna" :value="120" icon="fa-solid fa-user-graduate" varian="accent" badge="Aktif" badgeType="info" description="..." :href="..." /> --}}
@props([
    'title'       => '',
    'value'       => 0,
    'icon'        => 'fa-solid fa-chart-simple',
    'varian'      => 'accent',   // warna ikon: accent | success | warning | danger | info
    'badge'       => null,
    'badgeType'   => 'accent',   // varian ds-badge
    'description' => null,
    'href'        => null,
])
@once
<style>
    .ds-stat { color: inherit; text-decoration: none; }
    .ds-stat:hover { color: inherit; }
    .ds-stat:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .ds-stat__icon--info { background: linear-gradient(135deg, #0ea5e9, var(--info)); }
    .ds-stat__row .ds-badge { font-size: 10px; padding: 2px 8px; }
    .ds-stat__note span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    div.ds-stat:hover { transform: none; }
</style>
@endonce
<{{ $href ? 'a' : 'div' }} @if($href) href="{{ $href }}" @endif class="ds-stat">
    <div class="ds-stat__top">
        <span class="ds-stat__label">{{ $title }}</span>
        <span class="ds-stat__icon {{ $varian !== 'accent' ? 'ds-stat__icon--'.$varian : '' }}"><i class="{{ $icon }}"></i></span>
    </div>
    <div class="ds-stat__row">
        <span class="ds-stat__value">{{ $value }}</span>
        @if($badge)
        <span class="ds-badge ds-badge--{{ $badgeType }}">{{ $badge }}</span>
        @endif
    </div>
    @if($description)
    <div class="ds-stat__note"><i class="fa-solid fa-circle-info ds-icon"></i><span>{{ $description }}</span></div>
    @endif
</{{ $href ? 'a' : 'div' }}>
