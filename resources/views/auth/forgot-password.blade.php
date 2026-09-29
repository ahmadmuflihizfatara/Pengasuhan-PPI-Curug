<x-guest-layout>
    <x-auth-card title="Lupa Kata Sandi" subtitle="Masukkan email akun Anda. Kami akan mengirim tautan untuk mengatur ulang kata sandi.">
        @if (session('status'))
            <div class="ds-alert ds-alert--success" role="status" style="margin-bottom:var(--space-5)">
                <i class="fa-solid fa-circle-check ds-icon"></i><span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf

            <div class="ds-field" style="margin-bottom:var(--space-6)">
                <label for="email" class="ds-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="ds-input {{ $errors->has('email') ? 'ds-input--invalid' : '' }}" placeholder="nama@ppicurug.ac.id">
                @error('email') <div class="ds-error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="ds-btn ds-btn--primary" style="width:100%;padding:var(--space-3) var(--space-5)">
                <i class="fa-solid fa-paper-plane ds-icon"></i> Kirim Tautan Reset
            </button>

            <p style="text-align:center;margin:var(--space-5) 0 0;font-size:12px;color:var(--ink-700)">
                Ingat kata sandi? <a href="{{ route('login') }}" style="font-weight:700;color:var(--accent-ink);text-decoration:none">Kembali ke Masuk</a>
            </p>
        </form>
    </x-auth-card>
</x-guest-layout>
