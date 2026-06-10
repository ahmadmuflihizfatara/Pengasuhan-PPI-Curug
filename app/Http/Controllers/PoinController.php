<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\PoinMahasiswa;
use App\Http\Controllers\MahasiswaController;
use App\Traits\LogsActivity; // <-- TAMBAHAN

class PoinController extends Controller
{
    use LogsActivity; // <-- TAMBAHAN
    public function index(Request $request): View
    {
        $allMahasiswa = MahasiswaController::enrichMahasiswa(MahasiswaController::getAllMahasiswa());

        // Flatten for search/select
        $flatMahasiswa = [];
        foreach ($allMahasiswa as $kelas => $students) {
            foreach ($students as $s) {
                $flatMahasiswa[] = array_merge($s, ['kelas' => $kelas]);
            }
        }

        $user = auth()->user();

        // ====================================================
        // TARUNA: auto-load poin miliknya sendiri berdasarkan
        // username yang cocok dengan nickname di data mahasiswa
        // ====================================================
        if ($user->isTaruna()) {
            $selectedStudent = null;

            foreach ($flatMahasiswa as $m) {
                if (strtolower($m['nickname'] ?? '') === strtolower($user->username ?? '')
                    || strtolower($m['nickname'] ?? '') === strtolower($user->nama_panggilan ?? '')
                    || strtolower($m['npm'] ?? '') === strtolower($user->username ?? '')
                    || strtolower($m['email'] ?? '') === strtolower($user->email ?? ''))
                {
                    $selectedStudent = $m;
                    break;
                }
            }

            $riwayat   = collect();
            $totalPoin = 0;

            if ($selectedStudent) {
                $riwayat   = PoinMahasiswa::where('npm', $selectedStudent['npm'])
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
            ) + ['selectedNpm' => $selectedStudent['npm'] ?? null]);
        }

        // ====================================================
        // PENGASUH / PENYELENGGARA: pilih mahasiswa secara bebas
        // ====================================================
        $selectedNpm     = $request->get('npm');
        $selectedStudent = null;
        $riwayat         = collect();
        $totalPoin       = 0;

        if ($selectedNpm) {
            foreach ($flatMahasiswa as $m) {
                if ($m['npm'] === $selectedNpm) {
                    $selectedStudent = $m;
                    break;
                }
            }
            if ($selectedStudent) {
                $riwayat   = PoinMahasiswa::where('npm', $selectedNpm)
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
            'nilai'      => 'required|integer|min:1',
            'pengasuh'   => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Get student info
        $allMahasiswa = MahasiswaController::getAllMahasiswa();
        $student = null;
        $kelas = null;
        foreach ($allMahasiswa as $k => $students) {
            foreach ($students as $s) {
                if ($s['npm'] === $request->npm) {
                    $student = $s;
                    $kelas = $k;
                    break 2;
                }
            }
        }

        if (!$student) {
            return back()->withErrors(['npm' => 'Mahasiswa tidak ditemukan'])->withInput();
        }

        $poin = PoinMahasiswa::create([
            'npm'            => $request->npm,
            'nama_mahasiswa' => $student['nama'],
            'kelas'          => $kelas,
            'kategori'       => $request->kategori,
            'kegiatan'       => $request->kegiatan,
            'tanggal'        => $request->tanggal,
            'nilai'          => abs((int)$request->nilai),
            'pengasuh'       => $request->pengasuh,
            'keterangan'     => $request->keterangan,
        ]);

        // ========== ACTIVITY LOG ==========
        $kategoriLabel = $request->kategori === 'prestasi' ? 'Prestasi' : 'Pelanggaran';
        $this->logActivity(
            modul: 'poin',
            aksi: 'tambah',
            deskripsi: "Tambah poin {$kategoriLabel} untuk {$student['nama']} (NPM: {$request->npm}) — Kegiatan: {$request->kegiatan}, Nilai: {$request->nilai}",
            detail: [
                'npm'            => $request->npm,
                'nama_mahasiswa' => $student['nama'],
                'kelas'          => $kelas,
                'kategori'       => $request->kategori,
                'kegiatan'       => $request->kegiatan,
                'nilai'          => abs((int)$request->nilai),
                'tanggal'        => $request->tanggal,
                'pengasuh'       => $request->pengasuh,
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
}
