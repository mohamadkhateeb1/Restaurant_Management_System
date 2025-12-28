<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TablesRestaurant extends Model
{
    use HasFactory;

    protected $table = 'tables_restaurants';

    protected $fillable = [
        'table_number',
        'seating_capacity',
        'status',
        'location',
    ];
    
    public function dineInOrders()
    {
        return $this->hasMany(DineInOrderRestaurant::class, 'table_id');
    }   
}