<?php
// update_penulis.php — Perbarui data penulis (UPDATE).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$id            = (int) ($_POST['id'] ?? 0);
$nama_depan    = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name'] ?? '');
$password      = (string) ($_POST['password'] ?? '');

if ($id <= 0) {
    gagal('ID tidak valid.');
}
if ($nama_depan === '' || $nama_belakang === '' || $user_name === '') {
    gagal('Nama depan, nama belakang, dan username wajib diisi.');
}

// Ambil data lama (untuk foto).
$stmt = $koneksi->prepare('SELECT foto FROM penulis WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$lama = $stmt->get_result()->fetch_assoc();
if (!$lama) {
    gagal('Data penulis tidak ditemukan.', 404);
}

// Foto baru (opsional).
try {
    $foto_baru = simpan_gambar('foto', DIR_UPLOAD_PENULIS);
} catch (RuntimeException $e) {
    gagal($e->getMessage());
}
$foto = $foto_baru !== '' ? $foto_baru : $lama['foto'];

// Susun query: password hanya diubah bila diisi.
try {
    if ($password !== '') {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $koneksi->prepare(
            'UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?'
        );
        $stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $hash, $foto, $id);
    } else {
        $stmt = $koneksi->prepare(
            'UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?'
        );
        $stmt->bind_param('ssssi', $nama_depan, $nama_belakang, $user_name, $foto, $id);
    }
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    if ($foto_baru !== '') {
        hapus_gambar($foto_baru, DIR_UPLOAD_PENULIS);
    }
    if ((int) $e->getCode() === 1062) {
        gagal('Username sudah digunakan, silakan pilih yang lain.');
    }
    gagal('Gagal memperbarui data penulis.');
}

// Hapus foto lama bila diganti.
if ($foto_baru !== '') {
    hapus_gambar($lama['foto'], DIR_UPLOAD_PENULIS);
}

sukses('Data penulis berhasil diperbarui.');
