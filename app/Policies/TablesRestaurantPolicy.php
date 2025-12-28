<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class TablesRestaurantPolicy
{

    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('tables.view');
    }

    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('tables.create');
    }

    public function update(Employee $employee): bool
    {
        return $employee->hasAbility('tables.update');
    }

    public function delete(Employee $employee): bool
    {
        return $employee->hasAbility('tables.delete');
    }

    public function view(Employee $employee): bool
    {
        return $employee->hasAbility('tables.show');
    }
}
