<x-app-layout>
<style>
    .reward-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .reward-kembali:hover { color: var(--accent-ink); }
</style>

<x-island-navbar />

@php
    // Varian sama dengan badge status di daftar reward
    [$varian, $ikon, $desc] = match($reward->status) {
        'Disetujui' => ['success', 'fa-circle-check',  'Pengajuan reward Anda telah disetujui oleh satuan pengasuhan.'],
        'Ditolak'   => ['danger',  'fa-circle-xmark',  'Pengajuan reward Anda ditolak. Lihat alasan pada respon pengasuhan.'],
        'Diproses'  => ['accent',  'fa-spinner',       'Pengajuan reward Anda sedang ditinjau oleh satuan pengasuhan.'],
        default     => ['warning', 'fa-hourglass-half', 'Pengajuan reward Anda sudah terkirim dan menunggu ditinjau satuan pengasuhan.'],
    };
    [$judulRespon, $pesanRespon] = match($reward->status) {
        'Disetujui' => ['Reward Disetujui', $reward->catatan_pengasuhan ?: 'Prestasi Anda telah diakui dan reward disetujui oleh satuan pengasuhan.'],
        'Ditolak'   => ['Alasan Penolakan', $reward->catatan_pengasuhan ?: 'Pengajuan reward Anda tidak dapat disetujui. Silakan hubungi satuan pengasuhan untuk informasi lebih lanjut.'],
        'Diproses'  => ['Sedang Ditinjau', $reward->catatan_pengasuhan ?: 'Pengajuan sedang ditinjau. Anda akan menerima notifikasi ketika keputusan telah dibuat.'],
        default     => ['Menunggu Tinjauan', 'Pengajuan reward Anda belum ditinjau. Anda akan menerima notifikasi ketika statusnya berubah.'],
    };
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Detail Reward Prestasi" icon="fa-award"
            subtitle="Pantau status dan respon satuan pengasuhan atas pengajuan reward Anda" />

        <a href="{{ route('reward.index') }}" class="ds-btn ds-btn--pill reward-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Reward
        </a>

        {{-- Status pengajuan --}}
        <div class="ds-card dt-card mb-4">
            <span class="ds-stat__icon {{ $varian !== 'accent' ? 'ds-stat__icon--'.$varian : '' }}"><i class="fa-solid {{ $ikon }}"></i></span>
            <div class="dt-card__body">
                <span class="dt-card__label">Status Pengajuan</span>
                <div class="dt-card__top">
                    <span class="dt-card__value">{{ $reward->status }}</span>
                    <span class="ds-badge ds-badge--info">{{ $reward->kategori }} · {{ ucfirst($reward->jenis) }}</span>
                </div>
                <p class="dt-card__desc">{{ $desc }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            {{-- Informasi pengajuan --}}
            <div class="ds-card lg:col-span-2">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-circle-info ds-icon"></i> Informasi Prestasi</h3>
                    <p class="ds-card__desc">Data yang Anda kirim saat mengajukan reward</p>
                </div>

                <dl class="dt-fields">
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-medal"></i> Kategori Prestasi</dt>
                        <dd>{{ $reward->kategori }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-calendar"></i> Tanggal Prestasi</dt>
                        <dd>{{ $reward->tanggal_prestasi->locale('id')->isoFormat('dddd, D MMMM Y') }}</dd>
                    </div>
                    <div class="dt-field {{ $reward->jenis === 'kelompok' ? '' : 'dt-field--full' }}">
                        <dt><i class="fa-solid {{ $reward->jenis === 'kelompok' ? 'fa-users' : 'fa-user' }}"></i> Jenis Pengajuan</dt>
                        <dd>{{ ucfirst($reward->jenis) }}</dd>
                    </div>
                    @if($reward->jenis === 'kelompok')
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-people-group"></i> Jumlah Anggota</dt>
                        <dd>{{ $reward->jumlah_anggota }} orang</dd>
                    </div>
                    @endif
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-user"></i> Nama Pengaju</dt>
                        <dd>{{ $reward->nama }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-id-card"></i> NPM</dt>
                        <dd>{{ $reward->npm ?? '-' }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-envelope"></i> Email</dt>
                        <dd>{{ $reward->email }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-graduation-cap"></i> Program Studi</dt>
                        <dd>{{ $reward->prodi ?? '-' }} — {{ $reward->prodi_nama }}</dd>
                    </div>
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-note-sticky"></i> Keterangan Prestasi</dt>
                        <dd class="dt-teks">{{ $reward->keterangan }}</dd>
                    </div>
                    @if(!empty($reward->dokumen))
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-paperclip"></i> Dokumentasi ({{ count($reward->dokumen) }})</dt>
                        @foreach($reward->dokumen as $file)
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
                    <p class="ds-card__desc">Keputusan dan catatan reward dari satuan pengasuhan</p>
                </div>

                <div class="ds-alert dt-respon dt-respon--{{ $varian }}" role="status">
                    <span class="dt-respon__ikon"><i class="fa-solid {{ $ikon }}"></i></span>
                    <div>
                        <div class="dt-respon__judul">{{ $judulRespon }}</div>
                        <div class="dt-respon__pesan">{{ $pesanRespon }}</div>
                    </div>
                </div>

                <div class="dt-waktu">
                    <span><i class="fa-solid fa-clock"></i>Diajukan {{ $reward->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fa-solid fa-rotate"></i>Diperbarui {{ $reward->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>

    </div>
</main>
</x-app-layout>
