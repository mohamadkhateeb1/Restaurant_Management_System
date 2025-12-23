<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Ability;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\HasRoles;
class Role extends Model
{
    use HasRoles;
    protected $fillable = ['name'];
    // ربط بين الدور والموظفين باستخدام علاقة متعددة الأشكال
   public function employees(): MorphToMany
    {
        return $this->morphedByMany(Employee::class, 'authorizable', 'role_user');// 'role_user' هو اسم جدول الربط
    }
    // ريطط بين الدور والقدرات
    public function abilities()
    {
        return $this->hasMany(Ability::class); //(Ability أو RoleAbility) تأكد من اسم الموديل عندك 
    }

    public static function createwithAbilities($request)
    {
        $role = Role::create(['name' => $request->name]);
        foreach ($request->abilities as $ability => $value) {
            $role->abilities()->create([
                'role_id' => $role->id,
                'ability' => $ability,
                'type' => $value,
            ]);
        }
        return $role;
    }
    public  function updateWithAbilities($request)
    {
        $this->update(['name' => $request->name]); // تحديث اسم الدور
        foreach ($request->abilities as $ability => $value) {
            Ability::updateOrCreate(
                [
                    'role_id' => $this->id,
                    'ability' => $ability,
                ],
                [
                    'type' => $value
                ]
            );
        }
        return $this;
    }
}
