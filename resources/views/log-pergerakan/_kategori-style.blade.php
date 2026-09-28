{{-- Gaya form keberangkatan 3 cabang (kartu kategori, pil sub-kategori, status awal) —
     dipakai form mandiri taruna & mode tablet pos jaga admin --}}
@once
<style>
/* === FLOW CARDS: PILIH KATEGORI (3 CABANG) === */
.category-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-4);
}
.cat-card {
    background: var(--glass-card);
    border: 1px solid var(--border-glass-glow);
    border-radius: var(--radius-lg);
    padding: var(--space-5);
    cursor: pointer;
    transition: transform .25s cubic-bezier(.16,1,.3,1), box-shadow .25s, background-color .25s, border-color .25s;
    position: relative;
    overflow: hidden;
}
.cat-card:hover {
    background: var(--glass-solid);
    transform: translateY(-3px);
    box-shadow: var(--shadow-card-hover);
}
.cat-card:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
.cat-card.active {
    border-color: var(--accent);
    background: var(--glass-solid);
    box-shadow: 0 0 0 3px var(--focus-ring-glow), var(--shadow-glass-sm);
}
.cat-card.active::after {
    content: '\f00c';
    font-family: 'Font Awesome 5 Free', 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    top: 12px;
    right: 14px;
    width: 24px;
    height: 24px;
    background: var(--accent);
    color: var(--ink-on-dark);
    border-radius: var(--radius-pill);
    font-size: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cat-icon-wrapper {
    width: 48px; height: 48px; border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; margin-bottom: var(--space-3-5);
    color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm);
}
.cat-1 .cat-icon-wrapper { background: linear-gradient(135deg, #f43f5e, var(--danger)); }
.cat-2 .cat-icon-wrapper { background: linear-gradient(135deg, #2563eb, var(--accent)); }
.cat-3 .cat-icon-wrapper { background: linear-gradient(135deg, #10b981, var(--success)); }
.cat-num { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--ink-500); margin-bottom: 2px; }
.cat-name { font-size: 16px; font-weight: 800; color: var(--ink-900); margin-bottom: var(--space-1); }
.cat-desc { font-size: 12px; color: var(--ink-600); line-height: 1.45; }

/* Subcategory Pill Selectors — ds-btn--pill */
.subcat-pills { display: flex; gap: var(--space-2); flex-wrap: wrap; margin-bottom: var(--space-1); }
.subcat-pill {
    display: inline-flex; align-items: center; gap: var(--space-1-5);
    padding: var(--space-2) var(--space-4); border-radius: var(--radius-pill);
    background: var(--glass-card); border: 1px solid var(--border-glass-glow);
    backdrop-filter: blur(var(--blur-subtle)); -webkit-backdrop-filter: blur(var(--blur-subtle));
    box-shadow: var(--shadow-glass-sm);
    font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); cursor: pointer;
    transition: background-color .15s, color .15s, transform .1s, box-shadow .15s;
}
.subcat-pill:hover { background: var(--glass-solid); color: var(--ink-900); }
.subcat-pill:active { transform: scale(.97); }
.subcat-pill:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
.subcat-pill.active { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); }

/* Status awal — komponen ds-alert--danger; di sini hanya layout */
.status-awal-box { align-items: center; flex-wrap: wrap; margin: var(--space-5) 0 var(--space-6); }
.status-awal-box__body { flex: 1; min-width: 180px; }
.status-awal-box__title { font-weight: 800; }
.status-awal-box__desc { font-size: 11px; font-weight: 500; color: var(--ink-600); margin-top: 2px; }

@media (max-width: 768px) {
    .category-grid { grid-template-columns: 1fr; }
}
</style>
@endonce
