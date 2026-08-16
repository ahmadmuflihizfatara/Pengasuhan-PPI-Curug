{{-- Tabel konsinyir, dipakai untuk section Aktif & Riwayat --}}
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>NAMA TARUNA</th>
            <th>PRODI</th>
            <th>TINGKAT</th>
            <th>MULAI</th>
            <th>LAMA</th>
            <th>SELESAI</th>
            <th>KETERANGAN</th>
            <th>STATUS</th>
            <th style="text-align:center;">AKSI</th>
        </tr>
    </thead>
    <tbody>
        @foreach($daftar as $i => $k)
        <tr>
            <td style="color:#bbb; font-size:12px;">{{ $i + 1 }}</td>
            <td>
                <div style="display:flex; align-items:center; gap:10px;">
                    <div class="k-avatar">{{ strtoupper(substr($k->mahasiswa->nama ?? '?', 0, 2)) }}</div>
                    <span class="k-name">{{ $k->mahasiswa->nama ?? '—' }}</span>
                </div>
            </td>
            <td><span class="pill">{{ $k->mahasiswa->prodi ?? '-' }}</span></td>
            <td><span class="pill pill-tingkat">{{ $k->mahasiswa->tingkat ?? '-' }}</span></td>
            <td style="white-space:nowrap;">{{ $k->tanggal_mulai->locale('id')->isoFormat('D MMM Y') }}</td>
            <td style="white-space:nowrap;">{{ $k->lama_hari }} hari</td>
            <td style="white-space:nowrap;">{{ $k->tanggal_selesai->locale('id')->isoFormat('D MMM Y') }}</td>
            <td class="keterangan-cell">{{ $k->keterangan ?: '—' }}</td>
            <td>
                <span class="status-badge {{ $k->status }}">
                    {{ $k->status === 'aktif' ? 'Aktif' : 'Selesai' }}
                </span>
            </td>
            <td style="text-align:center;">
                <button type="button" class="btn-hapus"
                        onclick="bukaHapusModal('del-konsinyir-{{ $k->id }}', '{{ addslashes($k->mahasiswa->nama ?? '') }}')">
                    <i class="fas fa-trash"></i>
                </button>
                <form id="del-konsinyir-{{ $k->id }}" method="POST" action="{{ route('konsinyir.destroy', $k) }}" style="display:none;">
                    @csrf @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
