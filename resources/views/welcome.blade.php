<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PPI Curug — Politeknik Penerbangan Indonesia</title>

        @auth
        {{-- Redirect langsung ke dashboard jika sudah login --}}
        <meta http-equiv="refresh" content="0;url={{ url('/dashboard') }}">
        @endauth

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <style>
            *, ::before, ::after { box-sizing: border-box; margin: 0; padding: 0; }

            html, body {
                width: 100%;
                height: 100%;
                overflow-x: hidden;
            }

            body {
                font-family: 'Figtree', sans-serif;
                min-height: 100vh;
                background: #0f172a;
                color: #fff;
                -webkit-font-smoothing: antialiased;
                display: block;
            }

            /* ── Background ── */
            .bg-scene {
                position: fixed;
                inset: 0;
                background:
                    radial-gradient(ellipse 80% 60% at 50% 0%, rgba(30, 58, 138, 0.55) 0%, transparent 70%),
                    radial-gradient(ellipse 50% 40% at 80% 80%, rgba(234, 179, 8, 0.08) 0%, transparent 60%),
                    #0f172a;
                z-index: 0;
                pointer-events: none;
            }

            /* subtle dot grid */
            .bg-scene::after {
                content: '';
                position: absolute;
                inset: 0;
                background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
                background-size: 28px 28px;
            }

            /* ── Layout ── */
            .page-wrapper {
                position: relative;
                z-index: 1;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                width: 100%;
            }

            /* ── Navbar ── */
            .welcome-nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.25rem 2rem;
                border-bottom: 1px solid rgba(255,255,255,0.06);
                backdrop-filter: blur(12px);
                background: rgba(15, 23, 42, 0.5);
                position: sticky;
                top: 0;
                z-index: 50;
                width: 100%;
            }

            .nav-brand {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .nav-logo {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 50%;
                object-fit: cover;
                box-shadow: 0 0 0 2px rgba(234,179,8,0.4);
            }

            .nav-title {
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                line-height: 1.3;
                color: #fbbf24;
            }

            .nav-title span { color: #fff; }

            .nav-actions { display: flex; align-items: center; gap: 1rem; }

            .btn-nav-secondary {
                font-size: 0.8rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: rgba(255,255,255,0.75);
                text-decoration: none;
                padding: 0.45rem 1rem;
                border: 1px solid rgba(255,255,255,0.18);
                border-radius: 0.5rem;
                transition: all 0.2s;
            }

            .btn-nav-secondary:hover {
                color: #fff;
                border-color: rgba(255,255,255,0.4);
                background: rgba(255,255,255,0.06);
            }

            .btn-nav-primary {
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: #0f172a;
                text-decoration: none;
                padding: 0.5rem 1.25rem;
                border-radius: 0.5rem;
                background: #fbbf24;
                transition: all 0.2s;
                display: flex;
                align-items: center;
                gap: 0.4rem;
            }

            .btn-nav-primary:hover { background: #f59e0b; transform: translateY(-1px); }

            /* ── Hero ── */
            .hero {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 5rem 1.5rem 4rem;
            }

            .hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.72rem;
                font-weight: 600;
                letter-spacing: 0.15em;
                text-transform: uppercase;
                color: #fbbf24;
                background: rgba(234,179,8,0.1);
                border: 1px solid rgba(234,179,8,0.25);
                padding: 0.4rem 1rem;
                border-radius: 9999px;
                margin-bottom: 2rem;
            }

            .hero h1 {
                font-size: clamp(2rem, 6vw, 4.5rem);
                font-weight: 800;
                line-height: 1.1;
                letter-spacing: -0.02em;
                max-width: 850px;
                margin-bottom: 1.5rem;
            }

            .hero h1 .accent { color: #fbbf24; }

            .hero p {
                font-size: 1.05rem;
                line-height: 1.75;
                color: rgba(255,255,255,0.6);
                max-width: 560px;
                margin-bottom: 2.5rem;
            }

            .hero-cta {
                display: flex;
                align-items: center;
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            .btn-primary-lg {
                display: inline-flex;
                align-items: center;
                gap: 0.6rem;
                font-size: 0.9rem;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: #0f172a;
                text-decoration: none;
                padding: 0.9rem 2rem;
                border-radius: 0.65rem;
                background: linear-gradient(135deg, #fbbf24, #f59e0b);
                box-shadow: 0 8px 30px rgba(251,191,36,0.35);
                transition: all 0.25s;
            }

            .btn-primary-lg:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 36px rgba(251,191,36,0.45);
            }

            .btn-ghost-lg {
                display: inline-flex;
                align-items: center;
                gap: 0.6rem;
                font-size: 0.9rem;
                font-weight: 600;
                letter-spacing: 0.06em;
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                padding: 0.9rem 1.75rem;
                border-radius: 0.65rem;
                border: 1px solid rgba(255,255,255,0.18);
                transition: all 0.25s;
            }

            .btn-ghost-lg:hover {
                color: #fff;
                border-color: rgba(255,255,255,0.35);
                background: rgba(255,255,255,0.06);
            }

            /* ── Stats Strip ── */
            .stats-strip {
                display: flex;
                justify-content: center;
                gap: 3rem;
                flex-wrap: wrap;
                margin-top: 3rem;
                padding: 1.5rem 2rem;
                border-top: 1px solid rgba(255,255,255,0.07);
                border-bottom: 1px solid rgba(255,255,255,0.07);
                width: 100%;
                max-width: 700px;
            }

            .stat-item { text-align: center; }

            .stat-value {
                font-size: 1.75rem;
                font-weight: 800;
                color: #fbbf24;
                line-height: 1;
            }

            .stat-label {
                font-size: 0.72rem;
                font-weight: 600;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: rgba(255,255,255,0.45);
                margin-top: 0.3rem;
            }

            /* ── Features Section ── */
            .features {
                padding: 5rem 2rem;
                max-width: 1100px;
                margin: 0 auto;
                width: 100%;
            }

            .section-label {
                text-align: center;
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: #fbbf24;
                margin-bottom: 1rem;
            }

            .section-title {
                text-align: center;
                font-size: clamp(1.5rem, 3vw, 2.25rem);
                font-weight: 800;
                margin-bottom: 3.5rem;
                color: #fff;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .feature-card {
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 1.25rem;
                padding: 2rem;
                transition: all 0.3s;
            }

            .feature-card:hover {
                background: rgba(255,255,255,0.07);
                border-color: rgba(251,191,36,0.2);
                transform: translateY(-3px);
            }

            .feature-icon {
                width: 3rem;
                height: 3rem;
                background: rgba(234,179,8,0.12);
                border-radius: 0.75rem;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.25rem;
                color: #fbbf24;
            }

            .feature-icon svg { width: 1.4rem; height: 1.4rem; }

            .feature-card h3 {
                font-size: 1rem;
                font-weight: 700;
                margin-bottom: 0.6rem;
                color: #fff;
            }

            .feature-card p {
                font-size: 0.875rem;
                line-height: 1.65;
                color: rgba(255,255,255,0.5);
            }

            /* ── CTA Banner ── */
            .cta-banner {
                max-width: 900px;
                margin: 0 auto 5rem;
                padding: 0 2rem;
                width: 100%;
            }

            .cta-inner {
                background: linear-gradient(135deg, rgba(30,58,138,0.6) 0%, rgba(15,23,42,0.8) 100%);
                border: 1px solid rgba(251,191,36,0.2);
                border-radius: 1.5rem;
                padding: 3rem 2.5rem;
                text-align: center;
                backdrop-filter: blur(12px);
            }

            .cta-inner h2 {
                font-size: clamp(1.4rem, 3vw, 2rem);
                font-weight: 800;
                margin-bottom: 0.75rem;
            }

            .cta-inner p {
                color: rgba(255,255,255,0.55);
                font-size: 0.95rem;
                margin-bottom: 2rem;
            }

            .cta-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            /* ── Footer ── */
            .welcome-footer {
                text-align: center;
                padding: 1.5rem;
                font-size: 0.8rem;
                color: rgba(255,255,255,0.25);
                border-top: 1px solid rgba(255,255,255,0.06);
                width: 100%;
            }

            /* ── Responsive ── */
            @media (max-width: 640px) {
                .welcome-nav { padding: 1rem; }
                .nav-title { display: none; }
                .hero { padding: 3rem 1.25rem 2.5rem; }
                .stats-strip { gap: 2rem; }
                .cta-banner { padding: 0 1rem; }
                .cta-inner { padding: 2rem 1.5rem; }
                .features { padding: 3rem 1.25rem; }
            }
        </style>
    </head>
    <body>

        <div class="bg-scene"></div>

        <div class="page-wrapper">

            {{-- ── Navbar ── --}}
            <nav class="welcome-nav">
                <div class="nav-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PPI Curug" class="nav-logo">
                    <div class="nav-title">
                        Politeknik Penerbangan Indonesia<br>
                        <span>Curug</span>
                    </div>
                </div>

                <div class="nav-actions">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-nav-secondary">Daftar</a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn-nav-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:1rem;height:1rem">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                            Masuk ke Kokpit
                        </a>
                    @endif
                </div>
            </nav>

            {{-- ── Hero ── --}}
            <section class="hero">
                <div class="hero-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:0.85rem;height:0.85rem">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                    Sistem Informasi Karir Penerbangan
                </div>

                <h1>
                    WUJUDKAN KARIR<br>
                    <span class="accent">PILOT PROFESIONAL</span><br>
                    ANDA BERSAMA KAMI
                </h1>

                <p>
                    Platform resmi Politeknik Penerbangan Indonesia Curug untuk manajemen pendidikan,
                    pemantauan progres kadet, dan informasi program penerbangan kelas dunia.
                </p>

                <div class="hero-cta">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn-primary-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:1.1rem;height:1.1rem">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                            Masuk ke Kokpit
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-ghost-lg">
                            Daftar Sebagai Kadet
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:1rem;height:1rem">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @endif
                </div>

                {{-- Stats Strip --}}
                <div class="stats-strip">
                    <div class="stat-item">
                        <div class="stat-value">50+</div>
                        <div class="stat-label">Tahun Berpengalaman</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">10K+</div>
                        <div class="stat-label">Alumni Aktif</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">15+</div>
                        <div class="stat-label">Program Studi</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">100%</div>
                        <div class="stat-label">Terakreditasi</div>
                    </div>
                </div>
            </section>

            {{-- ── Features ── --}}
            <section class="features">
                <div class="section-label">Fitur Unggulan</div>
                <h2 class="section-title">Semua yang Anda Butuhkan<br>dalam Satu Platform</h2>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                            </svg>
                        </div>
                        <h3>Manajemen Data Kadet</h3>
                        <p>Kelola profil, dokumen, dan riwayat pendidikan setiap kadet secara terpusat dan aman.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3>Pemantauan Progres</h3>
                        <p>Pantau kemajuan jam terbang, nilai akademik, dan pencapaian sertifikasi secara real-time.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <h3>Jadwal & Penugasan</h3>
                        <p>Akses jadwal kuliah, jadwal terbang, dan penugasan instruktur dalam satu tampilan terpadu.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>
                        <h3>Laporan & Analitik</h3>
                        <p>Buat laporan kinerja kadet dan statistik program secara otomatis dengan visualisasi data.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <h3>Keamanan Data</h3>
                        <p>Sistem autentikasi berlapis dan enkripsi data memastikan informasi kadet terlindungi sepenuhnya.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                            </svg>
                        </div>
                        <h3>Informasi Program</h3>
                        <p>Temukan informasi lengkap mengenai program studi, persyaratan, biaya, dan jadwal pendaftaran.</p>
                    </div>
                </div>
            </section>

            {{-- ── CTA Banner ── --}}
            <div class="cta-banner">
                <div class="cta-inner">
                    <h2>Siap Memulai Perjalanan Anda?</h2>
                    <p>Bergabunglah dengan ribuan kadet yang telah mempercayakan pendidikan penerbangan mereka bersama PPI Curug.</p>
                    <div class="cta-buttons">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary-lg">
                                Daftar Sekarang — Gratis
                            </a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn-ghost-lg">Sudah punya akun? Masuk</a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Footer ── --}}
            <footer class="welcome-footer">
                &copy; {{ date('Y') }} Politeknik Penerbangan Indonesia Curug. Hak cipta dilindungi.
            </footer>

        </div>

    </body>
</html>
