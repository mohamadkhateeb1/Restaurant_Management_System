<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Waiter;
use App\Models\Employee;
class WaiterPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('waiter.view');
    }
}
