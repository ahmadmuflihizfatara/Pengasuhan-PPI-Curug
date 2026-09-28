<x-app-layout>
<x-form-glass-style />
<style>
    .sr-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .sr-kembali:hover { color: var(--accent-ink); }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Tambah Surat Baru" icon="fa-envelope-open-text"
            subtitle="Isi formulir berikut untuk mencatat surat baru ke dalam sistem" />

        <a href="{{ route('surat.index') }}" class="ds-btn ds-btn--pill sr-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Surat
        </a>

        @if($errors->any())
        <x-glass-alert type="danger" title="Surat belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        @include('surat._form', ['surat' => null])

    </div>
</main>
</x-app-layout>
