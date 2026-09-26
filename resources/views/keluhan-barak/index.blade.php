<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="barak-page spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

                {{-- Header — sama dengan header tab dashboard & poin --}}
                <x-page-banner title="Keluhan Barak Saya" icon="fa-door-open"
                    subtitle="Pantau status pengajuan perbaikan fasilitas dan kendala barak Anda secara real-time" />

                <style>
                    .barak-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
                    .barak-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
                    .barak-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }
                    .barak-ket { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
                    .barak-baru { width: 8px; height: 8px; border-radius: 50%; background: var(--danger); box-shadow: 0 0 0 3px var(--danger-tint); }
                </style>

                {{-- Tombol ajukan — di bawah header --}}
                <div class="ds-card barak-aksi mb-4">
                    <span class="barak-aksi__teks"><i class="fa-solid fa-screwdriver-wrench"></i>Ada kerusakan sarana atau kendala fasilitas di barak Anda?</span>
                    <a href="{{ route('keluhan-barak.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Ajukan Keluhan Baru</a>
                </div>

                @if(session('success'))
                <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
                @endif

                <div class="ds-card">
                    <div class="ds-card__head tbl-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-clipboard-list ds-icon"></i> Daftar Keluhan Saya</h3>
                            <p class="ds-card__desc">Keluhan terbaru tampil paling atas — klik baris untuk melihat detail</p>
                        </div>
                        <span class="ds-badge ds-badge--accent">{{ $daftarKeluhan->count() }} keluhan</span>
                    </div>

                    @if($daftarKeluhan->isEmpty())
                    <div class="ds-empty">
                        <i class="fa-solid fa-door-open ds-icon"></i>
                        Belum ada riwayat keluhan barak.
                    </div>
                    @else
                    @php
                        $varianStatus = ['Diajukan' => 'warning', 'Diproses' => 'info', 'Selesai' => 'success', 'Ditolak' => 'danger'];
                    @endphp
                    <div class="ds-table-wrap">
                        <div class="ds-scroll">
                            <table class="ds-table tbl-table">
                                <thead>
                                    <tr>
                                        <th>Lokasi Barak</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th data-filter>Status</th>
                                        <th class="ds-right" data-no-sort>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($daftarKeluhan as $k)
                                    <tr onclick="window.location='{{ route('keluhan-barak.show', $k->id) }}'" style="cursor:pointer;">
                                        <td>
                                            <div class="ds-cell-person">
                                                <span class="ds-avatar ds-avatar--sq"><i class="fa-solid fa-door-open"></i></span>
                                                <div>
                                                    <div class="tbl-title">{{ $k->lorong }} &bull; No. {{ $k->nomor_barak }}</div>
                                                    <div class="tbl-sub">Asrama {{ $k->asrama }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="tbl-date" data-sort="{{ $k->tanggal_pengajuan->format('Y-m-d') }}">{{ $k->tanggal_pengajuan->locale('id')->isoFormat('D MMM Y') }}</td>
                                        <td><div class="tbl-sub barak-ket" style="margin:0;" title="{{ $k->keterangan }}">{{ $k->keterangan }}</div></td>
                                        <td>
                                            <span class="ds-badge ds-badge--{{ $varianStatus[$k->status] ?? 'dark' }}">
                                                {{ $k->status }}
                                                @if(!$k->taruna_baca && in_array($k->status, ['Diproses', 'Selesai', 'Ditolak']))
                                                <span class="barak-baru" title="Pembaruan status baru"></span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="ds-right">
                                            <a href="{{ route('keluhan-barak.show', $k->id) }}" class="ds-btn ds-btn--sm ds-btn--pill">Detail <i class="fa-solid fa-arrow-right"></i></a>
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

<div class="toast-container" id="toastContainer"></div>

<script>
let knownStatuses = {};

@foreach($daftarKeluhan as $k)
knownStatuses[{{ $k->id }}] = "{{ $k->status }}";
@endforeach

function showToast(keluhan) {
    const container = document.getElementById('toastContainer');
    const icon = keluhan.status === 'Ditolak' ? 'fa-times' : keluhan.status === 'Selesai' ? 'fa-check' : 'fa-spinner';
    const iconBg = keluhan.status === 'Ditolak' ? 'linear-gradient(135deg,#e53e3e,#fc5c7d)' : keluhan.status === 'Selesai' ? 'linear-gradient(135deg,#38a169,#48bb78)' : 'linear-gradient(135deg,#3182ce,#0bc5ea)';

    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <div class="toast-icon" style="background:${iconBg}"><i class="fas ${icon}"></i></div>
        <div class="toast-body">
            <div class="toast-title">Status Keluhan Berubah</div>
            <div class="toast-msg">Keluhan <strong>${keluhan.asrama} ${keluhan.lorong} No. ${keluhan.barak}</strong> sekarang <strong>${keluhan.status}</strong>.</div>
        </div>
        <button class="toast-close" onclick="document.getElementById('${toastId}').remove()">×</button>
    `;
    toast.id = toastId;
    container.appendChild(toast);

    setTimeout(() => {
        const el = document.getElementById(toastId);
        if (el) el.style.animation = 'none', el.style.opacity = '0', el.style.transition = 'opacity .4s', setTimeout(() => el.remove(), 400);
    }, 8000);
}

function pollNotifications() {
    fetch("{{ route('api.keluhanNotifications') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                data.unread.forEach(k => {
                    if (knownStatuses[k.id] !== k.status) {
                        showToast(k);
                        knownStatuses[k.id] = k.status;
                    }
                });
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(() => {});
}

setInterval(pollNotifications, 5000);
</script>

</x-app-layout>
