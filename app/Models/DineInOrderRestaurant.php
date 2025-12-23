<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DineInOrderRestaurant extends Model
{
    use HasFactory;

    // تحديد اسم الجدول الصحيح ليتطابق مع قاعدة البيانات
    protected $table = 'dine_in_order_restaurants';

    // تحديث الحقول المسموح بإدخالها جماعياً لتشمل total_amount و employee_id
    protected $fillable = [
        'table_id', 
        'employee_id', 
        'order_number', 
        'status', 
        'total_amount'
    ];

    /**
     * علاقة One-to-Many مع جدول الموظفين (الموظف الذي أنشأ الطلب)
     */
    public function employee()
    {
        // تم استخدام 'employee_id' بدلاً من 'user_id' ليتوافق مع ملف التهجير
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * علاقة One-to-Many مع جدول الطاولات
     */
    public function table()
    {
        // الربط مع موديل TablesRestaurant عبر الحقل table_id [cite: 4]
        return $this->belongsTo(TablesRestaurant::class, 'table_id');
    }

    /**
     * علاقة One-to-Many مع تفاصيل الأصناف (Order Items)
     * تم تسمية العلاقة orderItems لتفادي خطأ RelationNotFoundException
     */
    public function orderItems()
    {
        // الربط مع موديل OrderItemsRestaurant عبر حقل dine_in_order_id [cite: 22, 24]
        return $this->hasMany(OrderItemsRestaurant::class, 'dine_in_order_id');
    }

    /**
     * تابع مساعد لحساب إجمالي الطلب وتحديثه في قاعدة البيانات
     [cite_start]* [cite: 4, 22]
     */
    public function refreshTotalAmount()
    {
       // حساب المجموع من خلال ضرب الكمية بالسعر لكل صنف مرتبط بالطلب [cite: 4, 22]
        $total = $this->orderItems()->sum(DB::raw('quantity * price'));
        
        // تحديث حقل total_amount
        $this->update(['total_amount' => $total]);
        
        return $total;
    }

    /**
     * علاقة One-to-One مع الفواتير (في حال وجود نظام فواتير)
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'dine_in_order_id');
    }
}