# UTS Pemrograman Web III - BukuKu

Aplikasi ini merupakan sistem manajemen perpustakaan sederhana yang dibuat menggunakan Laravel.

## Teknologi
- Laravel
- PHP
- MySQL
- Blade
- Eloquent ORM
- Bootstrap/CSS

## Fitur
- Login dan logout
- Dashboard
- Daftar buku
- Tambah buku
- Edit buku
- Hapus buku
- Detail buku
- Pencarian buku
- Filter kategori
- Export data buku

## Akun Login
Email: admin@perpustakaan.test
Password: password

## Cara Menjalankan
```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve