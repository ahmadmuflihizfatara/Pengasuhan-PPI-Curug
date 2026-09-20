<x-app-layout>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Page Header --}}
        <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-amber-300 mb-2">
                    <span>✦</span>
                    <span>Admin Sistem</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-key text-amber-400"></i>
                    <span>Pemberian Akses Khusus Taruna</span>
                </h1>
                <p class="text-xs text-indigo-100/80">Beri kewenangan Kepala Seksi Internal atau Polisi Taruna ke akun taruna tertentu</p>
            </div>
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        @if(session('success'))
        <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if($errors->any())
        <div class="rounded-2xl bg-rose-100/90 border border-rose-300 p-4 text-rose-800 text-xs font-bold mb-5 shadow-sm backdrop-blur-md">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        {{-- Legenda akses --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
            @foreach($daftarAkses as $key => $a)
            <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-4 shadow flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-base flex-shrink-0" style="background:{{ $a['warna'] }}">
                    <i class="fas {{ $a['ikon'] }}"></i>
                </div>
                <div>
                    <div class="text-xs font-extrabold text-slate-900">{{ $a['label'] }}</div>
                    <div class="text-[11px] text-slate-500">{{ $a['ket'] }}</div>
                    <div class="text-[10px] font-bold mt-0.5" style="color:{{ $a['warna'] }}">{{ $taruna->filter(fn ($u) => in_array($key, $u->akses_khusus ?? []))->count() }} taruna memegang akses ini</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pencarian --}}
        <form method="GET" action="{{ route('akses-khusus.index') }}" class="flex items-center gap-2 mb-4">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama / email taruna..."
                   class="flex-1 sm:flex-none sm:w-80 px-3.5 py-2.5 rounded-xl bg-white/70 focus:bg-white border border-white/80 text-xs font-semibold text-slate-800 outline-none">
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if($q)
            <a href="{{ route('akses-khusus.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 no-underline">Reset</a>
            @endif
        </form>

        {{-- Tabel taruna --}}
        <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg overflow-x-auto">
            @if($taruna->isEmpty())
            <div class="text-center py-8 text-slate-400">
                <i class="fa-solid fa-user-slash text-3xl mb-2 block"></i>
                <span class="font-semibold text-xs">Tidak ada akun taruna ditemukan.</span>
            </div>
            @else
            <table class="w-full text-xs">
                <thead>
                    <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200/70">
                        <th class="text-left py-2 pr-3">Taruna</th>
                        <th class="text-left py-2 px-3">Prodi / Tk</th>
                        @foreach($daftarAkses as $a)
                        <th class="text-center py-2 px-3" style="color:{{ $a['warna'] }}">{{ $a['label'] }}</th>
                        @endforeach
                        <th class="py-2 pl-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taruna as $u)
                    <tr class="border-b border-slate-100/70 hover:bg-white/40 {{ $u->akses_khusus ? 'bg-amber-50/40' : '' }}">
                            <td class="py-2.5 pr-3">
                                <div class="font-bold text-slate-800">{{ $u->name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $u->email }}</div>
                            </td>
                            <td class="py-2.5 px-3 text-slate-600">
                                {{ $u->mahasiswa ? $u->mahasiswa->prodi . ' / ' . $u->mahasiswa->tingkat : '-' }}
                            </td>
                            @foreach($daftarAkses as $key => $a)
                            <td class="py-2.5 px-3 text-center">
                                <input type="checkbox" form="akses-{{ $u->id }}" name="akses[]" value="{{ $key }}" class="w-4 h-4 cursor-pointer" style="accent-color:{{ $a['warna'] }}"
                                       @checked(in_array($key, $u->akses_khusus ?? []))>
                            </td>
                            @endforeach
                            <td class="py-2.5 pl-3 text-right">
                                <button type="submit" form="akses-{{ $u->id }}" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-[10px] transition">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                                </button>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

</x-app-layout>
