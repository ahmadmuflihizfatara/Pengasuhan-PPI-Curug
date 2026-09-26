<x-app-layout>
<style>
/* Sub-tab (sama dengan halaman jadwal lain) */
.subtab-row { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
.subtab {
    padding:10px 18px; border-radius:11px; font-size:13px; font-weight:700;
    text-decoration:none; color:#666; display:inline-flex; align-items:center; gap:8px; transition:all .15s;
}

/* Alokasi — PPI Curug Glass (ds-card, ds-select, ds-badge) */
.alokasi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: var(--space-4); margin-bottom: var(--space-5); }
.alokasi-card .ds-card__head { display: flex; align-items: center; justify-content: space-between; gap: var(--space-2); }
.alokasi-slot { display: flex; align-items: center; gap: var(--space-2-5); margin-bottom: var(--space-2-5); }
.alokasi-slot:last-child { margin-bottom: 0; }
.alokasi-slot__no {
    width: 24px; height: 24px; border-radius: var(--radius-pill); flex-shrink: 0;
    display: grid; place-items: center; font-size: 10px; font-weight: 800;
    background: var(--accent-tint); color: var(--accent-ink);
}
.alokasi-slot .ds-select { cursor: pointer; }
.alokasi-aksi { display: flex; justify-content: flex-end; gap: var(--space-2); flex-wrap: wrap; }
.belum-list { display: flex; gap: var(--space-2); flex-wrap: wrap; }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Alokasi Pengasuh"
                       :subtitle="'Tetapkan ' . \App\Models\Pengasuh::PER_HARI . ' pengasuh yang bertugas default setiap hari'" />

        @include('jadwal._tabs', ['aktif' => 'alokasi'])

        @if(session('success'))
        <div class="ds-alert ds-alert--success"><i class="fas fa-check-circle ds-icon"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="ds-alert ds-alert--danger"><i class="fas fa-exclamation-circle ds-icon"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
        <div class="ds-alert ds-alert--danger">
            <i class="fas fa-exclamation-circle ds-icon"></i>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="ds-alert ds-alert--info">
            <i class="fas fa-circle-info ds-icon"></i>
            <span>Alokasi dipakai untuk tanggal yang belum digenerate dan saat generate jadwal berikutnya. Jadwal yang sudah tersimpan
                  tidak berubah — gunakan tombol <strong>Tukar</strong> di Jadwal Pengasuh. Satu pengasuh hanya bertugas di satu hari.</span>
        </div>

        <form method="POST" action="{{ route('jadwal.alokasi.simpan') }}" id="formAlokasi">
            @csrf
            @method('PUT')

            <div class="alokasi-grid">
                @foreach(\App\Models\Pengasuh::HARI as $hari => $label)
                @php $sekarang = $pengasuhByHari->get($hari, collect())->pluck('id')->values(); @endphp
                <div class="ds-card alokasi-card">
                    <div class="ds-card__head">
                        <h2 class="ds-card__title"><i class="fas fa-calendar-day ds-icon"></i> {{ $label }}</h2>
                        <span class="ds-badge {{ $sekarang->count() === \App\Models\Pengasuh::PER_HARI ? 'ds-badge--success' : 'ds-badge--warning' }}">
                            {{ $sekarang->count() }}/{{ \App\Models\Pengasuh::PER_HARI }} pengasuh
                        </span>
                    </div>

                    @for($i = 0; $i < \App\Models\Pengasuh::PER_HARI; $i++)
                    @php $dipilih = old("alokasi.$hari.$i", $sekarang->get($i)); @endphp
                    <div class="alokasi-slot">
                        <span class="alokasi-slot__no">{{ $i + 1 }}</span>
                        <select name="alokasi[{{ $hari }}][]" class="ds-select" aria-label="Pengasuh {{ $label }} ke-{{ $i + 1 }}">
                            <option value="">— Kosong —</option>
                            @foreach($semuaPengasuh as $p)
                            <option value="{{ $p->id }}" @selected((string) $dipilih === (string) $p->id)>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endfor
                </div>
                @endforeach
            </div>

            @php $belum = $semuaPengasuh->whereNull('hari'); @endphp
            @if($belum->isNotEmpty())
            <div class="ds-card mb-4">
                <div class="ds-card__head">
                    <h2 class="ds-card__title"><i class="fas fa-user-clock ds-icon"></i> Belum Dialokasikan</h2>
                    <p class="ds-card__desc">Pengasuh berikut belum punya hari tugas default.</p>
                </div>
                <div class="belum-list">
                    @foreach($belum as $p)
                    <span class="ds-badge">{{ $p->nama }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="alokasi-aksi">
                <a href="{{ route('jadwal.index') }}" class="ds-btn">Batal</a>
                <button type="submit" class="ds-btn ds-btn--primary"><i class="fas fa-save"></i> Simpan Alokasi</button>
            </div>
        </form>

    </div>
</main>

<script>
// Tandai pengasuh yang dipilih di lebih dari satu slot (server tetap memvalidasi)
(function () {
    const selects = document.querySelectorAll('#formAlokasi select');
    function tandaiDobel() {
        const hitung = {};
        selects.forEach(s => { if (s.value) hitung[s.value] = (hitung[s.value] || 0) + 1; });
        selects.forEach(s => s.classList.toggle('ds-input--invalid', !!s.value && hitung[s.value] > 1));
    }
    selects.forEach(s => s.addEventListener('change', tandaiDobel));
    tandaiDobel();
})();
</script>
</x-app-layout>
