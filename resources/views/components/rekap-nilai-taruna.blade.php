@props(['nilai'])

@php
    $chartId = 'nilaiChart_' . \Illuminate\Support\Str::random(8);
    // Tiga metrik dengan skala berbeda → tiga grafik kecil, bukan satu sumbu campur
    $seri = [
        ['key' => 'ips',        'label' => 'IPS',        'max' => 4,   'step' => 0.5, 'desimal' => 2, 'warna' => '#4f46e5'],
        ['key' => 'samapta',    'label' => 'Samapta',    'max' => 100, 'step' => 10,  'desimal' => 1, 'warna' => '#047857'],
        ['key' => 'pengasuhan', 'label' => 'Pengasuhan', 'max' => 100, 'step' => 10,  'desimal' => 1, 'warna' => '#b45309'],
    ];
    $chartData = $nilai->map(fn ($n) => [
        'semester' => $n->semester, 'ips' => (float) $n->ips, 'samapta' => (float) $n->samapta, 'pengasuhan' => (float) $n->pengasuhan,
    ])->values();
@endphp

<div class="ds-card">
    <div class="ds-card__head" style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:var(--space-3);">
        <div>
            <h2 class="ds-card__title"><i class="fa-solid fa-chart-line ds-icon"></i> Rekapitulasi Nilai per Semester</h2>
            <p class="ds-card__desc">Indeks Prestasi Semester, Samapta &amp; Pengasuhan yang diinput pengasuh</p>
        </div>
        @if($nilai->isNotEmpty())
        <div class="ds-row">
            <span class="ds-badge ds-badge--accent">IPK {{ number_format($nilai->avg('ips'), 2, ',', '.') }}</span>
            <span class="ds-badge ds-badge--success">Rata-rata Samapta {{ number_format($nilai->avg('samapta'), 1, ',', '.') }}</span>
            <span class="ds-badge ds-badge--warning">Rata-rata Pengasuhan {{ number_format($nilai->avg('pengasuhan'), 1, ',', '.') }}</span>
        </div>
        @endif
    </div>

    @if($nilai->isEmpty())
    <div class="ds-empty">
        <i class="fa-solid fa-inbox ds-icon"></i>
        Belum ada nilai yang diinput.
    </div>
    @else

    {{-- Grafik --}}
    <div class="rnt-charts">
        @foreach($seri as $s)
        @php $akhir = $nilai->last()->{$s['key']}; @endphp
        <figure class="rnt-chart">
            <figcaption class="rnt-chart__head">
                <span class="rnt-chart__label"><span class="rnt-chart__swatch" style="background:{{ $s['warna'] }}"></span>{{ $s['label'] }}</span>
                <span class="rnt-chart__last">
                    <span class="rnt-chart__value">{{ number_format($akhir, $s['desimal'], ',', '.') }}</span>
                    <span class="rnt-chart__max">/ {{ $s['max'] }}</span>
                </span>
            </figcaption>
            <svg id="{{ $chartId }}_{{ $s['key'] }}" viewBox="0 0 320 170" role="img" aria-label="Grafik {{ $s['label'] }} per semester"></svg>
        </figure>
        @endforeach
    </div>

    {{-- Tabel --}}
    <div class="ds-table-wrap">
        <div class="ds-scroll">
            <table class="ds-table">
                <thead>
                    <tr>
                        <th data-filter>Semester</th>
                        <th class="ds-center">IPS</th>
                        <th class="ds-center">Samapta</th>
                        <th class="ds-center">Pengasuhan</th>
                        <th data-filter>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilai as $n)
                    <tr>
                        <td class="ds-name">Semester {{ $n->semester }}</td>
                        <td class="ds-center rnt-num">{{ number_format($n->ips, 2, ',', '.') }}</td>
                        <td class="ds-center rnt-num">{{ number_format($n->samapta, 2, ',', '.') }}</td>
                        <td class="ds-center rnt-num">{{ number_format($n->pengasuhan, 2, ',', '.') }}</td>
                        <td class="rnt-ket">{{ $n->keterangan ?: '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
        const fmt = (v, d) => Number(v).toLocaleString('id-ID', { minimumFractionDigits: d, maximumFractionDigits: d });

        const draw = () => SERI.forEach(s => {
            const svg = document.getElementById('{{ $chartId }}_' + s.key);
            svg.replaceChildren();
            // viewBox = lebar asli → teks tetap 11px di HP maupun desktop
            const W = Math.max(200, Math.round(svg.getBoundingClientRect().width) || 320), H = 170, m = { top: 26, right: 22, bottom: 30, left: 40 };
            svg.setAttribute('viewBox', `0 0 ${W} ${H}`);
            const pw = W - m.left - m.right, ph = H - m.top - m.bottom;

            // Sumbu y diperbesar ke rentang data (dibulatkan ke kelipatan step) agar perubahan terlihat
            const vals = DATA.map(d => d[s.key]);
            // (hi - lo) = 2k·step supaya tick tengah juga kelipatan step
            const hi = s.max;
            const k = Math.max(1, Math.ceil((hi - (Math.min(...vals) - s.step)) / (2 * s.step)));
            const lo = Math.max(0, hi - 2 * k * s.step);
            const ticks = [lo, (lo + hi) / 2, hi];

            const pad = 28; // jarak titik dari sumbu agar label nilai tidak menabrak angka sumbu
            const x = i => m.left + pad + (DATA.length === 1 ? (pw - 2 * pad) / 2 : i * (pw - 2 * pad) / (DATA.length - 1));
            const y = v => m.top + ph - ((v - lo) / (hi - lo)) * ph;

            ticks.forEach(t => {
                svg.appendChild(el('line', { x1: m.left, x2: W - m.right, y1: y(t), y2: y(t), stroke: '#94a3b8', 'stroke-opacity': .35, 'stroke-dasharray': t === lo ? '' : '3 4' }));
                svg.appendChild(el('text', { x: m.left - 8, y: y(t) + 4, 'text-anchor': 'end', fill: '#475569', 'font-size': 11, 'font-weight': 600 }, fmt(t, s.max === 4 ? 1 : 0)));
            });

            if (DATA.length > 1) {
                const pts = DATA.map((d, i) => `${x(i)},${y(d[s.key])}`);
                svg.appendChild(el('polygon', { points: `${x(0)},${y(lo)} ${pts.join(' ')} ${x(DATA.length - 1)},${y(lo)}`, fill: s.warna, 'fill-opacity': .10 }));
                svg.appendChild(el('polyline', { points: pts.join(' '), fill: 'none', stroke: s.warna, 'stroke-width': 2.5, 'stroke-linejoin': 'round', 'stroke-linecap': 'round' }));
            }
            DATA.forEach((d, i) => {
                const cx = x(i), cy = y(d[s.key]);
                const c = el('circle', { cx, cy, r: 4.5, fill: s.warna, stroke: '#fff', 'stroke-width': 2 });
                c.appendChild(el('title', {}, `Semester ${d.semester}: ${fmt(d[s.key], s.max === 4 ? 2 : 1)}`));
                svg.appendChild(c);
                // Label nilai: pil putih di atas titik agar tetap terbaca di atas garis/area
                const label = fmt(d[s.key], s.max === 4 ? 2 : 1);
                const lw = label.length * 7 + 10;
                svg.appendChild(el('rect', { x: cx - lw / 2, y: cy - 25, width: lw, height: 17, rx: 8.5, fill: '#fff', 'fill-opacity': .92, stroke: s.warna, 'stroke-opacity': .35 }));
                svg.appendChild(el('text', { x: cx, y: cy - 12.5, 'text-anchor': 'middle', fill: '#0f172a', 'font-size': 11, 'font-weight': 800 }, label));
                svg.appendChild(el('text', { x: cx, y: H - 8, 'text-anchor': 'middle', fill: '#334155', 'font-size': 11, 'font-weight': 700 }, 'Smt ' + d.semester));
            });
        });
        draw();
        // gambar ulang saat layout/lebar berubah agar teks tetap 11px
        let raf;
        addEventListener("load", draw);
        addEventListener("resize", () => { cancelAnimationFrame(raf); raf = requestAnimationFrame(draw); });
    })();
    </script>
    @endif
</div>

@once
<style>
.rnt-charts { display: grid; grid-template-columns: 1fr; gap: var(--space-4); margin-bottom: var(--space-5); }
@media (min-width: 768px) { .rnt-charts { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
.rnt-chart {
    margin: 0; padding: var(--space-4);
    background: var(--glass-card); border: 1px solid var(--border-glass-glow); border-radius: var(--radius-lg);
    backdrop-filter: blur(var(--blur-subtle)); -webkit-backdrop-filter: blur(var(--blur-subtle));
    box-shadow: var(--shadow-glass-sm);
}
.rnt-chart svg { display: block; width: 100%; height: auto; overflow: visible; font-family: var(--font-sans); }
.rnt-chart__head { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: var(--space-2); }
.rnt-chart__label { display: inline-flex; align-items: center; gap: var(--space-1-5); font-size: 10px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-800); }
.rnt-chart__swatch { width: 10px; height: 10px; border-radius: 3px; }
.rnt-chart__value { font-family: var(--font-mono); font-size: 20px; line-height: 24px; font-weight: 800; color: var(--ink-900); }
.rnt-chart__max { font-size: 11px; font-weight: 600; color: var(--ink-600); }
.ds-table td.rnt-num { font-family: var(--font-mono); font-weight: 700; }
.ds-table td.rnt-ket { color: var(--ink-600) !important; }
</style>
@endonce
