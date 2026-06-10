<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class SuratTarunaController extends Controller
{
    use LogsActivity;

    /**
     * Daftar pengajuan surat milik taruna yang sedang login
     */
    public function index()
    {
        $user  = auth()->user();
        $surat = Surat::where('user_id', $user->id)
            ->latest()
            ->get();

        // Tandai semua notifikasi sebagai sudah dibaca saat buka halaman ini
        Surat::where('user_id', $user->id)
            ->where('taruna_baca', false)
            ->whereIn('status', ['Disetujui', 'Ditolak'])
            ->update(['taruna_baca' => true]);

        return view('surat.taruna.index', compact('surat'));
    }

    /**
     * Form pengajuan surat baru
     */
    public function create()
    {
        $jenisList = Surat::jenisSuratList();
        return view('surat.taruna.create', compact('jenisList'));
    }

    /**
     * Simpan pengajuan surat baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'jenis_surat' => 'required|string',
            'perihal'     => 'required|string|max:255',
            'keterangan'  => 'nullable|string',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('surat', 'public');
        }

        $surat = Surat::create([
            'user_id'      => $user->id,
            'diajukan_oleh'=> $user->name,
            'jenis_surat'  => $validated['jenis_surat'],
            'perihal'      => $validated['perihal'],
            'pengirim'     => $user->name,
            'penerima'     => 'Satuan Pengasuhan',
            'tanggal_surat'=> now()->toDateString(),
            'status'       => 'Diproses',
            'keterangan'   => $validated['keterangan'] ?? null,
            'file_path'    => $filePath,
            'taruna_baca'  => true,
        ]);

        $this->logActivity(
            modul: 'surat',
            aksi: 'ajukan',
            deskripsi: "Taruna \"{$user->name}\" mengajukan {$surat->jenis_surat}: \"{$surat->perihal}\"",
            detail: [
                'jenis_surat' => $surat->jenis_surat,
                'perihal'     => $surat->perihal,
                'pengirim'    => $surat->pengirim,
            ],
            subject: $surat
        );

        return redirect()->route('surat-taruna.index')
            ->with('success', 'Pengajuan surat berhasil dikirim! Silakan tunggu konfirmasi dari satuan pengasuhan.');
    }

    /**
     * Detail pengajuan surat taruna
     */
    public function show(Surat $surat)
    {
        $user = auth()->user();

        // Pastikan surat ini milik taruna yang login
        if ($surat->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak melihat surat ini.');
        }

        // Tandai sudah dibaca jika belum
        if (!$surat->taruna_baca && in_array($surat->status, ['Disetujui', 'Ditolak'])) {
            $surat->update(['taruna_baca' => true]);
        }

        return view('surat.taruna.show', compact('surat'));
    }

    /**
     * API: cek apakah ada notifikasi surat yang belum dibaca (untuk polling)
     */
    public function notifications()
    {
        $user = auth()->user();

        $unread = Surat::where('user_id', $user->id)
            ->where('taruna_baca', false)
            ->whereIn('status', ['Disetujui', 'Ditolak'])
            ->get()
            ->map(fn($s) => [
                'id'     => $s->id,
                'perihal'=> $s->perihal,
                'status' => $s->status,
            ]);

        return response()->json([
            'count'       => $unread->count(),
            'unread'      => $unread,
        ]);
    }
}
