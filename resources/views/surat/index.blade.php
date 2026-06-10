<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.app-layout {
    display: flex;
    min-height: 100vh;
}

/* ===== MAIN ===== */
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: space-between;
}
.page-header::before { content: ''; position: absolute; right: -50px; top: -50px; width: 180px; height: 180px; background: rgba(255,255,255,.08); border-radius: 50%; }
.page-header::after  { content: ''; position: absolute; right: 80px; bottom: -60px; width: 140px; height: 140px; background: rgba(255,255,255,.05); border-radius: 50%; }
.page-header-text { position: relative; z-index: 1; }
.page-header h1 { margin: 0 0 4px 0; font-size: 22px; font-weight: 800; }
.page-header p  { margin: 0; opacity: .85; font-size: 13px; }
.btn-add { position: relative; z-index: 1; background: white; color: #667eea; padding: 11px 22px; border-radius: 25px; text-decoration: none; font-size: 13px; font-weight: 800; display: flex; align-items: center; gap: 7px; white-space: nowrap; box-shadow: 0 4px 15px rgba(0,0,0,.15); transition: transform .15s; }
.btn-add:hover { transform: translateY(-2px); color: #667eea; }

.alert-success { background: linear-gradient(135deg,#43e97b,#38f9d7); color: white; padding: 13px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 13px; }

/* Stats */
.stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 20px; }
.stat-card  { background: white; border-radius: 14px; padding: 16px; box-shadow: 0 2px 10px rgba(0,0,0,.05); text-align: center; }
.stat-icon  { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 17px; color: white; }
.stat-count { font-size: 24px; font-weight: 800; color: #333; line-height: 1; }
.stat-label { font-size: 11px; color: #999; font-weight: 600; margin-top: 4px; }

/* Filter bar */
.filter-bar { background: white; border-radius: 14px; padding: 16px 20px; box-shadow: 0 2px 10px rgba(0,0,0,.05); margin-bottom: 18px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.search-wrap  { flex: 1; min-width: 200px; position: relative; }
.search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 12px; }
.search-input  { width: 100%; padding: 9px 12px 9px 32px; border: 1.5px solid #edf0f7; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; outline: none; color: #444; background: #fafbff; transition: border .15s; }
.search-input:focus { border-color: #667eea; }
.filter-select { padding: 9px 14px; border: 1.5px solid #edf0f7; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; color: #444; outline: none; background: #fafbff; cursor: pointer; }
.btn-filter { background: linear-gradient(135deg,#667eea,#764ba2); color: white; border: none; padding: 9px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px; }
.btn-reset  { color: #999; font-size: 13px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 5px; }

/* Table */
.card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.06); }
.empty-state   { text-align: center; padding: 60px 20px; }
.empty-state i { font-size: 54px; color: #e2e5ee; display: block; margin-bottom: 14px; }
.empty-state h4 { color: #aab; margin: 0 0 6px; font-size: 15px; }
.empty-state p  { color: #ccc; margin: 0 0 18px; font-size: 13px; }
.btn-primary-pill { background: linear-gradient(135deg,#667eea,#764ba2); color: white; padding: 10px 26px; border-radius: 25px; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }

table { width: 100%; border-collapse: collapse; }
thead tr { background: linear-gradient(135deg,#667eea,#764ba2); }
th { padding: 13px 14px; text-align: left; color: white; font-size: 10px; font-weight: 700; letter-spacing: .06em; }
td { padding: 12px 14px; font-size: 13px; color: #444; border-top: 1px solid #f0f2f7; vertical-align: middle; }
tbody tr { transition: background .1s; }
tbody tr:hover { background: #f8f9ff; }

.jenis-badge  { background: #eef0ff; color: #667eea; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; }
.status-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; }
.btn-view   { background: #e0f7ff; color: #0bc5ea; border: none; padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; cursor: pointer; }
.btn-edit   { background: #eef0ff; color: #667eea; border: none; padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; cursor: pointer; }
.btn-delete { background: #fff0f0; color: #e53e3e; border: none; padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; }
.btn-view:hover   { background: #c0efff; }
.btn-edit:hover   { background: #dde2ff; }
.btn-delete:hover { background: #ffe0e0; }
.btn-approve-ico { background: #e6fff5; color: #38a169; border: none; padding: 6px 9px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; transition: background .1s; }
.btn-approve-ico:hover { background: #c6f6d5; }
.btn-reject-ico { background: #fff5f5; color: #e53e3e; border: none; padding: 6px 9px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; transition: background .1s; }
.btn-reject-ico:hover { background: #fed7d7; }

/* Modal */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:20px; padding:30px 28px; max-width:390px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,.2); text-align:center; animation:modalIn .2s ease; }
@keyframes modalIn { from{transform:scale(.93);opacity:0} to{transform:scale(1);opacity:1} }
.modal-icon-wrap { width:56px; height:56px; border-radius:50%; background:#fff0f0; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.modal-icon-wrap i { font-size:24px; color:#e53e3e; }
.modal-box h3  { margin:0 0 6px; font-size:17px; font-weight:800; color:#333; }
.modal-label   { font-weight:600; color:#333; margin:0 0 6px; font-size:13px; }
.modal-sub     { color:#aab; font-size:12px; margin:0 0 22px; }
.modal-actions { display:flex; gap:10px; justify-content:center; }
.modal-cancel  { background:#f4f5f9; color:#666; border:none; padding:10px 24px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-cancel:hover  { background:#e8e9f0; }
.modal-confirm { background:linear-gradient(135deg,#fc5c7d,#e53e3e); color:white; border:none; padding:10px 24px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-confirm:hover { opacity:.9; }

/* Pagination */
.pagination-bar   { padding: 14px 18px; border-top: 1px solid #f0f2f7; display: flex; align-items: center; justify-content: space-between; }
.pagination-info  { font-size: 12px; color: #aab; }
.pagination-links { display: flex; gap: 6px; }
.page-btn           { padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none; }
.page-btn.active-pg { background: linear-gradient(135deg,#667eea,#764ba2); color: white; }
.page-btn.disabled  { background: #f4f5f9; color: #ccc; pointer-events: none; }
.page-btn.normal    { background: #eef0ff; color: #667eea; }
</style>

<div class="app-layout">

    {{-- ── SIDEBAR ── --}}
    <x-sidebar active="surat" />

    <!-- MAIN -->
    <div class="main-content">

        <!-- Header -->
        <div class="page-header">
            <div class="page-header-text">
                <h1><i class="fas fa-envelope-open-text" style="margin-right:10px;"></i>Administrasi Surat</h1>
                <p>Kelola dan pantau semua surat persuratan pengasuhan</p>
            </div>
            <a href="{{ route('surat.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Surat
            </a>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:17px;"></i> {{ session('success') }}
        </div>
        @endif

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#667eea,#764ba2);"><i class="fas fa-envelope"></i></div>
                <div class="stat-count">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Surat</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#f6ad55,#e07020);"><i class="fas fa-spinner"></i></div>
                <div class="stat-count">{{ $stats['diproses'] }}</div>
                <div class="stat-label">Diproses</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#48bb78,#38a169);"><i class="fas fa-check-circle"></i></div>
                <div class="stat-count">{{ $stats['disetujui'] }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#fc8181,#e53e3e);"><i class="fas fa-times-circle"></i></div>
                <div class="stat-count">{{ $stats['ditolak'] }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:linear-gradient(135deg,#76e4f7,#0bc5ea);"><i class="fas fa-flag-checkered"></i></div>
                <div class="stat-count">{{ $stats['selesai'] }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>

        <!-- Filter -->
        <div class="filter-bar">
            <form method="GET" action="{{ route('surat.index') }}" style="display:contents;">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari perihal, pengirim, penerima..." class="search-input">
                </div>
                <select name="jenis" class="filter-select">
                    <option value="">Semua Jenis</option>
                    @foreach(\App\Models\Surat::jenisSuratList() as $j)
                        <option value="{{ $j }}" {{ request('jenis') === $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    @foreach(\App\Models\Surat::statusList() as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
                @if(request()->hasAny(['search','jenis','status']))
                <a href="{{ route('surat.index') }}" class="btn-reset"><i class="fas fa-times"></i> Reset</a>
                @endif
            </form>
        </div>

        <!-- Tabel / Empty -->
        @if($surat->isEmpty())
        <div class="card">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4>Belum ada surat</h4>
                <p>Klik "Tambah Surat" untuk menambahkan data surat baru.</p>
                <a href="{{ route('surat.create') }}" class="btn-primary-pill">
                    <i class="fas fa-plus"></i> Tambah Surat Pertama
                </a>
            </div>
        </div>
        @else
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NO. SURAT</th>
                        <th>JENIS</th>
                        <th>PERIHAL</th>
                        <th>PENGIRIM / PENERIMA</th>
                        <th>TANGGAL</th>
                        <th style="text-align:center;">STATUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surat as $i => $s)
                    <tr>
                        <td style="color:#bbb; font-weight:600; width:36px;">{{ ($surat->currentPage()-1)*$surat->perPage()+$i+1 }}</td>
                        <td style="color:#667eea; font-weight:700; font-size:12px; white-space:nowrap;">{{ $s->nomor_surat ?: '—' }}</td>
                        <td><span class="jenis-badge">{{ $s->jenis_surat }}</span></td>
                        <td style="max-width:200px;">
                            <a href="{{ route('surat.show', $s->id) }}" style="text-decoration:none;">
                                <div style="font-weight:700; color:#333; font-size:13px;">{{ Str::limit($s->perihal, 45) }}</div>
                            </a>
                            @if($s->keterangan)
                            <div style="font-size:11px; color:#aab; margin-top:2px;">{{ Str::limit($s->keterangan, 40) }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:12px; font-weight:600; color:#333;">{{ $s->pengirim }}</div>
                            <div style="font-size:11px; color:#aab; display:flex; align-items:center; gap:4px;">
                                <i class="fas fa-arrow-right" style="font-size:9px;"></i>{{ $s->penerima }}
                            </div>
                        </td>
                        <td style="white-space:nowrap;">
                            <div style="font-size:12px; color:#555;">
                                <i class="fas fa-calendar" style="color:#667eea; margin-right:5px; font-size:10px;"></i>
                                {{ \Carbon\Carbon::parse($s->tanggal_surat)->locale('id')->isoFormat('D MMM Y') }}
                            </div>
                            @if($s->tanggal_terima)
                            <div style="font-size:11px; color:#aab; margin-top:2px;">
                                Terima: {{ \Carbon\Carbon::parse($s->tanggal_terima)->locale('id')->isoFormat('D MMM Y') }}
                            </div>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <span class="status-badge" style="background:{{ $s->status_bg_color }}; color:{{ $s->status_badge_color }};">
                                {{ $s->status }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:5px;">
                                @if($s->status === 'Diproses')
                                    <form method="POST" action="{{ route('surat.updateStatus', $s->id) }}" style="display:inline; margin:0;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="Disetujui">
                                        <button type="submit" class="btn-approve-ico" title="Setujui"><i class="fas fa-check"></i></button>
                                    </form>
                                    <form method="POST" action="{{ route('surat.updateStatus', $s->id) }}" style="display:inline; margin:0;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="Ditolak">
                                        <button type="submit" class="btn-reject-ico" title="Tolak"><i class="fas fa-times"></i></button>
                                    </form>
                                @endif
                                <a href="{{ route('surat.show', $s->id) }}" class="btn-view" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('surat.edit', $s->id) }}" class="btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn-delete" title="Hapus"
                                        onclick="showSuratDeleteModal('del-surat-{{ $s->id }}', '{{ addslashes(Str::limit($s->perihal, 50)) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($surat->hasPages())
            <div class="pagination-bar">
                <div class="pagination-info">Menampilkan {{ $surat->firstItem() }}–{{ $surat->lastItem() }} dari {{ $surat->total() }} surat</div>
                <div class="pagination-links">
                    @if($surat->onFirstPage())
                        <span class="page-btn disabled">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $surat->previousPageUrl() }}" class="page-btn normal">‹ Sebelumnya</a>
                    @endif
                    @if($surat->hasMorePages())
                        <a href="{{ $surat->nextPageUrl() }}" class="page-btn active-pg">Berikutnya ›</a>
                    @else
                        <span class="page-btn disabled">Berikutnya ›</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endif

    </div>{{-- end main-content --}}
</div>{{-- end app-layout --}}

{{-- Hidden DELETE forms --}}
@foreach($surat as $s)
<form id="del-surat-{{ $s->id }}" method="POST" action="{{ route('surat.destroy', $s->id) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endforeach

{{-- Modal Konfirmasi Hapus --}}
<div class="modal-overlay" id="suratDeleteModal">
    <div class="modal-box">
        <div class="modal-icon-wrap"><i class="fas fa-envelope-open"></i></div>
        <h3>Hapus Surat?</h3>
        <p class="modal-label" id="suratModalPerihal"></p>
        <p class="modal-sub">Surat ini akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
        <div class="modal-actions">
            <button class="modal-cancel" onclick="closeSuratDeleteModal()">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="modal-confirm" onclick="submitSuratDeleteForm()">
                <i class="fas fa-trash"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
let suratTargetFormId = null;
function showSuratDeleteModal(formId, perihal) {
    suratTargetFormId = formId;
    document.getElementById('suratModalPerihal').textContent = perihal;
    document.getElementById('suratDeleteModal').classList.add('open');
}
function closeSuratDeleteModal() {
    document.getElementById('suratDeleteModal').classList.remove('open');
    suratTargetFormId = null;
}
function submitSuratDeleteForm() {
    if (suratTargetFormId) document.getElementById(suratTargetFormId).submit();
}
document.getElementById('suratDeleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeSuratDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeSuratDeleteModal();
});
</script>
</x-app-layout>
