<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Mahasiswa;
use App\Models\PoinMahasiswa;
use App\Traits\LogsActivity;
use Carbon\Carbon;

class PoinController extends Controller
{
    use LogsActivity;

    /**
     * Halaman POIN Taruna (Sesuai Diagram Alur Proses Pengusulan Poin & Tindakan)
     */
    public function index(Request $request): View
    {
        $allMahasiswa  = Mahasiswa::with('user')->orderBy('kelas')->orderBy('nama')->get();
        $flatMahasiswa = $allMahasiswa;

        $user = auth()->user();

        // ====================================================
        // 1. ROLE TARUNA: Auto-load raport poin miliknya sendiri
        // ====================================================
        if ($user->isTaruna()) {
            $selectedStudent = Mahasiswa::where('user_id', $user->id)->first();

            $riwayatPelanggaran = collect();
            $riwayatPenghargaan = collect();
            $totalPelanggaran   = 0;
            $totalPenghargaan   = 0;
            $statusSanksi       = PoinMahasiswa::getStatusSanksi(0);

            if ($selectedStudent) {
                // Poin Pelanggaran yang Tervalidasi (Approved)
                $riwayatPelanggaran = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
                    ->where('kategori', PoinMahasiswa::KAT_PELANGGARAN)
                    ->where('status_validasi', PoinMahasiswa::STATUS_DISETUJUI)
                    ->orderByDesc('tanggal')
                    ->orderByDesc('created_at')
                    ->get();
                
                // Total akumulasi pelanggaran (-)
                $totalPelanggaran = $riwayatPelanggaran->sum('nilai');

                // Poin Penghargaan yang Tervalidasi (Approved)
                $riwayatPenghargaan = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
                    ->where('kategori', PoinMahasiswa::KAT_PRESTASI)
                    ->where('status_validasi', PoinMahasiswa::STATUS_DISETUJUI)
                    ->orderByDesc('tanggal')
                    ->orderByDesc('created_at')
                    ->get();
                
                // Total akumulasi penghargaan (+) - TIDAK MENGURANGI PELANGGARAN
                $totalPenghargaan = $riwayatPenghargaan->sum('nilai');

                // Status Sanksi berdasarkan Total Poin Pelanggaran
                $statusSanksi = PoinMahasiswa::getStatusSanksi($totalPelanggaran);
            }

            return view('poin.taruna', compact(
                'allMahasiswa',
                'flatMahasiswa',
                'selectedStudent',
                'riwayatPelanggaran',
                'riwayatPenghargaan',
                'totalPelanggaran',
                'totalPenghargaan',
                'statusSanksi'
            ) + ['selectedNpm' => $selectedStudent->npm ?? null]);
        }

        // ====================================================
        // 2. ROLE PENGASUH / ADMIN: Manajemen & Pengusulan Poin
        // ====================================================
        $selectedNpm     = $request->get('npm');
        $selectedStudent = null;
        
        $riwayatPelanggaran = collect();
        $riwayatPenghargaan = collect();
        $riwayatPending     = collect();
        $totalPelanggaran   = 0;
        $totalPenghargaan   = 0;
        $statusSanksi       = PoinMahasiswa::getStatusSanksi(0);

        if ($selectedNpm) {
            $selectedStudent = $allMahasiswa->firstWhere('npm', $selectedNpm);

            if ($selectedStudent) {
                // Pelanggaran Tervalidasi
                $riwayatPelanggaran = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
                    ->where('kategori', PoinMahasiswa::KAT_PELANGGARAN)
                    ->where('status_validasi', PoinMahasiswa::STATUS_DISETUJUI)
                    ->orderByDesc('tanggal')
                    ->orderByDesc('created_at')
                    ->get();
                $totalPelanggaran = $riwayatPelanggaran->sum('nilai');

                // Penghargaan Tervalidasi
                $riwayatPenghargaan = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
                    ->where('kategori', PoinMahasiswa::KAT_PRESTASI)
                    ->where('status_validasi', PoinMahasiswa::STATUS_DISETUJUI)
                    ->orderByDesc('tanggal')
                    ->orderByDesc('created_at')
                    ->get();
                $totalPenghargaan = $riwayatPenghargaan->sum('nilai');

                // Usulan yang masih Menunggu Validasi untuk taruna ini
                $riwayatPending = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
                    ->where('status_validasi', PoinMahasiswa::STATUS_MENUNGGU)
                    ->orderByDesc('created_at')
                    ->get();

                // Status Sanksi Murni dari Poin Pelanggaran
                $statusSanksi = PoinMahasiswa::getStatusSanksi($totalPelanggaran);
            }
        }

        // Daftar Semua Usulan Menunggu Validasi (Untuk Admin & Pengasuh)
        $allPendingValidation = PoinMahasiswa::with(['mahasiswa', 'pengaju'])
            ->where('status_validasi', PoinMahasiswa::STATUS_MENUNGGU)
            ->latest()
            ->get();

        // Master Data PTTT
        $masterPelanggaran = PoinMahasiswa::getMasterPelanggaran();
        $masterPenghargaan = PoinMahasiswa::getMasterPenghargaan();

        return view('poin.index', compact(
            'allMahasiswa',
            'flatMahasiswa',
            'selectedStudent',
            'selectedNpm',
            'riwayatPelanggaran',
            'riwayatPenghargaan',
            'riwayatPending',
            'totalPelanggaran',
            'totalPenghargaan',
            'statusSanksi',
            'allPendingValidation',
            'masterPelanggaran',
            'masterPenghargaan'
        ));
    }

    /**
     * Pengusulan / Input Poin Baru
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'npm'        => 'required|string',
            'kategori'   => 'required|in:prestasi,pelanggaran',
            'tingkat'    => 'nullable|string|max:50',
            'kegiatan'   => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'nilai'      => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:1000',
            'foto_bukti' => 'nullable|image|max:5120',
        ]);

        $student = Mahasiswa::where('npm', $request->npm)->first();

        if (!$student) {
            return back()->withErrors(['npm' => 'Taruna/Mahasiswa tidak ditemukan'])->withInput();
        }

        $user = auth()->user();
        $pengasuhName = $user->name;

        // Tentukan Nilai Otomatis sesuai PTTT jika pelanggaran
        $nilai = abs((float)$request->nilai);
        if ($request->kategori === 'pelanggaran') {
            if ($request->tingkat === 'ringan') $nilai = 5;
            elseif ($request->tingkat === 'sedang') $nilai = 20;
            elseif ($request->tingkat === 'berat') $nilai = 50;
        }

        // Upload Foto Bukti jika ada
        $fotoBuktiPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoBuktiPath = $request->file('foto_bukti')->store('bukti_poin', 'public');
        }

        // Alur Validasi:
        // Jika diinput oleh Admin -> Langsung Disetujui (Tervalidasi)
        // Jika diinput oleh Pengasuh -> Menunggu Validasi Admin Pusbangkar
        $statusValidasi = $user->canManageSystem() ? PoinMahasiswa::STATUS_DISETUJUI : PoinMahasiswa::STATUS_MENUNGGU;
        $divalidasiOleh = $user->canManageSystem() ? $user->id : null;
        $waktuValidasi  = $user->canManageSystem() ? Carbon::now() : null;

        $poin = PoinMahasiswa::create([
            'mahasiswa_id'       => $student->id,
            'npm'                => $student->npm,
            'nama_mahasiswa'     => $student->nama,
            'kelas'              => $student->kelas,
            'kategori'           => $request->kategori,
            'tingkat'            => $request->tingkat,
            'kegiatan'           => $request->kegiatan,
            'tanggal'            => $request->tanggal,
            'nilai'              => $nilai,
            'status_validasi'    => $statusValidasi,
            'pengasuh'           => $pengasuhName,
            'diajukan_oleh_id'   => $user->id,
            'divalidasi_oleh_id' => $divalidasiOleh,
            'waktu_validasi'     => $waktuValidasi,
            'foto_bukti'         => $fotoBuktiPath,
            'keterangan'         => $request->keterangan,
        ]);

        // Activity Log
        $kategoriLabel = $request->kategori === 'prestasi' ? 'Penghargaan (+)' : 'Pelanggaran (-)';
        $statusInfo    = $statusValidasi === PoinMahasiswa::STATUS_DISETUJUI ? 'langsung divalidasi' : 'menunggu validasi Admin Pusbangkar';
        
        $this->logActivity(
            modul: 'poin',
            aksi: 'tambah',
            deskripsi: "Pengusulan poin {$kategoriLabel} ({$request->tingkat}) untuk {$student->nama} — {$request->kegiatan} [{$nilai} poin] ({$statusInfo})",
            detail: [
                'npm'             => $student->npm,
                'nama_mahasiswa'  => $student->nama,
                'kategori'        => $request->kategori,
                'tingkat'         => $request->tingkat,
                'kegiatan'        => $request->kegiatan,
                'nilai'           => $nilai,
                'status_validasi' => $statusValidasi,
            ],
            subject: $poin
        );

        $successMsg = $statusValidasi === PoinMahasiswa::STATUS_DISETUJUI
            ? "Poin {$kategoriLabel} berhasil ditambahkan dan tervalidasi ke akumulasi {$student->nama}!"
            : "Usulan temuan {$kategoriLabel} berhasil diajukan! Status: Menunggu Validasi Admin Pusbangkar.";

        return redirect()->route('poin.index', ['npm' => $request->npm])
            ->with('success', $successMsg);
    }

    /**
     * Validasi Usulan Poin oleh Admin Pusbangkar (Approve / Reject)
     */
    public function validasi(Request $request, int $id): RedirectResponse
    {
        $poin = PoinMahasiswa::findOrFail($id);

        $request->validate([
            'aksi'             => 'required|in:setujui,tolak',
            'catatan_validasi' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();

        if ($request->aksi === 'setujui') {
            $poin->status_validasi    = PoinMahasiswa::STATUS_DISETUJUI;
            $poin->divalidasi_oleh_id = $user->id;
            $poin->waktu_validasi     = Carbon::now();
            $poin->catatan_validasi   = $request->catatan_validasi;
            $poin->save();

            $msg = "Usulan poin untuk {$poin->nama_mahasiswa} berhasil DIVALIDASI dan resmi ditambahkan ke akumulasi!";
            $aksiLog = 'validasi_setujui';
        } else {
            $poin->status_validasi    = PoinMahasiswa::STATUS_DITOLAK;
            $poin->divalidasi_oleh_id = $user->id;
            $poin->waktu_validasi     = Carbon::now();
            $poin->catatan_validasi   = $request->catatan_validasi ?? 'Ditolak oleh Admin Pusbangkar';
            $poin->save();

            $msg = "Usulan poin untuk {$poin->nama_mahasiswa} telah DITOLAK.";
            $aksiLog = 'validasi_tolak';
        }

        // Activity Log
        $this->logActivity(
            modul: 'poin',
            aksi: $aksiLog,
            deskripsi: "Admin memvalidasi usulan poin {$poin->kategori} {$poin->nama_mahasiswa} ({$poin->status_validasi})",
            detail: [
                'poin_id'          => $poin->id,
                'status_validasi'  => $poin->status_validasi,
                'catatan_validasi' => $poin->catatan_validasi,
            ],
            subject: $poin
        );

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Hapus Poin (Admin / Pengasuh)
     */
    public function destroy(int $id): RedirectResponse
    {
        $poin = PoinMahasiswa::findOrFail($id);
        $npm  = $poin->npm;

        $kategoriLabel = $poin->kategori === 'prestasi' ? 'Penghargaan' : 'Pelanggaran';
        $this->logActivity(
            modul: 'poin',
            aksi: 'hapus',
            deskripsi: "Hapus data poin {$kategoriLabel} milik {$poin->nama_mahasiswa} (NPM: {$npm}) — {$poin->kegiatan}",
            detail: [
                'npm'            => $poin->npm,
                'nama_mahasiswa' => $poin->nama_mahasiswa,
                'kategori'       => $poin->kategori,
                'nilai'          => $poin->nilai,
            ],
            subject: $poin
        );

        $poin->delete();

        return redirect()->route('poin.index', ['npm' => $npm])
            ->with('success', 'Data poin berhasil dihapus.');
    }

    /**
     * API untuk Widget / Mobile Poin
     */
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
                'error'   => 'Data mahasiswa tidak ditemukan'
            ]);
        }

        $riwayatPelanggaran = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
            ->where('kategori', PoinMahasiswa::KAT_PELANGGARAN)
            ->where('status_validasi', PoinMahasiswa::STATUS_DISETUJUI)
            ->orderByDesc('tanggal')
            ->get();
        $totalPelanggaran = $riwayatPelanggaran->sum('nilai');

        $riwayatPenghargaan = PoinMahasiswa::where('mahasiswa_id', $selectedStudent->id)
            ->where('kategori', PoinMahasiswa::KAT_PRESTASI)
            ->where('status_validasi', PoinMahasiswa::STATUS_DISETUJUI)
            ->orderByDesc('tanggal')
            ->get();
        $totalPenghargaan = $riwayatPenghargaan->sum('nilai');

        $statusSanksi = PoinMahasiswa::getStatusSanksi($totalPelanggaran);

        return response()->json([
            'success'            => true,
            'totalPelanggaran'   => $totalPelanggaran,
            'totalPenghargaan'   => $totalPenghargaan,
            'statusSanksi'       => $statusSanksi,
            'riwayatPelanggaran' => $riwayatPelanggaran,
            'riwayatPenghargaan' => $riwayatPenghargaan,
            'student'            => $selectedStudent,
        ]);
    }
}
