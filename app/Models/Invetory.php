<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invetory extends Model 
{
    protected $table = 'inventories'; 

    public $fillable = [
        'item_name',
        'quantity',
        'min_quantity',
        'unit',
        'cost_per_unit',
        'supplier_name', 
    ];
    
    // ❌ تصحيح: تغيير اسم التابع وتصحيح اسم النموذج المرجعي
    public function transactions(): HasMany
    {
        return $this->hasMany(InvetoryTransactions::class); 
    }
}