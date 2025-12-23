<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemsRestaurant extends Model
{
    protected $table = 'order_items_restaurants';


    protected $fillable = [
        'dine_in_order_id',
        'take_away_order_id',
        'item_id',
        'quantity',
        'price'
    ];

    // تابع للتحقق من نوع الطلب
    public function isDineIn()
    {
        return !is_null($this->dine_in_order_id);
    }

    public function isTakeaway()
    {
        return !is_null($this->takeaway_order_id);
    }

    // العلاقات
    public function item()
    {
        return $this->belongsTo(ItemsRestaurant::class, 'item_id');
    }

    public function dineInOrder()
    {
        return $this->belongsTo(DineInOrderRestaurant::class, 'dine_in_order_id');
    }

    public function takeawayOrder()
    {
        return $this->belongsTo(TakeAwaysRestaurant::class, 'takeaway_order_id');
    }
}
