<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PPI Curug — Sistem Pengasuhan & Karakter Taruna</title>

    @auth
    {{-- Redirect langsung ke dashboard jika sudah login --}}
    <meta http-equiv="refresh" content="0;url={{ url('/dashboard') }}">
    @endauth

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body { margin: 0; min-height: 100vh; font-family: var(--font-sans); color: var(--ink-900); background: var(--ground-cockpit); overflow-x: hidden; -webkit-font-smoothing: antialiased; }
        #bg { position: fixed; inset: -20px; background: url('{{ asset('assets/img/auth-bg.jpg') }}') center/cover no-repeat; filter: blur(4px) brightness(.92); transform: scale(1.04); z-index: -10; }
        #bg-ov { position: fixed; inset: 0; background: radial-gradient(circle at 50% 35%, rgba(15,23,42,.45), rgba(15,23,42,.82)); z-index: -9; }
        .lp { max-width: 1152px; margin: 0 auto; padding: var(--space-4); }
        .lp-nav .ds-brand { background: rgba(255,255,255,.18); border-color: rgba(255,255,255,.3); padding: var(--space-3) var(--space-6) var(--space-3) var(--space-4); gap: var(--space-4); color: var(--ink-on-dark); }
        .lp-logo { height: 44px; width: auto; filter: drop-shadow(0 2px 6px rgba(0,0,0,.35)); }
        .lp-nav .ds-brand__name { font-size: 15px; letter-spacing: 0; margin-bottom: 4px; }
        .lp-nav .ds-brand__sub { font-size: 11px; font-weight: 700; letter-spacing: .08em; color: #7dd3fc; }
        .lp-nav { display: flex; align-items: center; justify-content: center; margin-bottom: var(--space-12); }
        .lp-hero { text-align: center; max-width: 820px; margin: 0 auto var(--space-12); color: var(--ink-on-dark); }
        .lp-hero h1 { font-family: var(--font-serif); font-weight: 400; letter-spacing: -.02em; line-height: 1.08; font-size: clamp(36px, 7vw, 68px); margin: var(--space-4) 0; text-shadow: 0 4px 24px rgba(0,0,0,.6); }
        .lp-hero p { margin: 0 auto var(--space-8); max-width: 640px; font-size: 16px; line-height: 26px; color: var(--ink-on-dark-muted); }
        .lp-hero .ds-eyebrow { margin: 0; }
        .lp-cta { display: flex; flex-wrap: wrap; justify-content: center; gap: var(--space-3); }
        .lp-grid { display: grid; gap: var(--space-4); grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); }
        .lp-foot { text-align: center; padding: var(--space-6) var(--space-4); font-size: 12px; font-weight: 500; color: var(--ink-on-dark-muted); }
    </style>
</head>
<body>
    <div id="bg"></div><div id="bg-ov"></div>

    <div class="lp">
        <nav class="lp-nav">
            <a href="{{ url('/') }}" class="ds-brand">
                <img src="{{ asset('assets/img/logo-ppi.png') }}" alt="Logo PPI Curug" class="lp-logo">
                <span><span class="ds-brand__name" style="display:block">PPI Curug</span><span class="ds-brand__sub">Pengasuhan Taruna</span></span>
            </a>
        </nav>

        <header class="lp-hero">
            <h1>Keunggulan Disiplin untuk Pemimpin Masa Depan</h1>
            <p>Platform terpadu Politeknik Penerbangan Indonesia Curug untuk manajemen kedisiplinan, pemantauan pos jaga real-time, raport poin, perizinan asrama, dan pembinaan karakter taruna.</p>
            <div class="lp-cta">
                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="ds-btn ds-btn--primary ds-btn--pill" style="padding:14px 32px">Masuk ke Sistem Pengasuhan <i class="fa-solid fa-arrow-right ds-icon"></i></a>
                @endif
                <a href="#fitur" class="ds-btn ds-btn--pill" style="padding:14px 28px">Pelajari 4 Pilar</a>
            </div>
        </header>

        <main id="fitur" class="ds-workspace">
            <div class="ds-row" style="justify-content:space-between;padding-bottom:var(--space-4);margin-bottom:var(--space-5);border-bottom:1px solid var(--border-glass-subtle)">
                <h2 class="ds-card__title"><i class="fa-solid fa-cubes ds-icon"></i> 4 Pilar Utama Pengasuhan</h2>
                <span class="ds-badge ds-badge--success"><span class="ds-dot ds-dot--pulse"></span> Sistem Aktif &amp; Terintegrasi</span>
            </div>

            <div class="lp-grid">
                <div class="ds-card ds-card--interactive">
                    <span class="ds-stat__icon" style="margin-bottom:var(--space-4)"><i class="fa-solid fa-shield-halved ds-icon"></i></span>
                    <h3 class="ds-card__title" style="margin-bottom:var(--space-1-5)">Raport Poin Disiplin</h3>
                    <p class="ds-card__desc" style="font-size:12px;line-height:18px">Pencatatan transparan poin pelanggaran dan penghargaan taruna berbasis tingkatan sanksi resmi pengasuhan.</p>
                </div>
                <div class="ds-card ds-card--interactive">
                    <span class="ds-stat__icon" style="margin-bottom:var(--space-4)"><i class="fa-solid fa-compass ds-icon"></i></span>
                    <h3 class="ds-card__title" style="margin-bottom:var(--space-1-5)">Pos Jaga & Log Pergerakan</h3>
                    <p class="ds-card__desc" style="font-size:12px;line-height:18px">Pemantauan arus keluar masuk taruna di gerbang utama secara real-time via tablet.</p>
                </div>
                <div class="ds-card ds-card--interactive">
                    <span class="ds-stat__icon ds-stat__icon--success" style="margin-bottom:var(--space-4)"><i class="fa-solid fa-clipboard-check ds-icon"></i></span>
                    <h3 class="ds-card__title" style="margin-bottom:var(--space-1-5)">Apel & Presensi Harian</h3>
                    <p class="ds-card__desc" style="font-size:12px;line-height:18px">Perekaman kehadiran apel pagi, siang, dan malam per barak dengan rekap otomatis dan berita acara digital.</p>
                </div>
                <div class="ds-card ds-card--interactive">
                    <span class="ds-stat__icon ds-stat__icon--warning" style="margin-bottom:var(--space-4)"><i class="fa-solid fa-envelope-open-text ds-icon"></i></span>
                    <h3 class="ds-card__title" style="margin-bottom:var(--space-1-5)">Surat Izin & Barak</h3>
                    <p class="ds-card__desc" style="font-size:12px;line-height:18px">Pengajuan izin bermalam digital, pelaporan keluhan fasilitas barak, dan approval bertingkat pengasuh.</p>
                </div>
            </div>

            <div class="lp-grid" style="margin-top:var(--space-8)">
                <div class="ds-stat">
                    <div class="ds-stat__top"><span class="ds-stat__label">Tahun Pengalaman</span><span class="ds-stat__icon"><i class="fa-solid fa-medal ds-icon"></i></span></div>
                    <div class="ds-stat__value">50+</div>
                </div>
                <div class="ds-stat">
                    <div class="ds-stat__top"><span class="ds-stat__label">Terakreditasi Unggul</span><span class="ds-stat__icon ds-stat__icon--success"><i class="fa-solid fa-award ds-icon"></i></span></div>
                    <div class="ds-stat__value">100%</div>
                </div>
                <div class="ds-stat">
                    <div class="ds-stat__top"><span class="ds-stat__label">Pengawasan Pos Jaga</span><span class="ds-stat__icon ds-stat__icon--warning"><i class="fa-solid fa-clock ds-icon"></i></span></div>
                    <div class="ds-stat__value">24/7</div>
                </div>
                <div class="ds-stat">
                    <div class="ds-stat__top"><span class="ds-stat__label">Alumni Berprestasi</span><span class="ds-stat__icon"><i class="fa-solid fa-user-graduate ds-icon"></i></span></div>
                    <div class="ds-stat__value">Ribuan</div>
                </div>
            </div>
        </main>

        <footer class="lp-foot">&copy; {{ date('Y') }} Politeknik Penerbangan Indonesia Curug. Hak cipta dilindungi undang-undang.</footer>
    </div>
</body>
</html>
