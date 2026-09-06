<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pengasuhan PPI Curug') }}</title>

    {{-- Vite JS & CSS (Tailwind & Glassmorphism) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Auth stylesheet custom --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Fixed blurred cockpit background container (sama seperti landing page) */
        .global-cockpit-background {
            position: fixed;
            top: -20px;
            left: -20px;
            right: -20px;
            bottom: -20px;
            background-image: url('{{ asset('assets/img/auth-bg.jpg') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            filter: blur(4px) brightness(0.92);
            transform: scale(1.04);
            z-index: -10;
            pointer-events: none;
        }

        .global-cockpit-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 35%, rgba(15, 23, 42, 0.45) 0%, rgba(15, 23, 42, 0.82) 100%);
            z-index: -9;
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased text-slate-800 font-sans min-h-screen relative overflow-x-hidden">
    
    {{-- Global Blurred Cockpit Background Layer --}}
    <div class="global-cockpit-background"></div>
    <div class="global-cockpit-overlay"></div>

    <div class="relative z-10 flex min-h-screen items-center justify-center p-4 sm:p-8">
        {{ $slot }}
    </div>

</body>
</html>