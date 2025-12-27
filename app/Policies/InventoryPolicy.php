<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
class InventoryPolicy
{
 
        public function before($user)
    {
        if ($user->super_admin) {
            return true;
        }
    }
    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('inventory.view');
    }
    public function view(Employee $employee): bool
    {
        return $employee->hasAbility('inventory.show');
    }
    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('inventory.create');
    }
    public function update(Employee $employee): bool
    {
        return $employee->hasAbility('inventory.update');
    }
    public function delete(Employee $employee): bool
    {
        return $employee->hasAbility('inventory.delete');
    }
    public function restore(Employee $employee): bool
    {
        return false;
    }
    public function forceDelete(Employee $employee): bool
    {
        return false;
    }   
}
