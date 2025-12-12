<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRestaurant extends Model
{
protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
    ];
        // تعريف العلاقة مع نموذج RolesRestaurant
    public function roles(){
        return $this->belongsToMany(RolesRestaurant::class, 'role_user', 'user_id', 'role_id');//(RolesRestaurant) علاقة متعدد إلى متعدد مع نموذج 
    }
       // تعريف العلاقة مع نموذج DineInOrderRestaurant
    public function dineinorders(){
        return $this->hasMany(DineInOrderRestaurant::class);
    }
    // تعريف العلاقة مع نموذج TakeAwayOrderRestaurant
    public function takeawayorders(){
        return $this->hasMany(TakeAwaysRestaurant::class);//(TakeAwaysRestaurant) علاقة واحد إلى متعدد مع نموذج
    }
    // تعريف العلاقة مع نموذج InvetoryTransactions
    public function inventorytransactions(){
        return $this->hasMany(InvetoryTransactions::class, 'performed_by_user');//(InvetoryTransactions) علاقة واحد إلى متعدد مع نموذج
    }   
    // علاقة مع الموظفين
    public function employees(){
        return $this->hasOne(Employees::class);//(Employee) علاقة واحد إلى واحد مع نموذج
    }
}
