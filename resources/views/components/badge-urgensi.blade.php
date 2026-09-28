{{-- Badge "Urgensi Tinggi" untuk Izin Keluar Khusus (tanpa surat). Kosong bila log bukan izin khusus.
     Pakai: <x-badge-urgensi :log="$log" /> --}}
@props(['log'])
@if($log->isUrgensiTinggi())
<span {{ $attributes->merge(['class' => 'ds-badge ds-badge--danger']) }} title="Izin Keluar Khusus — urgensi tinggi, tanpa surat"><i class="fa-solid fa-bolt"></i> Urgensi Tinggi</span>
@endif
