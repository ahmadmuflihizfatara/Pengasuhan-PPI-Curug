<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

/* Header */
.page-header {
    background: linear-gradient(135deg, #1baf7a 0%, #2a78d6 100%);
    border-radius: 18px; padding: 30px 34px;
    color: white; margin-bottom: 24px;
    position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:220px; height:220px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:70px; bottom:-80px; width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:23px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.88; font-size:13px; position:relative; z-index:1; }

.btn-primary {
    background:white; color:#1baf7a; border:none;
    padding:11px 20px; border-radius:11px; font-size:13px; font-weight:700;
    cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px;
    position:relative; z-index:1; transition:transform .15s, box-shadow .15s;
    box-shadow:0 4px 14px rgba(0,0,0,.12);
}
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 22px rgba(0,0,0,.18); color:#1baf7a; }

.flash-success { background:#f0fff4; border:1px solid #c6f6d5; color:#276749; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:8px; }

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
.detail-actions { margin-left:auto; display:flex; gap:9px; }
.btn-ghost {
    background:rgba(255,255,255,.2); color:white; border:none;
    padding:8px 15px; border-radius:9px; font-size:12px; font-weight:700;
    cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px;
    transition:background .15s; font-family:'Inter',sans-serif;
}
.btn-ghost:hover { background:rgba(255,255,255,.33); color:white; }

.detail-body { padding:24px 26px; }
.info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:16px; margin-bottom:22px; }
.info-item { background:#fafbff; border:1px solid #eef0f7; border-radius:12px; padding:14px 16px; }
.info-item .label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; margin-bottom:5px; display:flex; align-items:center; gap:6px; }
.info-item .value { font-size:14px; font-weight:700; color:#2b2b33; }
.info-item .value small { display:block; font-size:11px; font-weight:500; color:#98a0b3; margin-top:2px; }

.text-block { margin-bottom:18px; }
.text-block h3 { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; margin:0 0 7px; display:flex; align-items:center; gap:6px; }
.text-block .isi { font-size:13.5px; color:#444; line-height:1.65; white-space:pre-line; background:#fafbff; border-left:3px solid #1baf7a; border-radius:0 10px 10px 0; padding:13px 16px; }
.text-block .isi.kosong { color:#b9bfcc; font-style:italic; border-left-color:#e2e5ee; }

.detail-foot { border-top:1px solid #f0f2f7; padding:14px 26px; font-size:11.5px; color:#a0a6b6; display:flex; justify-content:space-between; flex-wrap:wrap; gap:8px; }

/* Empty */
.empty-state { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); text-align:center; padding:60px 24px; }
.empty-state i { font-size:46px; color:#e2e5ee; display:block; margin-bottom:14px; }
.empty-state p { font-size:14px; color:#98a0b3; margin:0 0 18px; font-weight:600; }
.btn-solid {
    background:linear-gradient(135deg,#1baf7a,#2a78d6); color:white; border:none;
    padding:11px 22px; border-radius:11px; font-size:13px; font-weight:700;
    cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px;
}
.btn-solid:hover { opacity:.9; color:white; }
</style>

<div class="app-layout">
    <x-sidebar active="apel" />

    <div class="main-content">

        <div class="page-header">
            <div>
                <h1><i class="fas fa-flag" style="margin-right:10px;"></i>Apel</h1>
                <p>Pilih apel berdasarkan tanggal dan sesi untuk melihat pembina, informasi, dan lokasi</p>
            </div>
            <a href="{{ route('apel.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Isi Data Apel
            </a>
        </div>

        @if(session('success'))
        <div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if($daftarApel->isEmpty())
        <div class="empty-state">
            <i class="fas fa-flag"></i>
            <p>Belum ada data apel yang tercatat.</p>
            <a href="{{ route('apel.create') }}" class="btn-solid">
                <i class="fas fa-plus"></i> Isi Data Apel Pertama
            </a>
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

        {{-- Detail apel terpilih --}}
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
                <div class="detail-actions">
                    <a href="{{ route('apel.edit', $terpilih) }}" class="btn-ghost">
                        <i class="fas fa-pen"></i> Ubah
                    </a>
                    <button type="button" class="btn-ghost" onclick="konfirmasiHapus()">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
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

                <div class="text-block">
                    <h3><i class="fas fa-circle-info"></i> Informasi Apel</h3>
                    <div class="isi {{ $terpilih->informasi ? '' : 'kosong' }}">{{ $terpilih->informasi ?: 'Belum ada informasi apel yang diisi.' }}</div>
                </div>

                @if($terpilih->keterangan)
                <div class="text-block">
                    <h3><i class="fas fa-note-sticky"></i> Keterangan Tambahan</h3>
                    <div class="isi">{{ $terpilih->keterangan }}</div>
                </div>
                @endif
            </div>

            <div class="detail-foot">
                <span><i class="fas fa-user-pen"></i> Diisi oleh: {{ $terpilih->pembuat?->name ?? '—' }}</span>
                <span>Terakhir diperbarui {{ $terpilih->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
            </div>
        </div>

        <form id="formHapus" method="POST" action="{{ route('apel.destroy', $terpilih) }}" style="display:none;">
            @csrf @method('DELETE')
        </form>
        @endif

        @endif
    </div>
</div>

<script>
function bukaApel(id) {
    window.location = '{{ route('apel.index') }}?apel=' + id;
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

    // Kalau pilihan aktif tersembunyi oleh filter, lompat ke apel pertama yang cocok
    if (pertamaCocok && select.selectedOptions[0].hidden) {
        bukaApel(pertamaCocok.value);
    }
}

function konfirmasiHapus() {
    if (confirm('Hapus data apel ini? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('formHapus').submit();
    }
}
</script>
</x-app-layout>
