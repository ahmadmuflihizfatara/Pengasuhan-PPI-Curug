<x-app-layout>
<style>
    .ak-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: var(--space-4); }
    .ak-kartu { display: flex; flex-direction: column; gap: var(--space-3); }
    .ak-kartu--buka  { border-color: var(--success-border); }
    .ak-kartu--tutup { border-color: var(--danger-border); }
    .ak-kepala { display: flex; align-items: center; gap: var(--space-3); }
    .ak-ikon { width: 44px; height: 44px; flex-shrink: 0; border-radius: var(--radius-md); display: grid; place-items: center; font-size: 17px; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .ak-nama { font-size: 15px; line-height: 20px; font-weight: 800; color: var(--ink-900); }
    .ak-ket { flex: 1; margin: 0; font-size: 12px; line-height: 18px; font-weight: 500; color: var(--ink-700); }
    .ak-meta { font-size: 11px; line-height: 15px; font-weight: 600; color: var(--ink-500); }
    .ak-meta i { margin-right: var(--space-1); }
    .ak-kartu form { margin: 0; }
    .ak-kartu .ds-btn { width: 100%; justify-content: center; }
</style>

<x-island-navbar />

@php $dibuka = $daftar->where('diizinkan', true)->count(); @endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Hak Akses Pengasuh" icon="fa-shield-halved"
            subtitle="Atur fitur mana yang boleh diisi, diubah, dan digenerate oleh pengasuh" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-4">
            <x-stat-card title="Fitur Dibuka" :value="$dibuka . '/' . $daftar->count()" icon="fa-solid fa-lock-open"
                varian="success" badge="Diizinkan" badgeType="success" description="Pengasuh dapat mengisi & mengubah" />
            <x-stat-card title="Fitur Ditutup" :value="$daftar->count() - $dibuka" icon="fa-solid fa-lock"
                varian="danger" badge="Hanya lihat" badgeType="danger" description="Pengasuh hanya dapat melihat data" />
        </div>

        <div class="ds-alert ds-alert--info mb-4" role="status">
            <i class="fa-solid fa-circle-info ds-icon"></i>
            <span>Saat akses ditutup, pengasuh <strong>tetap dapat membuka tab dan melihat data</strong> yang sudah ada,
                  tetapi tombol isi/generate/ubah hilang dan permintaan simpan ditolak server. Pengaturan berlaku untuk semua akun pengasuh.</span>
        </div>

        <div class="ak-grid">
            @foreach($daftar as $item)
            <div class="ds-card ak-kartu {{ $item['diizinkan'] ? 'ak-kartu--buka' : 'ak-kartu--tutup' }}">
                <div class="ak-kepala">
                    <span class="ak-ikon" style="background:linear-gradient(135deg,{{ $item['warna'] }},var(--accent));"><i class="fa-solid {{ $item['ikon'] }}"></i></span>
                    <div>
                        <div class="ak-nama">{{ $item['label'] }}</div>
                        <span class="ds-badge ds-badge--{{ $item['diizinkan'] ? 'success' : 'danger' }}">
                            <i class="fa-solid {{ $item['diizinkan'] ? 'fa-lock-open' : 'fa-lock' }}"></i> {{ $item['diizinkan'] ? 'Diizinkan' : 'Ditutup' }}
                        </span>
                    </div>
                </div>

                <p class="ak-ket">{{ $item['ket'] }}</p>

                <div class="ak-meta">
                    @if($item['diubah'])
                    <i class="fa-solid fa-clock-rotate-left"></i>Diubah {{ $item['diubah']->locale('id')->isoFormat('D MMM Y, HH:mm') }}@if($item['pengubah']) oleh {{ $item['pengubah'] }}@endif
                    @else
                    <i class="fa-solid fa-circle-info"></i>Belum pernah diubah — terbuka secara default
                    @endif
                </div>

                {{-- Menutup akses berdampak ke semua pengasuh → minta konfirmasi; membuka langsung --}}
                <form method="POST" action="{{ route('akses.update') }}"
                      @if($item['diizinkan']) data-konfirmasi="Semua pengasuh tidak akan bisa mengisi atau mengubah {{ $item['label'] }} sampai akses dibuka kembali. Data tetap dapat dilihat." data-konfirmasi-judul="Tutup Akses {{ $item['label'] }}?" data-konfirmasi-varian="warning" data-konfirmasi-tombol="Ya, Tutup Akses" @endif>
                    @csrf
                    <input type="hidden" name="fitur" value="{{ $item['key'] }}">
                    <input type="hidden" name="diizinkan" value="{{ $item['diizinkan'] ? 0 : 1 }}">
                    @if($item['diizinkan'])
                    <button type="submit" class="ds-btn ds-btn--danger"><i class="fa-solid fa-lock"></i> Tutup Akses</button>
                    @else
                    <button type="submit" class="ds-btn ds-btn--success"><i class="fa-solid fa-lock-open"></i> Buka Akses</button>
                    @endif
                </form>
            </div>
            @endforeach
        </div>

    </div>
</main>

<x-konfirmasi-modal />
</x-app-layout>
