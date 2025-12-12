<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // استخدام DB::table لضمان التنفيذ
        DB::table('employees')->insert([
            [
                'user_restaurant_id' => 1, // ربط بأول مستخدم (عادة المدير)
                'name' => 'محمد الأحمد',
                'email' => 'mohammad.ahmad@restaurant.com',
                'phone' => '0501234567',
                'position' => 'Manager',
                'salary' => 7500.00,
                'hire_date' => Carbon::parse('2022-01-15'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_restaurant_id' => 2, // ربط بثاني مستخدم (عادة المحاسب/المشرف)
                'name' => 'فاطمة الزهراء',
                'email' => 'fatima.zahra@restaurant.com',
                'phone' => '0509876543',
                'position' => 'Cashier',
                'salary' => 4000.00,
                'hire_date' => Carbon::parse('2023-05-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_restaurant_id' => 3, // ربط بثالث مستخدم (عادة الطاهي)
                'name' => 'علي الخالد',
                'email' => 'ali.khaled@restaurant.com',
                'phone' => '0505551112',
                'position' => 'Chef',
                'salary' => 6000.00,
                'hire_date' => Carbon::parse('2023-10-20'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_restaurant_id' => null, // موظف غير مرتبط بحساب دخول
                'name' => 'سارة الياسين',
                'email' => 'sara.yasin@restaurant.com',
                'phone' => '0503334445',
                'position' => 'Waiter',
                'salary' => 3500.00,
                'hire_date' => Carbon::parse('2024-03-10'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}