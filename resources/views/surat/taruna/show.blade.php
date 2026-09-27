<x-app-layout>
<style>
    .surat-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .surat-kembali:hover { color: var(--accent-ink); }
</style>

<x-island-navbar />

@php
    [$varian, $ikon, $desc] = match($surat->status) {
        'Disetujui' => ['success', 'fa-circle-check',     'Permohonan surat Anda telah disetujui oleh satuan pengasuhan.'],
        'Ditolak'   => ['danger',  'fa-circle-xmark',     'Permohonan surat Anda ditolak. Lihat alasan pada respon pengasuhan.'],
        'Selesai'   => ['accent',  'fa-flag-checkered',   'Permohonan surat telah selesai diproses.'],
        default     => ['warning', 'fa-hourglass-half',   'Permohonan surat Anda sedang ditinjau oleh satuan pengasuhan.'],
    };
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Detail Pengajuan Surat" icon="fa-file-signature"
            subtitle="Pantau status dan respon satuan pengasuhan atas permohonan surat Anda" />

        <a href="{{ route('surat-taruna.index') }}" class="ds-btn ds-btn--pill surat-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengajuan
        </a>

        {{-- Status pengajuan --}}
        <div class="ds-card dt-card mb-4">
            <span class="ds-stat__icon {{ $varian !== 'accent' ? 'ds-stat__icon--'.$varian : '' }}"><i class="fa-solid {{ $ikon }}"></i></span>
            <div class="dt-card__body">
                <span class="dt-card__label">Status Pengajuan</span>
                <div class="dt-card__top">
                    <span class="dt-card__value">{{ $surat->status }}</span>
                    <span class="ds-badge ds-badge--info">{{ $surat->jenis_surat }}</span>
                </div>
                <p class="dt-card__desc">{{ $desc }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- Informasi permohonan --}}
            <div class="ds-card lg:col-span-2">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-circle-info ds-icon"></i> Informasi Permohonan</h3>
                    <p class="ds-card__desc">Data yang Anda kirim saat mengajukan surat</p>
                </div>

                <dl class="dt-fields">
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-heading"></i> Perihal</dt>
                        <dd>{{ $surat->perihal }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-envelope"></i> Jenis Surat</dt>
                        <dd>{{ $surat->jenis_surat }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-calendar"></i> Tanggal Pengajuan</dt>
                        <dd>{{ $surat->tanggal_surat->locale('id')->isoFormat('dddd, D MMMM Y') }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-user"></i> Pengaju</dt>
                        <dd>{{ $surat->pengirim }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-building-shield"></i> Ditujukan</dt>
                        <dd>{{ $surat->penerima }}</dd>
                    </div>
                    @if($surat->keterangan)
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-note-sticky"></i> Keterangan / Alasan</dt>
                        <dd class="dt-teks">{{ $surat->keterangan }}</dd>
                    </div>
                    @endif
                    @if($surat->file_path)
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-paperclip"></i> Dokumen Lampiran</dt>
                        <dd class="dt-file">
                            <span class="dt-file__nama"><span class="ds-avatar ds-avatar--sq"><i class="fa-solid fa-file"></i></span>{{ basename($surat->file_path) }}</span>
                            <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank" rel="noopener" class="ds-btn ds-btn--primary ds-btn--sm">
                                <i class="fa-solid fa-download"></i> Lihat / Unduh
                            </a>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Respon satuan pengasuhan --}}
            <div class="ds-card">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-comment-dots ds-icon"></i> Respon Pengasuhan</h3>
                    <p class="ds-card__desc">Keputusan dan catatan dari satuan pengasuhan</p>
                </div>

                @php
                    [$judulRespon, $pesanRespon] = match($surat->status) {
                        'Disetujui' => ['Surat Disetujui', $surat->catatan_pengasuhan ?: 'Permohonan surat Anda telah disetujui. Silakan hubungi satuan pengasuhan untuk proses selanjutnya.'],
                        'Ditolak'   => ['Alasan Penolakan', $surat->catatan_pengasuhan ?: 'Pengajuan surat Anda tidak dapat disetujui. Silakan hubungi satuan pengasuhan untuk informasi lebih lanjut.'],
                        'Selesai'   => ['Surat Selesai', $surat->catatan_pengasuhan ?: 'Permohonan surat telah selesai diproses oleh satuan pengasuhan.'],
                        default     => ['Menunggu Keputusan', 'Permohonan surat Anda sedang dalam proses peninjauan. Anda akan menerima notifikasi ketika keputusan telah dibuat.'],
                    };
                @endphp
                <div class="ds-alert dt-respon dt-respon--{{ $varian }}" role="status">
                    <span class="dt-respon__ikon"><i class="fa-solid {{ $ikon }}"></i></span>
                    <div>
                        <div class="dt-respon__judul">{{ $judulRespon }}</div>
                        <div class="dt-respon__pesan">{{ $pesanRespon }}</div>
                    </div>
                </div>

                <div class="dt-waktu">
                    <span><i class="fa-solid fa-clock"></i>Diajukan {{ $surat->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fa-solid fa-rotate"></i>Diperbarui {{ $surat->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>

    </div>
</main>
</x-app-layout>
