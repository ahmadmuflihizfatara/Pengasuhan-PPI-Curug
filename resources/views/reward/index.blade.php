<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Page Header Glass Banner --}}
                <div class="rounded-2xl bg-gradient-to-r from-amber-900/90 via-orange-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-amber-300 mb-2">
                            <span>✦</span>
                            <span>Prestasi Taruna</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-award text-amber-400"></i>
                            <span>Reward Prestasi Saya</span>
                        </h1>
                        <p class="text-xs text-amber-100/80">Pantau status pengajuan reward, rekomendasi pengasuhan, dan poin prestasi Anda</p>
                    </div>

                    <div class="relative z-10">
                        <a href="{{ route('reward.create') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-xs shadow-md transition flex items-center gap-2 no-underline">
                            <i class="fa-solid fa-plus text-amber-600"></i>
                            <span>Ajukan Reward Baru</span>
                        </a>
                    </div>

                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif
                @if(session('error'))
                <div class="rounded-2xl bg-rose-100/90 border border-rose-300 p-4 text-rose-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if($daftarReward->isEmpty())
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-10 text-center shadow-lg">
                    <i class="fa-solid fa-award text-4xl text-slate-300 mb-3 block"></i>
                    <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Pengajuan Reward Prestasi</h4>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mb-4">Laporkan prestasi perlombaan akademik, olahraga, atau kepemimpinan Anda untuk mendapatkan poin penghargaan.</p>
                    <a href="{{ route('reward.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 text-white text-xs font-bold shadow-md transition no-underline">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Ajukan Reward Pertama</span>
                    </a>
                </div>
                @else
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                    <th class="py-3 px-3">#</th>
                                    <th class="py-3 px-3">Kategori</th>
                                    <th class="py-3 px-3">Jenis</th>
                                    <th class="py-3 px-3">Tanggal Prestasi</th>
                                    <th class="py-3 px-3">Keterangan</th>
                                    <th class="py-3 px-3 text-center">Status</th>
                                    <th class="py-3 px-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/30">
                                @foreach($daftarReward as $i => $r)
                                <tr class="hover:bg-white/60 transition">
                                    <td class="py-3 px-3 text-slate-400 font-bold">{{ $i + 1 }}</td>
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-slate-900">{{ $r->kategori }}</div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px] border border-amber-200 inline-flex items-center gap-1">
                                            <i class="fa-solid {{ $r->jenis === 'kelompok' ? 'fa-users' : 'fa-user' }} text-[9px]"></i>
                                            <span>{{ ucfirst($r->jenis) }}{{ $r->jenis === 'kelompok' ? ' ('.$r->jumlah_anggota.' org)' : '' }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-slate-600 font-medium whitespace-nowrap">
                                        <i class="fa-solid fa-calendar text-amber-500 mr-1"></i>
                                        {{ $r->tanggal_prestasi->locale('id')->isoFormat('D MMM Y') }}
                                    </td>
                                    <td class="py-3 px-3 max-w-[260px]">
                                        <div class="text-slate-800 font-medium truncate">{{ $r->keterangan }}</div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] inline-flex items-center gap-1.5" style="background:{{ $r->status_bg_color }}; color:{{ $r->status_badge_color }};">
                                            <span>{{ $r->status }}</span>
                                            @if(!$r->taruna_baca && in_array($r->status, ['Diproses', 'Disetujui', 'Ditolak']))
                                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <a href="{{ route('reward.show', $r->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-xs border border-amber-200 shadow-sm transition no-underline">
                                            <i class="fa-solid fa-eye text-[10px]"></i>
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

    </div>
</main>

<div class="toast-container" id="toastContainer"></div>

<script>
let knownStatuses = {};

@foreach($daftarReward as $r)
knownStatuses[{{ $r->id }}] = "{{ $r->status }}";
@endforeach

function showToast(reward) {
    const container = document.getElementById('toastContainer');
    const icon = reward.status === 'Ditolak' ? 'fa-times' : reward.status === 'Disetujui' ? 'fa-check' : 'fa-spinner';
    const iconBg = reward.status === 'Ditolak' ? 'linear-gradient(135deg,#e53e3e,#fc5c7d)' : reward.status === 'Disetujui' ? 'linear-gradient(135deg,#38a169,#48bb78)' : 'linear-gradient(135deg,#3182ce,#0bc5ea)';

    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <div class="toast-icon" style="background:${iconBg}"><i class="fas ${icon}"></i></div>
        <div class="toast-body">
            <div class="toast-title">Status Reward Berubah</div>
            <div class="toast-msg">Reward <strong>${reward.kategori}</strong> sekarang <strong>${reward.status}</strong>.</div>
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
    fetch("{{ route('api.rewardNotifications') }}")
        .then(res => res.json())
        .then(data => {
            if (data.count > 0) {
                data.unread.forEach(r => {
                    if (knownStatuses[r.id] !== r.status) {
                        showToast(r);
                        knownStatuses[r.id] = r.status;
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
