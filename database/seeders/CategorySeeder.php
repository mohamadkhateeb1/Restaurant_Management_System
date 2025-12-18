<?php

namespace Database\Seeders;

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\CategoriesRestaurant;

class CategorySeeder extends Seeder {
    public function run() {
        CategoriesRestaurant::create(['category_name' => 'وجبات غربية', 'status' => 'active']);
        CategoriesRestaurant::create(['category_name' => 'مشروبات', 'status' => 'active']);
    }
}