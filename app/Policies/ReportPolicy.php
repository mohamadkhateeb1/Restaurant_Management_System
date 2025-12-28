<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;

class ReportPolicy
{

    public function viewAny(Employee $employee): bool
    {
        return $employee->hasAbility('reports.view');
    }

    public function view(Employee $employee): bool
    {
        return $employee->hasAbility('reports.show');
    }

    public function create(Employee $employee): bool
    {
        return $employee->hasAbility('reports.create');
    }

    public function delete(Employee $employee): bool
    {
        return $employee->hasAbility('reports.delete');
    }
}
