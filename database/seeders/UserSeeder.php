<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRestaurant;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
        //حساب ال admin لللمشروع 
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}