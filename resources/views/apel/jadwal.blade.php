<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }

.app-layout { display: block; min-height: 100vh; }
.main-content { padding: 28px 30px; min-width: 0; max-width: 80rem; margin: 0 auto; width: 100%; }

/* Header */
.page-header {
    background: linear-gradient(135deg, #1baf7a 0%, #2a78d6 100%);
    border-radius: 18px; padding: 30px 34px;
    color: white; margin-bottom: 24px;
    position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:220px; height:220px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:70px; bottom:-80px; width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:23px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.88; font-size:13px; position:relative; z-index:1; }

/* Selector */
.selector-card { background:white; border-radius:16px; padding:20px 22px; box-shadow:0 2px 12px rgba(0,0,0,.05); margin-bottom:20px; }
.selector-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; margin-bottom:8px; display:block; }
.selector-row { display:flex; gap:12px; flex-wrap:wrap; align-items:center; }
.select-wrap { position:relative; flex:1; min-width:260px; }
.select-wrap select {
    width:100%; appearance:none; padding:12px 40px 12px 15px;
    border:2px solid #e8ebf5; border-radius:11px; background:#fafbff;
    font-size:14px; font-family:'Inter',sans-serif; color:#333; font-weight:600;
    cursor:pointer; outline:none; transition:border-color .15s;
}
.select-wrap select:focus { border-color:#1baf7a; background:white; }
.select-wrap i { position:absolute; right:15px; top:50%; transform:translateY(-50%); color:#98a0b3; pointer-events:none; font-size:13px; }
.filter-chips { display:flex; gap:7px; flex-wrap:wrap; }
.chip {
    padding:7px 14px; border-radius:50px; font-size:12px; font-weight:600;
    cursor:pointer; border:2px solid #e2e5ee; background:white; color:#666; transition:all .15s;
}
.chip:hover { border-color:#1baf7a; color:#1baf7a; }
.chip.active { background:#1baf7a; color:white; border-color:#1baf7a; }

/* Detail */
.detail-card { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; }
.detail-head { padding:22px 26px; color:white; display:flex; align-items:center; gap:16px; flex-wrap:wrap; }
.detail-head .ikon { width:52px; height:52px; border-radius:14px; background:rgba(255,255,255,.22); display:flex; align-items:center; justify-content:center; font-size:21px; flex-shrink:0; }
.detail-head h2 { margin:0 0 3px; font-size:19px; font-weight:800; }
.detail-head .meta { font-size:13px; opacity:.9; display:flex; gap:14px; flex-wrap:wrap; }

.detail-body { padding:24px 26px; }
.info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:16px; }
.info-item { background:#fafbff; border:1px solid #eef0f7; border-radius:12px; padding:14px 16px; }
.info-item .label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; margin-bottom:5px; display:flex; align-items:center; gap:6px; }
.info-item .value { font-size:14px; font-weight:700; color:#2b2b33; }
.info-item .value small { display:block; font-size:11px; font-weight:500; color:#98a0b3; margin-top:2px; }

/* Empty */
.empty-state { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); text-align:center; padding:60px 24px; }
.empty-state i { font-size:46px; color:#e2e5ee; display:block; margin-bottom:14px; }
.empty-state p { font-size:14px; color:#98a0b3; margin:0; font-weight:600; }
</style>

<div class="app-layout">
    <x-island-navbar />

    <div class="main-content">

        <div class="page-header">
            <h1><i class="fas fa-flag" style="margin-right:10px;"></i>Jadwal Apel</h1>
            <p>Lihat waktu pelaksanaan, pembina, dan lokasi apel</p>
        </div>

        @if($daftarApel->isEmpty())
        <div class="empty-state">
            <i class="fas fa-flag"></i>
            <p>Belum ada jadwal apel yang tercatat.</p>
        </div>
        @else

        {{-- Dropdown pemilih apel --}}
        <div class="selector-card">
            <label class="selector-label" for="apelSelect">Pilih Apel</label>
            <div class="selector-row">
                <div class="select-wrap">
                    <select id="apelSelect" onchange="bukaApel(this.value)">
                        @foreach($daftarApel as $item)
                        <option value="{{ $item->id }}"
                                data-sesi="{{ $item->sesi }}"
                                @selected($terpilih && $terpilih->id === $item->id)>
                            {{ $item->label_dropdown }}@if($item->jam) · {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }}@endif
                        </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="filter-chips">
                    <div class="chip active" data-filter="all" onclick="filterSesi('all', this)">Semua</div>
                    <div class="chip" data-filter="pagi" onclick="filterSesi('pagi', this)">Pagi</div>
                    <div class="chip" data-filter="malam" onclick="filterSesi('malam', this)">Malam</div>
                    <div class="chip" data-filter="khusus" onclick="filterSesi('khusus', this)">Khusus</div>
                </div>
            </div>
        </div>

        {{-- Detail apel terpilih — hanya jadwal, pembina, lokasi --}}
        @if($terpilih)
        <div class="detail-card">
            <div class="detail-head" style="background:linear-gradient(135deg,{{ $terpilih->warna }},#2a78d6);">
                <div class="ikon"><i class="fas {{ $terpilih->ikon }}"></i></div>
                <div>
                    <h2>{{ $terpilih->judul }}</h2>
                    <div class="meta">
                        <span><i class="fas fa-calendar-day"></i>
                            {{ $terpilih->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                        @if($terpilih->jam)
                        <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($terpilih->jam)->format('H:i') }} WIB</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="detail-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="label"><i class="fas fa-user-tie"></i> Pembina Apel</div>
                        <div class="value">
                            {{ $terpilih->pembina }}
                            @if($terpilih->pembinaUser?->jabatan)
                            <small>{{ $terpilih->pembinaUser->jabatan }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="label"><i class="fas fa-location-dot"></i> Lokasi Apel</div>
                        <div class="value">{{ $terpilih->lokasi }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label"><i class="fas fa-flag"></i> Sesi</div>
                        <div class="value">{{ $terpilih->judul }}
                            <small>{{ ucfirst($terpilih->sesi) }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @endif
    </div>
</div>

<script>
function bukaApel(id) {
    window.location = '{{ route('apel.jadwal') }}?apel=' + id;
}

function filterSesi(sesi, chipEl) {
    document.querySelectorAll('.chip').forEach(c => c.classList.toggle('active', c === chipEl));

    const select = document.getElementById('apelSelect');
    let pertamaCocok = null;

    [...select.options].forEach(opt => {
        const cocok = sesi === 'all' || opt.dataset.sesi === sesi;
        opt.hidden = !cocok;
        if (cocok && pertamaCocok === null) pertamaCocok = opt;
    });

    if (pertamaCocok && select.selectedOptions[0].hidden) {
        bukaApel(pertamaCocok.value);
    }
}
</script>
</x-app-layout>
