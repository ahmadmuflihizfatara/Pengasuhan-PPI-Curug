<x-app-layout>
<x-form-glass-style />
<style>
    .us-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .us-kembali:hover { color: var(--accent-ink); }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Ubah Akun" icon="fa-user-pen"
            :subtitle="'Perbarui data, role, atau password akun ' . $user->name" />

        <a href="{{ route('users.index') }}" class="ds-btn ds-btn--pill us-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen Akun
        </a>

        @if($errors->any())
        <x-glass-alert type="danger" title="Perubahan belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        @include('users._form', ['user' => $user])

    </div>
</main>
</x-app-layout>
