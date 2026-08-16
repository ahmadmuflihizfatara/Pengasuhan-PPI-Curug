<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
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

        $logs = $query->paginate(20)->withQueryString();

        // Statistik ringkasan
        $stats = [
            'total'   => ActivityLog::count(),
            'poin'    => ActivityLog::where('modul', 'poin')->count(),
            'acara'   => ActivityLog::where('modul', 'acara')->count(),
            'surat'   => ActivityLog::where('modul', 'surat')->count(),
            'berita'  => ActivityLog::where('modul', 'berita')->count(),
            'hari_ini'=> ActivityLog::whereDate('created_at', today())->count(),
        ];

        // Daftar user untuk filter dropdown
        $users = User::whereIn('role', ['pengasuh', 'admin'])
                     ->orderBy('name')
                     ->get(['id', 'name', 'role']);

        return view('activity-log.index', compact('logs', 'stats', 'users'));
    }
}
