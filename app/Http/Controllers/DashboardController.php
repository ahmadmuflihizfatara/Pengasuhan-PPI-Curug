<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Helpers\DashboardHelper;
use App\Models\Acara;
use App\Models\Mahasiswa;
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
        $suratTerbaru = Surat::latest()->take(5)->get();

        // Point total + grafik prodi/tingkat if Taruna
        $totalPoin = 0;
        $chartData = null;
        if (auth()->user()->isTaruna()) {
            $student = Mahasiswa::where('user_id', auth()->id())->first();
            if ($student) {
                $totalPoin = PoinMahasiswa::where('mahasiswa_id', $student->id)->get()->sum('nilai_efektif');
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
            'totalPoin'        => $totalPoin,
            'chartData'        => $chartData,
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
