<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RolesRestaurant;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ❌ تصحيح: إضافة guard_name
        RolesRestaurant::create([
            'role_name' => 'Admin',
        ]);
        RolesRestaurant::create([
            'role_name' => 'Manager', // ✅ إضافة دور المدير
        ]);
        RolesRestaurant::create([
            'role_name' => 'Cashier', // ✅ إضافة دور الكاشير
        ]);
        RolesRestaurant::create([
            'role_name' => 'Waiter',
        ]);
        RolesRestaurant::create([
            'role_name' => 'Chef',
        ]);
    }
}