<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    @vite(['resources/js/app.js'])

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/css/app.css'])
</head>
<body>
    <div id="app">
        {{ $slot }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Global: handle delete-user buttons (event delegation, works on any page) --}}
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
</body>
</html>
