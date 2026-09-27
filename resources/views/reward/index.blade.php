<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab surat & barak --}}
        <x-page-banner title="Reward Prestasi Saya" icon="fa-award"
            subtitle="Pantau status pengajuan reward, rekomendasi pengasuhan, dan poin prestasi Anda" />

        <style>
            .reward-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
            .reward-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
            .reward-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }
            .reward-ket { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            .reward-baru { width: 8px; height: 8px; border-radius: 50%; background: var(--danger); box-shadow: 0 0 0 3px var(--danger-tint); }
        </style>

        {{-- Tombol ajukan — kartu di bawah header, pola tab surat & barak --}}
        <div class="ds-card reward-aksi mb-4">
            <span class="reward-aksi__teks"><i class="fa-solid fa-trophy"></i>Punya prestasi akademik atau non-akademik yang ingin dilaporkan?</span>
            <a href="{{ route('reward.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Ajukan Reward Baru</a>
        </div>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif

        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-award ds-icon"></i> Daftar Pengajuan Reward</h3>
                    <p class="ds-card__desc">Pengajuan terbaru tampil paling atas — klik baris untuk melihat detail</p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ $daftarReward->count() }} pengajuan</span>
            </div>

            @if($daftarReward->isEmpty())
            <div class="ds-empty">
                <i class="fa-solid fa-award ds-icon"></i>
                Belum ada pengajuan reward prestasi.
            </div>
            @else
            @php
                $varianStatus = ['Diajukan' => 'warning', 'Diproses' => 'info', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
            @endphp
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table">
                        <thead>
                            <tr>
                                <th data-filter>Kategori</th>
                                <th data-filter>Jenis</th>
                                <th>Tanggal Prestasi</th>
                                <th>Keterangan</th>
                                <th data-filter>Status</th>
                                <th class="ds-right" data-no-sort>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarReward as $r)
                            <tr onclick="window.location='{{ route('reward.show', $r->id) }}'" style="cursor:pointer;">
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar ds-avatar--sq"><i class="fa-solid {{ $r->kategori === 'Akademik' ? 'fa-graduation-cap' : 'fa-medal' }}"></i></span>
                                        <div class="tbl-title">{{ $r->kategori }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="ds-badge ds-badge--info">
                                        <i class="fa-solid {{ $r->jenis === 'kelompok' ? 'fa-users' : 'fa-user' }}"></i>
                                        {{ ucfirst($r->jenis) }}{{ $r->jenis === 'kelompok' ? ' ('.$r->jumlah_anggota.' org)' : '' }}
                                    </span>
                                </td>
                                <td class="tbl-date" data-sort="{{ $r->tanggal_prestasi->format('Y-m-d') }}">{{ $r->tanggal_prestasi->locale('id')->isoFormat('D MMM Y') }}</td>
                                <td><div class="tbl-sub reward-ket" style="margin:0;" title="{{ $r->keterangan }}">{{ $r->keterangan }}</div></td>
                                <td>
                                    <span class="ds-badge ds-badge--{{ $varianStatus[$r->status] ?? 'dark' }}">
                                        {{ $r->status }}
                                        @if(!$r->taruna_baca && in_array($r->status, ['Diproses', 'Disetujui', 'Ditolak']))
                                        <span class="reward-baru" title="Pembaruan status baru"></span>
                                        @endif
                                    </span>
                                </td>
                                <td class="ds-right">
                                    <a href="{{ route('reward.show', $r->id) }}" class="ds-btn ds-btn--sm ds-btn--pill">Detail <i class="fa-solid fa-arrow-right"></i></a>
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

@foreach($daftarReward as $r)
knownStatuses[{{ $r->id }}] = "{{ $r->status }}";
@endforeach

function showToast(reward) {
    showStatusToast({
        judul: 'Status Reward Berubah',
        pesan: `Pengajuan reward Anda sekarang ${reward.status}.`,
        sub: `Prestasi ${reward.kategori}`,
        varian: { Disetujui: 'success', Ditolak: 'danger' }[reward.status] || 'info',
    });
}

function pollNotifications() {
    fetch("{{ route('api.rewardNotifications') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                data.unread.forEach(r => {
                    if (knownStatuses[r.id] !== r.status) {
                        showToast(r);
                        knownStatuses[r.id] = r.status;
                    }
                });
                setTimeout(() => location.reload(), 4000);
            }
        })
        .catch(() => {});
}

setInterval(pollNotifications, 5000);
</script>

</x-app-layout>
