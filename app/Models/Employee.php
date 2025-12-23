<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Testing\Fluent\Concerns\Has;
use App\Models\Role;
// use App\Concems\HasRoles;
use App\Concerns\HasRoles;
class Employee extends Authenticatable
{
    use Notifiable, HasFactory, HasRoles;
protected $casts = [
    'super_admin' => 'boolean',
];
    protected $fillable = [
        'name', 'email', 'phone', 'position', 'salary', 'password', 'status', 'hire_date', 'notes', 'super_admin'
    ];
//    public function roles(): MorphToMany
//     {
//         return $this->morphToMany(Role::class, 'authorizable', 'role_user');
//     }

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