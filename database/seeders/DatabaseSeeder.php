<?php
namespace Database\Seeders;
use App\Models\Book; use App\Models\Category; use App\Models\User; use Illuminate\Database\Seeder; use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder { public function run(): void {
    $categories=collect([
      ['name'=>'Pemrograman','description'=>'Buku tentang pemrograman dan pengembangan aplikasi.'],
      ['name'=>'Basis Data','description'=>'Buku tentang database, SQL, dan pengelolaan data.'],
      ['name'=>'Sistem Informasi','description'=>'Buku tentang analisis dan pengembangan sistem informasi.'],
    ])->mapWithKeys(fn($c)=>[$c['name']=>Category::create($c)]);
    $books=[
      ['category_id'=>$categories['Pemrograman']->id,'title'=>'Pemrograman Laravel untuk Pemula','author'=>'Andi Pratama','publisher'=>'Informatika','year'=>2025,'stock'=>8],
      ['category_id'=>$categories['Pemrograman']->id,'title'=>'Belajar PHP Modern','author'=>'Dewi Lestari','publisher'=>'Elex Media','year'=>2024,'stock'=>6],
      ['category_id'=>$categories['Basis Data']->id,'title'=>'Database MySQL Praktis','author'=>'Rizky Ramadhan','publisher'=>'Andi Publisher','year'=>2023,'stock'=>5],
      ['category_id'=>$categories['Sistem Informasi']->id,'title'=>'Analisis Sistem Informasi','author'=>'Sinta Maharani','publisher'=>'Graha Ilmu','year'=>2022,'stock'=>4],
      ['category_id'=>$categories['Basis Data']->id,'title'=>'SQL untuk Mahasiswa','author'=>'Fajar Nugraha','publisher'=>'Informatika','year'=>2025,'stock'=>7],
    ]; foreach($books as $b) Book::create($b);
    User::updateOrCreate(['email'=>'admin@perpustakaan.test'],['name'=>'Admin Perpustakaan','password'=>Hash::make('password')]);
} }
