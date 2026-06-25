## Deskripsi Studi Kasus

Sistem Manajemen Blog (CMS) yang telah dibangun pada Modul 10 sudah memiliki fitur
pengelolaan konten secara lengkap, yaitu pengelolaan artikel, penulis, dan kategori artikel
melalui antarmuka yang hanya dapat diakses oleh penulis yang sudah login. Namun hingga
saat ini, konten yang dikelola melalui CMS tersebut belum dapat dikunjungi oleh pengunjung
umum karena belum tersedia halaman publik yang menampilkan artikel kepada pembaca.

Proyek kali ini, proyek aplikasi-blog yang telah dibangun pada Modul 10 dikembangkan lebih
lanjut dengan menambahkan dua halaman pengunjung yang dapat diakses oleh siapa saja tanpa
perlu login. Halaman pengunjung dibangun menggunakan framework Laravel dengan
memanfaatkan database db_blog dan data yang sudah dikelola melalui CMS.

Halaman pertama adalah halaman utama yang menampilkan lima artikel terbaru beserta
widget kategori artikel di bagian samping. Pengunjung dapat menyaring artikel berdasarkan
kategori dengan mengklik salah satu item kategori di widget tersebut.
Halaman kedua adalah halaman detail artikel
yang menampilkan isi lengkap artikel yang dipilih beserta lima artikel terkait dari kategori yang
sama di bagian samping.

Tampilan halaman pengunjung dirancang dengan tema yang bersih, sederhana, dan elegan
diperbolehkan menggunakan CSS atau framework Bootstrap. Diharapkan tampilan tema
konsisten dengan tema pada CMS di Modul sebelumnya.

## Ketentuan Teknis

### 1. Prasyarat

Proyek aplikasi-blog dari Modul sebelumnya.
harus sudah selesai dikerjakan dan berfungsi dengan benar
sebelum memulai pengerjaan proyek Laravel ini.
Database db_blog beserta seluruh tabelnya harus sudah
tersedia dan terisi dengan data yang cukup untuk mendemonstrasikan seluruh fitur halaman
pengunjung.

### 2. Proyek Laravel

Halaman pengunjung dibangun di dalam proyek aplikasi-blog yang sama dengan Modul sebelumnya.
Tidak diperkenankan membuat proyek Laravel baru.

### 3. Database

Database yang digunakan adalah db_blog dengan struktur tabel yang sama dengan Modul sebelumnya, yaitu tabel penulis, kategori_artikel, dan artikel. Tidak diperkenankan mengubah
struktur tabel yang sudah ada.

### 4. Framework dan Tampilan

Halaman pengunjung dibangun menggunakan framework Laravel dengan tampilan
diperbolahkan menggunakan CSS atau framework Bootstrap.

### 5. Akses Halaman

Halaman pengunjung dapat diakses oleh siapa saja tanpa perlu login. Route halaman
pengunjung tidak dilindungi oleh middleware auth.

### 6. Arsitektur

Halaman pengunjung diimplementasikan menggunakan arsitektur MVC Laravel dengan
ketentuan sebagai berikut:
- Controller halaman pengunjung dibuat terpisah dari Controller CMS yang sudah ada
- Seluruh Route halaman pengunjung didefinisikan di file routes/web.php
- Tampilan menggunakan Blade template engine dengan layout tersendiri yang terpisah dari
layout CMS
