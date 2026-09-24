<?php

namespace App\Http\Controllers;

use App\Models\AksesFitur;
use App\Models\KeluhanBarak;
use App\Models\User;
use App\Traits\SortsQuery;
use App\Traits\LogsActivity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class KeluhanBarakStaffController extends Controller
{
    use LogsActivity;
    use SortsQuery;

    /**
     * Daftar semua keluhan dengan filter status, asrama, dan pencarian.
     */
    public function kelola(Request $request): View
    {
        $query = $this->filteredQuery($request);

        $this->applySort($query, $request, ['pengaju' => 'nama', 'lokasi' => 'asrama', 'tanggal' => 'tanggal_pengajuan', 'status' => 'status']);
        $daftarKeluhan = $query->paginate(10)->withQueryString();

        $stats = [
            'total'     => KeluhanBarak::count(),
            'diajukan'  => KeluhanBarak::where('status', 'Diajukan')->count(),
            'diproses'  => KeluhanBarak::where('status', 'Diproses')->count(),
            'selesai'   => KeluhanBarak::where('status', 'Selesai')->count(),
            'ditolak'   => KeluhanBarak::where('status', 'Ditolak')->count(),
        ];

        return view('keluhan-barak.kelola', [
            'daftarKeluhan' => $daftarKeluhan,
            'stats'         => $stats,
            'statusList'    => KeluhanBarak::statusList(),
            'asramaList'    => KeluhanBarak::ASRAMA,
        ]);
    }

    /**
     * Ekspor keluhan (mengikuti filter status/asrama/pencarian aktif) ke PDF.
     */
    public function exportPdf(Request $request): Response
    {
        $daftarKeluhan = $this->filteredQuery($request)->get();

        return Pdf::loadView('keluhan-barak.pdf', [
            'daftarKeluhan' => $daftarKeluhan,
            'filter'        => $request->only('status', 'asrama', 'search'),
        ])->setPaper('a4', 'landscape')
          ->download('keluhan-barak-' . now()->setTimezone('Asia/Jakarta')->format('Ymd-His') . '.pdf');
    }

    /**
     * Query keluhan dengan filter status, asrama, dan pencarian.
     */
    private function filteredQuery(Request $request): Builder
    {
        $query = KeluhanBarak::latest('tanggal_pengajuan')->latest('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('asrama')) {
            $query->where('asrama', $request->asrama);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('nomor_barak', 'like', "%{$s}%")
                  ->orWhere('keterangan', 'like', "%{$s}%");
            });
        }

        return $query;
    }

    /**
     * Detail keluhan untuk pengasuh/admin.
     */
    public function showDetail(KeluhanBarak $keluhan): View
    {
        return view('keluhan-barak.kelola-detail', [
            'keluhan'    => $keluhan,
            'statusList' => KeluhanBarak::statusList(),
        ]);
    }

    /**
     * Ubah status keluhan + catatan pengasuhan.
     * Status baru akan memunculkan notifikasi untuk taruna.
     */
    public function updateStatus(Request $request, KeluhanBarak $keluhan): RedirectResponse
    {
        if ($tolak = $this->tolakBilaAksesDitutup()) {
            return $tolak;
        }

        $validated = $request->validate([
            'status'             => ['required', Rule::in(KeluhanBarak::statusList())],
            'catatan_pengasuhan' => ['nullable', 'string', 'max:2000'],
        ]);

        $statusLama = $keluhan->status;

        $keluhan->update([
            'status'             => $validated['status'],
            'catatan_pengasuhan' => $validated['catatan_pengasuhan'] ?? null,
            'taruna_baca'        => false,
        ]);

        $aksi = match ($keluhan->status) {
            'Selesai' => 'selesai',
            'Ditolak' => 'tolak',
            'Diproses' => 'proses',
            default   => 'ubah',
        };

        $this->logActivity(
            modul: 'keluhan-barak',
            aksi: $aksi,
            deskripsi: "Ubah status keluhan barak {$keluhan->asrama} {$keluhan->lorong} No. {$keluhan->nomor_barak} milik {$keluhan->nama}: {$statusLama} → {$keluhan->status}",
            detail: [
                'nama'               => $keluhan->nama,
                'email'              => $keluhan->email,
                'asrama'             => $keluhan->asrama,
                'lorong'             => $keluhan->lorong,
                'nomor_barak'        => $keluhan->nomor_barak,
                'status_lama'        => $statusLama,
                'status_baru'        => $keluhan->status,
                'catatan_pengasuhan' => $keluhan->catatan_pengasuhan,
            ],
            subject: $keluhan
        );

        return redirect()->back()
            ->with('success', "Status keluhan berhasil diperbarui menjadi {$keluhan->status}.");
    }

    /**
     * Tolak aksi tulis kalau admin menutup akses fitur keluhan barak.
     * Admin selalu boleh; pengasuh diblokir saat fitur ditutup.
     */
    private function tolakBilaAksesDitutup(): ?RedirectResponse
    {
        if (auth()->user()->role === User::ROLE_ADMIN) {
            return null;
        }

        if (AksesFitur::diizinkan(AksesFitur::KELUHAN_BARAK)) {
            return null;
        }

        return redirect()->route('keluhan-barak.kelola')
            ->with('error', 'Akses pengelolaan keluhan barak sedang ditutup oleh admin.');
    }
}
