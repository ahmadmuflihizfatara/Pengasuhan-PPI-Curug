@props(['nilai'])

@php
    $chartId = 'nilaiChart_' . \Illuminate\Support\Str::random(8);
    // Tiga metrik dengan skala berbeda → tiga grafik kecil, bukan satu sumbu campur
    $seri = [
        ['key' => 'ips',        'label' => 'IPS',        'max' => 4,   'warna' => '#4f46e5'],
        ['key' => 'samapta',    'label' => 'Samapta',    'max' => 100, 'warna' => '#059669'],
        ['key' => 'pengasuhan', 'label' => 'Pengasuhan', 'max' => 100, 'warna' => '#d97706'],
    ];
    $rataIps = $nilai->avg('ips');
    $chartData = $nilai->map(fn ($n) => [
        'semester' => $n->semester, 'ips' => $n->ips, 'samapta' => $n->samapta, 'pengasuhan' => $n->pengasuhan,
    ])->values();
@endphp

<div class="rounded-2xl bg-white/50 backdrop-blur-xl border border-white/60 p-5 sm:p-6 shadow-lg">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3.5 mb-4 border-b border-white/30">
        <div>
            <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-emerald-500"></i>
                <span>Rekapitulasi Nilai per Semester</span>
            </h2>
            <p class="text-[11px] text-slate-500 mt-0.5">Indeks Prestasi Semester, Samapta &amp; Pengasuhan yang diinput pengasuh.</p>
        </div>
        @if($nilai->isNotEmpty())
        <div class="flex items-center gap-2 text-[10px] font-bold">
            <span class="px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700">IPK {{ number_format($rataIps, 2) }}</span>
            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">Samapta rata² {{ number_format($nilai->avg('samapta'), 1) }}</span>
            <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700">Pengasuhan rata² {{ number_format($nilai->avg('pengasuhan'), 1) }}</span>
        </div>
        @endif
    </div>

    @if($nilai->isEmpty())
    <div class="text-center py-8 text-slate-400">
        <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
        <span class="font-semibold text-xs">Belum ada nilai yang diinput untuk Anda.</span>
    </div>
    @else

    {{-- Grafik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        @foreach($seri as $s)
        <div class="rounded-xl bg-white/70 border border-white/80 p-3">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-extrabold uppercase tracking-wider" style="color:{{ $s['warna'] }}">{{ $s['label'] }}</span>
                <span class="text-[10px] text-slate-400">maks {{ $s['max'] }}</span>
            </div>
            <svg class="w-full h-auto block" id="{{ $chartId }}_{{ $s['key'] }}" viewBox="0 0 300 130" role="img" aria-label="Grafik {{ $s['label'] }} per semester"></svg>
        </div>
        @endforeach
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-xs">
            <thead>
                <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200/70">
                    <th class="text-left py-2 pr-3">Semester</th>
                    <th class="text-center py-2 px-3">IPS</th>
                    <th class="text-center py-2 px-3">Samapta</th>
                    <th class="text-center py-2 px-3">Pengasuhan</th>
                    <th class="text-left py-2 pl-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilai as $n)
                <tr class="border-b border-slate-100/70">
                    <td class="py-2.5 pr-3 font-bold text-slate-800">Semester {{ $n->semester }}</td>
                    <td class="py-2.5 px-3 text-center font-mono font-bold text-indigo-700">{{ number_format($n->ips, 2) }}</td>
                    <td class="py-2.5 px-3 text-center font-mono font-bold text-emerald-700">{{ number_format($n->samapta, 2) }}</td>
                    <td class="py-2.5 px-3 text-center font-mono font-bold text-amber-700">{{ number_format($n->pengasuhan, 2) }}</td>
                    <td class="py-2.5 pl-3 text-slate-500">{{ $n->keterangan ?: '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
    (function () {
        const DATA = @json($chartData);
        const SERI = @json($seri);
        const ns = 'http://www.w3.org/2000/svg';
        const el = (tag, attrs, text) => {
            const n = document.createElementNS(ns, tag);
            for (const k in attrs) n.setAttribute(k, attrs[k]);
            if (text !== undefined) n.textContent = text;
            return n;
        };

        SERI.forEach(s => {
            const svg = document.getElementById('{{ $chartId }}_' + s.key);
            const W = 300, H = 130, m = { top: 12, right: 12, bottom: 22, left: 30 };
            const pw = W - m.left - m.right, ph = H - m.top - m.bottom;
            const x = i => m.left + (DATA.length === 1 ? pw / 2 : i * pw / (DATA.length - 1));
            const y = v => m.top + ph - (v / s.max) * ph;

            // grid: 0, 50%, 100%
            [0, 0.5, 1].forEach(f => {
                const gy = m.top + ph - f * ph;
                svg.appendChild(el('line', { x1: m.left, x2: W - m.right, y1: gy, y2: gy, stroke: '#e5e7eb', 'stroke-width': 1 }));
                svg.appendChild(el('text', { x: m.left - 5, y: gy + 3, 'text-anchor': 'end', fill: '#9ca3af', 'font-size': 8 }, (s.max * f).toFixed(s.max === 4 ? 1 : 0)));
            });

            const pts = DATA.map((d, i) => `${x(i)},${y(d[s.key])}`);
            if (pts.length > 1) {
                svg.appendChild(el('polyline', { points: pts.join(' '), fill: 'none', stroke: s.warna, 'stroke-width': 2, 'stroke-linejoin': 'round', 'stroke-linecap': 'round' }));
            }
            DATA.forEach((d, i) => {
                const c = el('circle', { cx: x(i), cy: y(d[s.key]), r: 3.5, fill: s.warna, stroke: '#fff', 'stroke-width': 1.5 });
                c.appendChild(el('title', {}, `Semester ${d.semester}: ${d[s.key]}`));
                svg.appendChild(c);
                svg.appendChild(el('text', { x: x(i), y: y(d[s.key]) - 7, 'text-anchor': 'middle', fill: s.warna, 'font-size': 8, 'font-weight': 700 }, d[s.key]));
                svg.appendChild(el('text', { x: x(i), y: H - 6, 'text-anchor': 'middle', fill: '#6b7280', 'font-size': 8, 'font-weight': 600 }, 'S' + d.semester));
            });
        });
    })();
    </script>
    @endif
</div>
