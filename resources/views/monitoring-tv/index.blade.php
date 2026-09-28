<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- ponytail: reload penuh tiap 60 dtk, ganti polling JSON jika perlu update tanpa kedip --}}
    <meta http-equiv="refresh" content="60">
    <title>Monitoring TV - Pengasuhan PPI Curug</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { margin: 0; height: 100%; font-family: 'Inter', sans-serif; color: var(--ink-900); background: #0f172a; }
        /* Latar kokpit — sama dengan layout aplikasi */
        .tv-bg { position: fixed; inset: -20px; z-index: -2; background: url('{{ asset('images/BG.png') }}') center / cover no-repeat; filter: blur(4px) brightness(.9); transform: scale(1.04); }
        .tv-bg-overlay { position: fixed; inset: 0; z-index: -1; background: radial-gradient(circle at center, rgba(15,23,42,.12) 0%, rgba(15,23,42,.45) 100%); }

        .tv { height: 100vh; display: flex; flex-direction: column; gap: var(--space-4); padding: var(--space-4); box-sizing: border-box; }

        /* Header — gaya banner halaman */
        .tv-head {
            position: relative; overflow: hidden; flex-shrink: 0;
            display: flex; align-items: center; justify-content: space-between; gap: var(--space-4);
            padding: var(--space-4) var(--space-6); border-radius: var(--radius-lg); color: #fff;
            background: linear-gradient(90deg, rgba(30,58,138,.9), rgba(49,46,129,.85), rgba(15,23,42,.9));
            border: 1px solid rgba(255,255,255,.3); box-shadow: var(--shadow-glass-lg);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        }
        .tv-head::before, .tv-head::after { content: ''; position: absolute; border-radius: 50%; filter: blur(48px); pointer-events: none; }
        .tv-head::before { width: 220px; height: 220px; right: -60px; top: -80px; background: rgba(99,102,241,.3); }
        .tv-head::after  { width: 180px; height: 180px; right: 260px; bottom: -100px; background: rgba(14,165,233,.25); }
        .tv-head__kiri { position: relative; z-index: 1; display: flex; align-items: center; gap: var(--space-4); }
        .tv-head__ikon { font-size: 30px; color: rgba(199,210,254,.85); }
        .tv-head__judul { margin: 0; font-size: 22px; line-height: 28px; font-weight: 900; letter-spacing: -0.01em; }
        .tv-head__sub { margin: 2px 0 0; font-size: 12px; font-weight: 500; color: rgba(224,242,254,.8); }
        .tv-jam { position: relative; z-index: 1; text-align: right; padding: var(--space-2) var(--space-4); border-radius: var(--radius-md); background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); }
        .tv-jam__waktu { font-family: var(--font-mono); font-size: 28px; line-height: 32px; font-weight: 800; }
        .tv-jam__tgl { font-size: 11px; font-weight: 600; color: rgba(224,242,254,.8); }

        /* Panel */
        .tv-grid { flex: 1; min-height: 0; display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; gap: var(--space-4); }
        @media (max-width: 1023px) { .tv { height: auto; } .tv-grid { grid-template-columns: 1fr; grid-template-rows: none; } .tv-panel { min-height: 360px; } }
        .tv-panel { display: flex; flex-direction: column; min-height: 0; overflow: hidden; padding: 0; }
        .tv-panel__head { flex-shrink: 0; display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); padding: var(--space-3-5) var(--space-5); border-bottom: 1px solid var(--border-glass-subtle); }
        .tv-panel__judul { margin: 0; display: flex; align-items: center; gap: var(--space-2-5); font-size: 14px; line-height: 20px; font-weight: 900; letter-spacing: .04em; text-transform: uppercase; color: var(--ink-900); }
        .tv-panel__judul .ds-stat__icon { width: 32px; height: 32px; font-size: 13px; }
        .ds-stat__icon--info { background: linear-gradient(135deg, #0ea5e9, var(--info)); }
        .tv-panel__isi { flex: 1; min-height: 0; overflow-y: auto; padding: var(--space-3) var(--space-4); }
        .tv-panel__isi::-webkit-scrollbar { width: 6px; }
        .tv-panel__isi::-webkit-scrollbar-thumb { background: rgba(15,23,42,.2); border-radius: 3px; }
        .tv-kosong { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 14px; color: var(--ink-700); }

        /* Tabel panel */
        .tv-tabel { width: 100%; border-collapse: separate; border-spacing: 0 var(--space-1-5); font-size: 13px; }
        .tv-tabel th { position: sticky; top: 0; z-index: 1; padding: var(--space-2) var(--space-3); text-align: left; background: var(--glass-solid); font-size: 10px; line-height: 14px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: var(--ink-600); }
        .tv-tabel th:first-child { border-radius: var(--radius-sm) 0 0 var(--radius-sm); }
        .tv-tabel th:last-child { border-radius: 0 var(--radius-sm) var(--radius-sm) 0; }
        .tv-tabel td { padding: var(--space-2-5) var(--space-3); background: var(--glass-card); border-top: 1px solid var(--border-glass-glow); border-bottom: 1px solid var(--border-glass-glow); vertical-align: middle; color: var(--ink-800); }
        .tv-tabel td:first-child { border-left: 1px solid var(--border-glass-glow); border-radius: var(--radius-md) 0 0 var(--radius-md); }
        .tv-tabel td:last-child { border-right: 1px solid var(--border-glass-glow); border-radius: 0 var(--radius-md) var(--radius-md) 0; }
        .tv-tabel .kanan { text-align: right; }
        .tv-nama { font-size: 13px; line-height: 18px; font-weight: 800; color: var(--ink-900); }
        .tv-sub { font-size: 11px; line-height: 15px; font-weight: 600; color: var(--ink-600); }
        .tv-mono { font-family: var(--font-mono); font-weight: 800; color: var(--ink-900); }
        .tv-trunc { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* Log book */
        .tv-log { display: flex; flex-direction: column; gap: var(--space-1-5); }
        .tv-log__item { display: flex; align-items: center; gap: var(--space-3); padding: var(--space-2-5) var(--space-3); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
        .tv-log__ikon { width: 36px; height: 36px; flex-shrink: 0; border-radius: var(--radius-sm); display: grid; place-items: center; font-size: 14px; }
        .tv-log__ikon--danger  { background: var(--danger-tint); color: var(--danger-ink); }
        .tv-log__ikon--success { background: var(--success-tint); color: var(--success-ink); }
        .tv-log__isi { flex: 1; min-width: 0; }
        .tv-log__isi .tv-nama, .tv-log__isi .tv-sub { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .tv-log__nilai { flex-shrink: 0; text-align: right; }
        .tv-log__nilai b { display: block; font-family: var(--font-mono); font-size: 16px; line-height: 20px; font-weight: 900; }

        /* Galeri */
        .tv-galeri { position: relative; flex: 1; min-height: 0; margin: var(--space-3) var(--space-4) var(--space-4); border-radius: var(--radius-md); overflow: hidden; background: var(--glass-dark); user-select: none; }
        .tv-galeri img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; }
        .tv-galeri__cap { position: absolute; inset: auto 0 0 0; padding: var(--space-4); background: linear-gradient(to top, rgba(2,6,23,.9), transparent); color: #fff; }
        .tv-galeri__cap b { display: block; font-size: 14px; line-height: 20px; font-weight: 800; }
        .tv-galeri__cap span { font-size: 11px; color: rgba(226,232,240,.85); }
        .tv-galeri__nav { position: absolute; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; border-radius: var(--radius-pill); display: grid; place-items: center; border: 1px solid var(--border-glass-glow); background: var(--glass-solid); color: var(--ink-900); box-shadow: var(--shadow-glass-sm); cursor: pointer; }
        .tv-galeri__nav:hover { background: #fff; }
        .tv-galeri__nav--kiri { left: var(--space-3); }
        .tv-galeri__nav--kanan { right: var(--space-3); }
    </style>
</head>
<body>
<div class="tv-bg" aria-hidden="true"></div>
<div class="tv-bg-overlay" aria-hidden="true"></div>

<div class="tv">
    {{-- Header --}}
    <header class="tv-head">
        <div class="tv-head__kiri">
            <span class="tv-head__ikon" aria-hidden="true"><i class="fa-solid fa-tv"></i></span>
            <div>
                <h1 class="tv-head__judul">Monitoring TV Pengasuhan</h1>
                <p class="tv-head__sub">PPI Curug — Resimen Taruna · diperbarui otomatis tiap menit</p>
            </div>
        </div>
        <div class="tv-jam" x-data="{ now: new Date() }" x-init="setInterval(() => now = new Date(), 1000)">
            <div class="tv-jam__waktu" x-text="now.toLocaleTimeString('id-ID')"></div>
            <div class="tv-jam__tgl" x-text="now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })"></div>
        </div>
    </header>

    <main class="tv-grid">

        {{-- Dinas & Izin Keluar --}}
        <section class="ds-card tv-panel">
            <div class="tv-panel__head">
                <h2 class="tv-panel__judul"><span class="ds-stat__icon ds-stat__icon--info"><i class="fa-solid fa-person-walking-arrow-right"></i></span> Dinas &amp; Izin Keluar</h2>
                <span class="ds-badge ds-badge--info">{{ $izinKeluar->count() }} di luar</span>
            </div>
            <div class="tv-panel__isi">
                @if($izinKeluar->isEmpty())
                <div class="ds-empty tv-kosong"><i class="fa-solid fa-house-circle-check ds-icon"></i>Semua taruna berada di asrama.</div>
                @else
                <table class="tv-tabel" data-no-tools>
                    <thead><tr><th>Nama</th><th>Kategori</th><th>Keterangan</th><th class="kanan">Berangkat</th></tr></thead>
                    <tbody>
                        @foreach($izinKeluar as $log)
                        <tr>
                            <td><div class="tv-nama">{{ $log->nama }}</div><div class="tv-sub">{{ $log->prodi }}</div></td>
                            <td>
                                <span class="ds-badge ds-badge--{{ $log->kategori === 'perizinan' ? 'danger' : 'accent' }}">{{ $log->kategori === 'perizinan' ? 'Izin Keluar' : 'Dinas ' . ucfirst($log->kategori) }}</span>
                                @if($log->subkategori)<div class="tv-sub mt-1">{{ $log->subkategori_label }}</div>@endif
                                <x-badge-urgensi :log="$log" class="mt-1" />
                            </td>
                            <td class="tv-sub tv-trunc">{{ $log->keterangan_keluhan ?? $log->nama_ekskul ?? $log->lokasi_kegiatan ?? $log->rute ?? '—' }}</td>
                            <td class="kanan"><div class="tv-mono">{{ $log->waktu_berangkat?->format('H:i') ?? '—' }}</div><div class="tv-sub" style="color:var(--warning-ink)">{{ $log->getDurasiFormatted() }}</div></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </section>

        {{-- Log Book --}}
        <section class="ds-card tv-panel">
            <div class="tv-panel__head">
                <h2 class="tv-panel__judul"><span class="ds-stat__icon ds-stat__icon--warning"><i class="fa-solid fa-book"></i></span> Log Book Poin</h2>
                <span class="ds-badge">{{ $logBook->count() }} catatan terbaru</span>
            </div>
            <div class="tv-panel__isi">
                @if($logBook->isEmpty())
                <div class="ds-empty tv-kosong"><i class="fa-solid fa-book-open ds-icon"></i>Belum ada catatan.</div>
                @else
                <div class="tv-log">
                    @foreach($logBook as $p)
                    @php $pelanggaran = $p->kategori === \App\Models\PoinMahasiswa::KAT_PELANGGARAN; @endphp
                    <div class="tv-log__item">
                        <span class="tv-log__ikon tv-log__ikon--{{ $pelanggaran ? 'danger' : 'success' }}"><i class="fa-solid {{ $pelanggaran ? 'fa-triangle-exclamation' : 'fa-trophy' }}"></i></span>
                        <div class="tv-log__isi">
                            <div class="tv-nama">{{ $p->nama_mahasiswa }} <span class="tv-sub">· {{ $p->kelas }}</span></div>
                            <div class="tv-sub">{{ $p->kegiatan }}</div>
                        </div>
                        <div class="tv-log__nilai">
                            <b style="color:var(--{{ $pelanggaran ? 'danger' : 'success' }}-ink)">{{ $pelanggaran ? '−' : '+' }}{{ abs($p->nilai) }}</b>
                            <span class="tv-sub">{{ $p->tanggal?->locale('id')->isoFormat('D MMM') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>

        {{-- Taruna Sakit --}}
        <section class="ds-card tv-panel">
            <div class="tv-panel__head">
                <h2 class="tv-panel__judul"><span class="ds-stat__icon ds-stat__icon--danger"><i class="fa-solid fa-kit-medical"></i></span> Taruna Sakit Hari Ini</h2>
                <span class="ds-badge ds-badge--{{ $tarunaSakit->isEmpty() ? 'success' : 'danger' }}">{{ $tarunaSakit->count() }} taruna</span>
            </div>
            <div class="tv-panel__isi">
                @if($tarunaSakit->isEmpty())
                <div class="ds-empty tv-kosong"><i class="fa-solid fa-heart-pulse ds-icon"></i>Tidak ada laporan taruna sakit hari ini.</div>
                @else
                <table class="tv-tabel" data-no-tools>
                    <thead><tr><th>Nama</th><th>Kelas</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        @foreach($tarunaSakit as $s)
                        <tr>
                            <td class="tv-nama">{{ $s->mahasiswa->nama ?? '—' }}</td>
                            <td><span class="ds-badge">{{ $s->mahasiswa->kelas ?? '—' }}</span></td>
                            <td class="tv-sub">{{ $s->keterangan ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </section>

        {{-- Galeri Dokumentasi (satu foto, bisa di-swipe) --}}
        <section class="ds-card tv-panel"
            x-data="{ items: @js($galeri), i: 0, x0: null,
                      go(d) { if (!this.items.length) return; this.i = (this.i + d + this.items.length) % this.items.length; try { sessionStorage.tvGaleri = this.i } catch (e) {} } }"
            x-init="try { i = (+sessionStorage.tvGaleri || 0) % (items.length || 1) } catch (e) {}; setInterval(() => go(1), 8000)"
            @keydown.left.window="go(-1)" @keydown.right.window="go(1)">
            <div class="tv-panel__head">
                <h2 class="tv-panel__judul"><span class="ds-stat__icon ds-stat__icon--success"><i class="fa-solid fa-images"></i></span> Galeri Dokumentasi</h2>
                <span class="ds-badge" x-show="items.length" x-text="(i + 1) + ' / ' + items.length"></span>
            </div>
            <template x-if="items.length">
                <div class="tv-galeri"
                    @touchstart="x0 = $event.touches[0].clientX"
                    @touchend="if (x0 !== null) { const dx = $event.changedTouches[0].clientX - x0; if (Math.abs(dx) > 40) go(dx < 0 ? 1 : -1); x0 = null }">
                    <img :src="items[i].src" :alt="items[i].judul">
                    <div class="tv-galeri__cap"><b x-text="items[i].judul"></b><span x-text="items[i].tanggal"></span></div>
                    <button type="button" @click="go(-1)" aria-label="Foto sebelumnya" class="tv-galeri__nav tv-galeri__nav--kiri"><i class="fa-solid fa-chevron-left"></i></button>
                    <button type="button" @click="go(1)" aria-label="Foto berikutnya" class="tv-galeri__nav tv-galeri__nav--kanan"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </template>
            <div class="tv-panel__isi" x-show="!items.length">
                <div class="ds-empty tv-kosong"><i class="fa-solid fa-image ds-icon"></i>Belum ada foto dokumentasi.</div>
            </div>
        </section>

    </main>
</div>
</body>
</html>
