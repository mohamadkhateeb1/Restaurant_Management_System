<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inventory extends Model
{
    protected $table = 'inventories';
    protected $fillable = [
        'item_type',     
        'category_id',   
        'name',          
        'sku',           
        'quantity',      
        'unit',          
        'min_quantity',  
        'cost_per_unit', 
        'supplier',       
        'image',       
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

 
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoriesRestaurant::class, 'category_id');
    }


    public function item(): HasOne
    {
        return $this->hasOne(ItemsRestaurant::class, 'inventory_id'); 
    }

 
    public function isMenuItem(): bool
    {
        return $this->item_type === 'menu_item';
    }


    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_quantity;
    }

    public function getSalesPriceAttribute()
    {
        return $this->item ? $this->item->price : 0;
    }
}