<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cachier;
use App\Models\Employee;
class CachierPolicy

{
   
  public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('cashier.view');
    }
}
