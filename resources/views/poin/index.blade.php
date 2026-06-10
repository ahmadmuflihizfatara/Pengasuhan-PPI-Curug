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
                        <form method="POST" action="{{ route('poin.store') }}" id="poinForm">
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

                            <div class="form-group">
                                <label class="form-label">Kegiatan / Keterangan</label>
                                <input type="text" name="kegiatan" class="form-control"
                                       placeholder="Nama kegiatan atau pelanggaran..."
                                       value="{{ old('kegiatan') }}" required>
                                @error('kegiatan')<div style="color:#e53e3e; font-size:11px; margin-top:4px;">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                       value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nilai Poin</label>
                                <input type="number" name="nilai" class="form-control"
                                       placeholder="Contoh: 10" min="1"
                                       value="{{ old('nilai') }}" required>
                                @error('nilai')<div style="color:#e53e3e; font-size:11px; margin-top:4px;">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nama Pengasuh</label>
                                <input type="text" name="pengasuh" class="form-control"
                                       value="{{ Auth::user()->name }}" readonly style="background-color: #f3f4f6; color: #4b5563; cursor: not-allowed;">
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
// Pilih mahasiswa
function selectMahasiswa(npm, label) {
    window.location = '{{ route('poin.index') }}?npm=' + npm;
}

function filterMahasiswaList() {
    const q = document.getElementById('mhsSearchInput').value.toLowerCase();
    const dd = document.getElementById('mhsDropdown');
    dd.style.display = 'block';
    let found = 0;
    document.querySelectorAll('.mhs-option').forEach(function(el) {
        const match = (el.dataset.search || '').includes(q);
        el.style.display = match ? 'flex' : 'none';
        if (match) found++;
    });
}

// Kategori toggle
function setKategori(val) {
    document.getElementById('kategoriInput').value = val;
    document.getElementById('btnPrestasi').className   = 'kategori-btn' + (val === 'prestasi'   ? ' prestasi-active'   : '');
    document.getElementById('btnPelanggaran').className = 'kategori-btn' + (val === 'pelanggaran' ? ' pelanggaran-active' : '');
}

// Hapus poin modal
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
</script>
</x-app-layout>
