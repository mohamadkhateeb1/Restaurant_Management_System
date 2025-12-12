<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    public $fillable = [
        'user_restaurant_id',
        'name',
        'email',
        'phone',
        'position',
        'salary',
        'hire_date',
    ];
    // تعريف العلاقة مع نموذج UserRestaurant
    public function user(){
        return $this->belongsTo(UserRestaurant::class);//(UserRestaurant) علاقة متعدد إلى واحد مع نموذج 
    }
    
}
