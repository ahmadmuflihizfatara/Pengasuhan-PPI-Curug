{{-- Tabel konsinyir, dipakai untuk section Aktif & Riwayat --}}
@php $isTaruna = auth()->user()->hasTarunaAccess(); @endphp
<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse text-xs">
        <thead>
            <tr class="bg-white/60 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider text-slate-700 border-b border-white/40">
                <th class="py-3 px-3">#</th>
                <th class="py-3 px-3">Nama Taruna</th>
                <th class="py-3 px-3">Prodi</th>
                <th class="py-3 px-3">Tingkat</th>
                <th class="py-3 px-3">Mulai</th>
                <th class="py-3 px-3">Lama</th>
                <th class="py-3 px-3">Selesai</th>
                @unless($isTaruna)
                <th class="py-3 px-3">Keterangan</th>
                @endunless
                <th class="py-3 px-3">Status</th>
                @unless($isTaruna)
                <th class="py-3 px-3 text-center">Aksi</th>
                @endunless
            </tr>
        </thead>
        <tbody class="divide-y divide-white/30">
            @foreach($daftar as $i => $k)
            <tr class="hover:bg-white/60 transition">
                <td class="py-3 px-3 text-slate-400 font-bold">{{ $i + 1 }}</td>
                <td class="py-3 px-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-rose-500 to-orange-500 text-white flex items-center justify-center font-bold text-[11px] flex-shrink-0 shadow-sm">
                            {{ strtoupper(substr($k->mahasiswa->nama ?? '?', 0, 2)) }}
                        </div>
                        <span class="font-bold text-slate-900">{{ $k->mahasiswa->nama ?? '—' }}</span>
                    </div>
                </td>
                <td class="py-3 px-3">
                    <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 border border-indigo-200 font-bold text-[10px]">{{ $k->mahasiswa->prodi ?? '-' }}</span>
                </td>
                <td class="py-3 px-3">
                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold text-[10px]">Tk. {{ $k->mahasiswa->tingkat ?? '-' }}</span>
                </td>
                <td class="py-3 px-3 font-mono text-slate-700 whitespace-nowrap">{{ $k->tanggal_mulai->locale('id')->isoFormat('D MMM Y') }}</td>
                <td class="py-3 px-3 font-mono text-slate-700 whitespace-nowrap">{{ $k->lama_hari }} hari</td>
                <td class="py-3 px-3 font-mono text-slate-700 whitespace-nowrap">{{ $k->tanggal_selesai->locale('id')->isoFormat('D MMM Y') }}</td>
                @unless($isTaruna)
                <td class="py-3 px-3 text-slate-600 max-w-[220px] truncate" title="{{ $k->keterangan }}">{{ $k->keterangan ?: '—' }}</td>
                @endunless
                <td class="py-3 px-3">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $k->status === 'aktif' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                        {{ $k->status === 'aktif' ? 'Aktif' : 'Selesai' }}
                    </span>
                </td>
                @unless($isTaruna)
                <td class="py-3 px-3 text-center">
                    <button type="button" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 shadow-sm transition"
                            onclick="bukaHapusModal('del-konsinyir-{{ $k->id }}', '{{ addslashes($k->mahasiswa->nama ?? '') }}')" title="Hapus">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                    <form id="del-konsinyir-{{ $k->id }}" method="POST" action="{{ route('konsinyir.destroy', $k) }}" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </td>
                @endunless
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
