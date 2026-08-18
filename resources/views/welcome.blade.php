<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PPI Curug — Politeknik Penerbangan Indonesia</title>
    @auth
    <meta http-equiv="refresh" content="0;url={{ url('/dashboard') }}">
    @endauth

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        *, ::before, ::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { width: 100%; height: 100%; overflow-x: hidden; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0c1c2b;
            color: #fff;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══════════════════════════════════════
           INTRO — Full-Screen Airplane Animation
           ═══════════════════════════════════════ */
        .intro-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: linear-gradient(180deg, #070e1a 0%, #0c1c2b 40%, #12283a 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 1s ease, visibility 1s ease;
        }
        .intro-overlay.done {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* Stars in intro */
        .intro-overlay::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 8% 15%, rgba(255,255,255,.5) 0%, transparent 100%),
                radial-gradient(1px 1px at 22% 55%, rgba(255,255,255,.35) 0%, transparent 100%),
                radial-gradient(1px 1px at 40% 8%, rgba(255,255,255,.6) 0%, transparent 100%),
                radial-gradient(1px 1px at 55% 42%, rgba(255,255,255,.25) 0%, transparent 100%),
                radial-gradient(1px 1px at 70% 70%, rgba(255,255,255,.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 85% 25%, rgba(255,255,255,.45) 0%, transparent 100%),
                radial-gradient(1px 1px at 15% 80%, rgba(255,255,255,.3) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 30% 30%, rgba(253,187,17,.35) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 75% 18%, rgba(253,187,17,.25) 0%, transparent 100%),
                radial-gradient(1px 1px at 50% 90%, rgba(255,255,255,.2) 0%, transparent 100%),
                radial-gradient(1px 1px at 92% 55%, rgba(255,255,255,.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 5% 50%, rgba(255,255,255,.2) 0%, transparent 100%);
            pointer-events: none;
        }

        /* Logo di intro */
        .intro-logo {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            opacity: 0;
            animation: introLogoIn 1s ease-out 3.5s forwards;
        }
        @keyframes introLogoIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .intro-logo img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2px solid rgba(253,187,17,.4);
            box-shadow: 0 0 40px rgba(253,187,17,.15);
            object-fit: cover;
        }
        .intro-logo .intro-name {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255,255,255,.6);
        }
        .intro-logo .intro-name span { color: #fdbb11; }

        /* ═══ Airplane Terbang ═══ */
        .intro-airplane {
            position: absolute;
            top: 50%;
            left: -300px;
            transform: translateY(-50%) rotate(-5deg);
            z-index: 3;
            animation: flyAcross 3s cubic-bezier(.25,.1,.25,1) forwards;
        }
        @keyframes flyAcross {
            0% {
                left: -300px;
                top: 55%;
                opacity: 0;
                transform: translateY(-50%) rotate(-5deg) scale(.6);
            }
            10% {
                opacity: 1;
            }
            50% {
                top: 42%;
                transform: translateY(-50%) rotate(2deg) scale(1);
            }
            90% {
                opacity: 1;
            }
            100% {
                left: calc(100% + 300px);
                top: 38%;
                opacity: 0;
                transform: translateY(-50%) rotate(-2deg) scale(.8);
            }
        }

        .intro-airplane svg {
            width: 220px;
            height: 160px;
            filter: drop-shadow(0 15px 35px rgba(0,0,0,.6));
        }

        /* Trail pesawat */
        .intro-trail {
            position: absolute;
            top: 50%;
            right: 100%;
            width: 250px;
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(253,187,17,.15), rgba(253,187,17,.5));
            border-radius: 4px;
            filter: blur(1.5px);
            transform: translateY(-50%);
        }

        /* Condensation trail (awan tipis) */
        .intro-condensation {
            position: absolute;
            top: 50%;
            right: 100%;
            width: 400px;
            height: 8px;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.02) 30%, rgba(255,255,255,.06) 60%, rgba(255,255,255,.03) 100%);
            border-radius: 8px;
            filter: blur(4px);
            transform: translateY(-50%);
        }

        /* Loading text */
        .intro-loading {
            position: relative;
            z-index: 2;
            margin-top: 4rem;
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(255,255,255,.25);
            opacity: 0;
            animation: introLogoIn .8s ease-out 1s forwards;
        }
        .intro-loading .dots::after {
            content: '';
            animation: dots 1.5s steps(4,end) infinite;
        }
        @keyframes dots {
            0%   { content: ''; }
            25%  { content: '.'; }
            50%  { content: '..'; }
            75%  { content: '...'; }
            100% { content: ''; }
        }

        /* ═══════════════════════════════════════
           MAIN CONTENT — Login + Features
           ═══════════════════════════════════════ */
        .main-content {
            opacity: 0;
            transition: opacity 1s ease;
        }
        .main-content.visible {
            opacity: 1;
        }

        /* ═══ NAVBAR ═══ */
        .welcome-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2.5rem;
            background: rgba(12,28,43,.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,.05);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .nav-brand { display: flex; align-items: center; gap: .75rem; }
        .nav-logo {
            width: 2.2rem; height: 2.2rem;
            border-radius: 50%; object-fit: cover;
            border: 2px solid rgba(253,187,17,.3);
        }
        .nav-title {
            font-size: .65rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            line-height: 1.3; color: #fdbb11;
        }
        .nav-title span { color: rgba(255,255,255,.7); }
        .nav-actions { display: flex; gap: .75rem; }
        .nav-btn {
            font-size: .75rem; font-weight: 700; letter-spacing: .08em;
            text-transform: uppercase; text-decoration: none;
            padding: .5rem 1.25rem; border-radius: 9999px;
            transition: all .2s;
        }
        .nav-btn-primary { background: #fdbb11; color: #0c1c2b; }
        .nav-btn-primary:hover { background: #e5a800; }
        .nav-btn-ghost { border: 1px solid rgba(255,255,255,.15); color: rgba(255,255,255,.6); }
        .nav-btn-ghost:hover { color: #fff; border-color: rgba(255,255,255,.3); }

        /* ═══ HERO ═══ */
        .hero {
            position: relative;
            width: 100%;
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 5rem 2rem 4rem;
            background: linear-gradient(180deg, #0c1c2b 0%, #12283a 100%);
            overflow: hidden;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            font-size: .68rem; font-weight: 700; letter-spacing: .15em;
            text-transform: uppercase; color: #fdbb11;
            background: rgba(253,187,17,.08);
            border: 1px solid rgba(253,187,17,.2);
            padding: .4rem 1.2rem; border-radius: 9999px;
            margin-bottom: 1.5rem;
        }
        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 800; line-height: 1.15;
            letter-spacing: -.02em;
            max-width: 700px; margin-bottom: 1rem;
        }
        .hero h1 .accent { color: #fdbb11; }
        .hero p {
            font-size: .95rem; line-height: 1.75;
            color: rgba(255,255,255,.45);
            max-width: 500px; margin: 0 auto 2.5rem;
        }
        .hero-cta { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-gold {
            display: inline-flex; align-items: center; gap: .5rem;
            font-size: .8rem; font-weight: 700; letter-spacing: .08em;
            text-transform: uppercase; text-decoration: none;
            padding: .8rem 2rem; border-radius: 9999px;
            background: #fdbb11; color: #0c1c2b;
            transition: all .25s;
        }
        .btn-gold:hover { background: #e5a800; transform: translateY(-2px); }
        .btn-ghost {
            display: inline-flex; align-items: center; gap: .5rem;
            font-size: .8rem; font-weight: 600; text-decoration: none;
            padding: .8rem 2rem; border-radius: 9999px;
            border: 1px solid rgba(255,255,255,.15);
            color: rgba(255,255,255,.6);
            transition: all .25s;
        }
        .btn-ghost:hover { color: #fff; border-color: rgba(255,255,255,.3); background: rgba(255,255,255,.04); }

        /* ═══ LOGIN SECTION ═══ */
        .login-section {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #12283a 0%, #0c1c2b 100%);
            padding: 4rem 2rem;
        }
        .login-card {
            position: relative; z-index: 2;
            width: 100%; max-width: 960px;
            display: flex;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.06);
            background: rgba(255,255,255,.02);
        }

        /* Left panel */
        .login-left {
            flex: 0 0 42%;
            background: url('{{ asset("images/cockpit-bg.jpg") }}') center/cover no-repeat;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(18,40,58,.88) 0%, rgba(12,28,43,.95) 100%);
        }
        .login-left-content { position: relative; z-index: 2; text-align: center; }
        .login-logo {
            width: 80px; height: 80px; border-radius: 50%;
            object-fit: cover; border: 3px solid rgba(253,187,17,.4);
            box-shadow: 0 0 40px rgba(253,187,17,.15);
            margin-bottom: 1.5rem;
        }
        .login-left h2 {
            font-size: 1.1rem; font-weight: 800;
            letter-spacing: .08em; text-transform: uppercase;
            margin-bottom: .5rem; color: #fff;
        }
        .login-left h2 .gold { color: #fdbb11; }
        .login-left p {
            font-size: .8rem; color: rgba(255,255,255,.35);
            line-height: 1.6; max-width: 260px; margin: 0 auto;
        }
        .login-airplane {
            position: absolute; bottom: 30px; right: -15px;
            opacity: .06; transform: rotate(-15deg); pointer-events: none;
        }

        /* Right panel */
        .login-right {
            flex: 1; background: #eef3f9;
            padding: 3rem; display: flex; flex-direction: column; justify-content: center;
        }
        .login-right h1 { font-size: 1.5rem; font-weight: 800; color: #12283a; margin-bottom: .3rem; }
        .login-right .subtitle { font-size: .85rem; color: #6b7c93; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label {
            display: block; font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            color: #6b7c93; margin-bottom: .4rem;
        }
        .form-input-wrap { position: relative; display: flex; align-items: center; }
        .form-input-wrap .icon {
            position: absolute; left: 14px; color: #6b7c93;
            font-size: 14px; pointer-events: none;
        }
        .form-input {
            width: 100%; padding: .8rem 1rem .8rem 2.8rem;
            border: 1.5px solid #d4dbe5; border-radius: 12px;
            font-size: .875rem; font-family: 'Inter',sans-serif;
            color: #12283a; background: #fff; outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus { border-color: #12283a; box-shadow: 0 0 0 3px rgba(18,40,58,.08); }
        .form-input::placeholder { color: #b0b8c5; }
        .form-check {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 1.5rem;
        }
        .form-check label { display: flex; align-items: center; gap: .4rem; font-size: .8rem; color: #6b7c93; cursor: pointer; }
        .form-check a { font-size: .8rem; font-weight: 700; color: #12283a; text-decoration: none; }
        .form-check a:hover { color: #fdbb11; }
        .btn-login {
            width: 100%; padding: .85rem; border: none;
            border-radius: 9999px; background: #12283a; color: #fff;
            font-size: .85rem; font-weight: 700; font-family: 'Inter',sans-serif;
            letter-spacing: .06em; text-transform: uppercase;
            cursor: pointer; transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
        }
        .btn-login:hover { background: #fdbb11; color: #0c1c2b; transform: translateY(-1px); }
        .btn-login .gold-icon { color: #fdbb11; transition: color .2s; }
        .btn-login:hover .gold-icon { color: #0c1c2b; }
        .login-footer { text-align: center; margin-top: 1.5rem; font-size: .8rem; color: #6b7c93; }
        .login-footer a { font-weight: 700; color: #12283a; text-decoration: none; }
        .login-footer a:hover { color: #fdbb11; }
        .error-msg {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #dc2626; padding: .6rem 1rem; border-radius: 10px;
            font-size: .8rem; margin-bottom: 1rem;
        }

        /* ═══ FEATURES ═══ */
        .features-section { background: #eef3f9; padding: 5rem 2rem; }
        .features-inner { max-width: 1000px; margin: 0 auto; }
        .section-label {
            text-align: center; font-size: .7rem; font-weight: 700;
            letter-spacing: .2em; text-transform: uppercase;
            color: #fdbb11; background: #12283a;
            display: inline-block; padding: .3rem 1rem;
            border-radius: 9999px; margin: 0 auto 1rem;
        }
        .section-title {
            text-align: center; font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 800; color: #12283a; margin-bottom: .5rem;
        }
        .section-desc {
            text-align: center; font-size: .9rem; color: #6b7c93;
            margin-bottom: 3rem; max-width: 500px; margin-left: auto; margin-right: auto;
        }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .feature-card {
            background: #fff; border: 1px solid #d4dbe5;
            border-radius: 16px; padding: 2rem; transition: all .3s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(18,40,58,.08); border-color: #fdbb11; }
        .feature-icon {
            width: 48px; height: 48px; background: rgba(18,40,58,.06);
            border-radius: 12px; display: flex; align-items: center;
            justify-content: center; margin-bottom: 1rem;
            color: #12283a; font-size: 20px;
        }
        .feature-card h3 { font-size: .95rem; font-weight: 700; color: #12283a; margin-bottom: .4rem; }
        .feature-card p { font-size: .8rem; line-height: 1.65; color: #6b7c93; }

        /* ═══ STATS ═══ */
        .stats-section { background: #12283a; padding: 4rem 2rem; }
        .stats-inner {
            max-width: 900px; margin: 0 auto;
            display: flex; justify-content: space-around;
            flex-wrap: wrap; gap: 2rem;
        }
        .stat-item { text-align: center; }
        .stat-value { font-size: 2rem; font-weight: 800; color: #fdbb11; }
        .stat-label {
            font-size: .7rem; font-weight: 600; letter-spacing: .1em;
            text-transform: uppercase; color: rgba(255,255,255,.35); margin-top: .2rem;
        }

        /* ═══ FOOTER ═══ */
        .welcome-footer {
            text-align: center; padding: 1.5rem; font-size: .75rem;
            color: rgba(255,255,255,.25); background: #070e1a;
        }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 768px) {
            .login-card { flex-direction: column; }
            .login-left { flex: none; padding: 2rem; min-height: auto; }
            .features-grid { grid-template-columns: 1fr; }
            .intro-airplane svg { width: 140px; height: 100px; }
        }
    </style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     INTRO — Animasi Pesawat Terbang
     ═══════════════════════════════════════════ -->
<div class="intro-overlay" id="introOverlay">

    <!-- Logo muncul setelah pesawat lewat -->
    <div class="intro-logo">
        <img src="{{ asset('images/logo.png') }}" alt="PPI Curug">
        <div class="intro-name">
            Politeknik Penerbangan Indonesia<br>
            <span>Curug</span>
        </div>
    </div>

    <div class="intro-loading">Memuat Sistem<span class="dots"></span></div>

    <!-- Airplane terbang dari kiri ke kanan -->
    <div class="intro-airplane">
        <div class="intro-condensation"></div>
        <div class="intro-trail"></div>
        <svg viewBox="0 0 280 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Body -->
            <ellipse cx="160" cy="100" rx="85" ry="14" fill="rgba(255,255,255,.9)"/>
            <!-- Nose -->
            <path d="M245 100 L272 97 Q278 100 272 103 L245 100Z" fill="rgba(255,255,255,.85)"/>
            <!-- Cockpit -->
            <path d="M230 94 L250 98 Q252 100 250 102 L230 106Z" fill="rgba(253,187,17,.2)"/>
            <!-- Upper wing -->
            <path d="M145 100 L95 48 L115 43 L185 92Z" fill="rgba(253,187,17,.7)"/>
            <!-- Lower wing -->
            <path d="M145 100 L95 152 L115 157 L185 108Z" fill="rgba(253,187,17,.55)"/>
            <!-- Tail horizontal -->
            <path d="M78 100 L52 68 L70 66 L92 92Z" fill="rgba(255,255,255,.55)"/>
            <path d="M78 100 L52 132 L70 134 L92 108Z" fill="rgba(255,255,255,.4)"/>
            <!-- Tail fin vertical -->
            <path d="M65 100 L48 75 L65 78 L82 95Z" fill="rgba(253,187,17,.5)"/>
            <path d="M65 100 L48 125 L65 122 L82 105Z" fill="rgba(253,187,17,.35)"/>
            <!-- Windows -->
            <circle cx="175" cy="96" r="3" fill="rgba(253,187,17,.6)"/>
            <circle cx="190" cy="96" r="3" fill="rgba(253,187,17,.5)"/>
            <circle cx="205" cy="96" r="3" fill="rgba(253,187,17,.4)"/>
            <circle cx="218" cy="97" r="2.5" fill="rgba(253,187,17,.35)"/>
            <!-- Engine glow -->
            <ellipse cx="125" cy="94" rx="7" ry="3" fill="rgba(253,187,17,.35)">
                <animate attributeName="rx" values="7;10;7" dur=".4s" repeatCount="indefinite"/>
            </ellipse>
            <ellipse cx="125" cy="106" rx="7" ry="3" fill="rgba(253,187,17,.35)">
                <animate attributeName="rx" values="7;10;7" dur=".4s" repeatCount="indefinite"/>
            </ellipse>
        </svg>
    </div>
</div>

<!-- ═══════════════════════════════════════════
     MAIN CONTENT — Muncul setelah intro selesai
     ═══════════════════════════════════════════ -->
<div class="main-content" id="mainContent">

    <!-- NAVBAR -->
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
                <a href="{{ route('register') }}" class="nav-btn nav-btn-ghost">Daftar</a>
            @endif
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="nav-btn nav-btn-primary">
                    <i class="fas fa-plane" style="font-size:.7rem;"></i> Masuk
                </a>
            @endif
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-badge">
            <i class="fas fa-plane"></i>
            Sistem Pengasuhan Penerbangan
        </div>
        <h1>Politeknik Penerbangan<br>Indonesia <span class="accent">Curug</span></h1>
        <p>Platform resmi manajemen pendidikan, pemantauan progres kadet, dan informasi program penerbangan kelas dunia.</p>
        <div class="hero-cta">
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn-gold">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
                </a>
            @endif
            <a href="#features" class="btn-ghost">Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features-section" id="features">
        <div class="features-inner">
            <div style="text-align:center;"><div class="section-label">Fitur Unggulan</div></div>
            <h2 class="section-title">Semua yang Anda Butuhkan</h2>
            <p class="section-desc">Satu platform untuk manajemen pendidikan penerbangan yang terintegrasi.</p>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-user-graduate"></i></div>
                    <h3>Manajemen Kadet</h3>
                    <p>Kelola profil, dokumen, dan riwayat pendidikan setiap kadet secara terpusat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Pemantauan Progres</h3>
                    <p>Pantau pencapaian poin, jadwal, dan aktivitas kadet secara real-time.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
                    <h3>Jadwal & Acara</h3>
                    <p>Akses jadwal kuliah, apel, dan penugasan dalam satu tampilan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-envelope-open-text"></i></div>
                    <h3>Administrasi Surat</h3>
                    <p>Ajukan dan kelola pengajuan surat secara digital.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-award"></i></div>
                    <h3>Sistem Reward</h3>
                    <p>Dapatkan penghargaan atas pencapaian dan prestasi akademik.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Keamanan Data</h3>
                    <p>Sistem autentikasi berlapis melindungi informasi kadet.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <section class="stats-section">
        <div class="stats-inner">
            <div class="stat-item"><div class="stat-value">50+</div><div class="stat-label">Tahun Berpengalaman</div></div>
            <div class="stat-item"><div class="stat-value">10K+</div><div class="stat-label">Alumni Aktif</div></div>
            <div class="stat-item"><div class="stat-value">15+</div><div class="stat-label">Program Studi</div></div>
            <div class="stat-item"><div class="stat-value">100%</div><div class="stat-label">Terakreditasi</div></div>
        </div>
    </section>

    <!-- LOGIN -->
    <section class="login-section" id="login">
        <div class="login-card">
            <div class="login-left">
                <div class="login-left-content">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PPI Curug" class="login-logo">
                    <h2><span class="gold">PPI</span> Curug</h2>
                    <p>Politeknik Penerbangan Indonesia Curug — mencetak pilot profesional kelas dunia.</p>
                </div>
                <div class="login-airplane">
                    <svg width="280" height="180" viewBox="0 0 280 180" fill="none">
                        <ellipse cx="170" cy="90" rx="85" ry="14" fill="white"/>
                        <path d="M140 90 L90 40 L110 35 L180 83Z" fill="rgba(253,187,17,.3)"/>
                        <path d="M140 90 L90 140 L110 145 L180 97Z" fill="rgba(253,187,17,.25)"/>
                        <path d="M78 90 L50 58 L68 56 L88 83Z" fill="white"/>
                        <path d="M78 90 L50 122 L68 124 L88 97Z" fill="rgba(255,255,255,.7)"/>
                    </svg>
                </div>
            </div>
            <div class="login-right">
                <h1>Masuk ke Sistem</h1>
                <p class="subtitle">Gunakan akun Anda untuk mengakses dashboard.</p>

                @if ($errors->any())
                    <div class="error-msg">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email atau Username</label>
                        <div class="form-input-wrap">
                            <i class="fas fa-envelope icon"></i>
                            <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus class="form-input" placeholder="contoh@ppicurug.ac.id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <div class="form-input-wrap">
                            <i class="fas fa-lock icon"></i>
                            <input id="password" type="password" name="password" required class="form-input" placeholder="Masukkan kata sandi">
                        </div>
                    </div>
                    <div class="form-check">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat saya
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Lupa kata sandi?</a>
                        @endif
                    </div>
                    <button type="submit" class="btn-login">
                        <i class="fas fa-plane gold-icon"></i> Masuk
                    </button>
                </form>
                <div class="login-footer">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="welcome-footer">
        &copy; {{ date('Y') }} Politeknik Penerbangan Indonesia Curug. Hak cipta dilindungi.
    </footer>
</div>

<script>
    // Setelah pesawat selesai terbang (~3.5s), fade out intro & tampilkan konten
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('introOverlay').classList.add('done');
            document.getElementById('mainContent').classList.add('visible');
        }, 4000);
    });
</script>

</body>
</html>
