<?php

namespace App\Http\Controllers;

use App\Models\BeritaTaruna;
use App\Models\LaporanDuty;
use App\Models\LogPergerakan;
use App\Models\PoinMahasiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MonitoringTvController extends Controller
{
    /**
     * Layar Monitoring TV (pengasuh & admin): dinas/izin keluar, taruna sakit,
     * log book pelanggaran/penghargaan, dan galeri dokumentasi.
     */
    public function index(): View
    {
        // Taruna yang sedang di luar (dinas/kegiatan/izin) dan belum kembali
        $izinKeluar = LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)
            ->latest('waktu_berangkat')
            ->get();

        $tarunaSakit = LaporanDuty::with('mahasiswa')
            ->whereDate('tanggal', Carbon::today())
            ->latest()
            ->get();

        $logBook = PoinMahasiswa::where(fn ($q) => $q->whereNull('status_validasi')
                ->orWhere('status_validasi', '!=', PoinMahasiswa::STATUS_DITOLAK))
            ->latest('tanggal')
            ->latest()
            ->take(30)
            ->get();

        $galeri = BeritaTaruna::published()
            ->whereNotNull('gambar')
            ->latest()
            ->take(20)
            ->get()
            ->map(fn ($b) => [
                'src'     => Storage::url($b->gambar),
                'judul'   => $b->judul,
                'tanggal' => $b->created_at->locale('id')->isoFormat('D MMMM Y'),
            ])
            ->values();

        return view('monitoring-tv.index', compact('izinKeluar', 'tarunaSakit', 'logBook', 'galeri'));
    }
}
