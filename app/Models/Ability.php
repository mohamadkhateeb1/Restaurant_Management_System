<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    protected $fillable = ['role_id', 'ability', 'type'];
    // ربط القدرة بالدور
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
