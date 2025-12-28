<?php

namespace App\Concerns;

trait HasRoles
{
    /**
     * التحقق من دور الموظف
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * التحقق من صلاحية الموظف بناءً على الأدوار
     * تعتمد على الحقل super_admin أو وجود الصلاحية بنوع allow
     */
    public function hasAbility($ability)
    {
        if ($this->super_admin) {
            return true;
        }

        // البحث في الأدوار عن صلاحية محددة نوعها allow
        return $this->roles()->whereHas('abilities', function ($q) use ($ability) {
            $q->where('ability', $ability)
              ->where('type', 'allow');
        })->exists();
    }
}