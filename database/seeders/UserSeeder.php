<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRestaurant;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. المستخدم الإداري (Super Admin)
        UserRestaurant::create([
            'name' => 'Super Admin',
            'email' => 'admin@app.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'phone' => '0555111222', 
            'status' => 'active', 
        ]);

        UserRestaurant::create([
            'name' => 'Restaurant Manager',
            'role' => 'admin',
            'email' => 'manager@app.com',
            'password' => Hash::make('password'),
            'phone' => '0555333444',
            'status' => 'active',
        ]);
        
        UserRestaurant::create([
            'name' => 'Cashier Fatima',
            'email' => 'cashier@app.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
            'phone' => '0555555666',
            'status' => 'active',
        ]);
        
        // 4. مستخدم الطاهي (Chef) - لربطه بدور الطاهي ومعاملات المخزون
        UserRestaurant::create([
            'name' => 'Chef Khaled',
            'email' => 'chef@app.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
            'phone' => '0555777888',
            'status' => 'active',
        ]);
        
        // 5. مستخدم النادل (Waiter)
        UserRestaurant::create([
            'name' => 'Waiter Ali',
            'role' => 'staff',
            'email' => 'waiter@app.com', // ❌ تصحيح: تغيير الإيميل ليكون فريداً
            'password' => Hash::make('password'),
            'phone' => '0555999000',
            'status' => 'active',
        ]);
    }
}