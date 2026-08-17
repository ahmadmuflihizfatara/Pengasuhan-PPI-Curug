<?php

namespace App\Http\Controllers;

use App\Models\KeluhanBarak;
use App\Models\Mahasiswa;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KeluhanBarakController extends Controller
{
    use LogsActivity;

    /**
     * Daftar keluhan milik taruna yang sedang login.
     * Notifikasi (status berubah) ditandai sudah dibaca saat halaman dibuka.
     */
    public function index(): View
    {
        $user = auth()->user();

        $daftarKeluhan = KeluhanBarak::where('user_id', $user->id)
            ->latest('tanggal_pengajuan')
            ->latest('id')
            ->get();

        KeluhanBarak::where('user_id', $user->id)
            ->where('taruna_baca', false)
            ->whereIn('status', ['Diproses', 'Selesai', 'Ditolak'])
            ->update(['taruna_baca' => true]);

        return view('keluhan-barak.index', compact('daftarKeluhan'));
    }

    /**
     * Form pengajuan keluhan. Email & nama otomatis dari akun login,
     * prodi mengikuti prodi akun tapi tetap bisa diganti.
     */
    public function create(): View
    {
        $user = auth()->user();

        return view('keluhan-barak.create', [
            'user'       => $user,
            'asramaList' => KeluhanBarak::ASRAMA,
            'lorongList' => KeluhanBarak::LORONG,
            'prodiList'  => Mahasiswa::PRODI,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $lorongValid = collect(KeluhanBarak::LORONG[$request->asrama] ?? [])->values()->all();

        $data = $request->validate([
            'tanggal_pengajuan' => ['required', 'date'],
            'prodi'             => ['required', Rule::in(array_keys(Mahasiswa::PRODI))],
            'asrama'            => ['required', Rule::in(KeluhanBarak::ASRAMA)],
            'lorong'            => ['required', Rule::in($lorongValid)],
            'nomor_barak'       => ['required', 'string', 'max:20'],
            'keterangan'        => ['required', 'string', 'max:2000'],
            'lampiran'          => ['nullable', 'array', 'max:5'],
            'lampiran.*'        => ['file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ]);

        $lampiran = [];
        foreach ($request->file('lampiran', []) as $file) {
            $lampiran[] = $file->store('keluhan', 'public');
        }

        $keluhan = KeluhanBarak::create([
            'user_id'            => $user->id,
            'email'              => $user->email,
            'nama'               => $user->name,
            'tanggal_pengajuan'  => $data['tanggal_pengajuan'],
            'prodi'              => $data['prodi'],
            'asrama'             => $data['asrama'],
            'lorong'             => $data['lorong'],
            'nomor_barak'        => $data['nomor_barak'],
            'keterangan'         => $data['keterangan'],
            'status'             => 'Diajukan',
            'taruna_baca'        => true,
            'lampiran'           => $lampiran ?: null,
        ]);

        $this->logActivity(
            modul: 'keluhan-barak',
            aksi: 'ajukan',
            deskripsi: "Taruna \"{$user->name}\" mengajukan keluhan barak {$keluhan->asrama} {$keluhan->lorong} No. {$keluhan->nomor_barak}",
            detail: $this->detailLog($keluhan),
            subject: $keluhan
        );

        return redirect()->route('keluhan-barak.index')
            ->with('success', 'Keluhan barak berhasil diajukan. Silakan pantau statusnya.');
    }

    /**
     * Detail keluhan milik taruna yang login.
     */
    public function show(KeluhanBarak $keluhan): View
    {
        if ($keluhan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak melihat keluhan ini.');
        }

        if (!$keluhan->taruna_baca && in_array($keluhan->status, ['Diproses', 'Selesai', 'Ditolak'])) {
            $keluhan->update(['taruna_baca' => true]);
        }

        return view('keluhan-barak.show', compact('keluhan'));
    }

    /**
     * API: jumlah notifikasi keluhan yang belum dibaca (untuk polling badge sidebar).
     */
    public function notifications()
    {
        $unread = KeluhanBarak::where('user_id', auth()->id())
            ->where('taruna_baca', false)
            ->whereIn('status', ['Diproses', 'Selesai', 'Ditolak'])
            ->get()
            ->map(fn ($k) => [
                'id'      => $k->id,
                'asrama'  => $k->asrama,
                'barak'   => $k->nomor_barak,
                'status'  => $k->status,
            ]);

        return response()->json([
            'count'  => $unread->count(),
            'unread' => $unread,
        ]);
    }

    private function detailLog(KeluhanBarak $keluhan): array
    {
        return [
            'tanggal_pengajuan' => $keluhan->tanggal_pengajuan->format('Y-m-d'),
            'prodi'             => $keluhan->prodi,
            'asrama'            => $keluhan->asrama,
            'lorong'            => $keluhan->lorong,
            'nomor_barak'       => $keluhan->nomor_barak,
            'keterangan'        => $keluhan->keterangan,
            'lampiran'          => $keluhan->lampiran,
        ];
    }
}
