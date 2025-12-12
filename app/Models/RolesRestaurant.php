<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolesRestaurant extends Model
{
    public $fillable = ['role_name'];
    // تعريف العلاقة مع نموذج UserRestaurant
    public function users(){
        return $this->belongsToMany(UserRestaurant::class, 'role_user', 'role_id', 'user_id');//(UserRestaurant) علاقة متعدد إلى متعدد مع نموذج 
    }
    public function permissions(){
        return $this->belongsToMany(PremissionRestaurant::class, 'role_permission', 'role_id', 'permission_id');//(PermissionsRestaurant) علاقة متعدد إلى متعدد مع نموذج
    }
}
