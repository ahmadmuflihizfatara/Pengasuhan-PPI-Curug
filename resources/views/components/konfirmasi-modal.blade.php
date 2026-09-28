{{-- Modal konfirmasi glass pengganti confirm() bawaan browser. Pasang sekali per halaman: <x-konfirmasi-modal />
     Lalu beri atribut pada <form>:
       data-konfirmasi="Pesan konfirmasi"            (wajib)
       data-konfirmasi-judul="Judul modal"           (opsional, default "Konfirmasi")
       data-konfirmasi-varian="danger|success|warning|accent" (opsional, default danger)
       data-konfirmasi-tombol="Ya, Hapus"            (opsional, default "Ya, Lanjutkan") --}}
@once
<div class="ds-modal-overlay" id="konfirmasiModal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="konfirmasiJudul">
    <div class="ds-modal">
        <div class="ds-modal__icon" id="konfirmasiIkon"><i class="fa-solid fa-circle-question"></i></div>
        <h3 class="ds-modal__title" id="konfirmasiJudul">Konfirmasi</h3>
        <p class="ds-modal__body" id="konfirmasiPesan"></p>
        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" id="konfirmasiBatal">Batal</button>
            <button type="button" class="ds-btn ds-btn--primary" id="konfirmasiYa"></button>
        </div>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('konfirmasiModal');
    const ikonVarian = { danger: 'fa-triangle-exclamation', success: 'fa-circle-check', warning: 'fa-hourglass-half', accent: 'fa-circle-question' };
    let formTarget = null;

    function tutup() { modal.style.display = 'none'; formTarget = null; }

    // Tangkap submit form ber-atribut data-konfirmasi (fase capture, sebelum form terkirim)
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!form.dataset || !form.dataset.konfirmasi || form.dataset.konfirmasiOk) return;
        e.preventDefault();
        formTarget = form;
        const varian = form.dataset.konfirmasiVarian || 'danger';
        const warna = varian === 'accent' ? 'var(--accent)' : 'var(--' + varian + ')';
        const ikon = document.getElementById('konfirmasiIkon');
        ikon.style.background = varian === 'accent' ? 'var(--accent-tint)' : 'var(--' + varian + '-tint)';
        ikon.style.color = warna;
        ikon.innerHTML = '<i class="fa-solid ' + (ikonVarian[varian] || ikonVarian.danger) + '"></i>';
        document.getElementById('konfirmasiJudul').textContent = form.dataset.konfirmasiJudul || 'Konfirmasi';
        document.getElementById('konfirmasiPesan').textContent = form.dataset.konfirmasi;
        const ya = document.getElementById('konfirmasiYa');
        ya.textContent = form.dataset.konfirmasiTombol || 'Ya, Lanjutkan';
        ya.style.background = warna;
        modal.style.display = 'flex';
        ya.focus();
    }, true);

    document.getElementById('konfirmasiYa').addEventListener('click', function () {
        if (!formTarget) return;
        const form = formTarget;
        form.dataset.konfirmasiOk = '1';
        tutup();
        form.requestSubmit ? form.requestSubmit() : form.submit();
    });
    document.getElementById('konfirmasiBatal').addEventListener('click', tutup);
    modal.addEventListener('click', e => { if (e.target === modal) tutup(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && modal.style.display !== 'none') tutup(); });
})();
</script>
@endonce
