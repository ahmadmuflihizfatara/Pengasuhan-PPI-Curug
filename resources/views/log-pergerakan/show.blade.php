<x-app-layout>
<style>
    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

    .app-layout { display: flex; min-height: 100vh; }
    .main-content { flex: 1; padding: 24px 28px; min-width: 0; }

    .detail-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }
    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 1px solid #f0f2f7;
        flex-wrap: wrap;
        gap: 14px;
    }
    .detail-title { font-size: 22px; font-weight: 800; color: #333; margin: 0; }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }
    .info-item {
        background: #fafbff;
        border-radius: 12px;
        padding: 14px 18px;
        border: 1px solid #edf0f7;
    }
    .info-item .lbl { font-size: 11.5px; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 4px; }
    .info-item .val { font-size: 15px; font-weight: 700; color: #333; }

    .doc-img {
        max-width: 100%;
        max-height: 320px;
        border-radius: 12px;
        border: 1px solid #edf0f7;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    /* Badges */
    .badge-status-belum {
        background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5;
        padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .badge-status-sudah {
        background: #dcfce7; color: #15803d; border: 1px solid #86efac;
        padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .pulse-dot {
        width: 8px; height: 8px; background: #dc2626; border-radius: 50%; display: inline-block;
        animation: blink 1.2s infinite;
    }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
</style>

<div class="app-layout">
    <x-sidebar active="log-pergerakan" />

    <main class="main-content">

        <div class="mb-3">
            <a href="{{ route('log-pergerakan.index') }}" class="btn btn-outline-secondary btn-sm fw-bold rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Rekapitulasi
            </a>
            <a href="{{ route('log-pergerakan.tablet') }}" class="btn btn-outline-primary btn-sm fw-bold rounded-3 ms-2">
                <i class="fas fa-tablet-alt me-1"></i> Buka Mode Tablet
            </a>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <div>
                    <h2 class="detail-title">
                        <i class="fas fa-id-card text-primary me-2"></i> Detail Log: {{ $log->nama }}
                    </h2>
                    <div class="text-muted small mt-1">
                        Kategori: <strong>{{ ucfirst($log->kategori) }}</strong> &bull; Sub: <strong>{{ $log->subkategori }}</strong>
                    </div>
                </div>
                <div>
                    {!! $log->getStatusBadgeHtml() !!}
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="lbl">Nama Taruna / Koordinator</div>
                    <div class="val">{{ $log->nama }}</div>
                </div>
                <div class="info-item">
                    <div class="lbl">NPM & Prodi / Jurusan</div>
                    <div class="val">{{ $log->npm ?? '-' }} &bull; {{ $log->prodi ?? 'PPI Curug' }}</div>
                </div>
                <div class="info-item">
                    <div class="lbl">Waktu Keberangkatan</div>
                    <div class="val text-primary"><i class="far fa-clock me-1"></i> {{ $log->waktu_berangkat ? $log->waktu_berangkat->format('d F Y, H:i') : '-' }} WIB</div>
                </div>
                <div class="info-item">
                    <div class="lbl">Waktu Kembali / Durasi</div>
                    <div class="val text-success">
                        @if($log->isSudahKembali())
                            <i class="fas fa-check-circle me-1"></i> {{ $log->waktu_kembali ? $log->waktu_kembali->format('d F Y, H:i') : '-' }} WIB
                            <div class="small text-muted fw-normal mt-1">Durasi total: {{ $log->getDurasiFormatted() }}</div>
                        @else
                            <span class="text-danger"><i class="fas fa-hourglass-half me-1"></i> Masih di Luar ({{ $log->getDurasiFormatted() }} lalu)</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Detail Spesifik Kategori --}}
            <div class="card p-3 border-0 bg-light rounded-4 mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="fas fa-list-alt text-primary me-2"></i> Rincian Informasi Kegiatan</h5>
                
                @if($log->kategori === 'perizinan')
                    <div class="mb-2"><strong>Alasan / Keterangan Keluhan:</strong></div>
                    <div class="p-3 bg-white border rounded-3 text-dark">{{ $log->keterangan_keluhan ?? 'Tidak ada catatan tambahan.' }}</div>
                @elseif($log->kategori === 'ekstrakurikuler')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>Nama Ekskul:</strong>
                            <div class="fs-6 fw-bold text-primary">{{ $log->nama_ekskul }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>Jumlah Anggota:</strong>
                            <div class="fs-6 fw-bold text-dark">{{ $log->jumlah_anggota }} Orang</div>
                        </div>
                        <div class="col-md-4">
                            <strong>Lokasi Kegiatan:</strong>
                            <div class="fs-6 fw-bold text-dark">{{ $log->lokasi_kegiatan ?? '-' }}</div>
                        </div>
                        @if($log->daftar_anggota)
                        <div class="col-12">
                            <strong>Daftar Anggota yang Ikut:</strong>
                            <div class="p-2 bg-white border rounded-3 mt-1">{{ $log->daftar_anggota }}</div>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>Rute Olahraga:</strong>
                            <div class="fs-6 fw-bold text-success">{{ $log->rute ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>Pengikut / Teman Olahraga:</strong>
                            <div class="fs-6 fw-bold text-dark">{{ $log->pengikut ?? '-' }}</div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Dokumentasi Foto --}}
            <div class="row g-4 mb-4">
                @if($log->foto_keberangkatan)
                <div class="col-md-6">
                    <h6 class="fw-bold mb-2"><i class="fas fa-camera text-primary me-1"></i> Dokumentasi Keberangkatan</h6>
                    <img src="{{ asset('storage/' . $log->foto_keberangkatan) }}" alt="Foto Keberangkatan" class="doc-img">
                </div>
                @endif
                @if($log->foto_kembali)
                <div class="col-md-6">
                    <h6 class="fw-bold mb-2"><i class="fas fa-camera text-success me-1"></i> Dokumentasi Kepulangan</h6>
                    <img src="{{ asset('storage/' . $log->foto_kembali) }}" alt="Foto Kepulangan" class="doc-img">
                </div>
                @endif
            </div>

            {{-- Action jika belum kembali --}}
            @if($log->isBelumKembali())
            <div class="p-3 bg-white border border-warning rounded-4 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold text-dark mb-1"><i class="fas fa-exclamation-circle text-warning me-1"></i> Taruna Belum Kembali ke Asrama</h6>
                    <p class="text-muted small mb-0">Klik tombol di samping saat taruna telah tiba kembali di asrama untuk memperbarui status.</p>
                </div>
                <form action="{{ route('log-pergerakan.kembali', $log->id) }}" method="POST" onsubmit="return confirm('Tandai bahwa {{ $log->nama }} SUDAH KEMBALI?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-3">
                        <i class="fas fa-check-circle me-1"></i> UBAH STATUS AKHIR: KEMBALI
                    </button>
                </form>
            </div>
            @endif

        </div>

    </main>
</div>
</x-app-layout>
