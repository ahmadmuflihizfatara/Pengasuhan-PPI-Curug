<x-guest-layout>
    <x-auth-card title="Buat Akun Baru" subtitle="Lengkapi data berikut untuk mendaftar ke sistem Pengasuhan Taruna." width="520px">
        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <div class="ds-field">
                <label for="name" class="ds-label">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       class="ds-input {{ $errors->has('name') ? 'ds-input--invalid' : '' }}" placeholder="Nama sesuai KTP">
                @error('name') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <div class="ds-field">
                <label for="email" class="ds-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="ds-input {{ $errors->has('email') ? 'ds-input--invalid' : '' }}" placeholder="nama@ppicurug.ac.id">
                @error('email') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <div class="ds-form-grid ds-form-grid--2" style="margin-bottom:var(--space-6)">
                <div>
                    <label for="password" class="ds-label">Kata Sandi</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="ds-input {{ $errors->has('password') ? 'ds-input--invalid' : '' }}" placeholder="Min. 8 karakter">
                    @error('password') <div class="ds-error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="ds-label">Ulangi Kata Sandi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="ds-input" placeholder="Ulangi kata sandi">
                </div>
            </div>

            <button type="submit" class="ds-btn ds-btn--primary" style="width:100%;padding:var(--space-3) var(--space-5)">
                <i class="fa-solid fa-user-plus ds-icon"></i> Daftar
            </button>

            <p style="text-align:center;margin:var(--space-5) 0 0;font-size:12px;color:var(--ink-700)">
                Sudah memiliki akun? <a href="{{ route('login') }}" style="font-weight:700;color:var(--accent-ink);text-decoration:none">Masuk</a>
            </p>
        </form>
    </x-auth-card>
</x-guest-layout>
