<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

  protected $fillable = [
    'invoice_number', 'dine_in_order_id', 'employee_id', 
    'takeaway_order_id', 'amount_paid', 'payment_status'
];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function dineInOrder()
    {
        return $this->belongsTo(DineInOrderRestaurant::class, 'dine_in_order_id');
    }

    public function takeAwayOrder()
    {
        return $this->belongsTo(TakeAwaysRestaurant::class, 'takeaway_order_id');
    }

    public function getRelatedOrderAttribute()
    {
        return $this->dineInOrder ?? $this->takeAwayOrder;
    }
}