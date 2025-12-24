<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // علاقة الدور مع الموظفين

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'roles_employees');
    }

    // علاقة الدور مع القدرات

    public function abilities()
    {
        return $this->hasMany(RoleAbilities::class);
    }

    // هذا الميثود لإنشاء دور مع القدرات

    public static function createWithAbilities($request)
    {
        $role = Role::create(['name' => $request['name']]);
        foreach ($request['abilities'] as $ability => $value) {
            RoleAbilities::create([
                'role_id' => $role->id,
                'ability' => $ability,
                'type' => $value
            ]);
        }
        return $role;
    }

    // هذا الميثود لتحديث الدور مع القدرات

    public function updateWithAbilities($request)
    {
        $this->update(['name' => $request['name']]); // تحديث اسم الدور
        foreach ($request['abilities'] as $ability => $value) {
            RoleAbilities::updateOrCreate(
                [
                    'role_id' => $this->id,
                    'ability' => $ability
                ],
                [
                    'type' => $value
                ]
            );
        }
        return $this;
    }
}
