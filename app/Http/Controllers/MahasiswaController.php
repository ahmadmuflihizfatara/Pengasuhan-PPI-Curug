<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    /**
     * Display the student database page — dibaca langsung dari tabel mahasiswa
     */
    public function index(): View
    {
        $urutanProdi = implode("','", array_keys(Mahasiswa::PRODI));

        $mahasiswaData = Mahasiswa::with('user')
            ->orderByRaw("FIELD(prodi, '{$urutanProdi}')")
            ->orderBy('tingkat')
            ->orderBy('nama')
            ->get()
            ->groupBy(fn ($m) => $m->prodi ?: 'Tanpa Prodi');

        $chartData = Mahasiswa::chartDataPerTingkat();

        return view('mahasiswa.index', compact('mahasiswaData', 'chartData'));
    }

    /**
     * Show edit form for a single student
     */
    public function edit(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load('user');

        return view('mahasiswa.edit', ['student' => $mahasiswa]);
    }

    /**
     * Update biodata + akun mahasiswa
     */
    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $validated = $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'nickname'      => ['nullable', 'string', 'max:100'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'prodi'         => ['required', Rule::in(array_keys(Mahasiswa::PRODI))],
            'tingkat'       => ['required', 'integer', 'min:1', 'max:4'],
            'email'         => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($mahasiswa->user_id)],
        ]);

        // D-3 hanya punya tingkat 1-3
        $maxTingkat = Mahasiswa::PRODI[$validated['prodi']]['tingkat'];
        if ($validated['tingkat'] > $maxTingkat) {
            return back()->withInput()->withErrors([
                'tingkat' => "Prodi {$validated['prodi']} hanya sampai tingkat {$maxTingkat}.",
            ]);
        }

        $validated['kelas'] = $validated['tingkat'] . ' ' . $validated['prodi'];

        $mahasiswa->update(collect($validated)->except('email')->all());

        if ($mahasiswa->user && $request->filled('email')) {
            $mahasiswa->user->update(['email' => $request->email]);
        }

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }
}
