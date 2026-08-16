<?php

namespace App\Http\Controllers;

use App\Models\JadwalPengasuh;
use App\Models\Pengasuh;
use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JadwalController extends Controller
{
    use LogsActivity;

    /**
     * Timeline jadwal pengasuh untuk satu bulan.
     * Hari yang belum di-generate tetap ditampilkan (pakai jadwal mingguan default),
     * ditandai belum tersimpan — supaya timeline selalu utuh sebulan penuh.
     */
    public function index(Request $request): View
    {
        $tahun = (int) $request->get('tahun', now()->year);
        $bulan = (int) $request->get('bulan', now()->month);

        $awalBulan   = Carbon::create($tahun, $bulan, 1);
        $jumlahHari  = $awalBulan->daysInMonth;
        $hariIniStr  = now()->format('Y-m-d');

        $tersimpan = JadwalPengasuh::with('pengasuh')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->keyBy(fn ($j) => $j->tanggal->format('Y-m-d'));

        $semuaPengasuh = Pengasuh::orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu','minggu')")->get();
        $pengasuhByHari = $semuaPengasuh->keyBy('hari');

        $timeline = collect(range(1, $jumlahHari))->map(function ($d) use ($awalBulan, $tersimpan, $pengasuhByHari, $hariIniStr) {
            $tanggal = $awalBulan->copy()->day($d);
            $key     = $tanggal->format('Y-m-d');
            $jadwal  = $tersimpan->get($key);
            $pengasuh = $jadwal?->pengasuh ?? $pengasuhByHari->get(Pengasuh::hariDari($tanggal));

            return [
                'tanggal'    => $tanggal,
                'pengasuh'   => $pengasuh,
                'catatan'    => $jadwal?->catatan,
                'tersimpan'  => (bool) $jadwal,
                'is_today'   => $key === $hariIniStr,
            ];
        });

        $petugasHariIni = $timeline->firstWhere('is_today', true);
        $sudahDigenerate = $tersimpan->count() >= $jumlahHari;

        return view('jadwal.index', [
            'timeline'         => $timeline,
            'petugasHariIni'   => $petugasHariIni,
            'semuaPengasuh'    => $semuaPengasuh,
            'bulan'            => $bulan,
            'tahun'            => $tahun,
            'sudahDigenerate'  => $sudahDigenerate,
        ]);
    }

    /**
     * Generate jadwal satu bulan dari roster mingguan (satu pengasuh per hari).
     * Tidak menimpa tanggal yang sudah punya jadwal manual/override.
     */
    public function generate(Request $request): RedirectResponse
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = (int) $request->input('bulan', now()->month);

        $awalBulan  = Carbon::create($tahun, $bulan, 1);
        $pengasuhByHari = Pengasuh::all()->keyBy('hari');

        $dibuat = 0;
        for ($d = 1; $d <= $awalBulan->daysInMonth; $d++) {
            $tanggal  = $awalBulan->copy()->day($d);
            $pengasuh = $pengasuhByHari->get(Pengasuh::hariDari($tanggal));

            if (!$pengasuh) {
                continue;
            }

            $jadwal = JadwalPengasuh::firstOrCreate(
                ['tanggal' => $tanggal->format('Y-m-d')],
                ['pengasuh_id' => $pengasuh->id]
            );
            if ($jadwal->wasRecentlyCreated) {
                $dibuat++;
            }
        }

        $this->logActivity(
            modul: 'jadwal',
            aksi: 'generate',
            deskripsi: "Generate jadwal pengasuh bulan {$awalBulan->locale('id')->isoFormat('MMMM Y')} — {$dibuat} hari dibuat",
            detail: ['bulan' => $bulan, 'tahun' => $tahun, 'dibuat' => $dibuat]
        );

        return redirect()->route('jadwal.index', ['bulan' => $bulan, 'tahun' => $tahun])
            ->with('success', "Jadwal berhasil digenerate — {$dibuat} hari baru ditambahkan.");
    }

    /**
     * Set/override pengasuh bertugas pada satu tanggal (mis. tukar jaga).
     */
    public function set(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tanggal'     => ['required', 'date'],
            'pengasuh_id' => ['required', Rule::exists('pengasuh', 'id')],
            'catatan'     => ['nullable', 'string', 'max:500'],
        ]);

        $jadwal = JadwalPengasuh::updateOrCreate(
            ['tanggal' => $data['tanggal']],
            ['pengasuh_id' => $data['pengasuh_id'], 'catatan' => $data['catatan'] ?? null]
        );

        $pengasuh = Pengasuh::find($data['pengasuh_id']);
        $this->logActivity(
            modul: 'jadwal',
            aksi: 'ubah',
            deskripsi: "Set jadwal pengasuh {$data['tanggal']} → {$pengasuh?->nama}" . ($data['catatan'] ?? false ? " ({$data['catatan']})" : ''),
            detail: $data,
            subject: $jadwal
        );

        $tgl = Carbon::parse($data['tanggal']);

        return redirect()->route('jadwal.index', ['bulan' => $tgl->month, 'tahun' => $tgl->year])
            ->with('success', 'Jadwal tanggal ' . $tgl->locale('id')->isoFormat('D MMMM Y') . ' berhasil diperbarui.');
    }
}
