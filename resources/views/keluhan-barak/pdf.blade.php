<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Keluhan Barak</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #0f172a; }
        h1 { font-size: 15px; margin: 0 0 2px; }
        .meta { color: #475569; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 4px 5px; vertical-align: top; text-align: left; }
        th { background: #f1f5f9; font-size: 8.5px; text-transform: uppercase; }
        .c { text-align: center; }
    </style>
</head>
<body>
    <h1>Rekap Keluhan Barak Taruna — PPI Curug</h1>
    <div class="meta">
        Dicetak {{ now()->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB oleh {{ auth()->user()->name }}
        · {{ $daftarKeluhan->count() }} keluhan
        @if(array_filter($filter))
            · Filter:
            @foreach(array_filter($filter) as $k => $v) {{ ucfirst($k) }}: "{{ $v }}"@if(!$loop->last),@endif @endforeach
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="c">No</th>
                <th>Tanggal</th>
                <th>Pengaju</th>
                <th>Prodi</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Catatan Pengasuhan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($daftarKeluhan as $k)
            <tr>
                <td class="c">{{ $loop->iteration }}</td>
                <td>{{ $k->tanggal_pengajuan?->format('d/m/Y') }}</td>
                <td>{{ $k->nama }}<br><span style="color:#64748b">{{ $k->email }}</span></td>
                <td>{{ $k->prodi }}</td>
                <td>{{ $k->asrama }}, {{ $k->lorong }} No. {{ $k->nomor_barak }}</td>
                <td>{{ $k->keterangan }}</td>
                <td style="color: {{ $k->status_badge_color }}; font-weight: bold;">{{ $k->status }}</td>
                <td>{{ $k->catatan_pengasuhan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="8" class="c">Tidak ada data keluhan.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
