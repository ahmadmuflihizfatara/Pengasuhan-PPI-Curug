<x-guest-layout>
    {{-- Left: Visual --}}
    <div style="flex:0 0 42%;background:url('{{ asset('images/cockpit-bg.jpg') }}') center/cover no-repeat;position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:3rem;overflow:hidden;">
        <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(18,40,58,.85) 0%,rgba(12,28,43,.95) 100%);"></div>
        <div style="position:relative;z-index:2;text-align:center;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo PPI Curug" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid rgba(253,187,17,.4);box-shadow:0 0 40px rgba(253,187,17,.15);margin-bottom:1.5rem;">
            <h2 style="font-size:1.1rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;margin-bottom:.5rem;color:#fff;"><span style="color:#fdbb11;">PPI</span> Curug</h2>
            <p style="font-size:.8rem;color:rgba(255,255,255,.4);line-height:1.6;max-width:280px;margin:0 auto;">Politeknik Penerbangan Indonesia Curug — mencetak pilot profesional kelas dunia.</p>
        </div>
        <div style="position:absolute;bottom:40px;right:-20px;opacity:.06;transform:rotate(-15deg);pointer-events:none;">
            <svg width="300" height="200" viewBox="0 0 300 200" fill="none">
                <ellipse cx="180" cy="100" rx="90" ry="15" fill="white"/>
                <path d="M150 100 L95 45 L115 40 L195 93Z" fill="rgba(253,187,17,.3)"/>
                <path d="M150 100 L95 155 L115 160 L195 107Z" fill="rgba(253,187,17,.25)"/>
                <path d="M85 100 L55 68 L72 66 L95 93Z" fill="white"/>
                <path d="M85 100 L55 132 L72 134 L95 107Z" fill="rgba(255,255,255,.7)"/>
            </svg>
        </div>
    </div>

    {{-- Right: Form --}}
    <div style="flex:1;background:#eef3f9;padding:3rem;display:flex;flex-direction:column;justify-content:center;">
        <h1 style="font-size:1.5rem;font-weight:800;color:#12283a;margin-bottom:.3rem;">Masuk ke Sistem</h1>
        <p style="font-size:.85rem;color:#6b7c93;margin-bottom:2rem;">Gunakan akun Anda untuk mengakses dashboard.</p>

        @if ($errors->any())
            <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:.6rem 1rem;border-radius:10px;font-size:.8rem;margin-bottom:1rem;">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom:1.2rem;">
                <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7c93;margin-bottom:.4rem;">Email atau Username</label>
                <div style="position:relative;display:flex;align-items:center;">
                    <i class="fas fa-envelope" style="position:absolute;left:14px;color:#6b7c93;font-size:14px;pointer-events:none;"></i>
                    <input type="text" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@ppicurug.ac.id"
                        style="width:100%;padding:.8rem 1rem .8rem 2.8rem;border:1.5px solid #d4dbe5;border-radius:12px;font-size:.875rem;font-family:'Inter',sans-serif;color:#12283a;background:#fff;outline:none;transition:border-color .2s;">
                </div>
            </div>

            <div style="margin-bottom:1.2rem;">
                <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7c93;margin-bottom:.4rem;">Kata Sandi</label>
                <div style="position:relative;display:flex;align-items:center;">
                    <i class="fas fa-lock" style="position:absolute;left:14px;color:#6b7c93;font-size:14px;pointer-events:none;"></i>
                    <input type="password" name="password" required placeholder="Masukkan kata sandi"
                        style="width:100%;padding:.8rem 1rem .8rem 2.8rem;border:1.5px solid #d4dbe5;border-radius:12px;font-size:.875rem;font-family:'Inter',sans-serif;color:#12283a;background:#fff;outline:none;transition:border-color .2s;">
                </div>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                <label style="display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:#6b7c93;cursor:pointer;">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:.8rem;font-weight:700;color:#12283a;text-decoration:none;">Lupa kata sandi?</a>
                @endif
            </div>

            <button type="submit" style="width:100%;padding:.85rem;border:none;border-radius:9999px;background:#12283a;color:#fff;font-size:.85rem;font-weight:700;font-family:'Inter',sans-serif;letter-spacing:.06em;text-transform:uppercase;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:.5rem;"
                onmouseover="this.style.background='#fdbb11';this.style.color='#0c1c2b'"
                onmouseout="this.style.background='#12283a';this.style.color='#fff'">
                <i class="fas fa-plane" style="color:#fdbb11;"></i> Masuk
            </button>
        </form>

        <p style="text-align:center;margin-top:1.5rem;font-size:.8rem;color:#6b7c93;">
            Belum punya akun? <a href="{{ route('register') }}" style="font-weight:700;color:#12283a;text-decoration:none;">Daftar Sekarang</a>
        </p>
    </div>
</x-guest-layout>
