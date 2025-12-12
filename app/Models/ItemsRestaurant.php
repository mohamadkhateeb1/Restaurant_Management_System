<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsRestaurant extends Model
{
    public $fillable = [
        'category_id',
        'item_name',
        'description',
        'image',
        'price',
        'status',
        'prepare_time',
    ];
    public function category(){
        return $this->belongsTo(CategoriesRestaurant::class);//(CategoriesRestaurant) علاقة متعدد إلى واحد مع نموذج
    }
    public function orderItemsRestaurants(){
        return $this->hasMany(OrderItemsRestaurant::class);//(OrderItemsRestaurant) علاقة واحد إلى متعدد مع نموذج
    }
}
