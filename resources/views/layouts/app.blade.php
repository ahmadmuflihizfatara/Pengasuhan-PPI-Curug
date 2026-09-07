<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pengasuhan PPI Curug') }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: transparent !important;
            color: #0f172a;
            min-height: 100vh;
            position: relative;
        }

        /* Fixed blurred cockpit background container */
        #global-cockpit-bg-layer {
            position: fixed;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            background-image: url('{{ asset('images/BG.png') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            filter: blur(4px) brightness(0.92);
            transform: scale(1.04);
            z-index: -10;
            pointer-events: none;
        }

        /* Subtle radial dark overlay for high contrast */
        #global-cockpit-overlay-layer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.35) 100%);
            z-index: -9;
            pointer-events: none;
        }

        #app {
            padding: 0;
            margin: 0;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    {{-- Global Blurred Cockpit Background Layers --}}
    <div id="global-cockpit-bg-layer"></div>
    <div id="global-cockpit-overlay-layer"></div>

    <div id="app">
        {{ $slot }}
    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Alpine.js (menu dropdown, modal, mobile drawer) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>

    {{-- Global: handle delete-user buttons --}}
    <script>
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.js-delete-user');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        var userName = btn.getAttribute('data-user-name');
        var deleteUrl = btn.getAttribute('data-delete-url');
        if (!confirm('Hapus akun ' + userName + '?')) return;
        var csrfMeta = document.querySelector('meta[name="csrf-token"]');
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        form.style.display = 'none';
        var t = document.createElement('input');
        t.type = 'hidden'; t.name = '_token'; t.value = csrfMeta ? csrfMeta.content : '';
        form.appendChild(t);
        var m = document.createElement('input');
        m.type = 'hidden'; m.name = '_method'; m.value = 'DELETE';
        form.appendChild(m);
        document.body.appendChild(form);
        form.submit();
    });
    </script>

    {{-- Per-page scripts (outside #app so Vue doesn't interfere) --}}
    @stack('scripts')
</body>
</html>
