<x-app-layout>
<x-form-glass-style />
<style>
    .keluhan-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .keluhan-kembali:hover { color: var(--accent-ink); }
    .ds-stat__icon--info { background: linear-gradient(135deg, #0ea5e9, var(--info)); }

    .kb-tindakan { display: flex; flex-direction: column; gap: var(--space-2); margin-top: var(--space-3); }
    .kb-tindakan .ds-btn { width: 100%; justify-content: center; padding-top: var(--space-2-5); padding-bottom: var(--space-2-5); }
    .kb-btn--proses  { background: var(--info-tint); border-color: transparent; color: var(--info-ink); }
    .kb-btn--selesai { background: var(--success); border-color: transparent; color: var(--ink-on-dark); }
    .kb-btn--selesai:hover { background: var(--success-ink); }
    .kb-btn--tolak   { color: var(--danger-ink); }
    .kb-final { margin-top: var(--space-3); font-size: 11px; line-height: 16px; font-weight: 600; color: var(--ink-600); text-align: center; }

    #modalOverlay textarea.form-control { resize: vertical; min-height: 90px; }
    #modalOverlay .form-group { text-align: left; }
</style>

<x-island-navbar />

@php
    $varian = $keluhan->status_varian;
    $ikon = match($keluhan->status) {
        'Selesai'  => 'fa-circle-check',
        'Ditolak'  => 'fa-circle-xmark',
        'Diproses' => 'fa-screwdriver-wrench',
        default    => 'fa-hourglass-half',
    };
    $desc = match($keluhan->status) {
        'Selesai'  => 'Keluhan sudah selesai ditangani.',
        'Ditolak'  => 'Keluhan ditolak dan tidak diproses lebih lanjut.',
        'Diproses' => 'Keluhan sedang ditangani — tandai selesai bila perbaikan sudah tuntas.',
        default    => 'Keluhan baru masuk dan menunggu ditinjau — proses atau tolak keluhan ini.',
    };
    $respVarian = ['success' => 'success', 'danger' => 'danger', 'warning' => 'warning'][$varian] ?? 'accent';
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Detail Keluhan Barak" icon="fa-door-open"
            subtitle="Tinjau keluhan, perbarui status penanganan, dan kirim catatan untuk taruna" />

        <a href="{{ route('keluhan-barak.kelola') }}" class="ds-btn ds-btn--pill keluhan-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Keluhan
        </a>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif

        {{-- Status keluhan --}}
        <div class="ds-card dt-card mb-4">
            <span class="ds-stat__icon ds-stat__icon--{{ $varian }}"><i class="fa-solid {{ $ikon }}"></i></span>
            <div class="dt-card__body">
                <span class="dt-card__label">Status Keluhan · {{ $keluhan->nama }}</span>
                <div class="dt-card__top">
                    <span class="dt-card__value">{{ $keluhan->status }}</span>
                    <span class="ds-badge ds-badge--info">Asrama {{ $keluhan->asrama }} · {{ $keluhan->lorong }} · No. {{ $keluhan->nomor_barak }}</span>
                </div>
                <p class="dt-card__desc">{{ $desc }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
            {{-- Informasi keluhan --}}
            <div class="ds-card lg:col-span-2">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-circle-info ds-icon"></i> Informasi Keluhan</h3>
                    <p class="ds-card__desc">Data yang dikirim taruna saat mengajukan keluhan</p>
                </div>

                <dl class="dt-fields">
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-user"></i> Nama Pengaju</dt>
                        <dd>{{ $keluhan->nama }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-envelope"></i> Email</dt>
                        <dd>{{ $keluhan->email }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-graduation-cap"></i> Program Studi</dt>
                        <dd>{{ $keluhan->prodi }} — {{ $keluhan->prodi_nama }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-calendar"></i> Tanggal Pengajuan</dt>
                        <dd>{{ $keluhan->tanggal_pengajuan->locale('id')->isoFormat('dddd, D MMMM Y') }}</dd>
                    </div>
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-building"></i> Lokasi Barak</dt>
                        <dd>Asrama {{ $keluhan->asrama }} · {{ $keluhan->lorong }} · No. {{ $keluhan->nomor_barak }}</dd>
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

            {{-- Tindak lanjut pengasuh --}}
            <div class="ds-card">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-user-shield ds-icon"></i> Tindak Lanjut</h3>
                    <p class="ds-card__desc">Status baru akan dikirim sebagai notifikasi ke taruna</p>
                </div>

                <div class="ds-alert dt-respon dt-respon--{{ $respVarian }}" role="status">
                    <span class="dt-respon__ikon"><i class="fa-solid fa-comment-dots"></i></span>
                    <div>
                        <div class="dt-respon__judul">Catatan Pengasuhan</div>
                        <div class="dt-respon__pesan">{{ $keluhan->catatan_pengasuhan ?: 'Belum ada catatan untuk taruna.' }}</div>
                    </div>
                </div>

                @if(in_array($keluhan->status, ['Diajukan', 'Diproses']))
                <div class="kb-tindakan">
                    @if($keluhan->status === 'Diajukan')
                    <button type="button" class="ds-btn kb-btn--proses" onclick="openModal('Diproses')"><i class="fa-solid fa-screwdriver-wrench"></i> Proses Keluhan</button>
                    @else
                    <button type="button" class="ds-btn kb-btn--selesai" onclick="openModal('Selesai')"><i class="fa-solid fa-circle-check"></i> Tandai Selesai</button>
                    @endif
                    <button type="button" class="ds-btn kb-btn--tolak" onclick="openModal('Ditolak')"><i class="fa-solid fa-circle-xmark"></i> Tolak Keluhan</button>
                </div>
                @else
                <p class="kb-final"><i class="fa-solid fa-lock"></i> Keluhan sudah {{ strtolower($keluhan->status) }} — status tidak dapat diubah lagi.</p>
                @endif

                <div class="dt-waktu">
                    <span><i class="fa-solid fa-clock"></i>Diajukan {{ $keluhan->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fa-solid fa-rotate"></i>Diperbarui {{ $keluhan->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>

    </div>
</main>

<form method="POST" action="{{ route('keluhan-barak.updateStatus', $keluhan->id) }}" id="statusForm" style="display:none;">
    @csrf @method('PATCH')
    <input type="hidden" name="status" id="statusInput">
    <input type="hidden" name="catatan_pengasuhan" id="catatanInput">
</form>

{{-- Modal konfirmasi status (di luar panel kaca agar position:fixed tidak terkurung backdrop-filter) --}}
<div class="ds-modal-overlay" id="modalOverlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="ds-modal">
        <div class="ds-modal__icon" id="modalIcon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
        <h3 class="ds-modal__title" id="modalTitle">Konfirmasi</h3>
        <p class="ds-modal__body" id="modalDesc"></p>
        <div class="form-group">
            <label class="form-label" for="modalCatatan">Catatan untuk Taruna <span style="text-transform:none; letter-spacing:0; color:var(--ink-500);">(opsional)</span></label>
            <textarea class="form-control" id="modalCatatan" placeholder="Tulis catatan atau keterangan penanganan..."></textarea>
        </div>
        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" onclick="closeModal()">Batal</button>
            <button type="button" class="ds-btn ds-btn--primary" id="modalConfirmBtn" onclick="submitModal()">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
let currentStatus = null;

// Tampilan modal per status: [judul, deskripsi, label tombol, ikon, warna token]
const MODAL_STATUS = {
    Diproses: ['Proses Keluhan', 'Keluhan akan ditandai sedang ditangani. Tambahkan catatan untuk taruna bila perlu.', 'Ya, Proses', 'fa-screwdriver-wrench', 'info'],
    Selesai:  ['Selesaikan Keluhan', 'Keluhan akan ditandai selesai. Tambahkan catatan penanganan untuk taruna bila perlu.', 'Ya, Selesai', 'fa-circle-check', 'success'],
    Ditolak:  ['Tolak Keluhan', 'Keluhan akan ditolak. Tuliskan alasan penolakan agar taruna memahami keputusan ini.', 'Ya, Tolak', 'fa-circle-xmark', 'danger'],
};

function openModal(status) {
    const [judul, deskripsi, tombol, ikon, warna] = MODAL_STATUS[status];
    currentStatus = status;
    document.getElementById('modalTitle').textContent = judul;
    document.getElementById('modalDesc').textContent = deskripsi;
    document.getElementById('modalCatatan').value = '';

    const icon = document.getElementById('modalIcon');
    icon.innerHTML = '<i class="fa-solid ' + ikon + '"></i>';
    icon.style.background = 'var(--' + warna + '-tint)';
    icon.style.color = 'var(--' + warna + '-ink)';

    const btn = document.getElementById('modalConfirmBtn');
    btn.textContent = tombol;
    btn.style.background = 'var(--' + warna + ')';

    document.getElementById('modalOverlay').style.display = 'flex';
    document.getElementById('modalCatatan').focus();
}

function closeModal() {
    document.getElementById('modalOverlay').style.display = 'none';
    currentStatus = null;
}

function submitModal() {
    if (!currentStatus) return;
    document.getElementById('statusInput').value = currentStatus;
    document.getElementById('catatanInput').value = document.getElementById('modalCatatan').value;
    document.getElementById('statusForm').submit();
}

document.getElementById('modalOverlay').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
});
</script>
</x-app-layout>
