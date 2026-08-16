@props([
    'chartData',
    'title'    => 'Jumlah Taruna per Tingkat & Prodi',
    'subtitle' => 'Arahkan kursor ke batang untuk melihat jumlah persis. D-3 tidak punya tingkat 4.',
])

@php
    $chartId = 'prodiChart_' . \Illuminate\Support\Str::random(8);
@endphp

<style>
.chart-card { background:white; border-radius:16px; padding:22px 24px 14px; box-shadow:0 2px 12px rgba(0,0,0,.05); margin-bottom:20px; }
.chart-head { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:6px; }
.chart-head h2 { font-size:15px; font-weight:700; color:#333; margin:0; }
.chart-head p { font-size:12px; color:#98a0b3; margin:2px 0 0; }
.chart-legend { display:flex; gap:16px; flex-wrap:wrap; }
.chart-legend .item { display:flex; align-items:center; gap:6px; font-size:12px; color:#555; font-weight:600; }
.chart-legend .swatch { width:11px; height:11px; border-radius:3px; flex-shrink:0; }
.chart-wrap { position:relative; }
.chart-svg { width:100%; height:auto; display:block; }
.chart-svg text { font-family:'Inter',sans-serif; }
.chart-bar { cursor:pointer; transition:opacity .1s; }
.chart-bar:hover, .chart-bar:focus { opacity:.78; outline:none; }
.chart-tooltip {
    position:absolute; pointer-events:none; z-index:20;
    background:#242433; color:white; border-radius:9px;
    padding:8px 12px; font-size:12px; line-height:1.5;
    box-shadow:0 6px 20px rgba(0,0,0,.18); opacity:0; transform:translate(-50%,-100%);
    transition:opacity .1s; white-space:nowrap;
}
.chart-tooltip.show { opacity:1; }
.chart-tooltip .val { font-weight:700; font-size:13px; }
.chart-tooltip .key { display:inline-block; width:8px; height:2px; margin-right:6px; vertical-align:middle; }
</style>

<div {{ $attributes->merge(['class' => 'chart-card']) }}>
    <div class="chart-head">
        <div>
            <h2><i class="fas fa-chart-column" style="color:#5a67d8; margin-right:6px;"></i>{{ $title }}</h2>
            <p>{{ $subtitle }}</p>
        </div>
        <div class="chart-legend" id="{{ $chartId }}_legend"></div>
    </div>
    <div class="chart-wrap">
        <svg class="chart-svg" id="{{ $chartId }}" role="img" aria-label="Grafik jumlah taruna per tingkat, dikelompokkan per program studi"></svg>
        <div class="chart-tooltip" id="{{ $chartId }}_tooltip"></div>
    </div>
</div>

<script>
(function () {
    const CHART_DATA    = @json($chartData);
    const TINGKAT_WARNA = ['#2a78d6', '#eb6834', '#1baf7a', '#eda100'];
    const svg     = document.getElementById('{{ $chartId }}');
    const tooltip = document.getElementById('{{ $chartId }}_tooltip');
    const legend  = document.getElementById('{{ $chartId }}_legend');
    const svgNS   = 'http://www.w3.org/2000/svg';

    function debounce(fn, ms) {
        let t;
        return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
    }

    // Step "rapi" (1/2/5×10^n) yang membagi yMax jadi ~4 tick bulat, mis. maxVal=5 → step 2 → 0,2,4,6
    function niceStep(maxVal, targetTicks = 4) {
        const raw = Math.max(maxVal, 1) / targetTicks;
        const mag = Math.pow(10, Math.floor(Math.log10(raw)));
        const norm = raw / mag;
        const step = norm <= 1 ? 1 : norm <= 2 ? 2 : norm <= 5 ? 5 : 10;
        return step * mag;
    }

    // Rect dengan sudut membulat hanya di ujung atas (data-end), rata di baseline
    function roundedTopRect(x, y, w, h, r) {
        r = Math.min(r, h);
        if (h <= 0) return `M${x},${y + h} h${w} v0 h${-w} Z`;
        return `M${x},${y + h} V${y + r} Q${x},${y} ${x + r},${y} H${x + w - r} Q${x + w},${y} ${x + w},${y + r} V${y + h} Z`;
    }

    function render() {
        const wrap = svg.parentElement;
        const width = Math.max(wrap.clientWidth, 320);
        const height = 340;
        const margin = { top: 16, right: 12, bottom: 46, left: 36 };
        const plotW = width - margin.left - margin.right;
        const plotH = height - margin.top - margin.bottom;

        const maxVal = Math.max(1, ...CHART_DATA.flatMap(g => g.perTingkat.filter(v => v !== null)));
        const tickStep = niceStep(maxVal);
        const yMax = Math.ceil(maxVal / tickStep) * tickStep;

        const groupCount = CHART_DATA.length;
        const groupW = plotW / groupCount;
        const barGap = 2;
        const groupPad = 10;
        const barW = Math.min(24, (groupW - groupPad - barGap * 3) / 4);
        const yScale = v => (v / yMax) * plotH;

        svg.setAttribute('viewBox', `0 0 ${width} ${height}`);
        svg.innerHTML = '';

        const el = (tag, attrs) => {
            const n = document.createElementNS(svgNS, tag);
            for (const k in attrs) n.setAttribute(k, attrs[k]);
            return n;
        };

        // Gridlines + y labels — tick tiap tickStep, angka bulat & rata
        for (let val = 0; val <= yMax; val += tickStep) {
            const y = margin.top + plotH - yScale(val);
            svg.appendChild(el('line', {
                x1: margin.left, x2: width - margin.right, y1: y, y2: y,
                stroke: val === 0 ? '#c3c2b7' : '#e1e0d9', 'stroke-width': 1,
            }));
            const label = el('text', {
                x: margin.left - 8, y: y + 3, 'text-anchor': 'end',
                fill: '#898781', 'font-size': 10,
            });
            label.textContent = val;
            svg.appendChild(label);
        }

        CHART_DATA.forEach((group, gi) => {
            const groupX = margin.left + gi * groupW;
            const barsW = barW * 4 + barGap * 3;
            const startX = groupX + (groupW - barsW) / 2;

            const xLabel = el('text', {
                x: groupX + groupW / 2, y: height - margin.bottom + 18,
                'text-anchor': 'middle', fill: '#52514e', 'font-size': 11, 'font-weight': 700,
            });
            xLabel.textContent = group.kode;
            svg.appendChild(xLabel);
            const jenjangLabel = el('text', {
                x: groupX + groupW / 2, y: height - margin.bottom + 31,
                'text-anchor': 'middle', fill: '#aab', 'font-size': 9,
            });
            jenjangLabel.textContent = group.jenjang;
            svg.appendChild(jenjangLabel);

            group.perTingkat.forEach((val, ti) => {
                if (val === null) return; // D-3 tidak punya tingkat 4 — batang tidak digambar, bukan 0

                const bx = startX + ti * (barW + barGap);
                const bh = Math.max(val > 0 ? yScale(val) : 0, val > 0 ? 2 : 0);
                const by = margin.top + plotH - bh;
                const r = Math.min(4, barW / 2);

                const path = el('path', {
                    d: roundedTopRect(bx, by, barW, bh, r),
                    fill: TINGKAT_WARNA[ti],
                    class: 'chart-bar',
                    tabindex: 0,
                });
                const title = document.createElementNS(svgNS, 'title');
                title.textContent = `${group.kode} · Tingkat ${ti + 1}: ${val} taruna`;
                path.appendChild(title);

                const showTip = (evt) => {
                    tooltip.innerHTML = '';
                    const key = document.createElement('span');
                    key.className = 'key';
                    key.style.background = TINGKAT_WARNA[ti];
                    const valSpan = document.createElement('span');
                    valSpan.className = 'val';
                    valSpan.textContent = val + ' taruna';
                    const line1 = document.createElement('div');
                    line1.appendChild(valSpan);
                    const line2 = document.createElement('div');
                    line2.appendChild(key);
                    line2.appendChild(document.createTextNode(`${group.nama} (${group.kode}) · Tingkat ${ti + 1}`));
                    tooltip.appendChild(line1);
                    tooltip.appendChild(line2);

                    const wrapRect = wrap.getBoundingClientRect();
                    const px = (evt.clientX ?? wrapRect.left + bx) - wrapRect.left;
                    const py = (evt.clientY ?? wrapRect.top + by) - wrapRect.top;
                    tooltip.style.left = px + 'px';
                    tooltip.style.top = (py - 10) + 'px';
                    tooltip.classList.add('show');
                };
                const hideTip = () => tooltip.classList.remove('show');

                path.addEventListener('pointermove', showTip);
                path.addEventListener('pointerenter', showTip);
                path.addEventListener('pointerleave', hideTip);
                path.addEventListener('focus', showTip);
                path.addEventListener('blur', hideTip);

                svg.appendChild(path);
            });
        });
    }

    function renderLegend() {
        TINGKAT_WARNA.forEach((color, i) => {
            const item = document.createElement('div');
            item.className = 'item';
            const sw = document.createElement('span');
            sw.className = 'swatch';
            sw.style.background = color;
            const label = document.createElement('span');
            label.textContent = 'Tingkat ' + (i + 1);
            item.appendChild(sw);
            item.appendChild(label);
            legend.appendChild(item);
        });
    }

    render();
    renderLegend();
    new ResizeObserver(debounce(render, 100)).observe(svg.parentElement);
})();
</script>
