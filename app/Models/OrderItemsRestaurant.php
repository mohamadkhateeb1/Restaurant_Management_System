<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemsRestaurant extends Model
{
    protected $table = 'order_items_restaurants';

    protected $fillable = [
        'dine_in_order_id', 'take_away_order_id', 'item_id', 'quantity', 'price'
    ];

    public function item()
    {
        return $this->belongsTo(ItemsRestaurant::class, 'item_id');
    }

    public function dineInOrder()
    {
        return $this->belongsTo(DineInOrderRestaurant::class, 'dine_in_order_id');
    }

    public function takeAwayOrder()
    {
        return $this->belongsTo(TakeAwaysRestaurant::class, 'take_away_order_id');
    }
}