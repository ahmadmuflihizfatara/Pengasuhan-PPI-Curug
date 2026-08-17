<?php

namespace App\Http\Controllers;

use App\Models\AksesFitur;
use App\Models\Reward;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RewardStaffController extends Controller
{
    use LogsActivity;

    /**
     * Daftar semua pengajuan reward dengan filter status, kategori, dan pencarian.
     */
    public function kelola(Request $request): View
    {
        $query = Reward::latest('tanggal_prestasi')->latest('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('npm', 'like', "%{$s}%")
                  ->orWhere('keterangan', 'like', "%{$s}%");
            });
        }

        $daftarReward = $query->paginate(10)->withQueryString();

        $stats = [
            'total'     => Reward::count(),
            'diajukan'  => Reward::where('status', 'Diajukan')->count(),
            'diproses'  => Reward::where('status', 'Diproses')->count(),
            'disetujui' => Reward::where('status', 'Disetujui')->count(),
            'ditolak'   => Reward::where('status', 'Ditolak')->count(),
        ];

        return view('reward.kelola', [
            'daftarReward' => $daftarReward,
            'stats'        => $stats,
            'statusList'   => Reward::statusList(),
            'kategoriList' => Reward::KATEGORI,
        ]);
    }

    /**
     * Detail reward untuk pengasuh/admin.
     */
    public function showDetail(Reward $reward): View
    {
        return view('reward.kelola-detail', [
            'reward'     => $reward,
            'statusList' => Reward::statusList(),
        ]);
    }

    /**
     * Ubah status reward + catatan reward yang diberikan (barang/jajan/poin, dst).
     * Status baru akan memunculkan notifikasi untuk taruna.
     */
    public function updateStatus(Request $request, Reward $reward): RedirectResponse
    {
        if ($tolak = $this->tolakBilaAksesDitutup()) {
            return $tolak;
        }

        $validated = $request->validate([
            'status'             => ['required', Rule::in(Reward::statusList())],
            'catatan_pengasuhan' => ['nullable', 'string', 'max:2000'],
        ]);

        $statusLama = $reward->status;

        $reward->update([
            'status'             => $validated['status'],
            'catatan_pengasuhan' => $validated['catatan_pengasuhan'] ?? null,
            'taruna_baca'        => false,
        ]);

        $aksi = match ($reward->status) {
            'Disetujui' => 'setujui',
            'Ditolak'   => 'tolak',
            'Diproses'  => 'proses',
            default     => 'ubah',
        };

        $this->logActivity(
            modul: 'reward',
            aksi: $aksi,
            deskripsi: "Ubah status reward {$reward->kategori} milik {$reward->nama}: {$statusLama} → {$reward->status}",
            detail: [
                'nama'               => $reward->nama,
                'email'              => $reward->email,
                'kategori'           => $reward->kategori,
                'jenis'              => $reward->jenis,
                'status_lama'        => $statusLama,
                'status_baru'        => $reward->status,
                'catatan_pengasuhan' => $reward->catatan_pengasuhan,
            ],
            subject: $reward
        );

        return redirect()->back()
            ->with('success', "Status reward berhasil diperbarui menjadi {$reward->status}.");
    }

    /**
     * Tolak aksi tulis kalau admin menutup akses fitur reward.
     * Admin selalu boleh; pengasuh diblokir saat fitur ditutup.
     */
    private function tolakBilaAksesDitutup(): ?RedirectResponse
    {
        if (auth()->user()->role === User::ROLE_ADMIN) {
            return null;
        }

        if (AksesFitur::diizinkan(AksesFitur::REWARD)) {
            return null;
        }

        return redirect()->route('reward.kelola')
            ->with('error', 'Akses pengelolaan reward sedang ditutup oleh admin.');
    }
}
