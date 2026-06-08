<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;
use App\Traits\LogsActivity; 

class AcaraController extends Controller
{
    use LogsActivity; 

    public function index()
    {
        $acara = Acara::orderBy('tanggal', 'asc')->orderBy('jam', 'asc')->get();
        return view('acara.index', compact('acara'));
    }

    public function create()
    {
        return view('acara.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'jam'        => 'required',
            'keterangan' => 'nullable|string',
        ]);

        $acara = Acara::create($request->only(['nama_acara', 'tanggal', 'jam', 'keterangan']));

        // ========== ACTIVITY LOG ==========
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
        // ==================================

        return redirect()->route('acara.index')->with('success', 'Acara berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $acara = Acara::findOrFail($id);
        return view('acara.edit', compact('acara'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'jam'        => 'required',
            'keterangan' => 'nullable|string',
        ]);

        $acara    = Acara::findOrFail($id);
        $namaLama = $acara->nama_acara;
        $acara->update($request->only(['nama_acara', 'tanggal', 'jam', 'keterangan']));

        // ========== ACTIVITY LOG ==========
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
        // ==================================

        return redirect()->route('acara.index')->with('success', 'Acara berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $acara = Acara::findOrFail($id);

        // ========== ACTIVITY LOG ==========
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
        // ==================================

        $acara->delete();

        return redirect()->route('acara.index')->with('success', 'Acara berhasil dihapus!');
    }
}
