<?php

namespace App\Concems;

use App\Models\Role;

trait HasRoles
{
     public function roles()
    {
        return $this->morphToMany(Role::class, 'authorizable', 'role_user'); // هون بدي احدد انو اليوزر عندو عدة رولات
    }
    public function hasAbility($ability)
    { // فحص ما إذا كان للمستخدم دور يمنحه صلاحية معينة
        return $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)->where('type', 'allow');
        })->exists();
    }
}
