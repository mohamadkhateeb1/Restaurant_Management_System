<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Role;
use App\Models\Task;
use App\Policies\AttendancePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\LeaveRequestPolicy;
use App\Policies\LeaveTypePolicy;
use App\Policies\RolePolicy;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\In;
use App\Models\Inventory;
use App\Policies\InventoryPolicy;
use App\Models\Cachier;
use App\Policies\CachierPolicy;
class AuthServiceProvider extends ServiceProvider
{
    

    protected $policies = [// ربط النماذج بالسياسات الخاصة بها
        Employee::class => EmployeePolicy::class, // نموذج الموظف وسياسة الموظف
        Role::class => RolePolicy::class,// نموذج الدور وسياسة الدور
        Inventory::class => InventoryPolicy::class, // نموذج الجرد وسياسة الجرد
        Cachier::class => CachierPolicy::class, // نموذج الكاشير وسياسة الكاشير
        
    ];
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

     
        foreach (config('abilities') as $code => $label) {
            Gate::define($code, function ($user) use ($code) {
                return $user->hasAbility($code);
            });
        }
    }
}
