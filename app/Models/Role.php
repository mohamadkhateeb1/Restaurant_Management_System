<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($request) {
            $role = self::create(['name' => $request['name']]);
            foreach (config('abilities') as $ability => $label) {
                // استخدام اسم الـ ability كمفتاح لجلب القيمة من الفورم
                $value = $request['abilities'][$ability] ?? 'inherit';
                RoleAbilities::create([
                    'role_id' => $role->id,
                    'ability' => $ability,
                    'type'    => $value
                ]);
            }
            return $role;
        });
    }

    public function updateWithAbilities($request)
    {
        return DB::transaction(function () use ($request) {
            $this->update(['name' => $request['name']]);
            foreach (config('abilities') as $ability => $label) {
                $value = $request['abilities'][$ability] ?? 'inherit';
                RoleAbilities::updateOrCreate(
                    ['role_id' => $this->id, 'ability' => $ability],
                    ['type' => $value]
                );
            }
            return $this;
        });
    }
}
