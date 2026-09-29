<x-guest-layout>
    <x-auth-card title="Masuk ke Akun Anda" subtitle="Silakan masukkan kredensial akun terdaftar Anda untuk melanjutkan.">
        @if (session('status'))
            <div class="ds-alert ds-alert--success" role="status" style="margin-bottom:var(--space-5)">
                <i class="fa-solid fa-circle-check ds-icon"></i><span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="ds-field">
                <label for="email" class="ds-label">Email atau Username</label>
                <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="ds-input {{ $errors->has('email') ? 'ds-input--invalid' : '' }}" placeholder="NPM / Email PPI Curug">
                @error('email') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <div class="ds-field">
                <label for="password" class="ds-label">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="ds-input {{ $errors->has('password') ? 'ds-input--invalid' : '' }}" placeholder="••••••••">
                @error('password') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <div class="ds-row" style="justify-content:space-between;margin-bottom:var(--space-6);font-size:12px">
                <label class="ds-row" style="cursor:pointer;font-weight:600;color:var(--ink-700)">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat Saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-weight:700;color:var(--accent-ink);text-decoration:none">Lupa Kata Sandi?</a>
                @endif
            </div>

            <button type="submit" class="ds-btn ds-btn--primary" style="width:100%;padding:var(--space-3) var(--space-5)">
                <i class="fa-solid fa-right-to-bracket ds-icon"></i> Masuk
            </button>

            @if (Route::has('register'))
                <p style="text-align:center;margin:var(--space-5) 0 0;font-size:12px;color:var(--ink-700)">
                    Belum memiliki akun? <a href="{{ route('register') }}" style="font-weight:700;color:var(--accent-ink);text-decoration:none">Daftar Sekarang</a>
                </p>
            @endif
        </form>
    </x-auth-card>
</x-guest-layout>
