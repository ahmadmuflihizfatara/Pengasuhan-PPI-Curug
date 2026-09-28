{{-- Ikon header halaman (tanpa latar kotak) — ikon mengikuti island navbar. Pakai: <x-header-icon icon="fa-clock" /> --}}
@props(['icon'])
@once
<style>
    /* Putih transparan — netral di atas gradien banner yang warnanya berbeda per tab */
    .header-icon { flex-shrink: 0; font-size: 32px; line-height: 1; color: rgba(255, 255, 255, 0.85); }
    @media (max-width: 640px) { .header-icon { font-size: 26px; } }
</style>
@endonce
<span class="header-icon" aria-hidden="true"><i class="fa-solid {{ $icon }}"></i></span>
