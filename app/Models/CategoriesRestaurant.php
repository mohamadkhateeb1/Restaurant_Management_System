<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesRestaurant extends Model
{
    protected $table = 'categories_restaurants';

    protected $fillable = ['name', 'description', 'image', 'status', 'price'];

    public function items()
    {
        return $this->hasMany(ItemsRestaurant::class, 'category_id');
    }
}