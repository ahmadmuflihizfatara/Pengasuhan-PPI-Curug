{{-- Sub-tab navigasi halaman Jadwal (pengasuh): jadwal pengasuh & duty taruna; admin: + alokasi pengasuh --}}
@once
<style>
    .subtab-row { display: flex; gap: var(--space-1); flex-wrap: wrap; width: fit-content; max-width: 100%; margin-bottom: var(--space-4); padding: var(--space-1); border-radius: var(--radius-pill); background: var(--glass-panel); border: 1px solid var(--border-glass); box-shadow: var(--shadow-glass-sm); backdrop-filter: blur(var(--blur-subtle)); -webkit-backdrop-filter: blur(var(--blur-subtle)); }
    .subtab { display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-2) var(--space-4); border: 1px solid transparent; border-radius: var(--radius-pill); text-decoration: none; font-size: 13px; line-height: 18px; font-weight: 700; color: var(--ink-700); transition: background-color .15s, color .15s, box-shadow .15s; }
    .subtab:hover { background: var(--glass-card); color: var(--ink-900); }
    .subtab:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .subtab.active, .subtab.active:hover { background: var(--accent); color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    @media (max-width: 480px) { .subtab-row { width: 100%; } .subtab { flex: 1; justify-content: center; padding: var(--space-2); font-size: 12px; } }
</style>
@endonce
<nav class="subtab-row" aria-label="Sub-menu jadwal">
    <a href="{{ route('jadwal.index') }}" class="subtab {{ ($aktif ?? '') === 'pengasuh' ? 'active' : '' }}" @if(($aktif ?? '') === 'pengasuh') aria-current="page" @endif>
        <i class="fa-solid fa-user-clock"></i> Jadwal Pengasuh
    </a>
    <a href="{{ route('duty.index') }}" class="subtab {{ ($aktif ?? '') === 'duty' ? 'active' : '' }}" @if(($aktif ?? '') === 'duty') aria-current="page" @endif>
        <i class="fa-solid fa-user-group"></i> Duty Taruna
    </a>
    @if(auth()->user()?->isAdmin())
    <a href="{{ route('jadwal.alokasi') }}" class="subtab {{ ($aktif ?? '') === 'alokasi' ? 'active' : '' }}" @if(($aktif ?? '') === 'alokasi') aria-current="page" @endif>
        <i class="fa-solid fa-calendar-week"></i> Alokasi Pengasuh
    </a>
    @endif
</nav>
