<x-app-layout>
<x-form-glass-style />
<style>
    /* Legenda akses */
    .ak-legenda { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-3-5); }
    .ak-legenda__item { display: flex; align-items: center; gap: var(--space-3); }
    .ak-ikon { width: 44px; height: 44px; flex-shrink: 0; border-radius: var(--radius-md); display: grid; place-items: center; font-size: 17px; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .ak-legenda__nama { font-size: 14px; line-height: 19px; font-weight: 800; color: var(--ink-900); }
    .ak-legenda__ket { margin: 2px 0 var(--space-1-5); font-size: 12px; line-height: 16px; font-weight: 500; color: var(--ink-700); }

    /* Pencarian — pola filter tab Surat */
    .ak-cari { display: flex; gap: var(--space-2); flex-wrap: wrap; }
    .ak-cari__input { position: relative; flex: 1; min-width: 220px; max-width: 460px; }
    .ak-cari__input i { position: absolute; left: var(--space-3); top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .ak-cari__input .form-control { padding-left: 34px; }
    .ak-cari .ds-btn { height: 38px; }

    /* Tabel */
    .ak-table td { vertical-align: middle; }
    .ak-table tr.ak-pegang td { background: var(--warning-tint) !important; }
    .ak-table tr.ak-ubah td { background: var(--accent-tint) !important; }
    .ak-cek { display: inline-flex; align-items: center; justify-content: center; }
    /* Tailwind Forms menggambar checkbox pakai currentColor → warnai lewat color (accent-color untuk browser tanpa plugin) */
    .ak-cek input { width: 18px; height: 18px; margin: 0; cursor: pointer; color: var(--ak-warna, var(--accent)); accent-color: var(--ak-warna, var(--accent)); border-radius: 5px; }
    .ak-cek input:focus-visible { outline: none; box-shadow: var(--shadow-focus); border-radius: 4px; }
    .ak-th { white-space: nowrap; }
    .ak-th i { color: var(--ak-warna); margin-right: var(--space-1); }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Akses Khusus Taruna" icon="fa-key"
            subtitle="Beri kewenangan Kepala Seksi Internal atau Polisi Taruna ke akun taruna tertentu" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Akses belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        {{-- Legenda akses --}}
        <div class="ak-legenda mb-4">
            @foreach($daftarAkses as $key => $a)
            @php $pemegang = $taruna->filter(fn ($u) => in_array($key, $u->akses_khusus ?? []))->count(); @endphp
            <div class="ds-card ak-legenda__item">
                <span class="ak-ikon" style="background:linear-gradient(135deg,{{ $a['warna'] }},var(--accent));"><i class="fa-solid {{ $a['ikon'] }}"></i></span>
                <div>
                    <div class="ak-legenda__nama">{{ $a['label'] }}</div>
                    <p class="ak-legenda__ket">{{ $a['ket'] }}</p>
                    <span class="ds-badge {{ $pemegang ? 'ds-badge--warning' : '' }}"><i class="fa-solid fa-user-check"></i> {{ $pemegang }} taruna memegang akses ini</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pencarian --}}
        <div class="ds-card mb-4">
            <form method="GET" action="{{ route('akses-khusus.index') }}" class="ak-cari" role="search">
                <div class="ak-cari__input">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="q" value="{{ $q }}" class="form-control" placeholder="Cari nama / email taruna..." aria-label="Cari taruna">
                </div>
                <button type="submit" class="ds-btn ds-btn--primary"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                @if($q)
                <a href="{{ route('akses-khusus.index') }}" class="ds-btn" title="Reset pencarian" aria-label="Reset pencarian"><i class="fa-solid fa-xmark"></i></a>
                @endif
            </form>
        </div>

        {{-- Tabel taruna --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-user-gear ds-icon"></i> Akun Taruna</h3>
                    <p class="ds-card__desc">{{ $q ? 'Hasil pencarian "' . $q . '"' : 'Pemegang akses tampil paling atas' }} — centang akses lalu klik Simpan pada baris tersebut</p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ $taruna->count() }} taruna</span>
            </div>

            @if($taruna->isEmpty())
            <div class="ds-empty"><i class="fa-solid fa-user-slash ds-icon"></i> Tidak ada akun taruna ditemukan.</div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    {{-- data-no-tools: pencarian lewat server (form di atas) --}}
                    <table class="ds-table tbl-table ak-table" data-no-tools>
                        <thead>
                            <tr>
                                <th>Taruna</th>
                                <th>Prodi / Tingkat</th>
                                @foreach($daftarAkses as $a)
                                <th class="ds-center ak-th" style="--ak-warna:{{ $a['warna'] }}"><i class="fa-solid {{ $a['ikon'] }}"></i>{{ $a['label'] }}</th>
                                @endforeach
                                <th class="ds-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($taruna as $u)
                            <tr class="{{ $u->akses_khusus ? 'ak-pegang' : '' }}" data-baris="{{ $u->id }}">
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($u->name, 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $u->name }}</div>
                                            <div class="tbl-sub">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($u->mahasiswa)
                                    <span class="ds-badge ds-badge--info">{{ $u->mahasiswa->prodi }}</span>
                                    <span class="ds-badge ds-badge--success">Tk. {{ $u->mahasiswa->tingkat }}</span>
                                    @else
                                    <span class="tbl-sub">—</span>
                                    @endif
                                </td>
                                @foreach($daftarAkses as $key => $a)
                                <td class="ds-center">
                                    <label class="ak-cek" style="--ak-warna:{{ $a['warna'] }}">
                                        <input type="checkbox" form="akses-{{ $u->id }}" name="akses[]" value="{{ $key }}"
                                               aria-label="{{ $a['label'] }} untuk {{ $u->name }}" @checked(in_array($key, $u->akses_khusus ?? []))>
                                    </label>
                                </td>
                                @endforeach
                                <td class="ds-right">
                                    <button type="submit" form="akses-{{ $u->id }}" class="ds-btn ds-btn--sm ds-btn--pill" disabled title="Ubah centang akses untuk menyimpan">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Form per baris di luar tabel (form di dalam tr tidak valid HTML) --}}
            @foreach($taruna as $u)
            <form method="POST" action="{{ route('akses-khusus.update', $u) }}" id="akses-{{ $u->id }}">
                @csrf @method('PATCH')
                <input type="hidden" name="q" value="{{ $q }}">
            </form>
            @endforeach
            @endif
        </div>

    </div>
</main>

<script>
// Tombol Simpan per baris aktif hanya bila centang berubah — baris yang belum disimpan ikut disorot
document.querySelectorAll('tr[data-baris]').forEach(function (baris) {
    const cek = [...baris.querySelectorAll('input[type=checkbox]')];
    const awal = cek.map(c => c.checked).join();
    const tombol = baris.querySelector('button[type=submit]');
    cek.forEach(c => c.addEventListener('change', function () {
        const berubah = cek.map(x => x.checked).join() !== awal;
        tombol.disabled = !berubah;
        tombol.classList.toggle('ds-btn--primary', berubah);
        tombol.title = berubah ? 'Simpan perubahan akses' : 'Ubah centang akses untuk menyimpan';
        baris.classList.toggle('ak-ubah', berubah);
    }));
});
</script>
</x-app-layout>
