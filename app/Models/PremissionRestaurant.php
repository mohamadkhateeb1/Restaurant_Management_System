<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremissionRestaurant extends Model
{
    public $fillable = ['permission_name'];
    public function roles(){
        return $this->belongsToMany(RolesRestaurant::class, 'role_permission', 'permission_id', 'role_id');//(RolesRestaurant) علاقة متعدد إلى متعدد مع نموذج 
    }
}
