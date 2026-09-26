{{-- Notifikasi halaman (PPI Curug Glass). Pakai: <x-glass-alert type="success" title="Berhasil">pesan</x-glass-alert> --}}
@props(['type' => 'success', 'title'])
@once
<style>
    .glass-alert { align-items: center; gap: var(--space-3); }
    .ds-alert--success.glass-alert { border-color: var(--success-border); }
    .glass-alert__ikon { width: 36px; height: 36px; border-radius: var(--radius-pill); flex-shrink: 0; display: grid; place-items: center; font-size: 16px; }
    .ds-alert--success .glass-alert__ikon { background: var(--success-tint); color: var(--success-ink); }
    .ds-alert--danger  .glass-alert__ikon { background: var(--danger-tint);  color: var(--danger-ink); }
    .glass-alert__judul { font-size: 13px; font-weight: 800; color: var(--ink-900); }
    .glass-alert__pesan { font-size: 12px; font-weight: 500; color: var(--ink-700); margin-top: 1px; }
</style>
@endonce
<div class="ds-alert ds-alert--{{ $type }} glass-alert" role="{{ $type === 'danger' ? 'alert' : 'status' }}">
    <span class="glass-alert__ikon"><i class="fa-solid {{ $type === 'danger' ? 'fa-circle-exclamation' : 'fa-circle-check' }}"></i></span>
    <div>
        <div class="glass-alert__judul">{{ $title }}</div>
        <div class="glass-alert__pesan">{{ $slot }}</div>
    </div>
</div>
