<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Pemberian akses khusus (Kasi Internal, Polisi Taruna) oleh admin
 * ke akun taruna tertentu.
 */
class AksesKhususController extends Controller
{
    use LogsActivity;

    public function index(Request $request): View
    {
        $taruna = User::where('role', User::ROLE_TARUNA)
            ->with('mahasiswa:id,user_id,npm,prodi,tingkat')
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%")))
            ->orderByRaw('JSON_LENGTH(COALESCE(akses_khusus, "[]")) DESC')
            ->orderBy('name')
            ->get();

        return view('akses-khusus.index', [
            'taruna'      => $taruna,
            'daftarAkses' => User::DAFTAR_AKSES,
            'q'           => $request->q,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isTaruna(), 422, 'Akses khusus hanya untuk akun taruna.');

        $data = $request->validate([
            'akses'   => ['array'],
            'akses.*' => [Rule::in(array_keys(User::DAFTAR_AKSES))],
        ]);

        $akses = array_values(array_unique($data['akses'] ?? []));
        $user->update(['akses_khusus' => $akses ?: null]);

        $label = $akses
            ? implode(', ', array_map(fn ($a) => User::DAFTAR_AKSES[$a]['label'], $akses))
            : 'tidak ada';

        $this->logActivity(
            modul: 'akses_khusus',
            aksi: 'ubah',
            deskripsi: "Akses khusus {$user->name}: {$label}",
            detail: ['user_id' => $user->id, 'akses' => $akses],
            subject: $user
        );

        return redirect()->route('akses-khusus.index', ['q' => $request->q])
            ->with('success', "Akses khusus {$user->name} diperbarui: {$label}.");
    }
}
