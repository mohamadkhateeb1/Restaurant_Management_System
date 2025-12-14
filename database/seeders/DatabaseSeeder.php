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
        $this->call([UserSeeder::class]);
    }
}
