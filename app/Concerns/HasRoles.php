<?php

namespace App\Concerns;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
trait HasRoles
{
     public function roles()
    {
        return $this->morphToMany(Role::class, 'authorizable', 'role_user'); // هون بدي احدد انو اليوزر عندو عدة رولات
    } 
    
   
    public function hasAbility($ability)
{
    // 1. إذا كان المستخدم super_admin، امنحه الصلاحية فوراً
    if ($this->super_admin) {
        return true;
    }

    // 2. البحث في الصلاحيات المرتبطة بجميع أدوار المستخدم
    return $this->roles()->whereHas('abilities', function ($query) use ($ability) {
        $query->where('ability', $ability)
              ->where('type', 'allow');
    })->exists();
}
}
