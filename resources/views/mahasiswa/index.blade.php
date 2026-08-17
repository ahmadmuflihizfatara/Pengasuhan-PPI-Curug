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
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

/* Header */
.page-header {
    background: linear-gradient(135deg, #5a67d8 0%, #9f7aea 100%);
    border-radius: 18px; padding: 32px 36px;
    color: white; margin-bottom: 28px;
    position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:220px; height:220px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:60px; bottom:-80px; width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:24px; font-weight:700; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.85; font-size:14px; position:relative; z-index:1; }

/* Stats bar */
.stats-row { display:grid; grid-template-columns:repeat(5,1fr); gap:12px; margin-bottom:12px; }
.stat-card {
    background:white; border-radius:14px; padding:14px 12px;
    text-align:center; box-shadow:0 1px 6px rgba(0,0,0,.05);
    cursor:pointer; border:2px solid transparent; transition:all .2s;
}
.stat-card:hover { transform:translateY(-2px); box-shadow:0 4px 14px rgba(0,0,0,.1); }
.stat-card.active-tab { border-color:#5a67d8; }
.stat-card .count { font-size:19px; font-weight:700; color:#333; }
.stat-card .label { font-size:11px; color:#555; margin-top:2px; font-weight:700; }
.stat-card .sub   { font-size:9px; color:#aab; margin-top:1px; font-weight:500; }

/* Search */
.search-bar {
    display:flex; align-items:center;
    background:white; border-radius:12px;
    padding:10px 16px; margin:18px 0;
    box-shadow:0 1px 6px rgba(0,0,0,.05); gap:10px;
}
.search-bar i { color:#aab; }
.search-bar input { border:none; outline:none; width:100%; font-size:14px; font-family:'Inter',sans-serif; color:#333; background:transparent; }

/* Filter rows */
.filter-row { display:flex; gap:8px; margin-bottom:12px; flex-wrap:wrap; align-items:center; }
.filter-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; margin-right:4px; min-width:52px; }
.chip {
    padding:7px 15px; border-radius:50px; font-size:12px;
    font-weight:600; cursor:pointer; border:2px solid #e2e5ee;
    background:white; color:#666; transition:all .15s;
}
.chip:hover { border-color:#5a67d8; color:#5a67d8; }
.chip.active { background:#5a67d8; color:white; border-color:#5a67d8; }

/* Table */
.table-container { background:white; border-radius:14px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.05); }
.table-head { padding:16px 20px; border-bottom:1px solid #edf0f7; display:flex; justify-content:space-between; align-items:center; }
.table-head h2 { font-size:15px; font-weight:700; color:#333; margin:0; }
.badge-count { background:#eef0ff; color:#5a67d8; font-size:12px; font-weight:700; padding:3px 10px; border-radius:50px; }

table { width:100%; border-collapse:collapse; }
thead tr { background:linear-gradient(135deg,#5a67d8,#9f7aea); }
th { padding:12px 14px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:white; }
td { padding:12px 14px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr { transition:background .1s; }
tbody tr:hover { background:#fafbff; }

.student-name   { font-weight:600; color:#222; }
.npm-badge      { font-family:monospace; font-size:12px; color:#777; }
.nickname-badge { background:#eef0ff; color:#5a67d8; padding:3px 10px; border-radius:50px; font-size:12px; font-weight:600; }
.tingkat-badge  { background:#f0fff4; color:#38a169; padding:3px 10px; border-radius:50px; font-size:12px; font-weight:700; }
.jk-badge       { font-size:11px; font-weight:700; padding:2px 8px; border-radius:50px; }
.jk-L { background:#ebf4ff; color:#3182ce; }
.jk-P { background:#fff0f6; color:#d53f8c; }

.btn-edit {
    background:linear-gradient(135deg,#5a67d8,#9f7aea);
    color:white; border:none; padding:6px 14px; border-radius:8px;
    font-size:12px; font-weight:600; cursor:pointer;
    text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:opacity .15s;
}
.btn-edit:hover { opacity:.85; color:white; }

.prodi-header-row { background:linear-gradient(135deg,#5a67d8,#9f7aea); }
.prodi-header-row td { color:white; font-weight:700; padding:10px 14px; font-size:13px; border-top:none; }
.jenjang-pill { background:rgba(255,255,255,.25); padding:2px 9px; border-radius:50px; font-size:11px; font-weight:700; margin-left:6px; }

.flash-success { background:#f0fff4; border:1px solid #c6f6d5; color:#276749; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:8px; }

.hidden { display:none; }

.empty-search { text-align:center; padding:40px; color:#aab; }
.empty-search i { font-size:32px; margin-bottom:10px; display:block; }
</style>

<div class="app-layout">

    {{-- ── SIDEBAR ── --}}
    <x-sidebar active="mahasiswa" />

    <!-- Main Content -->
    <div class="main-content">

        <!-- Header -->
        <div class="page-header">
            <h1><i class="fas fa-database" style="margin-right:10px;"></i>Database Mahasiswa</h1>
            <p>Data biodata dan akun seluruh mahasiswa berdasarkan program studi dan tingkat</p>
        </div>

        @if(session('success'))
        <div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @php
            $prodiList   = \App\Models\Mahasiswa::PRODI;
            $totalSemua  = $mahasiswaData->flatten(1)->count();
            $maxTingkat  = 4;
        @endphp

        {{-- Grafik jumlah taruna per tingkat per prodi --}}
        <x-prodi-tingkat-chart :chart-data="$chartData" />

        {{-- Stat cards per prodi --}}
        <div class="stats-row">
            <div class="stat-card active-tab" data-prodi="all" onclick="setProdi('all', this)">
                <div class="count">{{ $totalSemua }}</div>
                <div class="label">Semua Prodi</div>
                <div class="sub">D-4 &amp; D-3</div>
            </div>
            @foreach($prodiList as $kode => $info)
            <div class="stat-card" data-prodi="{{ $kode }}" onclick="setProdi('{{ $kode }}', this)">
                <div class="count">{{ ($mahasiswaData[$kode] ?? collect())->count() }}</div>
                <div class="label">{{ $kode }}</div>
                <div class="sub">{{ $info['jenjang'] }} · {{ $info['nama'] }}</div>
            </div>
            @endforeach
        </div>

        <!-- Search -->
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput"
                   placeholder="Cari nama, NPM, atau nickname..."
                   oninput="applyFilters()">
        </div>

        {{-- Filter prodi --}}
        <div class="filter-row">
            <span class="filter-label">Prodi</span>
            <div class="chip active" data-prodi="all" onclick="setProdi('all', null, this)">Semua</div>
            @foreach($prodiList as $kode => $info)
            <div class="chip" data-prodi="{{ $kode }}" onclick="setProdi('{{ $kode }}', null, this)">
                {{ $kode }}
            </div>
            @endforeach
        </div>

        {{-- Filter tingkat --}}
        <div class="filter-row">
            <span class="filter-label">Tingkat</span>
            <div class="chip active" data-tingkat="all" onclick="setTingkat('all', this)">Semua</div>
            @for($t = 1; $t <= $maxTingkat; $t++)
            <div class="chip" data-tingkat="{{ $t }}" onclick="setTingkat('{{ $t }}', this)">
                Tingkat {{ $t }}
            </div>
            @endfor
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-head">
                <h2 id="tableTitle">Semua Mahasiswa</h2>
                <span class="badge-count" id="tableCount">{{ $totalSemua }} mahasiswa</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NPM</th>
                        <th>Nama Lengkap</th>
                        <th>Nickname</th>
                        <th>L/P</th>
                        <th>Tingkat</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    @php $no = 1; @endphp
                    @foreach($mahasiswaData as $kode => $students)
                    @php $info = $prodiList[$kode] ?? ['nama' => $kode, 'jenjang' => '-']; @endphp
                    <tr class="prodi-header-row" data-prodi="{{ $kode }}">
                        <td colspan="9">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $kode }} &mdash; {{ $info['nama'] }}
                            <span class="jenjang-pill">{{ $info['jenjang'] }}</span>
                            <span class="jenjang-pill">{{ count($students) }} mahasiswa</span>
                        </td>
                    </tr>
                    @foreach($students as $student)
                    <tr class="student-row"
                        data-prodi="{{ $kode }}"
                        data-tingkat="{{ $student->tingkat }}"
                        data-search="{{ strtolower($student->nama) }} {{ strtolower($student->npm ?? '') }} {{ strtolower($student->nickname ?? '') }}">
                        <td style="color:#bbb; font-size:12px;">{{ $no++ }}</td>
                        <td><span class="npm-badge">{{ $student->npm ?? '-' }}</span></td>
                        <td class="student-name">{{ $student->nama }}</td>
                        <td><span class="nickname-badge">{{ $student->nickname ?? '-' }}</span></td>
                        <td>
                            @if($student->jenis_kelamin)
                            <span class="jk-badge jk-{{ $student->jenis_kelamin }}">{{ $student->jenis_kelamin }}</span>
                            @else
                            <span style="color:#ccc;">-</span>
                            @endif
                        </td>
                        <td><span class="tingkat-badge">{{ $student->tingkat }}</span></td>
                        <td style="font-size:12px; color:#555;">{{ $student->user->email ?? '-' }}</td>
                        <td style="font-family:monospace; color:#5a67d8; font-size:13px; font-weight:600;">{{ $student->user->username ?? '-' }}</td>
                        <td>
                            <a href="{{ route('mahasiswa.edit', $student) }}" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
            <div id="emptySearch" class="empty-search hidden">
                <i class="fas fa-search"></i>
                Tidak ada mahasiswa yang cocok dengan filter
            </div>
        </div>

    </div>{{-- end main-content --}}
</div>{{-- end app-layout --}}

<script>
const PRODI_NAMA = @json(collect($prodiList)->map(fn($i) => $i['nama']));

let currentProdi   = 'all';
let currentTingkat = 'all';

function setProdi(kode, statCard, chipEl) {
    currentProdi = kode;

    document.querySelectorAll('.stat-card').forEach(c =>
        c.classList.toggle('active-tab', c.dataset.prodi === kode));
    document.querySelectorAll('.chip[data-prodi]').forEach(c =>
        c.classList.toggle('active', c.dataset.prodi === kode));

    applyFilters();
}

function setTingkat(tingkat, chipEl) {
    currentTingkat = tingkat;

    document.querySelectorAll('.chip[data-tingkat]').forEach(c =>
        c.classList.toggle('active', c.dataset.tingkat === tingkat));

    applyFilters();
}

function applyFilters() {
    const search  = document.getElementById('searchInput').value.toLowerCase().trim();
    const rows    = document.querySelectorAll('.student-row');
    const headers = document.querySelectorAll('.prodi-header-row');
    let visible   = 0;
    const terlihatPerProdi = {};

    rows.forEach(row => {
        const cocokProdi   = currentProdi === 'all' || row.dataset.prodi === currentProdi;
        const cocokTingkat = currentTingkat === 'all' || row.dataset.tingkat === currentTingkat;
        const cocokSearch  = !search || (row.dataset.search || '').includes(search);
        const tampil = cocokProdi && cocokTingkat && cocokSearch;

        row.classList.toggle('hidden', !tampil);
        if (tampil) {
            visible++;
            terlihatPerProdi[row.dataset.prodi] = (terlihatPerProdi[row.dataset.prodi] || 0) + 1;
        }
    });

    // Header prodi hanya tampil bila ada barisnya yang lolos filter
    headers.forEach(h => {
        h.classList.toggle('hidden', !terlihatPerProdi[h.dataset.prodi]);
    });

    document.getElementById('tableCount').textContent = visible + ' mahasiswa';
    document.getElementById('emptySearch').classList.toggle('hidden', visible > 0);

    // Judul tabel mengikuti filter aktif
    let judul = currentProdi === 'all'
        ? 'Semua Mahasiswa'
        : currentProdi + ' — ' + (PRODI_NAMA[currentProdi] || currentProdi);
    if (currentTingkat !== 'all') judul += ' · Tingkat ' + currentTingkat;
    document.getElementById('tableTitle').textContent = judul;
}
</script>
</x-app-layout>
