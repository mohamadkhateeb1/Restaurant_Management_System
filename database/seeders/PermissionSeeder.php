<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('premission_restaurants')->insert([
            [
                'permission_name' => 'view_users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'create_users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'delete_users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // صلاحيات إدارة الطلبات
            [
                'permission_name' => 'create_orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'update_order_status',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'view_all_orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // صلاحيات إدارة قائمة الطعام
            [
                'permission_name' => 'manage_menu_items',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // صلاحيات إدارة المخزون
            [
                'permission_name' => 'view_inventory',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'permission_name' => 'record_inventory_transactions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}