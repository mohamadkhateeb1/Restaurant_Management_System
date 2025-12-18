<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TakeAwaysRestaurant extends Model
{
    protected $table = 'take_aways_restaurants';

    protected $fillable = [
        'order_number', 'customer_name', 'employee_id', 'customer_phone', 'status', 'total_amount'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function orderItems()
    {
        // تأكدنا من حذف حرف الـ 's' الزائد ليطابق جدول الربط
        return $this->hasMany(OrderItemsRestaurant::class, 'take_away_order_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'takeaway_order_id');
    }
}