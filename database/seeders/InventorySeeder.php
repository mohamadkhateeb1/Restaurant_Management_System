<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invetories')->insert([
            [

                'item_name' => 'طحين أبيض',
                'quantity' => 150.00,
                'min_quantity' => 50.00,
                'unit' => 'kg',
                'cost_per_unit' => 0.50,
                'supplier_name' => 'المورد الرئيسي للأغذية', // ❌ استخدام الاسم الأصلي لديك
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ... (بقية السجلات)
        ]);
    }
}