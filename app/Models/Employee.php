<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Concerns\HasRoles;

class Employee extends Authenticatable
{
    protected $table = 'employees'; 
    use Notifiable, HasFactory, HasRoles;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'salary',
        'password',
        'status',
        'hire_date',
        'notes',
        'super_admin'
    ];
    protected $casts = [
        'super_admin' => 'boolean',
        'hire_date' => 'date',
    ];
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_employees', 'employee_id', 'role_id');
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
        return $this->hasMany(InventoryTransaction::class, 'performed_by_user');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'employee_id');
    }
}
