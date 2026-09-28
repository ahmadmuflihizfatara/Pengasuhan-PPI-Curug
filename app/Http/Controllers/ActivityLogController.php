<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Traits\SortsQuery;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    use SortsQuery;

    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter berdasarkan modul
        if ($request->filled('modul') && $request->modul !== 'semua') {
            $query->where('modul', $request->modul);
        }

        // Filter berdasarkan aksi
        if ($request->filled('aksi') && $request->aksi !== 'semua') {
            $query->where('aksi', $request->aksi);
        }

        // Filter berdasarkan user/pelaku
        if ($request->filled('user_id') && $request->user_id !== 'semua') {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan tanggal dari
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }

        // Filter berdasarkan tanggal sampai
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        // Pencarian teks bebas
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('deskripsi', 'like', "%{$s}%")
                  ->orWhere('user_name', 'like', "%{$s}%");
            });
        }

        $this->applySort($query, $request, ['waktu' => 'created_at', 'modul' => 'modul', 'aksi' => 'aksi', 'pelaku' => 'user_name']);
        $logs = $query->paginate(20)->withQueryString();

        // Statistik ringkasan
        $stats = [
            'total'       => ActivityLog::count(),
            'hari_ini'    => ActivityLog::whereDate('created_at', today())->count(),
            'minggu_ini'  => ActivityLog::where('created_at', '>=', today()->subDays(6))->count(),
            'pelaku_hari' => ActivityLog::whereDate('created_at', today())->distinct()->count('user_id'),
        ];

        // Pilihan filter diambil dari data yang benar-benar tercatat (semua modul & aksi, bukan daftar tetap)
        $modulList = ActivityLog::distinct()->orderBy('modul')->pluck('modul');
        $aksiList  = ActivityLog::distinct()->orderBy('aksi')->pluck('aksi');
        $users     = User::whereIn('id', ActivityLog::whereNotNull('user_id')->distinct()->select('user_id'))
                         ->orderBy('name')
                         ->get(['id', 'name', 'role']);

        return view('activity-log.index', compact('logs', 'stats', 'users', 'modulList', 'aksiList'));
    }
}
