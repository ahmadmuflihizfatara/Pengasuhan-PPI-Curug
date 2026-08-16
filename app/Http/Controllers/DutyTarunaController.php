<?php

namespace App\Http\Controllers;

use App\Models\AksesFitur;
use App\Models\DutyTaruna;
use App\Models\Mahasiswa;
use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DutyTarunaController extends Controller
{
    use LogsActivity;

    /**
     * Daftar duty taruna per minggu — minggu ini dan minggu-minggu sebelumnya.
     */
    public function index(Request $request): View
    {
        $mingguIni = DutyTaruna::awalMinggu();

        // Minggu yang dipilih tidak boleh melewati minggu berjalan
        $dipilih = $request->filled('minggu')
            ? DutyTaruna::awalMinggu(Carbon::parse($request->get('minggu')))
            : $mingguIni;
        if ($dipilih->gt($mingguIni)) {
            $dipilih = $mingguIni;
        }

        $duty = DutyTaruna::with('mahasiswa.user', 'penginput')
            ->whereDate('minggu_mulai', $dipilih)
            ->get()
            ->sortBy(fn ($d) => $d->mahasiswa->nama ?? '')
            ->values();

        // Riwayat minggu yang sudah terisi (untuk dropdown), terbaru dulu
        $riwayat = DutyTaruna::selectRaw('minggu_mulai, count(*) as jumlah')
            ->groupBy('minggu_mulai')
            ->orderByDesc('minggu_mulai')
            ->get()
            ->map(fn ($r) => [
                'minggu' => Carbon::parse($r->minggu_mulai),
                'jumlah' => (int) $r->jumlah,
            ]);

        return view('jadwal.duty', [
            'dipilih'       => $dipilih,
            'mingguIni'     => $mingguIni,
            'duty'          => $duty,
            'riwayat'       => $riwayat,
            'daftarTaruna'  => Mahasiswa::orderBy('nama')->get(['id', 'nama', 'npm', 'prodi', 'tingkat']),
            'bolehIsi'      => AksesFitur::diizinkan(AksesFitur::DUTY_TARUNA),
            'jumlahWajib'   => DutyTaruna::JUMLAH_PER_MINGGU,
        ]);
    }

    /**
     * Simpan 11 taruna duty untuk satu minggu (replace penuh).
     */
    public function store(Request $request): RedirectResponse
    {
        if (!AksesFitur::diizinkan(AksesFitur::DUTY_TARUNA)) {
            return back()->with('error', 'Akses pengisian duty taruna sedang ditutup oleh admin.');
        }

        $jumlah = DutyTaruna::JUMLAH_PER_MINGGU;

        $data = $request->validate([
            'minggu_mulai'   => ['required', 'date'],
            'mahasiswa_id'   => ['required', 'array', "size:{$jumlah}"],
            'mahasiswa_id.*' => ['required', 'distinct', 'exists:mahasiswa,id'],
        ], [
            'mahasiswa_id.size'       => "Duty taruna harus tepat {$jumlah} orang.",
            'mahasiswa_id.*.required' => 'Semua baris taruna wajib diisi.',
            'mahasiswa_id.*.distinct' => 'Taruna tidak boleh dipilih lebih dari sekali dalam satu minggu.',
            'mahasiswa_id.*.exists'   => 'Nama taruna tidak ditemukan di database mahasiswa.',
        ]);

        $minggu = DutyTaruna::awalMinggu(Carbon::parse($data['minggu_mulai']));

        if ($minggu->gt(DutyTaruna::awalMinggu())) {
            return back()->withInput()->withErrors(['minggu_mulai' => 'Duty tidak dapat diisi untuk minggu yang belum berjalan.']);
        }

        // Replace penuh: hapus isian lama minggu itu, lalu simpan yang baru
        DutyTaruna::whereDate('minggu_mulai', $minggu)->delete();

        foreach ($data['mahasiswa_id'] as $mahasiswaId) {
            DutyTaruna::create([
                'minggu_mulai' => $minggu,
                'mahasiswa_id' => $mahasiswaId,
                'diinput_oleh' => auth()->id(),
            ]);
        }

        $this->logActivity(
            modul: 'duty',
            aksi: 'isi',
            deskripsi: "Isi duty taruna minggu " . DutyTaruna::labelPeriode($minggu) . " — {$jumlah} taruna",
            detail: ['minggu_mulai' => $minggu->format('Y-m-d'), 'mahasiswa_id' => $data['mahasiswa_id']]
        );

        return redirect()->route('duty.index', ['minggu' => $minggu->format('Y-m-d')])
            ->with('success', 'Duty taruna minggu ' . DutyTaruna::labelPeriode($minggu) . ' berhasil disimpan.');
    }
}
