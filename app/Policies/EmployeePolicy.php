<?php

namespace App\Policies;

use App\Models\Employee;

class EmployeePolicy
{
      // قبل أي تحقق من القدرة
    public function before($user)
    {
        if ($user->super_admin) {
            return true;
        }
    }

    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('employee.view');
    }


    public function view(Employee $employee, Employee $emp): bool
    {
        return $employee->hasAbility('employees.view');
    }

    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('employee.create');
    }


    public function update(Employee $employee, Employee $emp): bool
    {
        return $employee->hasAbility('employee.edit');
    }

  
    public function delete(Employee $employee, Employee $emp): bool
    {
        return $employee->hasAbility('employee.delete');
    }

    public function restore(Employee $employee, Employee $emp): bool
    {
        return false;
    }

    public function forceDelete(Employee $employee, Employee $emp): bool
    {
        return false;
    }
}
