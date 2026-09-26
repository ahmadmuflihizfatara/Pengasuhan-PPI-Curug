{{-- Tabel konsinyir (pola tabel dashboard & poin), dipakai untuk section Aktif & Riwayat --}}
@php
    $isTaruna      = auth()->user()->hasTarunaAccess();
    $mahasiswaSaya = auth()->user()->mahasiswa?->id;
@endphp
<div class="ds-table-wrap">
    <div class="ds-scroll">
        <table class="ds-table tbl-table">
            <thead>
                <tr>
                    <th>Nama Taruna</th>
                    <th data-filter>Prodi</th>
                    <th data-filter>Tingkat</th>
                    <th>Mulai</th>
                    <th>Lama</th>
                    <th>Selesai</th>
                    @unless($isTaruna)
                    <th>Keterangan</th>
                    @endunless
                    <th class="{{ $isTaruna ? 'ds-right' : '' }}" data-filter>Status</th>
                    @unless($isTaruna)
                    <th class="ds-right" data-no-sort>Aksi</th>
                    @endunless
                </tr>
            </thead>
            <tbody>
                @foreach($daftar as $k)
                @php $saya = $mahasiswaSaya && $k->mahasiswa_id === $mahasiswaSaya; @endphp
                <tr class="{{ $saya ? 'konsinyir-saya' : '' }}">
                    <td>
                        <div class="ds-cell-person">
                            <span class="ds-avatar">{{ strtoupper(substr($k->mahasiswa->nama ?? '?', 0, 2)) }}</span>
                            <div>
                                <div class="tbl-title">{{ $k->mahasiswa->nama ?? '—' }} @if($saya)<span class="ds-badge ds-badge--accent">Saya</span>@endif</div>
                                <div class="tbl-sub">NPM {{ $k->mahasiswa->npm ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="ds-badge ds-badge--info">{{ $k->mahasiswa->prodi ?? '-' }}</span></td>
                    <td><span class="ds-badge ds-badge--success">Tk. {{ $k->mahasiswa->tingkat ?? '-' }}</span></td>
                    <td class="tbl-date" data-sort="{{ $k->tanggal_mulai->format('Y-m-d') }}">{{ $k->tanggal_mulai->locale('id')->isoFormat('D MMM Y') }}</td>
                    <td class="tbl-muted" data-sort="{{ $k->lama_hari }}" style="white-space:nowrap;">{{ $k->lama_hari }} hari</td>
                    <td class="tbl-date" data-sort="{{ $k->tanggal_selesai->format('Y-m-d') }}">{{ $k->tanggal_selesai->locale('id')->isoFormat('D MMM Y') }}</td>
                    @unless($isTaruna)
                    <td style="max-width:220px;"><div class="tbl-sub" style="margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $k->keterangan }}">{{ $k->keterangan ?: '—' }}</div></td>
                    @endunless
                    <td class="{{ $isTaruna ? 'ds-right' : '' }}">
                        <span class="ds-badge {{ $k->status === 'aktif' ? 'ds-badge--danger' : '' }}">{{ $k->status === 'aktif' ? 'Aktif' : 'Selesai' }}</span>
                    </td>
                    @unless($isTaruna)
                    <td class="ds-right">
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
</div>
