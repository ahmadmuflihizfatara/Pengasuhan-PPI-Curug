<?php

namespace App\Http\Controllers;

use App\Models\LogPergerakan;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LogPergerakanController extends Controller
{
    /**
     * Halaman Manajemen / Riwayat Log Pergerakan Taruna
     */
    public function index(Request $request)
    {
        $query = LogPergerakan::with(['user', 'creator', 'verifier'])->latest('waktu_berangkat');

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('waktu_berangkat', $request->tanggal);
        } else {
            // Default filter jika ada
        }

        // Search Nama / NPM / Keterangan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('npm', 'like', "%{$search}%")
                  ->orWhere('prodi', 'like', "%{$search}%")
                  ->orWhere('nama_ekskul', 'like', "%{$search}%")
                  ->orWhere('rute', 'like', "%{$search}%")
                  ->orWhere('keterangan_keluhan', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(15)->withQueryString();

        // Statistik Hari Ini
        $today = Carbon::today();
        $stats = [
            'total_today'    => LogPergerakan::whereDate('waktu_berangkat', $today)->count(),
            'belum_kembali'  => LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)->count(),
            'sudah_kembali'  => LogPergerakan::whereDate('waktu_berangkat', $today)->where('status', LogPergerakan::STATUS_KEMBALI)->count(),
            'perizinan'      => LogPergerakan::whereDate('waktu_berangkat', $today)->where('kategori', LogPergerakan::KAT_PERIZINAN)->count(),
            'ekskul'         => LogPergerakan::whereDate('waktu_berangkat', $today)->where('kategori', LogPergerakan::KAT_EKSTRAKURIKULER)->count(),
            'olahraga'       => LogPergerakan::whereDate('waktu_berangkat', $today)->where('kategori', LogPergerakan::KAT_OLAHRAGA)->count(),
        ];

        return view('log-pergerakan.index', compact('logs', 'stats'));
    }

    /**
     * Tampilan Mode Tablet Pos Jaga (Input Keberangkatan & Kepulangan)
     */
    public function tablet(Request $request)
    {
        // Ambil daftar mahasiswa untuk autocomplete / selection
        $mahasiswas = Mahasiswa::orderBy('kelas')->orderBy('nama')->get();
        
        // Ambil data taruna yang saat ini BELUM KEMBALI
        $belumKembali = LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)
            ->latest('waktu_berangkat')
            ->get();

        $stats = [
            'belum_kembali' => $belumKembali->count(),
            'sudah_kembali' => LogPergerakan::whereDate('waktu_berangkat', Carbon::today())
                ->where('status', LogPergerakan::STATUS_KEMBALI)->count(),
            'total_today'   => LogPergerakan::whereDate('waktu_berangkat', Carbon::today())->count(),
        ];

        return view('log-pergerakan.tablet', compact('mahasiswas', 'belumKembali', 'stats'));
    }

    /**
     * Simpan Log Keberangkatan Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori'           => 'required|in:perizinan,ekstrakurikuler,olahraga',
            'subkategori'        => 'required|string|max:100',
            'nama'               => 'required|string|max:255',
            'npm'                => 'nullable|string|max:50',
            'prodi'              => 'nullable|string|max:100',
            'waktu_berangkat'    => 'required|date',
            'estimasi_kembali'   => 'nullable|date',
            'keterangan_keluhan' => 'nullable|string',
            'nama_ekskul'        => 'nullable|string|max:150',
            'jumlah_anggota'     => 'nullable|integer|min:1',
            'daftar_anggota'     => 'nullable|string',
            'lokasi_kegiatan'    => 'nullable|string|max:255',
            'rute'               => 'nullable|string|max:255',
            'pengikut'           => 'nullable|string',
            'foto_keberangkatan' => 'nullable|image|max:5120', // Max 5MB
        ]);

        // Upload Foto Keberangkatan jika ada
        if ($request->hasFile('foto_keberangkatan')) {
            $path = $request->file('foto_keberangkatan')->store('log_pergerakan', 'public');
            $validated['foto_keberangkatan'] = $path;
        }

        // Cari user_id jika ada relasi user
        if (!empty($validated['npm'])) {
            $user = User::where('npm', $validated['npm'])->first();
            if ($user) {
                $validated['user_id'] = $user->id;
                if (empty($validated['prodi']) && !empty($user->prodi)) {
                    $validated['prodi'] = $user->prodi;
                }
            }
        }

        $validated['status'] = LogPergerakan::STATUS_BERANGKAT;
        $validated['created_by'] = auth()->id();

        $log = LogPergerakan::create($validated);

        // Activity Log
        if (auth()->check()) {
            ActivityLog::create([
                'user_id'   => auth()->id(),
                'user_name' => auth()->user()->name,
                'user_role' => auth()->user()->role,
                'modul'     => 'log pergerakan',
                'aksi'      => 'tambah',
                'deskripsi' => "Mencatat keberangkatan {$log->nama} ({$log->kategori} - {$log->subkategori})",
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Log keberangkatan berhasil disimpan!',
                'data'    => $log
            ]);
        }

        return redirect()->back()->with('success', 'Log keberangkatan berhasil disimpan! Status: 🔴 BELUM KEMBALI');
    }

    /**
     * Update Status Taruna Kembali (Kepulangan)
     */
    public function updateKembali(Request $request, $id)
    {
        $log = LogPergerakan::findOrFail($id);

        $request->validate([
            'waktu_kembali'   => 'nullable|date',
            'catatan_kembali' => 'nullable|string|max:1000',
            'foto_kembali'    => 'nullable|image|max:5120',
        ]);

        $log->status = LogPergerakan::STATUS_KEMBALI;
        $log->waktu_kembali = $request->filled('waktu_kembali') ? Carbon::parse($request->waktu_kembali) : Carbon::now();
        $log->catatan_kembali = $request->catatan_kembali;
        $log->verified_by = auth()->id();

        if ($request->hasFile('foto_kembali')) {
            $path = $request->file('foto_kembali')->store('log_pergerakan', 'public');
            $log->foto_kembali = $path;
        }

        $log->save();

        // Activity Log
        if (auth()->check()) {
            ActivityLog::create([
                'user_id'   => auth()->id(),
                'user_name' => auth()->user()->name,
                'user_role' => auth()->user()->role,
                'modul'     => 'log pergerakan',
                'aksi'      => 'ubah',
                'deskripsi' => "Mengubah status kembali untuk {$log->nama} ({$log->kategori})",
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status kepulangan berhasil dicatat! Status: 🟢 SUDAH KEMBALI',
                'data'    => $log
            ]);
        }

        return redirect()->back()->with('success', "Taruna {$log->nama} telah ditandai: 🟢 SUDAH KEMBALI.");
    }

    /**
     * Tampilan Dashboard Monitoring TV Pos Jaga (Live Display Screen)
     */
    public function tvMonitoring(Request $request)
    {
        $activeLogs = LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)
            ->latest('waktu_berangkat')
            ->get();

        $returnedToday = LogPergerakan::whereDate('waktu_berangkat', Carbon::today())
            ->where('status', LogPergerakan::STATUS_KEMBALI)
            ->latest('waktu_kembali')
            ->take(10)
            ->get();

        $today = Carbon::today();
        $stats = [
            'total_belum_kembali' => $activeLogs->count(),
            'total_sudah_kembali' => LogPergerakan::whereDate('waktu_berangkat', $today)->where('status', LogPergerakan::STATUS_KEMBALI)->count(),
            'total_perizinan'     => LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)->where('kategori', LogPergerakan::KAT_PERIZINAN)->count(),
            'total_ekskul'        => LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)->where('kategori', LogPergerakan::KAT_EKSTRAKURIKULER)->count(),
            'total_olahraga'      => LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)->where('kategori', LogPergerakan::KAT_OLAHRAGA)->count(),
            'total_hari_ini'      => LogPergerakan::whereDate('waktu_berangkat', $today)->count(),
        ];

        return view('log-pergerakan.tv-monitoring', compact('activeLogs', 'returnedToday', 'stats'));
    }

    /**
     * API Realtime Polling untuk Dashboard TV & Widget
     */
    public function apiData(Request $request)
    {
        $activeLogs = LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)
            ->latest('waktu_berangkat')
            ->get()
            ->map(function ($log) {
                return [
                    'id'                 => $log->id,
                    'nama'               => $log->nama,
                    'npm'                => $log->npm,
                    'prodi'              => $log->prodi,
                    'kategori'           => $log->kategori,
                    'subkategori'        => $log->subkategori,
                    'detail_kegiatan'    => $log->kategori === 'perizinan' ? $log->keterangan_keluhan : ($log->kategori === 'ekstrakurikuler' ? $log->nama_ekskul . ' (' . $log->jumlah_anggota . ' org)' : $log->rute),
                    'lokasi_rute'        => $log->lokasi_kegiatan ?? $log->rute ?? '-',
                    'waktu_berangkat'    => $log->waktu_berangkat ? $log->waktu_berangkat->format('H:i') : '-',
                    'tanggal_berangkat'  => $log->waktu_berangkat ? $log->waktu_berangkat->format('d/m/Y') : '-',
                    'durasi'             => $log->getDurasiFormatted(),
                    'estimasi_kembali'   => $log->estimasi_kembali ? $log->estimasi_kembali->format('H:i') : null,
                    'status'             => $log->status,
                    'status_label'       => $log->getStatusLabel(),
                    'foto_keberangkatan' => $log->foto_keberangkatan ? asset('storage/' . $log->foto_keberangkatan) : null,
                ];
            });

        $returnedToday = LogPergerakan::whereDate('waktu_berangkat', Carbon::today())
            ->where('status', LogPergerakan::STATUS_KEMBALI)
            ->latest('waktu_kembali')
            ->take(8)
            ->get()
            ->map(function ($log) {
                return [
                    'id'             => $log->id,
                    'nama'           => $log->nama,
                    'kategori'       => $log->kategori,
                    'subkategori'    => $log->subkategori,
                    'waktu_berangkat'=> $log->waktu_berangkat ? $log->waktu_berangkat->format('H:i') : '-',
                    'waktu_kembali'  => $log->waktu_kembali ? $log->waktu_kembali->format('H:i') : '-',
                    'durasi'         => $log->getDurasiFormatted(),
                    'status'         => $log->status,
                ];
            });

        $today = Carbon::today();
        $stats = [
            'total_belum_kembali' => $activeLogs->count(),
            'total_sudah_kembali' => LogPergerakan::whereDate('waktu_berangkat', $today)->where('status', LogPergerakan::STATUS_KEMBALI)->count(),
            'total_perizinan'     => LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)->where('kategori', LogPergerakan::KAT_PERIZINAN)->count(),
            'total_ekskul'        => LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)->where('kategori', LogPergerakan::KAT_EKSTRAKURIKULER)->count(),
            'total_olahraga'      => LogPergerakan::where('status', LogPergerakan::STATUS_BERANGKAT)->where('kategori', LogPergerakan::KAT_OLAHRAGA)->count(),
            'total_hari_ini'      => LogPergerakan::whereDate('waktu_berangkat', $today)->count(),
        ];

        return response()->json([
            'success'       => true,
            'timestamp'     => Carbon::now()->format('H:i:s d/m/Y'),
            'stats'         => $stats,
            'active_logs'   => $activeLogs,
            'returned_today'=> $returnedToday,
        ]);
    }

    /**
     * Detail Modal / Halaman Satu Log
     */
    public function show($id)
    {
        $log = LogPergerakan::with(['user', 'creator', 'verifier'])->findOrFail($id);
        return view('log-pergerakan.show', compact('log'));
    }

    /**
     * Hapus Data Log (Khusus Pengasuh / Admin)
     */
    public function destroy($id)
    {
        $log = LogPergerakan::findOrFail($id);
        
        if ($log->foto_keberangkatan && Storage::disk('public')->exists($log->foto_keberangkatan)) {
            Storage::disk('public')->delete($log->foto_keberangkatan);
        }
        if ($log->foto_kembali && Storage::disk('public')->exists($log->foto_kembali)) {
            Storage::disk('public')->delete($log->foto_kembali);
        }

        $nama = $log->nama;
        $log->delete();

        if (auth()->check()) {
            ActivityLog::create([
                'user_id'   => auth()->id(),
                'user_name' => auth()->user()->name,
                'user_role' => auth()->user()->role,
                'modul'     => 'log pergerakan',
                'aksi'      => 'hapus',
                'deskripsi' => "Menghapus riwayat log pergerakan untuk {$nama}",
            ]);
        }

        return redirect()->back()->with('success', "Log pergerakan {$nama} berhasil dihapus.");
    }
}
