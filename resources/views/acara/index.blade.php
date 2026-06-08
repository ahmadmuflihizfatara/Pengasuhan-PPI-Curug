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
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: space-between;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:80px; bottom:-60px; width:140px; height:140px; background:rgba(255,255,255,.06); border-radius:50%; }
.page-header-text { position:relative; z-index:1; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; }
.page-header p  { margin:0; opacity:.85; font-size:13px; }
.btn-add {
    position:relative; z-index:1;
    background:white; color:#667eea;
    padding:11px 22px; border-radius:25px;
    text-decoration:none; font-size:13px; font-weight:800;
    display:flex; align-items:center; gap:7px;
    white-space:nowrap; box-shadow:0 4px 15px rgba(0,0,0,.15);
    transition:transform .15s, box-shadow .15s;
}
.btn-add:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.2); color:#667eea; }

.alert-success {
    background:linear-gradient(135deg,#43e97b,#38f9d7);
    color:white; padding:14px 20px; border-radius:12px;
    margin-bottom:20px; display:flex; align-items:center; gap:10px;
    font-weight:600; font-size:14px;
}

.card { background:white; border-radius:16px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,.06); }
.empty-state { text-align:center; padding:60px 20px; }
.empty-state i  { font-size:56px; color:#e2e5ee; margin-bottom:16px; display:block; }
.empty-state h4 { color:#aab; margin:0 0 8px; font-size:16px; }
.empty-state p  { color:#ccc; margin:0 0 20px; font-size:14px; }
.btn-primary-pill {
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white; padding:11px 28px; border-radius:25px;
    text-decoration:none; font-size:13px; font-weight:700;
    display:inline-flex; align-items:center; gap:7px;
    box-shadow:0 4px 15px rgba(102,126,234,.4);
}

table { width:100%; border-collapse:collapse; }
thead tr { background:linear-gradient(135deg,#667eea,#764ba2); }
th { padding:14px 18px; text-align:left; color:white; font-size:11px; font-weight:700; letter-spacing:.06em; }
td { padding:14px 18px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr { transition:background .1s; }
tbody tr:hover { background:#f8f9ff; }

.icon-box  { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,#667eea,#764ba2); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.time-badge { background:#eef0ff; color:#667eea; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; }
.btn-edit   { background:#eef0ff; color:#667eea; border:none; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; text-decoration:none; cursor:pointer; display:inline-flex; align-items:center; gap:5px; transition:background .1s; }
.btn-edit:hover   { background:#dde2ff; }
.btn-delete { background:#fff0f0; color:#e53e3e; border:none; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:5px; transition:background .1s; }
.btn-delete:hover { background:#ffe0e0; }

/* Modal */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:20px; padding:32px 28px; max-width:400px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,.2); text-align:center; animation:modalIn .2s ease; }
@keyframes modalIn { from{transform:scale(.93);opacity:0} to{transform:scale(1);opacity:1} }
.modal-icon { width:60px; height:60px; border-radius:50%; background:#fff0f0; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.modal-icon i  { font-size:26px; color:#e53e3e; }
.modal-box h3  { margin:0 0 8px; font-size:18px; font-weight:800; color:#333; }
.modal-box p   { margin:0 0 24px; font-size:13px; color:#888; line-height:1.5; }
.modal-actions { display:flex; gap:10px; justify-content:center; }
.modal-cancel  { background:#f4f5f9; color:#666; border:none; padding:11px 28px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-cancel:hover  { background:#e8e9f0; }
.modal-confirm { background:linear-gradient(135deg,#fc5c7d,#e53e3e); color:white; border:none; padding:11px 28px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-confirm:hover { opacity:.9; }
</style>

<div class="app-layout">

    {{-- ── SIDEBAR ── --}}
    <x-sidebar active="acara" />

    <!-- Main Content -->
    <div class="main-content">

        <!-- Header -->
        <div class="page-header">
            <div class="page-header-text">
                <h1><i class="fas fa-calendar-alt" style="margin-right:10px;"></i>Kelola Acara</h1>
                <p>Daftar seluruh acara pengasuhan yang dijadwalkan</p>
            </div>
            <a href="{{ route('acara.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Acara
            </a>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:18px;"></i>{{ session('success') }}
        </div>
        @endif

        @if($acara->isEmpty())
        <div class="card">
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h4>Belum ada acara dijadwalkan</h4>
                <p>Klik tombol "Tambah Acara" untuk menambahkan acara baru.</p>
                <a href="{{ route('acara.create') }}" class="btn-primary-pill">
                    <i class="fas fa-plus"></i> Tambah Acara Pertama
                </a>
            </div>
        </div>
        @else
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAMA ACARA</th>
                        <th>TANGGAL</th>
                        <th>JAM</th>
                        <th>KETERANGAN</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acara as $i => $a)
                    <tr>
                        <td style="color:#bbb; font-weight:600;">{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="icon-box">
                                    <i class="fas fa-calendar-check" style="color:white; font-size:15px;"></i>
                                </div>
                                <span style="font-weight:700; color:#333;">{{ $a->nama_acara }}</span>
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-calendar" style="color:#667eea; margin-right:6px;"></i>
                            {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </td>
                        <td>
                            <span class="time-badge">
                                <i class="fas fa-clock" style="margin-right:4px;"></i>
                                {{ \Carbon\Carbon::parse($a->jam)->format('H:i') }} WIB
                            </span>
                        </td>
                        <td style="max-width:200px; color:#777;">
                            {!! $a->keterangan ? Str::limit($a->keterangan, 80) : '<span style="color:#ccc;">—</span>' !!}
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:7px;">
                                <a href="{{ route('acara.edit', $a->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn-delete"
                                        onclick="showDeleteModal('delete-acara-{{ $a->id }}', '{{ addslashes($a->nama_acara) }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @foreach($acara as $a)
        <form id="delete-acara-{{ $a->id }}" method="POST" action="{{ route('acara.destroy', $a->id) }}" style="display:none;">
            @csrf @method('DELETE')
        </form>
        @endforeach
        @endif

    </div>{{-- end main-content --}}
</div>{{-- end app-layout --}}

<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3>Hapus Acara?</h3>
        <p id="modalAcaraName" style="font-weight:600; color:#333; margin-bottom:6px;"></p>
        <p>Tindakan ini tidak dapat dibatalkan. Acara akan dihapus secara permanen.</p>
        <div class="modal-actions">
            <button class="modal-cancel" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="modal-confirm" onclick="submitDeleteForm()">
                <i class="fas fa-trash"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
let targetFormId = null;
function showDeleteModal(formId, nama) {
    targetFormId = formId;
    document.getElementById('modalAcaraName').textContent = nama;
    document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
    targetFormId = null;
}
function submitDeleteForm() {
    if (targetFormId) document.getElementById(targetFormId).submit();
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});
</script>
</x-app-layout>
