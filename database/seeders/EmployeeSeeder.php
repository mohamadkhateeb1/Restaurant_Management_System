<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder {
    public function run() {
        Employee::create([
            'name' => 'أحمد المدير',
            'email' => 'admin@restaurant.com',
            'phone' => '0912345678',
            'position' => 'Manager',
            'salary' => 5000,
            'password' => Hash::make('123456'),
            'hire_date' => now(),
            'status' => 'active'
        ]);
    }
}