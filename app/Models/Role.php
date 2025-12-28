<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'roles_employees');
    }
    public function abilities()
    {
        return $this->hasMany(RoleAbilities::class);
    }

    public static function createWithAbilities($request)
    {
        $role = Role::create([
            'name' => $request->name,
        ]);
        foreach ($request->abilities as $ability => $value) {
            RoleAbilities::create([
                'role_id' => $role->id,
                'ability' => $ability,
                'type' => $value
            ]);
        }
        return $role;
    }
    public  function updateWithAbilities($request)
    {
        $this->update([
            'name' => $request->post('name'),
        ]);
        foreach ($request->post('abilities') as $ability => $value) {
            RoleAbilities::updateOrCreate([
                'role_id' => $this->id,
                'ability' => $ability,
            ], [
                'type' => $value,
            ]);
        }
        return $this;
    }
}
