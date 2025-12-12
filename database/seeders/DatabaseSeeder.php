<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\TableSeeder;
use Database\Seeders\ItemSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\InventorySeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\InvoiceSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. الجداول الرئيسية أولاً (إنشاء السجلات الأساسية)
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,

            // ✅ تفعيل Seeders أساسية لقائمة الطعام
            CategorySeeder::class,
            ItemSeeder::class,
            // ✅ تفعيل Seeders أساسية للتشغيل
            TableSeeder::class,
            InventorySeeder::class, // ✅ يجب أن يكون جدول المخزون موجوداً قبل transactions
            EmployeeSeeder::class,
        ]);

        // 2. جداول الربط والعلاقات ثانياً (الربط بين السجلات)
        $this->call([
            RoleUserSeeder::class,
            RolePermissionSeeder::class,
            OrderSeeder::class,
            InvoiceSeeder::class,
        ]);
    }
}
