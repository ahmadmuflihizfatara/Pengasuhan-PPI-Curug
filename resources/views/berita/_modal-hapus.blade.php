{{-- Modal konfirmasi hapus berita — pola modal tab surat & acara. Pakai: tombol type="button" onclick="bukaHapusBerita(this.form, judul)" --}}
<div class="ds-modal-overlay" id="beritaHapusModal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="beritaHapusJudul">
    <div class="ds-modal">
        <div class="ds-modal__icon"><i class="fa-solid fa-trash"></i></div>
        <h3 class="ds-modal__title" id="beritaHapusJudul">Hapus Berita?</h3>
        <p class="ds-modal__body"><strong id="beritaHapusNama" style="color:var(--ink-900)"></strong><br>Berita beserta gambar sampulnya akan dihapus permanen.</p>
        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" onclick="tutupHapusBerita()">Batal</button>
            <button type="button" class="ds-btn ds-btn--primary" style="background:var(--danger);" onclick="beritaHapusForm && beritaHapusForm.submit()"><i class="fa-solid fa-trash"></i> Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
let beritaHapusForm = null;
function bukaHapusBerita(form, judul) {
    beritaHapusForm = form;
    document.getElementById('beritaHapusNama').textContent = judul;
    document.getElementById('beritaHapusModal').style.display = 'flex';
}
function tutupHapusBerita() {
    document.getElementById('beritaHapusModal').style.display = 'none';
    beritaHapusForm = null;
}
document.getElementById('beritaHapusModal').addEventListener('click', function (e) {
    if (e.target === this) tutupHapusBerita();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupHapusBerita(); });
</script>
