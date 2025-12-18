<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\TablesRestaurant;

class TableSeeder extends Seeder {
    public function run() {
        TablesRestaurant::create(['table_number' => 'T1', 'seating_capacity' => 4, 'status' => 'available']);
        TablesRestaurant::create(['table_number' => 'T2', 'seating_capacity' => 2, 'status' => 'available']);
    }
}
