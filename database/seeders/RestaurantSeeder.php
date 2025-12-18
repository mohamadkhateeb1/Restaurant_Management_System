<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\CategoriesRestaurant;
use App\Models\ItemsRestaurant;
use App\Models\TablesRestaurant;
use App\Models\DineInOrderRestaurant;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إضافة موظف
        $emp = Employee::create([
            'name' => 'أحمد المدير',
            'email' => 'admin@test.com',
            'phone' => '0912345678',
            'position' => 'Manager',
            'salary' => 5000,
            'password' => bcrypt('password'),
            'hire_date' => now(),
            'status' => 'active'
        ]);

        // 2. إضافة قسم
        $cat = CategoriesRestaurant::create([
            'category_name' => 'مشويات',
            'status' => 'active'
        ]);

        // 3. إضافة صنف
        $item = ItemsRestaurant::create([
            'category_id' => $cat->id,
            'item_name' => 'كباب حلب',
            'price' => 15.50,
            'status' => 'available'
        ]);

        // 4. إضافة طاولة
        $table = TablesRestaurant::create([
            'table_number' => 'T1',
            'seating_capacity' => 4,
            'status' => 'available'
        ]);

        // 5. إنشاء طلب داخلي
        DineInOrderRestaurant::create([
            'table_id' => $table->id,
            'employee_id' => $emp->id,
            'order_number' => 'ORD-001',
            'status' => 'pending',
            'total_amount' => 15.50
        ]);
    }
}