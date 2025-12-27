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
        'is_menu_category' // الحقل المفتاحي: 1 للبيع (منيو + مخزن)، 0 للمخزن فقط
    ];

    /**
     * علاقة الأصناف: جلب كافة الأطباق التابعة لهذا القسم
     */
    public function items(): HasMany
    {
        return $this->hasMany(ItemsRestaurant::class, 'category_id');
    }

    /**
     * علاقة المخزن: جلب كافة المواد المخزنية التابعة لهذا القسم
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'category_id');
    }

    // --- وظائف إضافية لتسهيل العمل في الكنترولر والواجهات ---

    /**
     * نطاق (Scope) لجلب الأقسام التي تظهر في المنيو فقط
     */
    public function scopeMenuOnly(Builder $query)
    {
        return $query->where('is_menu_category', true)->where('status', 'active');
    }

    /**
     * نطاق (Scope) لجلب الأقسام الإدارية للمخزن فقط
     */
    public function scopeInventoryOnly(Builder $query)
    {
        return $query->where('is_menu_category', false);
    }

    /**
     * دالة للتحقق: هل هذا القسم مخصص للبيع؟
     */
    public function isSalesType(): bool
    {
        return (bool) $this->is_menu_category;
    }
}