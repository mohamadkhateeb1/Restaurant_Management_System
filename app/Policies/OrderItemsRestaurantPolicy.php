<?php

namespace App\Policies;

use App\Models\Employee;

class OrderItemsRestaurantPolicy
{
    /**
     * Create a new policy instance.
     */

    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('order_items.view');
    }

    public function view(Employee $employee): bool
    {
        return $employee->hasAbility('order_items.show');
    }

    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('order_items.create');
    }

    public function delete(Employee $employee): bool
    {
        return $employee->hasAbility('order_items.delete');
    }
}
