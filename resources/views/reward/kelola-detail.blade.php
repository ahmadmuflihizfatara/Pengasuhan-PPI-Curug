<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }
.app-layout { display: block; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; max-width: 80rem; margin: 0 auto; width: 100%; }

.topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
.back-link { display: inline-flex; align-items: center; gap: 7px; color: #b45309; text-decoration: none; font-size: 13px; font-weight: 600; }
.back-link:hover { text-decoration: underline; }
.action-btns { display: flex; gap: 8px; }

.btn-process { background: #ebf4ff; color: #3182ce; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
.btn-process:hover { background: #dbeafe; }
.btn-done { background: #e6fff5; color: #38a169; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
.btn-done:hover { background: #c6f6d5; }
.btn-reject { background: #fff5f5; color: #e53e3e; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
.btn-reject:hover { background: #fed7d7; }

.detail-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.06); }
.detail-header { background: linear-gradient(135deg, #f7b733 0%, #fc4a1a 100%); padding: 28px 32px; color: white; position: relative; overflow: hidden; }
.detail-header::before { content: ''; position: absolute; right: -30px; top: -30px; width: 140px; height: 140px; background: rgba(255,255,255,.08); border-radius: 50%; }
.detail-header-inner { position: relative; z-index: 1; display: flex; align-items: flex-start; gap: 18px; }
.doc-icon { width: 54px; height: 54px; border-radius: 14px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px; }
.detail-header .jenis-label { font-size: 11px; font-weight: 700; opacity: .75; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .06em; }
.detail-header h2 { margin: 0 0 6px 0; font-size: 20px; font-weight: 800; }
.detail-header .nomor { font-size: 13px; opacity: .85; }
.status-badge { display: inline-flex; align-items: center; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; white-space: nowrap; margin-left: auto; flex-shrink: 0; }

.detail-body { padding: 28px 32px; }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.detail-field { background: #fafbff; border-radius: 12px; padding: 14px 18px; }
.detail-field.full { grid-column: span 2; }
.field-label { font-size: 10px; font-weight: 700; color: #aab; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
.field-value { font-size: 14px; font-weight: 700; color: #333; }
.file-attachment { background: #fef3e0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; }
.file-attachment-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #f7b733, #fc4a1a); display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0; }
.btn-download { background: linear-gradient(135deg, #f7b733, #fc4a1a); color: white; padding: 9px 20px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }

.timestamps { margin-top: 18px; padding-top: 14px; border-top: 1px solid #f0f2f7; display: flex; gap: 20px; }
.timestamps span { font-size: 11px; color: #ccc; display: flex; align-items: center; gap: 5px; }
.alert-success { background: linear-gradient(135deg,#43e97b,#38f9d7); color: white; padding: 13px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 13px; }
.alert-error   { background: linear-gradient(135deg,#fc5c7d,#e53e3e); color: white; padding: 13px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 13px; }

.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:20px; padding:32px; max-width:480px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,.2); }
.modal-box h3 { margin:0 0 8px; font-size:17px; font-weight:800; color:#333; }
.modal-box p  { margin:0 0 18px; font-size:13px; color:#666; line-height:1.6; }
.modal-textarea { width:100%; padding:12px 14px; border:2px solid #edf0f7; border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; resize:vertical; min-height:90px; outline:none; }
.modal-textarea:focus { border-color:#f5b301; }
.modal-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:18px; }
.modal-btn-cancel { background:#f4f5f9; color:#666; border:none; padding:10px 22px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-btn-confirm-process { background:linear-gradient(135deg,#3182ce,#0bc5ea); color:white; border:none; padding:10px 24px; border-radius:25px; font-size:13px; font-weight:800; cursor:pointer; }
.modal-btn-confirm-done    { background:linear-gradient(135deg,#38a169,#48bb78); color:white; border:none; padding:10px 24px; border-radius:25px; font-size:13px; font-weight:800; cursor:pointer; }
.modal-btn-confirm-reject  { background:linear-gradient(135deg,#e53e3e,#fc5c7d); color:white; border:none; padding:10px 24px; border-radius:25px; font-size:13px; font-weight:800; cursor:pointer; }
</style>

<div class="app-layout">
    <x-island-navbar />

    <div class="main-content">
        <div class="topbar">
            <a href="{{ route('reward.kelola') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Reward
            </a>
            <div class="action-btns">
                @if($reward->status === 'Diajukan')
                    <button type="button" class="btn-process" onclick="openModal('Diproses')">
                        <i class="fas fa-play"></i> Proses
                    </button>
                    <button type="button" class="btn-reject" onclick="openModal('Ditolak')">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                @elseif($reward->status === 'Diproses')
                    <button type="button" class="btn-done" onclick="openModal('Disetujui')">
                        <i class="fas fa-check"></i> Setujui
                    </button>
                    <button type="button" class="btn-reject" onclick="openModal('Ditolak')">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                @endif
            </div>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:17px;"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle" style="font-size:17px;"></i> {{ session('error') }}
        </div>
        @endif

        <div class="detail-card">
            <div class="detail-header">
                <div class="detail-header-inner">
                    <div class="doc-icon"><i class="fas fa-award"></i></div>
                    <div style="flex:1;">
                        <div class="jenis-label">{{ $reward->kategori }} · {{ ucfirst($reward->jenis) }}{{ $reward->jenis === 'kelompok' ? ' ('.$reward->jumlah_anggota.' orang)' : '' }}</div>
                        <h2>{{ Str::limit($reward->keterangan, 60) }}</h2>
                        <div class="nomor">Prestasi {{ $reward->tanggal_prestasi->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                    </div>
                    <span class="status-badge" style="background:{{ $reward->status_bg_color }}; color:{{ $reward->status_badge_color }};">
                        {{ $reward->status }}
                    </span>
                </div>
            </div>

            <div class="detail-body">
                <div class="detail-grid">
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-user"></i> Nama Pengaju</div>
                        <div class="field-value">{{ $reward->nama }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-envelope"></i> Email</div>
                        <div class="field-value">{{ $reward->email }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-id-card"></i> NPM</div>
                        <div class="field-value">{{ $reward->npm ?? '-' }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-graduation-cap"></i> Program Studi</div>
                        <div class="field-value">{{ $reward->prodi ?? '-' }} — {{ $reward->prodi_nama }}</div>
                    </div>

                    @if($reward->jenis === 'kelompok')
                    <div class="detail-field full">
                        <div class="field-label"><i class="fas fa-users"></i> Jumlah Anggota Kelompok</div>
                        <div class="field-value">{{ $reward->jumlah_anggota }} orang</div>
                    </div>
                    @endif

                    <div class="detail-field full">
                        <div class="field-label"><i class="fas fa-sticky-note"></i> Keterangan Prestasi</div>
                        <div class="field-value" style="font-weight:400; font-size:13px; line-height:1.6; color:#555;">{{ $reward->keterangan }}</div>
                    </div>

                    @if(!empty($reward->dokumen))
                    <div class="detail-field full">
                        <div class="field-label"><i class="fas fa-paperclip"></i> Dokumentasi ({{ count($reward->dokumen) }})</div>
                        @foreach($reward->dokumen as $file)
                        <div class="file-attachment" style="margin-bottom:10px;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="file-attachment-icon">
                                    <i class="fas fa-file" style="color:white; font-size:16px;"></i>
                                </div>
                                <div>
                                    <div style="font-size:13px; font-weight:700; color:#333;">{{ basename($file) }}</div>
                                </div>
                            </div>
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($file) }}" target="_blank" class="btn-download">
                                <i class="fas fa-download"></i> Download / Lihat
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                @if($reward->catatan_pengasuhan)
                <div style="margin-top:16px; padding:16px 18px; background:{{ $reward->status === 'Disetujui' ? '#f0fff4' : ($reward->status === 'Ditolak' ? '#fff5f5' : '#fffaf0') }}; border-radius:12px; border-left:4px solid {{ $reward->status === 'Disetujui' ? '#38a169' : ($reward->status === 'Ditolak' ? '#e53e3e' : '#f5b301') }};">
                    <div class="field-label"><i class="fas fa-comment-dots"></i> Catatan Reward yang Diberikan</div>
                    <div style="font-size:13px; color:#333; line-height:1.6;">{{ $reward->catatan_pengasuhan }}</div>
                </div>
                @endif

                <div class="timestamps">
                    <span><i class="fas fa-clock"></i> Diajukan: {{ $reward->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fas fa-sync"></i> Diperbarui: {{ $reward->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('reward.updateStatus', $reward->id) }}" id="statusForm" style="display:none;">
    @csrf @method('PATCH')
    <input type="hidden" name="status" id="statusInput">
    <input type="hidden" name="catatan_pengasuhan" id="catatanInput">
</form>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <h3 id="modalTitle">Konfirmasi</h3>
        <p id="modalDesc">Tambahkan catatan reward untuk taruna (opsional):</p>
        <textarea class="modal-textarea" id="modalCatatan" placeholder="Contoh: mendapatkan barang, jajan, atau tambahan poin pengasuhan..."></textarea>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeModal()">Batal</button>
            <button class="modal-btn-confirm-process" id="modalConfirmBtn" onclick="submitModal()">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
let currentStatus = null;

function openModal(status) {
    currentStatus = status;
    const overlay = document.getElementById('modalOverlay');
    const title   = document.getElementById('modalTitle');
    const desc    = document.getElementById('modalDesc');
    const btn     = document.getElementById('modalConfirmBtn');
    document.getElementById('modalCatatan').value = '';

    if (status === 'Diproses') {
        title.innerHTML = '<i class="fas fa-play" style="color:#3182ce; margin-right:8px;"></i> Proses Reward';
        desc.textContent = 'Anda akan memproses pengajuan reward ini. Tambahkan catatan (opsional):';
        btn.className = 'modal-btn-confirm-process';
        btn.textContent = 'Ya, Proses';
    } else if (status === 'Disetujui') {
        title.innerHTML = '<i class="fas fa-check-circle" style="color:#38a169; margin-right:8px;"></i> Setujui Reward';
        desc.textContent = 'Anda akan menyetujui reward ini. Tulis catatan reward yang didapatkan taruna, misalnya mendapatkan barang, jajan, atau poin pengasuhan:';
        btn.className = 'modal-btn-confirm-done';
        btn.textContent = 'Ya, Setujui';
    } else {
        title.innerHTML = '<i class="fas fa-times-circle" style="color:#e53e3e; margin-right:8px;"></i> Tolak Reward';
        desc.textContent = 'Anda akan menolak pengajuan reward ini. Tambahkan alasan penolakan untuk taruna (opsional):';
        btn.className = 'modal-btn-confirm-reject';
        btn.textContent = 'Ya, Tolak';
    }

    overlay.classList.add('open');
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('open');
    currentStatus = null;
}

function submitModal() {
    if (!currentStatus) return;
    document.getElementById('statusInput').value = currentStatus;
    document.getElementById('catatanInput').value = document.getElementById('modalCatatan').value;
    document.getElementById('statusForm').submit();
}

document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
</x-app-layout>
