# Sistem Manajemen Blog 2026

Aplikasi blog yang terdiri dari dua bagian yang berbagi satu basis data MySQL (`db_blog`):

1. **Panel CMS (`blog/`)** — aplikasi PHP murni (vanilla, mysqli + *prepared statements*) untuk
   mengelola data blog: **Artikel**, **Kategori**, dan **Penulis** (operasi CRUD lengkap dengan
   unggah gambar). Antarmuka admin berada di `blog/index.php` dan berkomunikasi dengan sekumpulan
   *endpoint* PHP yang mengembalikan respons JSON.
2. **Halaman Pengunjung (`aplikasi-blog/`)** — aplikasi **Laravel 10** yang menampilkan daftar
   artikel dan halaman detail untuk pembaca, membaca dari basis data yang sama (`db_blog`).
   Gambar artikel diambil dari folder unggahan CMS (`blog/uploads_artikel/`).

Demo: https://ablogsonofjhonsyarif.kotapalangkaraya.my.id/

---

## Persyaratan

- **PHP 8.1+** (Laravel 10 membutuhkan PHP ≥ 8.1; CMS PHP juga berjalan di versi ini)
- **MySQL 8.0+**
- **Composer**
- Disarankan menggunakan **Laragon** (lingkungan yang dipakai saat pengembangan)

> Catatan Laragon: pada lingkungan pengembangan, PHP di PATH menunjuk ke versi lama.
> Gunakan PHP 8.1.10 milik Laragon secara eksplisit bila perlu:
> `D:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe`

---

## Langkah Menjalankan Secara Lokal

### 1. Siapkan basis data

1. Jalankan MySQL (mis. lewat Laragon).
2. Buat basis data bernama `db_blog`.
3. Impor skema dan data awal dari berkas `blog/db_blog.sql`:

   ```bash
   mysql -u root -p db_blog < blog/db_blog.sql
   ```

4. Sesuaikan kredensial koneksi bila berbeda dari bawaan:
   - CMS PHP: ubah konstanta `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` di `blog/koneksi.php`.
   - Laravel: ubah `DB_*` di `aplikasi-blog/.env`.

### 2. Jalankan Panel CMS (`blog/`)

Letakkan proyek di dalam *document root* server web (mis. `www` pada Laragon), lalu akses melalui
browser:

```
http://localhost/sistem_manajemen_blog/blog/
```

Atau jalankan dengan server bawaan PHP dari folder `blog/`:

```bash
php -S localhost:8080
```

lalu buka http://localhost:8080/.

### 3. Jalankan Halaman Pengunjung (Laravel — `aplikasi-blog/`)

```bash
cd aplikasi-blog

# Pasang dependensi
composer install

# Siapkan berkas environment & application key
cp .env.example .env      # bila .env belum ada
php artisan key:generate

# Jalankan server pengembangan
php artisan serve
```

Aplikasi pengunjung akan tersedia di http://127.0.0.1:8000.

> Di Laragon, jika `php` di PATH bukan 8.1+, panggil binernya secara eksplisit:
> `& "D:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe" artisan serve`

---

Server powered by: [kotapalangkaraya.my.id](https://kotapalangkaraya.my.id/) - [hanyajasa.com](https://hanyajasa.com/)

Email: hanyajasa@gmail.com
