<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(Employee $employee)
    {
        if ($employee->super_admin) {
            return true;
        }
    }

    public function viewAny(Employee $employee)
    {
        return $employee->hasAbility('role.view');
    }

    public function view(Employee $employee, Role $role)
    {
        return $employee->hasAbility('role.show');
    }

    public function create(Employee $employee)
    {
        return $employee->hasAbility('role.create');
    }

    public function update(Employee $employee, Role $role)
    {
        return $employee->hasAbility('role.update');
    }

    public function delete(Employee $employee, Role $role)
    {
        return $employee->hasAbility('role.delete');
    }
}