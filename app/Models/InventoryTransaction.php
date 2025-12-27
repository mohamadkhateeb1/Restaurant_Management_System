<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    public $timestamps = false; 
    protected $casts = [
    'created_at' => 'datetime', 
];

    protected $fillable = [
        'inventory_id', 
        'type', 
        'quantity', 
        'reference', 
        'notes', 
        'employee_id' 
    ];

    // علاقة الحركة بالمادة الخام
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    // علاقة الحركة بالموظف
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}