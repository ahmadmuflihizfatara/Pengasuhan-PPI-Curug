<x-guest-layout>
    <x-auth-card title="Atur Ulang Kata Sandi" subtitle="Buat kata sandi baru untuk akun Anda.">
        <form method="POST" action="{{ route('password.store') }}" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="ds-field">
                <label for="email" class="ds-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                       class="ds-input {{ $errors->has('email') ? 'ds-input--invalid' : '' }}">
                @error('email') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <div class="ds-field">
                <label for="password" class="ds-label">Kata Sandi Baru</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="ds-input {{ $errors->has('password') ? 'ds-input--invalid' : '' }}" placeholder="Min. 8 karakter">
                @error('password') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <div class="ds-field" style="margin-bottom:var(--space-6)">
                <label for="password_confirmation" class="ds-label">Ulangi Kata Sandi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="ds-input {{ $errors->has('password_confirmation') ? 'ds-input--invalid' : '' }}" placeholder="Ulangi kata sandi">
                @error('password_confirmation') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="ds-btn ds-btn--primary" style="width:100%;padding:var(--space-3) var(--space-5)">
                <i class="fa-solid fa-key ds-icon"></i> Simpan Kata Sandi
            </button>
        </form>
    </x-auth-card>
</x-guest-layout>
