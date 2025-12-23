<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model 
{
    // تحديد اسم الجدول يدوياً لأننا صححنا الإملاء
    protected $table = 'inventories'; 

    protected $fillable = [
        'item_name', 'quantity', 'min_quantity', 'unit', 'cost_per_unit', 'supplier_name'
    ];

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'inventory_id');
    }
}