<?php

namespace App\Policies;

use App\Models\Employee;

class EmployeePolicy
{
    public function before(Employee $employee)
    {
        if ($employee->super_admin) {
            return true;
        }
    }

    public function viewAny(Employee $employee)
    {
        return $employee->hasAbility('employee.view');
    }

    public function view(Employee $employee)
    {
        return $employee->hasAbility('employee.show');
    }

    public function create(Employee $employee)
    {
        return $employee->hasAbility('employee.create');
    }

    public function update(Employee  $employee)
    {
        return $employee->hasAbility('employee.update');
    }

    public function delete(Employee  $employee)
    {
        return $employee->hasAbility('employee.delete');
    }
}
