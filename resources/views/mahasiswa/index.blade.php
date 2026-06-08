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

/* Stats bar — dihitung langsung dari $mahasiswaData, bukan $stats */
.stats-row { display:grid; grid-template-columns:repeat(6,1fr); gap:12px; margin-bottom:24px; }
.stat-card {
    background:white; border-radius:14px; padding:16px 12px;
    text-align:center; box-shadow:0 1px 6px rgba(0,0,0,.05);
    cursor:pointer; border:2px solid transparent; transition:all .2s;
}
.stat-card:hover { transform:translateY(-2px); box-shadow:0 4px 14px rgba(0,0,0,.1); }
.stat-card.active-tab { border-color:#5a67d8; }
.stat-card .count { font-size:20px; font-weight:700; color:#333; }
.stat-card .label { font-size:10px; color:#888; margin-top:2px; font-weight:500; }

/* Search */
.search-bar {
    display:flex; align-items:center;
    background:white; border-radius:12px;
    padding:10px 16px; margin-bottom:18px;
    box-shadow:0 1px 6px rgba(0,0,0,.05); gap:10px;
}
.search-bar i { color:#aab; }
.search-bar input { border:none; outline:none; width:100%; font-size:14px; font-family:'Inter',sans-serif; color:#333; background:transparent; }

/* Class tabs */
.class-tabs { display:flex; gap:8px; margin-bottom:18px; flex-wrap:wrap; }
.class-tab {
    padding:7px 16px; border-radius:50px; font-size:12px;
    font-weight:600; cursor:pointer; border:2px solid #e2e5ee;
    background:white; color:#666; transition:all .15s;
}
.class-tab:hover { border-color:#5a67d8; color:#5a67d8; }
.class-tab.active { background:#5a67d8; color:white; border-color:#5a67d8; }

/* Table */
.table-container { background:white; border-radius:14px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.05); }
.table-head { padding:16px 20px; border-bottom:1px solid #edf0f7; display:flex; justify-content:space-between; align-items:center; }
.table-head h2 { font-size:15px; font-weight:700; color:#333; margin:0; }
.badge-count { background:#eef0ff; color:#5a67d8; font-size:12px; font-weight:700; padding:3px 10px; border-radius:50px; }

table { width:100%; border-collapse:collapse; }
thead tr { background:#f8f9ff; }
th { padding:12px 14px; text-align:left; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#8a93b0; }
td { padding:12px 14px; font-size:13px; color:#444; border-top:1px solid #f0f2f7; }
tbody tr { transition:background .1s; }
tbody tr:hover { background:#fafbff; }

.student-name  { font-weight:600; color:#222; }
.npm-badge     { font-family:monospace; font-size:12px; color:#777; }
.nickname-badge { background:#eef0ff; color:#5a67d8; padding:3px 10px; border-radius:50px; font-size:12px; font-weight:600; }

.btn-edit {
    background:linear-gradient(135deg,#5a67d8,#9f7aea);
    color:white; border:none; padding:6px 14px; border-radius:8px;
    font-size:12px; font-weight:600; cursor:pointer;
    text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:opacity .15s;
}
.btn-edit:hover { opacity:.85; color:white; }

.class-header-row { background:linear-gradient(135deg,#5a67d8,#9f7aea); }
.class-header-row td { color:white; font-weight:700; padding:10px 14px; font-size:13px; border-top:none; }

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
            <p>Data biodata dan akun seluruh mahasiswa berdasarkan kelas</p>
        </div>

        {{-- Stats — dihitung langsung, tidak butuh variabel $stats dari controller --}}
        @php $totalSemua = array_sum(array_map('count', $mahasiswaData)); @endphp
        <div class="stats-row">
            <div class="stat-card active-tab" onclick="filterClass('all', this)">
                <div class="count">{{ $totalSemua }}</div>
                <div class="label">Semua Kelas</div>
            </div>
            @foreach($mahasiswaData as $kelas => $students)
            <div class="stat-card" onclick="filterClass('{{ str_replace([' ', '-'], '_', $kelas) }}', this)">
                <div class="count">{{ count($students) }}</div>
                <div class="label">{{ $kelas }}</div>
            </div>
            @endforeach
        </div>

        <!-- Search -->
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput"
                   placeholder="Cari nama, NPM, atau nickname..."
                   oninput="searchStudents()">
        </div>

        <!-- Class Tabs -->
        <div class="class-tabs">
            <div class="class-tab active" onclick="filterClass('all', null, this)">Semua</div>
            @foreach($mahasiswaData as $kelas => $students)
            <div class="class-tab" onclick="filterClass('{{ str_replace([' ', '-'], '_', $kelas) }}', null, this)">
                {{ $kelas }}
            </div>
            @endforeach
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
                        <th>Email</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    @php $no = 1; @endphp
                    @foreach($mahasiswaData as $kelas => $students)
                    <tr class="class-header-row class-{{ str_replace([' ', '-'], '_', $kelas) }}"
                        data-class="{{ str_replace([' ', '-'], '_', $kelas) }}">
                        <td colspan="8">
                            <i class="fas fa-users"></i>
                            Kelas {{ $kelas }} &mdash; {{ count($students) }} mahasiswa
                        </td>
                    </tr>
                    @foreach($students as $student)
                    <tr class="student-row class-{{ str_replace([' ', '-'], '_', $kelas) }}"
                        data-class="{{ str_replace([' ', '-'], '_', $kelas) }}"
                        data-search="{{ strtolower($student['nama']) }} {{ strtolower($student['npm']) }} {{ strtolower($student['nickname']) }}">
                        <td style="color:#bbb; font-size:12px;">{{ $no++ }}</td>
                        <td><span class="npm-badge">{{ $student['npm'] }}</span></td>
                        <td class="student-name">{{ $student['nama'] }}</td>
                        <td><span class="nickname-badge">{{ $student['nickname'] }}</span></td>
                        <td style="font-size:12px; color:#555;">{{ $student['email'] }}</td>
                        <td style="font-family:monospace; color:#5a67d8; font-size:13px; font-weight:600;">{{ $student['username'] }}</td>
                        <td style="font-family:monospace; color:#e07020; font-size:13px;">{{ $student['password'] }}</td>
                        <td>
                            <a href="{{ route('mahasiswa.edit', ['npm' => $student['npm']]) }}" class="btn-edit">
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
                Tidak ada mahasiswa yang cocok dengan pencarian
            </div>
        </div>

    </div>{{-- end main-content --}}
</div>{{-- end app-layout --}}

<script>
let currentClass  = 'all';
let currentSearch = '';

function filterClass(cls, statCard, tabEl) {
    currentClass = cls;

    // Update stat card active
    document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active-tab'));
    if (statCard) statCard.classList.add('active-tab');

    // Update tab active
    if (tabEl) {
        document.querySelectorAll('.class-tab').forEach(t => t.classList.remove('active'));
        tabEl.classList.add('active');
    } else {
        // Sinkronisasi tab dari stat card
        document.querySelectorAll('.class-tab').forEach(t => {
            const txt = t.textContent.trim().replace(/\s+/g, '_').replace(/-/g, '_');
            t.classList.toggle('active', cls === 'all' ? t === document.querySelector('.class-tab') : txt === cls);
        });
    }

    applyFilters();
}

function searchStudents() {
    currentSearch = document.getElementById('searchInput').value.toLowerCase().trim();
    applyFilters();
}

function applyFilters() {
    const rows    = document.querySelectorAll('.student-row');
    const headers = document.querySelectorAll('.class-header-row');
    let visible   = 0;

    // Tampilkan/sembunyikan header kelas
    headers.forEach(h => {
        h.classList.toggle('hidden', currentClass !== 'all' && h.dataset.class !== currentClass);
    });

    // Tampilkan/sembunyikan baris mahasiswa
    rows.forEach(row => {
        const classMatch  = currentClass === 'all' || row.dataset.class === currentClass;
        const searchMatch = !currentSearch || (row.dataset.search || '').includes(currentSearch);
        const show = classMatch && searchMatch;
        row.classList.toggle('hidden', !show);
        if (show) visible++;
    });

    // Update counter & judul
    document.getElementById('tableCount').textContent = visible + ' mahasiswa';
    document.getElementById('emptySearch').classList.toggle('hidden', visible > 0);

    if (currentClass === 'all') {
        document.getElementById('tableTitle').textContent = 'Semua Mahasiswa';
    } else {
        const hdr = document.querySelector(`.class-header-row.class-${currentClass} td`);
        document.getElementById('tableTitle').textContent =
            hdr ? hdr.textContent.split('—')[0].trim() : currentClass.replace(/_/g, ' ');
    }
}
</script>
</x-app-layout>
