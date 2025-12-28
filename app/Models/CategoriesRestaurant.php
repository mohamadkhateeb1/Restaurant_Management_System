<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class CategoriesRestaurant extends Model
{
    protected $table = 'categories_restaurants';

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'is_menu_category'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ItemsRestaurant::class, 'category_id');
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'category_id');
    }


    public function scopeMenuOnly(Builder $query)
    {
        return $query->where('is_menu_category', true)->where('status', 'active');
    }


    public function scopeInventoryOnly(Builder $query)
    {
        return $query->where('is_menu_category', false);
    }

    public function isSalesType(): bool
    {
        return (bool) $this->is_menu_category;
    }
}
