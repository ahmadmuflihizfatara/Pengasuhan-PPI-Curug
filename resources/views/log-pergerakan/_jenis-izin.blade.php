{{-- Pil jenis izin cabang Perizinan + perilaku per jenis — dipakai form mandiri taruna & tablet pos jaga.
     Halaman pemakai wajib punya: #inputKeterangan, #labelKeterangan, #fieldDokumentasi,
     dan memanggil terapkanJenisIzin(sub) di dalam setSubcat(). --}}
@php use App\Models\LogPergerakan; @endphp
@once
<style>
    .jenis-izin-ket { display: flex; align-items: center; gap: var(--space-1-5); margin: var(--space-2) 0 0; font-size: 11px; line-height: 15px; font-weight: 600; color: var(--ink-600); }
    .jenis-izin-ket i { color: var(--accent); }
    .subcat-pill--khusus.active { background: var(--danger); }
    .catatan-urgensi { align-items: flex-start; margin: var(--space-3) 0 0; }
    .catatan-urgensi strong { display: block; }
    .catatan-urgensi span { font-size: 11px; font-weight: 500; }
</style>
@endonce

<div class="subcat-pills" id="subcatPerizinan" role="group" aria-label="Jenis izin">
    @foreach(LogPergerakan::SUBKAT_PERIZINAN as $sub => $jenis)
    <button type="button" class="subcat-pill {{ $loop->first ? 'active' : '' }} {{ $sub === LogPergerakan::SUBKAT_KHUSUS ? 'subcat-pill--khusus' : '' }}"
            data-sub="{{ $sub }}" title="{{ $jenis['ket'] }}" onclick="setSubcat(this.dataset.sub, this)">
        <i class="fa-solid {{ $jenis['ikon'] }}"></i> {{ $sub === LogPergerakan::SUBKAT_KHUSUS ? 'Izin Keluar Khusus' : $sub }}
    </button>
    @endforeach
</div>
<p class="jenis-izin-ket" id="jenisIzinKet"><i class="fa-solid fa-circle-info"></i> <span></span></p>
<div class="ds-alert ds-alert--danger catatan-urgensi" id="catatanUrgensi" style="display:none" role="status">
    <i class="fa-solid fa-bolt ds-icon"></i>
    <div>
        <strong>Izin Keluar Khusus — urgensi tinggi, tanpa surat</strong>
        <span>Tuliskan alasan urgensi dengan jelas. Log ditandai <b>Urgensi Tinggi</b> dan disorot agar segera divalidasi pengasuh.</span>
    </div>
</div>

<script>
const JENIS_IZIN = @json(LogPergerakan::SUBKAT_PERIZINAN);
const JENIS_IZIN_KHUSUS = @json(LogPergerakan::SUBKAT_KHUSUS);

// Sesuaikan form dengan jenis izin: Izin Khusus tanpa foto surat; label & contoh keterangan per jenis.
// Untuk cabang lain (ekskul/olahraga) sub tidak ada di daftar → form kembali normal.
function terapkanJenisIzin(sub) {
    const jenis = JENIS_IZIN[sub];
    const khusus = sub === JENIS_IZIN_KHUSUS;

    const dok = document.getElementById('fieldDokumentasi');
    dok.style.display = khusus ? 'none' : '';
    if (khusus) dok.querySelectorAll('input[type=file]').forEach(i => i.value = '');
    document.getElementById('catatanUrgensi').style.display = khusus ? 'flex' : 'none';

    const ket = document.getElementById('jenisIzinKet');
    ket.style.display = jenis ? '' : 'none';
    if (!jenis) return;
    ket.querySelector('span').textContent = jenis.ket;
    document.getElementById('labelKeterangan').innerHTML = jenis.label_ket + ' <span class="req">*</span>';
    document.getElementById('inputKeterangan').placeholder = jenis.contoh;
}

// Kolom target berada di bawah partial ini → terapkan jenis awal setelah DOM siap
document.addEventListener('DOMContentLoaded', function () {
    const aktif = document.querySelector('#subcatPerizinan:not(.d-none) .subcat-pill.active');
    if (aktif) terapkanJenisIzin(aktif.dataset.sub);
});
</script>
