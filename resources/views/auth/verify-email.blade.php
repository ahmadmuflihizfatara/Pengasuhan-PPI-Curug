<x-guest-layout>
    <x-auth-card title="Verifikasi Email" subtitle="Terima kasih telah mendaftar! Klik tautan verifikasi yang kami kirim ke email Anda sebelum melanjutkan. Belum menerima email? Kirim ulang di bawah.">
        @if (session('status') == 'verification-link-sent')
            <div class="ds-alert ds-alert--success" role="status" style="margin-bottom:var(--space-5)">
                <i class="fa-solid fa-circle-check ds-icon"></i><span>Tautan verifikasi baru telah dikirim ke email yang Anda daftarkan.</span>
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="ds-btn ds-btn--primary" style="width:100%;padding:var(--space-3) var(--space-5)">
                <i class="fa-solid fa-envelope ds-icon"></i> Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top:var(--space-3)">
            @csrf
            <button type="submit" class="ds-btn ds-btn--ghost" style="width:100%;padding:var(--space-3) var(--space-5)">
                <i class="fa-solid fa-right-from-bracket ds-icon"></i> Keluar
            </button>
        </form>
    </x-auth-card>
</x-guest-layout>
