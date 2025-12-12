<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DineInOrderRestaurant extends Model
{
    public $fillable = [
        'user_id',
        'table_id',
        'order_number',
        'status',
        'total_amount',
    ];
    public function user(){
        return $this->belongsTo(UserRestaurant::class);//(UserRestaurant) علاقة متعدد إلى واحد مع نموذج 
    }
    // تعريف العلاقة مع نموذج TablesRestaurant
    public function table(){
        return $this->belongsTo(TablesRestaurant::class);//(TablesRestaurant) علاقة متعدد إلى واحد مع نموذج 
    }
    public function orderItemsRestaurants(){
        return $this->hasMany(OrderItemsRestaurant::class, 'dine_in_order_id');//(OrderItemsRestaurant) علاقة واحد إلى متعدد مع نموذج
    }
    public function invoices(){
        return $this->hasOne(Invoice::class,'dine_in_order_id');//(InvoiceRestaurant) علاقة واحد إلى واحد مع نموذج
    }
}
