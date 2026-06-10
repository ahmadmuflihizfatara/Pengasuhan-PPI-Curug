<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; max-width: 820px; }

.back-link { display:inline-flex; align-items:center; gap:7px; color:#667eea; text-decoration:none; font-size:13px; font-weight:600; margin-bottom:20px; }
.back-link:hover { text-decoration:underline; }

.status-banner { border-radius:18px; padding:28px 32px; color:white; margin-bottom:24px; position:relative; overflow:hidden; }
.status-banner.diproses  { background:linear-gradient(135deg,#ed8936,#dd6b20); }
.status-banner.disetujui { background:linear-gradient(135deg,#48bb78,#38a169); }
.status-banner.ditolak   { background:linear-gradient(135deg,#fc5c7d,#e53e3e); }
.status-banner.selesai   { background:linear-gradient(135deg,#667eea,#764ba2); }
.status-banner::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.status-banner::after  { content:''; position:absolute; right:80px; bottom:-60px; width:140px; height:140px; background:rgba(255,255,255,.06); border-radius:50%; }
.status-banner h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.status-banner p  { margin:0; opacity:.85; font-size:13px; position:relative; z-index:1; }

/* Info sections */
.card { background:white; border-radius:16px; padding:28px; box-shadow:0 2px 16px rgba(0,0,0,.06); margin-bottom:20px; }
.card-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#aab; margin-bottom:18px; padding-bottom:10px; border-bottom:1px solid #f0f2f7; }

.info-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.info-item {}
.info-item label { display:block; font-size:11px; color:#aab; font-weight:700; text-transform:uppercase; letter-spacing:.06em; margin-bottom:5px; }
.info-item span  { font-size:14px; color:#333; font-weight:600; display:block; }
.info-item span.muted { font-size:13px; color:#888; font-weight:400; }

/* Status badges */
.status-badge-lg { display:inline-flex; align-items:center; padding:8px 18px; border-radius:25px; font-size:14px; font-weight:800; gap:8px; }
.badge-diproses  { background:#fff4e6; color:#e07020; }
.badge-disetujui { background:#e6fff5; color:#38a169; }
.badge-ditolak   { background:#fff0f0; color:#e53e3e; }
.badge-selesai   { background:#eef0ff; color:#667eea; }

/* Catatan box */
.catatan-box { border-radius:12px; padding:18px 20px; margin-top:4px; }
.catatan-box.approved { background:linear-gradient(135deg,#f0fff4,#e6fff5); border:1.5px solid #9ae6b4; }
.catatan-box.rejected { background:linear-gradient(135deg,#fff5f5,#fff0f0); border:1.5px solid #fc8181; }
.catatan-box.pending  { background:#fffbf0; border:1.5px solid #fbd38d; }
.catatan-box .cb-title { font-weight:700; font-size:13px; margin-bottom:8px; display:flex; align-items:center; gap:8px; }
.catatan-box.approved .cb-title { color:#276749; }
.catatan-box.rejected .cb-title { color:#c53030; }
.catatan-box.pending  .cb-title { color:#c05621; }
.catatan-box p { margin:0; font-size:13px; line-height:1.7; }
.catatan-box.approved p { color:#276749; }
.catatan-box.rejected p { color:#742a2a; }
.catatan-box.pending  p { color:#7b341e; }

.file-link { display:inline-flex; align-items:center; gap:8px; background:#eef0ff; color:#667eea; padding:10px 20px; border-radius:25px; text-decoration:none; font-size:13px; font-weight:700; }
.file-link:hover { background:#dde2ff; }
</style>

<div class="app-layout">
    <x-sidebar active="surat-taruna" />

    <div class="main-content">
        <a href="{{ route('surat-taruna.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengajuan
        </a>

        @php
            $bannerClass = match($surat->status) {
                'Disetujui' => 'disetujui',
                'Ditolak'   => 'ditolak',
                'Selesai'   => 'selesai',
                default     => 'diproses',
            };
            $bannerIcon  = match($surat->status) {
                'Disetujui' => 'fa-check-circle',
                'Ditolak'   => 'fa-times-circle',
                'Selesai'   => 'fa-flag-checkered',
                default     => 'fa-clock',
            };
            $bannerDesc  = match($surat->status) {
                'Disetujui' => 'Permohonan surat Anda telah disetujui oleh satuan pengasuhan.',
                'Ditolak'   => 'Permohonan surat Anda ditolak. Lihat keterangan di bawah.',
                'Selesai'   => 'Permohonan surat telah selesai diproses.',
                default     => 'Permohonan surat Anda sedang diproses oleh satuan pengasuhan.',
            };
        @endphp
        <div class="status-banner {{ $bannerClass }}">
            <h1><i class="fas {{ $bannerIcon }}" style="margin-right:10px;"></i>{{ $surat->status }}</h1>
            <p>{{ $bannerDesc }}</p>
        </div>

        {{-- Detail Surat --}}
        <div class="card">
            <div class="card-title"><i class="fas fa-info-circle" style="margin-right:6px;"></i>Informasi Permohonan</div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Jenis Surat</label>
                    <span><span style="background:#eef0ff; color:#667eea; padding:3px 12px; border-radius:20px; font-size:12px; font-weight:700;">{{ $surat->jenis_surat }}</span></span>
                </div>
                <div class="info-item">
                    <label>Tanggal Pengajuan</label>
                    <span>{{ $surat->tanggal_surat->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
                <div class="info-item" style="grid-column:span 2;">
                    <label>Perihal</label>
                    <span>{{ $surat->perihal }}</span>
                </div>
                <div class="info-item">
                    <label>Pengaju</label>
                    <span>{{ $surat->pengirim }}</span>
                </div>
                <div class="info-item">
                    <label>Ditujukan</label>
                    <span>{{ $surat->penerima }}</span>
                </div>
                @if($surat->keterangan)
                <div class="info-item" style="grid-column:span 2;">
                    <label>Keterangan / Alasan</label>
                    <span class="muted">{{ $surat->keterangan }}</span>
                </div>
                @endif
            </div>

            @if($surat->file_path)
            <div style="margin-top:20px; padding-top:20px; border-top:1px solid #f0f2f7;">
                <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank" class="file-link">
                    <i class="fas fa-file-download"></i> Lihat / Unduh Dokumen Lampiran
                </a>
            </div>
            @endif
        </div>

        {{-- Status & Catatan Pengasuhan --}}
        <div class="card">
            <div class="card-title"><i class="fas fa-comment-dots" style="margin-right:6px;"></i>Respon Satuan Pengasuhan</div>
            @if($surat->status === 'Disetujui')
            <div class="catatan-box approved">
                <div class="cb-title"><i class="fas fa-check-circle"></i> Surat Disetujui</div>
                <p>{{ $surat->catatan_pengasuhan ?: 'Permohonan surat Anda telah disetujui. Silakan hubungi satuan pengasuhan untuk proses selanjutnya.' }}</p>
            </div>
            @elseif($surat->status === 'Ditolak')
            <div class="catatan-box rejected">
                <div class="cb-title"><i class="fas fa-times-circle"></i> Alasan Penolakan</div>
                <p>{{ $surat->catatan_pengasuhan ?: 'Pengajuan surat Anda tidak dapat disetujui. Silakan hubungi satuan pengasuhan untuk informasi lebih lanjut.' }}</p>
            </div>
            @else
            <div class="catatan-box pending">
                <div class="cb-title"><i class="fas fa-hourglass-half"></i> Menunggu Keputusan</div>
                <p>Permohonan surat Anda sedang dalam proses peninjauan. Anda akan menerima notifikasi ketika keputusan telah dibuat.</p>
            </div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
