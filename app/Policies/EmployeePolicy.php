<?php

namespace App\Policies;

use App\Models\Employee;

class EmployeePolicy
{
    /**
     * التحقق للسوبر أدمن قبل أي عملية
     */
    public function before(Employee $user, $ability)
    {
        if ($user->super_admin) {
            return true;
        }
    }

    public function viewAny(Employee $user)
    {
        return $user->hasAbility('employee.view');
    }

    public function view(Employee $user, Employee $employee)
    {
        return $user->hasAbility('employee.show');
    }

    public function create(Employee $user)
    {
        return $user->hasAbility('employee.create');
    }

    public function update(Employee $user, Employee $employee)
    {
        if ($employee->super_admin && !$user->super_admin) {
            return false;
        }
        return $user->hasAbility('employee.update');
    }

    public function delete(Employee $user, Employee $employee)
    {
        if ($user->id === $employee->id || $employee->super_admin) {
            return false;
        }
        return $user->hasAbility('employee.delete');
    }
}
