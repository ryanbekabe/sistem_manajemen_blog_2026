# Rencana Program — Sistem Manajemen Blog (CMS)

## A. Deskripsi Proyek

Buatlah sebuah aplikasi web berbasis **PHP** dengan nama **Sistem Manajemen Blog (CMS)** yang
memungkinkan pengelolaan data **penulis**, **artikel**, dan **kategori artikel** secara lengkap.
Aplikasi dibangun menggunakan **PHP**, **MySQL**, dan **JavaScript** dengan pendekatan
*asynchronous* menggunakan **Fetch API** sehingga seluruh operasi berlangsung **tanpa reload
halaman** (single-page experience).

---

## B. Ketentuan Database

Gunakan database dengan nama **`db_blog`** yang terdiri dari **tiga tabel**. Jalankan perintah SQL
berikut melalui **tab SQL pada phpMyAdmin** untuk membuat database dan seluruh tabel yang diperlukan.

```sql
-- Membuat database
CREATE DATABASE IF NOT EXISTS db_blog
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Menggunakan database
USE db_blog;

-- Membuat tabel penulis
CREATE TABLE penulis (
    id            INT          NOT NULL AUTO_INCREMENT,
    nama_depan    VARCHAR(100) NOT NULL,
    nama_belakang VARCHAR(100) NOT NULL,
    user_name     VARCHAR(50)  NOT NULL,
    password      VARCHAR(255) NOT NULL,
    foto          VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_user_name (user_name)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Membuat tabel kategori_artikel
CREATE TABLE kategori_artikel (
    id            INT          NOT NULL AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    keterangan    TEXT,
    PRIMARY KEY (id),
    UNIQUE KEY uq_nama_kategori (nama_kategori)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Membuat tabel artikel
CREATE TABLE artikel (
    id            INT          NOT NULL AUTO_INCREMENT,
    id_penulis    INT          NOT NULL,
    id_kategori   INT          NOT NULL,
    judul         VARCHAR(255) NOT NULL,
    isi           TEXT         NOT NULL,
    gambar        VARCHAR(255) NOT NULL,
    hari_tanggal  VARCHAR(50)  NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_artikel_penulis
        FOREIGN KEY (id_penulis)
        REFERENCES penulis (id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_artikel_kategori
        FOREIGN KEY (id_kategori)
        REFERENCES kategori_artikel (id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## C. Ketentuan Aplikasi

### 1. Tampilan (GUI)

Aplikasi terdiri dari satu halaman utama (**`index.php`**) dengan tata letak sebagai berikut:

- **a. Bagian atas (header)** — menampilkan nama aplikasi.
- **b. Bagian kiri (navigasi)** — berisi tiga menu: **Kelola Penulis**, **Kelola Artikel**, dan
  **Kelola Kategori Artikel**.
- **c. Bagian kanan (konten)** — menampilkan data sesuai menu yang dipilih.

### 2. Fitur yang Harus Diimplementasikan

Setiap menu navigasi harus memiliki fitur **CRUD (Create, Read, Update, Delete)** yang berjalan
secara **asynchronous** menggunakan **Fetch API**. Berikut ketentuan untuk masing-masing menu.

#### a. Kelola Penulis

1. Menampilkan data penulis dalam format **tabel** yang memuat kolom **foto, nama, username,
   password, dan aksi**.
2. Tombol **Tambah Penulis** membuka **modal form** untuk menambah data baru.
3. Kolom **foto** menampilkan foto profil penulis. Jika penulis tidak mengunggah foto, tampilkan
   gambar siluet default (**`default.png`**) yang disimpan di folder **`uploads_penulis/`**.
4. **Password** dienkripsi menggunakan fungsi **`password_hash()`** dengan algoritma
   **`PASSWORD_BCRYPT`** sebelum disimpan ke database.
5. Tombol **Edit** membuka modal form yang **terisi otomatis** dengan data terbaru dari database.
6. Tombol **Hapus** menampilkan **konfirmasi** sebelum data dihapus. Jika penulis **masih memiliki
   artikel**, data **tidak dapat dihapus** (sesuai `ON DELETE RESTRICT`).

#### b. Kelola Artikel

1. Menampilkan data artikel dalam format **tabel** yang memuat kolom **gambar, judul, kategori,
   penulis, tanggal, dan aksi**.
2. Tombol **Tambah Artikel** membuka **modal form** untuk menambah data baru.
3. Kolom **`hari_tanggal`** diisi **otomatis dari server** menggunakan PHP dengan format
   **"Senin, 13 April 2026 | 15:17"** dan timezone **`Asia/Jakarta`**. Berikut potongan fungsi
   yang dapat digunakan:

```php
date_default_timezone_set('Asia/Jakarta');
$hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',
    4=>'April',   5=>'Mei',      6=>'Juni',
    7=>'Juli',    8=>'Agustus',  9=>'September',
    10=>'Oktober',11=>'November',12=>'Desember'
];
$sekarang    = new DateTime();
$nama_hari   = $hari[$sekarang->format('w')];
$tanggal     = $sekarang->format('j');
$nama_bulan  = $bulan[(int)$sekarang->format('n')];
$tahun       = $sekarang->format('Y');
$jam         = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";
```

4. **Upload gambar** artikel **wajib** dilakukan. Gambar disimpan di folder **`uploads_artikel/`**.
5. **Dropdown Penulis** diisi dari data tabel **`penulis`** di database.
6. **Dropdown Kategori** diisi dari data tabel **`kategori_artikel`** di database.
7. Tombol **Edit** membuka modal form yang **terisi otomatis** dengan data terbaru dari database.
8. Tombol **Hapus** menampilkan **konfirmasi** sebelum data dihapus. **File gambar ikut dihapus**
   dari server ketika data artikel dihapus.

#### c. Kelola Kategori Artikel

1. Menampilkan data kategori dalam format **tabel** yang memuat kolom **nama kategori, keterangan,
   dan aksi**.
2. Tombol **Tambah Kategori** membuka **modal form** untuk menambah data baru.
3. Tombol **Edit** membuka modal form yang **terisi otomatis** dengan data terbaru dari database.
4. Tombol **Hapus** menampilkan **konfirmasi** sebelum data dihapus. Jika kategori **masih memiliki
   artikel**, data **tidak dapat dihapus** (sesuai `ON DELETE RESTRICT`).

### 3. Validasi dan Keamanan

1. Seluruh operasi database menggunakan **prepared statements** dengan **`mysqli`**.
2. Validasi **tipe file** menggunakan fungsi **`finfo`**, **bukan** dari `$_FILES['foto']['type']`.
3. Ukuran file **maksimal 2 MB**.
4. **Sanitasi output** menggunakan **`htmlspecialchars()`**.
5. Folder **`uploads_penulis/`** dan **`uploads_artikel/`** dilindungi menggunakan file
   **`.htaccess`** untuk mencegah eksekusi file PHP.

---

## D. Struktur Folder Proyek

Seluruh file disimpan dalam folder **`blog/`** dengan struktur sebagai berikut.

```
blog/
├── index.php
├── koneksi.php
│
├── ambil_penulis.php
├── simpan_penulis.php
├── ambil_satu_penulis.php
├── update_penulis.php
├── hapus_penulis.php
│
├── ambil_kategori.php
├── simpan_kategori.php
├── ambil_satu_kategori.php
├── update_kategori.php
├── hapus_kategori.php
│
├── ambil_artikel.php
├── simpan_artikel.php
├── ambil_satu_artikel.php
├── update_artikel.php
├── hapus_artikel.php
│
├── uploads_penulis/
│   ├── .htaccess
│   └── default.png
│
└── uploads_artikel/
    └── .htaccess
```
