<?php

namespace App\Http\Controllers;

use App\Models\AksesFitur;
use App\Models\DutyTaruna;
use App\Models\JadwalPengasuh;
use App\Models\Pengasuh;
use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JadwalController extends Controller
{
    use LogsActivity;

    /**
     * Timeline jadwal pengasuh untuk satu bulan — tiga pengasuh per hari.
     * Hari yang belum di-generate tetap ditampilkan (pakai alokasi mingguan default),
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
            ->groupBy(fn ($j) => $j->tanggal->format('Y-m-d'));

        $semuaPengasuh  = Pengasuh::urutHari()->get();
        $pengasuhByHari = $semuaPengasuh->whereNotNull('hari')->groupBy('hari');

        $timeline = collect(range(1, $jumlahHari))->map(function ($d) use ($awalBulan, $tersimpan, $pengasuhByHari, $hariIniStr) {
            $tanggal = $awalBulan->copy()->day($d);
            $key     = $tanggal->format('Y-m-d');
            $jadwal  = $tersimpan->get($key);

            $petugas = $jadwal
                ? $jadwal->map(fn ($j) => ['pengasuh' => $j->pengasuh, 'catatan' => $j->catatan])
                : $pengasuhByHari->get(Pengasuh::hariDari($tanggal), collect())
                    ->map(fn ($p) => ['pengasuh' => $p, 'catatan' => null]);

            return [
                'tanggal'   => $tanggal,
                'petugas'   => $petugas->sortBy(fn ($x) => $x['pengasuh']->nama)->values(),
                'tersimpan' => (bool) $jadwal,
                'is_today'  => $key === $hariIniStr,
            ];
        });

        return view('jadwal.index', [
            'timeline'         => $timeline,
            'petugasHariIni'   => $timeline->firstWhere('is_today', true),
            'semuaPengasuh'    => $semuaPengasuh,
            'pengasuhByHari'   => $pengasuhByHari,
            'bulan'            => $bulan,
            'tahun'            => $tahun,
            'sudahDigenerate'  => $tersimpan->count() >= $jumlahHari,
            'bolehIsi'         => AksesFitur::diizinkan(AksesFitur::JADWAL_PENGASUH),
            'bulanDepan'       => $this->melewatiBulanIni($tahun, $bulan),
        ]);
    }

    /**
     * Generate jadwal satu bulan dari alokasi mingguan (tiga pengasuh per hari).
     * Tidak menimpa tanggal yang sudah punya jadwal manual/override.
     * Hanya sampai bulan berjalan — bulan berikutnya belum boleh digenerate.
     */
    public function generate(Request $request): RedirectResponse
    {
        if (!AksesFitur::diizinkan(AksesFitur::JADWAL_PENGASUH)) {
            return back()->with('error', 'Akses pengisian jadwal pengasuh sedang ditutup oleh admin.');
        }

        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = (int) $request->input('bulan', now()->month);

        if ($this->melewatiBulanIni($tahun, $bulan)) {
            return back()->with('error', 'Jadwal hanya dapat digenerate sampai bulan berjalan.');
        }

        $awalBulan = Carbon::create($tahun, $bulan, 1);

        $dibuat = 0;
        for ($d = 1; $d <= $awalBulan->daysInMonth; $d++) {
            if ($this->isiDefault($awalBulan->copy()->day($d))) {
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
     * Tukar jaga: ganti satu dari tiga pengasuh bertugas pada satu tanggal.
     * Tanggal yang belum tersimpan diisi dulu dari alokasi default, lalu ditukar.
     */
    public function set(Request $request): RedirectResponse
    {
        if (!AksesFitur::diizinkan(AksesFitur::JADWAL_PENGASUH)) {
            return back()->with('error', 'Akses pengisian jadwal pengasuh sedang ditutup oleh admin.');
        }

        $data = $request->validate([
            'tanggal'     => ['required', 'date'],
            'ganti_id'    => ['nullable', Rule::exists('pengasuh', 'id')],
            'pengasuh_id' => ['required', Rule::exists('pengasuh', 'id')],
            'catatan'     => ['nullable', 'string', 'max:500'],
        ]);

        $tgl = Carbon::parse($data['tanggal']);
        if ($this->melewatiBulanIni($tgl->year, $tgl->month)) {
            return back()->with('error', 'Jadwal hanya dapat diatur sampai bulan berjalan.');
        }

        $this->isiDefault($tgl);
        $hariItu = fn () => JadwalPengasuh::whereDate('tanggal', $tgl);
        $gantiId = $data['ganti_id'] ?? null;

        if ((int) $data['pengasuh_id'] !== (int) $gantiId
            && $hariItu()->where('pengasuh_id', $data['pengasuh_id'])->exists()) {
            return back()->with('error', 'Pengasuh tersebut sudah bertugas pada tanggal ini.');
        }

        $jadwal = $gantiId ? $hariItu()->where('pengasuh_id', $gantiId)->first() : null;
        if (!$jadwal && $hariItu()->count() >= Pengasuh::PER_HARI) {
            return back()->with('error', 'Tanggal ini sudah terisi ' . Pengasuh::PER_HARI . ' pengasuh — pilih pengasuh yang ditukar.');
        }

        $jadwal ??= new JadwalPengasuh(['tanggal' => $tgl->format('Y-m-d')]);
        $jadwal->fill(['pengasuh_id' => $data['pengasuh_id'], 'catatan' => $data['catatan'] ?? null])->save();

        $pengasuh = Pengasuh::find($data['pengasuh_id']);
        $this->logActivity(
            modul: 'jadwal',
            aksi: 'ubah',
            deskripsi: "Set jadwal pengasuh {$data['tanggal']} → {$pengasuh?->nama}" . ($data['catatan'] ?? false ? " ({$data['catatan']})" : ''),
            detail: $data,
            subject: $jadwal
        );

        return redirect()->route('jadwal.index', ['bulan' => $tgl->month, 'tahun' => $tgl->year])
            ->with('success', 'Jadwal tanggal ' . $tgl->locale('id')->isoFormat('D MMMM Y') . ' berhasil diperbarui.');
    }

    /**
     * Alokasi pengasuh per hari (admin) — tetapkan tiga pengasuh default untuk tiap hari.
     * Berlaku untuk tanggal yang belum digenerate dan generate berikutnya.
     */
    public function alokasi(): View
    {
        $semuaPengasuh = Pengasuh::orderBy('nama')->get();

        return view('jadwal.alokasi', [
            'semuaPengasuh'  => $semuaPengasuh,
            'pengasuhByHari' => $semuaPengasuh->whereNotNull('hari')->groupBy('hari'),
        ]);
    }

    public function simpanAlokasi(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'alokasi'     => ['required', 'array'],
            'alokasi.*'   => ['array', 'max:' . Pengasuh::PER_HARI],
            'alokasi.*.*' => ['nullable', Rule::exists('pengasuh', 'id')],
        ]);

        $alokasi = collect($data['alokasi'])
            ->only(array_keys(Pengasuh::HARI))
            ->map(fn ($ids) => array_values(array_filter($ids)));

        $semuaId = $alokasi->flatten();
        if ($semuaId->count() !== $semuaId->unique()->count()) {
            return back()->withInput()->with('error', 'Satu pengasuh hanya bisa dialokasikan ke satu hari.');
        }

        DB::transaction(function () use ($alokasi) {
            Pengasuh::query()->update(['hari' => null]);
            foreach ($alokasi as $hari => $ids) {
                Pengasuh::whereIn('id', $ids)->update(['hari' => $hari]);
            }
        });

        $this->logActivity(
            modul: 'jadwal',
            aksi: 'ubah',
            deskripsi: 'Mengubah alokasi pengasuh per hari',
            detail: $alokasi->all()
        );

        return redirect()->route('jadwal.alokasi')->with('success', 'Alokasi pengasuh per hari berhasil disimpan.');
    }

    /**
     * Jadwal untuk taruna — hanya lihat: pengasuh bertugas hari ini + duty taruna minggu ini.
     */
    public function taruna(): View
    {
        $hariIni = now()->startOfDay();
        $jadwal  = JadwalPengasuh::with('pengasuh')->whereDate('tanggal', $hariIni)->get();
        $petugas = $jadwal->isNotEmpty()
            ? $jadwal->map(fn ($j) => ['pengasuh' => $j->pengasuh, 'catatan' => $j->catatan])
            : Pengasuh::bertugasPada($hariIni)->map(fn ($p) => ['pengasuh' => $p, 'catatan' => null]);

        $mingguIni = DutyTaruna::awalMinggu();
        $duty = DutyTaruna::with('mahasiswa')
            ->whereDate('minggu_mulai', $mingguIni)
            ->get()
            ->sortBy(fn ($d) => $d->mahasiswa->nama ?? '')
            ->values();

        return view('jadwal.taruna', [
            'hariIni'   => $hariIni,
            'petugas'   => $petugas->sortBy(fn ($x) => $x['pengasuh']->nama)->values(),
            'mingguIni' => $mingguIni,
            'duty'      => $duty,
        ]);
    }

    /**
     * Isi tanggal dari alokasi mingguan default bila belum punya jadwal tersimpan.
     * Mengembalikan true bila ada baris baru dibuat.
     */
    private function isiDefault(Carbon $tanggal): bool
    {
        if (JadwalPengasuh::whereDate('tanggal', $tanggal)->exists()) {
            return false;
        }

        $petugas = Pengasuh::bertugasPada($tanggal);
        foreach ($petugas as $p) {
            JadwalPengasuh::create(['tanggal' => $tanggal->format('Y-m-d'), 'pengasuh_id' => $p->id]);
        }

        return $petugas->isNotEmpty();
    }

    /** Bulan yang diminta melewati bulan berjalan? */
    private function melewatiBulanIni(int $tahun, int $bulan): bool
    {
        return Carbon::create($tahun, $bulan, 1)->gt(now()->startOfMonth());
    }
}
