<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRestaurant;
use App\Models\RolesRestaurant;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. جلب المستخدمين (من UserSeeder)
        $managerUser = UserRestaurant::where('email', 'mohammad.ahmad@restaurant.com')->first();
        $cashierUser = UserRestaurant::where('email', 'fatima.zahra@restaurant.com')->first();
        $chefUser = UserRestaurant::where('email', 'ali.khaled@restaurant.com')->first();
        $adminUser = UserRestaurant::where('email', 'admin@app.com')->first();
        $waiterUser = UserRestaurant::where('email', 'ali@app.com')->first();

        // 2. جلب الأدوار (من RoleSeeder)
        $adminRole = RolesRestaurant::where('role_name', 'Admin')->first();
        $managerRole = RolesRestaurant::where('role_name', 'Manager')->first();
        $cashierRole = RolesRestaurant::where('role_name', 'Cashier')->first();
        $chefRole = RolesRestaurant::where('role_name', 'Chef')->first();
        $waiterRole = RolesRestaurant::where('role_name', 'Waiter')->first();

        // 3. تنفيذ الربط (M:M)
        
        // ربط المدير العام بالدور الإداري
        if ($adminUser && $adminRole) {
            $adminUser->roles()->sync([$adminRole->id]); 
        }

        // ربط مشرف المطعم بدور المدير
        if ($managerUser && $managerRole) {
            $managerUser->roles()->sync([$managerRole->id]); 
        }

        // ربط الكاشير
        if ($cashierUser && $cashierRole) {
            $cashierUser->roles()->sync([$cashierRole->id]); 
        }
        
        // ربط الطاهي
        if ($chefUser && $chefRole) {
            $chefUser->roles()->sync([$chefRole->id]); 
        }
        
        // ربط النادل
        if ($waiterUser && $waiterRole) {
            $waiterUser->roles()->sync([$waiterRole->id]);
        }
    }
}