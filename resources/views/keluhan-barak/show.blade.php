<x-app-layout>
<style>
    .keluhan-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .keluhan-kembali:hover { color: var(--accent-ink); }
</style>

<x-island-navbar />

@php
    // Varian sama dengan badge status di daftar keluhan
    [$varian, $ikon, $desc] = match($keluhan->status) {
        'Selesai'  => ['success', 'fa-circle-check',   'Keluhan Anda telah selesai ditangani oleh satuan pengasuhan.'],
        'Ditolak'  => ['danger',  'fa-circle-xmark',   'Keluhan Anda ditolak. Lihat alasan pada respon pengasuhan.'],
        'Diproses' => ['accent',  'fa-screwdriver-wrench', 'Keluhan Anda sedang ditangani oleh satuan pengasuhan.'],
        default    => ['warning', 'fa-hourglass-half', 'Keluhan Anda sudah terkirim dan menunggu ditinjau satuan pengasuhan.'],
    };
    [$judulRespon, $pesanRespon] = match($keluhan->status) {
        'Selesai'  => ['Keluhan Selesai', $keluhan->catatan_pengasuhan ?: 'Perbaikan atau penanganan keluhan telah selesai dilakukan.'],
        'Ditolak'  => ['Alasan Penolakan', $keluhan->catatan_pengasuhan ?: 'Keluhan Anda tidak dapat diproses. Silakan hubungi satuan pengasuhan untuk informasi lebih lanjut.'],
        'Diproses' => ['Sedang Ditangani', $keluhan->catatan_pengasuhan ?: 'Keluhan sedang ditindaklanjuti. Anda akan menerima notifikasi ketika statusnya berubah.'],
        default    => ['Menunggu Tinjauan', 'Keluhan Anda belum ditinjau. Anda akan menerima notifikasi ketika statusnya berubah.'],
    };
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Detail Keluhan Barak" icon="fa-door-open"
            subtitle="Pantau status dan respon satuan pengasuhan atas keluhan barak Anda" />

        <a href="{{ route('keluhan-barak.index') }}" class="ds-btn ds-btn--pill keluhan-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Keluhan
        </a>

        {{-- Status keluhan --}}
        <div class="ds-card dt-card mb-4">
            <span class="ds-stat__icon {{ $varian !== 'accent' ? 'ds-stat__icon--'.$varian : '' }}"><i class="fa-solid {{ $ikon }}"></i></span>
            <div class="dt-card__body">
                <span class="dt-card__label">Status Keluhan</span>
                <div class="dt-card__top">
                    <span class="dt-card__value">{{ $keluhan->status }}</span>
                    <span class="ds-badge ds-badge--info">{{ $keluhan->lorong }} · No. {{ $keluhan->nomor_barak }}</span>
                </div>
                <p class="dt-card__desc">{{ $desc }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- Informasi keluhan --}}
            <div class="ds-card lg:col-span-2">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-circle-info ds-icon"></i> Informasi Keluhan</h3>
                    <p class="ds-card__desc">Data yang Anda kirim saat mengajukan keluhan</p>
                </div>

                <dl class="dt-fields">
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-building"></i> Lokasi Barak</dt>
                        <dd>Asrama {{ $keluhan->asrama }} · {{ $keluhan->lorong }} · No. {{ $keluhan->nomor_barak }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-calendar"></i> Tanggal Pengajuan</dt>
                        <dd>{{ $keluhan->tanggal_pengajuan->locale('id')->isoFormat('dddd, D MMMM Y') }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-user"></i> Nama Pengaju</dt>
                        <dd>{{ $keluhan->nama }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-envelope"></i> Email</dt>
                        <dd>{{ $keluhan->email }}</dd>
                    </div>
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-graduation-cap"></i> Program Studi</dt>
                        <dd>{{ $keluhan->prodi }} — {{ $keluhan->prodi_nama }}</dd>
                    </div>
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-note-sticky"></i> Keterangan Keluhan</dt>
                        <dd class="dt-teks">{{ $keluhan->keterangan }}</dd>
                    </div>
                    @if(!empty($keluhan->lampiran))
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-paperclip"></i> Lampiran ({{ count($keluhan->lampiran) }})</dt>
                        @foreach($keluhan->lampiran as $file)
                        <dd class="dt-file {{ !$loop->first ? 'mt-2' : '' }}">
                            <span class="dt-file__nama"><span class="ds-avatar ds-avatar--sq"><i class="fa-solid fa-file"></i></span>{{ basename($file) }}</span>
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($file) }}" target="_blank" rel="noopener" class="ds-btn ds-btn--primary ds-btn--sm">
                                <i class="fa-solid fa-download"></i> Lihat / Unduh
                            </a>
                        </dd>
                        @endforeach
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Respon satuan pengasuhan --}}
            <div class="ds-card">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-comment-dots ds-icon"></i> Respon Pengasuhan</h3>
                    <p class="ds-card__desc">Tindak lanjut dan catatan dari satuan pengasuhan</p>
                </div>

                <div class="ds-alert dt-respon dt-respon--{{ $varian }}" role="status">
                    <span class="dt-respon__ikon"><i class="fa-solid {{ $ikon }}"></i></span>
                    <div>
                        <div class="dt-respon__judul">{{ $judulRespon }}</div>
                        <div class="dt-respon__pesan">{{ $pesanRespon }}</div>
                    </div>
                </div>

                <div class="dt-waktu">
                    <span><i class="fa-solid fa-clock"></i>Diajukan {{ $keluhan->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fa-solid fa-rotate"></i>Diperbarui {{ $keluhan->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>

    </div>
</main>
</x-app-layout>
