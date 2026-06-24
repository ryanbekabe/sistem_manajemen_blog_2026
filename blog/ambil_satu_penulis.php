<?php
// ambil_satu_penulis.php — Ambil satu penulis untuk form edit (READ).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    gagal('ID tidak valid.');
}

$stmt = $koneksi->prepare(
    'SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis WHERE id = ?'
);
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$r   = $res->fetch_assoc();

if (!$r) {
    gagal('Data penulis tidak ditemukan.', 404);
}

$foto = $r['foto'] !== '' ? $r['foto'] : 'default.png';

kirim_json([
    'sukses' => true,
    'data'   => [
        'id'            => (int) $r['id'],
        'nama_depan'    => $r['nama_depan'],
        'nama_belakang' => $r['nama_belakang'],
        'user_name'     => $r['user_name'],
        'foto'          => $foto,
        'foto_url'      => 'uploads_penulis/' . rawurlencode($foto),
    ],
]);
