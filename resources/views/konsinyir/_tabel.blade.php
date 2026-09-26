{{-- Tabel konsinyir (PPI Curug Glass), dipakai untuk section Aktif & Riwayat --}}
@php
    $isTaruna      = auth()->user()->hasTarunaAccess();
    $mahasiswaSaya = auth()->user()->mahasiswa?->id;
@endphp
<div class="ds-scroll">
    <table class="ds-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Taruna</th>
                <th>Prodi</th>
                <th>Tingkat</th>
                <th>Mulai</th>
                <th>Lama</th>
                <th>Selesai</th>
                @unless($isTaruna)
                <th>Keterangan</th>
                @endunless
                <th>Status</th>
                @unless($isTaruna)
                <th class="ds-center">Aksi</th>
                @endunless
            </tr>
        </thead>
        <tbody>
            @foreach($daftar as $i => $k)
            @php $saya = $mahasiswaSaya && $k->mahasiswa_id === $mahasiswaSaya; @endphp
            <tr class="{{ $saya ? 'konsinyir-saya' : '' }}">
                <td class="ds-num">{{ $i + 1 }}</td>
                <td>
                    <div class="ds-cell-person">
                        <span class="ds-avatar">{{ strtoupper(substr($k->mahasiswa->nama ?? '?', 0, 2)) }}</span>
                        <span class="ds-name">{{ $k->mahasiswa->nama ?? '—' }}</span>
                        @if($saya)<span class="ds-badge ds-badge--accent">Saya</span>@endif
                    </div>
                </td>
                <td><span class="ds-badge ds-badge--info">{{ $k->mahasiswa->prodi ?? '-' }}</span></td>
                <td><span class="ds-badge ds-badge--success">Tk. {{ $k->mahasiswa->tingkat ?? '-' }}</span></td>
                <td style="white-space:nowrap;">{{ $k->tanggal_mulai->locale('id')->isoFormat('D MMM Y') }}</td>
                <td style="white-space:nowrap; font-weight:700;">{{ $k->lama_hari }} hari</td>
                <td style="white-space:nowrap;">{{ $k->tanggal_selesai->locale('id')->isoFormat('D MMM Y') }}</td>
                @unless($isTaruna)
                <td style="max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color:var(--ink-700);" title="{{ $k->keterangan }}">{{ $k->keterangan ?: '—' }}</td>
                @endunless
                <td>
                    <span class="ds-badge {{ $k->status === 'aktif' ? 'ds-badge--danger' : '' }}">
                        {{ $k->status === 'aktif' ? 'Aktif' : 'Selesai' }}
                    </span>
                </td>
                @unless($isTaruna)
                <td class="ds-center">
                    <button type="button" class="ds-btn ds-btn--icon ds-btn--danger"
                            onclick="bukaHapusModal('del-konsinyir-{{ $k->id }}', '{{ addslashes($k->mahasiswa->nama ?? '') }}')"
                            title="Hapus" aria-label="Hapus konsinyir {{ $k->mahasiswa->nama ?? '' }}">
                        <i class="fa-solid fa-trash"></i>
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
