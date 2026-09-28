<x-app-layout>
<x-form-glass-style />
<style>
    .rw-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .rw-kembali:hover { color: var(--accent-ink); }
    .ds-stat__icon--info { background: linear-gradient(135deg, #0ea5e9, var(--info)); }

    .rw-tindakan { display: flex; flex-direction: column; gap: var(--space-2); margin-top: var(--space-3); }
    .rw-tindakan .ds-btn { width: 100%; justify-content: center; padding-top: var(--space-2-5); padding-bottom: var(--space-2-5); }
    .rw-btn--proses  { background: var(--info-tint); border-color: transparent; color: var(--info-ink); }
    .rw-btn--setuju  { background: var(--success); border-color: transparent; color: var(--ink-on-dark); }
    .rw-btn--setuju:hover { background: var(--success-ink); }
    .rw-btn--tolak   { color: var(--danger-ink); }
    .rw-final { margin-top: var(--space-3); font-size: 11px; line-height: 16px; font-weight: 600; color: var(--ink-600); text-align: center; }

    #modalOverlay textarea.form-control { resize: vertical; min-height: 90px; }
    #modalOverlay .form-group { text-align: left; }
</style>

<x-island-navbar />

@php
    $varian = $reward->status_varian;
    $ikon = match($reward->status) {
        'Disetujui' => 'fa-circle-check',
        'Ditolak'   => 'fa-circle-xmark',
        'Diproses'  => 'fa-spinner',
        default     => 'fa-hourglass-half',
    };
    $desc = match($reward->status) {
        'Disetujui' => 'Reward sudah disetujui dan diberikan kepada taruna.',
        'Ditolak'   => 'Pengajuan reward ditolak.',
        'Diproses'  => 'Pengajuan sedang ditinjau — setujui bila prestasi sudah terverifikasi.',
        default     => 'Pengajuan baru masuk — proses untuk mulai meninjau, atau tolak bila tidak memenuhi syarat.',
    };
    $respVarian = ['success' => 'success', 'danger' => 'danger', 'warning' => 'warning'][$varian] ?? 'accent';
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Detail Reward Taruna" icon="fa-award"
            subtitle="Tinjau prestasi, putuskan pengajuan, dan catat reward yang diberikan" />

        <a href="{{ route('reward.kelola') }}" class="ds-btn ds-btn--pill rw-kembali mb-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Reward
        </a>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif

        {{-- Status pengajuan --}}
        <div class="ds-card dt-card mb-4">
            <span class="ds-stat__icon ds-stat__icon--{{ $varian }}"><i class="fa-solid {{ $ikon }}"></i></span>
            <div class="dt-card__body">
                <span class="dt-card__label">Status Pengajuan · {{ $reward->nama }}</span>
                <div class="dt-card__top">
                    <span class="dt-card__value">{{ $reward->status }}</span>
                    <span class="ds-badge ds-badge--info">{{ $reward->kategori }} · {{ ucfirst($reward->jenis) }}{{ $reward->jenis === 'kelompok' ? ' (' . $reward->jumlah_anggota . ' orang)' : '' }}</span>
                </div>
                <p class="dt-card__desc">{{ $desc }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
            {{-- Informasi prestasi --}}
            <div class="ds-card lg:col-span-2">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-circle-info ds-icon"></i> Informasi Prestasi</h3>
                    <p class="ds-card__desc">Data yang dikirim taruna saat mengajukan reward</p>
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
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($file) }}" target="_blank" rel="noopener" class="ds-btn ds-btn--primary ds-btn--sm"><i class="fa-solid fa-download"></i> Lihat / Unduh</a>
                        </dd>
                        @endforeach
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Keputusan pengasuh --}}
            <div class="ds-card">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-user-shield ds-icon"></i> Keputusan</h3>
                    <p class="ds-card__desc">Keputusan dikirim sebagai notifikasi ke taruna</p>
                </div>

                <div class="ds-alert dt-respon dt-respon--{{ $respVarian }}" role="status">
                    <span class="dt-respon__ikon"><i class="fa-solid fa-gift"></i></span>
                    <div>
                        <div class="dt-respon__judul">Catatan Reward</div>
                        <div class="dt-respon__pesan">{{ $reward->catatan_pengasuhan ?: 'Belum ada catatan reward untuk taruna.' }}</div>
                    </div>
                </div>

                @if(in_array($reward->status, ['Diajukan', 'Diproses']))
                <div class="rw-tindakan">
                    @if($reward->status === 'Diajukan')
                    <button type="button" class="ds-btn rw-btn--proses" onclick="openModal('Diproses')"><i class="fa-solid fa-spinner"></i> Proses Pengajuan</button>
                    @else
                    <button type="button" class="ds-btn rw-btn--setuju" onclick="openModal('Disetujui')"><i class="fa-solid fa-circle-check"></i> Setujui Reward</button>
                    @endif
                    <button type="button" class="ds-btn rw-btn--tolak" onclick="openModal('Ditolak')"><i class="fa-solid fa-circle-xmark"></i> Tolak Pengajuan</button>
                </div>
                @else
                <p class="rw-final"><i class="fa-solid fa-lock"></i> Pengajuan sudah {{ strtolower($reward->status) }} — status tidak dapat diubah lagi.</p>
                @endif

                <div class="dt-waktu">
                    <span><i class="fa-solid fa-clock"></i>Diajukan {{ $reward->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fa-solid fa-rotate"></i>Diperbarui {{ $reward->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>

    </div>
</main>

<form method="POST" action="{{ route('reward.updateStatus', $reward->id) }}" id="statusForm" style="display:none;">
    @csrf @method('PATCH')
    <input type="hidden" name="status" id="statusInput">
    <input type="hidden" name="catatan_pengasuhan" id="catatanInput">
</form>

{{-- Modal keputusan (di luar panel kaca agar position:fixed tidak terkurung backdrop-filter) --}}
<div class="ds-modal-overlay" id="modalOverlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="ds-modal">
        <div class="ds-modal__icon" id="modalIcon"><i class="fa-solid fa-spinner"></i></div>
        <h3 class="ds-modal__title" id="modalTitle">Konfirmasi</h3>
        <p class="ds-modal__body" id="modalDesc"></p>
        <div class="form-group">
            <label class="form-label" for="modalCatatan">Catatan untuk Taruna <span style="text-transform:none; letter-spacing:0; color:var(--ink-500);">(opsional)</span></label>
            <textarea class="form-control" id="modalCatatan" placeholder="Contoh: mendapatkan barang, jajan, atau tambahan poin pengasuhan..."></textarea>
        </div>
        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" onclick="closeModal()">Batal</button>
            <button type="button" class="ds-btn ds-btn--primary" id="modalConfirmBtn" onclick="submitModal()">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
let currentStatus = null;

// [judul, deskripsi, tombol, ikon, warna token]
const MODAL_STATUS = {
    Diproses:  ['Proses Pengajuan', 'Pengajuan reward akan mulai ditinjau. Tambahkan catatan untuk taruna bila perlu.', 'Ya, Proses', 'fa-spinner', 'info'],
    Disetujui: ['Setujui Reward', 'Reward akan disetujui. Tuliskan reward yang didapatkan taruna, misalnya barang, jajan, atau tambahan poin pengasuhan.', 'Ya, Setujui', 'fa-circle-check', 'success'],
    Ditolak:   ['Tolak Pengajuan', 'Pengajuan reward akan ditolak. Tuliskan alasan penolakan agar taruna memahami keputusan ini.', 'Ya, Tolak', 'fa-circle-xmark', 'danger'],
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
