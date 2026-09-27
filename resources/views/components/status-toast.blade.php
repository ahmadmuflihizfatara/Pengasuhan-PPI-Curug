{{-- Toast notifikasi perubahan status (PPI Curug Glass) — dipakai tab surat, barak & reward.
     Pakai: <x-status-toast /> lalu showStatusToast({ judul, pesan, sub, varian: 'success'|'danger'|'info'|'warning' }).
     Class gt-* sengaja bukan .toast agar tidak ditimpa Bootstrap (.toast:not(.show) { display:none }). --}}
@once
<style>
.gt-toasts { position: fixed; right: var(--space-4); bottom: var(--space-4); z-index: 9999; display: flex; flex-direction: column; gap: var(--space-2-5); width: min(380px, calc(100vw - 2 * var(--space-4))); pointer-events: none; }
.gt-toast {
    display: flex; align-items: flex-start; gap: var(--space-3); pointer-events: auto;
    padding: var(--space-3-5) var(--space-4); border-radius: var(--radius-lg);
    background: var(--glass-solid);
    backdrop-filter: blur(var(--blur-standard)) saturate(180%); -webkit-backdrop-filter: blur(var(--blur-standard)) saturate(180%);
    border: 1px solid var(--border-glass-glow); box-shadow: var(--shadow-glass-lg);
    animation: gt-masuk .3s cubic-bezier(.16,1,.3,1);
    transition: opacity .4s, transform .4s;
}
.gt-toast--keluar { opacity: 0; transform: translateX(16px); }
.gt-toast--success { border-color: var(--success-border); }
.gt-toast--danger  { border-color: var(--danger-border); }
.gt-toast--warning { border-color: var(--warning-border); }
.gt-toast__ikon { width: 36px; height: 36px; border-radius: var(--radius-pill); flex-shrink: 0; display: grid; place-items: center; font-size: 16px; }
.gt-toast--success .gt-toast__ikon { background: var(--success-tint); color: var(--success-ink); }
.gt-toast--danger  .gt-toast__ikon { background: var(--danger-tint);  color: var(--danger-ink); }
.gt-toast--warning .gt-toast__ikon { background: var(--warning-tint); color: var(--warning-ink); }
.gt-toast--info    .gt-toast__ikon { background: var(--info-tint);    color: var(--info-ink); }
.gt-toast__body { flex: 1; min-width: 0; }
.gt-toast__judul { font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
.gt-toast__pesan { margin-top: 2px; font-size: 12px; line-height: 17px; font-weight: 500; color: var(--ink-700); }
.gt-toast__sub { margin-top: var(--space-1); font-size: 11px; line-height: 16px; font-weight: 700; color: var(--accent-ink); overflow-wrap: anywhere; }
.gt-toast__tutup { flex-shrink: 0; width: 24px; height: 24px; margin: -2px -4px 0 0; padding: 0; border: 0; border-radius: var(--radius-pill); background: transparent; color: var(--ink-500); cursor: pointer; display: grid; place-items: center; font-size: 12px; transition: background-color .15s, color .15s; }
.gt-toast__tutup:hover { background: var(--glass-subtle); color: var(--ink-900); }
.gt-toast__tutup:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
@keyframes gt-masuk { from { opacity: 0; transform: translateX(110%); } to { opacity: 1; transform: none; } }
</style>

<div class="gt-toasts" id="gtToasts" aria-live="polite"></div>

<script>
function showStatusToast({ judul, pesan, sub = '', varian = 'info' }) {
    const ikon = { success: 'fa-circle-check', danger: 'fa-circle-xmark', warning: 'fa-hourglass-half', info: 'fa-rotate' }[varian] || 'fa-bell';
    const el = document.createElement('div');
    el.className = `gt-toast gt-toast--${varian}`;
    el.setAttribute('role', 'status');
    el.innerHTML = `
        <span class="gt-toast__ikon"><i class="fa-solid ${ikon}"></i></span>
        <div class="gt-toast__body">
            <div class="gt-toast__judul"></div>
            <div class="gt-toast__pesan"></div>
            <div class="gt-toast__sub"></div>
        </div>
        <button type="button" class="gt-toast__tutup" aria-label="Tutup notifikasi"><i class="fa-solid fa-xmark"></i></button>`;
    // Isi lewat textContent — teks berasal dari data pengajuan
    el.querySelector('.gt-toast__judul').textContent = judul;
    el.querySelector('.gt-toast__pesan').textContent = pesan;
    const subEl = el.querySelector('.gt-toast__sub');
    sub ? subEl.textContent = sub : subEl.remove();

    const tutup = () => { el.classList.add('gt-toast--keluar'); setTimeout(() => el.remove(), 400); };
    el.querySelector('.gt-toast__tutup').addEventListener('click', tutup);
    document.getElementById('gtToasts').appendChild(el);
    setTimeout(tutup, 8000);
}
</script>
@endonce
