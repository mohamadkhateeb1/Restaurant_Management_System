<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAbilities extends Model
{
    protected $fillable = ['role_id', 'ability', 'type'];
    
}
