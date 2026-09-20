<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\NilaiTaruna;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NilaiTarunaController extends Controller
{
    use LogsActivity;

    public function index(Request $request): View
    {
        $query = NilaiTaruna::with('mahasiswa', 'penginput')
            ->orderByDesc('updated_at');

        if ($request->filled('mahasiswa_id')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        return view('nilai-taruna.index', [
            'daftarNilai'  => $query->get(),
            'daftarTaruna' => Mahasiswa::orderBy('nama')->get(['id', 'nama', 'npm', 'prodi', 'tingkat']),
            'filterId'     => $request->mahasiswa_id,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mahasiswa_id' => ['required', 'exists:mahasiswa,id'],
            'semester'     => ['required', 'integer', 'min:1', 'max:8'],
            'ips'          => ['required', 'numeric', 'min:0', 'max:4'],
            'samapta'      => ['required', 'numeric', 'min:0', 'max:100'],
            'pengasuhan'   => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan'   => ['nullable', 'string', 'max:1000'],
        ], [
            'mahasiswa_id.required' => 'Pilih taruna dari database mahasiswa.',
            'mahasiswa_id.exists'   => 'Nama taruna tidak ditemukan di database mahasiswa.',
        ]);

        // Satu baris per taruna per semester — input ulang = perbarui nilai
        $nilai = NilaiTaruna::updateOrCreate(
            ['mahasiswa_id' => $data['mahasiswa_id'], 'semester' => $data['semester']],
            $data + ['diinput_oleh' => auth()->id()]
        );
        $nilai->load('mahasiswa');

        $this->logActivity(
            modul: 'nilai_taruna',
            aksi: $nilai->wasRecentlyCreated ? 'tambah' : 'ubah',
            deskripsi: "Nilai semester {$data['semester']} {$nilai->mahasiswa->nama}: IPS {$data['ips']}, Samapta {$data['samapta']}, Pengasuhan {$data['pengasuhan']}",
            detail: $data,
            subject: $nilai
        );

        return redirect()->route('nilai-taruna.index')
            ->with('success', "Nilai semester {$data['semester']} {$nilai->mahasiswa->nama} berhasil disimpan.");
    }

    public function destroy(NilaiTaruna $nilai): RedirectResponse
    {
        $nilai->load('mahasiswa');
        $nama = $nilai->mahasiswa->nama;

        $this->logActivity(
            modul: 'nilai_taruna',
            aksi: 'hapus',
            deskripsi: "Hapus nilai semester {$nilai->semester} {$nama}",
            detail: ['mahasiswa_id' => $nilai->mahasiswa_id, 'semester' => $nilai->semester],
        );

        $nilai->delete();

        return redirect()->route('nilai-taruna.index')->with('success', "Nilai semester {$nilai->semester} {$nama} berhasil dihapus.");
    }
}
