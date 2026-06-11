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

/* Header */
.page-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:200px; height:200px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:80px; bottom:-60px; width:150px; height:150px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.85; font-size:13px; position:relative; z-index:1; }

.alert-success { background:linear-gradient(135deg,#43e97b,#38f9d7); color:white; padding:13px 18px; border-radius:12px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-weight:600; font-size:13px; }

/* Layout dua kolom */
.poin-layout { display: grid; grid-template-columns: 1fr 1.8fr; gap: 20px; }

/* Panel kiri */
.panel-left { display: flex; flex-direction: column; gap: 16px; }
.card { background: white; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,.06); overflow: hidden; }
.card-header { padding: 16px 20px; border-bottom: 1px solid #f0f2f7; display: flex; align-items: center; gap: 10px; }
.card-header-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px; color: white; flex-shrink: 0; }
.card-header h3 { font-size: 14px; font-weight: 700; color: #333; margin: 0; }
.card-body { padding: 18px 20px; }

/* Search mahasiswa */
.mhs-search-box { position: relative; margin-bottom: 10px; }
.mhs-search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 12px; }
.mhs-search-box input { width: 100%; padding: 9px 12px 9px 34px; border: 1.5px solid #edf0f7; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; outline: none; color: #444; background: #fafbff; transition: border .15s; }
.mhs-search-box input:focus { border-color: #f5576c; }

.mhs-dropdown { max-height: 220px; overflow-y: auto; border: 1.5px solid #edf0f7; border-radius: 10px; background: white; }
.mhs-option { padding: 9px 14px; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: background .1s; border-bottom: 1px solid #f8f9ff; font-size: 13px; color: #444; }
.mhs-option:last-child { border-bottom: none; }
.mhs-option:hover { background: #f8f0ff; }
.mhs-option.selected { background: #f3eeff; font-weight: 600; }
.mhs-avatar-sm { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: white; flex-shrink: 0; }
.mhs-empty { text-align: center; padding: 20px; color: #bbb; font-size: 13px; }

/* Info mahasiswa terpilih */
.selected-student-card { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 14px; padding: 18px; color: white; margin-bottom: 4px; }
.student-ava { width: 52px; height: 52px; border-radius: 50%; background: rgba(255,255,255,.25); display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; margin-bottom: 10px; }
.student-name { font-size: 16px; font-weight: 800; margin-bottom: 2px; }
.student-npm  { font-size: 12px; opacity: .85; }
.student-kelas { font-size: 11px; opacity: .7; margin-top: 2px; }

/* Total poin badge */
.total-poin-wrap { display: flex; align-items: center; justify-content: space-between; background: white; border-radius: 14px; padding: 16px 18px; box-shadow: 0 2px 10px rgba(0,0,0,.06); margin-bottom: 4px; }
.total-poin-label { font-size: 12px; color: #888; font-weight: 600; }
.total-poin-value { font-size: 28px; font-weight: 800; }

/* Form tambah poin */
.form-group  { margin-bottom: 14px; }
.form-label  { font-size: 11px; font-weight: 700; color: #666; text-transform: uppercase; letter-spacing: .05em; display: block; margin-bottom: 5px; }
.form-control { width: 100%; padding: 9px 12px; border: 1.5px solid #edf0f7; border-radius: 10px; font-size: 13px; font-family: 'Inter', sans-serif; outline: none; color: #444; background: #fafbff; transition: border .15s; }
.form-control:focus { border-color: #f5576c; }
textarea.form-control { resize: vertical; min-height: 70px; }

.kategori-toggle { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 4px; }
.kategori-btn { padding: 9px; border-radius: 10px; border: 2px solid #edf0f7; background: white; cursor: pointer; font-size: 12px; font-weight: 700; text-align: center; transition: all .15s; color: #888; }
.kategori-btn.prestasi-active  { border-color: #38a169; background: #e6fff5; color: #38a169; }
.kategori-btn.pelanggaran-active { border-color: #e53e3e; background: #fff0f0; color: #e53e3e; }

.btn-submit { width: 100%; background: linear-gradient(135deg,#f093fb,#f5576c); color: white; border: none; padding: 12px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: opacity .15s; font-family: 'Inter', sans-serif; }
.btn-submit:hover { opacity: .9; }
.btn-submit:disabled { opacity: .6; cursor: not-allowed; }

/* Panel kanan - riwayat */
.riwayat-header { padding: 16px 20px; border-bottom: 1px solid #f0f2f7; display: flex; align-items: center; justify-content: space-between; }
.riwayat-title  { font-size: 14px; font-weight: 700; color: #333; display: flex; align-items: center; gap: 8px; }

table { width: 100%; border-collapse: collapse; }
thead tr { background: #f8f9ff; }
th { padding: 12px 14px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #8a93b0; }
td { padding: 12px 14px; font-size: 13px; color: #444; border-top: 1px solid #f0f2f7; vertical-align: middle; }
tbody tr { transition: background .1s; }
tbody tr:hover { background: #fdf0ff; }

.kategori-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.poin-positive { font-size: 15px; font-weight: 800; color: #38a169; }
.poin-negative { font-size: 15px; font-weight: 800; color: #e53e3e; }
.btn-hapus { background: #fff0f0; color: #e53e3e; border: none; padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: background .1s; }
.btn-hapus:hover { background: #ffe0e0; }

.empty-state-riwayat { text-align: center; padding: 50px 20px; }
.empty-state-riwayat i { font-size: 44px; color: #e2e5ee; display: block; margin-bottom: 12px; }
.empty-state-riwayat p { color: #bbb; font-size: 13px; margin: 0; }

.empty-no-student { text-align: center; padding: 60px 20px; }
.empty-no-student i { font-size: 48px; color: #e2e5ee; display: block; margin-bottom: 14px; }
.empty-no-student p { color: #bbb; font-size: 14px; font-weight: 600; margin: 0 0 6px; }
.empty-no-student small { color: #ccc; font-size: 12px; }

/* Modal */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:20px; padding:30px 28px; max-width:380px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,.2); text-align:center; animation:modalIn .2s ease; }
@keyframes modalIn { from{transform:scale(.93);opacity:0} to{transform:scale(1);opacity:1} }
.modal-icon { width:56px; height:56px; border-radius:50%; background:#fff0f0; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.modal-icon i  { font-size:24px; color:#e53e3e; }
.modal-box h3  { margin:0 0 6px; font-size:17px; font-weight:800; color:#333; }
.modal-box p   { margin:0 0 22px; font-size:13px; color:#888; }
.modal-actions { display:flex; gap:10px; justify-content:center; }
.modal-cancel  { background:#f4f5f9; color:#666; border:none; padding:10px 22px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-cancel:hover  { background:#e8e9f0; }
.modal-confirm { background:linear-gradient(135deg,#fc5c7d,#e53e3e); color:white; border:none; padding:10px 22px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-confirm:hover { opacity:.9; }

/* File upload area */
.file-upload-area {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    border: 2px dashed #d8b4fe; border-radius: 12px; padding: 18px 14px;
    background: #fdf4ff; cursor: pointer; transition: all .15s; text-align: center;
    font-size: 12px; color: #9333ea; font-weight: 600;
}
.file-upload-area:hover { border-color: #a855f7; background: #fae8ff; }
.file-upload-area.has-file { border-color: #38a169; background: #e6fff5; color: #276749; }
</style>

<div class="app-layout">

    {{-- ── SIDEBAR ── --}}
    <x-sidebar active="poin" />

    <!-- MAIN -->
    <div class="main-content">

        <!-- Header -->
        <div class="page-header">
            <h1><i class="fas fa-star" style="margin-right:10px;"></i>POIN Pengasuhan</h1>
            <p>Kelola poin pengasuhan mahasiswa — Prestasi &amp; Pelanggaran</p>
        </div>

        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle" style="font-size:17px;"></i> {{ session('success') }}
        </div>
        @endif

        <div class="poin-layout">

            {{-- ── KOLOM KIRI ── --}}
            <div class="panel-left">

                {{-- Pilih Mahasiswa --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon" style="background:linear-gradient(135deg,#667eea,#764ba2);">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>Pilih Mahasiswa</h3>
                    </div>
                    <div class="card-body">
                        <div class="mhs-search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="mhsSearchInput"
                                   placeholder="Ketik nama atau NPM mahasiswa..."
                                   oninput="filterMahasiswaList()"
                                   value="{{ $selectedStudent ? ($selectedStudent['nickname'].' - '.$selectedStudent['npm']) : '' }}">
                        </div>
                        <div class="mhs-dropdown" id="mhsDropdown" style="{{ $selectedStudent ? 'display:none;' : '' }}">
                            @php $avatarColors = ['#667eea','#764ba2','#f093fb','#f5576c','#38a169','#e07020','#3182ce','#d53f8c']; $ci=0; @endphp
                            @forelse($flatMahasiswa as $m)
                            <div class="mhs-option {{ $selectedNpm === $m['npm'] ? 'selected' : '' }}"
                                 data-npm="{{ $m['npm'] }}"
                                 data-search="{{ strtolower($m['nama']).' '.strtolower($m['nickname']).' '.$m['npm'] }}"
                                 onclick="selectMahasiswa('{{ $m['npm'] }}', '{{ addslashes($m['nickname']) }} - {{ $m['npm'] }}')">
                                <div class="mhs-avatar-sm" style="background:{{ $avatarColors[$ci % count($avatarColors)] }};">
                                    {{ strtoupper(substr($m['nickname'], 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600; color:#333;">{{ $m['nickname'] }}</div>
                                    <div style="font-size:11px; color:#aab;">{{ $m['npm'] }} · {{ $m['kelas'] }}</div>
                                </div>
                            </div>
                            @php $ci++; @endphp
                            @empty
                            <div class="mhs-empty">Tidak ada mahasiswa</div>
                            @endforelse
                        </div>
                        @if($selectedStudent)
                        <div style="margin-top:8px;">
                            <a href="{{ route('poin.index') }}"
                               style="font-size:12px; color:#f5576c; font-weight:600; text-decoration:none; display:flex; align-items:center; gap:4px;">
                                <i class="fas fa-times-circle"></i> Ganti mahasiswa
                            </a>
                        </div>
                        @else
                        <div style="font-size:12px; color:#bbb; margin-top:8px; text-align:center;">
                            Pilih mahasiswa untuk mulai mengelola poin
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Info & Form (hanya jika mahasiswa dipilih) --}}
                @if($selectedStudent)

                {{-- Info mahasiswa --}}
                <div class="selected-student-card">
                    <div class="student-ava">{{ strtoupper(substr($selectedStudent['nickname'], 0, 1)) }}</div>
                    <div class="student-name">{{ $selectedStudent['nama'] }}</div>
                    <div class="student-npm">NPM: {{ $selectedStudent['npm'] }}</div>
                    <div class="student-kelas">{{ $selectedStudent['kelas'] }}</div>
                </div>

                {{-- Total poin --}}
                <div class="total-poin-wrap">
                    <div>
                        <div class="total-poin-label">Total Poin</div>
                        <div class="total-poin-value" style="color:{{ $totalPoin >= 0 ? '#38a169' : '#e53e3e' }};">
                            {{ $totalPoin >= 0 ? '+' : '' }}{{ $totalPoin }}
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:11px; color:#bbb;">{{ $riwayat->count() }} entri</div>
                        <div style="font-size:20px; color:{{ $totalPoin >= 0 ? '#38a169' : '#e53e3e' }};">
                            <i class="fas {{ $totalPoin >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                        </div>
                    </div>
                </div>

                {{-- Form Tambah Poin --}}
                @if(Auth::user()->canEdit())
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                            <i class="fas fa-plus"></i>
                        </div>
                        <h3>Tambah Poin</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('poin.store') }}" id="poinForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="npm" value="{{ $selectedStudent['npm'] }}">

                            {{-- Kategori --}}
                            <div class="form-group">
                                <label class="form-label">Kategori</label>
                                <input type="hidden" name="kategori" id="kategoriInput" value="{{ old('kategori', 'prestasi') }}">
                                <div class="kategori-toggle">
                                    <button type="button"
                                            class="kategori-btn {{ old('kategori', 'prestasi') === 'prestasi' ? 'prestasi-active' : '' }}"
                                            id="btnPrestasi"
                                            onclick="setKategori('prestasi')">
                                        <i class="fas fa-trophy"></i> Prestasi
                                    </button>
                                    <button type="button"
                                            class="kategori-btn {{ old('kategori') === 'pelanggaran' ? 'pelanggaran-active' : '' }}"
                                            id="btnPelanggaran"
                                            onclick="setKategori('pelanggaran')">
                                        <i class="fas fa-exclamation-triangle"></i> Pelanggaran
                                    </button>
                                </div>
                            </div>

                            {{-- Jenis Kegiatan --}}
                            <div class="form-group">
                                <label class="form-label">Jenis Kegiatan</label>
                                <select id="jenisKegiatanSelect" class="form-control" onchange="onJenisChange()" required>
                                    <option value="">-- Pilih Jenis Kegiatan --</option>
                                </select>
                            </div>

                            {{-- Kategori Kegiatan --}}
                            <div class="form-group">
                                <label class="form-label">Kategori Kegiatan</label>
                                <select id="kategoriKegiatanSelect" name="kegiatan" class="form-control" onchange="onKategoriKegiatanChange()" required>
                                    <option value="">-- Pilih Kategori Kegiatan --</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                       value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nilai Poin</label>
                                <input type="number" name="nilai" id="nilaiInput" class="form-control"
                                       placeholder="Contoh: 3.5" min="0" step="0.001"
                                       value="{{ old('nilai') }}" required>
                                @error('nilai')<div style="color:#e53e3e; font-size:11px; margin-top:4px;">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nama Pengasuh</label>
                                <input type="text" name="pengasuh" class="form-control"
                                       value="{{ Auth::user()->name }}" readonly style="background-color: #f3f4f6; color: #4b5563; cursor: not-allowed;">
                            </div>

                            {{-- File Bukti (Prestasi Only) --}}
                            <div class="form-group" id="buktiFileGroup" style="display:none;">
                                <label class="form-label">Bukti Prestasi <span style="color:#bbb; font-weight:400;">(PDF/JPG/PNG, maks 5MB)</span></label>
                                <label for="buktiFile" class="file-upload-area" id="fileUploadLabel">
                                    <i class="fas fa-cloud-upload-alt" style="font-size:22px; color:#c026d3; margin-bottom:6px;"></i>
                                    <span id="fileUploadText">Klik atau drag file bukti di sini</span>
                                    <span id="fileUploadName" style="display:none; font-size:11px; color:#38a169; font-weight:700; margin-top:4px;"></span>
                                </label>
                                <input type="file" name="bukti_file" id="buktiFile" accept=".pdf,.jpg,.jpeg,.png"
                                       style="display:none;" onchange="onFileChange(this)">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Keterangan Tambahan</label>
                                <textarea name="keterangan" class="form-control"
                                          placeholder="Opsional...">{{ old('keterangan') }}</textarea>
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fas fa-plus-circle"></i> Tambah Poin
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                @endif {{-- end if selectedStudent --}}

            </div>{{-- end panel-left --}}

            {{-- ── KOLOM KANAN (Riwayat) ── --}}
            <div class="card" style="align-self:start;">
                <div class="riwayat-header">
                    <div class="riwayat-title">
                        <i class="fas fa-history" style="color:#f5576c;"></i>
                        Riwayat Poin
                    </div>
                    @if($selectedStudent)
                    <div style="font-size:12px; color:#aab;">{{ $riwayat->count() }} entri</div>
                    @endif
                </div>

                @if(!$selectedStudent)
                <div class="empty-no-student">
                    <i class="fas fa-history" style="color:#e2e5ee;"></i>
                    <p>Pilih mahasiswa untuk melihat riwayat poin</p>
                </div>

                @elseif($riwayat->isEmpty())
                <div class="empty-state-riwayat">
                    <i class="fas fa-star" style="color:#f3d0ff;"></i>
                    <p>Belum ada riwayat poin untuk mahasiswa ini</p>
                </div>

                @else
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TANGGAL</th>
                                <th>KATEGORI</th>
                                <th>KEGIATAN</th>
                                <th>PENGASUH</th>
                                <th style="text-align:center;">NILAI</th>
                                @if(Auth::user()->canEdit())
                                <th style="text-align:center;">AKSI</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $i => $p)
                            <tr>
                                <td style="color:#bbb; font-size:12px;">{{ $i + 1 }}</td>
                                <td style="white-space:nowrap; font-size:12px; color:#666;">
                                    {{ \Carbon\Carbon::parse($p->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                                </td>
                                <td>
                                    @if($p->kategori === 'prestasi')
                                    <span class="kategori-badge" style="background:#e6fff5; color:#38a169;">
                                        <i class="fas fa-trophy" style="font-size:10px;"></i> Prestasi
                                    </span>
                                    @else
                                    <span class="kategori-badge" style="background:#fff0f0; color:#e53e3e;">
                                        <i class="fas fa-exclamation-triangle" style="font-size:10px;"></i> Pelanggaran
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#333;">{{ $p->kegiatan }}</div>
                                    @if($p->keterangan)
                                    <div style="font-size:11px; color:#aab; margin-top:1px;">{{ Str::limit($p->keterangan, 50) }}</div>
                                    @endif
                                </td>
                                <td style="font-size:12px; color:#666;">{{ $p->pengasuh }}</td>
                                <td style="text-align:center;">
                                    @if($p->kategori === 'prestasi')
                                    <span class="poin-positive">+{{ $p->nilai }}</span>
                                    @else
                                    <span class="poin-negative">-{{ $p->nilai }}</span>
                                    @endif
                                </td>
                                @if(Auth::user()->canEdit())
                                <td style="text-align:center;">
                                    <button type="button" class="btn-hapus"
                                            onclick="showHapusModal({{ $p->id }}, '{{ addslashes($p->kegiatan) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>{{-- end riwayat card --}}

        </div>{{-- end poin-layout --}}
    </div>{{-- end main-content --}}
</div>{{-- end app-layout --}}

{{-- Delete forms --}}
@if($selectedStudent)
@foreach($riwayat as $p)
<form id="del-poin-{{ $p->id }}" method="POST" action="{{ route('poin.destroy', $p->id) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endforeach
@endif

{{-- Modal Konfirmasi Hapus --}}
<div class="modal-overlay" id="hapusPoinModal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-star"></i></div>
        <h3>Hapus Poin?</h3>
        <p id="hapusPoinDesc" style="font-weight:600; color:#333; margin-bottom:6px;"></p>
        <p>Data poin ini akan dihapus secara permanen.</p>
        <div class="modal-actions">
            <button class="modal-cancel" onclick="closeHapusModal()">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="modal-confirm" onclick="submitHapusPoin()">
                <i class="fas fa-trash"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
// ============================================================
// DATA KEGIATAN & PELANGGARAN — Berdasarkan Kepdir No.39/2025
// Format: { label, nilai } — nilai bisa null (user isi manual)
// ============================================================
const PRESTASI_DATA = {
    "Perlombaan & Pertandingan": [
        { label: "Perlombaan/Pertandingan Internasional — Juara 1", nilai: 3.8 },
        { label: "Perlombaan/Pertandingan Internasional — Juara 2", nilai: 3.5 },
        { label: "Perlombaan/Pertandingan Internasional — Juara 3", nilai: 3.3 },
        { label: "Perlombaan/Pertandingan Internasional — Pemenang Kategori/Peserta", nilai: 1.2 },
        { label: "Perlombaan/Pertandingan Nasional — Juara 1", nilai: 3.1 },
        { label: "Perlombaan/Pertandingan Nasional — Juara 2", nilai: 2.6 },
        { label: "Perlombaan/Pertandingan Nasional — Juara 3", nilai: 2.1 },
        { label: "Perlombaan/Pertandingan Nasional — Pemenang Kategori/Peserta", nilai: 0.9 },
        { label: "Perlombaan/Pertandingan Provinsi — Juara 1", nilai: 2.4 },
        { label: "Perlombaan/Pertandingan Provinsi — Juara 2", nilai: 1.9 },
        { label: "Perlombaan/Pertandingan Provinsi — Juara 3", nilai: 1.4 },
        { label: "Perlombaan/Pertandingan Provinsi — Pemenang Kategori/Peserta", nilai: 0.6 },
        { label: "Perlombaan/Pertandingan Kotamadya/Kabupaten — Juara 1", nilai: 1.7 },
        { label: "Perlombaan/Pertandingan Kotamadya/Kabupaten — Juara 2", nilai: 1.2 },
        { label: "Perlombaan/Pertandingan Kotamadya/Kabupaten — Juara 3", nilai: 0.7 },
        { label: "Perlombaan/Pertandingan Kotamadya/Kabupaten — Pemenang Kategori/Peserta", nilai: 0.3 },
    ],
    "Sertifikasi": [
        { label: "Sertifikasi Akademik/Non-akademik Tingkat Internasional", nilai: 1.0 },
        { label: "Sertifikasi Akademik/Non-akademik Tingkat Nasional", nilai: 0.7 },
    ],
    "Produk / Jasa Keamanan Siber": [
        { label: "Produk/Jasa Keamanan Siber — Masyarakat Umum Internasional", nilai: 1.2 },
        { label: "Produk/Jasa Keamanan Siber — Pihak Tertentu Internasional", nilai: 1.1 },
        { label: "Produk/Jasa Keamanan Siber — Masyarakat Umum Nasional", nilai: 1.1 },
        { label: "Produk/Jasa Keamanan Siber — Pihak Tertentu Nasional", nilai: 1.0 },
        { label: "Produk/Jasa Keamanan Siber — Masyarakat Umum Provinsi", nilai: 0.9 },
        { label: "Produk/Jasa Keamanan Siber — Pihak Tertentu Provinsi", nilai: 0.7 },
        { label: "Produk/Jasa Keamanan Siber — Masyarakat Umum Kotamadya/Kabupaten", nilai: 0.6 },
        { label: "Produk/Jasa Keamanan Siber — Pihak Tertentu Kotamadya/Kabupaten", nilai: 0.6 },
        { label: "Produk/Jasa Keamanan Siber — Lingkup Kantor BSSN", nilai: 0.7 },
        { label: "Produk/Jasa Keamanan Siber — Lingkup Poltek SSN", nilai: 0.5 },
    ],
    "Organisasi": [
        { label: "Organisasi Internasional — Ketua/Koordinator", nilai: 2.4 },
        { label: "Organisasi Internasional — Sekretaris/Bendahara/Kepala Bidang", nilai: 2.2 },
        { label: "Organisasi Internasional — Anggota", nilai: 1.9 },
        { label: "Organisasi Nasional — Ketua/Koordinator", nilai: 2.3 },
        { label: "Organisasi Nasional — Sekretaris/Bendahara/Kepala Bidang", nilai: 2.1 },
        { label: "Organisasi Nasional — Anggota", nilai: 1.8 },
        { label: "Organisasi Provinsi — Ketua/Sekretaris/Bendahara", nilai: 2.2 },
        { label: "Organisasi Provinsi — Kepala Bidang/Sejenisnya", nilai: 2.0 },
        { label: "Organisasi Provinsi — Anggota", nilai: 1.7 },
        { label: "Ketua/Wakil/Sekretaris/Bendahara Senat Korps Taruna (Demustar >87)", nilai: 10.0 },
        { label: "Ketua/Wakil/Sekretaris/Bendahara Senat Korps Taruna (Demustar 71–87)", nilai: 8.0 },
        { label: "Ketua/Wakil/Sekretaris/Bendahara Senat Korps Taruna (Demustar 50–71)", nilai: 5.0 },
        { label: "Ketua/Wakil/Sekretaris/Bendahara Senat Korps Taruna (Demustar ≤50)", nilai: 3.0 },
        { label: "Kepala Seksi Korps Taruna (Demustar >87)", nilai: 9.0 },
        { label: "Kepala Seksi Korps Taruna (Demustar 71–87)", nilai: 7.2 },
        { label: "Kepala Seksi Korps Taruna (Demustar 50–71)", nilai: 4.5 },
        { label: "Kepala Seksi Korps Taruna (Demustar ≤50)", nilai: 2.7 },
        { label: "Kepala Biro/Anggota Poltar Tk.IV (Demustar >87)", nilai: 8.25 },
        { label: "Kepala Biro/Anggota Poltar Tk.IV (Demustar 71–87)", nilai: 6.6 },
        { label: "Kepala Biro/Anggota Poltar Tk.IV (Demustar 50–71)", nilai: 4.125 },
        { label: "Kepala Biro/Anggota Poltar Tk.IV (Demustar ≤50)", nilai: 2.475 },
        { label: "Kepala Satuan Korps Taruna Madya (Demustar >87)", nilai: 7.75 },
        { label: "Kepala Satuan Korps Taruna Madya (Demustar 71–87)", nilai: 6.2 },
        { label: "Kepala Satuan Korps Taruna Madya (Demustar 50–71)", nilai: 3.875 },
        { label: "Kepala Satuan Korps Taruna Madya (Demustar ≤50)", nilai: 2.325 },
        { label: "Kabag Tk.III (Demustar >87)", nilai: 7.5 },
        { label: "Kabag Tk.III (Demustar 71–87)", nilai: 6.0 },
        { label: "Kabag Tk.III (Demustar 50–71)", nilai: 3.75 },
        { label: "Kabag Tk.III (Demustar ≤50)", nilai: 2.25 },
        { label: "Staf Tk.II (Demustar >87)", nilai: 7.0 },
        { label: "Staf Tk.II (Demustar 71–87)", nilai: 5.6 },
        { label: "Staf Tk.II (Demustar 50–71)", nilai: 3.5 },
        { label: "Staf Tk.II (Demustar ≤50)", nilai: 2.1 },
        { label: "Ketua Demustar (Pengasuh >87)", nilai: 9.5 },
        { label: "Ketua Demustar (Pengasuh 71–87)", nilai: 7.6 },
        { label: "Ketua Demustar (Pengasuh 50–71)", nilai: 4.75 },
        { label: "Ketua Demustar (Pengasuh ≤50)", nilai: 2.85 },
        { label: "Sekjen Demustar (Pengasuh >87)", nilai: 9.0 },
        { label: "Sekjen Demustar (Pengasuh 71–87)", nilai: 7.2 },
        { label: "Sekjen Demustar (Pengasuh 50–71)", nilai: 4.5 },
        { label: "Sekjen Demustar (Pengasuh ≤50)", nilai: 2.7 },
        { label: "Komisi Demustar (Pengasuh >87)", nilai: 8.0 },
        { label: "Komisi Demustar (Pengasuh 71–87)", nilai: 6.4 },
        { label: "Komisi Demustar (Pengasuh 50–71)", nilai: 4.0 },
        { label: "Komisi Demustar (Pengasuh ≤50)", nilai: 2.4 },
        { label: "Anggota Demustar Tk.4 (Pengasuh >87)", nilai: 6.25 },
        { label: "Anggota Demustar Tk.3 (Pengasuh >87)", nilai: 6.0 },
        { label: "Anggota Demustar Tk.2 (Pengasuh >87)", nilai: 5.75 },
        { label: "Anggota Demustar Tk.1 (Pengasuh >87)", nilai: 5.0 },
        { label: "KPUT (Demustar >87)", nilai: 3.0 },
        { label: "Asisten Kesehatan (Demustar >87)", nilai: 4.5 },
        { label: "Asisten Laboratorium (Demustar >87)", nilai: 3.0 },
        { label: "Ketua Klub (Demustar >87)", nilai: 3.5 },
        { label: "Tugas Belajar Korea (Demustar >87)", nilai: 5.5 },
        { label: "Duta Literasi (Demustar >87)", nilai: 4.0 },
        { label: "Partisipasi Kaderisasi Tk.1 (Demustar >87)", nilai: 1.5 },
    ],
    "Kepanitiaan": [
        { label: "Kepanitiaan Internasional — Ketua", nilai: 1.2 },
        { label: "Kepanitiaan Internasional — Sekretaris/Bendahara/Kepala Bidang", nilai: 1.1 },
        { label: "Kepanitiaan Internasional — Anggota", nilai: 1.0 },
        { label: "Kepanitiaan Nasional — Ketua", nilai: 1.1 },
        { label: "Kepanitiaan Nasional — Sekretaris/Bendahara/Kepala Bidang", nilai: 1.0 },
        { label: "Kepanitiaan Nasional — Anggota", nilai: 0.9 },
        { label: "Kepanitiaan Provinsi — Ketua", nilai: 1.0 },
        { label: "Kepanitiaan Provinsi — Sekretaris/Bendahara/Kepala Bidang", nilai: 0.9 },
        { label: "Kepanitiaan Provinsi — Anggota", nilai: 0.8 },
        { label: "Kepanitiaan Lokal/Kotamadya/BSSN (Acara Besar) — Ketua", nilai: 0.9 },
        { label: "Kepanitiaan Lokal/Kotamadya/BSSN (Acara Besar) — Sekretaris/Bendahara", nilai: 0.8 },
        { label: "Kepanitiaan Lokal/Kotamadya/BSSN (Acara Besar) — Anggota", nilai: 0.7 },
        { label: "Kepanitiaan Acara Besar Taruna Poltek SSN — Ketua", nilai: 0.9 },
        { label: "Kepanitiaan Acara Besar Taruna Poltek SSN — Sekretaris/Bendahara", nilai: 0.7 },
        { label: "Kepanitiaan Acara Besar Taruna Poltek SSN — Anggota", nilai: 0.5 },
        { label: "Perbantuan Kegiatan Singkat Poltek SSN/BSSN", nilai: 0.3 },
        { label: "Pengisi Acara BSSN — Penampil Kesenian", nilai: 0.5 },
        { label: "Pengisi Acara BSSN — Marching Band Display", nilai: 0.7 },
        { label: "Pengisi Acara BSSN — Marching Band Korsik", nilai: 0.5 },
        { label: "Pengisi Acara BSSN — Band/Hadroh/Marawis", nilai: 0.4 },
        { label: "Pengisi Acara BSSN — Penampil Non Kesenian", nilai: 0.4 },
        { label: "Pengisi Acara BSSN — Kolaborasi (Korsik+Display)", nilai: 0.7 },
        { label: "Petugas Upacara Kegiatan BSSN", nilai: 0.3 },
        { label: "Petugas Upacara Kegiatan PSSN", nilai: 0.2 },
        { label: "Penjaga Booth Stand Kegiatan BSSN/Poltek SSN", nilai: 0.3 },
        { label: "Peserta Kegiatan BSSN (Upacara, HUT BSSN, dll)", nilai: 0.2 },
        { label: "Pendamping Pejabat/Tamu BSSN/Poltek SSN", nilai: 0.3 },
        { label: "Penerima Tamu/Pembawa Baki Poltek SSN/BSSN", nilai: 0.2 },
        { label: "MC Acara Kedinasan (Wisuda, Pengukuhan, dll)", nilai: 0.3 },
        { label: "Tugas Pembawa Tanda Kehormatan", nilai: 0.3 },
    ],
    "Lain-lain (Tambahan)": [
        { label: "Perbantuan Penyelenggara Non Panitia", nilai: 0.2 },
        { label: "Kegiatan Terpuji Sesuai 4 Nilai Dasar Taruna", nilai: null },
        { label: "Mendampingi Teman Izin Keluar (Bermalam)", nilai: 0.2 },
        { label: "Mendampingi Teman Izin Keluar (Tidak Bermalam)", nilai: 0.1 },
        { label: "Jaga Asrama (Non-Rutin)", nilai: 0.1 },
        { label: "Taruna Jaga >2 kali, catatan baik", nilai: 1.8 },
        { label: "Taruna Jaga 1 kali, catatan baik (>1 kali krn perbaikan)", nilai: 1.2 },
        { label: "Taruna Jaga 1 kali, ketidaksesuaian ringan", nilai: 0.6 },
        { label: "Taruna Jaga 1 kali, ketidaksesuaian sedang/buruk", nilai: 0.3 },
        { label: "Komandan Regu >2 kali", nilai: 0.7 },
        { label: "Komandan Regu 1–2 kali", nilai: 0.6 },
        { label: "Ketua Kelas >2 kali", nilai: 0.4 },
        { label: "Ketua Kelas 2 kali", nilai: 0.3 },
        { label: "Ketua Kelas 1 kali", nilai: 0.2 },
        { label: "Koordinator Penampilan/Perlombaan (Non Panitia)", nilai: 0.3 },
        { label: "Pemapar Seminar/Sosialisasi Poltek SSN/Pengabdian Masyarakat", nilai: 0.4 },
        { label: "Jurnal/Seminar Internasional — Penulis 1", nilai: 1.2 },
        { label: "Jurnal/Seminar Internasional — Penulis 2", nilai: 1.0 },
        { label: "Jurnal/Seminar Internasional — Penulis 3+", nilai: 0.8 },
        { label: "Seminar Internasional — Peserta (Undangan Satsuh)", nilai: 0.3 },
        { label: "Seminar Internasional — Peserta (Mandiri, maks 3x/sem)", nilai: 0.2 },
        { label: "Seminar Internasional — Peserta Terbaik 1/Kategori Khusus", nilai: 0.6 },
        { label: "Jurnal/Seminar Nasional/BSSN/PTK — Penulis 1", nilai: 1.0 },
        { label: "Jurnal/Seminar Nasional/BSSN/PTK — Penulis 2", nilai: 0.9 },
        { label: "Jurnal/Seminar Nasional/BSSN/PTK — Penulis 3+", nilai: 0.7 },
        { label: "Seminar Nasional/BSSN — Peserta (Undangan Satsuh)", nilai: 0.3 },
        { label: "Seminar Nasional/BSSN — Peserta (Mandiri, maks 5x/sem)", nilai: 0.2 },
        { label: "Seminar Nasional/BSSN — Peserta Terbaik 1/Kategori Khusus", nilai: 0.4 },
        { label: "Sanapati Cendekia Emas", nilai: 1.1 },
        { label: "Sanapati Cendekia Perak", nilai: 1.0 },
        { label: "Sanapati Cendekia Perunggu", nilai: 0.9 },
        { label: "Kesamaptaan — Peringkat Tertinggi 1", nilai: 1.1 },
        { label: "Kesamaptaan — Peringkat Tertinggi 2", nilai: 1.0 },
        { label: "Kesamaptaan — Peringkat Tertinggi 3", nilai: 0.9 },
        { label: "Kesamaptaan — Nilai Samapta 95–100", nilai: 0.4 },
        { label: "Mentor Personal (1-2 Mentee) Non Periodik 1–5 Pertemuan", nilai: 0.5 },
        { label: "Mentor Personal (1-2 Mentee) Non Periodik 6–10 Pertemuan", nilai: 0.8 },
        { label: "Mentor Personal (1-2 Mentee) Non Periodik 11–15 Pertemuan", nilai: 1.0 },
        { label: "Mentor Kelas (10-20 Mentee) Non Periodik 1–4 Pertemuan", nilai: 1.4 },
        { label: "Mentor Kelas (10-20 Mentee) Non Periodik 5–10 Pertemuan", nilai: 2.0 },
        { label: "Mentor Kelas (10-20 Mentee) Non Periodik 11–15 Pertemuan", nilai: 2.4 },
        { label: "Pengembangan Diri Rohani (Islam/Kristen/Hindu) — lihat tabel", nilai: null },
        { label: "Poin Perpustakaan 100–199", nilai: 0.1 },
        { label: "Poin Perpustakaan 200–299", nilai: 0.2 },
        { label: "Poin Perpustakaan 300–399", nilai: 0.3 },
        { label: "Poin Perpustakaan 400–499", nilai: 0.4 },
        { label: "Poin Perpustakaan 500–599", nilai: 0.5 },
        { label: "Poin Perpustakaan 600–699", nilai: 0.6 },
        { label: "Poin Perpustakaan >700", nilai: 0.7 },
        { label: "PIC Akademik Kelas", nilai: 1.5 },
        { label: "PIC Mata Kuliah", nilai: 1.2 },
    ]
};

const PELANGGARAN_DATA = {
    "Kegiatan Harian Taruna (KHT)": [
        { label: "Terlambat KHT (berdampak diri sendiri)", nilai: 0.256 },
        { label: "Terlambat KHT (berdampak pada organisasi Poltek SSN)", nilai: 0.272 },
        { label: "Terlambat KHT (berdampak pada lingkungan kantor)", nilai: 0.336 },
        { label: "Terlambat KHT Pengganti Makan Bersama (hari puasa)", nilai: 0.248 },
        { label: "Terlambat kembali ke kampus dari izin bermalam/pesiar/libur", nilai: 0.316 },
        { label: "Tidak mengikuti KHT tanpa izin", nilai: 0.348 },
        { label: "Tidak mengikuti KHT Makan Sahur", nilai: 0.256 },
        { label: "Tidak mengikuti KHT Pengganti Makan Bersama (hari puasa)", nilai: 0.256 },
        { label: "Melanggar jam malam", nilai: 0.324 },
        { label: "Tidak melaksanakan kegiatan ibadah sesuai ketentuan", nilai: 0.308 },
        { label: "Tidak tidur di tempat sesuai denah kamar", nilai: 0.204 },
        { label: "Tidak melaksanakan apel/upacara tertib (Apel Taruna/i)", nilai: 0.324 },
        { label: "Tidak melaksanakan apel/upacara tertib (Apel/Upacara Pejabat PSSN)", nilai: 0.364 },
        { label: "Tidak menyimpan device/gawai pada tempat yang ditentukan", nilai: 0.384 },
        { label: "Tidak menjalankan PBB sesuai ketentuan", nilai: 0.252 },
        { label: "Tidak melakukan pergerakan sesuai rute yang ditentukan", nilai: 0.248 },
        { label: "Tidak menjaga kebersihan/kerapihan Kamar", nilai: 0.248 },
        { label: "Tidak menjaga kebersihan/kerapihan Asrama", nilai: 0.252 },
        { label: "Tidak menjaga kebersihan/kerapihan Kelas", nilai: 0.252 },
        { label: "Tidak menjaga kebersihan/kerapihan Tempat ibadah/umum", nilai: 0.312 },
        { label: "Tidur selama pelaksanaan KHT", nilai: 0.256 },
        { label: "Menghindari tes kesamaptaan tanpa alasan jelas", nilai: 0.332 },
        { label: "Tidak melaksanakan salah satu komponen tes kesamaptaan dengan sengaja", nilai: 0.332 },
        { label: "Tidak memberi penghormatan saat penaikan/penurunan bendera", nilai: 0.256 },
    ],
    "Kegiatan Akademik": [
        { label: "Terlambat datang di tempat ujian", nilai: 0.332 },
        { label: "Terlambat memasuki kelas >15 menit tanpa izin", nilai: 0.324 },
        { label: "Makan/minum di ruang ujian/perkuliahan tanpa izin", nilai: 0.128 },
        { label: "Tidur dalam pelaksanaan perkuliahan/ujian", nilai: 0.256 },
        { label: "Tidak melaksanakan ketentuan dalam ujian/perkuliahan", nilai: 0.264 },
        { label: "Mencontek dalam ujian", nilai: 4.352 },
        { label: "Bekerja sama dalam ujian", nilai: 4.832 },
        { label: "Menggunakan data palsu/plagiarism saat ujian", nilai: 4.608 },
        { label: "Tidak menjaga kekondusifan saat ujian", nilai: 0.308 },
        { label: "Tidak mengerjakan tugas dosen tanpa alasan", nilai: 0.408 },
        { label: "Bermain game/nonton film di jam perkuliahan tanpa izin", nilai: 0.376 },
    ],
    "Prosedur dan Tata Tertib": [
        { label: "Tidak membawa/menjaga buku saku", nilai: 0.308 },
        { label: "Berbelanja tidak sesuai ketentuan Perduptar (Pasal 33-34)", nilai: 0.308 },
        { label: "Mengunjungi pemakaman/orang sakit tidak sesuai ketentuan (Pasal 27-28)", nilai: 0.248 },
        { label: "Meminjam/mengembalikan sesuatu tidak sesuai ketentuan (Pasal 59)", nilai: 0.308 },
        { label: "Taruna sakit dan berobat tidak sesuai ketentuan (Pasal 12)", nilai: 0.248 },
        { label: "Bertamu/menerima tamu tidak sesuai Perduptar (Pasal 30-32)", nilai: 0.256 },
        { label: "Berpenampilan/berpakaian tidak sesuai ketentuan Perduptar", nilai: 0.316 },
        { label: "Melanggar ketentuan berkendaraan (Pasal 24)", nilai: 0.368 },
        { label: "Tidak mempedomani prosedur (izin keluar, surat jalan, dll)", nilai: 0.204 },
        { label: "Menyalahgunakan fasilitas internet (bukan untuk kepentingan belajar)", nilai: 0.384 },
        { label: "Membuat janji tidak sesuai ketentuan Perduptar (Pasal 29)", nilai: 0.312 },
        { label: "Mengunjungi tempat rekreasi/hiburan tidak sesuai Perduptar (Pasal 54)", nilai: 0.484 },
        { label: "Melanggar ketentuan tata cara meninggalkan ruang kelas", nilai: 0.252 },
        { label: "Menggunakan pakaian dinas untuk membeli barang terlarang (rokok/vape)", nilai: 1.76 },
        { label: "Terlambat mengumpulkan tugas pengasuhan/penyelenggara/dosen tanpa konfirmasi", nilai: 0.376 },
        { label: "Memasuki ruangan tanpa izin (ruang pengasuhan/dosen)", nilai: 0.256 },
        { label: "Tidak menjunjung sportivitas dalam perlombaan", nilai: 0.248 },
        { label: "Memiliki/menyimpan barang tidak berizin dari Unit Pengasuhan", nilai: 2.216 },
        { label: "Memberikan pendapat di media atas nama institusi tanpa izin Direktur", nilai: 2.672 },
        { label: "Tidak kembali dari izin keluar/pesiar/bermalam/cuti tanpa konfirmasi", nilai: 2.304 },
    ],
    "Sikap dan Perilaku": [
        { label: "Tidak menyapa saat bertemu penyelenggara/pejabat Poltek SSN", nilai: 0.248 },
        { label: "Berbohong/memberikan keterangan palsu", nilai: 1.648 },
        { label: "Tidak melaksanakan/menghormati tugas, hak, kewajiban taruna lain", nilai: 0.252 },
        { label: "Berbicara kasar/memotong pembicaraan di depan umum", nilai: 0.528 },
        { label: "Melakukan perbuatan yang membahayakan orang lain (Pasal 21)", nilai: 4.128 },
        { label: "Menghilangkan/membantu menghilangkan barang bukti dengan sengaja", nilai: 4.128 },
        { label: "Tidak melaksanakan arahan/instruksi pengasuh/penyelenggara/dosen", nilai: 0.392 },
        { label: "Tidak memelihara keamanan dan ketertiban lingkungan taruna/masyarakat", nilai: 1.28 },
        { label: "Memiliki/menyebarkan paham yang bertentangan Pancasila/UUD 1945", nilai: 4.384 },
        { label: "Menindik/menato anggota badan, menggunakan anting (taruna)", nilai: 1.472 },
        { label: "Tata rias tidak sesuai ketentuan (menyerupai lawan jenis)", nilai: 0.348 },
        { label: "Bepergian berdua bersama lawan jenis (bukan keluarga)", nilai: 0.472 },
        { label: "Tidak menjaga sikap/perilaku/kehormatan dalam interaksi lawan jenis", nilai: 1.472 },
        { label: "Mengakses situs pornografi/perjudian/kekerasan/radikalisme", nilai: 4.864 },
        { label: "Menyimpan/menyaksikan/mengedarkan konten pornografi", nilai: 4.864 },
        { label: "Tidak menjaga kontrol sosial saat berkomunikasi/berinteraksi", nilai: 1.264 },
        { label: "Tidak menjaga nama baik almamater saat berinteraksi dengan luar", nilai: 2.672 },
        { label: "Taruna/i saling memiliki hubungan asmara", nilai: 1.024 },
        { label: "Menjadikan indekos/hotel sebagai tujuan bermalam/pesiar", nilai: 0.484 },
        { label: "Mengambil/mengunggah foto/video bersama lawan jenis di luar kedinasan", nilai: 0.424 },
        { label: "Perbuatan bertentangan norma agama/hukum/kesusilaan", nilai: 6.304 },
        { label: "Menyalahgunakan/merusak barang orang lain", nilai: 0.256 },
        { label: "Tidak mematuhi tata krama bertukar pesan dalam grup", nilai: 0.488 },
        { label: "Tidak menjaga/merusak/menghilangkan barang pembagian negara", nilai: 0.548 },
        { label: "Menghina/menghasut/menyebarkan kebencian bernuansa SARA", nilai: 2.912 },
        { label: "Memiliki/menjual/meminjamkan dokumen/barang milik negara secara tidak sah", nilai: 2.304 },
        { label: "Melakukan tindakan bertentangan norma kesopanan/etika", nilai: 0.376 },
        { label: "Menghisap/menyimpan/mengedarkan rokok atau sejenisnya", nilai: 2.416 },
        { label: "Mencuri/mengambil barang yang bukan haknya", nilai: 4.384 },
        { label: "Berkelahi/melakukan tindakan kekerasan", nilai: 4.608 },
        { label: "Membeli/menggunakan software bajakan berpotensi malware", nilai: 1.12 },
        { label: "Inisiatif berlebih yang mengakibatkan orang lain berbuat salah", nilai: 0.432 },
        { label: "Tidak memiliki kepekaan/kepedulian sosial/lingkungan", nilai: 0.252 },
        { label: "Perbuatan tidak pantas sehingga menimbulkan perhatian umum", nilai: 0.456 },
        { label: "Tidak menjaga rahasia kegiatan/proses Poltek SSN/BSSN", nilai: 0.376 },
        { label: "Menghasut taruna lain untuk berbuat pelanggaran", nilai: 0.316 },
        { label: "Pembiaran terhadap taruna lain yang melakukan pelanggaran", nilai: 0.256 },
        { label: "Berkomplot/membantu taruna lain dalam pelanggaran disiplin", nilai: 0.392 },
        { label: "Pembinaan tanpa memperhatikan esensi dan nilai positif", nilai: 0.324 },
    ]
};

// ===================== STATE =====================
let currentKategori = document.getElementById('kategoriInput')
    ? document.getElementById('kategoriInput').value || 'prestasi'
    : 'prestasi';

// ===================== HELPERS =====================
function getDataForKategori(kat) {
    return kat === 'prestasi' ? PRESTASI_DATA : PELANGGARAN_DATA;
}

function populateJenis(kat) {
    const sel = document.getElementById('jenisKegiatanSelect');
    if (!sel) return;
    sel.innerHTML = '<option value="">-- Pilih Jenis Kegiatan --</option>';
    const data = getDataForKategori(kat);
    Object.keys(data).forEach(function(jenis) {
        const opt = document.createElement('option');
        opt.value = jenis;
        opt.textContent = jenis;
        sel.appendChild(opt);
    });
    populateKategoriKegiatan('');
}

function populateKategoriKegiatan(jenis) {
    const sel = document.getElementById('kategoriKegiatanSelect');
    if (!sel) return;
    sel.innerHTML = '<option value="">-- Pilih Kategori Kegiatan --</option>';
    if (!jenis) return;
    const data = getDataForKategori(currentKategori);
    if (!data[jenis]) return;
    data[jenis].forEach(function(item) {
        const opt = document.createElement('option');
        opt.value = item.label;
        opt.dataset.nilai = item.nilai !== null ? item.nilai : '';
        opt.textContent = item.label;
        sel.appendChild(opt);
    });
}

function onJenisChange() {
    const jenis = document.getElementById('jenisKegiatanSelect').value;
    populateKategoriKegiatan(jenis);
    clearNilaiAuto();
}

function onKategoriKegiatanChange() {
    const sel = document.getElementById('kategoriKegiatanSelect');
    const chosen = sel.options[sel.selectedIndex];
    const nilaiInput = document.getElementById('nilaiInput');
    if (!nilaiInput) return;
    if (chosen && chosen.dataset.nilai !== '') {
        nilaiInput.value = chosen.dataset.nilai;
    } else {
        nilaiInput.value = '';
    }
}

function clearNilaiAuto() {
    const nilaiInput = document.getElementById('nilaiInput');
    if (nilaiInput) nilaiInput.value = '';
}

// ===================== FILE UPLOAD =====================
function onFileChange(input) {
    const label = document.getElementById('fileUploadLabel');
    const nameSpan = document.getElementById('fileUploadName');
    const textSpan = document.getElementById('fileUploadText');
    if (input.files && input.files[0]) {
        const f = input.files[0];
        nameSpan.textContent = f.name + ' (' + (f.size/1024).toFixed(1) + ' KB)';
        nameSpan.style.display = 'block';
        textSpan.style.display = 'none';
        label.classList.add('has-file');
    } else {
        nameSpan.style.display = 'none';
        textSpan.style.display = 'block';
        label.classList.remove('has-file');
    }
}

// ===================== KATEGORI TOGGLE =====================
function setKategori(val) {
    currentKategori = val;
    document.getElementById('kategoriInput').value = val;
    document.getElementById('btnPrestasi').className   = 'kategori-btn' + (val === 'prestasi'   ? ' prestasi-active'   : '');
    document.getElementById('btnPelanggaran').className = 'kategori-btn' + (val === 'pelanggaran' ? ' pelanggaran-active' : '');

    // Show/hide file upload for prestasi only
    const buktiGroup = document.getElementById('buktiFileGroup');
    if (buktiGroup) buktiGroup.style.display = val === 'prestasi' ? 'block' : 'none';

    // Reset dropdowns
    populateJenis(val);
    clearNilaiAuto();
}

// ===================== PILIH MAHASISWA =====================
function selectMahasiswa(npm, label) {
    window.location = '{{ route('poin.index') }}?npm=' + npm;
}

function filterMahasiswaList() {
    const q = document.getElementById('mhsSearchInput').value.toLowerCase();
    const dd = document.getElementById('mhsDropdown');
    dd.style.display = 'block';
    document.querySelectorAll('.mhs-option').forEach(function(el) {
        const match = (el.dataset.search || '').includes(q);
        el.style.display = match ? 'flex' : 'none';
    });
}

// ===================== HAPUS MODAL =====================
let hapusPoinId = null;
function showHapusModal(id, desc) {
    hapusPoinId = id;
    document.getElementById('hapusPoinDesc').textContent = desc;
    document.getElementById('hapusPoinModal').classList.add('open');
}
function closeHapusModal() {
    document.getElementById('hapusPoinModal').classList.remove('open');
    hapusPoinId = null;
}
function submitHapusPoin() {
    if (hapusPoinId) document.getElementById('del-poin-' + hapusPoinId).submit();
}
document.getElementById('hapusPoinModal').addEventListener('click', function(e) {
    if (e.target === this) closeHapusModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeHapusModal();
});

// ===================== INIT =====================
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('jenisKegiatanSelect')) {
        populateJenis(currentKategori);

        // Show/hide file upload based on initial kategori
        const buktiGroup = document.getElementById('buktiFileGroup');
        if (buktiGroup) {
            buktiGroup.style.display = currentKategori === 'prestasi' ? 'block' : 'none';
        }
    }
});
</script>
</x-app-layout>
