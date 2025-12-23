<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $table = 'inventory_transactions';

    protected $fillable = [
        'inventory_id', 'transaction_type', 'performed_by_user', 'quantity', 'unit_price', 'notes'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function employee()
    {
        // الموظف الذي قام بالعملية
        return $this->belongsTo(Employee::class, 'performed_by_user');
    }
}