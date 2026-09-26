{{-- Gaya form halaman taruna (PPI Curug Glass) — dipakai form Log Gerbang & Ajukan Keluhan Barak.
     Pakai: <x-form-glass-style /> lalu .form-card > .form-section-title / .form-group > .form-label + .form-control, .btn-submit-log --}}
@once
<style>
.form-card {
    background: var(--glass-panel);
    backdrop-filter: blur(var(--blur-standard)) saturate(180%); -webkit-backdrop-filter: blur(var(--blur-standard)) saturate(180%);
    border: 1px solid var(--border-glass);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-glass);
    padding: var(--space-6);
    color: var(--ink-900);
}
.form-section-title {
    font-size: 14px; line-height: 20px; font-weight: 800; color: var(--ink-900);
    margin-bottom: var(--space-5); padding-bottom: var(--space-3-5);
    border-bottom: 1px solid var(--border-glass-subtle);
    display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap;
}
.form-group { margin-bottom: var(--space-4); }
.form-label {
    display: block; margin-bottom: var(--space-1-5);
    font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;
    color: var(--ink-700);
}
.form-label .req { color: var(--danger); }
.form-control, .form-select {
    display: block; width: 100%;
    padding: var(--space-2-5) var(--space-3-5);
    border-radius: var(--radius-md);
    background-color: var(--glass-card);
    backdrop-filter: blur(var(--blur-subtle)); -webkit-backdrop-filter: blur(var(--blur-subtle));
    border: 1.5px solid var(--border-glass-glow);
    font-family: inherit; font-size: 12px; line-height: 16px; font-weight: 600; color: var(--ink-900);
    outline: none; transition: background-color .15s, border-color .15s, box-shadow .15s;
}
.form-control::placeholder { color: var(--ink-500); font-weight: 500; }
.form-control:hover, .form-select:hover { background-color: rgba(255,255,255,0.85); }
.form-control:focus, .form-select:focus {
    background-color: var(--glass-solid); border-color: var(--focus-ring); box-shadow: var(--shadow-focus); outline: none;
}
/* Input file — tombol pilih file bergaya ds-btn--primary */
.form-control[type="file"] { padding: var(--space-1-5); cursor: pointer; color: var(--ink-600); font-weight: 500; }
.form-control[type="file"]::file-selector-button {
    margin: 0 var(--space-3) 0 0; padding: var(--space-2) var(--space-4);
    border: 1px solid transparent; border-radius: var(--radius-sm);
    background: var(--accent); color: var(--ink-on-dark);
    box-shadow: var(--shadow-glass-sm);
    font-family: inherit; font-size: 12px; line-height: 16px; font-weight: 700;
    cursor: pointer; transition: background-color .15s, transform .1s;
}
.form-control[type="file"]:hover:not(:disabled):not([readonly])::file-selector-button { background: var(--accent-hover); }
.form-control[type="file"]:active::file-selector-button { transform: scale(.97); }
.form-help { display: block; margin-top: var(--space-1-5); font-size: 11px; line-height: 14px; color: var(--ink-600); }

/* Submit — ds-btn--primary ukuran penuh */
.btn-submit-log {
    display: flex; align-items: center; justify-content: center; gap: var(--space-2); width: 100%;
    padding: var(--space-3-5) var(--space-6);
    border-radius: var(--radius-md);
    background: var(--accent); border: 1px solid transparent; color: var(--ink-on-dark);
    box-shadow: var(--shadow-glass-sm);
    font-family: inherit; font-size: 13px; line-height: 16px; font-weight: 800; letter-spacing: 0.03em;
    cursor: pointer; transition: background-color .15s, transform .1s, box-shadow .15s;
}
.btn-submit-log:hover { background: var(--accent-hover); box-shadow: var(--shadow-glass); }
.btn-submit-log:active { transform: scale(.98); }
.btn-submit-log:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
</style>
@endonce
