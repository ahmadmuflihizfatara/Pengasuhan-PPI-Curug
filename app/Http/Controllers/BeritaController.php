<?php

namespace App\Http\Controllers;

use App\Models\BeritaTaruna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class BeritaController extends Controller
{
    use LogsActivity;

    // ──────────────────────────────────────────────────
    // INDEX — semua role bisa akses
    // ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = BeritaTaruna::with('penulis')->published()->latest();

        // Pinned articles selalu di atas
        $pinnedQuery = BeritaTaruna::with('penulis')
            ->published()
            ->pinned()
            ->latest();

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
            $pinnedQuery->where('kategori', $request->kategori);
        }

        // Pencarian
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('ringkasan', 'like', "%{$s}%")
                  ->orWhere('konten', 'like', "%{$s}%");
            });
            $pinnedQuery->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('ringkasan', 'like', "%{$s}%")
                  ->orWhere('konten', 'like', "%{$s}%");
            });
        }

        $pinned = $pinnedQuery->get();
        $berita = $query->whereNotIn('id', $pinned->pluck('id'))->paginate(9)->withQueryString();

        $stats = [
            'total'      => BeritaTaruna::published()->count(),
            'pengumuman' => BeritaTaruna::published()->where('kategori', 'pengumuman')->count(),
            'prestasi'   => BeritaTaruna::published()->where('kategori', 'prestasi')->count(),
            'kegiatan'   => BeritaTaruna::published()->where('kategori', 'kegiatan')->count(),
            'informasi'  => BeritaTaruna::published()->where('kategori', 'informasi')->count(),
        ];

        return view('berita.index', compact('berita', 'pinned', 'stats'));
    }

    // ──────────────────────────────────────────────────
    // SHOW — semua role
    // ──────────────────────────────────────────────────
    public function show(BeritaTaruna $beritum)
    {
        // $beritum adalah binding dari route model (model BeritaTaruna)
        // Laravel memetakan nama parameter route ke nama variabel
        // Jika route: /berita/{beritum} — Laravel auto inject
        abort_if(!$beritum->is_published, 404);

        // Berita terkait (kategori sama, bukan artikel ini)
        $terkait = BeritaTaruna::with('penulis')
            ->published()
            ->where('kategori', $beritum->kategori)
            ->where('id', '!=', $beritum->id)
            ->latest()
            ->take(3)
            ->get();

        return view('berita.show', compact('beritum', 'terkait'));
    }

    // ──────────────────────────────────────────────────
    // CREATE — hanya pengasuh & penyelenggara
    // ──────────────────────────────────────────────────
    public function create()
    {
        $this->authorizeStaff();
        $kategoriList = BeritaTaruna::kategoriList();
        return view('berita.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $this->authorizeStaff();

        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|in:pengumuman,prestasi,kegiatan,informasi,lainnya',
            'ringkasan'    => 'nullable|string|max:500',
            'konten'       => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'is_published' => 'boolean',
            'is_pinned'    => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['user_id']      = Auth::id();
        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['is_pinned']    = $request->boolean('is_pinned', false);

        $berita = BeritaTaruna::create($validated);

        $this->logActivity(
            modul: 'berita',
            aksi: 'buat',
            deskripsi: "Buat berita baru: \"{$berita->judul}\" (Kategori: {$berita->kategori_label})",
            detail: [
                'judul'    => $berita->judul,
                'kategori' => $berita->kategori,
                'pinned'   => $berita->is_pinned,
            ],
            subject: $berita
        );

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil dipublikasikan!');
    }

    // ──────────────────────────────────────────────────
    // EDIT / UPDATE — hanya pengasuh & penyelenggara
    // ──────────────────────────────────────────────────
    public function edit(BeritaTaruna $beritum)
    {
        $this->authorizeStaff();
        $kategoriList = BeritaTaruna::kategoriList();
        return view('berita.edit', compact('beritum', 'kategoriList'));
    }

    public function update(Request $request, BeritaTaruna $beritum)
    {
        $this->authorizeStaff();

        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|in:pengumuman,prestasi,kegiatan,informasi,lainnya',
            'ringkasan'    => 'nullable|string|max:500',
            'konten'       => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'is_published' => 'boolean',
            'is_pinned'    => 'boolean',
        ]);

        $judulLama = $beritum->judul;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($beritum->gambar && Storage::disk('public')->exists($beritum->gambar)) {
                Storage::disk('public')->delete($beritum->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['is_pinned']    = $request->boolean('is_pinned', false);

        $beritum->update($validated);

        $this->logActivity(
            modul: 'berita',
            aksi: 'ubah',
            deskripsi: "Ubah berita \"{$judulLama}\" → \"{$beritum->judul}\"",
            detail: [
                'judul_lama' => $judulLama,
                'judul_baru' => $beritum->judul,
                'kategori'   => $beritum->kategori,
            ],
            subject: $beritum
        );

        return redirect()->route('berita.show', $beritum)
            ->with('success', 'Berita berhasil diperbarui!');
    }

    // ──────────────────────────────────────────────────
    // DESTROY — hanya pengasuh & penyelenggara
    // ──────────────────────────────────────────────────
    public function destroy(BeritaTaruna $beritum)
    {
        $this->authorizeStaff();

        $this->logActivity(
            modul: 'berita',
            aksi: 'hapus',
            deskripsi: "Hapus berita \"{$beritum->judul}\" (Kategori: {$beritum->kategori_label})",
            detail: [
                'judul'    => $beritum->judul,
                'kategori' => $beritum->kategori,
            ],
            subject: $beritum
        );

        if ($beritum->gambar && Storage::disk('public')->exists($beritum->gambar)) {
            Storage::disk('public')->delete($beritum->gambar);
        }

        $beritum->delete();

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────
    // TOGGLE PIN — hanya pengasuh & penyelenggara
    // ──────────────────────────────────────────────────
    public function togglePin(BeritaTaruna $beritum)
    {
        $this->authorizeStaff();
        $beritum->update(['is_pinned' => !$beritum->is_pinned]);
        $label = $beritum->is_pinned ? 'di-pin' : 'dilepas pin';
        return back()->with('success', "Berita berhasil {$label}.");
    }

    // ──────────────────────────────────────────────────
    // HELPER
    // ──────────────────────────────────────────────────
    private function authorizeStaff(): void
    {
        if (Auth::user()->isTaruna()) {
            abort(403, 'Akses ditolak. Taruna tidak dapat mengelola berita.');
        }
    }
}
