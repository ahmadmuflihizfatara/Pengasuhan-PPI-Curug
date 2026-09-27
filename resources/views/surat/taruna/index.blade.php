<x-app-layout>
<style>
/* Kartu tombol ajukan — sama dengan .barak-aksi */
.surat-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
.surat-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
.surat-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }

/* Notif badge */
.notif-dot { width:8px; height:8px; background:var(--danger); border-radius:50%; display:inline-block; margin-left:2px; animation:pulse 1.5s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab poin & log gerbang --}}
        <x-page-banner title="Pengajuan Surat Saya" icon="fa-file-signature"
            subtitle="Ajukan permohonan surat kepada satuan pengasuhan" />

        {{-- Tombol ajukan — kartu di bawah header, pola tab barak --}}
        <div class="ds-card surat-aksi mb-4">
            <span class="surat-aksi__teks"><i class="fa-solid fa-envelope-open-text"></i>Butuh surat izin, keterangan, atau permohonan lain dari pengasuhan?</span>
            <a href="{{ route('surat-taruna.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Ajukan Surat Baru</a>
        </div>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif

        {{-- Tabel surat — pola tabel dashboard & konsinyir --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-envelope-open-text ds-icon"></i> Riwayat Pengajuan Surat</h3>
                    <p class="ds-card__desc">Status pengajuan diperbarui otomatis setelah diperiksa pengasuh</p>
                </div>
                <span class="ds-badge">{{ $surat->count() }} surat</span>
            </div>

            @if($surat->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-file-signature ds-icon"></i>
                Belum ada pengajuan surat. Klik "Ajukan Surat Baru" untuk mengajukan permohonan.
            </div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table">
                        <thead>
                            <tr>
                                <th data-filter>Jenis Surat</th>
                                <th>Perihal</th>
                                <th>Tanggal Ajukan</th>
                                <th data-filter>Status</th>
                                <th class="ds-right" data-no-sort data-no-filter>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surat as $s)
                            @php
                                [$statusVarian, $statusIcon] = match($s->status) {
                                    'Disetujui' => ['success', 'fa-circle-check'],
                                    'Ditolak'   => ['danger',  'fa-circle-xmark'],
                                    'Selesai'   => ['accent',  'fa-flag-checkered'],
                                    default     => ['warning', 'fa-spinner'],
                                };
                            @endphp
                            <tr>
                                <td><span class="ds-badge ds-badge--info">{{ $s->jenis_surat }}</span></td>
                                <td>
                                    <div class="tbl-title">{{ $s->perihal }}</div>
                                    @if($s->keterangan)<div class="tbl-sub">{{ Str::limit($s->keterangan, 50) }}</div>@endif
                                </td>
                                <td class="tbl-date" data-sort="{{ $s->tanggal_surat->format('Y-m-d') }}">{{ $s->tanggal_surat->locale('id')->isoFormat('D MMM Y') }}</td>
                                <td>
                                    <span class="ds-badge ds-badge--{{ $statusVarian }}">
                                        <i class="fa-solid {{ $statusIcon }}"></i> {{ $s->status }}
                                        @if(!$s->taruna_baca && in_array($s->status, ['Disetujui', 'Ditolak']))
                                        <span class="notif-dot"></span>
                                        @endif
                                    </span>
                                </td>
                                <td class="ds-right">
                                    <a href="{{ route('surat-taruna.show', $s->id) }}" class="ds-btn ds-btn--sm ds-btn--pill">Detail <i class="fa-solid fa-arrow-right"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

    </div>
</main>

<x-status-toast />

<script>
let knownStatuses = {};

// Inisialisasi status saat ini dari server
@foreach($surat as $s)
knownStatuses[{{ $s->id }}] = "{{ $s->status }}";
@endforeach

function showToast(perihal, status) {
    const disetujui = status === 'Disetujui';
    showStatusToast({
        judul: disetujui ? 'Surat Disetujui' : 'Surat Ditolak',
        pesan: disetujui ? 'Pengajuan surat Anda telah disetujui oleh pengasuhan.' : 'Pengajuan surat Anda ditolak. Buka detail untuk melihat alasan.',
        sub: perihal,
        varian: disetujui ? 'success' : 'danger',
    });
}

function pollNotifications() {
    fetch("{{ route('api.suratNotifications') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                data.unread.forEach(s => {
                    // Cek apakah status berubah
                    if (knownStatuses[s.id] !== s.status) {
                        showToast(s.perihal, s.status, s.id);
                        knownStatuses[s.id] = s.status;
                    }
                });
                // Reload tabel setelah 2 detik untuk memperbarui tampilan status
                setTimeout(() => location.reload(), 4000);
            }
        })
        .catch(() => {});
}

// Poll setiap 5 detik
setInterval(pollNotifications, 5000);
</script>
</x-app-layout>
