<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout { display: flex; min-height: 100vh; }
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

.alert-success { background:linear-gradient(135deg,#43e97b,#38f9d7); color:white; padding:14px 20px; border-radius:12px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:14px; }

.card { background:white; border-radius:16px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,.06); }
.empty-state { text-align:center; padding:60px 20px; }
.empty-state i  { font-size:56px; color:#e2e5ee; margin-bottom:16px; display:block; }
.empty-state h4 { color:#aab; margin:0 0 8px; font-size:16px; }
.empty-state p  { color:#ccc; margin:0 0 20px; font-size:14px; }
.btn-primary-pill {
    background:linear-gradient(135deg,#667eea,#764ba2); color:white;
    padding:11px 28px; border-radius:25px; text-decoration:none;
    font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:7px;
}

table { width:100%; border-collapse:collapse; }
thead tr { background:linear-gradient(135deg,#667eea,#764ba2); }
th { padding:14px 18px; text-align:left; color:white; font-size:11px; font-weight:700; letter-spacing:.06em; }
td { padding:14px 18px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr { transition:background .1s; }
tbody tr:hover { background:#f8f9ff; }

.status-badge { display:inline-flex; align-items:center; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; gap:5px; }
.badge-diproses  { background:#fff4e6; color:#e07020; }
.badge-disetujui { background:#e6fff5; color:#38a169; }
.badge-ditolak   { background:#fff0f0; color:#e53e3e; }
.badge-selesai   { background:#eef0ff; color:#667eea; }

.btn-view { background:#eef0ff; color:#667eea; border:none; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; text-decoration:none; cursor:pointer; display:inline-flex; align-items:center; gap:5px; }
.btn-view:hover { background:#dde2ff; }

/* Notif badge */
.notif-dot { width:8px; height:8px; background:#e53e3e; border-radius:50%; display:inline-block; margin-left:4px; animation:pulse 1.5s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

/* Toast notification */
.toast-container { position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; }
.toast { background:white; border-radius:14px; padding:16px 20px; box-shadow:0 8px 30px rgba(0,0,0,.15); display:flex; align-items:flex-start; gap:12px; min-width:320px; max-width:400px; animation:slideIn .3s ease; border-left:4px solid #667eea; }
.toast.toast-disetujui { border-left-color:#38a169; }
.toast.toast-ditolak   { border-left-color:#e53e3e; }
@keyframes slideIn { from{transform:translateX(120%);opacity:0} to{transform:translateX(0);opacity:1} }
.toast-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; color:white; flex-shrink:0; }
.toast.toast-disetujui .toast-icon { background:linear-gradient(135deg,#38a169,#48bb78); }
.toast.toast-ditolak   .toast-icon { background:linear-gradient(135deg,#fc5c7d,#e53e3e); }
.toast-body .toast-title { font-weight:700; font-size:13px; color:#333; margin-bottom:3px; }
.toast-body .toast-msg   { font-size:12px; color:#888; }
.toast-close { margin-left:auto; background:none; border:none; color:#aab; cursor:pointer; font-size:16px; padding:0; }
</style>

<div class="app-layout">
    <x-sidebar active="surat-taruna" />

    <div class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1><i class="fas fa-file-signature" style="margin-right:10px;"></i>Pengajuan Surat Saya</h1>
                <p>Ajukan permohonan surat kepada satuan pengasuhan</p>
            </div>
            <a href="{{ route('surat-taruna.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Ajukan Surat Baru
            </a>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:18px;"></i> {{ session('success') }}
        </div>
        @endif

        @if($surat->isEmpty())
        <div class="card">
            <div class="empty-state">
                <i class="fas fa-file-signature"></i>
                <h4>Belum ada pengajuan surat</h4>
                <p>Klik tombol "Ajukan Surat Baru" untuk mengajukan permohonan surat kepada pengasuhan.</p>
                <a href="{{ route('surat-taruna.create') }}" class="btn-primary-pill">
                    <i class="fas fa-plus"></i> Ajukan Surat Pertama
                </a>
            </div>
        </div>
        @else
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>JENIS SURAT</th>
                        <th>PERIHAL</th>
                        <th>TANGGAL AJUKAN</th>
                        <th style="text-align:center;">STATUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surat as $i => $s)
                    <tr>
                        <td style="color:#bbb; font-weight:600;">{{ $i + 1 }}</td>
                        <td>
                            <span style="background:#eef0ff; color:#667eea; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                                {{ $s->jenis_surat }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight:700; color:#333;">{{ $s->perihal }}</div>
                            @if($s->keterangan)
                            <div style="font-size:11px; color:#aab; margin-top:2px;">{{ Str::limit($s->keterangan, 50) }}</div>
                            @endif
                        </td>
                        <td style="font-size:12px; color:#666; white-space:nowrap;">
                            <i class="fas fa-calendar" style="color:#667eea; margin-right:5px;"></i>
                            {{ $s->tanggal_surat->locale('id')->isoFormat('D MMM Y') }}
                        </td>
                        <td style="text-align:center;">
                            @php
                                $statusClass = match($s->status) {
                                    'Disetujui' => 'badge-disetujui',
                                    'Ditolak'   => 'badge-ditolak',
                                    'Selesai'   => 'badge-selesai',
                                    default     => 'badge-diproses',
                                };
                                $statusIcon = match($s->status) {
                                    'Disetujui' => 'fa-check-circle',
                                    'Ditolak'   => 'fa-times-circle',
                                    'Selesai'   => 'fa-flag-checkered',
                                    default     => 'fa-spinner',
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <i class="fas {{ $statusIcon }}"></i> {{ $s->status }}
                                @if(!$s->taruna_baca && in_array($s->status, ['Disetujui', 'Ditolak']))
                                <span class="notif-dot"></span>
                                @endif
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <a href="{{ route('surat-taruna.show', $s->id) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<!-- Toast Notification Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
let knownStatuses = {};

// Inisialisasi status saat ini dari server
@foreach($surat as $s)
knownStatuses[{{ $s->id }}] = "{{ $s->status }}";
@endforeach

function showToast(perihal, status, suratId) {
    const container = document.getElementById('toastContainer');
    const isApproved = status === 'Disetujui';
    const toastClass = isApproved ? 'toast-disetujui' : 'toast-ditolak';
    const icon = isApproved ? 'fa-check' : 'fa-times';
    const msg = isApproved
        ? 'Pengajuan surat Anda telah <strong>disetujui</strong> oleh pengasuhan.'
        : 'Pengajuan surat Anda <strong>ditolak</strong>. Buka detail untuk melihat alasan.';

    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.className = `toast ${toastClass}`;
    toast.id = toastId;
    toast.innerHTML = `
        <div class="toast-icon"><i class="fas ${icon}"></i></div>
        <div class="toast-body">
            <div class="toast-title">${isApproved ? '✅ Surat Disetujui' : '❌ Surat Ditolak'}</div>
            <div class="toast-msg">${msg}</div>
            <div style="font-size:11px; color:#667eea; margin-top:4px; font-weight:600;">${perihal}</div>
        </div>
        <button class="toast-close" onclick="document.getElementById('${toastId}').remove()">×</button>
    `;
    container.appendChild(toast);

    // Auto-remove after 8s
    setTimeout(() => {
        const el = document.getElementById(toastId);
        if (el) el.style.animation = 'none', el.style.opacity = '0', el.style.transition = 'opacity .4s', setTimeout(() => el.remove(), 400);
    }, 8000);
}

function pollNotifications() {
    fetch("{{ route('api.suratNotifications') }}")
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                data.unread.forEach(s => {
                    // Cek apakah status berubah
                    if (knownStatuses[s.id] !== s.status) {
                        showToast(s.perihal, s.status, s.id);
                        knownStatuses[s.id] = s.status;
                    }
                });
                // Reload tabel setelah 2 detik untuk memperbarui tampilan status
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(() => {});
}

// Poll setiap 5 detik
setInterval(pollNotifications, 5000);
</script>
</x-app-layout>
