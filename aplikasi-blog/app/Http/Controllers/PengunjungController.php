<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Controller halaman pengunjung (publik) — TERPISAH dari controller CMS.
 * Tidak memerlukan login / middleware auth.
 */
class PengunjungController extends Controller
{
    /** Jumlah artikel terbaru & artikel terkait yang ditampilkan. */
    private const BATAS = 5;

    /**
     * Halaman utama: 5 artikel terbaru + widget kategori.
     * Mendukung penyaringan berdasarkan kategori (?kategori=ID).
     */
    public function index(Request $request)
    {
        $idKategori    = $request->query('kategori');
        $kategoriAktif = $idKategori ? KategoriArtikel::find($idKategori) : null;

        $artikel = Artikel::with(['penulis', 'kategori'])
            ->when($idKategori, fn ($q) => $q->where('id_kategori', $idKategori))
            ->orderByDesc('id')
            ->take(self::BATAS)
            ->get();

        $kategori = KategoriArtikel::withCount('artikel')
            ->orderBy('nama_kategori')
            ->get();

        $totalArtikel = Artikel::count();

        return view('pengunjung.index', compact(
            'artikel',
            'kategori',
            'totalArtikel',
            'idKategori',
            'kategoriAktif'
        ));
    }

    /**
     * Halaman detail artikel: isi lengkap + 5 artikel terkait sekategori.
     */
    public function show($id)
    {
        $artikel = Artikel::with(['penulis', 'kategori'])->findOrFail($id);

        $terkait = Artikel::where('id_kategori', $artikel->id_kategori)
            ->where('id', '!=', $artikel->id)
            ->orderByDesc('id')
            ->take(self::BATAS)
            ->get();

        return view('pengunjung.detail', compact('artikel', 'terkait'));
    }

    /**
     * Menyajikan file gambar artikel dari folder uploads_artikel milik CMS
     * (berada di luar proyek Laravel). Bila tidak ada, tampilkan placeholder.
     */
    public function gambar(string $file): BinaryFileResponse
    {
        $file = basename($file); // cegah path traversal
        $path = dirname(base_path()) . '/blog/uploads_artikel/' . $file;

        if (! is_file($path)) {
            $path = public_path('img/placeholder.svg');
        }

        return response()->file($path);
    }
}
