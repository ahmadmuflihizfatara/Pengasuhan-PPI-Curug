<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Reward;
use App\Traits\LogsActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RewardController extends Controller
{
    use LogsActivity;

    /**
     * Daftar reward milik taruna yang sedang login.
     */
    public function index(): View
    {
        $user = auth()->user();

        $daftarReward = Reward::where('user_id', $user->id)
            ->latest('tanggal_prestasi')
            ->latest('id')
            ->get();

        Reward::where('user_id', $user->id)
            ->where('taruna_baca', false)
            ->whereIn('status', ['Diproses', 'Disetujui', 'Ditolak'])
            ->update(['taruna_baca' => true]);

        return view('reward.index', compact('daftarReward'));
    }

    /**
     * Form pengajuan reward. Email, nama, prodi & NPM otomatis dari data
     * mahasiswa yang terhubung ke akun login.
     */
    public function create(): View
    {
        $user      = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        return view('reward.create', [
            'user'      => $user,
            'mahasiswa' => $mahasiswa,
            'kategoriList' => Reward::KATEGORI,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user      = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return back()->with('error', 'Akun Anda belum terhubung ke data mahasiswa. Hubungi pengasuh/admin.');
        }

        $data = $request->validate([
            'jenis'             => ['required', Rule::in([Reward::JENIS_INDIVIDU, Reward::JENIS_KELOMPOK])],
            'jumlah_anggota'    => [Rule::requiredIf($request->jenis === Reward::JENIS_KELOMPOK), 'nullable', 'integer', 'min:2', 'max:200'],
            'kategori'          => ['required', Rule::in(Reward::KATEGORI)],
            'tanggal_prestasi'  => ['required', 'date', 'before_or_equal:today'],
            'keterangan'        => ['required', 'string', 'max:2000'],
            'dokumen'           => ['required', 'array', 'min:1', 'max:5'],
            'dokumen.*'         => ['file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ], [
            'dokumen.required'        => 'Dokumentasi atau dokumen pendukung wajib dilampirkan.',
            'jumlah_anggota.required' => 'Jumlah anggota kelompok wajib diisi untuk pengajuan kelompok.',
        ]);

        if ($data['jenis'] === Reward::JENIS_INDIVIDU) {
            $data['jumlah_anggota'] = null;
        }

        $dokumen = [];
        foreach ($request->file('dokumen', []) as $file) {
            $dokumen[] = $file->store('reward', 'public');
        }

        $reward = Reward::create([
            'user_id'          => $user->id,
            'mahasiswa_id'     => $mahasiswa->id,
            'email'            => $user->email,
            'nama'             => $mahasiswa->nama,
            'npm'              => $mahasiswa->npm,
            'prodi'            => $mahasiswa->prodi,
            'tingkat'          => $mahasiswa->tingkat,
            'jenis'            => $data['jenis'],
            'jumlah_anggota'   => $data['jumlah_anggota'] ?? null,
            'kategori'         => $data['kategori'],
            'tanggal_prestasi' => $data['tanggal_prestasi'],
            'keterangan'       => $data['keterangan'],
            'dokumen'          => $dokumen,
            'status'           => 'Diajukan',
            'taruna_baca'      => true,
        ]);

        $this->logActivity(
            modul: 'reward',
            aksi: 'ajukan',
            deskripsi: "Taruna \"{$mahasiswa->nama}\" mengajukan reward {$reward->kategori} ({$reward->jenis})",
            detail: $this->detailLog($reward),
            subject: $reward
        );

        return redirect()->route('reward.index')
            ->with('success', 'Pengajuan reward berhasil dikirim. Silakan pantau statusnya.');
    }

    /**
     * Detail reward milik taruna yang login.
     */
    public function show(Reward $reward): View
    {
        if ($reward->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak melihat pengajuan reward ini.');
        }

        if (!$reward->taruna_baca && in_array($reward->status, ['Diproses', 'Disetujui', 'Ditolak'])) {
            $reward->update(['taruna_baca' => true]);
        }

        return view('reward.show', compact('reward'));
    }

    /**
     * API: jumlah notifikasi reward yang belum dibaca (polling badge sidebar).
     */
    public function notifications()
    {
        $unread = Reward::where('user_id', auth()->id())
            ->where('taruna_baca', false)
            ->whereIn('status', ['Diproses', 'Disetujui', 'Ditolak'])
            ->get()
            ->map(fn ($r) => [
                'id'       => $r->id,
                'kategori' => $r->kategori,
                'status'   => $r->status,
            ]);

        return response()->json([
            'count'  => $unread->count(),
            'unread' => $unread,
        ]);
    }

    private function detailLog(Reward $reward): array
    {
        return [
            'nama'             => $reward->nama,
            'npm'              => $reward->npm,
            'prodi'            => $reward->prodi,
            'jenis'            => $reward->jenis,
            'jumlah_anggota'   => $reward->jumlah_anggota,
            'kategori'         => $reward->kategori,
            'tanggal_prestasi' => $reward->tanggal_prestasi->format('Y-m-d'),
            'keterangan'       => $reward->keterangan,
            'dokumen'          => $reward->dokumen,
        ];
    }
}
