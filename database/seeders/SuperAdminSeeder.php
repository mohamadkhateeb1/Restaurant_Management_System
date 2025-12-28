<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
 
    public function run(): void
    {
        Employee::create([
                'email' => 'admin@admin.com',
                'name'         => 'Super Admin',
                'phone'        => '0000000000',
                'super_admin'  => true, 
                'position'     => 'Owner',
                'salary'       => 0,
                'password'     => Hash::make('12345678'), 
                'hire_date'    => now(),
                'status'       => 'active',
                'notes'        => 'Main System Administrator',
            ]
        );

        $this->command->info('Super Admin created successfully!');
    }
}