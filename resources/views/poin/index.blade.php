<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

.poin-layout {
    display: flex;
    min-height: calc(100vh - 100px);
    margin-top: -40px;
    margin-left: -25px;
    margin-right: -25px;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 240px;
    background: #fff;
    border-right: 1px solid #edf0f7;
    padding: 28px 16px;
    min-height: 100%;
    flex-shrink: 0;
}
.sidebar-logo { font-size:18px; font-weight:700; color:#5a67d8; text-decoration:none; display:flex; align-items:center; gap:8px; margin-bottom:32px; }
.sidebar-section-title { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#aab; margin-bottom:10px; padding-left:8px; }
.sidebar-nav { list-style:none; padding:0; margin:0 0 24px 0; }
.sidebar-nav li { margin-bottom:2px; }
.sidebar-nav a { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:500; color:#555; transition:all .15s; }
.sidebar-nav a:hover { background:#f0f0fb; color:#5a67d8; }
.sidebar-nav a.active { background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; }
.sidebar-divider { border:none; border-top:1px solid #edf0f7; margin:12px 0 20px 0; }
.logout-link { color:#e05252 !important; }

/* ===== MAIN ===== */
.main-content { flex:1; padding:28px 30px; min-width:0; }

/* Header */
.page-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 18px;
    padding: 28px 36px;
    color: white;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:200px; height:200px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after { content:''; position:absolute; right:60px; bottom:-80px; width:160px; height:160px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header-inner { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; }
.page-header h1 { margin:0 0 4px 0; font-size:22px; font-weight:800; }
.page-header p { margin:0; opacity:.85; font-size:13px; }
.poin-badge-header {
    background: rgba(255,255,255,.2);
    border-radius: 14px;
    padding: 10px 18px;
    text-align: center;
    backdrop-filter: blur(4px);
}
.poin-badge-header .num { font-size:26px; font-weight:800; line-height:1; }
.poin-badge-header .lbl { font-size:11px; opacity:.85; }

/* 2-column layout */
.two-col { display: grid; grid-template-columns: 380px 1fr; gap: 22px; align-items: start; }

/* Card */
.card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    overflow: visible;
}
/* tabel di dalam riwayat tetap perlu clip agar header radius tidak bocor */
.table-wrapper { border-radius: 16px; overflow: hidden; }
.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f0f2f7;
    display: flex;
    align-items: center;
    gap: 10px;
}
.card-header h3 { margin:0; font-size:14px; font-weight:700; color:#333; }
.card-header .icon {
    width: 32px; height:32px;
    border-radius: 8px;
    display: flex; align-items:center; justify-content:center;
    font-size: 14px;
    color: white;
}
.icon-pink { background: linear-gradient(135deg, #f093fb, #f5576c); }
.icon-blue { background: linear-gradient(135deg, #5a67d8, #9f7aea); }
.icon-green { background: linear-gradient(135deg, #38a169, #48bb78); }
.card-body { padding: 20px; }

/* Student Selector */
.student-search-wrap { position: relative; margin-bottom: 14px; }
.student-search-input {
    width: 100%;
    padding: 11px 14px 11px 38px;
    border: 2px solid #e8ebf5;
    border-radius: 10px;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    outline: none;
    transition: border .15s;
    background: #fafbff;
}
.student-search-input:focus { border-color: #5a67d8; }
.search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aab; font-size: 13px; }
.student-dropdown {
    max-height: 260px;
    overflow-y: auto;
    border: 2px solid #e8ebf5;
    border-radius: 10px;
    background: white;
    display: none;
    position: absolute;
    width: 100%;
    z-index: 9999;
    box-shadow: 0 12px 32px rgba(0,0,0,.15);
    top: calc(100% + 6px);
    left: 0;
}
.student-dropdown.open { display: block; }
.dropdown-group-label {
    padding: 6px 12px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    color: #aab;
    background: #f8f9ff;
    letter-spacing: .05em;
    border-top: 1px solid #f0f2f7;
}
.dropdown-item {
    padding: 10px 14px;
    cursor: pointer;
    font-size: 13px;
    transition: background .1s;
    display: flex;
    align-items: center;
    gap: 10px;
}
.dropdown-item:hover { background: #f0f1ff; }
.dropdown-item .ava {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5a67d8, #9f7aea);
    color: white;
    font-size: 11px;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.dropdown-item .info { flex: 1; min-width: 0; }
.dropdown-item .info strong { display: block; color: #222; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dropdown-item .info span { font-size: 11px; color: #888; }

/* Selected student card */
.selected-student-card {
    background: linear-gradient(135deg, #5a67d8 0%, #9f7aea 100%);
    border-radius: 12px;
    padding: 14px 16px;
    color: white;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
}
.selected-ava {
    width: 44px; height: 44px;
    background: rgba(255,255,255,.25);
    border-radius: 50%;
    font-size: 16px;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.selected-info strong { display: block; font-size: 15px; font-weight: 700; }
.selected-info span { font-size: 12px; opacity: .85; }
.change-btn {
    margin-left: auto;
    background: rgba(255,255,255,.2);
    border: none;
    color: white;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    flex-shrink: 0;
}
.change-btn:hover { background: rgba(255,255,255,.35); }

/* Kategori Toggle */
.kategori-toggle { display: flex; gap: 10px; margin-bottom: 18px; }
.kat-btn {
    flex: 1;
    padding: 12px 8px;
    border-radius: 12px;
    border: 2px solid #e8ebf5;
    cursor: pointer;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    transition: all .2s;
    background: #fafbff;
    color: #888;
    user-select: none;
}
.kat-btn i { display: block; font-size: 20px; margin-bottom: 4px; }
.kat-btn.prestasi-active { border-color: #38a169; background: #e6f9f0; color: #38a169; }
.kat-btn.pelanggaran-active { border-color: #e53e3e; background: #fff5f5; color: #e53e3e; }

/* Form */
.form-group { margin-bottom: 14px; }
label { font-size: 12px; font-weight: 600; color: #555; display: block; margin-bottom: 5px; }
.form-control {
    width: 100%;
    padding: 10px 13px;
    border: 2px solid #e8ebf5;
    border-radius: 10px;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    color: #333;
    background: #fafbff;
    outline: none;
    transition: border .15s;
}
.form-control:focus { border-color: #5a67d8; background: white; }
textarea.form-control { resize: vertical; min-height: 72px; }

.nilai-wrap { display: flex; align-items: center; border: 2px solid #e8ebf5; border-radius: 10px; overflow: hidden; background: #fafbff; transition: border .15s; }
.nilai-wrap:focus-within { border-color: #5a67d8; background: white; }
.nilai-prefix {
    padding: 10px 12px;
    font-size: 15px;
    font-weight: 700;
    min-width: 40px;
    text-align: center;
    transition: all .2s;
}
.nilai-prefix.positif { color: #38a169; background: #e6f9f0; }
.nilai-prefix.negatif { color: #e53e3e; background: #fff5f5; }
.nilai-input { border: none; background: transparent; font-size: 14px; font-family: 'Inter', sans-serif; color: #333; outline: none; padding: 10px 10px; width: 100%; }

.btn-submit {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: opacity .15s, transform .1s;
    margin-top: 4px;
    color: white;
}
.btn-submit:hover { opacity: .88; transform: translateY(-1px); }
.btn-submit.prestasi { background: linear-gradient(135deg, #38a169, #48bb78); }
.btn-submit.pelanggaran { background: linear-gradient(135deg, #e53e3e, #fc8181); }

/* Riwayat Table */
.riwayat-empty { text-align:center; padding:40px; color:#bbb; }
.riwayat-empty i { font-size:32px; display:block; margin-bottom:8px; }

table { width:100%; border-collapse:collapse; }
thead tr { background:#f8f9ff; }
th { padding:11px 14px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; }
td { padding:12px 14px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr { transition:background .1s; }
tbody tr:hover { background:#fafbff; }

.badge-prestasi {
    display: inline-flex; align-items: center; gap: 4px;
    background: #e6f9f0; color: #38a169;
    padding: 3px 10px; border-radius: 50px;
    font-size: 11px; font-weight: 700;
}
.badge-pelanggaran {
    display: inline-flex; align-items: center; gap: 4px;
    background: #fff5f5; color: #e53e3e;
    padding: 3px 10px; border-radius: 50px;
    font-size: 11px; font-weight: 700;
}
.poin-positif { color: #38a169; font-weight: 700; font-size: 14px; }
.poin-negatif { color: #e53e3e; font-weight: 700; font-size: 14px; }

.delete-btn {
    background: none;
    border: 1px solid #f5c6c6;
    color: #e05252;
    padding: 4px 10px;
    border-radius: 7px;
    font-size: 11px;
    cursor: pointer;
    transition: all .15s;
}
.delete-btn:hover { background: #fff5f5; }

/* Modal konfirmasi */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:99999; align-items:center; justify-content:center; }
.modal-overlay.open { display:flex; }
.modal-box { background:white; border-radius:20px; padding:30px 28px; max-width:380px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,.2); text-align:center; animation:modalIn .2s ease; }
@keyframes modalIn { from{transform:scale(.93);opacity:0} to{transform:scale(1);opacity:1} }
.modal-icon { width:54px; height:54px; border-radius:50%; background:#fff5f5; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }
.modal-icon i { font-size:22px; color:#e53e3e; }
.modal-box h3 { margin:0 0 8px; font-size:17px; font-weight:800; color:#333; }
.modal-box p { margin:0 0 22px; font-size:13px; color:#888; line-height:1.5; }
.modal-actions { display:flex; gap:10px; justify-content:center; }
.modal-cancel { background:#f4f5f9; color:#666; border:none; padding:10px 26px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; }
.modal-cancel:hover { background:#e8e9f0; }
.modal-confirm { background:linear-gradient(135deg,#fc5c7d,#e53e3e); color:white; border:none; padding:10px 26px; border-radius:25px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 4px 15px rgba(229,62,62,.35); }
.modal-confirm:hover { opacity:.9; }

/* Total poin card */
.total-poin-card {
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}
.total-poin-card.positif { background: linear-gradient(135deg, #e6f9f0, #c6f6d5); }
.total-poin-card.negatif { background: linear-gradient(135deg, #fff5f5, #fed7d7); }
.total-poin-card.netral { background: #f0f2f7; }
.total-label { font-size: 12px; font-weight: 600; color: #666; }
.total-value { font-size: 28px; font-weight: 800; }
.total-value.positif { color: #38a169; }
.total-value.negatif { color: #e53e3e; }
.total-value.netral { color: #888; }

.alert { padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:16px; display:flex; gap:8px; align-items:center; }
.alert-success { background:#e6f9f0; border:1px solid #9ae6b4; color:#276749; }
.alert-danger { background:#fff5f5; border:1px solid #feb2b2; color:#9b2c2c; }

/* No student state */
.no-student {
    text-align: center;
    padding: 50px 20px;
    color: #bbb;
}
.no-student i { font-size: 40px; display:block; margin-bottom:12px; }
.no-student p { font-size: 14px; }
</style>

<div class="poin-layout">
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <i class="fas fa-graduation-cap"></i> Pengasuhan
        </a>
        <p class="sidebar-section-title">Menu</p>
        <ul class="sidebar-nav">
            <li><a href="{{ route('dashboard') }}"><i class="fas fa-th-large" style="width:16px;"></i> Dashboard</a></li>
            <li><a href="{{ route('surat.index') }}"><i class="fas fa-envelope-open-text" style="width:16px;"></i> Administrasi Surat</a></li>
            <li><a href="{{ route('acara.index') }}"><i class="fas fa-calendar-alt" style="width:16px;"></i> Acara</a></li>
            <li><a href="{{ route('poin.index') }}" class="active"><i class="fas fa-star" style="width:16px;"></i> POIN</a></li>
            @if(Auth::user()->canManageSystem())
            <li><a href="{{ route('mahasiswa.index') }}"><i class="fas fa-users" style="width:16px;"></i> Database Mahasiswa</a></li>
            @endif
        </ul>
        <hr class="sidebar-divider">
        <p class="sidebar-section-title">Pengaturan</p>
        <ul class="sidebar-nav">
            <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user-circle" style="width:16px;"></i> Profil Saya</a></li>
            @if(Auth::user()->canManageSystem())
            <li><a href="{{ route('users.index') }}"><i class="fas fa-user-shield" style="width:16px;"></i> Manajemen Akun</a></li>
            <li><a href="{{ route('setting.index') }}"><i class="fas fa-cog" style="width:16px;"></i> Setting</a></li>
            @endif
            <li>
                <a href="{{ route('logout') }}" class="logout-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt" style="width:16px;"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="page-header">
            <div class="page-header-inner">
                <div>
                    <h1><i class="fas fa-star"></i> POIN Pengasuhan</h1>
                    <p>Kelola poin pengasuhan mahasiswa &mdash; Prestasi &amp; Pelanggaran</p>
                </div>
                @if($selectedStudent)
                <div class="poin-badge-header">
                    <div class="num" style="color:{{ $totalPoin >= 0 ? '#fff' : '#fed7d7' }}">
                        {{ $totalPoin >= 0 ? '+' : '' }}{{ $totalPoin }}
                    </div>
                    <div class="lbl">Total Poin {{ $selectedStudent['nickname'] }}</div>
                </div>
                @endif
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        @if(Auth::user()->isTaruna())
        {{-- ===== TAMPILAN KHUSUS TARUNA: hanya riwayat, tanpa form ===== --}}
        @if(!$selectedStudent)
        <div class="card" style="padding:48px; text-align:center; color:#bbb;">
            <i class="fas fa-user-graduate" style="font-size:42px; margin-bottom:14px; display:block; color:#e8ebf5;"></i>
            <p style="font-size:14px; margin:0;">Data poin kamu tidak ditemukan.<br>Hubungi Pengasuh untuk verifikasi akun.</p>
        </div>
        @else
        {{-- Ringkasan Poin --}}
        <div class="card" style="margin-bottom:18px;">
            <div class="card-header">
                <div class="icon icon-green"><i class="fas fa-chart-bar"></i></div>
                <h3>Ringkasan Poin — {{ $selectedStudent['nama'] }}</h3>
                <span style="margin-left:auto; background:#eef0ff; color:#667eea; font-size:11px; font-weight:700; padding:3px 10px; border-radius:50px;">
                    Kelas {{ $selectedStudent['kelas'] }}
                </span>
            </div>
            <div class="card-body" style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                @php
                    $totalPrestasi    = $riwayat->where('kategori','prestasi')->sum('nilai');
                    $totalPelanggaran = $riwayat->where('kategori','pelanggaran')->sum('nilai');
                @endphp
                <div style="background:#e6f9f0; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:#38a169;">+{{ $totalPrestasi }}</div>
                    <div style="font-size:12px; color:#38a169; font-weight:600; margin-top:4px;"><i class="fas fa-trophy"></i> Prestasi</div>
                </div>
                <div style="background:#fff5f5; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:#e53e3e;">-{{ $totalPelanggaran }}</div>
                    <div style="font-size:12px; color:#e53e3e; font-weight:600; margin-top:4px;"><i class="fas fa-exclamation-triangle"></i> Pelanggaran</div>
                </div>
                <div style="background:{{ $totalPoin >= 0 ? '#e6f9f0' : '#fff5f5' }}; border-radius:12px; padding:18px; text-align:center;">
                    <div style="font-size:28px; font-weight:800; color:{{ $totalPoin >= 0 ? '#38a169' : '#e53e3e' }};">
                        {{ $totalPoin >= 0 ? '+' : '' }}{{ $totalPoin }}
                    </div>
                    <div style="font-size:12px; color:#888; font-weight:600; margin-top:4px;"><i class="fas fa-star"></i> Total</div>
                </div>
            </div>
        </div>
        {{-- Tabel Riwayat (read-only, tanpa tombol hapus) --}}
        <div class="card">
            <div class="card-header">
                <div class="icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);"><i class="fas fa-history"></i></div>
                <h3>Riwayat Poin Saya</h3>
                <span style="margin-left:auto; background:#fdf0ff; color:#c026d3; font-size:12px; font-weight:700; padding:3px 10px; border-radius:50px;">
                    {{ $riwayat->count() }} entri
                </span>
            </div>
            @if($riwayat->isEmpty())
            <div class="riwayat-empty">
                <i class="fas fa-inbox" style="color:#e8ebf5;"></i>
                <p>Belum ada data poin untukmu.</p>
            </div>
            @else
            <div class="table-wrapper" style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Kegiatan</th>
                            <th>Poin</th>
                            <th>Pengasuh</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $r)
                        <tr>
                            <td style="white-space:nowrap; font-size:12px; color:#888;">{{ $r->tanggal->format('d M Y') }}</td>
                            <td>
                                @if($r->kategori === 'prestasi')
                                <span class="badge-prestasi"><i class="fas fa-trophy"></i> Prestasi</span>
                                @else
                                <span class="badge-pelanggaran"><i class="fas fa-exclamation-triangle"></i> Pelanggaran</span>
                                @endif
                            </td>
                            <td style="max-width:180px; font-weight:500;">{{ $r->kegiatan }}</td>
                            <td>
                                @if($r->kategori === 'prestasi')
                                <span class="poin-positif">+{{ $r->nilai }}</span>
                                @else
                                <span class="poin-negatif">-{{ $r->nilai }}</span>
                                @endif
                            </td>
                            <td style="font-size:12px; color:#666;">{{ $r->pengasuh }}</td>
                            <td style="font-size:12px; color:#888;">{{ $r->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        @endif
        @else
        {{-- ===== TAMPILAN PENGASUH / PENYELENGGARA: form + riwayat lengkap ===== --}}
        <div class="two-col">
            <!-- LEFT: Pilih Mahasiswa + Form -->
            <div>
                <!-- Pilih Mahasiswa -->
                <div class="card" style="margin-bottom:18px;">
                    <div class="card-header">
                        <div class="icon icon-blue"><i class="fas fa-user-graduate"></i></div>
                        <h3>Pilih Mahasiswa</h3>
                    </div>
                    <div class="card-body">
                        @if($selectedStudent)
                            <div class="selected-student-card">
                                <div class="selected-ava">{{ strtoupper(substr($selectedStudent['nickname'],0,2)) }}</div>
                                <div class="selected-info">
                                    <strong>{{ $selectedStudent['nama'] }}</strong>
                                    <span>{{ $selectedStudent['npm'] }} &bull; Kelas {{ $selectedStudent['kelas'] }}</span>
                                </div>
                                <button class="change-btn" onclick="showSearch()"><i class="fas fa-exchange-alt"></i> Ganti</button>
                            </div>
                            <div id="searchWrap" style="display:none; position:relative;">
                        @else
                            <div id="searchWrap" style="position:relative;">
                        @endif
                                <div class="student-search-wrap">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" class="student-search-input" id="studentSearch"
                                           placeholder="Ketik nama atau NPM mahasiswa..."
                                           oninput="filterStudents()" onfocus="openDropdown()" onblur="closeDropdown()">
                                    <div class="student-dropdown" id="studentDropdown">
                                        @foreach($allMahasiswa as $kelas => $students)
                                        <div class="dropdown-group-label">{{ $kelas }}</div>
                                        @foreach($students as $s)
                                        <div class="dropdown-item"
                                             data-npm="{{ $s['npm'] }}"
                                             data-nama="{{ strtolower($s['nama']) }}"
                                             data-nick="{{ strtolower($s['nickname']) }}"
                                             onmousedown="selectStudent('{{ $s['npm'] }}')">
                                            <div class="ava">{{ strtoupper(substr($s['nickname'],0,2)) }}</div>
                                            <div class="info">
                                                <strong>{{ $s['nama'] }}</strong>
                                                <span>{{ $s['npm'] }} &bull; {{ $kelas }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @if(!$selectedStudent)
                        <p style="font-size:12px; color:#aab; text-align:center; margin:0;">Pilih mahasiswa untuk mulai mengelola poin</p>
                        @endif
                    </div>
                </div>

                <!-- Form Tambah Poin -->
                @if($selectedStudent)
                <div class="card">
                    <div class="card-header">
                        <div class="icon icon-pink"><i class="fas fa-plus-circle"></i></div>
                        <h3>Tambah / Kurangi Poin</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('poin.store') }}" id="poinForm">
                            @csrf
                            <input type="hidden" name="npm" value="{{ $selectedStudent['npm'] }}">
                            <input type="hidden" name="kategori" id="kategoriInput" value="{{ old('kategori', 'prestasi') }}">

                            <!-- Kategori Toggle -->
                            <div class="form-group">
                                <label>Kategori</label>
                                <div class="kategori-toggle">
                                    <div class="kat-btn" id="btnPrestasi" onclick="setKategori('prestasi')">
                                        <i class="fas fa-trophy"></i> Prestasi
                                    </div>
                                    <div class="kat-btn" id="btnPelanggaran" onclick="setKategori('pelanggaran')">
                                        <i class="fas fa-exclamation-triangle"></i> Pelanggaran
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Kegiatan</label>
                                <input type="text" name="kegiatan" class="form-control"
                                       placeholder="Nama kegiatan / event"
                                       value="{{ old('kegiatan') }}" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                       value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Nilai Poin</label>
                                <div class="nilai-wrap">
                                    <div class="nilai-prefix positif" id="nilaiPrefix">+</div>
                                    <input type="number" name="nilai" class="nilai-input" id="nilaiInput"
                                           placeholder="0" min="1" value="{{ old('nilai') }}" required>
                                    <span style="padding:10px 12px; color:#aab; font-size:12px; font-weight:600;">poin</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pengasuh</label>
                                <input type="text" name="pengasuh" class="form-control"
                                       placeholder="Nama pengasuh"
                                       value="{{ old('pengasuh', Auth::user()->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Keterangan <span style="color:#aab; font-weight:400;">(opsional)</span></label>
                                <textarea name="keterangan" class="form-control"
                                          placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                            </div>

                            <button type="submit" class="btn-submit prestasi" id="submitBtn">
                                <i class="fas fa-plus-circle"></i> <span id="submitText">Tambah Poin Prestasi</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="no-student">
                        <i class="fas fa-star" style="color:#e8ebf5;"></i>
                        <p>Pilih mahasiswa terlebih dahulu<br>untuk mengelola poin pengasuhan</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- RIGHT: Riwayat Poin -->
            <div>
                @if($selectedStudent)
                <!-- Total Poin Summary -->
                <div class="card" style="margin-bottom:18px;">
                    <div class="card-header">
                        <div class="icon icon-green"><i class="fas fa-chart-bar"></i></div>
                        <h3>Ringkasan Poin</h3>
                    </div>
                    <div class="card-body" style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                        @php
                            $totalPrestasi = $riwayat->where('kategori','prestasi')->sum('nilai');
                            $totalPelanggaran = $riwayat->where('kategori','pelanggaran')->sum('nilai');
                        @endphp
                        <div style="background:#e6f9f0; border-radius:12px; padding:14px; text-align:center;">
                            <div style="font-size:22px; font-weight:800; color:#38a169;">+{{ $totalPrestasi }}</div>
                            <div style="font-size:11px; color:#38a169; font-weight:600; margin-top:2px;"><i class="fas fa-trophy"></i> Prestasi</div>
                        </div>
                        <div style="background:#fff5f5; border-radius:12px; padding:14px; text-align:center;">
                            <div style="font-size:22px; font-weight:800; color:#e53e3e;">-{{ $totalPelanggaran }}</div>
                            <div style="font-size:11px; color:#e53e3e; font-weight:600; margin-top:2px;"><i class="fas fa-exclamation-triangle"></i> Pelanggaran</div>
                        </div>
                        <div style="background:{{ $totalPoin >= 0 ? '#e6f9f0' : '#fff5f5' }}; border-radius:12px; padding:14px; text-align:center;">
                            <div style="font-size:22px; font-weight:800; color:{{ $totalPoin >= 0 ? '#38a169' : '#e53e3e' }};">
                                {{ $totalPoin >= 0 ? '+' : '' }}{{ $totalPoin }}
                            </div>
                            <div style="font-size:11px; color:#888; font-weight:600; margin-top:2px;"><i class="fas fa-star"></i> Total</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Riwayat Table -->
                <div class="card">
                    <div class="card-header">
                        <div class="icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);"><i class="fas fa-history"></i></div>
                        <h3>Riwayat Poin</h3>
                        @if($selectedStudent)
                        <span style="margin-left:auto; background:#fdf0ff; color:#c026d3; font-size:12px; font-weight:700; padding:3px 10px; border-radius:50px;">
                            {{ $riwayat->count() }} entri
                        </span>
                        @endif
                    </div>

                    @if(!$selectedStudent)
                    <div class="riwayat-empty">
                        <i class="fas fa-history" style="color:#e8ebf5;"></i>
                        <p>Pilih mahasiswa untuk melihat riwayat poin</p>
                    </div>
                    @elseif($riwayat->isEmpty())
                    <div class="riwayat-empty">
                        <i class="fas fa-inbox" style="color:#e8ebf5;"></i>
                        <p>Belum ada data poin untuk <strong>{{ $selectedStudent['nama'] }}</strong></p>
                    </div>
                    @else
                    <div class="table-wrapper" style="overflow-x:auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Kegiatan</th>
                                    <th>Poin</th>
                                    <th>Pengasuh</th>
                                    <th>Keterangan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $r)
                                <tr>
                                    <td style="white-space:nowrap; font-size:12px; color:#888;">
                                        {{ $r->tanggal->format('d M Y') }}
                                    </td>
                                    <td>
                                        @if($r->kategori === 'prestasi')
                                        <span class="badge-prestasi"><i class="fas fa-trophy"></i> Prestasi</span>
                                        @else
                                        <span class="badge-pelanggaran"><i class="fas fa-exclamation-triangle"></i> Pelanggaran</span>
                                        @endif
                                    </td>
                                    <td style="max-width:160px; font-weight:500;">{{ $r->kegiatan }}</td>
                                    <td>
                                        @if($r->kategori === 'prestasi')
                                        <span class="poin-positif">+{{ $r->nilai }}</span>
                                        @else
                                        <span class="poin-negatif">-{{ $r->nilai }}</span>
                                        @endif
                                    </td>
                                    <td style="font-size:12px; color:#666;">{{ $r->pengasuh }}</td>
                                    <td style="font-size:12px; color:#888; max-width:140px;">{{ $r->keterangan ?? '-' }}</td>
                                    <td>
                                        {{-- button tanpa form di dalam td --}}
                                        <button type="button" class="delete-btn"
                                                onclick="showPoinDeleteModal('delete-poin-{{ $r->id }}', '{{ addslashes($r->kegiatan) }}')"
                                                title="Hapus entri ini">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Form DELETE di LUAR tabel --}}
                    @foreach($riwayat as $r)
                    <form id="delete-poin-{{ $r->id }}"
                          method="POST"
                          action="{{ route('poin.destroy', $r->id) }}"
                          style="display:none;">
                        @csrf @method('DELETE')
                    </form>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// === KATEGORI TOGGLE ===
let currentKategori = '{{ old("kategori", "prestasi") }}';
function setKategori(k) {
    currentKategori = k;
    document.getElementById('kategoriInput').value = k;
    const btnP = document.getElementById('btnPrestasi');
    const btnV = document.getElementById('btnPelanggaran');
    const prefix = document.getElementById('nilaiPrefix');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    if (k === 'prestasi') {
        btnP.className = 'kat-btn prestasi-active'; btnV.className = 'kat-btn';
        prefix.textContent = '+'; prefix.className = 'nilai-prefix positif';
        submitBtn.className = 'btn-submit prestasi';
        submitText.textContent = 'Tambah Poin Prestasi';
    } else {
        btnV.className = 'kat-btn pelanggaran-active'; btnP.className = 'kat-btn';
        prefix.textContent = '-'; prefix.className = 'nilai-prefix negatif';
        submitBtn.className = 'btn-submit pelanggaran';
        submitText.textContent = 'Kurangi Poin (Pelanggaran)';
    }
}
document.addEventListener('DOMContentLoaded', function() { setKategori(currentKategori); });
function openDropdown() { document.getElementById('studentDropdown').classList.add('open'); }
function closeDropdown() { setTimeout(() => document.getElementById('studentDropdown').classList.remove('open'), 200); }
function filterStudents() {
    const q = document.getElementById('studentSearch').value.toLowerCase();
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.style.display = (item.dataset.nama||'').includes(q)||(item.dataset.nick||'').includes(q)||(item.dataset.npm||'').includes(q) ? '' : 'none';
    });
    document.querySelectorAll('.dropdown-group-label').forEach(g => {
        let next = g.nextElementSibling, has = false;
        while (next && !next.classList.contains('dropdown-group-label')) { if (next.style.display!=='none') has=true; next=next.nextElementSibling; }
        g.style.display = has ? '' : 'none';
    });
    openDropdown();
}
function selectStudent(npm) { window.location.href='{{ route("poin.index") }}?npm='+npm; }
function showSearch() { document.getElementById('searchWrap').style.display='block'; setTimeout(()=>document.getElementById('studentSearch').focus(),50); }
</script>

{{-- Modal Konfirmasi Hapus Poin --}}
<div class="modal-overlay" id="poinDeleteModal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3>Hapus Entri Poin?</h3>
        <p id="poinModalName" style="font-weight:600; color:#333; margin-bottom:6px;"></p>
        <p>Entri poin ini akan dihapus secara permanen.</p>
        <div class="modal-actions">
            <button class="modal-cancel" onclick="closePoinDeleteModal()"><i class="fas fa-times"></i> Batal</button>
            <button class="modal-confirm" onclick="submitPoinDeleteForm()"><i class="fas fa-trash"></i> Ya, Hapus</button>
        </div>
    </div>
</div>
<script>
let poinTargetFormId = null;
function showPoinDeleteModal(formId, kegiatan) {
    poinTargetFormId = formId;
    document.getElementById('poinModalName').textContent = kegiatan;
    document.getElementById('poinDeleteModal').classList.add('open');
}
function closePoinDeleteModal() {
    document.getElementById('poinDeleteModal').classList.remove('open');
    poinTargetFormId = null;
}
function submitPoinDeleteForm() {
    if (poinTargetFormId) document.getElementById(poinTargetFormId).submit();
}
document.getElementById('poinDeleteModal').addEventListener('click', function(e) { if (e.target===this) closePoinDeleteModal(); });
document.addEventListener('keydown', function(e) { if (e.key==='Escape') closePoinDeleteModal(); });
</script>
        @endif
</x-app-layout>
