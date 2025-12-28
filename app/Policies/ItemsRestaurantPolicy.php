<?php

namespace App\Policies;

use App\Models\Employee;

class ItemsRestaurantPolicy
{
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('items.view');
    }
    public function view(Employee $employee): bool
    {
        return $employee->hasAbility('items.show');
    }
    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('items.create');
    }
    public function update(Employee $employee): bool
    {
        return $employee->hasAbility('items.update');
    }
    public function delete(Employee $employee): bool
    {
        return $employee->hasAbility('items.delete');
    }
}
