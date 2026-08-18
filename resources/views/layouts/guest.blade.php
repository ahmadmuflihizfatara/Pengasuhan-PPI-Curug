<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PPI Curug') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #0a1628 0%, #12283a 50%, #1a3550 100%);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        /* Stars */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 10% 20%, rgba(255,255,255,.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 30% 60%, rgba(255,255,255,.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 50% 10%, rgba(255,255,255,.5) 0%, transparent 100%),
                radial-gradient(1px 1px at 70% 40%, rgba(255,255,255,.2) 0%, transparent 100%),
                radial-gradient(1px 1px at 90% 70%, rgba(255,255,255,.35) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 25% 35%, rgba(253,187,17,.3) 0%, transparent 100%);
            pointer-events: none;
        }
        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 960px;
            display: flex;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,.4);
            background: rgba(255,255,255,.03);
            border: 1px solid rgba(255,255,255,.06);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        {{ $slot }}
    </div>
</body>
</html>
