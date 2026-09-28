<x-app-layout>
<x-form-glass-style />
<style>
    .br-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .br-kembali:hover { color: var(--accent-ink); }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Tulis Berita Baru" icon="fa-pen-nib"
            subtitle="Buat artikel, pengumuman, atau informasi untuk taruna" />

        <a href="{{ route('berita.index') }}" class="ds-btn ds-btn--pill br-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
        </a>

        @if($errors->any())
        <x-glass-alert type="danger" title="Berita belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        @include('berita._form', ['beritum' => null])

    </div>
</main>
</x-app-layout>
