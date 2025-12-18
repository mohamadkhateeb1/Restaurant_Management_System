<?php

namespace App\Concems;

use App\Models\Role;

trait HasRoles
{
    public function roles()
    { // تعريف علاقة متعدد الأشكال بين المستخدمين والأدوار
        return $this->morphToMany(Role::class, 'authorizable', 'role_user');
    }
    public function hasAbility($ability)
    { // فحص ما إذا كان للمستخدم دور يمنحه صلاحية معينة
        return $this->roles()->whereHas('abilities', function ($query) use ($ability) {
            $query->where('ability', $ability)->where('type', 'allow');
        })->exists();
    }
}
