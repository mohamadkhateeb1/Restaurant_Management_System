<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // افترض أن:
        // - user_id 1 (المدير) هو من قام بإدخال الطلبات
        // - table_id 1 و 2 موجودة

        // 1. طلبات تناول الطعام داخل المطعم (dine_in_order_restaurants)
        DB::table('dine_in_order_restaurants')->insert([
            [
                'user_id' => 1,
                'table_id' => 1,
                'order_number' => 'DIN-001',
                'status' => 'paid',
                'total_amount' => 150.50, // ❌ استخدام الاسم الأصلي لديك
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'table_id' => 2,
                'order_number' => 'DIN-002',
                'status' => 'pending',
                'total_amount' => 85.00, // ❌ استخدام الاسم الأصلي لديك
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2. الطلبات الخارجية (take_aways_restaurants)
        DB::table('take_aways_restaurants')->insert([
            [
                'user_id' => 1,
                'order_number' => 'TAK-001',
                'customer_name' => 'خالد العلي',
                'customer_phone' => '0567891234',
                'status' => 'ready',
                'total_amount' => 70.00, // ❌ استخدام الاسم الأصلي لديك
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'order_number' => 'TAK-002',
                'customer_name' => 'نور سامي',
                'customer_phone' => '0567894321',
                'status' => 'pending',
                'total_amount' => 110.25, // ❌ استخدام الاسم الأصلي لديك
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        // 3. تفاصيل الطلبات (order_items_restaurants)
        // يجب أن نستخدم الأعمدة الأصلية لديك: price (بدلاً من subtotal)
        
        DB::table('order_items_restaurants')->insert([
            // تفاصيل الطلب الداخلي الأول (DIN-001)
            [
                'dine_in_order_id' => 1,
                'take_away_order_id' => null,
                'item_id' => 1, // افترض وجود item_id 1
                'quantity' => 2,
                'price' => 75.25, // سعر الوحدة x الكمية سيكون 150.50
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // تفاصيل الطلب الخارجي الأول (TAK-001)
            [
                'dine_in_order_id' => null,
                'take_away_order_id' => 1,
                'item_id' => 2, // افترض وجود item_id 2
                'quantity' => 4,
                'price' => 17.50, // سعر الوحدة x الكمية سيكون 70.00
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}