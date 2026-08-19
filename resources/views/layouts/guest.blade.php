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