<?php

namespace App\Concerns;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
trait HasRoles
{
    // تحقق مما إذا كان الموظف يمتلك دورًا معينًا
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    

    // تحقق مما إذا كان الموظف يمتلك قدرة معينة
    
    public function hasAbility($ability)
    {
        return $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)
                ->where('type', 'allow');
        })->exists();
    }
}
