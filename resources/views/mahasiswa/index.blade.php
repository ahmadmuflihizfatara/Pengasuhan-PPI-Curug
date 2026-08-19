<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Page Header Glass Banner --}}
                <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-purple-950/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-sky-200 mb-2">
                            <span>✦</span>
                            <span>Master Data Taruna</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-users text-sky-400"></i>
                            <span>Database Mahasiswa &amp; Taruna</span>
                        </h1>
                        <p class="text-xs text-sky-100/80">Data biodata, program studi, tingkat, dan akun seluruh mahasiswa aktif PPI Curug</p>
                    </div>

                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                @if(session('success'))
                <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @php
                    $prodiList   = \App\Models\Mahasiswa::PRODI;
                    $totalSemua  = $mahasiswaData->flatten(1)->count();
                    $maxTingkat  = 4;
                @endphp

                {{-- Chart Komponen --}}
                <div class="mb-5">
                    <x-prodi-tingkat-chart :chart-data="$chartData" />
                </div>

                {{-- Stats Row Per Prodi --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-4">
                    <div class="rounded-2xl bg-white/60 backdrop-blur-xl border border-white/80 p-3.5 text-center shadow-md cursor-pointer transition-all duration-200 hover:-translate-y-0.5 stat-card active-tab" data-prodi="all" onclick="setProdi('all', this)">
                        <div class="text-xl font-black text-slate-900 font-mono count">{{ $totalSemua }}</div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-indigo-700 label">Semua Prodi</div>
                        <div class="text-[9px] text-slate-500 sub">D-4 &amp; D-3 Aktif</div>
                    </div>
                    @foreach($prodiList as $kode => $info)
                    <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-3.5 text-center shadow-sm cursor-pointer transition-all duration-200 hover:-translate-y-0.5 stat-card" data-prodi="{{ $kode }}" onclick="setProdi('{{ $kode }}', this)">
                        <div class="text-xl font-black text-slate-800 font-mono count">{{ ($mahasiswaData[$kode] ?? collect())->count() }}</div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-700 label">{{ $kode }}</div>
                        <div class="text-[9px] text-slate-400 sub truncate">{{ $info['jenjang'] }} · {{ $info['nama'] }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Search Bar --}}
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/70 p-3 sm:px-4 sm:py-3 mb-4 shadow-sm flex items-center gap-3">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm ml-1"></i>
                    <input type="text" id="searchInput"
                           placeholder="Cari nama lengkap, NPM, atau nickname taruna..."
                           class="w-full bg-transparent border-none outline-none text-xs font-semibold text-slate-800 placeholder-slate-400"
                           oninput="applyFilters()">
                </div>

                {{-- Filter Chips Prodi & Tingkat --}}
                <div class="rounded-2xl bg-white/40 backdrop-blur-xl border border-white/50 p-4 mb-5 shadow-sm space-y-2.5">
                    <div class="flex items-center gap-2 flex-wrap text-xs">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 min-w-[50px]">Prodi:</span>
                        <button type="button" class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-600 text-white shadow-sm border border-indigo-600 transition chip active" data-prodi="all" onclick="setProdi('all', null, this)">Semua</button>
                        @foreach($prodiList as $kode => $info)
                        <button type="button" class="px-3 py-1 rounded-full text-xs font-bold bg-white/60 hover:bg-white text-slate-700 border border-white transition chip" data-prodi="{{ $kode }}" onclick="setProdi('{{ $kode }}', null, this)">
                            {{ $kode }}
                        </button>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-2 flex-wrap text-xs">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 min-w-[50px]">Tingkat:</span>
                        <button type="button" class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-600 text-white shadow-sm border border-indigo-600 transition chip active" data-tingkat="all" onclick="setTingkat('all', this)">Semua</button>
                        @for($t = 1; $t <= $maxTingkat; $t++)
                        <button type="button" class="px-3 py-1 rounded-full text-xs font-bold bg-white/60 hover:bg-white text-slate-700 border border-white transition chip" data-tingkat="{{ $t }}" onclick="setTingkat('{{ $t }}', this)">
                            Tingkat {{ $t }}
                        </button>
                        @endfor
                    </div>
                </div>

                {{-- Table Card --}}
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                    <div class="flex items-center justify-between pb-3.5 mb-3.5 border-b border-white/30">
                        <h2 class="text-xs font-extrabold uppercase tracking-wider text-slate-800" id="tableTitle">Semua Mahasiswa</h2>
                        <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 font-bold text-[10px]" id="tableCount">{{ $totalSemua }} mahasiswa</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                    <th class="py-3 px-3">#</th>
                                    <th class="py-3 px-3">NPM</th>
                                    <th class="py-3 px-3">Nama Lengkap</th>
                                    <th class="py-3 px-3">Nickname</th>
                                    <th class="py-3 px-3">L/P</th>
                                    <th class="py-3 px-3">Tingkat</th>
                                    <th class="py-3 px-3">Email Akun</th>
                                    <th class="py-3 px-3">Username</th>
                                    <th class="py-3 px-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody" class="divide-y divide-white/30">
                                @php $no = 1; @endphp
                                @foreach($mahasiswaData as $kode => $students)
                                @php $info = $prodiList[$kode] ?? ['nama' => $kode, 'jenjang' => '-']; @endphp
                                <tr class="bg-indigo-900/80 text-white font-bold prodi-header-row" data-prodi="{{ $kode }}">
                                    <td colspan="9" class="py-2 px-3 text-white">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <span>{{ $kode }} &mdash; {{ $info['nama'] }}</span>
                                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-[10px]">{{ $info['jenjang'] }}</span>
                                            <span class="px-2 py-0.5 rounded-full bg-white/20 text-[10px]">{{ count($students) }} taruna</span>
                                        </div>
                                    </td>
                                </tr>
                                @foreach($students as $student)
                                <tr class="student-row hover:bg-white/60 transition"
                                    data-prodi="{{ $kode }}"
                                    data-tingkat="{{ $student->tingkat }}"
                                    data-search="{{ strtolower($student->nama) }} {{ strtolower($student->npm ?? '') }} {{ strtolower($student->nickname ?? '') }}">
                                    <td class="py-3 px-3 text-slate-400 font-bold">{{ $no++ }}</td>
                                    <td class="py-3 px-3 font-mono font-bold text-slate-800">{{ $student->npm ?? '-' }}</td>
                                    <td class="py-3 px-3 font-bold text-slate-900">{{ $student->nama }}</td>
                                    <td class="py-3 px-3">
                                        <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 font-bold text-[10px]">
                                            {{ $student->nickname ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3">
                                        @if($student->jenis_kelamin)
                                        <span class="px-2 py-0.5 rounded-full font-bold text-[10px] {{ $student->jenis_kelamin === 'L' ? 'bg-sky-100 text-sky-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ $student->jenis_kelamin }}
                                        </span>
                                        @else
                                        <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3">
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                            Tingkat {{ $student->tingkat }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-slate-600 font-medium">{{ $student->user->email ?? '-' }}</td>
                                    <td class="py-3 px-3 font-mono text-indigo-700 font-bold">{{ $student->user->username ?? '-' }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <a href="{{ route('mahasiswa.edit', $student) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm transition no-underline">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                            <span>Edit</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="emptySearch" class="text-center py-10 text-slate-400 hidden">
                        <i class="fa-solid fa-magnifying-glass text-3xl mb-2 block"></i>
                        <span class="font-semibold text-xs">Tidak ada mahasiswa yang cocok dengan filter atau pencarian.</span>
                    </div>
                </div>

    </div>
</main>

<script>
const PRODI_NAMA = @json(collect($prodiList)->map(fn($i) => $i['nama']));

let currentProdi   = 'all';
let currentTingkat = 'all';

function setProdi(kode, statCard, chipEl) {
    currentProdi = kode;

    document.querySelectorAll('.stat-card').forEach(c => {
        const isActive = c.dataset.prodi === kode;
        c.classList.toggle('bg-white/70', isActive);
        c.classList.toggle('border-indigo-400', isActive);
    });
    document.querySelectorAll('.chip[data-prodi]').forEach(c => {
        const isActive = c.dataset.prodi === kode;
        c.classList.toggle('bg-indigo-600', isActive);
        c.classList.toggle('text-white', isActive);
        c.classList.toggle('bg-white/60', !isActive);
        c.classList.toggle('text-slate-700', !isActive);
    });

    applyFilters();
}

function setTingkat(tingkat, chipEl) {
    currentTingkat = tingkat;

    document.querySelectorAll('.chip[data-tingkat]').forEach(c => {
        const isActive = c.dataset.tingkat === tingkat;
        c.classList.toggle('bg-indigo-600', isActive);
        c.classList.toggle('text-white', isActive);
        c.classList.toggle('bg-white/60', !isActive);
        c.classList.toggle('text-slate-700', !isActive);
    });

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

    headers.forEach(h => {
        h.classList.toggle('hidden', !terlihatPerProdi[h.dataset.prodi]);
    });

    document.getElementById('tableCount').textContent = visible + ' mahasiswa';
    document.getElementById('emptySearch').classList.toggle('hidden', visible > 0);

    let judul = currentProdi === 'all'
        ? 'Semua Mahasiswa'
        : currentProdi + ' — ' + (PRODI_NAMA[currentProdi] || currentProdi);
    if (currentTingkat !== 'all') judul += ' · Tingkat ' + currentTingkat;
    document.getElementById('tableTitle').textContent = judul;
}
</script>

</x-app-layout>
