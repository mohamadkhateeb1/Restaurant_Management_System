<?php

namespace App\Concerns;

trait HasRoles
{
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
    public function hasAbility($ability)
    {
        if ($this->super_admin) {
            return true;
        }
        return $this->roles()->whereHas('abilities', function ($q) use ($ability) {
            $q->where('ability', $ability)
                ->where('type', 'allow');
        })->exists();
    }
}
