<x-app-layout>
<style>
    .lg-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .lg-kembali:hover { color: var(--accent-ink); }
    .lg-nav { display: flex; flex-wrap: wrap; gap: var(--space-2); }

    .lg-foto { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: var(--space-3); }
    .lg-foto figure { margin: 0; padding: var(--space-2-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .lg-foto img { display: block; width: 100%; height: 220px; object-fit: cover; border-radius: var(--radius-sm); }
    .lg-foto figcaption { margin-top: var(--space-2); font-size: 11px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .lg-foto figcaption i { color: var(--accent); margin-right: var(--space-1); }

    .lg-tindakan { display: flex; flex-direction: column; gap: var(--space-3); }
    .lg-tindakan .dt-respon { margin: 0; }
    .lg-tindakan form { margin: 0; }
    .lg-tindakan .ds-btn { width: 100%; justify-content: center; padding-top: var(--space-2-5); padding-bottom: var(--space-2-5); }
    .lg-btn-kembali { background: var(--success); border-color: transparent; color: var(--ink-on-dark); }
    .lg-btn-kembali:hover { background: var(--success-ink); }
</style>

<x-island-navbar />

@php
    [$katLabel, $katIkon, $katVarian] = $log->kategoriMeta();
    $belum = $log->isBelumKembali();
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Detail Log Pergerakan" icon="fa-person-walking"
            subtitle="Rincian keberangkatan, kepulangan, dan validasi log pos jaga gerbang" />

        <div class="lg-nav mb-4">
            <a href="{{ route('log-pergerakan.index') }}" class="ds-btn ds-btn--pill lg-kembali"><i class="fa-solid fa-arrow-left"></i> Kembali ke Rekap Log</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('log-pergerakan.tablet') }}" class="ds-btn ds-btn--pill lg-kembali"><i class="fa-solid fa-tablet-screen-button"></i> Mode Tablet Pos Jaga</a>
            @endif
        </div>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        {{-- Status pergerakan --}}
        <div class="ds-card dt-card mb-4">
            <span class="ds-stat__icon ds-stat__icon--{{ $belum ? 'danger' : 'success' }}"><i class="fa-solid {{ $belum ? 'fa-person-walking-arrow-right' : 'fa-house-circle-check' }}"></i></span>
            <div class="dt-card__body">
                <span class="dt-card__label">Status Pergerakan · {{ $log->nama }}</span>
                <div class="dt-card__top">
                    <span class="dt-card__value">{{ $belum ? 'Belum Kembali' : 'Sudah Kembali' }}</span>
                    <span class="ds-badge ds-badge--{{ $katVarian }}"><i class="fa-solid {{ $katIkon }}"></i> {{ $katLabel }}</span>
                    <x-badge-urgensi :log="$log" />
                    <span class="ds-badge ds-badge--{{ $log->is_validated ? 'success' : 'warning' }}"><i class="fa-solid {{ $log->is_validated ? 'fa-user-check' : 'fa-hourglass-half' }}"></i> {{ $log->is_validated ? 'Tervalidasi' : 'Menunggu validasi' }}</span>
                </div>
                <p class="dt-card__desc">
                    {{ $belum ? 'Taruna masih di luar asrama sejak ' . $log->getDurasiFormatted() . ' lalu.' : 'Taruna sudah kembali ke asrama. Durasi total ' . $log->getDurasiFormatted() . '.' }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
            {{-- Informasi pergerakan --}}
            <div class="ds-card lg:col-span-2">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-circle-info ds-icon"></i> Informasi Pergerakan</h3>
                    <p class="ds-card__desc">{{ $katLabel }}{{ $log->subkategori ? ' · ' . $log->subkategori_label : '' }}</p>
                </div>

                <dl class="dt-fields">
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-user"></i> Nama Taruna / Koordinator</dt>
                        <dd>{{ $log->nama }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-id-card"></i> NPM &amp; Program Studi</dt>
                        <dd>{{ $log->npm ?? '-' }} · {{ $log->prodi ?? 'PPI Curug' }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-right-from-bracket"></i> Waktu Berangkat</dt>
                        <dd>{{ $log->waktu_berangkat ? $log->waktu_berangkat->locale('id')->isoFormat('dddd, D MMMM Y · HH:mm') . ' WIB' : '—' }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-right-to-bracket"></i> Waktu Kembali</dt>
                        <dd>
                            @if($log->isSudahKembali())
                            {{ $log->waktu_kembali ? $log->waktu_kembali->locale('id')->isoFormat('dddd, D MMMM Y · HH:mm') . ' WIB' : '—' }}
                            @else
                            <span style="color:var(--danger-ink)">Masih di luar ({{ $log->getDurasiFormatted() }} lalu)</span>
                            @endif
                        </dd>
                    </div>

                    @if($log->kategori === 'perizinan')
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-note-sticky"></i> Alasan / Keterangan Keluhan</dt>
                        <dd class="dt-teks">{{ $log->keterangan_keluhan ?? 'Tidak ada catatan tambahan.' }}</dd>
                    </div>
                    @elseif($log->kategori === 'ekstrakurikuler')
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-people-group"></i> Nama Ekstrakurikuler</dt>
                        <dd>{{ $log->nama_ekskul ?? '—' }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-users"></i> Jumlah Anggota</dt>
                        <dd>{{ $log->jumlah_anggota ? $log->jumlah_anggota . ' orang' : '—' }}</dd>
                    </div>
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-location-dot"></i> Lokasi Kegiatan</dt>
                        <dd>{{ $log->lokasi_kegiatan ?? '—' }}</dd>
                    </div>
                    @if($log->daftar_anggota)
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-list"></i> Daftar Anggota yang Ikut</dt>
                        <dd class="dt-teks">{{ $log->daftar_anggota }}</dd>
                    </div>
                    @endif
                    @else
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-route"></i> Rute Olahraga</dt>
                        <dd>{{ $log->rute ?? '—' }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-user-group"></i> Pengikut / Teman Olahraga</dt>
                        <dd>{{ $log->pengikut ?? '—' }}</dd>
                    </div>
                    @endif
                </dl>

                @if($log->foto_keberangkatan || $log->foto_kembali)
                <div class="lg-foto mt-3">
                    @if($log->foto_keberangkatan)
                    <figure>
                        <a href="{{ asset('storage/' . $log->foto_keberangkatan) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/' . $log->foto_keberangkatan) }}" alt="Foto keberangkatan {{ $log->nama }}"></a>
                        <figcaption><i class="fa-solid fa-camera"></i> Dokumentasi Keberangkatan</figcaption>
                    </figure>
                    @endif
                    @if($log->foto_kembali)
                    <figure>
                        <a href="{{ asset('storage/' . $log->foto_kembali) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/' . $log->foto_kembali) }}" alt="Foto kepulangan {{ $log->nama }}"></a>
                        <figcaption><i class="fa-solid fa-camera"></i> Dokumentasi Kepulangan</figcaption>
                    </figure>
                    @endif
                </div>
                @endif
            </div>

            {{-- Tindakan pengasuh / admin --}}
            <div class="ds-card">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-user-shield ds-icon"></i> Tindakan</h3>
                    <p class="ds-card__desc">Perbarui status kepulangan dan validasi log</p>
                </div>

                <div class="lg-tindakan">
                    @if($belum)
                    <div class="ds-alert dt-respon dt-respon--danger">
                        <span class="dt-respon__ikon"><i class="fa-solid fa-person-walking-arrow-right"></i></span>
                        <div>
                            <div class="dt-respon__judul">Taruna belum kembali</div>
                            <div class="dt-respon__pesan">{{ auth()->user()->isAdmin() ? 'Tandai kembali saat taruna sudah tiba di asrama.' : 'Taruna menandai kembali sendiri, atau admin melalui tablet pos jaga.' }}</div>
                        </div>
                    </div>
                    {{-- Tandai kembali hanya admin (route role:taruna,admin — pengasuh sebatas validator) --}}
                    @if(auth()->user()->isAdmin())
                    <form action="{{ route('log-pergerakan.kembali', $log->id) }}" method="POST"
                          data-konfirmasi="{{ $log->nama }} akan ditandai sudah kembali ke asrama sekarang." data-konfirmasi-judul="Tandai Sudah Kembali?" data-konfirmasi-varian="success" data-konfirmasi-tombol="Ya, Sudah Kembali">
                        @csrf @method('PATCH')
                        <button type="submit" class="ds-btn lg-btn-kembali"><i class="fa-solid fa-circle-check"></i> Tandai Sudah Kembali</button>
                    </form>
                    @endif
                    @endif

                    <div class="ds-alert dt-respon dt-respon--{{ $log->is_validated ? 'success' : 'warning' }}">
                        <span class="dt-respon__ikon"><i class="fa-solid {{ $log->is_validated ? 'fa-user-check' : 'fa-hourglass-half' }}"></i></span>
                        <div>
                            <div class="dt-respon__judul">{{ $log->is_validated ? 'Log sudah divalidasi' : 'Log belum divalidasi' }}</div>
                            <div class="dt-respon__pesan">
                                @if($log->is_validated && $log->validator)
                                Oleh {{ $log->validator->name }} · {{ $log->validated_at?->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                @else
                                Validasi menyatakan data izin sudah diperiksa dan sesuai fakta di lapangan.
                                @endif
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('log-pergerakan.validasi', $log->id) }}" method="POST"
                          data-konfirmasi="{{ $log->is_validated ? 'Validasi log ini akan dibatalkan dan kembali berstatus menunggu.' : 'Log ini akan ditandai tervalidasi. Pastikan data sudah sesuai fakta di lapangan.' }}"
                          data-konfirmasi-judul="{{ $log->is_validated ? 'Batalkan Validasi?' : 'Validasi Log?' }}"
                          data-konfirmasi-varian="{{ $log->is_validated ? 'warning' : 'success' }}"
                          data-konfirmasi-tombol="{{ $log->is_validated ? 'Ya, Batalkan' : 'Ya, Validasi' }}">
                        @csrf @method('PATCH')
                        @if($log->is_validated)
                        <button type="submit" class="ds-btn"><i class="fa-solid fa-rotate-left"></i> Batalkan Validasi</button>
                        @else
                        <button type="submit" class="ds-btn ds-btn--primary"><i class="fa-solid fa-circle-check"></i> Validasi Sekarang</button>
                        @endif
                    </form>
                </div>

                <div class="dt-waktu">
                    <span><i class="fa-solid fa-clock"></i>Dicatat {{ $log->created_at?->locale('id')->isoFormat('D MMM Y, HH:mm') }}{{ $log->creator ? ' oleh ' . $log->creator->name : '' }}</span>
                    <span><i class="fa-solid fa-rotate"></i>Diperbarui {{ $log->updated_at?->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>

    </div>
</main>

<x-konfirmasi-modal />
</x-app-layout>
