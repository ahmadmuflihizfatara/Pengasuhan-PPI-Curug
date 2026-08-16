<?php

namespace App\Http\Controllers;

use App\Models\AksesFitur;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AksesController extends Controller
{
    use LogsActivity;

    public function index(): View
    {
        return view('akses.index', ['daftar' => AksesFitur::semua()]);
    }

    /**
     * Buka/tutup akses satu fitur untuk pengasuh.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'fitur'     => ['required', Rule::in(array_keys(AksesFitur::DAFTAR))],
            'diizinkan' => ['required', 'boolean'],
        ]);

        AksesFitur::updateOrCreate(
            ['fitur' => $data['fitur']],
            ['diizinkan' => $data['diizinkan'], 'diubah_oleh' => auth()->id()]
        );

        $label  = AksesFitur::DAFTAR[$data['fitur']]['label'];
        $status = $data['diizinkan'] ? 'dibuka' : 'ditutup';

        $this->logActivity(
            modul: 'akses',
            aksi: 'ubah',
            deskripsi: "Akses \"{$label}\" untuk pengasuh {$status}",
            detail: $data
        );

        return redirect()->route('akses.index')
            ->with('success', "Akses {$label} berhasil {$status}.");
    }
}
