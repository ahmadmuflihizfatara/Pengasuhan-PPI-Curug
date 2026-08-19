<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: transparent; }

.app-layout { display: flex; min-height: 100vh; }
.main-content { flex: 1; padding: 28px 30px; min-width: 0; }

.page-header {
    background: linear-gradient(135deg, #764ba2 0%, #4a3aa7 100%);
    border-radius: 18px; padding: 28px 32px; color: white; margin-bottom: 22px;
    position: relative; overflow: hidden;
}
.page-header::before { content:''; position:absolute; right:-60px; top:-60px; width:220px; height:220px; background:rgba(255,255,255,.1); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:70px; bottom:-80px; width:180px; height:180px; background:rgba(255,255,255,.07); border-radius:50%; }
.page-header h1 { margin:0 0 4px; font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-header p  { margin:0; opacity:.88; font-size:13px; position:relative; z-index:1; }

.flash-success { background:#f0fff4; border:1px solid #c6f6d5; color:#276749; padding:12px 18px; border-radius:12px; margin-bottom:18px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:8px; }

.info-strip {
    background:#f4f3ff; border:1px solid #ddd8ff; color:#4a3aa7;
    padding:13px 18px; border-radius:12px; margin-bottom:20px;
    font-size:12.5px; display:flex; gap:10px; align-items:flex-start; line-height:1.6;
}

.akses-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:16px; }
.akses-card { background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); padding:22px; border:2px solid transparent; transition:border-color .15s; }
.akses-card.aktif { border-color:#c6f6d5; }
.akses-card.mati  { border-color:#fed7d7; }

.akses-head { display:flex; align-items:center; gap:13px; margin-bottom:12px; }
.akses-ikon { width:46px; height:46px; border-radius:13px; display:flex; align-items:center; justify-content:center; color:white; font-size:18px; flex-shrink:0; }
.akses-nama { font-size:15px; font-weight:800; color:#2b2b33; }
.akses-status { font-size:11px; font-weight:800; padding:3px 11px; border-radius:20px; display:inline-block; margin-top:3px; }
.akses-status.on  { background:#f0fff4; color:#276749; }
.akses-status.off { background:#fff5f5; color:#c53030; }

.akses-ket { font-size:12.5px; color:#7b8194; line-height:1.6; margin-bottom:14px; }
.akses-meta { font-size:11px; color:#b0b6c5; margin-bottom:14px; }

.btn-toggle {
    width:100%; border:none; padding:11px; border-radius:11px;
    font-size:13px; font-weight:700; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:8px;
    font-family:'Inter',sans-serif; transition:opacity .15s;
}
.btn-toggle:hover { opacity:.9; }
.btn-tutup { background:#fff5f5; color:#c53030; }
.btn-buka  { background:linear-gradient(135deg,#1baf7a,#2a78d6); color:white; }
</style>

{{-- Top Floating Island Capsule Navbar --}}
<x-island-navbar />

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <div class="page-header">
            <h1><i class="fas fa-shield-alt" style="margin-right:10px;"></i>Akses Fitur Pengasuh</h1>
            <p>Atur fitur mana yang boleh diisi dan digenerate oleh pengasuh</p>
        </div>

        @if(session('success'))
        <div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <div class="info-strip">
            <i class="fas fa-circle-info" style="margin-top:2px;"></i>
            <span>Saat akses ditutup, pengasuh <strong>tetap dapat membuka tab dan melihat data</strong> yang sudah ada,
                  tetapi tombol isi/generate/ubah hilang dan permintaan simpan ditolak server. Pengaturan berlaku untuk semua akun pengasuh.</span>
        </div>

        <div class="akses-grid">
            @foreach($daftar as $item)
            <div class="akses-card {{ $item['diizinkan'] ? 'aktif' : 'mati' }}">
                <div class="akses-head">
                    <div class="akses-ikon" style="background:{{ $item['warna'] }};">
                        <i class="fas {{ $item['ikon'] }}"></i>
                    </div>
                    <div>
                        <div class="akses-nama">{{ $item['label'] }}</div>
                        <span class="akses-status {{ $item['diizinkan'] ? 'on' : 'off' }}">
                            {{ $item['diizinkan'] ? 'DIIZINKAN' : 'DITUTUP' }}
                        </span>
                    </div>
                </div>

                <div class="akses-ket">{{ $item['ket'] }}</div>

                @if($item['diubah'])
                <div class="akses-meta">
                    <i class="fas fa-clock-rotate-left"></i>
                    Diubah {{ $item['diubah']->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                    @if($item['pengubah']) oleh {{ $item['pengubah'] }} @endif
                </div>
                @endif

                <form method="POST" action="{{ route('akses.update') }}">
                    @csrf
                    <input type="hidden" name="fitur" value="{{ $item['key'] }}">
                    <input type="hidden" name="diizinkan" value="{{ $item['diizinkan'] ? 0 : 1 }}">
                    <button type="submit" class="btn-toggle {{ $item['diizinkan'] ? 'btn-tutup' : 'btn-buka' }}">
                        <i class="fas {{ $item['diizinkan'] ? 'fa-lock' : 'fa-lock-open' }}"></i>
                        {{ $item['diizinkan'] ? 'Tutup Akses' : 'Buka Akses' }}
                    </button>
                </form>
            </div>
            @endforeach
        </div>

    </div>
</main>
</x-app-layout>
