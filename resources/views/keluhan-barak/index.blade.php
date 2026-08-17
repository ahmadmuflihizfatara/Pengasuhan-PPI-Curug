<x-app-layout>
<x-administration-table-style />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

.page-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
    background:white; color:#d63384;
    padding:11px 22px; border-radius:25px;
    text-decoration:none; font-size:13px; font-weight:800;
    display:flex; align-items:center; gap:7px;
    white-space:nowrap; box-shadow:0 4px 15px rgba(0,0,0,.15);
    transition:transform .15s, box-shadow .15s;
}
.btn-add:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.2); color:#d63384; }

.alert-success { background:linear-gradient(135deg,#43e97b,#38f9d7); color:white; padding:14px 20px; border-radius:12px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:14px; }

.card { background:white; border-radius:16px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,.06); }
.empty-state { text-align:center; padding:60px 20px; }
.empty-state i  { font-size:56px; color:#e2e5ee; margin-bottom:16px; display:block; }
.empty-state h4 { color:#aab; margin:0 0 8px; font-size:16px; }
.empty-state p  { color:#ccc; margin:0 0 20px; font-size:14px; }
.btn-primary-pill {
    background:linear-gradient(135deg,#f093fb,#f5576c); color:white;
    padding:11px 28px; border-radius:25px; text-decoration:none;
    font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:7px;
}

table { width:100%; border-collapse:collapse; }
thead tr { background:linear-gradient(135deg,#f093fb,#f5576c); }
th { padding:14px 18px; text-align:left; color:white; font-size:11px; font-weight:700; letter-spacing:.06em; }
td { padding:14px 18px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr { transition:background .1s; }
tbody tr:hover { background:#fff8fb; }

.status-badge { display:inline-flex; align-items:center; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; gap:5px; }

.btn-view { background:#fdf0f9; color:#d63384; border:none; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; text-decoration:none; cursor:pointer; display:inline-flex; align-items:center; gap:5px; }
.btn-view:hover { background:#fad3ec; }

.notif-dot { width:8px; height:8px; background:#e53e3e; border-radius:50%; display:inline-block; margin-left:4px; animation:pulse 1.5s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

.toast-container { position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; }
.toast { background:white; border-radius:14px; padding:16px 20px; box-shadow:0 8px 30px rgba(0,0,0,.15); display:flex; align-items:flex-start; gap:12px; min-width:320px; max-width:400px; animation:slideIn .3s ease; border-left:4px solid #d63384; }
@keyframes slideIn { from{transform:translateX(120%);opacity:0} to{transform:translateX(0);opacity:1} }
.toast-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; color:white; flex-shrink:0; }
.toast-body .toast-title { font-weight:700; font-size:13px; color:#333; margin-bottom:3px; }
.toast-body .toast-msg   { font-size:12px; color:#888; }
.toast-close { margin-left:auto; background:none; border:none; color:#aab; cursor:pointer; font-size:16px; padding:0; }
</style>

<div class="app-layout">
    <x-sidebar active="keluhan-barak" />

    <div class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1><i class="fas fa-door-open" style="margin-right:10px;"></i>Keluhan Barak Saya</h1>
                <p>Pantau status pengajuan keluhan barak Anda</p>
            </div>
            <a href="{{ route('keluhan-barak.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Ajukan Keluhan Baru
            </a>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:18px;"></i> {{ session('success') }}
        </div>
        @endif

        @if($daftarKeluhan->isEmpty())
        <div class="card admin-list-table">
            <div class="empty-state">
                <i class="fas fa-door-open"></i>
                <h4>Belum ada keluhan barak</h4>
                <p>Klik tombol "Ajukan Keluhan Baru" untuk melaporkan kerusakan atau kendala di barak Anda.</p>
                <a href="{{ route('keluhan-barak.create') }}" class="btn-primary-pill">
                    <i class="fas fa-plus"></i> Ajukan Keluhan Pertama
                </a>
            </div>
        </div>
        @else
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>LOKASI BARAK</th>
                        <th>TANGGAL</th>
                        <th>KETERANGAN</th>
                        <th style="text-align:center;">STATUS</th>
                        <th style="text-align:center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarKeluhan as $i => $k)
                    <tr>
                        <td style="color:#bbb; font-weight:600;">{{ $i + 1 }}</td>
                        <td>
                            <span style="background:#fdf0f9; color:#b83280; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                                {{ $k->asrama }}
                            </span>
                            <div style="font-weight:700; color:#333; margin-top:4px;">
                                {{ $k->lorong }} · No. {{ $k->nomor_barak }}
                            </div>
                        </td>
                        <td style="font-size:12px; color:#666; white-space:nowrap;">
                            <i class="fas fa-calendar" style="color:#d63384; margin-right:5px;"></i>
                            {{ $k->tanggal_pengajuan->locale('id')->isoFormat('D MMM Y') }}
                        </td>
                        <td style="max-width:260px;">
                            <div style="font-weight:600; color:#333;">{{ Str::limit($k->keterangan, 60) }}</div>
                        </td>
                        <td style="text-align:center;">
                            <span class="status-badge" style="background:{{ $k->status_bg_color }}; color:{{ $k->status_badge_color }};">
                                {{ $k->status }}
                                @if(!$k->taruna_baca && in_array($k->status, ['Diproses', 'Selesai', 'Ditolak']))
                                <span class="notif-dot"></span>
                                @endif
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <a href="{{ route('keluhan-barak.show', $k->id) }}" class="btn-view">
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

<div class="toast-container" id="toastContainer"></div>

<script>
let knownStatuses = {};

@foreach($daftarKeluhan as $k)
knownStatuses[{{ $k->id }}] = "{{ $k->status }}";
@endforeach

function showToast(keluhan) {
    const container = document.getElementById('toastContainer');
    const icon = keluhan.status === 'Ditolak' ? 'fa-times' : keluhan.status === 'Selesai' ? 'fa-check' : 'fa-spinner';
    const iconBg = keluhan.status === 'Ditolak' ? 'linear-gradient(135deg,#e53e3e,#fc5c7d)' : keluhan.status === 'Selesai' ? 'linear-gradient(135deg,#38a169,#48bb78)' : 'linear-gradient(135deg,#3182ce,#0bc5ea)';

    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <div class="toast-icon" style="background:${iconBg}"><i class="fas ${icon}"></i></div>
        <div class="toast-body">
            <div class="toast-title">Status Keluhan Berubah</div>
            <div class="toast-msg">Keluhan <strong>${keluhan.asrama} ${keluhan.lorong} No. ${keluhan.barak}</strong> sekarang <strong>${keluhan.status}</strong>.</div>
        </div>
        <button class="toast-close" onclick="document.getElementById('${toastId}').remove()">×</button>
    `;
    toast.id = toastId;
    container.appendChild(toast);

    setTimeout(() => {
        const el = document.getElementById(toastId);
        if (el) el.style.animation = 'none', el.style.opacity = '0', el.style.transition = 'opacity .4s', setTimeout(() => el.remove(), 400);
    }, 8000);
}

function pollNotifications() {
    fetch("{{ route('api.keluhanNotifications') }}")
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                data.unread.forEach(k => {
                    if (knownStatuses[k.id] !== k.status) {
                        showToast(k);
                        knownStatuses[k.id] = k.status;
                    }
                });
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(() => {});
}

setInterval(pollNotifications, 5000);
</script>
</x-app-layout>
