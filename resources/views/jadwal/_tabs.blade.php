{{-- Sub-tab navigasi halaman Jadwal (pengasuh): jadwal pengasuh & duty taruna --}}
<div class="subtab-row">
    <a href="{{ route('jadwal.index') }}" class="subtab {{ ($aktif ?? '') === 'pengasuh' ? 'active' : '' }}">
        <i class="fas fa-user-clock"></i> Jadwal Pengasuh
    </a>
    <a href="{{ route('duty.index') }}" class="subtab {{ ($aktif ?? '') === 'duty' ? 'active' : '' }}">
        <i class="fas fa-user-group"></i> Duty Taruna
    </a>
</div>
