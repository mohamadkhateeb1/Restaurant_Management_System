<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\CategoriesRestaurant;

class CategoryPolicy
{

    public function before(Employee $employee, $ability)
    {
        if ($employee->super_admin) {
            return true;
        }
    }

    public function viewAny(Employee $employee)
    {
        return $employee->hasAbility('categories.view');
    }

    public function view(Employee $employee, CategoriesRestaurant $category)
    {
        return $employee->hasAbility('categories.view');
    }

    public function create(Employee $employee)
    {
        return $employee->hasAbility('categories.create');
    }

    public function update(Employee $employee, CategoriesRestaurant $category)
    {
        return $employee->hasAbility('categories.update');
    }

    public function delete(Employee $employee, CategoriesRestaurant $category)
    {
        return $employee->hasAbility('categories.delete');
    }
}