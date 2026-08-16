<?php

namespace App\Http\Controllers;

use App\Models\Apel;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ApelController extends Controller
{
    use LogsActivity;

    /**
     * Daftar apel + detail apel terpilih.
     * Apel dipilih lewat dropdown (tanggal + sesi).
     */
    public function index(Request $request): View
    {
        $daftarApel = Apel::with('pembinaUser')->terbaru()->get();

        $terpilih = $request->filled('apel')
            ? $daftarApel->firstWhere('id', (int) $request->get('apel'))
            : $daftarApel->first();

        return view('apel.index', [
            'daftarApel' => $daftarApel,
            'terpilih'   => $terpilih,
        ]);
    }

    /**
     * Jadwal apel untuk taruna — hanya jadwal, pembina, dan lokasi.
     * Tidak menampilkan informasi/keterangan apel.
     */
    public function jadwalTaruna(Request $request): View
    {
        $daftarApel = Apel::with('pembinaUser')->terbaru()->get();

        $terpilih = $request->filled('apel')
            ? $daftarApel->firstWhere('id', (int) $request->get('apel'))
            : $daftarApel->first();

        return view('apel.jadwal', [
            'daftarApel' => $daftarApel,
            'terpilih'   => $terpilih,
        ]);
    }

    public function create(): View
    {
        return view('apel.form', [
            'apel'        => new Apel(['tanggal' => now()]),
            'daftarPembina' => $this->daftarPembina(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $apel = Apel::create($data + ['dibuat_oleh' => auth()->id()]);

        $this->logActivity(
            modul: 'apel',
            aksi: 'buat',
            deskripsi: "Buat {$apel->judul} pada {$apel->tanggal->format('d/m/Y')} — Pembina: {$apel->pembina}, Lokasi: {$apel->lokasi}",
            detail: $this->detailLog($apel),
            subject: $apel
        );

        return redirect()->route('apel.index', ['apel' => $apel->id])
            ->with('success', 'Data apel berhasil disimpan.');
    }

    public function edit(Apel $apel): View
    {
        return view('apel.form', [
            'apel'          => $apel,
            'daftarPembina' => $this->daftarPembina(),
        ]);
    }

    public function update(Request $request, Apel $apel): RedirectResponse
    {
        $data = $this->validated($request, $apel);

        $apel->update($data);

        $this->logActivity(
            modul: 'apel',
            aksi: 'ubah',
            deskripsi: "Ubah {$apel->judul} pada {$apel->tanggal->format('d/m/Y')} — Pembina: {$apel->pembina}, Lokasi: {$apel->lokasi}",
            detail: $this->detailLog($apel),
            subject: $apel
        );

        return redirect()->route('apel.index', ['apel' => $apel->id])
            ->with('success', 'Data apel berhasil diperbarui.');
    }

    public function destroy(Apel $apel): RedirectResponse
    {
        $this->logActivity(
            modul: 'apel',
            aksi: 'hapus',
            deskripsi: "Hapus {$apel->judul} pada {$apel->tanggal->format('d/m/Y')} — Pembina: {$apel->pembina}",
            detail: $this->detailLog($apel),
            subject: $apel
        );

        $apel->delete();

        return redirect()->route('apel.index')->with('success', 'Data apel berhasil dihapus.');
    }

    /**
     * Validasi + normalisasi input. Pembina boleh dipilih dari akun pengasuh
     * (pembina_user_id) atau diketik bebas (pembina).
     */
    private function validated(Request $request, ?Apel $apel = null): array
    {
        // Satu apel pagi/malam per tanggal; apel khusus bebas.
        $unik = Rule::unique('apel', 'sesi')
            ->where(fn ($q) => $q->where('tanggal', $request->tanggal));
        if ($apel) {
            $unik->ignore($apel->id);
        }

        $data = $request->validate([
            'tanggal'         => ['required', 'date'],
            'sesi'            => [
                'required',
                Rule::in([Apel::SESI_PAGI, Apel::SESI_MALAM, Apel::SESI_KHUSUS]),
                $request->sesi === Apel::SESI_KHUSUS ? 'nullable' : $unik,
            ],
            'nama_apel'       => [Rule::requiredIf($request->sesi === Apel::SESI_KHUSUS), 'nullable', 'string', 'max:255'],
            'jam'             => ['nullable', 'date_format:H:i'],
            'pembina_user_id' => ['nullable', 'exists:users,id'],
            'pembina'         => ['required_without:pembina_user_id', 'nullable', 'string', 'max:255'],
            'lokasi'          => ['required', 'string', 'max:255'],
            'informasi'       => ['nullable', 'string', 'max:2000'],
            'keterangan'      => ['nullable', 'string', 'max:2000'],
        ], [
            'sesi.unique'        => 'Apel :input pada tanggal tersebut sudah ada. Ubah data yang ada atau pilih Apel Khusus.',
            'nama_apel.required' => 'Nama apel wajib diisi untuk apel khusus.',
            'pembina.required_without' => 'Isi nama pembina atau pilih dari daftar pengasuh.',
        ]);

        // Nama pembina mengikuti akun yang dipilih; kalau tidak memilih, pakai ketikan bebas
        if (!empty($data['pembina_user_id'])) {
            $data['pembina'] = User::find($data['pembina_user_id'])?->name ?? $data['pembina'];
        }

        if ($data['sesi'] !== Apel::SESI_KHUSUS) {
            $data['nama_apel'] = null;
        }

        return $data;
    }

    /** Akun yang bisa jadi pembina apel */
    private function daftarPembina()
    {
        return User::whereIn('role', [User::ROLE_PENGASUH, User::ROLE_ADMIN])
            ->orderBy('name')
            ->get(['id', 'name', 'jabatan', 'role']);
    }

    private function detailLog(Apel $apel): array
    {
        return [
            'tanggal'    => $apel->tanggal->format('Y-m-d'),
            'sesi'       => $apel->sesi,
            'nama_apel'  => $apel->nama_apel,
            'jam'        => $apel->jam,
            'pembina'    => $apel->pembina,
            'lokasi'     => $apel->lokasi,
            'informasi'  => $apel->informasi,
            'keterangan' => $apel->keterangan,
        ];
    }
}
