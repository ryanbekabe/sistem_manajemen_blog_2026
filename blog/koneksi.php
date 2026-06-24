<?php
/**
 * koneksi.php — Koneksi database & helper bersama.
 * Seluruh operasi database menggunakan mysqli + prepared statements.
 */

declare(strict_types=1);

date_default_timezone_set('Asia/Jakarta');

// ---- Konfigurasi koneksi ----
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = 'root';
const DB_NAME = 'db_blog';

// Lapor error mysqli sebagai exception agar mudah ditangani.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $koneksi->set_charset('utf8mb4');
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'sukses' => false,
        'pesan'  => 'Gagal terhubung ke database.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ---- Helper umum ----

/** Kirim respons JSON lalu hentikan eksekusi. */
function kirim_json(array $data, int $kode = 200): void
{
    http_response_code($kode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/** Respons sukses standar. */
function sukses(string $pesan, array $tambahan = []): void
{
    kirim_json(array_merge(['sukses' => true, 'pesan' => $pesan], $tambahan));
}

/** Respons gagal standar. */
function gagal(string $pesan, int $kode = 400): void
{
    kirim_json(['sukses' => false, 'pesan' => $pesan], $kode);
}

/** Sanitasi output untuk mencegah XSS. */
function aman(?string $teks): string
{
    return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Validasi & simpan file gambar yang diunggah.
 * - Tipe diperiksa dengan finfo (bukan $_FILES[...]['type']).
 * - Ukuran maksimal 2 MB.
 *
 * @return string Nama file yang tersimpan (basename), atau '' jika tidak ada file.
 * @throws RuntimeException bila file tidak valid.
 */
function simpan_gambar(string $field, string $folder_tujuan): string
{
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return '';
    }

    $file = $_FILES[$field];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Gagal mengunggah file (kode: ' . $file['error'] . ').');
    }

    // Ukuran maksimal 2 MB.
    $maks = 2 * 1024 * 1024;
    if ($file['size'] > $maks) {
        throw new RuntimeException('Ukuran file melebihi 2 MB.');
    }

    // Validasi tipe MIME nyata via finfo.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);

    $izin = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    if (!isset($izin[$mime])) {
        throw new RuntimeException('Tipe file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP.');
    }

    if (!is_dir($folder_tujuan) && !mkdir($folder_tujuan, 0775, true) && !is_dir($folder_tujuan)) {
        throw new RuntimeException('Folder upload tidak dapat dibuat.');
    }

    $nama_baru = bin2hex(random_bytes(16)) . '.' . $izin[$mime];
    $tujuan    = rtrim($folder_tujuan, '/\\') . DIRECTORY_SEPARATOR . $nama_baru;

    if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
        throw new RuntimeException('Gagal menyimpan file ke server.');
    }

    return $nama_baru;
}

/** Hapus file gambar dari folder bila ada (abaikan default.png). */
function hapus_gambar(string $nama_file, string $folder): void
{
    if ($nama_file === '' || $nama_file === 'default.png') {
        return;
    }
    $path = rtrim($folder, '/\\') . DIRECTORY_SEPARATOR . basename($nama_file);
    if (is_file($path)) {
        @unlink($path);
    }
}

/** Format tanggal Indonesia: "Senin, 13 April 2026 | 15:17". */
function tanggal_indonesia(): string
{
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April',   5 => 'Mei',      6 => 'Juni',
        7 => 'Juli',    8 => 'Agustus',  9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
    $sekarang   = new DateTime();
    $nama_hari  = $hari[(int) $sekarang->format('w')];
    $tanggal    = $sekarang->format('j');
    $nama_bulan = $bulan[(int) $sekarang->format('n')];
    $tahun      = $sekarang->format('Y');
    $jam        = $sekarang->format('H:i');

    return "$nama_hari, $tanggal $nama_bulan $tahun | $jam";
}

// Path absolut folder upload (dipakai endpoint).
const DIR_UPLOAD_PENULIS = __DIR__ . DIRECTORY_SEPARATOR . 'uploads_penulis';
const DIR_UPLOAD_ARTIKEL = __DIR__ . DIRECTORY_SEPARATOR . 'uploads_artikel';
