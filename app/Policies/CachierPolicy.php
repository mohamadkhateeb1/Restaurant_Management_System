<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cachier;
use App\Models\Employee;
class CachierPolicy

{
    /**
     * Create a new policy instance.
     */
  public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('cashier.view');
    }
}
