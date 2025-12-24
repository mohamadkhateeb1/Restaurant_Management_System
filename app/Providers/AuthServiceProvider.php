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

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $policies = [// ربط النماذج بالسياسات الخاصة بها
        Employee::class => EmployeePolicy::class, // نموذج الموظف وسياسة الموظف
        Role::class => RolePolicy::class,// نموذج الدور وسياسة الدور
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
