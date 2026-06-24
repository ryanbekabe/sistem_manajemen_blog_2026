<?php
// hapus_artikel.php — Hapus artikel (DELETE). File gambar ikut dihapus.
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    gagal('ID tidak valid.');
}

// Ambil nama gambar untuk dihapus dari server.
$stmt = $koneksi->prepare('SELECT gambar FROM artikel WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$r = $stmt->get_result()->fetch_assoc();
if (!$r) {
    gagal('Data artikel tidak ditemukan.', 404);
}

try {
    $stmt = $koneksi->prepare('DELETE FROM artikel WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    gagal('Gagal menghapus artikel.');
}

// File gambar ikut dihapus dari server.
hapus_gambar($r['gambar'], DIR_UPLOAD_ARTIKEL);

sukses('Artikel berhasil dihapus.');
