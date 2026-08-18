<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

.topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.back-link { display: inline-flex; align-items: center; gap: 7px; color: #fdbb11; text-decoration: none; font-size: 13px; font-weight: 600; }
.back-link:hover { text-decoration: underline; }
.action-btns { display: flex; gap: 8px; }
.btn-edit-top { background: #eef3f9; color: #12283a; padding: 8px 18px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; transition: background .1s; }
.btn-edit-top:hover { background: #dde8f0; }
.btn-delete-top { background: #fff0f0; color: #e53e3e; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
.btn-delete-top:hover { background: #ffe0e0; }

/* Detail Card */
.detail-card { background: white; border-radius: 16px; overflow: hidden; border: 1px solid #d4dbe5; }

/* Card header banner */
.detail-header { background: #12283a; padding: 28px 32px; color: white; position: relative; overflow: hidden; }
.detail-header::before { content: ''; position: absolute; right: -30px; top: -30px; width: 140px; height: 140px; background: rgba(255,255,255,.08); border-radius: 50%; }
.detail-header-inner { position: relative; z-index: 1; display: flex; align-items: flex-start; gap: 18px; }
.doc-icon { width: 54px; height: 54px; border-radius: 14px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px; }
.detail-header .jenis-label { font-size: 11px; font-weight: 700; opacity: .75; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .06em; }
.detail-header h2 { margin: 0 0 6px 0; font-size: 20px; font-weight: 800; }
.detail-header .nomor { font-size: 13px; opacity: .85; }
.status-badge { display: inline-flex; align-items: center; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; white-space: nowrap; margin-left: auto; flex-shrink: 0; }

/* Detail body */
.detail-body { padding: 28px 32px; }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.detail-field { background: #eef3f9; border-radius: 12px; padding: 14px 18px; }
.detail-field.full { grid-column: span 2; }
.field-label { font-size: 10px; font-weight: 700; color: #aab; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
.field-value { font-size: 14px; font-weight: 700; color: #333; }
.file-attachment { background: #eef3f9; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; }
.file-attachment-icon { width: 40px; height: 40px; border-radius: 10px; background: #12283a; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0; }
.btn-download { background: #12283a; color: white; padding: 9px 20px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }

.timestamps { margin-top: 18px; padding-top: 14px; border-top: 1px solid #f0f2f7; display: flex; gap: 20px; }
.timestamps span { font-size: 11px; color: #ccc; display: flex; align-items: center; gap: 5px; }
.btn-approve { background: #e6fff5; color: #38a169; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background .1s; }
.btn-approve:hover { background: #c6f6d5; }
.btn-reject { background: #fff5f5; color: #e53e3e; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background .1s; }
.btn-reject:hover { background: #fed7d7; }
.alert-success { background: linear-gradient(135deg,#16a34a,#38f9d7); color: white; padding: 13px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 13px; }

/* Modal styles */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:20px; padding:32px; max-width:480px; width:90%; border: 1px solid #d4dbe5; }
.modal-box h3 { margin:0 0 8px; font-size:17px; font-weight:800; color:#333; }
.modal-box p  { margin:0 0 18px; font-size:13px; color:#666; line-height:1.6; }
.modal-textarea { width:100%; padding:12px 14px; border:2px solid #d4dbe5; border-radius:10px; font-size:13px; font-family:'Inter',sans-serif; resize:vertical; min-height:90px; outline:none; }
.modal-textarea:focus { border-color:#fdbb11; }
.modal-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:18px; }
.modal-btn-cancel { background:#f4f5f9; color:#666; border:none; padding:10px 22px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-btn-confirm-approve { background:linear-gradient(135deg,#38a169,#48bb78); color:white; border:none; padding:10px 24px; border-radius:25px; font-size:13px; font-weight:800; cursor:pointer; }
.modal-btn-confirm-reject  { background:linear-gradient(135deg,#e53e3e,#fc5c7d); color:white; border:none; padding:10px 24px; border-radius:25px; font-size:13px; font-weight:800; cursor:pointer; }

/* Taruna submission info */
.taruna-tag { background:#fff4e6; color:#c05621; border-radius:8px; padding:8px 14px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px; margin-bottom:16px; }
</style>

<div class="app-layout">
    <x-sidebar active="surat" />

    <div class="main-content">
        <!-- Top bar -->
        <div class="topbar">
            <a href="{{ route('surat.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Surat
            </a>
            <div class="action-btns" style="display: flex; gap: 8px; align-items: center;">
                @if($surat->status === 'Diproses')
                    <button type="button" class="btn-approve" onclick="openModal('approve')">
                        <i class="fas fa-check"></i> Setujui
                    </button>
                    <button type="button" class="btn-reject" onclick="openModal('reject')">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                @endif
                <a href="{{ route('surat.edit', $surat->id) }}" class="btn-edit-top">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form method="POST" action="{{ route('surat.destroy', $surat->id) }}"
                      onsubmit="return confirm('Hapus surat ini secara permanen?');" style="margin: 0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete-top">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:17px;"></i> {{ session('success') }}
        </div>
        @endif

        {{-- Taruna submission tag --}}
        @if($surat->isDiajukanTaruna())
        <div class="taruna-tag">
            <i class="fas fa-user-graduate"></i>
            Diajukan oleh Taruna: <strong>{{ $surat->diajukan_oleh ?? $surat->pengirim }}</strong>
        </div>
        @endif

        <!-- Detail Card -->
        <div class="detail-card">
            <!-- Banner Header -->
            <div class="detail-header">
                <div class="detail-header-inner">
                    <div class="doc-icon"><i class="fas fa-file-alt"></i></div>
                    <div style="flex:1;">
                        <div class="jenis-label">{{ $surat->jenis_surat }}</div>
                        <h2>{{ $surat->perihal }}</h2>
                        @if($surat->nomor_surat)
                        <div class="nomor">No. {{ $surat->nomor_surat }}</div>
                        @endif
                    </div>
                    <span class="status-badge"
                          style="background:{{ $surat->status_bg_color }}; color:{{ $surat->status_badge_color }};">
                        {{ $surat->status }}
                    </span>
                </div>
            </div>

            <!-- Detail Body -->
            <div class="detail-body">
                <div class="detail-grid">
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-paper-plane"></i> Pengirim</div>
                        <div class="field-value">{{ $surat->pengirim }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-inbox"></i> Penerima</div>
                        <div class="field-value">{{ $surat->penerima }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-calendar"></i> Tanggal Surat</div>
                        <div class="field-value">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-calendar-check"></i> Tanggal Diterima</div>
                        <div class="field-value">
                            @if($surat->tanggal_terima)
                                {{ \Carbon\Carbon::parse($surat->tanggal_terima)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            @else
                                <span style="color:#ccc; font-weight:400;">—</span>
                            @endif
                        </div>
                    </div>

                    @if($surat->keterangan)
                    <div class="detail-field full">
                        <div class="field-label"><i class="fas fa-sticky-note"></i> Keterangan</div>
                        <div class="field-value" style="font-weight:400; font-size:13px; line-height:1.6; color:#555;">{{ $surat->keterangan }}</div>
                    </div>
                    @endif

                    @if($surat->file_path)
                    <div class="detail-field full" style="background:#eef3f9; border-radius:12px;">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="file-attachment-icon">
                                    <i class="fas fa-paperclip" style="color:white; font-size:16px;"></i>
                                </div>
                                <div>
                                    <div style="font-size:13px; font-weight:700; color:#333;">Dokumen Terlampir</div>
                                    <div style="font-size:12px; color:#fdbb11;">{{ basename($surat->file_path) }}</div>
                                </div>
                            </div>
                            <a href="{{ Storage::url($surat->file_path) }}" target="_blank" class="btn-download">
                                <i class="fas fa-download"></i> Download / Lihat
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                @if($surat->catatan_pengasuhan)
                <div style="margin-top:16px; padding:16px 18px; background:{{ in_array($surat->status,['Disetujui','Selesai']) ? '#f0fff4' : '#fff5f5' }}; border-radius:12px; border-left:4px solid {{ in_array($surat->status,['Disetujui','Selesai']) ? '#38a169' : '#e53e3e' }};">
                    <div class="field-label"><i class="fas fa-comment-dots"></i> Catatan Pengasuhan</div>
                    <div style="font-size:13px; color:#333; line-height:1.6;">{{ $surat->catatan_pengasuhan }}</div>
                </div>
                @endif

                <!-- Timestamps -->
                <div class="timestamps">
                    <span><i class="fas fa-clock"></i> Dibuat: {{ $surat->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fas fa-sync"></i> Diperbarui: {{ $surat->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden form that the modal will submit --}}
<form method="POST" action="{{ route('surat.updateStatus', $surat->id) }}" id="statusForm" style="display:none;">
    @csrf @method('PATCH')
    <input type="hidden" name="status" id="statusInput">
    <input type="hidden" name="catatan_pengasuhan" id="catatanInput">
</form>

{{-- Approve Modal --}}
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <h3 id="modalTitle">Konfirmasi</h3>
        <p id="modalDesc">Tambahkan catatan untuk taruna (opsional):</p>
        <textarea class="modal-textarea" id="modalCatatan" placeholder="Tulis catatan atau pesan untuk taruna..."></textarea>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeModal()">Batal</button>
            <button class="modal-btn-confirm-approve" id="modalConfirmBtn" onclick="submitModal()">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
let currentAction = null;

function openModal(action) {
    currentAction = action;
    const overlay = document.getElementById('modalOverlay');
    const title   = document.getElementById('modalTitle');
    const desc    = document.getElementById('modalDesc');
    const btn     = document.getElementById('modalConfirmBtn');
    document.getElementById('modalCatatan').value = '';

    if (action === 'approve') {
        title.innerHTML = '<i class="fas fa-check-circle" style="color:#38a169; margin-right:8px;"></i> Setujui Surat';
        desc.textContent  = 'Anda akan menyetujui surat ini. Tambahkan catatan atau pesan untuk taruna (opsional):';
        btn.className     = 'modal-btn-confirm-approve';
        btn.textContent   = 'Ya, Setujui';
    } else {
        title.innerHTML = '<i class="fas fa-times-circle" style="color:#e53e3e; margin-right:8px;"></i> Tolak Surat';
        desc.textContent  = 'Anda akan menolak surat ini. Tambahkan alasan penolakan untuk taruna (opsional):';
        btn.className     = 'modal-btn-confirm-reject';
        btn.textContent   = 'Ya, Tolak';
    }

    overlay.classList.add('open');
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('open');
    currentAction = null;
}

function submitModal() {
    if (!currentAction) return;
    document.getElementById('statusInput').value  = currentAction === 'approve' ? 'Disetujui' : 'Ditolak';
    document.getElementById('catatanInput').value = document.getElementById('modalCatatan').value;
    document.getElementById('statusForm').submit();
}

// Close on overlay click
document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
</x-app-layout>
