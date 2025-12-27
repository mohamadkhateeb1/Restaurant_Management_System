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
        'item_type',     // نوع المادة: 'raw_material' أو 'menu_item'
        'category_id',   // لربط المادة بالقسم التنظيمي
        'name',          
        'sku',           
        'quantity',      
        'unit',          
        'min_quantity',  
        'cost_per_unit', 
        'supplier',       
        'image',       
    ];

    /**
     * العلاقة مع حركة المخزن (التوريد والصرف)
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * العلاقة مع القسم: العقل المدبر الذي يحدد نطاق عمل المادة
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoriesRestaurant::class, 'category_id');
    }

    /**
     * العلاقة مع سجل المنيو: الربط العكسي لضمان تحديث بيانات الطبق آلياً
     */
    public function item(): HasOne
    {
        // الربط يتم عبر inventory_id الموجود في جدول الأصناف
        return $this->hasOne(ItemsRestaurant::class, 'inventory_id'); 
    }

    // --- وظائف مساعدة (Helpers) لتبسيط العمل في الكنترولر والواجهات ---

    /**
     * هل هذه المادة مخصصة للبيع؟
     */
    public function isMenuItem(): bool
    {
        return $this->item_type === 'menu_item';
    }

    /**
     * فحص حالة المخزون
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_quantity;
    }

    /**
     * جلب سعر البيع المرتبط بالطبق (في حال كانت المادة Menu Item)
     */
    public function getSalesPriceAttribute()
    {
        return $this->item ? $this->item->price : 0;
    }
}