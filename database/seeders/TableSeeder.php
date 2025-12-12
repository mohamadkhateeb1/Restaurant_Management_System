<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tables_restaurants')->insert([
            [
                'table_number' => 'T01',
                'seating_capacity' => 4, // ❌ استخدام الاسم الأصلي لديك
                'status' => 'occupied',
                'location' => 'Main Dining Area',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'table_number' => 'T02',
                'seating_capacity' => 2,
                'status' => 'available',
                'location' => 'Main Dining Area',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'table_number' => 'T03',
                'seating_capacity' => 6,
                'status' => 'reserved',
                'location' => 'VIP Section',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'table_number' => 'B01',
                'seating_capacity' => 8,
                'status' => 'available',
                'location' => 'Outdoor Terrace',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}