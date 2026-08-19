# MASTER DESIGN SPECIFICATION: SPATIAL GLASS COCKPIT & FLOATING WORKSPACE
**Project:** Sistem Informasi Pengasuhan Taruna — PPI Curug  
**Design Reference:** Concept inspired by *Green Heaven UI/UX Workspace* (`design.mp4`)  
**Target Version:** 2.0 Glassmorphism & Floating Island Spatial Architecture  
**Document Purpose:** Panduan Master & Standar Operasional Desain Frontend bagi AI Agentic Coder dan Developer untuk merekayasa ulang (refactor) seluruh UI/UX aplikasi secara presisi, modern, dan konsisten tanpa mengubah fitur atau background yang telah ada.

---

## 1. RINGKASAN EKSEKUTIF & PRINSIP UTAMA (EXECUTIVE SUMMARY)

Dokumen ini merumuskan spesifikasi visual dan teknis UI/UX generasi baru untuk aplikasi **Pengasuhan PPI Curug** yang diadaptasi dari konsep **Green Heaven Workspace** (`design.mp4`). Desain ini menggabungkan estetika *Spatial UI*, *Frosted Glassmorphism 2.0*, *Floating Capsule Dock*, tipografi editorial display yang prestisius, dan kanvas workspace melayang dengan pencahayaan ambient glow.

```
+-----------------------------------------------------------------------------------+
|  [Layer 0] Fixed Background: BG.png (Fixed + Blur + Ambient Radial Vignette)       |
|  +-----------------------------------------------------------------------------+  |
|  |  [Layer 1] Top Floating Island Capsule Dock: (Logo, Nav Pills, Profile)     |  |
|  +-----------------------------------------------------------------------------+  |
|  |  [Layer 2] Hero & Omnibar Center:                                           |  |
|  |    - Pill Tag: "✦ Sistem Informasi Pengasuhan Taruna"                       |  |
|  |    - Editorial Headline: "Keunggulan Disiplin & Integritas Masa Depan"       |  |
|  |    - Floating AI/Search Omnibar with Quick Action Pill                       |  |
|  |  +-----------------------------------------------------------------------+  |  |
|  |  |  [Layer 3] Floating Spatial Master Workspace Canvas (rounded-3xl)     |  |  |
|  |  |  +----------------+  +---------------------------------------------+  |  |  |
|  |  |  | Minimalist     |  | Workspace Action Bar (Filter Pills, Badges) |  |  |  |
|  |  |  | Glass Sidebar  |  | Content Grid (Stat Cards, Flow Nodes,       |  |  |  |
|  |  |  | (Active White  |  | Real-time Tracking, Tables, Form Panels)    |  |  |  |
|  |  |  |  Pill Highlight|  |                                             |  |  |  |
|  |  |  +----------------+  +---------------------------------------------+  |  |  |
|  |  +-----------------------------------------------------------------------+  |  |
+-----------------------------------------------------------------------------------+
```

### 3 ATURAN BAKU (GOLDEN RULES):
> [!IMPORTANT]
> 1. **BACKGROUND INTEGRITY**: File gambar latar belakang (`BG.png`) yang berada di layer root `resources/views/layouts/dashboardLayout.blade.php` **TIDAK BOLEH DIGANTI ATAU DIHAPUS**. Seluruh komponen visual kaca (glassmorphism) dan panel melayang dibangun di atas layer latar belakang ini.
> 2. **ZERO FEATURE DELETION**: **TIDAK BOLEH MENGURANGI, MENGHAPUS, ATAU MERUSAK SEDIKITPUN FITUR, FORM, ROUTE, LOGIC, VALIDASI, ATAU DATABASE** yang sudah ada pada web. Semua modul (Poin, Sanksi, Konsinyir, Keluhan Barak, Apel, Perizinan Surat, Log Pergerakan Pos Jaga, Mahasiswa, Activity Log, Users, Profile, Setting) harus 100% berfungsi normal dengan layout visual yang telah di-upgrade.
> 3. **PIXEL-PERFECT FIDELITY**: Semua komponen harus mematuhi token CSS, radius, blur, bayangan, dan tata letak floating capsule yang tertera di dokumen ini.

---

## 2. DESIGN TOKENS & SYSTEM FOUNDATIONS

### 2.1 Color Palette & Glassmorphism Tokens

Sistem warna memadukan transparansi kaca frosted dengan aksen kedirgantaraan PPI Curug (Aviation Navy, Emerald Eco, Golden Aviation, dan Alert Rose).

| Token Variable | Nilai CSS / RGBA | Penggunaan Visual |
| :--- | :--- | :--- |
| `--glass-bg-ultra` | `rgba(255, 255, 255, 0.12)` | Master floating workspace canvas, search omnibar |
| `--glass-bg-panel` | `rgba(255, 255, 255, 0.65)` | Kartu konten standar, tabel, modal dialog |
| `--glass-bg-card` | `rgba(255, 255, 255, 0.78)` | Stat cards, form container, dropdown menu |
| `--glass-bg-dark` | `rgba(15, 23, 42, 0.65)` | Floating capsule top dock, dark mode widgets |
| `--glass-border-light` | `rgba(255, 255, 255, 0.45)` | Garis tepi kartu standar dengan efek kilau kaca |
| `--glass-border-glow` | `rgba(255, 255, 255, 0.75)` | Highlight specular pada sisi atas kartu melayang |
| `--glass-border-dark` | `rgba(255, 255, 255, 0.12)` | Garis tepi pada floating top capsule & dark badges |
| `--color-accent-navy` | `#1e3a8a` / `rgba(30, 58, 138, 0.9)` | Gradien banner, identitas PPI Curug |
| `--color-accent-emerald` | `#059669` / `rgba(16, 185, 129, 0.9)` | Poin penghargaan, status aktif, safe node |
| `--color-accent-gold` | `#d97706` / `rgba(245, 158, 11, 0.9)` | Taruna bintang, status perizinan, alert sedang |
| `--color-accent-rose` | `#e11d48` / `rgba(225, 29, 72, 0.9)` | Poin pelanggaran, sanksi berat, emergency pos jaga |
| `--text-primary` | `#0f172a` (Slate 900) | Teks utama pada kartu terang |
| `--text-secondary` | `#475569` (Slate 600) | Subteks, label form, keterangan data |
| `--text-light-primary` | `#ffffff` | Teks pada banner gelap & top capsule dock |
| `--text-light-muted` | `rgba(255, 255, 255, 0.72)` | Subtitle hero, label capsule, secondary info |

### 2.2 Backdrop Filters & Shadow Elevasi

```css
/* Token Shadow & Blur Sesuai Video design.mp4 */
--blur-subtle: blur(12px) saturate(160%);
--blur-standard: blur(20px) saturate(180%);
--blur-heavy: blur(32px) saturate(200%);

--shadow-capsule: 0 10px 30px -5px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.12);
--shadow-workspace: 0 25px 50px -12px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.3);
--shadow-card-hover: 0 20px 35px -8px rgba(0, 0, 0, 0.18), 0 0 15px rgba(255, 255, 255, 0.4) inset;
```

### 2.3 Typography Hierarchy & Pairing

Berdasarkan *design.mp4*, tipografi menggunakan kombinasi prestisius antara **Serif Editorial Display** (untuk Headline/Hero) dan **Clean Geometric Sans** (untuk Antarmuka UI, Data, dan Navigasi).

1. **Display & Headline Font**:
   - Font Family: `'Instrument Serif'`, `'Playfair Display'`, `'Newsreader'`, atau `'Merriweather'`, serif
   - Karakteristik: Anggun, berwibawa, berkelas tinggi, editorial aesthetic
   - Ukuran Hero: `text-4xl` hingga `text-6xl` (36px - 60px), font-weight: 500-600
2. **Body & UI Interface Font**:
   - Font Family: `'Inter'`, `'Plus Jakarta Sans'`, `'Figtree'`, sans-serif
   - Karakteristik: Sangat bersih, keterbacaan tinggi pada latar kaca, geometris modern
   - Bobot: 400 (Regular), 500 (Medium), 600 (SemiBold), 700 (Bold), 800 (ExtraBold)
3. **Data / Monospace Numbers Font**:
   - Font Family: `'JetBrains Mono'`, `'Fira Code'`, monospace
   - Penggunaan: Nomor Induk Taruna (NIT), Jam Pos Jaga, Token Presensi, Koordinat

---

## 3. LAYOUT ARCHITECTURE & SPATIAL CANVAS STRUCTURE

Struktur hierarki DOM dirancang secara berlapis (layered spatial stacking) untuk menghasilkan kedalaman visual 3D yang halus.

### 3.1 Layer 0: Global Background Cockpit
```html
<!-- Diletakkan di dashboardLayout.blade.php & guest.blade.php -->
<div id="global-cockpit-bg-layer" class="fixed -inset-5 bg-cover bg-center bg-no-repeat z-[-10] pointer-events-none scale-105" 
     style="background-image: url('{{ asset('images/BG.png') }}'); filter: blur(3px) brightness(0.94);"></div>
<div id="global-cockpit-overlay-layer" class="fixed inset-0 z-[-9] pointer-events-none"
     style="background: radial-gradient(circle at 50% 20%, rgba(15, 23, 42, 0.08) 0%, rgba(15, 23, 42, 0.4) 100%);"></div>
```

### 3.2 Layer 1: Top Floating Island Capsule Navbar
Floating Island melayang di bagian atas halaman (center-aligned pill navigation bar).

```html
<header class="w-full pt-4 pb-2 px-6 sticky top-0 z-50 flex items-center justify-between pointer-events-auto">
    <!-- Brand Logo Left -->
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-2xl bg-white/20 hover:bg-white/30 backdrop-blur-xl border border-white/30 transition-all duration-300 shadow-md">
        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-700 to-indigo-500 flex items-center justify-center text-white font-black text-sm shadow-inner">
            <i class="fa-solid fa-plane-departure text-xs"></i>
        </div>
        <span class="font-bold text-slate-800 tracking-tight text-sm hidden sm:inline">PPI CURUG</span>
    </a>

    <!-- Center Floating Capsule Navigation Dock -->
    <nav class="flex items-center gap-1 sm:gap-2 px-3 py-1.5 rounded-full bg-slate-900/60 backdrop-blur-2xl border border-white/15 shadow-2xl">
        <a href="{{ route('dashboard') }}" class="p-2.5 rounded-full text-white/80 hover:text-white hover:bg-white/10 transition" title="Dashboard">
            <i class="fa-solid fa-bell text-sm"></i>
        </a>
        <a href="{{ route('poin.index') }}" class="p-2.5 rounded-full text-white/80 hover:text-white hover:bg-white/10 transition" title="Poin & Pelanggaran">
            <i class="fa-solid fa-chart-simple text-sm"></i>
        </a>
        <a href="{{ route('log-pergerakan.index') }}" class="p-2.5 rounded-full text-white/80 hover:text-white hover:bg-white/10 transition" title="Log Pos Jaga">
            <i class="fa-solid fa-compass text-sm"></i>
        </a>
        <a href="{{ route('konsinyir.index') }}" class="p-2.5 rounded-full text-white/80 hover:text-white hover:bg-white/10 transition" title="Konsinyir & Izin">
            <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
        </a>
        <a href="{{ route('profile.edit') }}" class="p-2.5 rounded-full text-white/80 hover:text-white hover:bg-white/10 transition" title="Profil">
            <i class="fa-solid fa-user text-sm"></i>
        </a>
        <div class="w-px h-5 bg-white/20 my-auto"></div>
        <button type="button" class="p-2.5 rounded-full text-white/80 hover:text-white hover:bg-white/10 transition" title="Menu Cepat">
            <i class="fa-solid fa-table-cells-large text-sm"></i>
        </button>
    </nav>

    <!-- Right Quick Action Pill / Auth Button -->
    <div class="flex items-center gap-2">
        @auth
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-full bg-white/90 hover:bg-white text-slate-900 font-semibold text-xs shadow-lg transition-all duration-300 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ Auth::user()->name }}</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="px-5 py-2 rounded-full bg-white text-slate-900 font-bold text-xs shadow-lg hover:bg-slate-100 transition-all duration-300">
                Masuk Sistem
            </a>
        @endauth
    </div>
</header>
```

### 3.3 Layer 2: Hero & Command Center
Bagian header editorial yang memberikan kesan prestisius dan modern seperti pada *design.mp4*.

```html
<section class="max-w-4xl mx-auto text-center py-6 px-4 flex flex-col items-center">
    <!-- Top Pill Badge -->
    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/25 backdrop-blur-md border border-white/30 shadow-sm text-xs font-semibold text-slate-800 mb-3 animate-fade-in">
        <span class="text-amber-600 font-bold">✦</span>
        <span>Sistem Pengasuhan & Karakter Taruna</span>
    </div>

    <!-- Editorial Serif Display Headline -->
    <h1 class="text-3xl sm:text-5xl font-medium tracking-tight text-slate-900 font-serif drop-shadow-sm leading-tight max-w-2xl mb-2">
        Keunggulan Disiplin untuk Pemimpin Masa Depan
    </h1>

    <!-- Subtitle Sans-serif -->
    <p class="text-xs sm:text-sm text-slate-700 max-w-xl mx-auto leading-relaxed mb-6 font-normal">
        Pemantauan terpadu catatan poin, perizinan pos jaga, rekap apel, dan pembinaan karakter taruna Politeknik Penerbangan Indonesia Curug.
    </p>

    <!-- Floating Omnibar Search Pill with Action Button -->
    <div class="w-full max-w-lg relative group">
        <div class="flex items-center bg-white/40 hover:bg-white/60 focus-within:bg-white/80 backdrop-blur-2xl border border-white/60 focus-within:border-indigo-400 rounded-full px-4 py-2 shadow-xl transition-all duration-300">
            <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm ml-1 mr-3"></i>
            <input type="text" 
                   id="global-omnibar-input"
                   placeholder="Cari nama taruna, NIT, surat izin, kamar barak..." 
                   class="w-full bg-transparent border-none outline-none text-xs sm:text-sm text-slate-800 placeholder-slate-500 font-medium focus:ring-0">
            <button type="button" class="w-8 h-8 rounded-full bg-slate-900 hover:bg-slate-800 text-white flex items-center justify-center transition-transform duration-200 active:scale-95 shadow-md flex-shrink-0">
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>
    </div>
</section>
```

### 3.4 Layer 3: Floating Spatial Master Workspace Canvas
Kanvas utama berukuran besar yang membungkus konten aplikasi dengan radius sudut membulat lebar (`rounded-3xl`), efek kaca multi-layer, dan pembagian layout terstruktur.

```html
<main class="max-w-7xl mx-auto px-4 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/20 backdrop-blur-2xl border border-white/40 shadow-2xl p-4 sm:p-6 overflow-hidden relative">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Integrated Glass Sidebar (Col 1) -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <!-- Komponen Sidebar Refactored -->
                <x-sidebar :active="$active ?? 'dashboard'" />
            </aside>

            <!-- Main Workspace Canvas Area (Col 2) -->
            <section class="flex-1 min-w-0">
                <!-- Top Workspace Control & Filter Bar -->
                <div class="workspace-action-bar flex flex-wrap items-center justify-between gap-3 pb-4 mb-4 border-b border-white/25">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-folder-open text-indigo-600"></i>
                            <span>{{ $pageTitle ?? 'Workspace Pengasuhan' }}</span>
                        </span>
                    </div>

                    <!-- Filter Action Pills -->
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="filter-pill-btn px-3 py-1.5 rounded-full bg-white/40 hover:bg-white/60 border border-white/40 text-xs font-semibold text-slate-700 flex items-center gap-1.5 cursor-pointer transition shadow-sm">
                            <span>Filter Status</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-500"></i>
                        </div>
                        <div class="filter-pill-btn px-3 py-1.5 rounded-full bg-white/40 hover:bg-white/60 border border-white/40 text-xs font-semibold text-slate-700 flex items-center gap-1.5 cursor-pointer transition shadow-sm">
                            <span>Urutkan</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-500"></i>
                        </div>
                        <div class="stat-pill-indicator px-3 py-1.5 rounded-full bg-slate-900/70 backdrop-blur-md text-white text-xs font-medium flex items-center gap-2 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                            <span>Live Data</span>
                        </div>
                    </div>
                </div>

                <!-- Konten Halaman Spesifik / Blade Content Slot -->
                <div class="workspace-page-content">
                    {{ $slot }}
                </div>
            </section>
        </div>
    </div>
</main>
```

---

## 4. KOMPONEN UI REUSABLE & ATOMIK (UI COMPONENT SPECIFICATIONS)

### 4.1 Minimalist Glass Sidebar (`<x-sidebar />`)
Sidebar bertransformasi dari panel abu-abu standar menjadi bilah kaca terpadu dengan navigasi berbasis pill:

- **Active State:** Menggunakan pill putih solid melayang (`bg-white text-slate-900 shadow-md font-bold rounded-xl px-3.5 py-2.5 flex items-center gap-3 transition-all`)
- **Inactive State:** Pill semi-transparan (`text-slate-700 hover:bg-white/30 hover:text-slate-900 rounded-xl px-3.5 py-2.5 flex items-center gap-3 transition-all`)
- **Badge Notifikasi:** Lingkaran kecil bersinar (`bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full`)
- **Search Taruna Cepat:** Input kaca mini dengan ikon kaca pembesar dan autocomplete dropdown

```html
<!-- Contoh Struktur Item Menu Sidebar -->
<ul class="space-y-1">
    <li>
        <a href="{{ route('dashboard') }}" class="group flex items-center justify-between px-3.5 py-2 rounded-xl {{ $active === 'dashboard' ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-700 hover:bg-white/40 hover:text-slate-950 font-medium' }} transition-all duration-200 text-xs">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-house-chimney text-sm {{ $active === 'dashboard' ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>
                <span>Beranda Utama</span>
            </div>
            @if($active === 'dashboard')
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
            @endif
        </a>
    </li>
    <!-- Modul lainnya: Poin, Surat, Apel, Pos Jaga, Barak, dsb -->
</ul>
```

### 4.2 High-End Glass Stat Cards (KPI Metric Cards)
Kartu metrik menggunakan glassmorphism dengan kontras angka yang tinggi, ikon bercahaya (ambient glow icon box), dan badge indikator tren.

```html
<div class="stat-glass-card rounded-2xl bg-white/50 hover:bg-white/70 backdrop-blur-xl border border-white/60 p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl group">
    <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Total Taruna</span>
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm shadow-md group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>
    <div class="flex items-baseline gap-2">
        <span class="text-2xl sm:text-3xl font-black text-slate-900 font-mono tracking-tight">{{ $totalMahasiswa ?? 0 }}</span>
        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-full border border-emerald-200">Aktif</span>
    </div>
    <div class="mt-2 flex items-center gap-1.5 text-[11px] text-slate-500">
        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
        <span>Data terverifikasi pengasuhan</span>
    </div>
</div>
```

### 4.3 Visual Flow Nodes & Interactive Tracking Cards
Sesuai adegan pada `design.mp4` yang memperlihatkan alur kerja terhubung (*Review Sustainability* -> *Green Hills Wind Farm* dengan kurva bezier), modul **Log Pergerakan Taruna / Pos Jaga** dan **Poin Sanksi** dilengkapi tampilan representasi visual node interaktif.

- **Status Node:** Pill status (`Low Risk`, `Dalam Kampus`, `Izin Bermalam`, `Konsinyir`)
- **Card Header:** Foto avatar/lokasi, nama pos, timestamp dinamis
- **Connecting Line:** Garis kurva SVG atau dashed border penghubung riwayat pergerakan dari pos gerbang utama ke barak

```html
<div class="flow-node-card rounded-2xl bg-white/60 backdrop-blur-lg border border-white/70 p-3.5 shadow-md flex items-center gap-3 relative overflow-hidden">
    <div class="w-2 h-full absolute left-0 top-0 bg-emerald-500"></div>
    <div class="w-10 h-10 rounded-xl bg-emerald-100 border border-emerald-300 flex items-center justify-center text-emerald-700 flex-shrink-0">
        <i class="fa-solid fa-shield-halved text-base"></i>
    </div>
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2">
            <span class="px-2 py-0.5 rounded-full bg-emerald-200/80 text-emerald-800 text-[10px] font-bold uppercase tracking-wider">Aman</span>
            <span class="text-[10px] text-slate-500">Pos 1 Utama</span>
        </div>
        <h4 class="text-xs font-bold text-slate-900 truncate mt-0.5">Monitoring Keluar Masuk</h4>
        <p class="text-[11px] text-slate-600">0 Taruna terlambat kembali</p>
    </div>
    <button class="px-3 py-1 rounded-full bg-slate-900 hover:bg-slate-800 text-white text-[10px] font-semibold transition">
        Detail
    </button>
</div>
```

### 4.4 Data Tables & Sleek Glass Grids
Tabel data menggunakan latar transparan berlapis, header frosted glass dengan teks tebal, dan hover efek baris yang halus:

```html
<div class="glass-table-container rounded-2xl bg-white/40 backdrop-blur-xl border border-white/50 overflow-hidden shadow-lg">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/60 backdrop-blur-md border-b border-white/40 text-[11px] font-bold uppercase tracking-wider text-slate-700">
                    <th class="py-3.5 px-4">Taruna</th>
                    <th class="py-3.5 px-4">Kamar / Barak</th>
                    <th class="py-3.5 px-4">Poin Pelanggaran</th>
                    <th class="py-3.5 px-4">Poin Penghargaan</th>
                    <th class="py-3.5 px-4">Status Sanksi</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/30 text-xs">
                <tr class="hover:bg-white/60 transition-colors duration-150">
                    <td class="py-3 px-4 font-semibold text-slate-900">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">A</div>
                            <div>
                                <div class="font-bold text-slate-900">Ahmad Muflih</div>
                                <div class="text-[10px] text-slate-500 font-mono">NIT. 210203001</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-slate-700">Barak Alpha - No. 12</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 font-bold text-[11px]">0 Poin</span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-bold text-[11px]">+15 Poin</span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-100/90 text-emerald-800 font-semibold text-[10px] border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disiplin Baik
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right">
                        <a href="#" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white/70 hover:bg-white text-indigo-700 font-bold text-xs border border-white/60 shadow-sm transition">
                            <span>Periksa</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

### 4.5 Glass Form Controls & Dynamic Inputs
Formulir input mengusung border kaca semi-transparan dengan efek fokus ring bercahaya lembut:

```html
<div class="form-group mb-4">
    <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
        Nama Pelanggaran / Kegiatan
    </label>
    <div class="relative">
        <input type="text" 
               class="w-full px-3.5 py-2.5 rounded-xl bg-white/60 hover:bg-white/80 focus:bg-white backdrop-blur-md border border-white/60 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 text-xs font-medium text-slate-800 placeholder-slate-400 transition-all outline-none"
               placeholder="Masukkan rincian kegiatan...">
    </div>
</div>
```

---

## 5. BLUEPRINT TRANSFORMASI PER HALAMAN (PAGE-BY-PAGE MAPPING)

Setiap halaman yang ada di `resources/views` diintegrasikan ke dalam arsitektur desain baru dengan mempertahankan seluruh form, aksi controller, dan variabel Blade:

### 5.1 Landing Page (`resources/views/welcome.blade.php`)
- **Konsep:** Gerbang Utama Publik dengan Hero Editorial, Floating Omnibar untuk Cek Status Taruna Publik/Orang Tua, Glass Feature Showcase (Poin, Apel, Pos Jaga, Keluhan Barak).
- **Elemen:**
  1. Top Floating Island Capsule (Logo PPI Curug, Tombol Masuk Portal Pengasuhan).
  2. Hero Headline Serif: *"Politeknik Penerbangan Indonesia Curug — Pusat Pembentukan Karakter & Disiplin Taruna Transportasi Udara"*.
  3. Floating Status Checker Omnibar (Pencarian cepat status izin & kepulangan taruna oleh wali/taruna).
  4. Showcase Cards: 4 pilar pengasuhan dalam balutan kartu kaca melayang dengan hover lift.

### 5.2 Main Dashboard (`resources/views/dashboard.blade.php`)
- **Konsep:** Central Flight Cockpit Command.
- **Elemen:**
  1. Top Banner Glass Navy/Royal Blue: Salam pembuka pengasuh/admin dengan avatar taruna/petugas berbingkai kaca.
  2. 5 KPI Stat Cards: Total Taruna, Pelanggaran Aktif Hari Ini, Izin Keluar/IB Berjalan, Keluhan Barak Terbuka, Taruna Konsinyir.
  3. Quick Pos Jaga Monitor: Live card feed status gerbang pos jaga dengan indikator lampu hijau/merah.
  4. Dual Column Workspace:
     - Kiri: Agenda Apel & Jadwal Kegiatan Pengasuhan Hari Ini.
     - Kanan: Feed Log Pergerakan Terkini & Pelanggaran Terbaru dengan aksi cepat tindak lanjut.

### 5.3 Modul Poin & Sanksi Taruna (`resources/views/poin/*`)
- **Sub-halaman:** `index.blade.php`, `create.blade.php`, `taruna.blade.php`, `rekap.blade.php`, `edit.blade.php`.
- **Elemen:**
  1. Header Banner: Scoreboard Dual Card (Total Poin Pelanggaran Merah Kaca vs Total Poin Penghargaan Hijau Kaca).
  2. Dynamic Sanksi Severity Indicator: Visual badge bertingkat (Peringatan Lisan -> Peringatan Tertulis -> Sidang Disiplin -> Sanksi Berat).
  3. Filter Bar: Pill tombol kategori pelanggaran (Kerapian, Perizinan, Tata Krama, Kedisiplinan Barak).
  4. Form Input Pelanggaran: Modal/Formulir kaca dengan dropdown taruna cepat, upload bukti foto, dan kalkulasi otomatis akumulasi poin.

### 5.4 Modul Log Pergerakan & Pos Jaga (`resources/views/log-pergerakan/*`)
- **Sub-halaman:** `index.blade.php`, `create.blade.php`, `scan.blade.php`.
- **Elemen:**
  1. Live Gate Monitor: Visual flow card per pos (Pos 1 Gerbang Utama, Pos 2 Asrama, Pos 3 Hangar).
  2. Scanner Quick Bar: Input barcode/QR NIT taruna dengan audio-visual feedback glow hijau/merah.
  3. Interactive Movement Timeline: Garis alur bezier menghubungkan status check-out izin dengan check-in kembali ke kampus.

### 5.5 Modul Apel & Presensi Taruna (`resources/views/apel/*`)
- **Sub-halaman:** `index.blade.php`, `create.blade.php`, `detail.blade.php`, `rekap.blade.php`.
- **Elemen:**
  1. Apel Quick Counter Pills: Hadir, Izin Sakit, Dinas Khusus, Terlambat, Tanpa Keterangan.
  2. Roster Grid: Tampilan kartu barak dengan switch toggle kehadiran sekali klik (glass toggle switch).
  3. Export Pill Action: Tombol unduh berita acara rekap apel format PDF/Excel.

### 5.6 Modul Konsinyir & Izin Keluar Asrama (`resources/views/konsinyir/*`)
- **Sub-halaman:** `index.blade.php`, `create.blade.php`, `approval.blade.php`.
- **Elemen:**
  1. Status Ribbon Card: Indikator masa konsinyir kampus dengan countdown jam berlatar kaca gelap.
  2. Workflow Approval Queue: Kartu pengajuan izin bermalam (IB) dengan tombol cepat Setujui/Tolak bertingkat pengasuh.

### 5.7 Modul Keluhan Barak (`resources/views/keluhan-barak/*`)
- **Sub-halaman:** `index.blade.php`, `create.blade.php`, `show.blade.php`.
- **Elemen:**
  1. Kanban Glass Grid: Kolom Status Keluhan (`Menunggu Peninjauan`, `Sedang Diperbaiki`, `Selesai`).
  2. Photo Attachment Preview: Galeri foto fasilitas barak yang dilaporkan dengan lightbox modal kaca.

### 5.8 Modul Surat & Perizinan (`resources/views/surat/*`)
- **Sub-halaman:** `index.blade.php`, `create.blade.php`, `show.blade.php`.
- **Elemen:**
  1. Digital Document Card: Kartu surat dengan cap/watermark dinamis status persetujuan Kepala Pengasuhan.
  2. Tracking Stepper: Visual tahapan disposisi surat izin.

### 5.9 Modul Mahasiswa / Taruna (`resources/views/mahasiswa/*`)
- **Sub-halaman:** `index.blade.php`, `show.blade.php`, `edit.blade.php`, `create.blade.php`.
- **Elemen:**
  1. Taruna Profile Cockpit: Header profil dengan foto resmi taruna, badge korps, NIT, program studi, status barak, dan radar chart kedisiplinan.
  2. Tabbed Glass Navigation: Tab Riwayat Poin, Riwayat Perizinan, Catatan Kesehatan, Prestasi & Penghargaan.

### 5.10 Modul Berita, Acara, Jadwal, Activity Log, Users, Profile & Setting
- Transformasi seluruh tabel CRUD, modal konfirmasi hapus, card berita, dan form pengaturan profil menjadi komponen glassmorphism yang seragam sesuai design tokens di Bagian 2.

---

## 6. ANIMASI, TRANSISI & MICRO-INTERACTIONS

Setiap interaksi pengguna diberikan umpan balik visual yang halus dan responsif:

1. **Hover Lift & Shimmer (Kartu Kaca):**
   ```css
   .glass-interactive-card {
       transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), 
                   box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1),
                   background-color 0.25s ease;
   }
   .glass-interactive-card:hover {
       transform: translateY(-3px);
       box-shadow: 0 16px 36px -8px rgba(0, 0, 0, 0.18), 0 0 0 1px rgba(255, 255, 255, 0.6);
   }
   ```
2. **Pill Scale Micro-interaction (Tombol & Menu):**
   - Active click: `active:scale-95 transition-transform duration-100`
3. **Pulsing Status Badges:**
   - Indikator live status pos jaga menggunakan `animate-ping` / `animate-pulse` dengan warna cerah (Emerald `#10b981`, Amber `#f59e0b`, Rose `#f43f5e`).
4. **Smooth Backdrop Transition:**
   - Pembukaan modal dan dropdown menggunakan transisi `ease-out duration-200 opacity-0 scale-95 -> opacity-100 scale-100`.

---

## 7. PANDUAN TEKNIS IMPLEMENTASI BAGI AI AGENT (CODING RULES)

Bagi AI Agentic Coder yang bertugas mengeksekusi perubahan kode pada proyek ini, ikuti langkah-langkah standardisasi berikut:

### 7.1 Konfigurasi Tailwind CSS (`tailwind.config.js`)
Pastikan font family `serif` mendukung editorial display dan `sans` mendukung Inter/Plus Jakarta Sans:

```javascript
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                serif: ['Instrument Serif', 'Playfair Display', 'Merriweather', ...defaultTheme.fontFamily.serif],
                mono: ['JetBrains Mono', 'Fira Code', ...defaultTheme.fontFamily.mono],
            },
            boxShadow: {
                'glass-sm': '0 4px 16px 0 rgba(0, 0, 0, 0.08)',
                'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.15)',
                'glass-lg': '0 16px 48px 0 rgba(0, 0, 0, 0.22)',
                'glass-pill': '0 6px 20px -2px rgba(0, 0, 0, 0.2)',
            },
            backdropBlur: {
                'xs': '2px',
                '2xl': '24px',
                '3xl': '32px',
            }
        },
    },
    plugins: [forms],
};
```

### 7.2 Core CSS Extensions (`resources/css/app.css`)
Tambahkan utility class untuk master spatial container, glass highlights, dan scrollbar tipis transparan:

```css
/* Custom Glassmorphism Specular Highlight */
.specular-border {
    border-top: 1px solid rgba(255, 255, 255, 0.75);
    border-left: 1px solid rgba(255, 255, 255, 0.55);
    border-right: 1px solid rgba(255, 255, 255, 0.35);
    border-bottom: 1px solid rgba(255, 255, 255, 0.25);
}

/* Custom Thin Scrollbar */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}
::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.4);
    border-radius: 9999px;
}
::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.6);
}
```

### 7.3 Standardisasi Layout Blade Template
Pastikan `dashboardLayout.blade.php` menyertakan link font Google Display Serif (`Instrument Serif` & `Plus Jakarta Sans`):

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
```

---

## 8. CHECKLIST VERIFIKASI KUALITAS (AGENTIC QUALITY CHECKLIST)

Sebelum menyelesaikan pekerjaan perombakan kode pada setiap view:
- [ ] **Background Check:** Pastikan `BG.png` tetap tampil bersih sebagai latar belakang global tanpa tertutup background putih solid.
- [ ] **Contrast Check:** Semua teks di atas kaca transparan harus memiliki kontras tinggi (`text-slate-900` atau `text-slate-800` untuk panel terang, `text-white` untuk capsule gelap).
- [ ] **Functionality Check:** Form submission, CSRF token, modal delete trigger, route parameters, dan pagination Laravel berfungsi 100%.
- [ ] **Mobile Responsiveness:** Pada layar kecil (<768px), sidebar bertransisi menjadi drawer geser atau floating bottom/top nav tanpa overflow horizontal yang merusak layout.
- [ ] **Video Design Match:** Keberadaan Floating Island Capsule Dock, Pill Filter Badges, Editorial Display Headlines, Omnibar Search, dan Translucent Workspace Window telah terwujud secara presisi.

---
*Dokumen ini menjadi patokan resmi dan mutlak untuk seluruh siklus perombakan frontend pada repository PPI Curug.*
