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
        // 1. إذا كان سوبر أدمن، افتح له كل شيء فوراً
        if ($this->super_admin) {
            return true;
        } 
        
        // 2. البحث في قاعدة البيانات عن الصلاحية بشرط أن يكون النوع 'allow'
        // هذا السطر يحل مشكلة ظهور العناصر للموظف العادي
        return $this->roles()->whereHas('abilities', function ($q) use ($ability) {
            $q->where('ability', $ability)
              ->where('type', 'allow');
        })->exists();
    }
}