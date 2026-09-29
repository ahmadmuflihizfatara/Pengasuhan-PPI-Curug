<x-guest-layout>
    <x-auth-card title="Konfirmasi Kata Sandi" subtitle="Ini area aman aplikasi. Masukkan kata sandi Anda untuk melanjutkan.">
        <form method="POST" action="{{ route('password.confirm') }}" novalidate>
            @csrf

            <div class="ds-field" style="margin-bottom:var(--space-6)">
                <label for="password" class="ds-label">Kata Sandi</label>
                <input id="password" type="password" name="password" required autofocus autocomplete="current-password"
                       class="ds-input {{ $errors->has('password') ? 'ds-input--invalid' : '' }}" placeholder="••••••••">
                @error('password') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="ds-btn ds-btn--primary" style="width:100%;padding:var(--space-3) var(--space-5)">
                <i class="fa-solid fa-shield-halved ds-icon"></i> Konfirmasi
            </button>
        </form>
    </x-auth-card>
</x-guest-layout>
