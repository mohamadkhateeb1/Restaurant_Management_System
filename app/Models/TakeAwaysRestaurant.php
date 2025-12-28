<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeAwaysRestaurant extends Model
{
    use HasFactory;

    protected $table = 'take_aways_restaurants';

    protected $fillable = [
        'order_number',
        'customer_name',
        'employee_id',
        'customer_phone',
        'status',
        'total_amount'
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItemsRestaurant::class, 'take_away_order_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'take_away_order_id');
    }
}
