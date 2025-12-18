<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'position', 'salary', 'password', 'status', 'hire_date', 'notes'
    ];

    public function dineInOrders()
    {
        return $this->hasMany(DineInOrderRestaurant::class, 'employee_id');
    }

    public function takeAwayOrders()
    {
        return $this->hasMany(TakeAwaysRestaurant::class, 'employee_id');
    }

    public function inventoryTransactions()
    {
        // الربط مع حقل الموظف الذي قام بالحركة
        return $this->hasMany(InventoryTransaction::class, 'performed_by_user');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'employee_id');
    }
}