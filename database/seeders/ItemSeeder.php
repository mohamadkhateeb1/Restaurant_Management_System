<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. يجب التأكد من وجود سجلات في جدول 'categories_restaurants'
        // سنفترض وجود فئة بالـ ID = 1 (المقبلات) وفئة ID = 2 (الأطباق الرئيسية)

        DB::table('items_restaurants')->insert([
            [
                'category_id' => 2, // الأطباق الرئيسية
                'item_name' => 'بيتزا مارغريتا', // ❌ استخدام الاسم الأصلي لديك
                'description' => 'عجينة طازجة بصلصة الطماطم والجبنة الموزاريلا.',
                'image' => 'images/pizza_margarita.jpg',
                'price' => 25.50,
                'status' => 'available',
                'prepare_time' => 15, // ❌ استخدام الاسم الأصلي لديك (بالدقائق)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2, // الأطباق الرئيسية
                'item_name' => 'ساندويتش دجاج مشوي',
                'description' => 'صدر دجاج مشوي مع الخضروات وصلصة خاصة.',
                'image' => 'images/chicken_sandwich.jpg',
                'price' => 18.00,
                'status' => 'available',
                'prepare_time' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1, // المقبلات
                'item_name' => 'سلطة السيزر',
                'description' => 'خس، خبز محمص، جبنة بارميزان، وصلصة السيزر.',
                'image' => 'images/caesar_salad.jpg',
                'price' => 12.75,
                'status' => 'available',
                'prepare_time' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1, // المقبلات
                'item_name' => 'بطاطا مقلية',
                'description' => 'بطاطس مقلية مقرمشة.',
                'image' => 'images/french_fries.jpg',
                'price' => 7.00,
                'status' => 'unavailable', // مثال على صنف غير متاح
                'prepare_time' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}