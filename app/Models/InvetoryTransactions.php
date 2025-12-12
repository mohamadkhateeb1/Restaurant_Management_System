<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvetoryTransactions extends Model
{
    public $fillable = [
        'inventory_id',
        'transaction_type',
        'performed_by_user',
        'quantity',
        'notes',
    ];
    public function inventory(){
        return $this->belongsTo(Invetory::class, 'inventory_id');//(Invetory) علاقة متعدد إلى واحد مع نموذج
    }
    public function performedBy(){
        return $this->belongsTo(UserRestaurant::class, 'performed_by_user');//(UserRestaurant) علاقة متعدد إلى واحد مع نموذج
    }   
}
