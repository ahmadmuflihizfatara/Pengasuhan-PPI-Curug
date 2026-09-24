<x-app-layout>

<x-island-navbar />

<main class="max-w-3xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7"
         x-data="{
            berat: '', tinggi: '',
            get bmi() { const b = parseFloat(this.berat), t = parseFloat(this.tinggi) / 100; return b > 0 && t > 0 ? b / (t * t) : null },
            get kategori() {
                const v = this.bmi;
                if (v === null) return null;
                // Klasifikasi WHO (dewasa)
                if (v < 18.5) return { label: 'Berat Badan Kurang', warna: 'text-sky-600', bg: 'bg-sky-50 border-sky-200', saran: 'Tingkatkan asupan gizi seimbang dan latihan kekuatan secara teratur.' };
                if (v < 25)   return { label: 'Normal', warna: 'text-emerald-600', bg: 'bg-emerald-50 border-emerald-200', saran: 'Pertahankan pola makan dan latihan fisik rutin.' };
                if (v < 30)   return { label: 'Berat Badan Berlebih', warna: 'text-amber-600', bg: 'bg-amber-50 border-amber-200', saran: 'Kurangi asupan kalori berlebih dan tambah latihan kardio.' };
                return { label: 'Obesitas', warna: 'text-rose-600', bg: 'bg-rose-50 border-rose-200', saran: 'Disarankan konsultasi ke tenaga kesehatan / poliklinik.' };
            },
            get beratIdeal() { const t = parseFloat(this.tinggi) / 100; return t > 0 ? [18.5 * t * t, 24.9 * t * t] : null },
         }">

        <div class="rounded-2xl bg-gradient-to-r from-blue-900/90 via-indigo-900/85 to-slate-900/90 border border-white/30 p-6 text-white mb-6 shadow-xl">
            <h1 class="text-2xl font-extrabold tracking-tight flex items-center gap-2 mb-1">
                <i class="fa-solid fa-weight-scale"></i> Kalkulator BMI
            </h1>
            <p class="text-xs text-sky-100/80">Hitung Body Mass Index (Indeks Massa Tubuh) dari berat dan tinggi badan Anda.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <label class="rounded-2xl bg-white/70 border border-white/80 p-4 shadow-sm block">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Berat Badan (kg)</span>
                <input type="number" x-model="berat" min="1" max="300" step="0.1" inputmode="decimal" placeholder="mis. 65"
                       class="mt-1 w-full border-0 bg-transparent p-0 text-2xl font-black text-slate-900 focus:ring-0">
            </label>
            <label class="rounded-2xl bg-white/70 border border-white/80 p-4 shadow-sm block">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tinggi Badan (cm)</span>
                <input type="number" x-model="tinggi" min="50" max="250" step="0.1" inputmode="decimal" placeholder="mis. 170"
                       class="mt-1 w-full border-0 bg-transparent p-0 text-2xl font-black text-slate-900 focus:ring-0">
            </label>
        </div>

        <div class="rounded-2xl border p-6 text-center shadow-sm transition" :class="kategori ? kategori.bg : 'bg-white/60 border-white/80'" aria-live="polite">
            <template x-if="bmi === null">
                <p class="text-sm text-slate-500">Isi berat dan tinggi badan untuk melihat hasil.</p>
            </template>
            <template x-if="bmi !== null">
                <div>
                    <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">BMI Anda</div>
                    <div class="text-5xl font-black font-mono my-1" :class="kategori.warna" x-text="bmi.toFixed(1)"></div>
                    <div class="text-lg font-extrabold" :class="kategori.warna" x-text="kategori.label"></div>
                    <p class="text-xs text-slate-600 mt-2" x-text="kategori.saran"></p>
                    <p class="text-xs text-slate-600 mt-1" x-show="beratIdeal">
                        Berat badan ideal untuk tinggi Anda:
                        <strong x-text="beratIdeal[0].toFixed(1) + ' – ' + beratIdeal[1].toFixed(1) + ' kg'"></strong>
                    </p>
                </div>
            </template>
        </div>

        <div class="mt-6 rounded-2xl bg-white/60 border border-white/80 p-4 shadow-sm">
            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Klasifikasi BMI (WHO)</div>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-slate-200/60">
                    <tr><td class="py-1.5 font-mono">&lt; 18,5</td><td class="py-1.5 font-bold text-sky-600">Berat Badan Kurang</td></tr>
                    <tr><td class="py-1.5 font-mono">18,5 – 24,9</td><td class="py-1.5 font-bold text-emerald-600">Normal</td></tr>
                    <tr><td class="py-1.5 font-mono">25 – 29,9</td><td class="py-1.5 font-bold text-amber-600">Berat Badan Berlebih</td></tr>
                    <tr><td class="py-1.5 font-mono">&ge; 30</td><td class="py-1.5 font-bold text-rose-600">Obesitas</td></tr>
                </tbody>
            </table>
            <p class="text-[11px] text-slate-500 mt-2">Rumus: BMI = berat (kg) ÷ tinggi (m)². Hasil hanya indikasi awal, bukan diagnosis medis.</p>
        </div>
    </div>
</main>

</x-app-layout>
