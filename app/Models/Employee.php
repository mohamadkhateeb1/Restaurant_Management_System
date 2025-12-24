<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Concerns\HasRoles; 

class Employee extends Authenticatable
{
    use Notifiable, HasFactory, HasRoles;
    // خصائص الموظف القابلة للتعبئة

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

    // تحويل القيم المناسبة

    protected $casts = [
        'super_admin' => 'boolean',
        'hire_date' => 'date',
    ];

    // علاقة الموظف مع الأدوار (الربط الأساسي)

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_employees', 'employee_id', 'role_id');
    }

    // علاقات الموظف مع باقي النماذج

    public function dineInOrders()
    {
        return $this->hasMany(DineInOrderRestaurant::class, 'employee_id');
    }

    // علاقة الموظف مع طلبات التيك أواي

    public function takeAwayOrders()
    {
        return $this->hasMany(TakeAwaysRestaurant::class, 'employee_id');
    }

    // علاقة الموظف مع معاملات المخزون

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'performed_by_user');
    }

    // علاقة الموظف مع الفواتير

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'employee_id');
    }
}
