<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DineInOrderRestaurant extends Model
{
    protected $table = 'dine_in_order_restaurants';

    protected $fillable = [
        'table_id', 'employee_id', 'order_number', 'status', 'total_amount'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function table()
    {
        return $this->belongsTo(TablesRestaurant::class, 'table_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItemsRestaurant::class, 'dine_in_order_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'dine_in_order_id');
    }
}