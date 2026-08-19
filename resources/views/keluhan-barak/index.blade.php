<x-app-layout>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">
        

                
                {{-- Page Header Glass Banner --}}
                <div class="rounded-2xl bg-gradient-to-r from-pink-900/90 via-rose-900/85 to-slate-900/90 backdrop-blur-xl border border-white/30 p-6 text-white mb-6 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[10px] font-bold tracking-widest uppercase text-pink-200 mb-2">
                            <span>✦</span>
                            <span>Fasilitas &amp; Asrama</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-door-open text-pink-400"></i>
                            <span>Keluhan Barak Saya</span>
                        </h1>
                        <p class="text-xs text-pink-100/80">Pantau status pengajuan perbaikan fasilitas dan kendala barak Anda secara real-time</p>
                    </div>

                    <div class="relative z-10">
                        <a href="{{ route('keluhan-barak.create') }}" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-900 font-extrabold text-xs shadow-md transition flex items-center gap-2 no-underline">
                            <i class="fa-solid fa-plus text-rose-500"></i>
                            <span>Ajukan Keluhan Baru</span>
                        </a>
                    </div>

                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                <div class="rounded-2xl bg-emerald-100/90 border border-emerald-300 p-4 text-emerald-800 text-xs font-bold mb-5 flex items-center gap-2 shadow-sm backdrop-blur-md">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($daftarKeluhan->isEmpty())
                <div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-10 text-center shadow-lg">
                    <i class="fa-solid fa-door-open text-4xl text-slate-300 mb-3 block"></i>
                    <h4 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Riwayat Keluhan Barak</h4>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mb-4">Klik tombol di bawah untuk melaporkan kerusakan sarana atau kendala fasilitas di barak Anda.</p>
                    <a href="{{ route('keluhan-barak.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-pink-600 to-rose-600 text-white text-xs font-bold shadow-md transition no-underline">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Ajukan Keluhan Pertama</span>
                    </a>
                </div>
                @else
                <div class="rounded-2xl bg-white/45 backdrop-blur-xl border border-white/60 p-4 sm:p-5 shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                                    <th class="py-3 px-3">#</th>
                                    <th class="py-3 px-3">Lokasi Barak</th>
                                    <th class="py-3 px-3">Tanggal</th>
                                    <th class="py-3 px-3">Keterangan</th>
                                    <th class="py-3 px-3 text-center">Status</th>
                                    <th class="py-3 px-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/30">
                                @foreach($daftarKeluhan as $i => $k)
                                <tr class="hover:bg-white/60 transition">
                                    <td class="py-3 px-3 text-slate-400 font-bold">{{ $i + 1 }}</td>
                                    <td class="py-3 px-3">
                                        <span class="px-2 py-0.5 rounded-full bg-pink-100 text-pink-800 font-bold text-[10px] border border-pink-200">
                                            {{ $k->asrama }}
                                        </span>
                                        <div class="font-bold text-slate-900 mt-1">
                                            {{ $k->lorong }} &bull; No. {{ $k->nomor_barak }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-slate-600 font-medium whitespace-nowrap">
                                        <i class="fa-solid fa-calendar text-pink-500 mr-1"></i>
                                        {{ $k->tanggal_pengajuan->locale('id')->isoFormat('D MMM Y') }}
                                    </td>
                                    <td class="py-3 px-3 max-w-[260px]">
                                        <div class="text-slate-800 font-medium truncate">{{ $k->keterangan }}</div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] inline-flex items-center gap-1.5" style="background:{{ $k->status_bg_color }}; color:{{ $k->status_badge_color }};">
                                            <span>{{ $k->status }}</span>
                                            @if(!$k->taruna_baca && in_array($k->status, ['Diproses', 'Selesai', 'Ditolak']))
                                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <a href="{{ route('keluhan-barak.show', $k->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-pink-50 hover:bg-pink-100 text-pink-700 font-bold text-xs border border-pink-200 shadow-sm transition no-underline">
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
    fetch("{{ route('api.keluhanNotifications') }}")
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
