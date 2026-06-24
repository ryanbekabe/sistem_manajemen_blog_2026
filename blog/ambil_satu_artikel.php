<?php
// ambil_satu_artikel.php — Ambil satu artikel untuk form edit (READ).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    gagal('ID tidak valid.');
}

$stmt = $koneksi->prepare(
    'SELECT id, id_penulis, id_kategori, judul, isi, gambar, hari_tanggal FROM artikel WHERE id = ?'
);
$stmt->bind_param('i', $id);
$stmt->execute();
$r = $stmt->get_result()->fetch_assoc();

if (!$r) {
    gagal('Data artikel tidak ditemukan.', 404);
}

kirim_json([
    'sukses' => true,
    'data'   => [
        'id'           => (int) $r['id'],
        'id_penulis'   => (int) $r['id_penulis'],
        'id_kategori'  => (int) $r['id_kategori'],
        'judul'        => $r['judul'],
        'isi'          => $r['isi'],
        'gambar'       => $r['gambar'],
        'gambar_url'   => 'uploads_artikel/' . rawurlencode($r['gambar']),
        'hari_tanggal' => $r['hari_tanggal'],
    ],
]);
