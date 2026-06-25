<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model penulis — memetakan tabel `penulis` milik CMS (db_blog).
 */
class Penulis extends Model
{
    protected $table = 'penulis';

    public $timestamps = false;

    /** Sembunyikan password dari serialisasi. */
    protected $hidden = ['password'];

    /** Nama lengkap penulis. */
    public function getNamaLengkapAttribute(): string
    {
        return trim($this->nama_depan . ' ' . $this->nama_belakang);
    }
}
