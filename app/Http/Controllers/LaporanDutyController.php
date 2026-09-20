<?php

namespace App\Http\Controllers;

use App\Models\DutyTaruna;
use App\Models\LaporanDuty;
use App\Models\Mahasiswa;
use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Laporan taruna sakit harian.
 * Taruna duty minggu ini: lapor. Pengasuh/admin: lihat laporan masuk.
 */
class LaporanDutyController extends Controller
{
    use LogsActivity;

    public function index(Request $request): View
    {
        $user = auth()->user();

        // Taruna duty hanya boleh lihat hari ini; pengasuh/admin bisa pilih tanggal
        $tanggal = $user->isTaruna() || !$request->filled('tanggal')
            ? now()->startOfDay()
            : Carbon::parse($request->tanggal)->startOfDay();

        $laporan = LaporanDuty::with('mahasiswa', 'pelapor')
            ->whereDate('tanggal', $tanggal)
            ->orderByDesc('updated_at')
            ->get();

        return view('laporan-duty.index', [
            'tanggal'      => $tanggal,
            'laporan'      => $laporan,
            'daftarTaruna' => $user->isTaruna() ? Mahasiswa::orderBy('nama')->get(['id', 'nama', 'npm', 'prodi', 'tingkat']) : collect(),
            'dutyMinggu'   => DutyTaruna::with('mahasiswa')->whereDate('minggu_mulai', DutyTaruna::awalMinggu())->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mahasiswa_id' => ['required', 'exists:mahasiswa,id'],
            'keterangan'   => ['nullable', 'string', 'max:1000'],
        ], [
            'mahasiswa_id.required' => 'Pilih taruna dari database mahasiswa.',
            'mahasiswa_id.exists'   => 'Nama taruna tidak ditemukan di database mahasiswa.',
        ]);

        $laporan = LaporanDuty::updateOrCreate(
            ['tanggal' => now()->toDateString(), 'mahasiswa_id' => $data['mahasiswa_id']],
            ['keterangan' => $data['keterangan'] ?? null, 'dilaporkan_oleh' => auth()->id()]
        );
        $laporan->load('mahasiswa');

        $this->logActivity(
            modul: 'laporan_duty',
            aksi: $laporan->wasRecentlyCreated ? 'tambah' : 'ubah',
            deskripsi: "Laporan duty: {$laporan->mahasiswa->nama} sakit",
            detail: $data,
            subject: $laporan
        );

        return redirect()->route('laporan-duty.index')
            ->with('success', "Laporan {$laporan->mahasiswa->nama} sakit hari ini berhasil dikirim ke pengasuh.");
    }

    public function destroy(LaporanDuty $laporan): RedirectResponse
    {
        $user = auth()->user();

        // Taruna duty hanya boleh hapus laporannya sendiri hari ini
        if ($user->isTaruna() && ($laporan->dilaporkan_oleh !== $user->id || !$laporan->tanggal->isToday())) {
            abort(403, 'Anda hanya dapat menghapus laporan Anda sendiri hari ini.');
        }

        $laporan->load('mahasiswa');
        $nama = $laporan->mahasiswa->nama;

        $this->logActivity(
            modul: 'laporan_duty',
            aksi: 'hapus',
            deskripsi: "Hapus laporan duty {$nama} ({$laporan->tanggal->format('d/m/Y')})",
            detail: ['mahasiswa_id' => $laporan->mahasiswa_id, 'tanggal' => $laporan->tanggal->toDateString()],
        );

        $laporan->delete();

        return redirect()->route('laporan-duty.index', $user->isTaruna() ? [] : ['tanggal' => $laporan->tanggal->toDateString()])
            ->with('success', "Laporan {$nama} berhasil dihapus.");
    }
}
