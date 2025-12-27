<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\CategoriesRestaurant;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriesRestaurantPolicy
{
    use HandlesAuthorization;

    public function viewAny(Employee $employee)
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