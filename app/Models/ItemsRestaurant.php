<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemsRestaurant extends Model
{
    protected $table = 'items_restaurants';

    protected $fillable = [
        'category_id',
        'inventory_id', 
        'item_name',    
        'description',
        'image',
        'price',        
        'status',
        'prepare_time',
        'quantity',     
        'unit',         
        'min_quantity'  
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoriesRestaurant::class, 'category_id');
    }

   
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItemsRestaurant::class, 'item_id');
    }


    public function isAvailableToOrder(): bool
    {
        return $this->status === 'available' &&
               optional($this->inventory)->quantity > 0 &&
               optional($this->category)->status === 'active';
    }


public function getCurrentQuantityAttribute()
{
    return $this->inventory ? $this->inventory->quantity : 0;
}
}