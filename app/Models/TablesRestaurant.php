<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablesRestaurant extends Model
{
    public $fillable = [
        'table_number',
        'seating_capacity',
        'status',
        'location',
    ];
    
    public function dineinorders(){
        return $this->hasMany(DineInOrderRestaurant::class);//(DineInOrdersRestaurant) علاقة واحد إلى متعدد مع نموذج
    }   
}
