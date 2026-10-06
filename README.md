# UTS Pemrograman Web III — BukuKu
Aplikasi perpustakaan sederhana berbasis Laravel untuk memenuhi studi kasus UTS Universitas Sriwijaya.

## Fitur
- Authentication/login
- Dashboard
- CRUD buku
- Detail buku
- Relasi Category hasMany Book dan Book belongsTo Category
- Migration + Seeder
- Pencarian judul/penulis dan filter kategori (bonus)
- Git minimal 3 commit

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

Login demo: `admin@perpustakaan.test` / `password`.

## Git
Repository sudah disiapkan dengan commit:
- Initial Laravel project
- Add database and book model
- Add book CRUD and authentication
- Add UI, search and documentation
