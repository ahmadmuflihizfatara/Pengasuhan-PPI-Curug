<?php

namespace App\Http\Controllers;

use App\Models\LogPergerakan;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\ActivityLog;
use App\Traits\SortsQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LogPergerakanController extends Controller
{
    use SortsQuery;

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

        // Filter Validasi
        if ($request->filled('validasi')) {
            $query->where('is_validated', $request->validasi === 'tervalidasi');
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

        $this->applySort($query, $request, ['nama' => 'nama', 'kategori' => 'kategori', 'berangkat' => 'waktu_berangkat', 'kembali' => 'waktu_kembali', 'status' => 'status', 'validasi' => 'is_validated']);
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
            'belum_validasi' => LogPergerakan::where('is_validated', false)->count(),
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
     * Tampilan Mandiri Taruna: input izin keluar & konfirmasi kembali sendiri.
     * Pengasuh tidak lagi input manual — hanya memvalidasi (lihat index/show).
     */
    public function mandiri(Request $request)
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $activeLog = LogPergerakan::where('user_id', $user->id)
            ->where('status', LogPergerakan::STATUS_BERANGKAT)
            ->latest('waktu_berangkat')
            ->first();

        $riwayat = LogPergerakan::where('user_id', $user->id)
            ->latest('waktu_berangkat')
            ->take(5)
            ->get();

        $identitas = [
            'nama'  => $user->name,
            'npm'   => $mahasiswa->npm ?? null,
            'prodi' => $mahasiswa->prodi ?? $user->prodi ?? null,
        ];

        return view('log-pergerakan.mandiri', compact('activeLog', 'riwayat', 'identitas'));
    }

    /**
     * Simpan Log Keberangkatan Baru.
     * Taruna: identitas dikunci ke akun sendiri (anti-impersonasi).
     * Admin: input manual via mode tablet (identitas bebas diisi/dicari).
     */
    public function store(Request $request)
    {
        $isTaruna = auth()->user()->hasTarunaAccess();

        $rules = [
            'kategori'           => 'required|in:perizinan,ekstrakurikuler,olahraga',
            'subkategori'        => 'required|string|max:100',
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
        ];

        if (!$isTaruna) {
            $rules['nama']  = 'required|string|max:255';
            $rules['npm']   = 'nullable|string|max:50';
            $rules['prodi'] = 'nullable|string|max:100';
        }

        $validated = $request->validate($rules);

        if ($isTaruna) {
            // Taruna hanya boleh input untuk dirinya sendiri, satu izin aktif dalam satu waktu
            $user = auth()->user();
            $sudahAktif = LogPergerakan::where('user_id', $user->id)
                ->where('status', LogPergerakan::STATUS_BERANGKAT)
                ->exists();

            if ($sudahAktif) {
                return redirect()->back()->with('error', 'Anda masih memiliki izin keluar yang belum ditandai kembali. Selesaikan itu dulu sebelum mengajukan izin baru.');
            }

            $mahasiswa = $user->mahasiswa;
            $validated['user_id'] = $user->id;
            $validated['nama']    = $user->name;
            $validated['npm']     = $mahasiswa->npm ?? null;
            $validated['prodi']   = $mahasiswa->prodi ?? $user->prodi ?? null;
        }

        // Upload Foto Keberangkatan jika ada
        if ($request->hasFile('foto_keberangkatan')) {
            $path = $request->file('foto_keberangkatan')->store('log_pergerakan', 'public');
            $validated['foto_keberangkatan'] = $path;
        }

        // Cari user_id jika ada relasi user (npm ada di tabel mahasiswa, bukan users) — hanya untuk input manual admin
        if (!$isTaruna && !empty($validated['npm'])) {
            $mahasiswa = Mahasiswa::where('npm', $validated['npm'])->first();
            if ($mahasiswa) {
                $validated['user_id'] = $mahasiswa->user_id;
                if (empty($validated['prodi']) && !empty($mahasiswa->prodi)) {
                    $validated['prodi'] = $mahasiswa->prodi;
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

        if (auth()->user()->hasTarunaAccess() && $log->user_id !== auth()->id()) {
            abort(403, 'Anda hanya bisa mengubah status kepulangan izin milik sendiri.');
        }

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
     * Validasi (audit) log oleh Pengasuh/Admin. Toggle: validasi <-> batalkan validasi.
     * Pengasuh berperan sebagai validator saja, bukan penginput data.
     */
    public function validasi(Request $request, $id)
    {
        $log = LogPergerakan::findOrFail($id);

        if ($log->is_validated) {
            $log->is_validated = false;
            $log->validated_by = null;
            $log->validated_at = null;
            $pesan = "Validasi untuk {$log->nama} dibatalkan.";
            $aksi  = 'batal validasi';
        } else {
            $log->is_validated = true;
            $log->validated_by = auth()->id();
            $log->validated_at = Carbon::now();
            $pesan = "Log pergerakan {$log->nama} telah divalidasi.";
            $aksi  = 'validasi';
        }

        $log->save();

        if (auth()->check()) {
            ActivityLog::create([
                'user_id'   => auth()->id(),
                'user_name' => auth()->user()->name,
                'user_role' => auth()->user()->role,
                'modul'     => 'log pergerakan',
                'aksi'      => $aksi,
                'deskripsi' => "Memvalidasi log pergerakan untuk {$log->nama} ({$log->kategori})",
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $pesan, 'data' => $log]);
        }

        return redirect()->back()->with('success', $pesan);
    }

    /**
     * Detail Modal / Halaman Satu Log
     */
    public function show($id)
    {
        $log = LogPergerakan::with(['user', 'creator', 'verifier', 'validator'])->findOrFail($id);
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
