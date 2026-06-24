<?php
// hapus_kategori.php — Hapus kategori (DELETE). Ditolak bila masih punya artikel.
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    gagal('ID tidak valid.');
}

try {
    $stmt = $koneksi->prepare('DELETE FROM kategori_artikel WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    if ((int) $e->getCode() === 1451) {
        gagal('Kategori tidak dapat dihapus karena masih memiliki artikel.');
    }
    gagal('Gagal menghapus kategori.');
}

if ($stmt->affected_rows === 0) {
    gagal('Data kategori tidak ditemukan.', 404);
}

sukses('Kategori berhasil dihapus.');
