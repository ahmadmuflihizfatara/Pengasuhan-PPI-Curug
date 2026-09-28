<x-app-layout>
{{-- Form memakai gaya yang sama dengan form Log Gerbang, Surat & Reward --}}
<x-form-glass-style />
<style>
    [x-cloak] { display: none !important; }

    /* Alur kerja */
    .pn-flow { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .pn-flow__langkah { display: flex; align-items: center; gap: var(--space-2) var(--space-3); flex-wrap: wrap; }
    .pn-step { display: inline-flex; align-items: center; gap: var(--space-2); font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-600); }
    .pn-step__no { width: 22px; height: 22px; flex-shrink: 0; border-radius: var(--radius-pill); display: grid; place-items: center; font-size: 11px; font-weight: 800; background: var(--glass-subtle); border: 1px solid var(--border-glass-glow); color: var(--ink-600); }
    .pn-step--aktif { color: var(--ink-900); }
    .pn-step--aktif .pn-step__no { background: var(--accent); border-color: transparent; color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .pn-flow__panah { font-size: 10px; color: var(--ink-400); }
    @media (max-width: 767px) { .pn-flow__langkah { flex-direction: column; align-items: flex-start; } .pn-flow__panah { display: none; } }

    /* Tata letak */
    .pn-grid { display: grid; grid-template-columns: 340px minmax(0, 1fr); gap: var(--space-4); align-items: start; }
    @media (max-width: 1023px) { .pn-grid { grid-template-columns: 1fr; } }
    .pn-kolom { display: flex; flex-direction: column; gap: var(--space-4); min-width: 0; }

    /* Pilih taruna */
    .pn-cari { position: relative; margin-bottom: var(--space-3); }
    .pn-cari i { position: absolute; left: var(--space-3); top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--ink-500); pointer-events: none; }
    .pn-cari .form-control { padding-left: 34px; }
    .pn-daftar { max-height: 320px; overflow-y: auto; display: flex; flex-direction: column; gap: var(--space-1-5); padding-right: 2px; }
    .mhs-item-opt { display: flex; align-items: center; gap: var(--space-2-5); padding: var(--space-2) var(--space-2-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); color: inherit; text-decoration: none; transition: background-color .15s, border-color .15s; }
    .mhs-item-opt:hover { background: var(--glass-solid); color: inherit; }
    .mhs-item-opt:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .mhs-item-opt.selected { background: var(--accent-tint); border-color: var(--accent); }
    .mhs-item-opt .ds-avatar { flex-shrink: 0; }
    .mhs-opt-name { font-size: 12px; line-height: 16px; font-weight: 800; color: var(--ink-900); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .mhs-opt-meta { font-size: 11px; line-height: 14px; font-weight: 600; color: var(--ink-600); }

    /* Profil & skor */
    .pn-profil { text-align: center; padding-bottom: var(--space-4); margin-bottom: var(--space-4); border-bottom: 1px solid var(--border-glass-subtle); }
    .pn-profil__ava { width: 60px; height: 60px; margin: 0 auto var(--space-2-5); border-radius: var(--radius-lg); display: grid; place-items: center; font-size: 20px; font-weight: 900; color: var(--ink-on-dark); background: linear-gradient(135deg, #6366f1, var(--accent)); box-shadow: var(--shadow-glass); }
    .pn-profil__nama { font-size: 15px; line-height: 20px; font-weight: 900; color: var(--ink-900); }
    .pn-profil__meta { margin-top: 2px; font-size: 11px; line-height: 16px; font-weight: 600; color: var(--ink-600); }
    .pn-profil__total { margin-top: var(--space-2-5); display: inline-flex; align-items: baseline; gap: var(--space-1-5); padding: var(--space-1-5) var(--space-3); border-radius: var(--radius-pill); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .pn-profil__total b { font-family: var(--font-mono); font-size: 18px; font-weight: 900; color: var(--ink-900); }
    .pn-profil__total span { font-size: 11px; font-weight: 600; color: var(--ink-600); }
    .pn-skor { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-2-5); margin-bottom: var(--space-3); }
    .pn-skor__item { padding: var(--space-3); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .pn-skor__label { display: flex; align-items: center; gap: var(--space-1-5); font-size: 10px; line-height: 14px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .pn-skor__nilai { margin-top: var(--space-1); font-family: var(--font-mono); font-size: 24px; line-height: 30px; font-weight: 900; letter-spacing: -0.02em; }
    .pn-sanksi { display: flex; align-items: flex-start; gap: var(--space-3); padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .pn-sanksi .ds-stat__icon { flex-shrink: 0; }
    .pn-sanksi__judul { font-size: 14px; line-height: 20px; font-weight: 900; color: var(--ink-900); }
    .pn-sanksi__desc { margin: 2px 0 0; font-size: 11px; line-height: 16px; font-weight: 500; color: var(--ink-700); }
    .pn-rentang { margin-top: var(--space-4); }
    .pn-rentang__wrap { position: relative; padding-top: 26px; }
    .pn-rentang__track { display: flex; gap: 3px; height: 14px; padding: 2px; border-radius: var(--radius-pill); background: var(--glass-card); border: 1px solid var(--border-glass-glow); }
    .pn-rentang__seg { height: 100%; border-radius: var(--radius-pill); opacity: .8; }
    .pn-rentang__marker { position: absolute; top: 0; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; }
    .pn-rentang__marker span { padding: 1px 8px; border-radius: var(--radius-pill); background: var(--glass-dark); color: var(--ink-on-dark); font-family: var(--font-mono); font-size: 10px; line-height: 16px; font-weight: 700; white-space: nowrap; }
    .pn-rentang__marker i { width: 0; height: 0; border: 4px solid transparent; border-top-color: var(--glass-dark); border-bottom: 0; }
    .pn-rentang__legend { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-1) var(--space-3); margin-top: var(--space-2-5); font-size: 10px; line-height: 14px; font-weight: 700; color: var(--ink-700); }
    .pn-rentang__legend span { display: flex; align-items: center; gap: var(--space-1-5); }
    .pn-rentang__legend i { width: 8px; height: 8px; border-radius: 2px; flex-shrink: 0; }

    /* Toggle kategori usulan — warna lembut sesuai varian (danger / success) */
    .usulan-toggle { display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-2); margin-bottom: var(--space-5); }
    .toggle-btn {
        display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3) var(--space-3-5);
        border: 1.5px solid var(--border-glass-glow); border-radius: var(--radius-md); background: var(--glass-card);
        font-family: inherit; text-align: left; color: var(--ink-700); cursor: pointer;
        transition: background-color .15s, border-color .15s, box-shadow .15s, color .15s;
    }
    .toggle-btn:hover { background: var(--glass-solid); }
    .toggle-btn:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .toggle-btn__ikon { width: 36px; height: 36px; flex-shrink: 0; border-radius: var(--radius-sm); display: grid; place-items: center; font-size: 14px; background: var(--glass-subtle); color: var(--ink-500); transition: background-color .15s, color .15s; }
    .toggle-btn__judul { display: block; font-size: 13px; line-height: 18px; font-weight: 800; }
    .toggle-btn__ket { display: block; font-size: 11px; line-height: 14px; font-weight: 600; color: var(--ink-600); }
    .toggle-btn.active-pelanggaran { background: var(--danger-tint); border-color: var(--danger-border); color: var(--danger-ink); box-shadow: 0 0 0 3px color-mix(in srgb, var(--danger) 12%, transparent); }
    .toggle-btn.active-pelanggaran .toggle-btn__ikon { background: linear-gradient(135deg, #f43f5e, var(--danger)); color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .toggle-btn.active-penghargaan { background: var(--success-tint); border-color: var(--success-border); color: var(--success-ink); box-shadow: 0 0 0 3px color-mix(in srgb, var(--success) 12%, transparent); }
    .toggle-btn.active-penghargaan .toggle-btn__ikon { background: linear-gradient(135deg, #10b981, var(--success)); color: var(--ink-on-dark); box-shadow: var(--shadow-glass-sm); }
    .toggle-btn[disabled] { cursor: default; grid-column: 1 / -1; }
    @media (max-width: 480px) { .toggle-btn__ket { display: none; } }

    /* Tingkat pelanggaran — tiap kartu diberi warna tingkatnya, kartu terpilih lebih pekat */
    .tingkat-pelanggaran-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-2-5); margin-bottom: var(--space-2); }
    .tingkat-card {
        position: relative; padding: var(--space-3) var(--space-3); border-radius: var(--radius-md); cursor: pointer;
        background: color-mix(in srgb, var(--tk-tint) 45%, var(--glass-card));
        border: 1.5px solid color-mix(in srgb, var(--tk) 28%, transparent);
        transition: background-color .15s, border-color .15s, box-shadow .15s, transform .15s;
    }
    .tingkat-card:hover { background: var(--tk-tint); transform: translateY(-1px); }
    .tingkat-card.tier-ringan { --tk: var(--warning); --tk-ink: var(--warning-ink); --tk-tint: var(--warning-tint); }
    .tingkat-card.tier-sedang { --tk: #ea580c;        --tk-ink: #9a3412;          --tk-tint: #ffedd5; }
    .tingkat-card.tier-berat  { --tk: var(--danger);  --tk-ink: var(--danger-ink);  --tk-tint: var(--danger-tint); }
    .tingkat-card.active-ringan, .tingkat-card.active-sedang, .tingkat-card.active-berat {
        background: var(--tk-tint); border-color: var(--tk);
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--tk) 18%, transparent), var(--shadow-glass-sm);
    }
    /* Tanda centang pada kartu terpilih */
    .tingkat-card.active-ringan::after, .tingkat-card.active-sedang::after, .tingkat-card.active-berat::after {
        content: '\f00c'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; top: var(--space-2); right: var(--space-2); width: 18px; height: 18px; border-radius: 50%;
        display: grid; place-items: center; font-size: 9px; background: var(--tk); color: var(--ink-on-dark);
    }
    .tingkat-name { font-size: 11px; line-height: 14px; font-weight: 800; letter-spacing: .05em; text-transform: uppercase; color: var(--tk-ink); }
    .tingkat-poin { margin-top: var(--space-1); font-family: var(--font-mono); font-size: 20px; line-height: 24px; font-weight: 900; letter-spacing: -0.02em; color: var(--tk-ink); }
    .tingkat-poin small { font-family: var(--font-sans); font-size: 11px; font-weight: 700; letter-spacing: 0; }
    .tingkat-ket { margin-top: 2px; font-size: 10px; line-height: 14px; font-weight: 600; color: var(--ink-600); }
    @media (max-width: 480px) { .tingkat-ket { display: none; } .tingkat-poin { font-size: 17px; } }
    .pn-bantuan { display: block; margin-bottom: var(--space-4); font-size: 11px; line-height: 16px; font-weight: 500; color: var(--ink-600); }
    .pn-bantuan i { color: var(--accent); margin-right: var(--space-1); }
    .pn-mode { display: flex; align-items: flex-start; gap: var(--space-2); margin: var(--space-1) 0 var(--space-4); padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); font-size: 12px; line-height: 18px; font-weight: 500; color: var(--ink-700); }
    .pn-mode i { margin-top: 3px; color: var(--accent); }
    .pn-mode strong { color: var(--ink-900); }
    #displayNilaiPenghargaan { font-family: var(--font-mono); font-size: 14px; font-weight: 800; color: var(--success-ink); }

    /* Riwayat */
    .rw-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: var(--space-3); }
    .rw-tabs { display: inline-flex; gap: var(--space-1); padding: var(--space-1); border-radius: var(--radius-pill); background: var(--glass-subtle); border: 1px solid var(--border-glass); }
    .rw-tab { display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-2) var(--space-3-5); border: 1px solid transparent; border-radius: var(--radius-pill); background: transparent; cursor: pointer; font-family: inherit; font-size: 12px; line-height: 16px; font-weight: 700; color: var(--ink-700); transition: background-color .15s, color .15s; }
    .rw-tab:hover { background: var(--glass-card); color: var(--ink-900); }
    .rw-tab:focus-visible { outline: none; box-shadow: var(--shadow-focus); }
    .rw-tab--aktif, .rw-tab--aktif:hover { background: var(--glass-solid); border-color: var(--border-glass-glow); color: var(--ink-900); box-shadow: var(--shadow-glass-sm); }
    @media (max-width: 480px) { .rw-tabs { width: 100%; } .rw-tab { flex: 1; justify-content: center; padding: var(--space-2); } .rw-tab > i { display: none; } }
    .rw-table td { vertical-align: top; }
    .ds-table td.rw-poin { font-family: var(--font-mono); font-size: 14px; font-weight: 800; white-space: nowrap; }
    .pn-tunggu { border-color: var(--warning-border); }
    .pn-aksi-sel { display: inline-flex; gap: var(--space-1); }

    /* Modal validasi admin — pola ds-modal + rincian usulan */
    .pn-vmodal { max-width: 460px; }
    .pn-vmodal .ds-modal__icon--setujui { background: var(--success-tint); color: var(--success); }
    .pn-vmodal__rinci { display: grid; gap: var(--space-2); margin: var(--space-3) 0 var(--space-4); padding: var(--space-3) var(--space-3-5); border-radius: var(--radius-md); background: var(--glass-card); border: 1px solid var(--border-glass-glow); text-align: left; }
    .pn-vmodal__rinci div { display: grid; grid-template-columns: 78px minmax(0, 1fr); gap: var(--space-2); }
    .pn-vmodal__rinci dt { font-size: 10px; line-height: 18px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-600); }
    .pn-vmodal__rinci dd { margin: 0; font-size: 12px; line-height: 18px; font-weight: 700; color: var(--ink-900); overflow-wrap: anywhere; }
    .pn-vmodal__poin { font-family: var(--font-mono); font-weight: 900 !important; }
    .pn-vmodal .form-group { margin-bottom: var(--space-5); text-align: left; }
    .pn-vmodal textarea.form-control { min-height: 64px; resize: vertical; }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

@php
    $u = auth()->user();
    $modeLabel = $u->canManageSystem() ? 'Admin Pusbangkar (Validator)' : ($u->isPolisiTaruna() ? 'Polisi Taruna (Pengusul Pelanggaran)' : 'Pengasuh (Pengusul)');
    $varianTingkat = fn ($t) => match (strtolower((string) $t)) { 'berat' => 'danger', 'sedang', 'ringan' => 'warning', default => '' };
    $angkaPoin = fn ($n) => rtrim(rtrim(number_format((float) $n, 2, ',', '.'), '0'), ',');
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        {{-- Header — sama dengan header tab lain --}}
        <x-page-banner title="Pengusulan Poin & Sanksi Taruna" icon="fa-scale-balanced"
            subtitle="Sesuai Peraturan Tata Tertib Taruna (PTTT) PPI Curug · Validasi Admin Pusbangkar" />

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if($errors->any())
        <x-glass-alert type="danger" title="Usulan poin belum tersimpan">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </x-glass-alert>
        @endif

        {{-- Alur kerja + mode akun --}}
        <div class="ds-card pn-flow mb-4">
            <div class="pn-flow__langkah">
                <span class="pn-step {{ $selectedStudent ? 'pn-step--aktif' : '' }}"><span class="pn-step__no">1</span> Pilih taruna</span>
                <i class="fa-solid fa-chevron-right pn-flow__panah"></i>
                <span class="pn-step {{ $selectedStudent ? 'pn-step--aktif' : '' }}"><span class="pn-step__no">2</span> Pilih usulan (penghargaan / pelanggaran)</span>
                <i class="fa-solid fa-chevron-right pn-flow__panah"></i>
                <span class="pn-step"><span class="pn-step__no">3</span> Nilai menyesuaikan otomatis</span>
                <i class="fa-solid fa-chevron-right pn-flow__panah"></i>
                <span class="pn-step"><span class="pn-step__no">4</span> Validasi admin &amp; akumulasi SP</span>
            </div>
            <span class="ds-badge ds-badge--accent"><i class="fa-solid fa-user-shield"></i> Mode: {{ $modeLabel }}</span>
        </div>

        {{-- Usulan menunggu validasi --}}
        @if($allPendingValidation->count() > 0)
        <div class="ds-card pn-tunggu mb-4">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-clipboard-check ds-icon"></i> Usulan Poin Menunggu Validasi</h3>
                    <p class="ds-card__desc">Perlu divalidasi Admin Pusbangkar agar masuk ke akumulasi taruna</p>
                </div>
                <span class="ds-badge ds-badge--warning">{{ $allPendingValidation->count() }} usulan</span>
            </div>
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table rw-table">
                        <thead>
                            <tr>
                                <th>Taruna</th>
                                <th data-filter>Jenis</th>
                                <th>Kegiatan / Temuan</th>
                                <th class="ds-right">Poin</th>
                                <th data-filter>Diajukan Oleh</th>
                                <th>Tanggal</th>
                                <th data-no-sort data-no-filter>Bukti</th>
                                <th class="ds-right" data-no-sort data-no-filter>{{ $u->canManageSystem() ? 'Aksi' : 'Status' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allPendingValidation as $item)
                            @php $pel = $item->kategori === 'pelanggaran'; @endphp
                            <tr>
                                <td>
                                    <div class="tbl-title">{{ $item->nama_mahasiswa }}</div>
                                    <div class="tbl-sub">{{ $item->npm }} · {{ $item->kelas }}</div>
                                </td>
                                <td><span class="ds-badge ds-badge--{{ $pel ? 'danger' : 'success' }}">{{ $pel ? 'Pelanggaran' : 'Penghargaan' }} · {{ ucfirst($item->tingkat ?? ($pel ? 'PTTT' : 'Prestasi')) }}</span></td>
                                <td>
                                    <div class="tbl-title">{{ $item->kegiatan }}</div>
                                    @if($item->keterangan)<div class="tbl-sub">{{ Str::limit($item->keterangan, 60) }}</div>@endif
                                </td>
                                <td class="ds-right rw-poin" style="color:var(--{{ $pel ? 'danger' : 'success' }}-ink)" data-sort="{{ (float) $item->nilai }}">{{ $pel ? '−' : '+' }}{{ $angkaPoin($item->nilai) }}</td>
                                <td>
                                    <div class="tbl-title">{{ $item->pengasuh }}</div>
                                    <div class="tbl-sub">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="tbl-date" data-sort="{{ $item->tanggal?->format('Y-m-d') }}">{{ $item->tanggal ? $item->tanggal->locale('id')->isoFormat('D MMM Y') : '—' }}</td>
                                <td>
                                    @if($item->foto_bukti)
                                    <a href="{{ Storage::url($item->foto_bukti) }}" target="_blank" rel="noopener" class="ds-btn ds-btn--xs"><i class="fa-solid fa-image"></i> Lihat</a>
                                    @else
                                    <span class="tbl-sub">—</span>
                                    @endif
                                </td>
                                <td class="ds-right">
                                    @if($u->canManageSystem())
                                    @php
                                        $dataValidasi = [
                                            'url'     => route('poin.validasi', $item->id),
                                            'taruna'  => $item->nama_mahasiswa . ' · ' . $item->npm,
                                            'usulan'  => ($pel ? 'Pelanggaran' : 'Penghargaan') . ' · ' . $item->kegiatan,
                                            'poin'    => ($pel ? '−' : '+') . $angkaPoin($item->nilai) . ' poin',
                                            'pel'     => $pel,
                                            'pengaju' => $item->pengasuh ?: '—',
                                            'bukti'   => $item->foto_bukti ? Storage::url($item->foto_bukti) : null,
                                        ];
                                    @endphp
                                    <div class="pn-aksi-sel">
                                        <button type="button" class="ds-btn ds-btn--sm ds-btn--success" data-validasi="{{ json_encode($dataValidasi) }}" onclick="bukaValidasi(this, 'setujui')"><i class="fa-solid fa-check"></i> Validasi</button>
                                        <button type="button" class="ds-btn ds-btn--icon ds-btn--danger" title="Tolak" aria-label="Tolak usulan {{ $item->nama_mahasiswa }}" data-validasi="{{ json_encode($dataValidasi) }}" onclick="bukaValidasi(this, 'tolak')"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                    @else
                                    <span class="ds-badge ds-badge--warning"><i class="fa-solid fa-clock"></i> Menunggu admin</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="pn-grid">
            {{-- ── KOLOM KIRI: PILIH TARUNA & STATUS ── --}}
            <div class="pn-kolom">
                <div class="ds-card">
                    <div class="ds-card__head">
                        <h3 class="ds-card__title"><i class="fa-solid fa-user-graduate ds-icon"></i> 1. Pilih Taruna</h3>
                        <p class="ds-card__desc">Ketik nama, NPM, atau kelas lalu pilih dari daftar</p>
                    </div>
                    <div class="pn-cari">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="mhsSearchInput" class="form-control" placeholder="Cari nama atau NPM..." oninput="filterMhsList()" aria-label="Cari taruna">
                    </div>
                    <div class="pn-daftar" id="mhsDropdownList">
                        @foreach($flatMahasiswa as $mhs)
                        <a href="{{ route('poin.index', ['npm' => $mhs->npm]) }}"
                           class="mhs-item-opt {{ $selectedNpm === $mhs->npm ? 'selected' : '' }}"
                           data-search="{{ strtolower($mhs->nama . ' ' . $mhs->npm . ' ' . $mhs->kelas) }}"
                           @if($selectedNpm === $mhs->npm) aria-current="true" @endif>
                            <span class="ds-avatar">{{ strtoupper(substr($mhs->nickname ?? $mhs->nama, 0, 2)) }}</span>
                            <span style="flex:1; min-width:0;">
                                <span class="mhs-opt-name d-block">{{ $mhs->nama }}</span>
                                <span class="mhs-opt-meta d-block">{{ $mhs->npm }} · {{ $mhs->kelas }}</span>
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>

                @if($selectedStudent)
                @php
                    $sanksiVarian = match ($statusSanksi['level']) { 'aman' => 'success', 'sp1', 'sp2' => 'warning', default => 'danger' };
                    // Garis rentang status (skala −60 … 90) dari batas tingkat di model
                    $skalaMin = -60; $skalaMaks = 90; $skala = $skalaMaks - $skalaMin;
                    $warnaTingkat = ['sp3' => 'var(--danger)', 'sp2' => '#ea580c', 'sp1' => '#f59e0b', 'aman' => 'var(--success)'];
                    $segmen = collect(\App\Models\PoinMahasiswa::TINGKAT_SANKSI)->map(fn ($t, $k) => [
                        'lebar' => ((($t['atas'] ?? $skalaMaks) - ($t['bawah'] === null ? $skalaMin : $t['bawah'] - 1)) / $skala) * 100,
                        'warna' => $warnaTingkat[$k],
                        'label' => $t['bawah'] === null ? 'SP 3 (≤ '.$t['atas'].')' : ($t['atas'] === null ? 'Aman (≥ '.$t['bawah'].')' : strtoupper(substr($k, 0, 2)).' '.substr($k, 2).' ('.$t['bawah'].' – '.$t['atas'].')'),
                    ]);
                    $posisi = (max($skalaMin, min($skalaMaks, $poinTotal)) - $skalaMin) / $skala * 100;
                @endphp
                <div class="ds-card">
                    <div class="pn-profil">
                        <div class="pn-profil__ava">{{ strtoupper(substr($selectedStudent->nickname ?? $selectedStudent->nama, 0, 2)) }}</div>
                        <div class="pn-profil__nama">{{ $selectedStudent->nama }}</div>
                        <div class="pn-profil__meta">NPM {{ $selectedStudent->npm }} · Kelas {{ $selectedStudent->kelas }}</div>
                        <div class="pn-profil__total"><b>{{ (float) $poinTotal }}</b><span>poin total</span></div>
                        <div class="pn-profil__meta">Awal {{ \App\Models\PoinMahasiswa::POIN_AWAL }} + penghargaan − pelanggaran</div>
                    </div>

                    <div class="pn-skor">
                        <div class="pn-skor__item">
                            <span class="pn-skor__label"><i class="fa-solid fa-triangle-exclamation" style="color:var(--danger-ink)"></i> Pelanggaran</span>
                            <div class="pn-skor__nilai" style="color:var(--danger-ink)">−{{ $angkaPoin($totalPelanggaran) }}</div>
                        </div>
                        <div class="pn-skor__item">
                            <span class="pn-skor__label"><i class="fa-solid fa-trophy" style="color:var(--success-ink)"></i> Penghargaan</span>
                            <div class="pn-skor__nilai" style="color:var(--success-ink)">+{{ $angkaPoin($totalPenghargaan) }}</div>
                        </div>
                    </div>

                    <div class="pn-sanksi">
                        <span class="ds-stat__icon ds-stat__icon--{{ $sanksiVarian }}"><i class="{{ $statusSanksi['icon'] }}"></i></span>
                        <div>
                            <div class="pn-sanksi__judul">{{ $statusSanksi['status'] }}</div>
                            <p class="pn-sanksi__desc">{{ $statusSanksi['desc'] }}</p>
                        </div>
                    </div>

                    <div class="pn-rentang" aria-label="Posisi poin total pada rentang status kedisiplinan">
                        <div class="pn-rentang__wrap">
                            <div class="pn-rentang__marker" style="left: clamp(24px, {{ $posisi }}%, calc(100% - 24px))"><span>{{ (float) $poinTotal }}</span><i></i></div>
                            <div class="pn-rentang__track">
                                @foreach($segmen as $sg)
                                <span class="pn-rentang__seg" style="flex-basis: {{ $sg['lebar'] }}%; background: {{ $sg['warna'] }};" title="{{ $sg['label'] }}"></span>
                                @endforeach
                            </div>
                        </div>
                        <div class="pn-rentang__legend">@foreach($segmen->reverse() as $sg)<span><i style="background: {{ $sg['warna'] }}"></i>{{ $sg['label'] }}</span>@endforeach</div>
                    </div>
                </div>
                @endif
            </div>

            {{-- ── KOLOM KANAN: FORM USULAN & RIWAYAT ── --}}
            <div class="pn-kolom">
                @if($selectedStudent)
                <div class="form-card">
                    <div class="form-section-title">
                        <span><i class="fa-solid fa-circle-plus me-2" style="color:var(--accent)"></i> 2. Form Pengusulan Poin</span>
                        <span class="ds-badge ds-badge--accent"><i class="fa-solid fa-user"></i> {{ $selectedStudent->nama }}</span>
                    </div>

                    <form action="{{ route('poin.store') }}" method="POST" enctype="multipart/form-data" id="formUsulPoin">
                        @csrf
                        <input type="hidden" name="npm" value="{{ $selectedStudent->npm }}">
                        <input type="hidden" name="kategori" id="inputKategoriPoin" value="pelanggaran">
                        <input type="hidden" name="tingkat" id="inputTingkatPoin" value="ringan">
                        <input type="hidden" name="nilai" id="inputNilaiPoin" value="5">

                        {{-- Polisi Taruna hanya berwenang mengajukan pelanggaran, jadi toggle dikunci --}}
                        @unless($u->isPolisiTaruna())
                        <span class="form-label">Jenis Usulan <span class="req">*</span></span>
                        <div class="usulan-toggle" role="group" aria-label="Jenis usulan">
                            <button type="button" class="toggle-btn active-pelanggaran" id="btnPilihPelanggaran" onclick="switchKategori('pelanggaran')">
                                <span class="toggle-btn__ikon"><i class="fa-solid fa-ban"></i></span>
                                <span><span class="toggle-btn__judul">Pelanggaran</span><span class="toggle-btn__ket">Mengurangi poin total</span></span>
                            </button>
                            <button type="button" class="toggle-btn" id="btnPilihPenghargaan" onclick="switchKategori('prestasi')">
                                <span class="toggle-btn__ikon"><i class="fa-solid fa-trophy"></i></span>
                                <span><span class="toggle-btn__judul">Penghargaan</span><span class="toggle-btn__ket">Menambah poin total</span></span>
                            </button>
                        </div>
                        @else
                        <span class="form-label">Jenis Usulan</span>
                        <div class="usulan-toggle">
                            <button type="button" class="toggle-btn active-pelanggaran" disabled>
                                <span class="toggle-btn__ikon"><i class="fa-solid fa-ban"></i></span>
                                <span><span class="toggle-btn__judul">Pelanggaran</span><span class="toggle-btn__ket">Polisi Taruna hanya dapat mengusulkan pelanggaran</span></span>
                            </button>
                        </div>
                        @endunless

                        {{-- Cabang pelanggaran PTTT --}}
                        <div id="sectionFormPelanggaran">
                            <span class="form-label">Tingkat Pelanggaran PTTT <span class="req">*</span></span>
                            <div class="tingkat-pelanggaran-grid">
                                <div class="tingkat-card tier-ringan active-ringan" id="cardRingan" role="button" tabindex="0" onclick="selectTingkatPelanggaran('ringan', 5)" onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.click(); }">
                                    <div class="tingkat-name">Ringan</div>
                                    <div class="tingkat-poin">−5 <small>poin</small></div>
                                    <div class="tingkat-ket">Atribut, kerapian, keterlambatan</div>
                                </div>
                                <div class="tingkat-card tier-sedang" id="cardSedang" role="button" tabindex="0" onclick="selectTingkatPelanggaran('sedang', 20)" onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.click(); }">
                                    <div class="tingkat-name">Sedang</div>
                                    <div class="tingkat-poin">−20 <small>poin</small></div>
                                    <div class="tingkat-ket">Izin, barang terlarang, alpa</div>
                                </div>
                                <div class="tingkat-card tier-berat" id="cardBerat" role="button" tabindex="0" onclick="selectTingkatPelanggaran('berat', 50)" onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); this.click(); }">
                                    <div class="tingkat-name">Berat</div>
                                    <div class="tingkat-poin">−50 <small>poin</small></div>
                                    <div class="tingkat-ket">Pelanggaran berat PTTT</div>
                                </div>
                            </div>
                            <small class="pn-bantuan"><i class="fa-solid fa-circle-info"></i>Bobot poin terisi otomatis sesuai tingkat yang dipilih.</small>

                            <div class="form-group">
                                <label class="form-label" for="selectJenisPelanggaran">Jenis Pelanggaran Sesuai PTTT <span class="req">*</span></label>
                                <select class="form-select" id="selectJenisPelanggaran" onchange="setKegiatanFromSelect(this)">
                                    <option value="">Pilih jenis pelanggaran tingkat ringan</option>
                                    @foreach($masterPelanggaran['ringan']['items'] as $item)
                                    <option value="{{ $item }}" data-tingkat="ringan">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Cabang penghargaan / prestasi --}}
                        <div id="sectionFormPenghargaan" class="d-none">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="form-label" for="selectKategoriPenghargaan">Kategori / Tingkat Penghargaan <span class="req">*</span></label>
                                    <select class="form-select" id="selectKategoriPenghargaan" onchange="updatePenghargaanDropdown(this.value)">
                                        <option value="internasional" data-poin="50">Internasional (+50 poin)</option>
                                        <option value="nasional" data-poin="30">Nasional (+30 poin)</option>
                                        <option value="provinsi" data-poin="20">Provinsi / Daerah (+20 poin)</option>
                                        <option value="internal" data-poin="10">Internal Kampus (+10 poin)</option>
                                        <option value="keteladanan" data-poin="15">Keteladanan &amp; Kepemimpinan (+15 poin)</option>
                                        <option value="khusus" data-poin="10">Penugasan / Petugas Khusus (+10 poin)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="form-label" for="displayNilaiPenghargaan">Bobot Poin Diberikan</label>
                                    <input type="number" class="form-control" id="displayNilaiPenghargaan" value="50" min="1" onchange="document.getElementById('inputNilaiPoin').value = this.value">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="selectJenisPenghargaan">Jenis Prestasi / Penghargaan <span class="req">*</span></label>
                                <select class="form-select" id="selectJenisPenghargaan" onchange="setKegiatanFromSelect(this)">
                                    <option value="">Pilih jenis prestasi</option>
                                    @foreach($masterPenghargaan['internasional']['items'] as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="inputNamaKegiatan">Deskripsi Kegiatan / Temuan <span class="req">*</span></label>
                            <input type="text" class="form-control" name="kegiatan" id="inputNamaKegiatan" placeholder="Terisi otomatis dari pilihan di atas, atau ketik sendiri" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="inputTanggalPoin">Tanggal Kejadian / Prestasi <span class="req">*</span></label>
                                <input type="date" class="form-control" id="inputTanggalPoin" name="tanggal" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="inputFotoBukti">Bukti (BAP / Sertifikat / Foto)</label>
                                <input type="file" class="form-control" id="inputFotoBukti" name="foto_bukti" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="inputKeteranganPoin">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control" id="inputKeteranganPoin" name="keterangan" rows="2" placeholder="Kronologi, saksi, atau tindak lanjut"></textarea>
                        </div>

                        <div class="pn-mode">
                            <i class="fa-solid fa-circle-info"></i>
                            <div>
                                @if($u->canManageSystem())
                                <strong>Mode Admin Pusbangkar:</strong> poin yang disimpan <strong>langsung tervalidasi</strong> dan otomatis masuk ke akumulasi taruna.
                                @elseif($u->isPolisiTaruna())
                                <strong>Mode Polisi Taruna:</strong> pelanggaran dikirim sebagai <strong>usulan temuan</strong> dan divalidasi oleh Admin Pusbangkar.
                                @else
                                <strong>Mode Pengasuh:</strong> poin dikirim sebagai <strong>usulan temuan</strong> dan divalidasi oleh Admin Pusbangkar.
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-log" id="btnSubmitPoin">
                            <i class="fa-solid fa-paper-plane"></i> {{ $u->canManageSystem() ? 'SIMPAN POIN' : 'KIRIM USULAN POIN' }}
                        </button>
                    </form>
                </div>

                {{-- Riwayat poin tervalidasi --}}
                <div class="ds-card" x-data="{ tab: 'pelanggaran' }">
                    <div class="ds-card__head rw-head">
                        <div>
                            <h3 class="ds-card__title"><i class="fa-solid fa-clock-rotate-left ds-icon"></i> Riwayat Poin Taruna</h3>
                            <p class="ds-card__desc">Pelanggaran &amp; penghargaan yang sudah tervalidasi</p>
                        </div>
                        <div class="rw-tabs" role="tablist" aria-label="Jenis riwayat poin">
                            <button type="button" role="tab" class="rw-tab" :class="{ 'rw-tab--aktif': tab === 'pelanggaran' }" :aria-selected="tab === 'pelanggaran'" @click="tab = 'pelanggaran'">
                                <i class="fa-solid fa-ban" style="color:var(--danger-ink)"></i> Pelanggaran
                                <span class="ds-badge ds-badge--danger">{{ $riwayatPelanggaran->count() }} · −{{ $angkaPoin($totalPelanggaran) }}</span>
                            </button>
                            <button type="button" role="tab" class="rw-tab" :class="{ 'rw-tab--aktif': tab === 'penghargaan' }" :aria-selected="tab === 'penghargaan'" @click="tab = 'penghargaan'">
                                <i class="fa-solid fa-trophy" style="color:var(--success-ink)"></i> Penghargaan
                                <span class="ds-badge ds-badge--success">{{ $riwayatPenghargaan->count() }} · +{{ $angkaPoin($totalPenghargaan) }}</span>
                            </button>
                        </div>
                    </div>

                    @foreach([
                        ['pelanggaran', $riwayatPelanggaran, 'Jenis Pelanggaran', 'Pengusul / Validator', 'fa-shield-halved', 'Tidak ada catatan pelanggaran tervalidasi. Status disiplin: Aman.'],
                        ['penghargaan', $riwayatPenghargaan, 'Prestasi / Penghargaan', 'Pemberi Rekomendasi', 'fa-award', 'Belum ada catatan penghargaan tervalidasi.'],
                    ] as [$kunci, $daftar, $kolom, $kolomOleh, $ikonKosong, $teksKosong])
                    @php $pel = $kunci === 'pelanggaran'; @endphp
                    <div x-show="tab === '{{ $kunci }}'" @if(!$pel) x-cloak @endif role="tabpanel">
                        @if($daftar->isEmpty())
                        <div class="ds-empty"><i class="fa-solid {{ $ikonKosong }} ds-icon"></i>{{ $teksKosong }}</div>
                        @else
                        <div class="ds-table-wrap">
                            <div class="ds-scroll">
                                <table class="ds-table tbl-table rw-table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th data-filter>Tingkat</th>
                                            <th>{{ $kolom }}</th>
                                            <th class="ds-right">Poin</th>
                                            <th data-filter>{{ $kolomOleh }}</th>
                                            <th class="ds-right" data-no-sort data-no-filter>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($daftar as $p)
                                        <tr>
                                            <td class="tbl-date" data-sort="{{ $p->tanggal?->format('Y-m-d') }}">{{ $p->tanggal ? $p->tanggal->locale('id')->isoFormat('D MMM Y') : '—' }}</td>
                                            <td>
                                                @php $vt = $pel ? $varianTingkat($p->tingkat) : 'success'; @endphp
                                                <span class="ds-badge {{ $vt ? 'ds-badge--'.$vt : '' }}">{{ ucfirst($p->tingkat ?? ($pel ? 'Pelanggaran' : 'Prestasi')) }}</span>
                                            </td>
                                            <td>
                                                <div class="tbl-title">{{ $p->kegiatan }}</div>
                                                @if($p->keterangan)<div class="tbl-sub">{{ $p->keterangan }}</div>@endif
                                            </td>
                                            <td class="ds-right rw-poin" style="color:var(--{{ $pel ? 'danger' : 'success' }}-ink)" data-sort="{{ (float) $p->nilai }}">{{ $pel ? '−' : '+' }}{{ $angkaPoin($p->nilai) }}</td>
                                            <td>
                                                <div class="tbl-title">{{ $p->pengasuh ?: '—' }}</div>
                                                <div class="tbl-sub" style="color:var(--success-ink)"><i class="fa-solid fa-circle-check"></i> Tervalidasi</div>
                                            </td>
                                            <td class="ds-right">
                                                {{-- Hapus hanya pengasuh & admin (route role:pengasuh,admin) --}}
                                                @unless($u->isPolisiTaruna())
                                                <form action="{{ route('poin.destroy', $p->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="ds-btn ds-btn--icon ds-btn--danger" title="Hapus" aria-label="Hapus poin {{ $p->kegiatan }}"
                                                            onclick="bukaHapusPoin(this.form, @js(($pel ? 'Pelanggaran' : 'Penghargaan') . ' · ' . $p->kegiatan . ' (' . ($pel ? '−' : '+') . $angkaPoin($p->nilai) . ')'))"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                                @endunless
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="ds-card">
                    <div class="ds-empty">
                        <i class="fa-solid fa-user-check ds-icon"></i>
                        Pilih salah satu taruna di kolom kiri untuk melihat raport poin, status sanksi PTTT, dan mengusulkan poin baru.
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</main>

{{-- Modal validasi usulan — hanya Admin Pusbangkar --}}
@if($u->canManageSystem())
<div class="ds-modal-overlay" id="pnValidasiModal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="pnValidasiJudul">
    <form class="ds-modal pn-vmodal" method="POST" id="pnValidasiForm">
        @csrf @method('PATCH')
        <input type="hidden" name="aksi" id="pnValidasiAksi">
        <div class="ds-modal__icon" id="pnValidasiIkon"><i class="fa-solid fa-check"></i></div>
        <h3 class="ds-modal__title" id="pnValidasiJudul">Validasi Usulan Poin?</h3>
        <p class="ds-modal__body" id="pnValidasiDesk" style="margin-bottom:0"></p>
        <dl class="pn-vmodal__rinci">
            <div><dt>Taruna</dt><dd id="pnVTaruna"></dd></div>
            <div><dt>Usulan</dt><dd id="pnVUsulan"></dd></div>
            <div><dt>Poin</dt><dd id="pnVPoin" class="pn-vmodal__poin"></dd></div>
            <div><dt>Pengusul</dt><dd id="pnVPengaju"></dd></div>
            <div><dt>Bukti</dt><dd id="pnVBukti"></dd></div>
        </dl>
        <div class="form-group">
            <label class="form-label" for="pnValidasiCatatan">Catatan Validasi <span style="color:var(--ink-500); font-weight:600; text-transform:none; letter-spacing:0">(opsional)</span></label>
            <textarea class="form-control" id="pnValidasiCatatan" name="catatan_validasi" maxlength="500" placeholder="Alasan atau catatan untuk pengusul..."></textarea>
        </div>
        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" onclick="tutupModalPoin()">Batal</button>
            <button type="submit" class="ds-btn ds-btn--primary" id="pnValidasiKirim"></button>
        </div>
    </form>
</div>
@endif

{{-- Modal hapus poin --}}
<div class="ds-modal-overlay" id="pnHapusModal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="pnHapusJudul">
    <div class="ds-modal">
        <div class="ds-modal__icon"><i class="fa-solid fa-trash"></i></div>
        <h3 class="ds-modal__title" id="pnHapusJudul">Hapus Poin?</h3>
        <p class="ds-modal__body"><strong id="pnHapusNama" style="color:var(--ink-900)"></strong><br>Poin ini akan dihapus permanen dan akumulasi taruna dihitung ulang.</p>
        <div class="ds-modal__actions">
            <button type="button" class="ds-btn" onclick="tutupModalPoin()">Batal</button>
            <button type="button" class="ds-btn ds-btn--primary" style="background:var(--danger);" onclick="pnHapusForm && pnHapusForm.submit()"><i class="fa-solid fa-trash"></i> Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    // Modal validasi: isi rincian dari data-validasi tombol, lalu kirim PATCH ke poin.validasi
    function bukaValidasi(btn, aksi) {
        const d = JSON.parse(btn.dataset.validasi);
        const setujui = aksi === 'setujui';
        document.getElementById('pnValidasiForm').action = d.url;
        document.getElementById('pnValidasiAksi').value = aksi;
        document.getElementById('pnValidasiJudul').textContent = setujui ? 'Validasi Usulan Poin?' : 'Tolak Usulan Poin?';
        document.getElementById('pnValidasiDesk').textContent = setujui
            ? 'Poin langsung masuk ke akumulasi taruna setelah divalidasi.'
            : 'Usulan ditolak dan tidak masuk ke akumulasi taruna.';
        const ikon = document.getElementById('pnValidasiIkon');
        ikon.className = 'ds-modal__icon' + (setujui ? ' ds-modal__icon--setujui' : '');
        ikon.innerHTML = '<i class="fa-solid ' + (setujui ? 'fa-check' : 'fa-xmark') + '"></i>';
        document.getElementById('pnVTaruna').textContent = d.taruna;
        document.getElementById('pnVUsulan').textContent = d.usulan;
        const poin = document.getElementById('pnVPoin');
        poin.textContent = d.poin;
        poin.style.color = d.pel ? 'var(--danger-ink)' : 'var(--success-ink)';
        document.getElementById('pnVPengaju').textContent = d.pengaju;
        const bukti = document.getElementById('pnVBukti');
        bukti.textContent = '';
        if (d.bukti) {
            const a = Object.assign(document.createElement('a'), { href: d.bukti, target: '_blank', rel: 'noopener', textContent: 'Lihat foto bukti' });
            a.className = 'ds-btn ds-btn--xs';
            bukti.appendChild(a);
        } else {
            bukti.textContent = 'Tidak dilampirkan';
        }
        document.getElementById('pnValidasiCatatan').value = '';
        const kirim = document.getElementById('pnValidasiKirim');
        kirim.innerHTML = setujui ? '<i class="fa-solid fa-check"></i> Ya, Validasi' : '<i class="fa-solid fa-xmark"></i> Ya, Tolak';
        kirim.style.background = setujui ? 'var(--success)' : 'var(--danger)';
        document.getElementById('pnValidasiModal').style.display = 'flex';
    }

    let pnHapusForm = null;
    function bukaHapusPoin(form, nama) {
        pnHapusForm = form;
        document.getElementById('pnHapusNama').textContent = nama;
        document.getElementById('pnHapusModal').style.display = 'flex';
    }

    function tutupModalPoin() {
        document.querySelectorAll('#pnValidasiModal, #pnHapusModal').forEach(m => m.style.display = 'none');
        pnHapusForm = null;
    }
    document.querySelectorAll('#pnValidasiModal, #pnHapusModal').forEach(m => m.addEventListener('click', e => { if (e.target === m) tutupModalPoin(); }));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupModalPoin(); });
</script>

{{-- Master Data JSON JS --}}
<script>
    const masterPelanggaran = @json($masterPelanggaran);
    const masterPenghargaan = @json($masterPenghargaan);

    function filterMhsList() {
        const q = document.getElementById('mhsSearchInput').value.toLowerCase().trim();
        const items = document.querySelectorAll('.mhs-item-opt');
        items.forEach(item => {
            const data = item.dataset.search || '';
            item.style.display = data.includes(q) ? 'flex' : 'none';
        });
    }

    // Gulir daftar (bukan halaman) ke taruna yang sedang dipilih
    (function () {
        const list = document.getElementById('mhsDropdownList');
        const sel = list && list.querySelector('.mhs-item-opt.selected');
        if (sel) list.scrollTop = sel.offsetTop - list.offsetTop - 8;
    })();

    function switchKategori(kat) {
        document.getElementById('inputKategoriPoin').value = kat;
        const btnPelanggaran = document.getElementById('btnPilihPelanggaran');
        const btnPenghargaan = document.getElementById('btnPilihPenghargaan');
        const secPelanggaran = document.getElementById('sectionFormPelanggaran');
        const secPenghargaan = document.getElementById('sectionFormPenghargaan');

        if (kat === 'pelanggaran') {
            btnPelanggaran.className = 'toggle-btn active-pelanggaran';
            btnPenghargaan.className = 'toggle-btn';
            secPelanggaran.classList.remove('d-none');
            secPenghargaan.classList.add('d-none');
            selectTingkatPelanggaran('ringan', 5);
        } else {
            btnPelanggaran.className = 'toggle-btn';
            btnPenghargaan.className = 'toggle-btn active-penghargaan';
            secPelanggaran.classList.add('d-none');
            secPenghargaan.classList.remove('d-none');
            updatePenghargaanDropdown('internasional');
        }
    }

    function selectTingkatPelanggaran(tingkat, poin) {
        document.getElementById('inputTingkatPoin').value = tingkat;
        document.getElementById('inputNilaiPoin').value = poin;

        // Reset visual card classes (tetap pertahankan warna tier permanen)
        document.getElementById('cardRingan').className = 'tingkat-card tier-ringan' + (tingkat === 'ringan' ? ' active-ringan' : '');
        document.getElementById('cardSedang').className = 'tingkat-card tier-sedang' + (tingkat === 'sedang' ? ' active-sedang' : '');
        document.getElementById('cardBerat').className  = 'tingkat-card tier-berat'  + (tingkat === 'berat'  ? ' active-berat'  : '');

        // Populate dropdown options
        const select = document.getElementById('selectJenisPelanggaran');
        select.innerHTML = '<option value="">Pilih jenis pelanggaran tingkat ' + tingkat + '</option>';
        if (masterPelanggaran[tingkat] && masterPelanggaran[tingkat].items) {
            masterPelanggaran[tingkat].items.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item;
                opt.textContent = item;
                select.appendChild(opt);
            });
        }
    }

    function updatePenghargaanDropdown(kategori) {
        document.getElementById('inputTingkatPoin').value = kategori;
        const select = document.getElementById('selectJenisPenghargaan');
        const poin = masterPenghargaan[kategori] ? masterPenghargaan[kategori].bobot : 10;
        
        document.getElementById('inputNilaiPoin').value = poin;
        document.getElementById('displayNilaiPenghargaan').value = poin;

        select.innerHTML = '<option value="">Pilih jenis prestasi</option>';
        if (masterPenghargaan[kategori] && masterPenghargaan[kategori].items) {
            masterPenghargaan[kategori].items.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item;
                opt.textContent = item;
                select.appendChild(opt);
            });
        }
    }

    function setKegiatanFromSelect(select) {
        if (select.value) {
            document.getElementById('inputNamaKegiatan').value = select.value;
        }
    }
</script>
</x-app-layout>
