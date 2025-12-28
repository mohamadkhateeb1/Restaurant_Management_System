<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class DashboardPolicy
{
    /**
     * Create a new policy instance.
     */
   public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('dashboard.view');
    }
}
