<?php
// ambil_artikel.php — Daftar seluruh artikel beserta nama penulis & kategori (READ).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

$sql = '
    SELECT a.id, a.judul, a.isi, a.gambar, a.hari_tanggal,
           a.id_penulis, a.id_kategori,
           CONCAT(p.nama_depan, " ", p.nama_belakang) AS nama_penulis,
           k.nama_kategori
    FROM artikel a
    JOIN penulis p          ON p.id = a.id_penulis
    JOIN kategori_artikel k ON k.id = a.id_kategori
    ORDER BY a.id DESC';

$rows = [];
$res = $koneksi->query($sql);
while ($r = $res->fetch_assoc()) {
    $rows[] = [
        'id'           => (int) $r['id'],
        'judul'        => aman($r['judul']),
        'isi'          => aman($r['isi']),
        'gambar'       => aman($r['gambar']),
        'gambar_url'   => 'uploads_artikel/' . rawurlencode($r['gambar']),
        'id_penulis'   => (int) $r['id_penulis'],
        'id_kategori'  => (int) $r['id_kategori'],
        'nama_penulis' => aman($r['nama_penulis']),
        'nama_kategori' => aman($r['nama_kategori']),
        'hari_tanggal' => aman($r['hari_tanggal']),
    ];
}

kirim_json(['sukses' => true, 'data' => $rows]);
