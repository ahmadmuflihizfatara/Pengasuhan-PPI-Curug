{{-- Ikon header halaman (tanpa latar kotak), satu warna untuk semua tab — ikon mengikuti island navbar. Pakai: <x-header-icon icon="fa-clock" /> --}}
@props(['icon'])
@once
<style>
    /* Indigo muda transparan — menyatu dengan gradien banner (biru → indigo → slate) & subjudul sky-100 */
    .header-icon { flex-shrink: 0; font-size: 32px; line-height: 1; color: rgba(199, 210, 254, 0.85); }
    @media (max-width: 640px) { .header-icon { font-size: 26px; } }
</style>
@endonce
<span class="header-icon" aria-hidden="true"><i class="fa-solid {{ $icon }}"></i></span>
