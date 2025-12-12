<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TakeAwaysRestaurant extends Model
{
    public $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'status',
        'total_amount',
    ];
    public function user(){
        return $this->belongsTo(UserRestaurant::class);//(UserRestaurant) علاقة متعدد إلى واحد مع نموذج 
    }
    public function orderItemsRestaurants(){
        return $this->hasMany(OrderItemsRestaurant::class, 'take_aways_order_id');//(OrderItemsRestaurant) علاقة واحد إلى متعدد مع نموذج
    }
    public function invoices(){
        return $this->hasOne(Invoice::class);//(InvoiceRestaurant) علاقة واحد إلى واحد مع نموذج
    }
}
