<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RolesRestaurant; // نفترض أن هذا هو اسم النموذج لديك
use App\Models\PremissionRestaurant;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. جلب الأدوار
        $managerRole = RolesRestaurant::where('role_name', 'Manager')->first();
        $cashierRole = RolesRestaurant::where('role_name', 'Cashier')->first();
        $chefRole = RolesRestaurant::where('role_name', 'Chef')->first();

        // 2. جلب الصلاحيات
        $permissions = PremissionRestaurant::pluck('id', 'permission_name');

        if ($managerRole && $cashierRole && $chefRole && $permissions->isNotEmpty()) {
            
            // 3. تعريف مصفوفات الصلاحيات لكل دور
            
            // المدير: كل الصلاحيات (كل الـ IDs)
            $managerPermissions = $permissions->values()->toArray(); 

            // الكاشير: صلاحيات الطلبات والفواتير
            $cashierPermissions = [
                $permissions['create_orders'],
                $permissions['update_order_status'],
                $permissions['view_all_orders'],
            ];
            
            // الطاهي: صلاحيات المخزون وتحديث حالة الطلبات
            $chefPermissions = [
                $permissions['view_inventory'],
                $permissions['update_order_status'],
            ];

            // 4. ربط الأدوار بالصلاحيات في الجدول الوسيط
            
            // ربط المدير
            $managerRole->permissions()->attach($managerPermissions);
            
            // ربط الكاشير
            $cashierRole->permissions()->attach($cashierPermissions);
            
            // ربط الطاهي
            $chefRole->permissions()->attach($chefPermissions);
        }
    }
}