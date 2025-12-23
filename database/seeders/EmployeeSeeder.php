<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use App\Models\RoleAbility; // تأكد من اسم الموديل عندك (Ability أو RoleAbility)
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء السوبر أدمن (محمد) - سيتخطى كل الفحوصات
        $superAdmin = Employee::create([
            'name' => 'محمد السوبر',
            'email' => 'super@admin.com',
            'phone' => '0900000000',
            'password' => Hash::make('123456'),
            'super_admin' => true, // الحقل الأهم
            'position' => 'Owner',
            'salary' => 5000,
            'hire_date' => now(),
            'status' => 'active',
        ]);

    }
}