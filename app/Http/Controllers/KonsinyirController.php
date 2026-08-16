<?php

namespace App\Http\Controllers;

use App\Models\Konsinyir;
use App\Models\Mahasiswa;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KonsinyirController extends Controller
{
    use LogsActivity;

    public function index(): View
    {
        $semua = Konsinyir::with('mahasiswa', 'penginput')->orderByDesc('tanggal_mulai')->get();

        return view('konsinyir.index', [
            'aktif'        => $semua->filter(fn ($k) => $k->status === 'aktif')->values(),
            'riwayat'      => $semua->filter(fn ($k) => $k->status === 'selesai')->values(),
            'daftarTaruna' => Mahasiswa::orderBy('nama')->get(['id', 'nama', 'npm', 'prodi', 'tingkat']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mahasiswa_id'  => ['required', 'exists:mahasiswa,id'],
            'tanggal_mulai' => ['required', 'date'],
            'lama_hari'     => ['required', 'integer', 'min:1', 'max:365'],
            'keterangan'    => ['nullable', 'string', 'max:1000'],
        ], [
            'mahasiswa_id.required' => 'Pilih taruna dari database mahasiswa.',
            'mahasiswa_id.exists'   => 'Nama taruna tidak ditemukan di database mahasiswa.',
        ]);

        $konsinyir = Konsinyir::create($data + ['diinput_oleh' => auth()->id()]);
        $konsinyir->load('mahasiswa');

        $this->logActivity(
            modul: 'konsinyir',
            aksi: 'tambah',
            deskripsi: "Tambah konsinyir {$konsinyir->mahasiswa->nama} — {$data['lama_hari']} hari mulai {$konsinyir->tanggal_mulai->format('d/m/Y')}",
            detail: $data,
            subject: $konsinyir
        );

        return redirect()->route('konsinyir.index')
            ->with('success', "Konsinyir {$konsinyir->mahasiswa->nama} berhasil ditambahkan.");
    }

    public function destroy(Konsinyir $konsinyir): RedirectResponse
    {
        $konsinyir->load('mahasiswa');
        $nama = $konsinyir->mahasiswa->nama;

        $this->logActivity(
            modul: 'konsinyir',
            aksi: 'hapus',
            deskripsi: "Hapus konsinyir {$nama}",
            detail: ['mahasiswa_id' => $konsinyir->mahasiswa_id],
        );

        $konsinyir->delete();

        return redirect()->route('konsinyir.index')->with('success', "Konsinyir {$nama} berhasil dihapus.");
    }
}
