<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | Pengasuhan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before { content: ''; position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,.06); border-radius: 50%; }
        body::after  { content: ''; position: absolute; bottom: -80px; left: -80px; width: 300px; height: 300px; background: rgba(255,255,255,.05); border-radius: 50%; }

        .card {
            background: white;
            border-radius: 28px;
            padding: 52px 56px;
            text-align: center;
            max-width: 460px;
            width: 90%;
            box-shadow: 0 32px 64px rgba(0,0,0,.2);
            position: relative;
            z-index: 1;
            animation: slideUp .5s cubic-bezier(.175,.885,.32,1.275);
        }
        @keyframes slideUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }

        .icon-wrap {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            font-size: 38px; color: white;
            box-shadow: 0 12px 30px rgba(238,90,36,.35);
        }
        .code { font-size: 72px; font-weight: 900; line-height: 1;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 8px; }
        .title { font-size: 22px; font-weight: 800; color: #333; margin-bottom: 10px; }
        .desc { font-size: 14px; color: #888; line-height: 1.7; margin-bottom: 28px; }
        .desc strong { color: #555; }

        .role-info {
            background: #f8f9ff;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 28px;
            text-align: left;
        }
        .role-info-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #aab; margin-bottom: 4px; }
        .role-badge { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; }

        .btn-back {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-back:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(102,126,234,.4); color: white; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrap"><i class="fas fa-shield-alt"></i></div>
        <div class="code">403</div>
        <h1 class="title">Akses Ditolak</h1>
        <p class="desc">
            Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            <strong>{{ $exception->getMessage() ?: 'Hubungi Admin jika Anda membutuhkan akses.' }}</strong>
        </p>

        @auth
        <div class="role-info">
            <div class="role-info-label">Role Anda saat ini</div>
            @php
                $roleColors = ['taruna' => ['#f0fff4','#38a169'], 'pengasuh' => ['#ebf4ff','#3182ce'], 'admin' => ['#f3eeff','#764ba2']];
                $role = auth()->user()->role;
                $rc = $roleColors[$role] ?? ['#f8f8f8','#888'];
            @endphp
            <span class="role-badge" style="background:{{ $rc[0] }}; color:{{ $rc[1] }};">
                <i class="fas fa-{{ $role === 'taruna' ? 'user-graduate' : ($role === 'pengasuh' ? 'chalkboard-teacher' : 'crown') }}" style="margin-right:5px;"></i>
                {{ ucfirst($role) }}
            </span>
        </div>
        @endauth

        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</body>
</html>
