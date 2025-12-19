<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {
        // الترتيب ضروري جداً لتجنب أخطاء المفاتيح الخارجية
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
