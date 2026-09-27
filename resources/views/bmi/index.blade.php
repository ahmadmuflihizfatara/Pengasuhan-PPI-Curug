<x-app-layout>
{{-- Input memakai gaya form yang sama dengan form Log Gerbang, Surat & Reward --}}
<x-form-glass-style />
<style>
    [x-cloak] { display: none !important; }
    .bmi-form .form-group:last-child { margin-bottom: 0; }
    .bmi-input { position: relative; }
    .bmi-input .form-control { padding-right: 52px; font-family: var(--font-mono); font-size: 20px; line-height: 28px; font-weight: 800; letter-spacing: -0.02em; }
    .bmi-input .form-control::placeholder { font-family: var(--font-sans, inherit); font-size: 13px; font-weight: 500; letter-spacing: 0; }
    .bmi-input__unit { position: absolute; right: var(--space-3-5); top: 50%; transform: translateY(-50%); font-size: 12px; font-weight: 700; color: var(--ink-500); pointer-events: none; }

    /* Hasil — pola kartu status tab poin */
    .bmi-hasil { display: flex; align-items: flex-start; gap: var(--space-3-5); }
    .bmi-hasil .ds-stat__icon { flex-shrink: 0; width: 44px; height: 44px; font-size: 17px; }
    .bmi-hasil__label { display: block; font-size: 11px; line-height: 16px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .bmi-hasil__top { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-1) var(--space-2-5); margin: var(--space-1) 0; }
    .bmi-hasil__nilai { font-family: var(--font-mono); font-size: 36px; line-height: 40px; font-weight: 900; letter-spacing: -0.03em; }
    .bmi-hasil__saran { margin: 0; font-size: 12px; line-height: 18px; font-weight: 500; color: var(--ink-700); }
    .bmi-ideal { margin-top: var(--space-4); padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .bmi-ideal__label { display: block; font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .bmi-ideal__nilai { font-family: var(--font-mono); font-size: 15px; line-height: 20px; font-weight: 800; color: var(--ink-900); }

    .bmi-tabel td { vertical-align: middle; }
    .ds-table td.bmi-rentang { font-family: var(--font-mono); font-weight: 700; color: var(--ink-900) !important; white-space: nowrap; }
    .ds-table tr.bmi-aktif { background: var(--accent-tint); }
    .bmi-catatan { margin: var(--space-3) 0 0; font-size: 11px; line-height: 16px; font-weight: 500; color: var(--ink-600); }
</style>

<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden"
         x-data="{
            berat: '', tinggi: '',
            get bmi() { const b = parseFloat(this.berat), t = parseFloat(this.tinggi) / 100; return b > 0 && t > 0 ? b / (t * t) : null },
            get kategori() {
                const v = this.bmi;
                if (v === null) return null;
                // Klasifikasi WHO (dewasa)
                if (v < 18.5) return { key: 'kurang',   label: 'Berat Badan Kurang',   varian: 'info',    ikon: 'fa-arrow-down',            saran: 'Tingkatkan asupan gizi seimbang dan latihan kekuatan secara teratur.' };
                if (v < 25)   return { key: 'normal',   label: 'Normal',               varian: 'success', ikon: 'fa-circle-check',          saran: 'Pertahankan pola makan dan latihan fisik rutin.' };
                if (v < 30)   return { key: 'berlebih', label: 'Berat Badan Berlebih', varian: 'warning', ikon: 'fa-triangle-exclamation', saran: 'Kurangi asupan kalori berlebih dan tambah latihan kardio.' };
                return               { key: 'obesitas', label: 'Obesitas',             varian: 'danger',  ikon: 'fa-heart-pulse',           saran: 'Disarankan konsultasi ke tenaga kesehatan / poliklinik.' };
            },
            get beratIdeal() { const t = parseFloat(this.tinggi) / 100; return t > 0 ? [18.5 * t * t, 24.9 * t * t] : null },
            angka(n) { return n.toFixed(1).replace('.', ',') },
         }">

        {{-- Header — sama dengan header tab poin, surat & barak --}}
        <x-page-banner title="Kalkulator BMI" icon="fa-weight-scale"
            subtitle="Hitung Body Mass Index (Indeks Massa Tubuh) dari berat dan tinggi badan Anda" />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
            {{-- Form ukuran tubuh --}}
            <div class="form-card bmi-form">
                <div class="form-section-title">
                    <span><i class="fa-solid fa-ruler-combined me-2" style="color:var(--accent)"></i> Ukuran Tubuh</span>
                    <span class="ds-badge ds-badge--accent"><i class="fa-solid fa-lock"></i> Tidak disimpan</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="beratBadan">Berat Badan</label>
                    <div class="bmi-input">
                        <input type="number" id="beratBadan" x-model="berat" min="1" max="300" step="0.1" inputmode="decimal"
                               placeholder="Contoh: 65" class="form-control">
                        <span class="bmi-input__unit">kg</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="tinggiBadan">Tinggi Badan</label>
                    <div class="bmi-input">
                        <input type="number" id="tinggiBadan" x-model="tinggi" min="50" max="250" step="0.1" inputmode="decimal"
                               placeholder="Contoh: 170" class="form-control">
                        <span class="bmi-input__unit">cm</span>
                    </div>
                    <small class="form-help"><i class="fa-solid fa-circle-info"></i> Hasil dihitung langsung di perangkat Anda saat angka diisi.</small>
                </div>
            </div>

            {{-- Hasil BMI --}}
            <div class="ds-card" aria-live="polite">
                <div class="ds-card__head">
                    <h3 class="ds-card__title"><i class="fa-solid fa-gauge-high ds-icon"></i> Hasil BMI</h3>
                    <p class="ds-card__desc">Kategori mengikuti klasifikasi WHO untuk dewasa</p>
                </div>

                <div class="ds-empty" x-show="bmi === null">
                    <i class="fa-solid fa-weight-scale ds-icon"></i>
                    Isi berat dan tinggi badan untuk melihat hasil.
                </div>

                <div x-show="bmi !== null" x-cloak>
                    <template x-if="kategori">
                        <div>
                            <div class="bmi-hasil">
                                <span class="ds-stat__icon" :class="kategori.varian !== 'info' && 'ds-stat__icon--' + kategori.varian"><i class="fa-solid" :class="kategori.ikon"></i></span>
                                <div>
                                    <span class="bmi-hasil__label">BMI Anda</span>
                                    <div class="bmi-hasil__top">
                                        <span class="bmi-hasil__nilai" :style="`color: var(--${kategori.varian}-ink)`" x-text="angka(bmi)"></span>
                                        <span class="ds-badge" :class="'ds-badge--' + kategori.varian" x-text="kategori.label"></span>
                                    </div>
                                    <p class="bmi-hasil__saran" x-text="kategori.saran"></p>
                                </div>
                            </div>
                            <div class="bmi-ideal" x-show="beratIdeal">
                                <span class="bmi-ideal__label">Berat badan ideal untuk tinggi Anda</span>
                                <span class="bmi-ideal__nilai" x-text="beratIdeal && (angka(beratIdeal[0]) + ' – ' + angka(beratIdeal[1]) + ' kg')"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Klasifikasi BMI --}}
        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-table-list ds-icon"></i> Klasifikasi BMI (WHO)</h3>
                    <p class="ds-card__desc">Baris kategori Anda disorot setelah hasil muncul</p>
                </div>
            </div>
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table bmi-tabel" data-no-tools>
                        <thead>
                            <tr>
                                <th>Rentang BMI</th>
                                <th>Kategori</th>
                                <th>Saran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach([
                                ['kurang',   '< 18,5',      'Berat Badan Kurang',   'info',    'Tingkatkan asupan gizi seimbang dan latihan kekuatan.'],
                                ['normal',   '18,5 – 24,9', 'Normal',               'success', 'Pertahankan pola makan dan latihan fisik rutin.'],
                                ['berlebih', '25 – 29,9',   'Berat Badan Berlebih', 'warning', 'Kurangi kalori berlebih dan tambah latihan kardio.'],
                                ['obesitas', '≥ 30',        'Obesitas',             'danger',  'Konsultasi ke tenaga kesehatan / poliklinik.'],
                            ] as [$key, $rentang, $label, $varian, $saran])
                            <tr :class="{ 'bmi-aktif': kategori && kategori.key === '{{ $key }}' }">
                                <td class="bmi-rentang">{{ $rentang }}</td>
                                <td><span class="ds-badge ds-badge--{{ $varian }}">{{ $label }}</span></td>
                                <td class="tbl-muted">{{ $saran }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="bmi-catatan"><i class="fa-solid fa-calculator" style="color:var(--accent)"></i> Rumus: BMI = berat (kg) ÷ tinggi (m)². Hasil hanya indikasi awal, bukan diagnosis medis.</p>
        </div>

    </div>
</main>

</x-app-layout>
