<?php
// update_kategori.php — Perbarui kategori (UPDATE).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$id            = (int) ($_POST['id'] ?? 0);
$nama_kategori = trim($_POST['nama_kategori'] ?? '');
$keterangan    = trim($_POST['keterangan'] ?? '');

if ($id <= 0) {
    gagal('ID tidak valid.');
}
if ($nama_kategori === '') {
    gagal('Nama kategori wajib diisi.');
}

try {
    $stmt = $koneksi->prepare('UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?');
    $stmt->bind_param('ssi', $nama_kategori, $keterangan, $id);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    if ((int) $e->getCode() === 1062) {
        gagal('Nama kategori sudah ada.');
    }
    gagal('Gagal memperbarui kategori.');
}

if ($stmt->affected_rows === 0) {
    // Tidak ada perubahan atau ID tidak ada — cek keberadaan.
    $cek = $koneksi->prepare('SELECT 1 FROM kategori_artikel WHERE id = ?');
    $cek->bind_param('i', $id);
    $cek->execute();
    if (!$cek->get_result()->fetch_row()) {
        gagal('Data kategori tidak ditemukan.', 404);
    }
}

sukses('Kategori berhasil diperbarui.');
