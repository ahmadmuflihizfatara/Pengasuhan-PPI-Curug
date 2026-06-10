<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

.topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.back-link { display: inline-flex; align-items: center; gap: 7px; color: #667eea; text-decoration: none; font-size: 13px; font-weight: 600; }
.back-link:hover { text-decoration: underline; }
.action-btns { display: flex; gap: 8px; }
.btn-edit-top { background: #eef0ff; color: #667eea; padding: 8px 18px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; transition: background .1s; }
.btn-edit-top:hover { background: #dde2ff; }
.btn-delete-top { background: #fff0f0; color: #e53e3e; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
.btn-delete-top:hover { background: #ffe0e0; }

/* Detail Card */
.detail-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.06); }

/* Card header banner */
.detail-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 28px 32px; color: white; position: relative; overflow: hidden; }
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
.detail-field { background: #fafbff; border-radius: 12px; padding: 14px 18px; }
.detail-field.full { grid-column: span 2; }
.field-label { font-size: 10px; font-weight: 700; color: #aab; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
.field-value { font-size: 14px; font-weight: 700; color: #333; }
.file-attachment { background: #eef0ff; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; }
.file-attachment-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0; }
.btn-download { background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 9px 20px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }

.timestamps { margin-top: 18px; padding-top: 14px; border-top: 1px solid #f0f2f7; display: flex; gap: 20px; }
.timestamps span { font-size: 11px; color: #ccc; display: flex; align-items: center; gap: 5px; }
.btn-approve { background: #e6fff5; color: #38a169; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background .1s; }
.btn-approve:hover { background: #c6f6d5; }
.btn-reject { background: #fff5f5; color: #e53e3e; border: none; padding: 8px 18px; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: background .1s; }
.btn-reject:hover { background: #fed7d7; }
.alert-success { background: linear-gradient(135deg,#43e97b,#38f9d7); color: white; padding: 13px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 13px; }
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
                    <form method="POST" action="{{ route('surat.updateStatus', $surat->id) }}" style="margin: 0;">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="Disetujui">
                        <button type="submit" class="btn-approve">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </form>
                    <form method="POST" action="{{ route('surat.updateStatus', $surat->id) }}" style="margin: 0;">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="Ditolak">
                        <button type="submit" class="btn-reject">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    </form>
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
                    <div class="detail-field full" style="background:#eef0ff; border-radius:12px;">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="file-attachment-icon">
                                    <i class="fas fa-paperclip" style="color:white; font-size:16px;"></i>
                                </div>
                                <div>
                                    <div style="font-size:13px; font-weight:700; color:#333;">Dokumen Terlampir</div>
                                    <div style="font-size:12px; color:#667eea;">{{ basename($surat->file_path) }}</div>
                                </div>
                            </div>
                            <a href="{{ Storage::url($surat->file_path) }}" target="_blank" class="btn-download">
                                <i class="fas fa-download"></i> Download / Lihat
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Timestamps -->
                <div class="timestamps">
                    <span><i class="fas fa-clock"></i> Dibuat: {{ $surat->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fas fa-sync"></i> Diperbarui: {{ $surat->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
