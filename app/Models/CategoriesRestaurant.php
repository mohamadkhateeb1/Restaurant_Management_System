<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesRestaurant extends Model
{
    protected $table = 'categories_restaurants';

    protected $fillable = ['category_name', 'description', 'image', 'status'];

    public function items()
    {
        return $this->hasMany(ItemsRestaurant::class, 'category_id');
    }
}