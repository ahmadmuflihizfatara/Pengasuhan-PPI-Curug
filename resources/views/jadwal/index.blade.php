<x-app-layout>
<x-form-glass-style />
<style>
    [x-cloak] { display: none !important; }

    /* Petugas hari ini — kartu kaca dengan ikon aksen */
    .jd-hari { display: flex; align-items: center; gap: var(--space-4); flex-wrap: wrap; }
    .jd-hari .ds-stat__icon { width: 48px; height: 48px; font-size: 19px; flex-shrink: 0; }
    .jd-hari__isi { flex: 1; min-width: 0; }
    .jd-hari__label { font-size: 11px; line-height: 16px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .jd-hari__tgl { font-size: 15px; line-height: 20px; font-weight: 900; color: var(--ink-900); }
    .jd-orang-list { display: flex; gap: var(--space-2); flex-wrap: wrap; margin-top: var(--space-2-5); }
    .jd-orang { display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-1-5) var(--space-3) var(--space-1-5) var(--space-1-5); border-radius: var(--radius-pill); background: var(--glass-card); border: 1px solid var(--border-glass-glow); font-size: 12px; font-weight: 800; color: var(--ink-900); }
    .jd-orang .ds-avatar { width: 26px; height: 26px; font-size: 10px; }
    .jd-orang--saya { background: var(--accent-tint); border-color: var(--accent); }

    /* Alokasi mingguan */
    .jd-roster { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: var(--space-2-5); }
    .jd-roster__hari { padding: var(--space-3); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .jd-roster__hari--ini { background: var(--accent-tint); border-color: var(--accent); }
    .jd-roster__nama-hari { display: block; margin-bottom: var(--space-1-5); font-size: 10px; line-height: 14px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: var(--accent-ink); }
    .jd-roster__orang { display: block; font-size: 12px; line-height: 18px; font-weight: 700; color: var(--ink-900); }
    .jd-roster__kosong { font-size: 12px; font-style: italic; color: var(--ink-500); }

    /* Bar bulan */
    .jd-bar { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .jd-bulan { display: flex; align-items: center; gap: var(--space-2); }
    .jd-bulan__judul { min-width: 150px; text-align: center; font-size: 15px; line-height: 20px; font-weight: 900; color: var(--ink-900); }
    .jd-bar__kanan { display: flex; align-items: center; gap: var(--space-2); flex-wrap: wrap; }
    .jd-bar__kanan form { margin: 0; }
    .jd-filter.aktif { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); }

    /* Timeline */
    .timeline { position: relative; padding-left: 40px; display: flex; flex-direction: column; gap: var(--space-2-5); }
    .timeline::before { content: ''; position: absolute; left: 15px; top: 10px; bottom: 10px; width: 2px; border-radius: 2px; background: var(--border-glass-glow); }
    .tl-item { position: relative; }
    .tl-dot { position: absolute; left: -40px; top: 14px; z-index: 1; width: 32px; height: 32px; border-radius: 50%; display: grid; place-items: center; background: var(--glass-solid); border: 1.5px solid var(--border-glass-glow); font-family: var(--font-mono); font-size: 11px; font-weight: 800; color: var(--ink-600); box-shadow: var(--shadow-glass-sm); }
    .tl-item.is-today .tl-dot { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); box-shadow: 0 0 0 4px var(--focus-ring-glow); }
    .tl-card { display: flex; align-items: flex-start; gap: var(--space-4); flex-wrap: wrap; padding: var(--space-3) var(--space-4); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); transition: background-color .15s; }
    .tl-card:hover { background: var(--glass-solid); }
    .tl-item.is-today .tl-card { background: var(--accent-tint); border-color: var(--accent); }
    .tl-date { min-width: 118px; padding-top: 4px; }
    .tl-date .day-name { font-size: 10px; line-height: 14px; font-weight: 800; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .tl-date .day-full { font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
    .tl-petugas { flex: 1; min-width: 220px; display: flex; flex-direction: column; gap: var(--space-2); }
    .tl-pengasuh { display: flex; align-items: center; gap: var(--space-2-5); }
    .tl-pengasuh .ds-avatar { flex-shrink: 0; }
    .tl-pengasuh-name { flex: 1; min-width: 0; font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
    .tl-catatan { margin-top: 1px; font-size: 11px; line-height: 15px; font-weight: 500; color: var(--ink-600); }
    .tl-catatan i { color: var(--warning-ink); }
    .tl-kosong { font-size: 12px; font-style: italic; color: var(--ink-500); }
    .tl-status { margin-top: 4px; }

    /* Modal tukar jaga */
    #swapModal .form-group { text-align: left; }
    #swapModal textarea.form-control { resize: vertical; min-height: 64px; }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php
    $userId = Auth::id();
    $prev = \Carbon\Carbon::create($tahun, $bulan, 1)->subMonth();
    $next = \Carbon\Carbon::create($tahun, $bulan, 1)->addMonth();
    // Kunci hari sesuai Pengasuh::HARI (senin … minggu), Carbon dayOfWeekIso: 1 = Senin
    $hariIniKey = array_keys(\App\Models\Pengasuh::HARI)[now()->dayOfWeekIso - 1];
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Jadwal Pengasuh" icon="fa-user-clock"
                       :subtitle="'Jadwal jaga pengasuh bulanan — ' . \App\Models\Pengasuh::PER_HARI . ' pengasuh bertugas setiap hari'" />

        @include('jadwal._tabs', ['aktif' => 'pengasuh'])

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif
        @unless($bolehIsi)
        <div class="ds-alert ds-alert--warning" role="status">
            <i class="fa-solid fa-lock ds-icon"></i>
            <span>Akses pengisian jadwal pengasuh sedang ditutup admin — halaman tetap dapat dilihat, tetapi tidak dapat diubah.</span>
        </div>
        @endunless

        {{-- Petugas hari ini --}}
        @if($petugasHariIni && $petugasHariIni['petugas']->isNotEmpty())
        <div class="ds-card jd-hari mb-4">
            <span class="ds-stat__icon"><i class="fa-solid fa-user-shield"></i></span>
            <div class="jd-hari__isi">
                <div class="jd-hari__label">Bertugas Hari Ini</div>
                <div class="jd-hari__tgl">{{ $petugasHariIni['tanggal']->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                <div class="jd-orang-list">
                    @foreach($petugasHariIni['petugas'] as $x)
                    <span class="jd-orang {{ $x['pengasuh']->user_id === $userId ? 'jd-orang--saya' : '' }}">
                        <span class="ds-avatar">{{ strtoupper(substr($x['pengasuh']->nama, 0, 2)) }}</span>
                        {{ $x['pengasuh']->nama }}
                    </span>
                    @endforeach
                </div>
            </div>
            <span class="ds-badge ds-badge--{{ $petugasHariIni['tersimpan'] ? 'success' : 'warning' }}">
                <i class="fa-solid {{ $petugasHariIni['tersimpan'] ? 'fa-circle-check' : 'fa-circle-info' }}"></i>
                {{ $petugasHariIni['tersimpan'] ? 'Jadwal tersimpan' : 'Jadwal default mingguan' }}
            </span>
        </div>
        @endif

        {{-- Alokasi mingguan default --}}
        @if($semuaPengasuh->isNotEmpty())
        <div class="ds-card mb-4">
            <div class="ds-card__head">
                <h3 class="ds-card__title"><i class="fa-solid fa-repeat ds-icon"></i> Alokasi Mingguan Default</h3>
                <p class="ds-card__desc">Pengasuh yang bertugas setiap hari bila jadwal bulan belum diubah</p>
            </div>
            <div class="jd-roster">
                @foreach(\App\Models\Pengasuh::HARI as $hari => $label)
                <div class="jd-roster__hari {{ $hari === $hariIniKey ? 'jd-roster__hari--ini' : '' }}">
                    <span class="jd-roster__nama-hari">{{ $label }}</span>
                    @forelse($pengasuhByHari->get($hari, collect()) as $p)
                    <span class="jd-roster__orang">{{ $p->nama }}</span>
                    @empty
                    <span class="jd-roster__kosong">Belum ada pengasuh</span>
                    @endforelse
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Jadwal bulanan --}}
        <div class="ds-card">
            <div class="ds-card__head jd-bar">
                <div class="jd-bulan">
                    <a href="{{ route('jadwal.index', ['bulan' => $prev->month, 'tahun' => $prev->year]) }}" class="ds-btn ds-btn--icon" aria-label="Bulan sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
                    <span class="jd-bulan__judul">{{ \Carbon\Carbon::create($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM Y') }}</span>
                    <a href="{{ route('jadwal.index', ['bulan' => $next->month, 'tahun' => $next->year]) }}" class="ds-btn ds-btn--icon" aria-label="Bulan berikutnya"><i class="fa-solid fa-chevron-right"></i></a>
                </div>

                <div class="jd-bar__kanan">
                    <button type="button" class="ds-btn ds-btn--sm ds-btn--pill jd-filter" id="btnToggleHanyaSaya" onclick="toggleHanyaDinasSaya()" aria-pressed="false">
                        <i class="fa-solid fa-filter"></i> <span>Hanya dinas saya</span>
                    </button>

                    @if($semuaPengasuh->isNotEmpty())
                        @if($bulanDepan)
                        <span class="ds-badge ds-badge--warning"><i class="fa-solid fa-hourglass-half"></i> Belum waktunya — jadwal hanya sampai bulan berjalan</span>
                        @elseif($sudahDigenerate)
                        <span class="ds-badge ds-badge--success"><i class="fa-solid fa-circle-check"></i> Jadwal bulan ini sudah digenerate</span>
                        @elseif($bolehIsi)
                        <form method="POST" action="{{ route('jadwal.generate') }}">
                            @csrf
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">
                            <button type="submit" class="ds-btn ds-btn--primary ds-btn--sm"><i class="fa-solid fa-wand-magic-sparkles"></i> Generate Jadwal Bulan Ini</button>
                        </form>
                        @endif
                    @endif
                </div>
            </div>

            @if($semuaPengasuh->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-user-clock ds-icon"></i>
                Belum ada data pengasuh. Jalankan seeder PengasuhSeeder untuk membuat akun pengasuh.
            </div>
            @else
            <div class="timeline">
                @foreach($timeline as $item)
                @php
                    $tglKey    = $item['tanggal']->format('Y-m-d');
                    $tglLabel  = $item['tanggal']->locale('id')->isoFormat('dddd, D MMMM Y');
                    $dinasSaya = $item['petugas']->contains(fn ($x) => $x['pengasuh']->user_id === $userId);
                @endphp
                <div class="tl-item {{ $item['is_today'] ? 'is-today' : '' }}" data-saya="{{ $dinasSaya ? 1 : 0 }}">
                    <div class="tl-dot">{{ $item['tanggal']->format('d') }}</div>
                    <div class="tl-card">
                        <div class="tl-date">
                            <div class="day-name">{{ $item['is_today'] ? 'Hari ini · ' : '' }}{{ $item['tanggal']->locale('id')->isoFormat('dddd') }}</div>
                            <div class="day-full">{{ $item['tanggal']->locale('id')->isoFormat('D MMM Y') }}</div>
                        </div>

                        <div class="tl-petugas">
                            @forelse($item['petugas'] as $x)
                            <div class="tl-pengasuh">
                                <span class="ds-avatar">{{ strtoupper(substr($x['pengasuh']->nama, 0, 2)) }}</span>
                                <div class="tl-pengasuh-name">
                                    {{ $x['pengasuh']->nama }}
                                    @if($x['pengasuh']->user_id === $userId)
                                    <span class="ds-badge ds-badge--accent"><i class="fa-solid fa-user-check"></i> Dinas saya</span>
                                    @endif
                                    @if($x['catatan'])
                                    <div class="tl-catatan"><i class="fa-solid fa-note-sticky"></i> {{ $x['catatan'] }}</div>
                                    @endif
                                </div>
                                @if($bolehIsi && !$bulanDepan)
                                <button type="button" class="ds-btn ds-btn--xs"
                                        onclick="bukaSwapModal('{{ $tglKey }}', '{{ $tglLabel }}', {{ $x['pengasuh']->id }}, @js($x['pengasuh']->nama), @js($x['catatan'] ?? ''))">
                                    <i class="fa-solid fa-right-left"></i> Tukar
                                </button>
                                @endif
                            </div>
                            @empty
                            <span class="tl-kosong">Belum ada pengasuh untuk hari ini</span>
                            @endforelse

                            @if($bolehIsi && !$bulanDepan && $item['petugas']->count() < \App\Models\Pengasuh::PER_HARI)
                            <div>
                                <button type="button" class="ds-btn ds-btn--xs" onclick="bukaSwapModal('{{ $tglKey }}', '{{ $tglLabel }}', null, null, '')">
                                    <i class="fa-solid fa-plus"></i> Tambah Pengasuh
                                </button>
                            </div>
                            @endif
                        </div>

                        <span class="ds-badge ds-badge--{{ $item['tersimpan'] ? 'success' : 'warning' }} tl-status">{{ $item['tersimpan'] ? 'Tersimpan' : 'Default' }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="ds-empty" id="kosongDinasSaya" style="display:none;">
                <i class="fa-solid fa-calendar-xmark ds-icon"></i>
                Anda tidak memiliki jadwal dinas pada bulan ini.
            </div>
            @endif
        </div>

    </div>
</main>

{{-- Modal tukar jaga (di luar panel kaca agar position:fixed tidak terkurung backdrop-filter) --}}
<div class="ds-modal-overlay" id="swapModal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="swapJudul">
    <form method="POST" action="{{ route('jadwal.set') }}" class="ds-modal">
        @csrf
        <input type="hidden" name="tanggal" id="swapTanggal">
        <input type="hidden" name="ganti_id" id="swapGanti">

        <div class="ds-modal__icon" style="background:var(--accent-tint); color:var(--accent);"><i class="fa-solid fa-right-left"></i></div>
        <h3 class="ds-modal__title" id="swapJudul">Tukar Jaga</h3>
        <p class="ds-modal__body" id="swapTanggalLabel"></p>

        <div class="form-group">
            <label class="form-label" for="swapPengasuh">Pengasuh Bertugas <span class="req">*</span></label>
            <select name="pengasuh_id" id="swapPengasuh" class="form-select" required>
                @foreach($semuaPengasuh as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->hari_label }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label" for="swapCatatan">Catatan <span style="text-transform:none; letter-spacing:0; color:var(--ink-500);">(opsional)</span></label>
            <textarea name="catatan" id="swapCatatan" class="form-control" placeholder="Contoh: tukar jaga dengan pengasuh hari Rabu"></textarea>
        </div>

        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" onclick="tutupSwapModal()">Batal</button>
            <button type="submit" class="ds-btn ds-btn--primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
        </div>
    </form>
</div>

<script>
function bukaSwapModal(tanggal, tanggalLabel, pengasuhId, pengasuhNama, catatan) {
    document.getElementById('swapTanggal').value = tanggal;
    document.getElementById('swapGanti').value = pengasuhId || '';
    document.getElementById('swapTanggalLabel').textContent = pengasuhNama
        ? tanggalLabel + ' — menggantikan ' + pengasuhNama
        : tanggalLabel + ' — tambah pengasuh bertugas';
    document.getElementById('swapCatatan').value = catatan || '';
    if (pengasuhId) document.getElementById('swapPengasuh').value = pengasuhId;
    document.getElementById('swapModal').style.display = 'flex';
    document.getElementById('swapPengasuh').focus();
}
function tutupSwapModal() {
    document.getElementById('swapModal').style.display = 'none';
}
document.getElementById('swapModal').addEventListener('click', function (e) {
    if (e.target === this) tutupSwapModal();
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') tutupSwapModal();
});

let hanyaDinasSaya = false;
function toggleHanyaDinasSaya() {
    hanyaDinasSaya = !hanyaDinasSaya;
    const btn = document.getElementById('btnToggleHanyaSaya');
    btn.classList.toggle('aktif', hanyaDinasSaya);
    btn.setAttribute('aria-pressed', hanyaDinasSaya);
    btn.querySelector('span').textContent = hanyaDinasSaya ? 'Menampilkan dinas saya' : 'Hanya dinas saya';
    btn.querySelector('i').className = 'fa-solid ' + (hanyaDinasSaya ? 'fa-check' : 'fa-filter');

    let tampil = 0;
    document.querySelectorAll('.tl-item').forEach(item => {
        const lihat = !hanyaDinasSaya || item.dataset.saya === '1';
        item.style.display = lihat ? '' : 'none';
        if (lihat) tampil++;
    });
    const kosong = document.getElementById('kosongDinasSaya');
    if (kosong) kosong.style.display = tampil ? 'none' : '';
}
</script>
</x-app-layout>
