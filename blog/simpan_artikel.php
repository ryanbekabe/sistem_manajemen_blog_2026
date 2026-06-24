<?php
// simpan_artikel.php — Tambah artikel baru (CREATE). Upload gambar wajib.
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$id_penulis  = (int) ($_POST['id_penulis'] ?? 0);
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);
$judul       = trim($_POST['judul'] ?? '');
$isi         = trim($_POST['isi'] ?? '');

if ($id_penulis <= 0 || $id_kategori <= 0 || $judul === '' || $isi === '') {
    gagal('Judul, isi, penulis, dan kategori wajib diisi.');
}

// Upload gambar WAJIB.
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] === UPLOAD_ERR_NO_FILE) {
    gagal('Gambar artikel wajib diunggah.');
}

try {
    $gambar = simpan_gambar('gambar', DIR_UPLOAD_ARTIKEL);
} catch (RuntimeException $e) {
    gagal($e->getMessage());
}

// Tanggal otomatis dari server.
$hari_tanggal = tanggal_indonesia();

try {
    $stmt = $koneksi->prepare(
        'INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    hapus_gambar($gambar, DIR_UPLOAD_ARTIKEL);
    // 1452: FK gagal (penulis/kategori tidak ada).
    if ((int) $e->getCode() === 1452) {
        gagal('Penulis atau kategori yang dipilih tidak valid.');
    }
    gagal('Gagal menyimpan artikel.');
}

sukses('Artikel berhasil ditambahkan.', ['id' => $koneksi->insert_id]);
