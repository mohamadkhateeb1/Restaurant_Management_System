<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsRestaurant extends Model
{
    protected $table = 'items_restaurants';

    protected $fillable = [
        'category_id', 'item_name', 'description', 'image', 'price', 'status', 'prepare_time'
    ];

    public function category()
    {
        return $this->belongsTo(CategoriesRestaurant::class, 'category_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItemsRestaurant::class, 'item_id');
    }
}