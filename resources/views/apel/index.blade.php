<x-app-layout>
<x-form-glass-style />
<style>
    /* Pola kartu sama dengan halaman Jadwal Apel taruna (apel/jadwal) */
    .ap-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .ap-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
    .ap-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }

    /* Pencarian berdasarkan tanggal */
    .ap-cari { display: flex; align-items: flex-end; gap: var(--space-3); flex-wrap: wrap; }
    .ap-cari .form-group { flex: 0 1 280px; margin: 0; }
    .ap-cari .form-control { cursor: pointer; }
    .ap-cari__nav { display: flex; align-items: center; gap: var(--space-2); flex-wrap: wrap; }
    .ap-cari__nav .ds-btn { height: 38px; }
    .ap-cari__info { margin-left: auto; }
    @media (max-width: 640px) { .ap-cari .form-group { flex-basis: 100%; } .ap-cari__info { margin-left: 0; } }
    .ap-daftar { display: flex; flex-direction: column; gap: var(--space-4); }
    .filter-chips { display: flex; gap: var(--space-2); flex-wrap: wrap; }
    .chip {
        display: inline-flex; align-items: center; gap: var(--space-1-5); height: 38px; padding: 0 var(--space-4); border-radius: var(--radius-pill);
        background: var(--glass-card); border: 1px solid var(--border-glass-glow); box-shadow: var(--shadow-glass-sm);
        font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); text-decoration: none;
        transition: background-color .15s, color .15s, transform .1s;
    }
    .chip:hover { background: var(--glass-solid); color: var(--ink-900); }
    .chip:active { transform: scale(.97); }
    .chip:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .chip.active { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); }

    .detail-head { display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); flex-wrap: wrap; }
    .detail-head__kiri { display: flex; align-items: center; gap: var(--space-4); min-width: 0; }
    .detail-head .ikon { width: 48px; height: 48px; border-radius: var(--radius-md); flex-shrink: 0; display: grid; place-items: center; font-size: 20px; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .detail-head h2 { margin: 0 0 2px; font-size: 16px; line-height: 22px; font-weight: 800; color: var(--ink-900); }
    .detail-head .meta { font-size: 12px; font-weight: 600; color: var(--ink-600); display: flex; gap: var(--space-3-5); flex-wrap: wrap; }
    .detail-head .meta i { color: var(--accent); margin-right: 2px; }
    .detail-head__aksi { display: flex; gap: var(--space-2); }

    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: var(--space-4); }
    .info-item { background: var(--glass-card); border: 1px solid var(--border-glass-glow); border-radius: var(--radius-md); padding: var(--space-3-5) var(--space-4); }
    .info-item .label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-600); margin-bottom: var(--space-1-5); display: flex; align-items: center; gap: var(--space-1-5); }
    .info-item .label i { color: var(--accent); }
    .info-item .value { font-size: 14px; font-weight: 700; color: var(--ink-900); }
    .info-item .value small { display: block; font-size: 11px; font-weight: 500; color: var(--ink-500); margin-top: 2px; }

    .ap-kunci { align-items: center; flex-wrap: wrap; }
    .ap-kunci__teks { flex: 1; min-width: 220px; }

    .ap-blok { margin-top: var(--space-4); }
    .ap-blok__judul { display: flex; align-items: center; gap: var(--space-1-5); margin: 0 0 var(--space-2); font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .ap-blok__judul i { color: var(--accent); }
    .ap-blok__isi { padding: var(--space-3-5) var(--space-4); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); border-left: 4px solid var(--ap-garis, var(--accent)); font-size: 13px; line-height: 21px; font-weight: 500; color: var(--ink-800); white-space: pre-line; overflow-wrap: anywhere; }
    .ap-blok__isi--kosong { color: var(--ink-500); font-style: italic; }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header Jadwal Apel taruna & tab lain --}}
        <x-page-banner title="Apel & Presensi Taruna" icon="fa-clipboard-check"
            subtitle="Cari apel berdasarkan tanggal dan jenis apel untuk melihat pembina, lokasi, dan informasi apel" />

        @if($bolehIsi)
        <div class="ds-card ap-aksi mb-4">
            <span class="ap-aksi__teks"><i class="fa-solid fa-flag"></i>Catat pembina, lokasi, dan informasi apel pagi, malam, atau khusus</span>
            <a href="{{ route('apel.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Isi Data Apel Baru</a>
        </div>
        @else
        <div class="ds-alert ds-alert--warning ap-kunci mb-4" role="status">
            <i class="fa-solid fa-lock ds-icon"></i>
            @if(auth()->user()->isAdmin())
            {{-- Admin yang mengatur kunci ini — beri jalan pintas untuk membukanya --}}
            <span class="ap-kunci__teks">Akses pengisian data apel sedang <strong>ditutup</strong> di Akses Fitur — pengasuh maupun admin tidak dapat menambah, mengubah, atau menghapus apel.</span>
            <a href="{{ route('akses.index') }}" class="ds-btn ds-btn--sm ds-btn--pill"><i class="fa-solid fa-key"></i> Buka di Akses Fitur</a>
            @else
            <span>Akses pengisian data apel sedang ditutup admin — data tetap dapat dilihat, tetapi tidak dapat diubah.</span>
            @endif
        </div>
        @endif

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif

        @php
            $tanggalLabel = $tanggal->locale('id')->isoFormat('dddd, D MMMM Y');
        @endphp

        @if($totalApel === 0)
        <div class="ds-card">
            <div class="ds-empty">
                <i class="fa-solid fa-flag ds-icon"></i>
                Belum ada data apel yang tercatat di sistem.
            </div>
        </div>
        @else

        {{-- Cari apel berdasarkan tanggal --}}
        <div class="ds-card mb-4">
            <form method="GET" action="{{ route('apel.index') }}" class="ap-cari" role="search">
                <div class="form-group">
                    <label class="form-label" for="tanggalApel">Tanggal Apel</label>
                    <input type="date" id="tanggalApel" name="tanggal" class="form-control"
                           value="{{ $tanggal->format('Y-m-d') }}" onchange="this.form.submit()">
                    @if($sesi)<input type="hidden" name="sesi" value="{{ $sesi }}">@endif
                </div>
                <div>
                    <span class="form-label">Jenis Apel</span>
                    <div class="filter-chips" role="group" aria-label="Filter jenis apel">
                        @foreach(['' => ['Semua', 'fa-layer-group'], 'pagi' => ['Pagi', 'fa-sun'], 'malam' => ['Malam', 'fa-moon'], 'khusus' => ['Khusus', 'fa-flag']] as $nilai => [$label, $ikon])
                        <a href="{{ route('apel.index', array_filter(['tanggal' => $tanggal->format('Y-m-d'), 'sesi' => $nilai])) }}"
                           class="chip {{ ($sesi ?? '') === $nilai ? 'active' : '' }}" @if(($sesi ?? '') === $nilai) aria-current="true" @endif>
                            <i class="fa-solid {{ $ikon }}"></i> {{ $label }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="ap-cari__nav">
                    @if($sebelumnya)
                    <a href="{{ route('apel.index', array_filter(['tanggal' => $sebelumnya->format('Y-m-d'), 'sesi' => $sesi])) }}" class="ds-btn ds-btn--pill" title="{{ $sebelumnya->locale('id')->isoFormat('D MMM Y') }}">
                        <i class="fa-solid fa-chevron-left"></i> Apel sebelumnya
                    </a>
                    @endif
                    @if($berikutnya)
                    <a href="{{ route('apel.index', array_filter(['tanggal' => $berikutnya->format('Y-m-d'), 'sesi' => $sesi])) }}" class="ds-btn ds-btn--pill" title="{{ $berikutnya->locale('id')->isoFormat('D MMM Y') }}">
                        Apel berikutnya <i class="fa-solid fa-chevron-right"></i>
                    </a>
                    @endif
                    @unless($tanggal->isToday())
                    <a href="{{ route('apel.index', array_filter(['tanggal' => today()->format('Y-m-d'), 'sesi' => $sesi])) }}" class="ds-btn ds-btn--pill">Hari ini</a>
                    @endunless
                </div>
                <span class="ds-badge ds-badge--{{ $daftarApel->isEmpty() ? 'warning' : 'accent' }} ap-cari__info">{{ $daftarApel->count() }} {{ $sesi ? 'apel ' . $sesi : 'apel' }} · {{ $tanggalLabel }}</span>
            </form>
        </div>

        @if($daftarApel->isEmpty())
        <div class="ds-card">
            <div class="ds-empty">
                <i class="fa-solid fa-calendar-xmark ds-icon"></i>
                Tidak ada {{ $sesi ? 'apel ' . $sesi : 'apel' }} pada {{ $tanggalLabel }}.
                @if($bolehIsi)
                <div class="mt-3"><a href="{{ route('apel.create') }}" class="ds-btn ds-btn--primary ds-btn--sm"><i class="fa-solid fa-plus"></i> Isi Data Apel</a></div>
                @endif
            </div>
        </div>
        @else
        <div class="ap-daftar">
            @foreach($daftarApel as $apel)
            <div class="ds-card">
                <div class="ds-card__head detail-head">
                    <div class="detail-head__kiri">
                        <div class="ikon" style="background:linear-gradient(135deg,{{ $apel->warna }},var(--accent));"><i class="fa-solid {{ $apel->ikon }}"></i></div>
                        <div>
                            <h2>{{ $apel->judul }}</h2>
                            <div class="meta">
                                <span><i class="fa-solid fa-calendar-day"></i> {{ $tanggalLabel }}</span>
                                @if($apel->jam)
                                <span><i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($apel->jam)->format('H:i') }} WIB</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($bolehIsi)
                    <div class="detail-head__aksi">
                        <a href="{{ route('apel.edit', $apel) }}" class="ds-btn ds-btn--sm ds-btn--pill"><i class="fa-solid fa-pen"></i> Ubah</a>
                        <form method="POST" action="{{ route('apel.destroy', $apel) }}" style="margin:0"
                              data-konfirmasi="{{ $apel->judul }} {{ $tanggalLabel }} akan dihapus permanen." data-konfirmasi-judul="Hapus Data Apel?" data-konfirmasi-tombol="Ya, Hapus">
                            @csrf @method('DELETE')
                            <button type="submit" class="ds-btn ds-btn--sm ds-btn--pill ds-btn--danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                    @endif
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="label"><i class="fa-solid fa-user-tie"></i> Pembina Apel</div>
                        <div class="value">
                            {{ $apel->pembina }}
                            @if($apel->pembinaUser?->jabatan)<small>{{ $apel->pembinaUser->jabatan }}</small>@endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="label"><i class="fa-solid fa-location-dot"></i> Lokasi Apel</div>
                        <div class="value">{{ $apel->lokasi }}</div>
                    </div>
                    <div class="info-item">
                        <div class="label"><i class="fa-solid fa-flag"></i> Jenis</div>
                        <div class="value">{{ $apel->judul }}<small>{{ ucfirst($apel->sesi) }}</small></div>
                    </div>
                </div>

                <div class="ap-blok">
                    <h3 class="ap-blok__judul"><i class="fa-solid fa-circle-info"></i> Informasi Apel</h3>
                    <div class="ap-blok__isi {{ $apel->informasi ? '' : 'ap-blok__isi--kosong' }}">{{ $apel->informasi ?: 'Belum ada informasi apel yang dicantumkan.' }}</div>
                </div>

                @if($apel->keterangan)
                <div class="ap-blok" style="--ap-garis: var(--warning)">
                    <h3 class="ap-blok__judul"><i class="fa-solid fa-note-sticky"></i> Keterangan Tambahan</h3>
                    <div class="ap-blok__isi">{{ $apel->keterangan }}</div>
                </div>
                @endif

                <div class="dt-waktu">
                    <span><i class="fa-solid fa-user-pen"></i>Diisi oleh {{ $apel->pembuat?->name ?? '—' }}</span>
                    <span><i class="fa-solid fa-rotate"></i>Diperbarui {{ $apel->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @endif

    </div>
</main>

<x-konfirmasi-modal />

</x-app-layout>
