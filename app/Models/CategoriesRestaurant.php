<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesRestaurant extends Model
{
    public $fillable = ['category_name', 'description', 'image', 'status'];//الحقول القابلة للتعبئة في النموذج
    public function items(){
        return $this->hasMany(ItemsRestaurant::class);//(ItemsRestaurant) علاقة واحد إلى متعدد مع نموذج
    }
}
