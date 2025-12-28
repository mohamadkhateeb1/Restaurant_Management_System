<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class KitchenPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('kitchen.view');
    }
}
