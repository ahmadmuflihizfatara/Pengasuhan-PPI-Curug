<x-app-layout>
<x-administration-table-style />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }

.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

.page-header {
    background: linear-gradient(135deg, #e34948 0%, #eb6834 100%);
    border-radius: 18px; padding: 28px 32px; color: white; margin-bottom: 22px;
    position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:220px; height:220px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:70px; bottom:-80px; width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.88; font-size:13px; position:relative; z-index:1; }

.flash-success { background:#f0fff4; border:1px solid #c6f6d5; color:#276749; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:8px; }
.flash-error { background:#fff5f5; border:1px solid #feb2b2; color:#c53030; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; gap:8px; align-items:flex-start; }
.flash-error ul { margin:0; padding-left:16px; }

/* Form tambah */
.form-card { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; margin-bottom:22px; }
.form-head { padding:18px 22px; border-bottom:1px solid #f0f2f7; }
.form-head h2 { font-size:15px; font-weight:700; color:#333; margin:0 0 3px; display:flex; align-items:center; gap:8px; }
.form-head p { font-size:12px; color:#98a0b3; margin:0; }
.form-body { padding:18px 22px 22px; }

.form-grid { display:grid; grid-template-columns:1.6fr 1fr 1fr; gap:14px; margin-bottom:14px; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group.full { grid-column:1/-1; }
label { font-size:11.5px; font-weight:700; color:#555; }
.form-control {
    padding:11px 13px; border:2px solid #e8ebf5; border-radius:10px;
    font-size:13px; font-family:'Inter',sans-serif; color:#333; outline:none; background:#f9fafb; width:100%;
}
.form-control:focus { border-color:#e34948; background:white; }
.form-control.cocok { border-color:#9ae6b4; background:#f6fffb; }
.form-control.gagal { border-color:#feb2b2; background:#fff8f8; }
.form-control[readonly] { background:#f3f4f8; color:#777; }
textarea.form-control { resize:vertical; min-height:70px; }
.hint { font-size:11px; color:#a8afbd; margin-top:2px; }

.info-taruna { display:flex; gap:10px; align-items:center; margin-top:2px; }
.info-taruna .pill { background:rgba(18,40,58,0.06); color:#5a67d8; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:700; }
.info-taruna .pill-tingkat { background:#f0fff4; color:#38a169; }

.btn-simpan {
    background:linear-gradient(135deg,#e34948,#eb6834); color:white; border:none;
    padding:12px 26px; border-radius:11px; font-size:13.5px; font-weight:700;
    cursor:pointer; display:inline-flex; align-items:center; gap:8px; font-family:'Inter',sans-serif; transition:opacity .15s;
}
.btn-simpan:hover { opacity:.9; }

/* Section */
.section-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; margin:0 0 12px; display:flex; align-items:center; gap:7px; }
.card { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; margin-bottom:22px; }

table { width:100%; border-collapse:collapse; }
thead tr { background:linear-gradient(135deg,#e34948,#eb6834); }
th { padding:12px 16px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:white; }
td { padding:12px 16px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; vertical-align:middle; }
tbody tr:hover { background:#f9fafb; }

.k-avatar { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#e34948,#eb6834); color:white; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; flex-shrink:0; }
.k-name { font-weight:700; color:#2b2b33; }
.npm-badge { font-family:monospace; font-size:12px; color:#777; }
.pill { background:rgba(18,40,58,0.06); color:#5a67d8; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:700; }
.pill-tingkat { background:#f0fff4; color:#38a169; }
.status-badge { font-size:10.5px; font-weight:800; padding:4px 12px; border-radius:20px; white-space:nowrap; }
.status-badge.aktif { background:#fff0f0; color:#c53030; }
.status-badge.selesai { background:#f0fff4; color:#276749; }
.keterangan-cell { max-width:220px; color:#777; }
.btn-hapus { background:#fff0f0; color:#e53e3e; border:none; padding:6px 12px; border-radius:8px; font-size:11px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:5px; }
.btn-hapus:hover { background:#ffe0e0; }

.empty { text-align:center; padding:44px 20px; }
.empty i { font-size:36px; color:#e2e5ee; display:block; margin-bottom:10px; }
.empty p { margin:0; font-size:13.5px; font-weight:600; color:#98a0b3; }

.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:18px; padding:28px 26px; max-width:360px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,.2); text-align:center; }
.modal-box h3 { margin:0 0 8px; font-size:16px; font-weight:800; color:#333; }
.modal-box p { margin:0 0 20px; font-size:13px; color:#888; }
.modal-actions { display:flex; gap:10px; justify-content:center; }
.modal-cancel { background:#f4f5f9; color:#666; border:none; padding:10px 22px; border-radius:20px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-confirm { background:linear-gradient(135deg,#e34948,#c53030); color:white; border:none; padding:10px 22px; border-radius:20px; font-size:13px; font-weight:700; cursor:pointer; }
</style>

<div class="app-layout">
    <x-sidebar active="konsinyir" />

    <div class="main-content">

        <div class="page-header">
            <h1><i class="fas fa-user-lock" style="margin-right:10px;"></i>Konsinyir</h1>
            <p>Data taruna yang menjalani konsinyir — dicocokkan langsung ke database mahasiswa</p>
        </div>

        @if(session('success'))
        <div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="flash-error">
            <i class="fas fa-exclamation-circle" style="margin-top:2px;"></i>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        {{-- Form tambah konsinyir --}}
        <div class="form-card">
            <div class="form-head">
                <h2><i class="fas fa-user-plus" style="color:#e34948;"></i> Tambah Konsinyir</h2>
                <p>Ketik nama taruna — prodi & tingkat terisi otomatis dari database mahasiswa.</p>
            </div>
            <div class="form-body">
                <form method="POST" action="{{ route('konsinyir.store') }}" id="konsinyirForm">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="namaTaruna">Nama Taruna</label>
                            <input type="text" id="namaTaruna" list="daftarTaruna" class="form-control"
                                   placeholder="Ketik nama taruna..." value="{{ old('nama') }}" autocomplete="off" required>
                            <input type="hidden" name="mahasiswa_id" id="mahasiswaId" value="{{ old('mahasiswa_id') }}">
                            <div class="info-taruna" id="infoTaruna" style="display:none;">
                                <span class="pill" id="infoProdi"></span>
                                <span class="pill pill-tingkat" id="infoTingkat"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggalMulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggalMulai" class="form-control"
                                   value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="lamaHari">Lama Konsinyir (hari)</label>
                            <input type="number" name="lama_hari" id="lamaHari" class="form-control"
                                   min="1" max="365" placeholder="Contoh: 3" value="{{ old('lama_hari') }}" required>
                        </div>
                        <div class="form-group full">
                            <label for="keterangan">Keterangan Konsinyir</label>
                            <textarea name="keterangan" id="keterangan" class="form-control"
                                      placeholder="Alasan/keterangan konsinyir...">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>

                    <datalist id="daftarTaruna">
                        @foreach($daftarTaruna as $t)
                        <option value="{{ $t->nama }}">{{ $t->npm }} · {{ $t->prodi }} {{ $t->tingkat }}</option>
                        @endforeach
                    </datalist>

                    <button type="submit" class="btn-simpan"><i class="fas fa-save"></i> Simpan Konsinyir</button>
                </form>
            </div>
        </div>

        {{-- Sedang konsinyir --}}
        <div class="section-title"><i class="fas fa-user-clock" style="color:#e34948;"></i> Sedang Konsinyir ({{ $aktif->count() }})</div>
        <div class="card admin-list-table">
            @if($aktif->isEmpty())
            <div class="empty"><i class="fas fa-circle-check"></i><p>Tidak ada taruna yang sedang konsinyir.</p></div>
            @else
            @include('konsinyir._tabel', ['daftar' => $aktif])
            @endif
        </div>

        {{-- Riwayat --}}
        <div class="section-title"><i class="fas fa-clock-rotate-left" style="color:#98a0b3;"></i> Riwayat Konsinyir ({{ $riwayat->count() }})</div>
        <div class="card admin-list-table">
            @if($riwayat->isEmpty())
            <div class="empty"><i class="fas fa-inbox"></i><p>Belum ada riwayat konsinyir.</p></div>
            @else
            @include('konsinyir._tabel', ['daftar' => $riwayat])
            @endif
        </div>

    </div>
</div>

<div class="modal-overlay" id="hapusModal">
    <div class="modal-box">
        <h3><i class="fas fa-trash-alt" style="color:#e34948;"></i></h3>
        <p id="hapusModalNama"></p>
        <div class="modal-actions">
            <button type="button" class="modal-cancel" onclick="tutupHapusModal()">Batal</button>
            <button type="button" class="modal-confirm" onclick="submitHapus()">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
const TARUNA = @json($daftarTaruna->mapWithKeys(fn($t) => [strtolower($t->nama) => ['id' => $t->id, 'prodi' => $t->prodi, 'tingkat' => $t->tingkat]]));

const namaEl = document.getElementById('namaTaruna');
function cocokkanTaruna() {
    const idEl   = document.getElementById('mahasiswaId');
    const infoEl = document.getElementById('infoTaruna');
    const cocok  = TARUNA[namaEl.value.trim().toLowerCase()];

    if (cocok) {
        idEl.value = cocok.id;
        document.getElementById('infoProdi').textContent = cocok.prodi || '-';
        document.getElementById('infoTingkat').textContent = 'Tingkat ' + (cocok.tingkat || '-');
        infoEl.style.display = 'flex';
        namaEl.classList.add('cocok');
        namaEl.classList.remove('gagal');
    } else {
        idEl.value = '';
        infoEl.style.display = 'none';
        namaEl.classList.remove('cocok');
        namaEl.classList.toggle('gagal', namaEl.value.trim() !== '');
    }
}
namaEl.addEventListener('input', cocokkanTaruna);
namaEl.addEventListener('change', cocokkanTaruna);
if (namaEl.value.trim()) cocokkanTaruna();

document.getElementById('konsinyirForm').addEventListener('submit', function(e) {
    if (!document.getElementById('mahasiswaId').value) {
        e.preventDefault();
        namaEl.classList.add('gagal');
        namaEl.focus();
        alert('Pilih nama taruna yang cocok dari daftar (ketik lalu pilih dari saran).');
    }
});

let hapusFormId = null;
function bukaHapusModal(formId, nama) {
    hapusFormId = formId;
    document.getElementById('hapusModalNama').textContent = 'Hapus data konsinyir ' + nama + '?';
    document.getElementById('hapusModal').classList.add('open');
}
function tutupHapusModal() {
    document.getElementById('hapusModal').classList.remove('open');
    hapusFormId = null;
}
function submitHapus() {
    if (hapusFormId) document.getElementById(hapusFormId).submit();
}
document.getElementById('hapusModal').addEventListener('click', function(e) {
    if (e.target === this) tutupHapusModal();
});
</script>
</x-app-layout>
