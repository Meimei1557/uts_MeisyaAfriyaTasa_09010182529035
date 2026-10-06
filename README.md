# UTS Pemrograman Web III — BukuKu

Aplikasi perpustakaan sederhana berbasis Laravel untuk UTS Universitas Sriwijaya.

## Fitur utama
- Login/logout dan proteksi halaman dengan authentication middleware
- Dashboard statistik: total buku, stok, kategori, dan stok menipis
- CRUD buku lengkap: tambah, daftar, detail, edit, hapus
- Relationship Category hasMany Book dan Book belongsTo Category
- Migration + Seeder (3 kategori dan 5 buku)
- Pencarian berdasarkan judul/penulis
- Filter kategori dan filter stok menipis
- Pengurutan berdasarkan terbaru, judul, stok terendah, dan tahun
- Export koleksi ke CSV
- Tombol cetak pada detail buku
- Tampilan responsive dengan kartu statistik, badge stok, cover inisial, empty state, dan navigasi aktif

## Instalasi Windows + XAMPP
1. Pastikan PHP 8.2+, Composer, MySQL/XAMPP, dan Git terpasang.
2. Buat database MySQL `uts_buku`.
3. `composer install`
4. `copy .env.example .env`
5. `php artisan key:generate`
6. Atur DB_* pada `.env` jika berbeda.
7. `php artisan migrate:fresh --seed`
8. `php artisan serve`
9. Buka `http://127.0.0.1:8000`

Jika muncul error `public does not exist`, source ZIP ini sudah menyediakan folder `public` beserta `index.php` dan `.htaccess`.

## Login demo
Email: `admin@perpustakaan.test`
Password: `password`

## Git
Repository disiapkan dengan commit minimal sesuai soal. Setelah modifikasi UI/fitur, buat commit tambahan, misalnya:
`git add .`
`git commit -m "Enhance dashboard UI and add book export"`
