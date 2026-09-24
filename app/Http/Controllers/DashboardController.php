<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Helpers\DashboardHelper;
use App\Models\Acara;
use App\Models\KeluhanBarak;
use App\Models\Konsinyir;
use App\Models\Mahasiswa;
use App\Models\NilaiTaruna;
use App\Models\PoinMahasiswa;
use App\Models\Surat;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index(): View
    {
        $mahasiswaSidebar = Mahasiswa::orderBy('kelas')->orderBy('nama')->get();
        $totalMahasiswa   = $mahasiswaSidebar->count();

        // Acara mendatang (urut tanggal + jam terdekat)
        $acaraMendatang = Acara::orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->get();

        // Semua acara untuk tabel
        $semuaAcara = Acara::orderBy('tanggal', 'asc')->orderBy('jam', 'asc')->get();

        // Surat stats
        $suratStats = [
            'total'     => Surat::count(),
            'diproses'  => Surat::where('status', 'Diproses')->count(),
            'disetujui' => Surat::where('status', 'Disetujui')->count(),
            'ditolak'   => Surat::where('status', 'Ditolak')->count(),
            'selesai'   => Surat::where('status', 'Selesai')->count(),
        ];

        // Surat terbaru
        // Taruna: seluruh surat yang diajukan akunnya sendiri; staf: 5 surat terbaru
        $suratTerbaru = auth()->user()->hasTarunaAccess()
            ? Surat::where('user_id', auth()->id())->latest()->get()
            : Surat::latest()->take(5)->get();

        // Keluhan barak stats
        $keluhanStats = [
            'total'     => KeluhanBarak::count(),
            'diajukan'  => KeluhanBarak::where('status', 'Diajukan')->count(),
            'diproses'  => KeluhanBarak::where('status', 'Diproses')->count(),
            'selesai'   => KeluhanBarak::where('status', 'Selesai')->count(),
            'ditolak'   => KeluhanBarak::where('status', 'Ditolak')->count(),
        ];

        // Point total + grafik prodi/tingkat + status konsinyir if Taruna
        $poinTaruna = ['pelanggaran' => 0, 'penghargaan' => 0];
        $chartData = null;
        $konsinyirAktif = null;
        $nilaiSemester = collect();
        $student = null;
        if (auth()->user()->hasTarunaAccess()) {
            $student = Mahasiswa::where('user_id', auth()->id())->first();
            if ($student) {
                // Sama dengan PoinController::myPointsApi: hanya poin yang sudah disetujui
                $disetujui = PoinMahasiswa::where('mahasiswa_id', $student->id)
                    ->where('status_validasi', PoinMahasiswa::STATUS_DISETUJUI);
                $poinTaruna = [
                    'pelanggaran' => (clone $disetujui)->where('kategori', PoinMahasiswa::KAT_PELANGGARAN)->sum('nilai'),
                    'penghargaan' => (clone $disetujui)->where('kategori', PoinMahasiswa::KAT_PRESTASI)->sum('nilai'),
                ];
                $konsinyirAktif = Konsinyir::where('mahasiswa_id', $student->id)
                    ->orderByDesc('tanggal_mulai')
                    ->get()
                    ->first(fn ($k) => $k->status === 'aktif');
                $nilaiSemester = NilaiTaruna::where('mahasiswa_id', $student->id)->orderBy('semester')->get();
            }
            $chartData = Mahasiswa::chartDataPerTingkat();
        }

        return view('dashboard', [
            'mahasiswaSidebar' => $mahasiswaSidebar,
            'totalMahasiswa'   => $totalMahasiswa,
            'acaraMendatang'   => $acaraMendatang,
            'semuaAcara'       => $semuaAcara,
            'suratStats'       => $suratStats,
            'suratTerbaru'     => $suratTerbaru,
            'keluhanStats'     => $keluhanStats,
            'poinTaruna'       => $poinTaruna,
            'chartData'        => $chartData,
            'konsinyirAktif'   => $konsinyirAktif,
            'nilaiSemester'    => $nilaiSemester,
            'student'          => $student,
        ]);
    }

    /**
     * Refresh dashboard data (API endpoint)
     */
    public function refresh(): JsonResponse
    {
        try {
            $stats = DashboardHelper::getDashboardStats();
            $callVolumeData = DashboardHelper::getCallVolumeData();

            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => $stats,
                    'chartData' => [
                        [
                            'name' => 'Inbound Calls',
                            'data' => $callVolumeData['inbound']
                        ],
                        [
                            'name' => 'Outbound Calls',
                            'data' => $callVolumeData['outbound']
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error refreshing dashboard data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get dashboard statistics
     */
    public function getStats(): JsonResponse
    {
        try {
            $stats = DashboardHelper::getDashboardStats();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get call volume data
     */
    public function getCallVolume(): JsonResponse
    {
        try {
            $data = DashboardHelper::getCallVolumeData();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching call volume data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent calls
     */
    public function getRecentCalls(): JsonResponse
    {
        try {
            $calls = DashboardHelper::getRecentCalls();

            return response()->json([
                'success' => true,
                'data' => $calls
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching recent calls: ' . $e->getMessage()
            ], 500);
        }
    }
}
