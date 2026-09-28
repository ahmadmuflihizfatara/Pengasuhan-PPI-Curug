<x-app-layout>
<x-form-glass-style />
<style>
/* Alokasi pengasuh per hari — PPI Curug Glass */
.al-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: var(--space-4); margin-bottom: var(--space-4); }
.al-hari { display: flex; flex-direction: column; }
.al-hari--hariini { border-color: var(--accent); box-shadow: 0 0 0 3px var(--focus-ring-glow), var(--shadow-glass-sm); }
.al-hari .ds-card__head { display: flex; align-items: center; justify-content: space-between; gap: var(--space-2); flex-wrap: wrap; }
.al-hari__badge { display: flex; gap: var(--space-1-5); flex-wrap: wrap; }
.al-slot { display: flex; align-items: center; gap: var(--space-2-5); margin-bottom: var(--space-2-5); }
.al-slot:last-child { margin-bottom: 0; }
.al-slot__no { width: 24px; height: 24px; flex-shrink: 0; border-radius: var(--radius-pill); display: grid; place-items: center; font-size: 10px; font-weight: 800; background: var(--accent-tint); color: var(--accent-ink); }
.al-slot .form-select { cursor: pointer; }
/* !important: app.css memaksa border & background semua .form-select */
.al-slot .form-select.al-dobel { border-color: var(--danger) !important; background-color: var(--danger-tint) !important; color: var(--danger-ink); }

.al-belum { display: flex; gap: var(--space-2); flex-wrap: wrap; }
.al-simpan { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
.al-simpan__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
.al-simpan__teks i { color: var(--accent); margin-right: var(--space-1-5); }
.al-simpan__teks--dobel, .al-simpan__teks--dobel i { color: var(--danger-ink); }
.al-simpan__aksi { display: flex; gap: var(--space-2); }
</style>

<x-island-navbar />

@php
    $perHari     = \App\Models\Pengasuh::PER_HARI;
    $hariIni     = array_keys(\App\Models\Pengasuh::HARI)[now()->dayOfWeekIso - 1];
    $dialokasi   = $semuaPengasuh->whereNotNull('hari')->count();
    $hariLengkap = collect(\App\Models\Pengasuh::HARI)->keys()->filter(fn ($h) => $pengasuhByHari->get($h, collect())->count() === $perHari)->count();
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Alokasi Pengasuh" icon="fa-calendar-week"
            :subtitle="'Tetapkan ' . $perHari . ' pengasuh yang bertugas default setiap hari — dipakai saat generate jadwal pengasuh'" />

        @include('jadwal._tabs', ['aktif' => 'alokasi'])

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Alokasi belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-4">
            <x-stat-card title="Total Pengasuh" :value="$semuaPengasuh->count()" icon="fa-solid fa-users"
                varian="accent" badge="Terdaftar" badgeType="accent" description="Semua pengasuh di sistem" />
            <x-stat-card title="Sudah Dialokasikan" :value="$dialokasi" icon="fa-solid fa-user-check"
                varian="success" :badge="($semuaPengasuh->count() - $dialokasi) . ' belum'" :badgeType="$dialokasi === $semuaPengasuh->count() ? 'success' : 'warning'" description="Punya hari tugas default" />
            <x-stat-card title="Hari Lengkap" :value="$hariLengkap . '/7'" icon="fa-solid fa-calendar-check"
                :varian="$hariLengkap === 7 ? 'success' : 'warning'" :badge="$perHari . ' / hari'" badgeType="info" description="Hari dengan slot pengasuh penuh" />
        </div>

        <div class="ds-alert ds-alert--info mb-4" role="status">
            <i class="fa-solid fa-circle-info ds-icon"></i>
            <span>Alokasi dipakai untuk tanggal yang belum digenerate dan saat generate jadwal berikutnya. Jadwal yang sudah tersimpan
                  tidak berubah — gunakan tombol <strong>Tukar</strong> di Jadwal Pengasuh. Satu pengasuh hanya bertugas di satu hari.</span>
        </div>

        <form method="POST" action="{{ route('jadwal.alokasi.simpan') }}" id="formAlokasi">
            @csrf
            @method('PUT')

            <div class="al-grid">
                @foreach(\App\Models\Pengasuh::HARI as $hari => $label)
                @php $sekarang = $pengasuhByHari->get($hari, collect())->pluck('id')->values(); @endphp
                <div class="ds-card al-hari {{ $hari === $hariIni ? 'al-hari--hariini' : '' }}">
                    <div class="ds-card__head">
                        <h2 class="ds-card__title"><i class="fa-solid fa-calendar-day ds-icon"></i> {{ $label }}</h2>
                        <span class="al-hari__badge">
                            @if($hari === $hariIni)<span class="ds-badge ds-badge--accent">Hari ini</span>@endif
                            <span class="ds-badge {{ $sekarang->count() === $perHari ? 'ds-badge--success' : 'ds-badge--warning' }}" data-hitung="{{ $hari }}">{{ $sekarang->count() }}/{{ $perHari }} pengasuh</span>
                        </span>
                    </div>

                    @for($i = 0; $i < $perHari; $i++)
                    @php $dipilih = old("alokasi.$hari.$i", $sekarang->get($i)); @endphp
                    <div class="al-slot">
                        <span class="al-slot__no">{{ $i + 1 }}</span>
                        <select name="alokasi[{{ $hari }}][]" class="form-select" data-hari="{{ $hari }}" aria-label="Pengasuh {{ $label }} ke-{{ $i + 1 }}">
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

            <div class="ds-card mb-4">
                <div class="ds-card__head tbl-head">
                    <div>
                        <h2 class="ds-card__title"><i class="fa-solid fa-user-clock ds-icon"></i> Belum Dialokasikan</h2>
                        <p class="ds-card__desc">Pengasuh yang belum dipilih di hari mana pun — ikut berubah saat Anda memilih</p>
                    </div>
                    <span class="ds-badge ds-badge--warning" id="belumJumlah">0 pengasuh</span>
                </div>
                <div class="al-belum" id="belumDaftar"></div>
                <div class="ds-empty" id="belumKosong" style="display:none; padding-top:0; padding-bottom:0;">
                    <i class="fa-solid fa-circle-check ds-icon"></i> Semua pengasuh sudah punya hari tugas.
                </div>
            </div>

            <div class="ds-card al-simpan">
                <span class="al-simpan__teks" id="simpanTeks"><i class="fa-solid fa-floppy-disk"></i>Simpan untuk menerapkan alokasi ke generate jadwal berikutnya</span>
                <div class="al-simpan__aksi">
                    <a href="{{ route('jadwal.index') }}" class="ds-btn"><i class="fa-solid fa-xmark"></i> Batal</a>
                    <button type="submit" class="ds-btn ds-btn--primary" id="btnSimpan"><i class="fa-solid fa-floppy-disk"></i> Simpan Alokasi</button>
                </div>
            </div>
        </form>

    </div>
</main>

<script>
// Ringkasan langsung: tandai pengasuh dobel, hitung slot per hari, dan daftar yang belum dialokasikan.
// Server tetap memvalidasi (satu pengasuh = satu hari).
(function () {
    const PER_HARI = {{ $perHari }};
    const selects = [...document.querySelectorAll('#formAlokasi select')];
    const semua = [...selects[0].options].filter(o => o.value).map(o => ({ id: o.value, nama: o.textContent }));
    const teks = document.getElementById('simpanTeks');
    const teksAwal = teks.innerHTML;

    function perbarui() {
        const hitung = {};
        selects.forEach(s => { if (s.value) hitung[s.value] = (hitung[s.value] || 0) + 1; });
        const adaDobel = selects.some(s => s.value && hitung[s.value] > 1);
        selects.forEach(s => s.classList.toggle('al-dobel', !!s.value && hitung[s.value] > 1));

        document.querySelectorAll('[data-hitung]').forEach(b => {
            const n = selects.filter(s => s.dataset.hari === b.dataset.hitung && s.value).length;
            b.textContent = n + '/' + PER_HARI + ' pengasuh';
            b.className = 'ds-badge ' + (n === PER_HARI ? 'ds-badge--success' : 'ds-badge--warning');
        });

        const belum = semua.filter(p => !hitung[p.id]);
        document.getElementById('belumDaftar').replaceChildren(...belum.map(p => Object.assign(document.createElement('span'), { className: 'ds-badge', textContent: p.nama })));
        const jumlah = document.getElementById('belumJumlah');
        jumlah.textContent = belum.length + ' pengasuh';
        jumlah.className = 'ds-badge ' + (belum.length ? 'ds-badge--warning' : 'ds-badge--success');
        document.getElementById('belumKosong').style.display = belum.length ? 'none' : '';

        teks.classList.toggle('al-simpan__teks--dobel', adaDobel);
        teks.innerHTML = adaDobel ? '<i class="fa-solid fa-triangle-exclamation"></i>Ada pengasuh yang dipilih di lebih dari satu slot — perbaiki slot bertanda merah' : teksAwal;
        document.getElementById('btnSimpan').disabled = adaDobel;
    }

    selects.forEach(s => s.addEventListener('change', perbarui));
    perbarui();
})();
</script>
</x-app-layout>
