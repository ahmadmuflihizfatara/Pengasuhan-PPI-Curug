/**
 * Table tools — search, filter, sort untuk semua <table> di halaman.
 *
 * Otomatis aktif untuk tabel dengan <thead> + <tbody> dan ≥ 1 baris data.
 * Toolbar disisipkan di atas pembungkus scroll tabel (.overflow-x-auto /
 * .table-responsive) supaya tetap di dalam kartu, tidak ikut ter-scroll.
 *
 * Opsi via atribut:
 *   <table data-no-tools>            lewati tabel ini
 *   <table data-server-sort>         klik header → reload dengan ?sort=&dir= (tabel paginasi)
 *   <th data-sort="kolom">           kunci sort server (dipakai bersama data-server-sort)
 *   <th data-no-sort>                header tidak bisa diurutkan
 *   <th data-filter> / data-no-filter paksa / matikan dropdown filter kolom ini
 *   <td data-sort="nilai">           nilai sort kustom (mis. ISO date) — default textContent
 */
(function () {
    const MAX_FILTER_VALUES = 12;
    const MAX_AUTO_FILTERS = 3;
    const ICON_SEARCH = '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="9" cy="9" r="5.5"/><path d="M13.5 13.5 17 17"/></svg>';
    const ICON_CLEAR = '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l8 8M14 6l-8 8"/></svg>';

    function cellValue(td) {
        return (td.dataset.sort ?? td.textContent).replace(/\s+/g, ' ').trim();
    }

    // Angka (termasuk "+12", "3,5", "1.250") dan tanggal dd/mm/yyyy → sortable
    function sortKey(raw) {
        const s = raw.replace(/\s+/g, ' ');
        if (/^[+-]?\d[\d.,]*$/.test(s)) return parseFloat(s.replace(/\./g, '').replace(',', '.'));
        const d = s.match(/^(\d{1,2})[\/-](\d{1,2})[\/-](\d{4})/);
        if (d) return new Date(+d[3], +d[2] - 1, +d[1]).getTime();
        if (/^\d{4}-\d{2}-\d{2}/.test(s)) return Date.parse(s.slice(0, 19)) || s;
        return s.toLowerCase();
    }

    // Kolom "kategorikal": teks pendek (Status, Prodi, Kategori) atau bilangan kecil (Tingkat, Semester)
    function isCategorical(values) {
        return values.every(v => v.length <= 28
            && (typeof sortKey(v) === 'string' || /^\d{1,2}$/.test(v))
            && !/^\d{1,2}[:.]\d{2}/.test(v)      // jam 08:00
            && !/(19|20)\d{2}/.test(v));     // tanggal "20 Sep 2026"
    }

    // Urut alami untuk teks: "Semester 2" sebelum "Semester 10"
    const collator = new Intl.Collator('id', { numeric: true, sensitivity: 'base' });
    function compareKeys(a, b) {
        if (typeof a === 'string' && typeof b === 'string') return collator.compare(a, b);
        if (typeof a !== typeof b) return typeof a === 'number' ? -1 : 1;   // angka sebelum teks ("—")
        return a === b ? 0 : (a > b ? 1 : -1);
    }

    function el(tag, cls, html) {
        const n = document.createElement(tag);
        if (cls) n.className = cls;
        if (html !== undefined) n.innerHTML = html;
        return n;
    }

    function enhance(table) {
        const thead = table.tHead;
        const tbody = table.tBodies[0];
        if (!thead || !tbody) return;
        const headers = [...thead.rows[thead.rows.length - 1].cells];
        // Baris "kosong"/placeholder (colspan penuh) tidak ikut disaring
        const dataRows = [...tbody.rows].filter(r => r.cells.length === headers.length);
        const serverSort = table.hasAttribute('data-server-sort');
        if (dataRows.length === 0 && !serverSort) return;

        if (serverSort) {
            // Tabel paginasi: cari/filter sudah ada server-side di halaman — cukup sort header
            bindSort(table, headers, dataRows, tbody, true);
            return;
        }

        // ---- Toolbar
        const bar = el('div', 'tt-bar');

        const searchWrap = el('div', 'tt-search-wrap', ICON_SEARCH);
        const search = el('input', 'tt-search');
        search.type = 'search';
        search.placeholder = 'Cari di tabel…';
        search.setAttribute('aria-label', 'Cari di tabel');
        searchWrap.appendChild(search);
        bar.appendChild(searchWrap);

        // Kandidat filter: dipaksa via data-filter, atau otomatis — diurutkan dari
        // yang paling "kategorikal" (paling sedikit nilai unik relatif jumlah baris)
        const forced = [], auto = [];
        headers.forEach((th, col) => {
            if (th.hasAttribute('data-no-filter')) return;
            const values = [...new Set(dataRows.map(r => cellValue(r.cells[col])).filter(Boolean))];
            if (values.length === 0) return;
            const label = th.textContent.trim() || 'Kolom ' + (col + 1);
            if (th.hasAttribute('data-filter')) { forced.push({ col, values, label }); return; }
            if (/^(#|no\.?|nomor|aksi|action)$/i.test(label)) return;   // kolom nomor urut / tombol aksi
            // Harus ada nilai yang berulang — filter tanpa duplikat tidak berguna
            if (values.length >= 2 && values.length <= MAX_FILTER_VALUES && values.length < dataRows.length && isCategorical(values) && label.length <= 20) {
                auto.push({ col, values, label, ratio: values.length / dataRows.length });
            }
        });
        auto.sort((a, b) => a.ratio - b.ratio);
        const chosen = [...forced, ...auto.slice(0, Math.max(0, MAX_AUTO_FILTERS - forced.length))]
            .sort((a, b) => a.col - b.col);

        const filters = chosen.map(f => {
            const wrap = el('label', 'tt-filter-wrap');
            const sel = el('select', 'tt-filter');
            sel.setAttribute('aria-label', 'Filter ' + f.label);
            sel.innerHTML = `<option value="">${f.label}: Semua</option>`
                + f.values.sort((a, b) => compareKeys(sortKey(a), sortKey(b)))
                    .map(v => `<option value="${v.replace(/"/g, '&quot;')}">${v}</option>`).join('');
            wrap.appendChild(sel);
            bar.appendChild(wrap);
            return { col: f.col, select: sel, wrap };
        });

        const right = el('div', 'tt-right');
        const reset = el('button', 'tt-reset', ICON_CLEAR + '<span>Reset</span>');
        reset.type = 'button';
        reset.hidden = true;
        const count = el('span', 'tt-count');
        right.append(reset, count);
        bar.appendChild(right);

        // Sisipkan di atas pembungkus scroll, bukan di dalamnya
        const anchor = table.closest('.ds-table-wrap, .overflow-x-auto, .table-responsive, [style*="overflow"]') || table;
        anchor.parentNode.insertBefore(bar, anchor);

        // ---- Filter + search
        function apply() {
            const q = search.value.trim().toLowerCase();
            let shown = 0;
            dataRows.forEach(r => {
                const okSearch = !q || r.textContent.toLowerCase().includes(q);
                const okFilter = filters.every(f => !f.select.value || cellValue(r.cells[f.col]) === f.select.value);
                r.style.display = okSearch && okFilter ? '' : 'none';
                if (okSearch && okFilter) shown++;
            });
            const aktif = !!q || filters.some(f => f.select.value);
            filters.forEach(f => f.wrap.classList.toggle('tt-active', !!f.select.value));
            reset.hidden = !aktif;
            count.textContent = aktif ? `${shown} / ${dataRows.length}` : `${dataRows.length} baris`;
            count.classList.toggle('tt-count-filtered', aktif);
        }
        search.addEventListener('input', apply);
        filters.forEach(f => f.select.addEventListener('change', apply));
        reset.addEventListener('click', () => {
            search.value = '';
            filters.forEach(f => f.select.value = '');
            apply();
        });
        apply();

        bindSort(table, headers, dataRows, tbody, false);
    }

    function bindSort(table, headers, dataRows, tbody, serverSort) {
        const url = new URL(location.href);
        headers.forEach((th, col) => {
            if (th.hasAttribute('data-no-sort') || !th.textContent.trim()) return;
            if (serverSort && !th.dataset.sort) return;
            th.classList.add('tt-sortable');
            th.appendChild(el('span', 'tt-ind'));

            if (serverSort) {
                if (url.searchParams.get('sort') === th.dataset.sort) {
                    th.classList.add(url.searchParams.get('dir') === 'desc' ? 'tt-desc' : 'tt-asc');
                }
                th.addEventListener('click', () => {
                    const cur = url.searchParams.get('sort') === th.dataset.sort && url.searchParams.get('dir') !== 'desc';
                    url.searchParams.set('sort', th.dataset.sort);
                    url.searchParams.set('dir', cur ? 'desc' : 'asc');
                    url.searchParams.delete('page');
                    location.href = url.toString();
                });
                return;
            }

            th.addEventListener('click', () => {
                const asc = !th.classList.contains('tt-asc');
                headers.forEach(h => h.classList.remove('tt-asc', 'tt-desc'));
                th.classList.add(asc ? 'tt-asc' : 'tt-desc');
                [...dataRows].sort((a, b) => {
                    return compareKeys(sortKey(cellValue(a.cells[col])), sortKey(cellValue(b.cells[col]))) * (asc ? 1 : -1);
                }).forEach(r => tbody.appendChild(r));
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('table:not([data-no-tools])').forEach(t => {
            try { enhance(t); } catch (e) { console.warn('table-tools', e); }
        });
    });
})();
