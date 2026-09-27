<x-app-layout>
<style>
/* Kartu tombol ajukan — sama dengan .barak-aksi */
.surat-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
.surat-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
.surat-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }

/* Notif badge */
.notif-dot { width:8px; height:8px; background:var(--danger); border-radius:50%; display:inline-block; margin-left:2px; animation:pulse 1.5s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

/* Toast notification */
.toast-container { position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; }
.toast { background:white; border-radius:14px; padding:16px 20px; box-shadow:0 8px 30px rgba(0,0,0,.15); display:flex; align-items:flex-start; gap:12px; min-width:320px; max-width:400px; animation:slideIn .3s ease; border-left:4px solid #4f46e5; }
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

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab poin & log gerbang --}}
        <x-page-banner title="Pengajuan Surat Saya" icon="fa-file-signature"
            subtitle="Ajukan permohonan surat kepada satuan pengasuhan" />

        {{-- Tombol ajukan — kartu di bawah header, pola tab barak --}}
        <div class="ds-card surat-aksi mb-4">
            <span class="surat-aksi__teks"><i class="fa-solid fa-envelope-open-text"></i>Butuh surat izin, keterangan, atau permohonan lain dari pengasuhan?</span>
            <a href="{{ route('surat-taruna.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Ajukan Surat Baru</a>
        </div>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        {{-- Tabel surat — pola tabel dashboard & konsinyir --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-envelope-open-text ds-icon"></i> Riwayat Pengajuan Surat</h3>
                    <p class="ds-card__desc">Status pengajuan diperbarui otomatis setelah diperiksa pengasuh</p>
                </div>
                <span class="ds-badge">{{ $surat->count() }} surat</span>
            </div>

            @if($surat->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-file-signature ds-icon"></i>
                Belum ada pengajuan surat. Klik "Ajukan Surat Baru" untuk mengajukan permohonan.
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table">
                        <thead>
                            <tr>
                                <th data-filter>Jenis Surat</th>
                                <th>Perihal</th>
                                <th>Tanggal Ajukan</th>
                                <th data-filter>Status</th>
                                <th class="ds-right" data-no-sort data-no-filter>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surat as $s)
                            @php
                                [$statusVarian, $statusIcon] = match($s->status) {
                                    'Disetujui' => ['success', 'fa-circle-check'],
                                    'Ditolak'   => ['danger',  'fa-circle-xmark'],
                                    'Selesai'   => ['accent',  'fa-flag-checkered'],
                                    default     => ['warning', 'fa-spinner'],
                                };
                            @endphp
                            <tr>
                                <td><span class="ds-badge ds-badge--info">{{ $s->jenis_surat }}</span></td>
                                <td>
                                    <div class="tbl-title">{{ $s->perihal }}</div>
                                    @if($s->keterangan)<div class="tbl-sub">{{ Str::limit($s->keterangan, 50) }}</div>@endif
                                </td>
                                <td class="tbl-date" data-sort="{{ $s->tanggal_surat->format('Y-m-d') }}">{{ $s->tanggal_surat->locale('id')->isoFormat('D MMM Y') }}</td>
                                <td>
                                    <span class="ds-badge ds-badge--{{ $statusVarian }}">
                                        <i class="fa-solid {{ $statusIcon }}"></i> {{ $s->status }}
                                        @if(!$s->taruna_baca && in_array($s->status, ['Disetujui', 'Ditolak']))
                                        <span class="notif-dot"></span>
                                        @endif
                                    </span>
                                </td>
                                <td class="ds-right">
                                    <a href="{{ route('surat-taruna.show', $s->id) }}" class="ds-btn ds-btn--sm ds-btn--pill">Detail <i class="fa-solid fa-arrow-right"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

    </div>
</main>

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
            <div style="font-size:11px; color:#4f46e5; margin-top:4px; font-weight:600;">${perihal}</div>
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
    fetch("{{ route('api.suratNotifications') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
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
