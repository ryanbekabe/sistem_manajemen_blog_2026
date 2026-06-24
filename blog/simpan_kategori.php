<?php
// simpan_kategori.php — Tambah kategori baru (CREATE).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$nama_kategori = trim($_POST['nama_kategori'] ?? '');
$keterangan    = trim($_POST['keterangan'] ?? '');

if ($nama_kategori === '') {
    gagal('Nama kategori wajib diisi.');
}

try {
    $stmt = $koneksi->prepare('INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)');
    $stmt->bind_param('ss', $nama_kategori, $keterangan);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    if ((int) $e->getCode() === 1062) {
        gagal('Nama kategori sudah ada.');
    }
    gagal('Gagal menyimpan kategori.');
}

sukses('Kategori berhasil ditambahkan.', ['id' => $koneksi->insert_id]);
