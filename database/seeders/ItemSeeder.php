<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\ItemsRestaurant;

class ItemSeeder extends Seeder {
    public function run() {
        ItemsRestaurant::create([
            'category_id' => 1, // وجبات غربية
            'item_name' => 'برغر دجاج',
            'price' => 15.50,
            'status' => 'available'
        ]);
    }
}