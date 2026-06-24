<?php
// ambil_kategori.php — Daftar seluruh kategori (READ).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

$rows = [];
$res = $koneksi->query('SELECT id, nama_kategori, keterangan FROM kategori_artikel ORDER BY nama_kategori ASC');
while ($r = $res->fetch_assoc()) {
    $rows[] = [
        'id'            => (int) $r['id'],
        'nama_kategori' => aman($r['nama_kategori']),
        'keterangan'    => aman($r['keterangan']),
    ];
}

kirim_json(['sukses' => true, 'data' => $rows]);
