<?php
// hapus_penulis.php — Hapus penulis (DELETE). Ditolak bila masih punya artikel.
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    gagal('ID tidak valid.');
}

// Ambil foto untuk dihapus setelah baris terhapus.
$stmt = $koneksi->prepare('SELECT foto FROM penulis WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$r = $stmt->get_result()->fetch_assoc();
if (!$r) {
    gagal('Data penulis tidak ditemukan.', 404);
}

try {
    $stmt = $koneksi->prepare('DELETE FROM penulis WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    // 1451: pelanggaran foreign key (ON DELETE RESTRICT).
    if ((int) $e->getCode() === 1451) {
        gagal('Penulis tidak dapat dihapus karena masih memiliki artikel.');
    }
    gagal('Gagal menghapus data penulis.');
}

hapus_gambar($r['foto'], DIR_UPLOAD_PENULIS);

sukses('Penulis berhasil dihapus.');
