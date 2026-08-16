<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Mahasiswa;
use App\Models\PoinMahasiswa;
use App\Traits\LogsActivity; // <-- TAMBAHAN

class PoinController extends Controller
{
    use LogsActivity; // <-- TAMBAHAN

    public function index(Request $request): View
    {
        $allMahasiswa  = Mahasiswa::with('user')->orderBy('kelas')->orderBy('nama')->get();
        $flatMahasiswa = $allMahasiswa;

        $user = auth()->user();

        // ====================================================
        // TARUNA: auto-load poin miliknya sendiri berdasarkan
        // akun user yang terhubung ke data mahasiswa
        // ====================================================
        if ($user->isTaruna()) {
            $selectedStudent = Mahasiswa::where('user_id', $user->id)->first();

            $riwayat   = collect();
            $totalPoin = 0;

            if ($selectedStudent) {
                $riwayat   = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
                    ->orderByDesc('tanggal')
                    ->orderByDesc('created_at')
                    ->get();
                $totalPoin = $riwayat->sum('nilai_efektif');
            }

            return view('poin.taruna', compact(
                'allMahasiswa',
                'flatMahasiswa',
                'selectedStudent',
                'riwayat',
                'totalPoin'
            ) + ['selectedNpm' => $selectedStudent->npm ?? null]);
        }

        // ====================================================
        // PENGASUH / PENYELENGGARA: pilih mahasiswa secara bebas
        // ====================================================
        $selectedNpm     = $request->get('npm');
        $selectedStudent = null;
        $riwayat         = collect();
        $totalPoin       = 0;

        if ($selectedNpm) {
            $selectedStudent = $allMahasiswa->firstWhere('npm', $selectedNpm);

            if ($selectedStudent) {
                $riwayat   = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
                    ->orderByDesc('tanggal')
                    ->orderByDesc('created_at')
                    ->get();
                $totalPoin = $riwayat->sum('nilai_efektif');
            }
        }

        return view('poin.index', compact(
            'allMahasiswa',
            'flatMahasiswa',
            'selectedStudent',
            'selectedNpm',
            'riwayat',
            'totalPoin'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'npm'        => 'required|string',
            'kategori'   => 'required|in:prestasi,pelanggaran',
            'kegiatan'   => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'nilai'      => 'required|numeric|min:0.001',
            'pengasuh'   => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $student = Mahasiswa::where('npm', $request->npm)->first();

        if (!$student) {
            return back()->withErrors(['npm' => 'Mahasiswa tidak ditemukan'])->withInput();
        }

        $pengasuhName = auth()->user()->name;

        $poin = PoinMahasiswa::create([
            'mahasiswa_id'   => $student->id,
            'npm'            => $student->npm,
            'nama_mahasiswa' => $student->nama,
            'kelas'          => $student->kelas,
            'kategori'       => $request->kategori,
            'kegiatan'       => $request->kegiatan,
            'tanggal'        => $request->tanggal,
            'nilai'          => abs((float)$request->nilai),
            'pengasuh'       => $pengasuhName,
            'keterangan'     => $request->keterangan,
        ]);

        // ========== ACTIVITY LOG ==========
        $kategoriLabel = $request->kategori === 'prestasi' ? 'Prestasi' : 'Pelanggaran';
        $this->logActivity(
            modul: 'poin',
            aksi: 'tambah',
            deskripsi: "Tambah poin {$kategoriLabel} untuk {$student->nama} (NPM: {$request->npm}) — Kegiatan: {$request->kegiatan}, Nilai: {$request->nilai}",
            detail: [
                'npm'            => $student->npm,
                'nama_mahasiswa' => $student->nama,
                'kelas'          => $student->kelas,
                'kategori'       => $request->kategori,
                'kegiatan'       => $request->kegiatan,
                'nilai'          => abs((float)$request->nilai),
                'tanggal'        => $request->tanggal,
                'pengasuh'       => $pengasuhName,
            ],
            subject: $poin
        );
        // ==================================

        return redirect()->route('poin.index', ['npm' => $request->npm])
            ->with('success', 'Poin berhasil ditambahkan!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $poin = PoinMahasiswa::findOrFail($id);
        $npm  = $poin->npm;

        // ========== ACTIVITY LOG ==========
        $kategoriLabel = $poin->kategori === 'prestasi' ? 'Prestasi' : 'Pelanggaran';
        $this->logActivity(
            modul: 'poin',
            aksi: 'hapus',
            deskripsi: "Hapus poin {$kategoriLabel} milik {$poin->nama_mahasiswa} (NPM: {$npm}) — Kegiatan: {$poin->kegiatan}, Nilai: {$poin->nilai}",
            detail: [
                'npm'            => $poin->npm,
                'nama_mahasiswa' => $poin->nama_mahasiswa,
                'kelas'          => $poin->kelas,
                'kategori'       => $poin->kategori,
                'kegiatan'       => $poin->kegiatan,
                'nilai'          => $poin->nilai,
                'tanggal'        => $poin->tanggal?->format('Y-m-d'),
                'pengasuh'       => $poin->pengasuh,
            ],
            subject: $poin
        );
        // ==================================

        $poin->delete();

        return redirect()->route('poin.index', ['npm' => $npm])
            ->with('success', 'Poin berhasil dihapus.');
    }

    public function myPointsApi(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $selectedStudent = Mahasiswa::where('user_id', $user->id)->first();

        if (!$selectedStudent) {
            return response()->json([
                'success' => false,
                'error' => 'Student data not found'
            ]);
        }

        $riwayat = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->get();

        $totalPoin = $riwayat->sum('nilai_efektif');
        $totalPrestasi = $riwayat->where('kategori', 'prestasi')->sum('nilai');
        $totalPelanggaran = $riwayat->where('kategori', 'pelanggaran')->sum('nilai');

        $formattedRiwayat = $riwayat->map(function ($r) {
            return [
                'id' => $r->id,
                'tanggal' => $r->tanggal->format('d M Y'),
                'kategori' => $r->kategori,
                'kegiatan' => $r->kegiatan,
                'nilai' => $r->nilai,
                'pengasuh' => $r->pengasuh,
                'keterangan' => $r->keterangan ?? '-',
            ];
        });

        return response()->json([
            'success' => true,
            'totalPoin' => $totalPoin,
            'totalPrestasi' => $totalPrestasi,
            'totalPelanggaran' => $totalPelanggaran,
            'riwayat' => $formattedRiwayat,
            'student' => $selectedStudent,
        ]);
    }
}
