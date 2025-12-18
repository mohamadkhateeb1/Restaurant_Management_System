<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TablesRestaurant extends Model
{
    use HasFactory;

    // تحديد اسم الجدول يدوياً لضمان الربط الصحيح مع Migration
    protected $table = 'tables_restaurants';

    protected $fillable = [
        'table_number',
        'seating_capacity',
        'status',
        'location',
    ];
    
    public function dineInOrders()
    {
        // تم تحديد 'table_id' كمفتاح خارجي لضمان الربط الدقيق
        return $this->hasMany(DineInOrderRestaurant::class, 'table_id');
    }   
}