<?php
// simpan_penulis.php — Tambah penulis baru (CREATE).
declare(strict_types=1);
require __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    gagal('Metode tidak diizinkan.', 405);
}

$nama_depan    = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name'] ?? '');
$password      = (string) ($_POST['password'] ?? '');

if ($nama_depan === '' || $nama_belakang === '' || $user_name === '' || $password === '') {
    gagal('Semua field (nama depan, nama belakang, username, password) wajib diisi.');
}

try {
    $foto = simpan_gambar('foto', DIR_UPLOAD_PENULIS);
} catch (RuntimeException $e) {
    gagal($e->getMessage());
}
if ($foto === '') {
    $foto = 'default.png';
}

$hash = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $koneksi->prepare(
        'INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto)
         VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->bind_param('sssss', $nama_depan, $nama_belakang, $user_name, $hash, $foto);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    // Bersihkan file yang sudah terlanjur diunggah bila insert gagal.
    hapus_gambar($foto, DIR_UPLOAD_PENULIS);
    if ((int) $e->getCode() === 1062) {
        gagal('Username sudah digunakan, silakan pilih yang lain.');
    }
    gagal('Gagal menyimpan data penulis.');
}

sukses('Penulis berhasil ditambahkan.', ['id' => $koneksi->insert_id]);
