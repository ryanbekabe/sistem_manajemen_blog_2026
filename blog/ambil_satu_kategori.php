<?php
// ambil_satu_kategori.php — Ambil satu kategori untuk form edit (READ).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    gagal('ID tidak valid.');
}

$stmt = $koneksi->prepare('SELECT id, nama_kategori, keterangan FROM kategori_artikel WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$r = $stmt->get_result()->fetch_assoc();

if (!$r) {
    gagal('Data kategori tidak ditemukan.', 404);
}

kirim_json([
    'sukses' => true,
    'data'   => [
        'id'            => (int) $r['id'],
        'nama_kategori' => $r['nama_kategori'],
        'keterangan'    => $r['keterangan'],
    ],
]);
