<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }
.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

.topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.back-link { display: inline-flex; align-items: center; gap: 7px; color: #d63384; text-decoration: none; font-size: 13px; font-weight: 600; }
.back-link:hover { text-decoration: underline; }

.detail-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,.06); }
.detail-header { background: linear-gradient(135deg, #fdbb11 0%, #dc2626 100%); padding: 28px 32px; color: white; position: relative; overflow: hidden; }
.detail-header::before { content: ''; position: absolute; right: -30px; top: -30px; width: 140px; height: 140px; background: rgba(255,255,255,.08); border-radius: 50%; }
.detail-header-inner { position: relative; z-index: 1; display: flex; align-items: flex-start; gap: 18px; }
.doc-icon { width: 54px; height: 54px; border-radius: 14px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px; }
.detail-header .jenis-label { font-size: 11px; font-weight: 700; opacity: .75; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .06em; }
.detail-header h2 { margin: 0 0 6px 0; font-size: 20px; font-weight: 800; }
.detail-header .nomor { font-size: 13px; opacity: .85; }
.status-badge { display: inline-flex; align-items: center; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; white-space: nowrap; margin-left: auto; flex-shrink: 0; }

.detail-body { padding: 28px 32px; }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.detail-field { background: #f9fafb; border-radius: 12px; padding: 14px 18px; }
.detail-field.full { grid-column: span 2; }
.field-label { font-size: 10px; font-weight: 700; color: #aab; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
.field-value { font-size: 14px; font-weight: 700; color: #333; }
.file-attachment { background: #fdf0f9; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; }
.file-attachment-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #fdbb11, #dc2626); display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0; }
.btn-download { background: linear-gradient(135deg, #fdbb11, #dc2626); color: white; padding: 9px 20px; border-radius: 10px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }

.timestamps { margin-top: 18px; padding-top: 14px; border-top: 1px solid #f0f2f7; display: flex; gap: 20px; }
.timestamps span { font-size: 11px; color: #ccc; display: flex; align-items: center; gap: 5px; }
</style>

<div class="app-layout">
    <x-sidebar active="keluhan-barak" />

    <div class="main-content">
        <div class="topbar">
            <a href="{{ route('keluhan-barak.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Keluhan
            </a>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <div class="detail-header-inner">
                    <div class="doc-icon"><i class="fas fa-door-open"></i></div>
                    <div style="flex:1;">
                        <div class="jenis-label">{{ $keluhan->asrama }}</div>
                        <h2>{{ $keluhan->lorong }} · No. {{ $keluhan->nomor_barak }}</h2>
                        <div class="nomor">Diajukan {{ $keluhan->tanggal_pengajuan->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
                    </div>
                    <span class="status-badge" style="background:{{ $keluhan->status_bg_color }}; color:{{ $keluhan->status_badge_color }};">
                        {{ $keluhan->status }}
                    </span>
                </div>
            </div>

            <div class="detail-body">
                <div class="detail-grid">
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-user"></i> Nama Pengaju</div>
                        <div class="field-value">{{ $keluhan->nama }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-envelope"></i> Email</div>
                        <div class="field-value">{{ $keluhan->email }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-graduation-cap"></i> Program Studi</div>
                        <div class="field-value">{{ $keluhan->prodi }} — {{ $keluhan->prodi_nama }}</div>
                    </div>
                    <div class="detail-field">
                        <div class="field-label"><i class="fas fa-building"></i> Asrama / Lorong</div>
                        <div class="field-value">{{ $keluhan->asrama }} · {{ $keluhan->lorong }}</div>
                    </div>

                    <div class="detail-field full">
                        <div class="field-label"><i class="fas fa-sticky-note"></i> Keterangan Keluhan</div>
                        <div class="field-value" style="font-weight:400; font-size:13px; line-height:1.6; color:#555;">{{ $keluhan->keterangan }}</div>
                    </div>

                    @if(!empty($keluhan->lampiran))
                    <div class="detail-field full">
                        <div class="field-label"><i class="fas fa-paperclip"></i> Lampiran ({{ count($keluhan->lampiran) }})</div>
                        @foreach($keluhan->lampiran as $file)
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

                @if($keluhan->catatan_pengasuhan)
                <div style="margin-top:16px; padding:16px 18px; background:{{ in_array($keluhan->status, ['Selesai', 'Diproses']) ? '#f0fff4' : '#fff5f5' }}; border-radius:12px; border-left:4px solid {{ in_array($keluhan->status, ['Selesai', 'Diproses']) ? '#38a169' : '#e53e3e' }};">
                    <div class="field-label"><i class="fas fa-comment-dots"></i> Catatan Pengasuhan</div>
                    <div style="font-size:13px; color:#333; line-height:1.6;">{{ $keluhan->catatan_pengasuhan }}</div>
                </div>
                @endif

                <div class="timestamps">
                    <span><i class="fas fa-clock"></i> Diajukan: {{ $keluhan->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fas fa-sync"></i> Diperbarui: {{ $keluhan->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
