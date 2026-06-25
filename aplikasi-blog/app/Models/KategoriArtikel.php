<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model kategori — memetakan tabel `kategori_artikel` milik CMS (db_blog).
 */
class KategoriArtikel extends Model
{
    protected $table = 'kategori_artikel';

    public $timestamps = false;

    /** Relasi: satu kategori memiliki banyak artikel. */
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_kategori');
    }
}
