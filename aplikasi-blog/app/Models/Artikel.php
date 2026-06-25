<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Model artikel — memetakan tabel `artikel` milik CMS (db_blog).
 * Tabel tidak punya kolom timestamp, jadi $timestamps dimatikan.
 */
class Artikel extends Model
{
    protected $table = 'artikel';

    public $timestamps = false;

    /** Relasi: setiap artikel ditulis oleh satu penulis. */
    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'id_penulis');
    }

    /** Relasi: setiap artikel masuk satu kategori. */
    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'id_kategori');
    }

    /** URL gambar artikel (disajikan dari folder uploads_artikel CMS). */
    public function getGambarUrlAttribute(): string
    {
        return route('pengunjung.gambar', ['file' => $this->gambar ?: 'default.png']);
    }

    /** Ringkasan isi artikel untuk kartu di halaman utama. */
    public function getRingkasanAttribute(): string
    {
        return Str::limit(strip_tags((string) $this->isi), 150);
    }
}
