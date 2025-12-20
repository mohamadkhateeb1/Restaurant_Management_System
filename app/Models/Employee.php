<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Concems\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Authenticatable
{
    use HasRoles,Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'position', 'salary', 'password', 'status', 'hire_date', 'notes'
    ];
   public function roles(): MorphToMany
    {
        return $this->morphToMany(Role::class, 'authorizable', 'role_user');
    }

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