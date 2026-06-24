<?php
// update_artikel.php — Perbarui artikel (UPDATE). Gambar opsional saat edit.
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$id          = (int) ($_POST['id'] ?? 0);
$id_penulis  = (int) ($_POST['id_penulis'] ?? 0);
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);
$judul       = trim($_POST['judul'] ?? '');
$isi         = trim($_POST['isi'] ?? '');

if ($id <= 0) {
    gagal('ID tidak valid.');
}
if ($id_penulis <= 0 || $id_kategori <= 0 || $judul === '' || $isi === '') {
    gagal('Judul, isi, penulis, dan kategori wajib diisi.');
}

// Ambil gambar lama.
$stmt = $koneksi->prepare('SELECT gambar FROM artikel WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$lama = $stmt->get_result()->fetch_assoc();
if (!$lama) {
    gagal('Data artikel tidak ditemukan.', 404);
}

// Gambar baru opsional.
try {
    $gambar_baru = simpan_gambar('gambar', DIR_UPLOAD_ARTIKEL);
} catch (RuntimeException $e) {
    gagal($e->getMessage());
}
$gambar = $gambar_baru !== '' ? $gambar_baru : $lama['gambar'];

try {
    $stmt = $koneksi->prepare(
        'UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?'
    );
    $stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    if ($gambar_baru !== '') {
        hapus_gambar($gambar_baru, DIR_UPLOAD_ARTIKEL);
    }
    if ((int) $e->getCode() === 1452) {
        gagal('Penulis atau kategori yang dipilih tidak valid.');
    }
    gagal('Gagal memperbarui artikel.');
}

// Hapus gambar lama bila diganti.
if ($gambar_baru !== '') {
    hapus_gambar($lama['gambar'], DIR_UPLOAD_ARTIKEL);
}

sukses('Artikel berhasil diperbarui.');
