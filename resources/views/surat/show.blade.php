<x-app-layout>
<x-form-glass-style />
<style>
    .sr-kembali { font-size: 13px; background: var(--glass-solid); color: var(--ink-800); }
    .sr-kembali:hover { color: var(--accent-ink); }
    .sr-nav { display: flex; align-items: center; justify-content: space-between; gap: var(--space-2); flex-wrap: wrap; }
    .sr-nav__kanan { display: flex; gap: var(--space-2); flex-wrap: wrap; }
    .sr-nav__kanan form { margin: 0; }

    .sr-tindakan { display: flex; flex-direction: column; gap: var(--space-2); margin-top: var(--space-3); }
    .sr-tindakan .ds-btn { width: 100%; justify-content: center; padding-top: var(--space-2-5); padding-bottom: var(--space-2-5); }
    .sr-btn--setuju { background: var(--success); border-color: transparent; color: var(--ink-on-dark); }
    .sr-btn--setuju:hover { background: var(--success-ink); }
    .sr-btn--tolak { color: var(--danger-ink); }
    .sr-final { margin-top: var(--space-3); font-size: 11px; line-height: 16px; font-weight: 600; color: var(--ink-600); text-align: center; }

    #modalOverlay textarea.form-control { resize: vertical; min-height: 90px; }
    #modalOverlay .form-group { text-align: left; }
</style>

<x-island-navbar />

@php
    $varian = $surat->status_varian;
    $ikon = match($surat->status) {
        'Disetujui' => 'fa-circle-check',
        'Ditolak'   => 'fa-circle-xmark',
        'Selesai'   => 'fa-flag-checkered',
        default     => 'fa-hourglass-half',
    };
    $desc = match($surat->status) {
        'Disetujui' => 'Surat sudah disetujui.',
        'Ditolak'   => 'Surat ditolak.',
        'Selesai'   => 'Surat sudah selesai diproses.',
        default     => 'Surat masih diproses — setujui atau tolak permohonan ini.',
    };
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Detail Surat" icon="fa-envelope-open-text"
            subtitle="Tinjau isi surat, putuskan permohonan, dan kirim catatan untuk taruna" />

        <div class="sr-nav mb-4">
            <a href="{{ route('surat.index') }}" class="ds-btn ds-btn--pill sr-kembali"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Surat</a>
            <div class="sr-nav__kanan">
                <a href="{{ route('surat.edit', $surat->id) }}" class="ds-btn ds-btn--pill sr-kembali"><i class="fa-solid fa-pen"></i> Ubah</a>
                <form method="POST" action="{{ route('surat.destroy', $surat->id) }}"
                      data-konfirmasi="Surat &quot;{{ Str::limit($surat->perihal, 60) }}&quot; akan dihapus permanen dari sistem." data-konfirmasi-judul="Hapus Surat?" data-konfirmasi-tombol="Ya, Hapus">
                    @csrf @method('DELETE')
                    <button type="submit" class="ds-btn ds-btn--pill ds-btn--danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </div>
        </div>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        {{-- Status surat --}}
        <div class="ds-card dt-card mb-4">
            <span class="ds-stat__icon {{ $varian !== 'accent' ? 'ds-stat__icon--' . $varian : '' }}"><i class="fa-solid {{ $ikon }}"></i></span>
            <div class="dt-card__body">
                <span class="dt-card__label">Status Surat{{ $surat->nomor_surat ? ' · No. ' . $surat->nomor_surat : '' }}</span>
                <div class="dt-card__top">
                    <span class="dt-card__value">{{ $surat->status }}</span>
                    <span class="ds-badge ds-badge--info">{{ $surat->jenis_surat }}</span>
                    @if($surat->isDiajukanTaruna())
                    <span class="ds-badge ds-badge--warning"><i class="fa-solid fa-user-graduate"></i> Diajukan taruna: {{ $surat->diajukan_oleh ?? $surat->pengirim }}</span>
                    @endif
                </div>
                <p class="dt-card__desc">{{ $desc }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
            {{-- Informasi surat --}}
            <div class="ds-card lg:col-span-2">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-circle-info ds-icon"></i> Informasi Surat</h3>
                    <p class="ds-card__desc">{{ $surat->jenis_surat }}</p>
                </div>

                <dl class="dt-fields">
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-heading"></i> Perihal</dt>
                        <dd>{{ $surat->perihal }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-paper-plane"></i> Pengirim</dt>
                        <dd>{{ $surat->pengirim }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-inbox"></i> Penerima</dt>
                        <dd>{{ $surat->penerima }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-calendar"></i> Tanggal Surat</dt>
                        <dd>{{ $surat->tanggal_surat->locale('id')->isoFormat('dddd, D MMMM Y') }}</dd>
                    </div>
                    <div class="dt-field">
                        <dt><i class="fa-solid fa-calendar-check"></i> Tanggal Diterima</dt>
                        <dd>{{ $surat->tanggal_terima ? $surat->tanggal_terima->locale('id')->isoFormat('dddd, D MMMM Y') : '—' }}</dd>
                    </div>
                    @if($surat->keterangan)
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-note-sticky"></i> Keterangan</dt>
                        <dd class="dt-teks">{{ $surat->keterangan }}</dd>
                    </div>
                    @endif
                    @if($surat->file_path)
                    <div class="dt-field dt-field--full">
                        <dt><i class="fa-solid fa-paperclip"></i> Dokumen Lampiran</dt>
                        <dd class="dt-file">
                            <span class="dt-file__nama"><span class="ds-avatar ds-avatar--sq"><i class="fa-solid fa-file"></i></span>{{ basename($surat->file_path) }}</span>
                            <a href="{{ Storage::url($surat->file_path) }}" target="_blank" rel="noopener" class="ds-btn ds-btn--primary ds-btn--sm"><i class="fa-solid fa-download"></i> Lihat / Unduh</a>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Keputusan pengasuh --}}
            <div class="ds-card">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-user-shield ds-icon"></i> Keputusan</h3>
                    <p class="ds-card__desc">{{ $surat->isDiajukanTaruna() ? 'Keputusan dikirim sebagai notifikasi ke taruna' : 'Perbarui status surat' }}</p>
                </div>

                <div class="ds-alert dt-respon dt-respon--{{ $varian }}" role="status">
                    <span class="dt-respon__ikon"><i class="fa-solid fa-comment-dots"></i></span>
                    <div>
                        <div class="dt-respon__judul">Catatan Pengasuhan</div>
                        <div class="dt-respon__pesan">{{ $surat->catatan_pengasuhan ?: 'Belum ada catatan.' }}</div>
                    </div>
                </div>

                @if($surat->status === 'Diproses')
                <div class="sr-tindakan">
                    <button type="button" class="ds-btn sr-btn--setuju" onclick="openModal('approve')"><i class="fa-solid fa-circle-check"></i> Setujui Surat</button>
                    <button type="button" class="ds-btn sr-btn--tolak" onclick="openModal('reject')"><i class="fa-solid fa-circle-xmark"></i> Tolak Surat</button>
                </div>
                @else
                <p class="sr-final"><i class="fa-solid fa-circle-info"></i> Status dapat diubah kembali melalui tombol Ubah.</p>
                @endif

                <div class="dt-waktu">
                    <span><i class="fa-solid fa-clock"></i>Dibuat {{ $surat->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    <span><i class="fa-solid fa-rotate"></i>Diperbarui {{ $surat->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                </div>
            </div>
        </div>

    </div>
</main>

<x-konfirmasi-modal />

{{-- Form yang dikirim modal --}}
<form method="POST" action="{{ route('surat.updateStatus', $surat->id) }}" id="statusForm" style="display:none;">
    @csrf @method('PATCH')
    <input type="hidden" name="status" id="statusInput">
    <input type="hidden" name="catatan_pengasuhan" id="catatanInput">
</form>

{{-- Modal keputusan (di luar panel kaca agar position:fixed tidak terkurung backdrop-filter) --}}
<div class="ds-modal-overlay" id="modalOverlay" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="ds-modal">
        <div class="ds-modal__icon" id="modalIcon"><i class="fa-solid fa-circle-check"></i></div>
        <h3 class="ds-modal__title" id="modalTitle">Konfirmasi</h3>
        <p class="ds-modal__body" id="modalDesc"></p>
        <div class="form-group">
            <label class="form-label" for="modalCatatan">Catatan untuk Taruna <span style="text-transform:none; letter-spacing:0; color:var(--ink-500);">(opsional)</span></label>
            <textarea class="form-control" id="modalCatatan" placeholder="Tulis catatan atau pesan untuk taruna..."></textarea>
        </div>
        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" onclick="closeModal()">Batal</button>
            <button type="button" class="ds-btn ds-btn--primary" id="modalConfirmBtn" onclick="submitModal()">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
let currentAction = null;

// [judul, deskripsi, tombol, ikon, warna token]
const MODAL_AKSI = {
    approve: ['Setujui Surat', 'Surat akan disetujui. Tambahkan catatan atau pesan untuk taruna bila perlu.', 'Ya, Setujui', 'fa-circle-check', 'success'],
    reject:  ['Tolak Surat', 'Surat akan ditolak. Tuliskan alasan penolakan agar taruna memahami keputusan ini.', 'Ya, Tolak', 'fa-circle-xmark', 'danger'],
};

function openModal(action) {
    const [judul, deskripsi, tombol, ikon, warna] = MODAL_AKSI[action];
    currentAction = action;
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
    currentAction = null;
}

function submitModal() {
    if (!currentAction) return;
    document.getElementById('statusInput').value  = currentAction === 'approve' ? 'Disetujui' : 'Ditolak';
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
