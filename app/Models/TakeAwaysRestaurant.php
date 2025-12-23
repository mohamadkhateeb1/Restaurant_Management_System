<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeAwaysRestaurant extends Model
{
    use HasFactory;

    // اسم الجدول في قاعدة البيانات
    protected $table = 'take_aways_restaurants';

    // الحقول المسموح بتعبئتها
    protected $fillable = [
        'order_number', 
        'customer_name', 
        'employee_id', 
        'customer_phone', 
        'status', 
        'total_amount'
    ];

    /**
     * علاقة الموظف الذي أنشأ الطلب
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * علاقة الأصناف (الوجبات) الموجودة في هذا الطلب
     * الربط يتم عبر foreign key: take_away_order_id
     */
    public function orderItems()
    {
        // تأكد أن الاسم هنا يطابق العمود الموجود في جدول order_items_restaurants
        return $this->hasMany(OrderItemsRestaurant::class, 'take_away_order_id');
    }

    /**
     * علاقة الفاتورة (في حال تم إصدار فاتورة نهائية)
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'take_away_order_id');
    }
}