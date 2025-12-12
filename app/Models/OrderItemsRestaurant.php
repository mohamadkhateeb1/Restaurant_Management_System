<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemsRestaurant extends Model
{
    public $fillable = [
        'dine_in_order_id',
        'take_away_order_id',
        'item_id',
        'quantity',
        'price',
    ];
        // تعريف العلاقة مع نموذج ItemsRestaurant
    public function item(){
        return $this->belongsTo(ItemsRestaurant::class);//(ItemsRestaurant) علاقة متعدد إلى واحد مع نموذج 
    }   
        // تعريف العلاقة مع نموذج DineInOrderRestaurant
    public function dineinorder(){
        return $this->belongsTo(DineInOrderRestaurant::class);//(DineInOrderRestaurant) علاقة متعدد إلى واحد مع نموذج 
    }
    // تعريف العلاقة مع نموذج TakeAwaysRestaurant
    public function takeaway(){
        return $this->belongsTo(TakeAwaysRestaurant::class);//(TakeAwaysRestaurant) علاقة متعدد إلى واحد مع نموذج 
    }
}
