<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories_restaurants')->insert([
            ['category_name' => 'المقبلات', 'description' => 'المقبلات الباردة والساخنة', 'status' => 'active'],
            ['category_name' => 'الأطباق الرئيسية', 'description' => 'الأطباق الرئيسية', 'status' => 'active'],
            ['category_name' => 'المشروبات', 'description' => 'المشروبات', 'status' => 'active'],
        ]);
    }
}