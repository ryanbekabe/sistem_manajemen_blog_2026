<?php
// ambil_penulis.php — Daftar seluruh penulis (READ).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

$rows = [];
$sql = 'SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis ORDER BY id DESC';
$res = $koneksi->query($sql);
while ($r = $res->fetch_assoc()) {
    $foto = $r['foto'] !== '' ? $r['foto'] : 'default.png';
    $rows[] = [
        'id'            => (int) $r['id'],
        'nama_depan'    => aman($r['nama_depan']),
        'nama_belakang' => aman($r['nama_belakang']),
        'nama'          => aman($r['nama_depan'] . ' ' . $r['nama_belakang']),
        'user_name'     => aman($r['user_name']),
        'foto'          => aman($foto),
        'foto_url'      => 'uploads_penulis/' . rawurlencode($foto),
    ];
}

kirim_json(['sukses' => true, 'data' => $rows]);
