<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Invoice extends Model
{
    public $fillable = [
        'invoice_number',
        'dine_in_order_id',
        'takeaway_order_id',
        'amount_paid',
        'payment_status',
    ];
    public function dineInOrder()
    {
        return $this->belongsTo(DineInOrderRestaurant::class);
    }

    // العلاقة مع الطلب السفري
    public function takeawayOrder()
    {
        return $this->belongsTo(TakeAwaysRestaurant::class);
    }
    
    // العلاقة مع المستخدم (الموظف الذي أصدر الفاتورة)
    public function user()
    {
        return $this->belongsTo(UserRestaurant::class);
    }
    
    // تابع مُساعد لجلب الطلب المرتبط (سواء داخلي أو سفري)
    public function order()
    {
        return $this->dineInOrder ?? $this->takeawayOrder;
    }

}
