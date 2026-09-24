<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- ponytail: reload penuh tiap 60 dtk, ganti polling JSON jika perlu update tanpa kedip --}}
    <meta http-equiv="refresh" content="60">
    <title>Monitoring TV - Pengasuhan PPI Curug</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .tv-scroll::-webkit-scrollbar { width: 6px; }
        .tv-scroll::-webkit-scrollbar-thumb { background: rgba(15,23,42,.2); border-radius: 3px; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 h-screen overflow-hidden flex flex-col">

    {{-- Header --}}
    <header class="flex items-center justify-between px-6 py-3 bg-white border-b border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-lg"><i class="fa-solid fa-tv"></i></div>
            <div>
                <div class="text-lg font-black tracking-tight">MONITORING TV PENGASUHAN</div>
                <div class="text-xs text-slate-500">PPI Curug — Resimen Taruna</div>
            </div>
        </div>
        <div class="text-right" x-data="{ now: new Date() }" x-init="setInterval(() => now = new Date(), 1000)">
            <div class="text-2xl font-black font-mono" x-text="now.toLocaleTimeString('id-ID')"></div>
            <div class="text-xs text-slate-500" x-text="now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })"></div>
        </div>
    </header>

    <main class="flex-1 grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-2 gap-4 p-4 min-h-0">

        {{-- Kiri atas: Dinas & Izin Keluar --}}
        <section class="rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col min-h-0">
            <h2 class="px-5 py-3 border-b border-slate-200 font-extrabold uppercase tracking-wider text-sm flex items-center justify-between">
                <span><i class="fa-solid fa-person-walking-arrow-right text-sky-600 mr-2"></i>Dinas &amp; Izin Keluar</span>
                <span class="px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-700 text-xs">{{ $izinKeluar->count() }} di luar</span>
            </h2>
            <div class="flex-1 overflow-y-auto tv-scroll">
                <table class="w-full text-sm">
                    <thead class="sticky top-0 bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500">
                        <tr><th class="text-left px-5 py-2">Nama</th><th class="text-left py-2">Kategori</th><th class="text-left py-2">Keterangan</th><th class="text-right px-5 py-2">Berangkat</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($izinKeluar as $log)
                        <tr>
                            <td class="px-5 py-2"><div class="font-bold">{{ $log->nama }}</div><div class="text-[11px] text-slate-500">{{ $log->prodi }}</div></td>
                            <td class="py-2">
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ $log->kategori === 'perizinan' ? 'bg-rose-100 text-rose-700' : 'bg-indigo-100 text-indigo-700' }}">
                                    {{ $log->kategori === 'perizinan' ? 'Izin Keluar' : 'Dinas ' . ucfirst($log->kategori) }}
                                </span>
                                @if($log->subkategori)<div class="text-[11px] text-slate-500 mt-0.5">{{ $log->subkategori }}</div>@endif
                            </td>
                            <td class="py-2 text-slate-600 max-w-[180px] truncate">{{ $log->keterangan_keluhan ?? $log->nama_ekskul ?? $log->lokasi_kegiatan ?? $log->rute ?? '-' }}</td>
                            <td class="px-5 py-2 text-right font-mono"><div>{{ $log->waktu_berangkat?->format('H:i') ?? '-' }}</div><div class="text-[11px] text-amber-600">{{ $log->getDurasiFormatted() }}</div></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-10 text-slate-500">Semua taruna berada di asrama.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Kanan atas: Log Book Pelanggaran & Penghargaan --}}
        <section class="rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col min-h-0">
            <h2 class="px-5 py-3 border-b border-slate-200 font-extrabold uppercase tracking-wider text-sm">
                <i class="fa-solid fa-book text-amber-500 mr-2"></i>Log Book Pelanggaran &amp; Penghargaan
            </h2>
            <div class="flex-1 overflow-y-auto tv-scroll divide-y divide-slate-100">
                @forelse($logBook as $p)
                @php $pelanggaran = $p->kategori === \App\Models\PoinMahasiswa::KAT_PELANGGARAN; @endphp
                <div class="px-5 py-2.5 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg flex-shrink-0 flex items-center justify-center {{ $pelanggaran ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                        <i class="fa-solid {{ $pelanggaran ? 'fa-triangle-exclamation' : 'fa-trophy' }}"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="font-bold text-sm truncate">{{ $p->nama_mahasiswa }} <span class="text-slate-500 font-normal text-xs">· {{ $p->kelas }}</span></div>
                        <div class="text-xs text-slate-500 truncate">{{ $p->kegiatan }}</div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <div class="font-black font-mono {{ $pelanggaran ? 'text-rose-600' : 'text-emerald-600' }}">{{ $pelanggaran ? '-' : '+' }}{{ abs($p->nilai) }}</div>
                        <div class="text-[11px] text-slate-500">{{ $p->tanggal?->locale('id')->isoFormat('D MMM') }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10 text-slate-500">Belum ada catatan.</div>
                @endforelse
            </div>
        </section>

        {{-- Kiri bawah: Taruna Sakit --}}
        <section class="rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col min-h-0">
            <h2 class="px-5 py-3 border-b border-slate-200 font-extrabold uppercase tracking-wider text-sm flex items-center justify-between">
                <span><i class="fa-solid fa-kit-medical text-rose-600 mr-2"></i>Taruna Sakit Hari Ini</span>
                <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 text-xs">{{ $tarunaSakit->count() }} taruna</span>
            </h2>
            <div class="flex-1 overflow-y-auto tv-scroll">
                <table class="w-full text-sm">
                    <thead class="sticky top-0 bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500">
                        <tr><th class="text-left px-5 py-2">Nama</th><th class="text-left py-2">Kelas</th><th class="text-left px-5 py-2">Keterangan</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tarunaSakit as $s)
                        <tr>
                            <td class="px-5 py-2 font-bold">{{ $s->mahasiswa->nama ?? '-' }}</td>
                            <td class="py-2 text-slate-600">{{ $s->mahasiswa->kelas ?? '-' }}</td>
                            <td class="px-5 py-2 text-slate-600">{{ $s->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-10 text-slate-500">Tidak ada laporan taruna sakit hari ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Kanan bawah: Galeri Dokumentasi (satu foto, bisa di-swipe) --}}
        <section class="rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col min-h-0 overflow-hidden"
            x-data="{ items: @js($galeri), i: 0, x0: null,
                      go(d) { if (!this.items.length) return; this.i = (this.i + d + this.items.length) % this.items.length; try { sessionStorage.tvGaleri = this.i } catch (e) {} } }"
            x-init="try { i = (+sessionStorage.tvGaleri || 0) % (items.length || 1) } catch (e) {}; setInterval(() => go(1), 8000)"
            @keydown.left.window="go(-1)" @keydown.right.window="go(1)">
            <h2 class="px-5 py-3 border-b border-slate-200 font-extrabold uppercase tracking-wider text-sm flex items-center justify-between">
                <span><i class="fa-solid fa-images text-emerald-600 mr-2"></i>Galeri Dokumentasi</span>
                <span class="text-xs text-slate-500" x-show="items.length" x-text="(i + 1) + ' / ' + items.length"></span>
            </h2>
            <template x-if="items.length">
                <div class="relative flex-1 min-h-0 select-none"
                    @touchstart="x0 = $event.touches[0].clientX"
                    @touchend="if (x0 !== null) { const dx = $event.changedTouches[0].clientX - x0; if (Math.abs(dx) > 40) go(dx < 0 ? 1 : -1); x0 = null }">
                    <img :src="items[i].src" :alt="items[i].judul" class="absolute inset-0 w-full h-full object-contain bg-slate-100">
                    <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/90 to-transparent">
                        <div class="font-bold text-white" x-text="items[i].judul"></div>
                        <div class="text-xs text-slate-200" x-text="items[i].tanggal"></div>
                    </div>
                    <button type="button" @click="go(-1)" aria-label="Foto sebelumnya" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/80 hover:bg-white text-slate-800 shadow flex items-center justify-center"><i class="fa-solid fa-chevron-left"></i></button>
                    <button type="button" @click="go(1)" aria-label="Foto berikutnya" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/80 hover:bg-white text-slate-800 shadow flex items-center justify-center"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </template>
            <div x-show="!items.length" class="flex-1 flex items-center justify-center text-slate-500">Belum ada foto dokumentasi.</div>
        </section>

    </main>
</body>
</html>
