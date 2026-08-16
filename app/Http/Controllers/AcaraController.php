<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\Apel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;

class AcaraController extends Controller
{
    use LogsActivity;

    /**
     * Kalender: acara + apel digabung.
     * - Taruna           : hanya bisa melihat (view kalender), tanpa informasi apel
     * - Pengasuh / admin : bisa kelola acara (tabel + kalender + CRUD), kalender juga menampilkan apel
     */
    public function index()
    {
        $acara = Acara::orderBy('tanggal', 'asc')->orderBy('jam', 'asc')->get();
        $apel  = Apel::with('pembinaUser')->orderBy('tanggal', 'asc')->orderBy('jam', 'asc')->get();

        return view('acara.index', compact('acara', 'apel'));
    }

    /**
     * Form tambah acara — hanya pengasuh & admin.
     */
    public function create()
    {
        $this->authorizeStaff();
        return view('acara.create');
    }

    public function store(Request $request)
    {
        $this->authorizeStaff();

        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'jam'        => 'required',
            'keterangan' => 'nullable|string',
        ]);

        $acara = Acara::create($request->only(['nama_acara', 'tanggal', 'jam', 'keterangan']));

        $this->logActivity(
            modul: 'acara',
            aksi: 'buat',
            deskripsi: "Buat acara baru: \"{$acara->nama_acara}\" pada {$acara->tanggal->format('d/m/Y')} pukul {$acara->jam}",
            detail: [
                'nama_acara' => $acara->nama_acara,
                'tanggal'    => $acara->tanggal->format('Y-m-d'),
                'jam'        => $acara->jam,
                'keterangan' => $acara->keterangan,
            ],
            subject: $acara
        );

        return redirect()->route('acara.index')->with('success', 'Acara berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $this->authorizeStaff();
        $acara = Acara::findOrFail($id);
        return view('acara.edit', compact('acara'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeStaff();

        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'jam'        => 'required',
            'keterangan' => 'nullable|string',
        ]);

        $acara    = Acara::findOrFail($id);
        $namaLama = $acara->nama_acara;
        $acara->update($request->only(['nama_acara', 'tanggal', 'jam', 'keterangan']));

        $this->logActivity(
            modul: 'acara',
            aksi: 'ubah',
            deskripsi: "Ubah acara \"{$namaLama}\" → \"{$acara->nama_acara}\" pada {$acara->tanggal->format('d/m/Y')} pukul {$acara->jam}",
            detail: [
                'nama_lama'  => $namaLama,
                'nama_baru'  => $acara->nama_acara,
                'tanggal'    => $acara->tanggal->format('Y-m-d'),
                'jam'        => $acara->jam,
                'keterangan' => $acara->keterangan,
            ],
            subject: $acara
        );

        return redirect()->route('acara.index')->with('success', 'Acara berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->authorizeStaff();

        $acara = Acara::findOrFail($id);

        $this->logActivity(
            modul: 'acara',
            aksi: 'hapus',
            deskripsi: "Hapus acara \"{$acara->nama_acara}\" yang dijadwalkan pada {$acara->tanggal->format('d/m/Y')} pukul {$acara->jam}",
            detail: [
                'nama_acara' => $acara->nama_acara,
                'tanggal'    => $acara->tanggal->format('Y-m-d'),
                'jam'        => $acara->jam,
                'keterangan' => $acara->keterangan,
            ],
            subject: $acara
        );

        $acara->delete();

        return redirect()->route('acara.index')->with('success', 'Acara berhasil dihapus!');
    }

    // ─────────────────────────────────────────────────────
    // Helper: tolak taruna yang mencoba akses endpoint CRUD
    // ─────────────────────────────────────────────────────
    private function authorizeStaff(): void
    {
        if (Auth::user()->isTaruna()) {
            abort(403, 'Akses ditolak. Taruna tidak dapat mengelola acara.');
        }
    }
}
